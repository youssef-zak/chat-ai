<?php
/**
 * Simple PDO wrapper for interacting with the SQLite database.
 */
class Database
{
    private \PDO $pdo;

    public function __construct(string $path)
    {
        $this->pdo = new \PDO('sqlite:' . $path);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->initialize();
    }

    private function initialize(): void
    {
        $this->pdo->exec(
            'CREATE TABLE IF NOT EXISTS messages (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                role TEXT NOT NULL,
                content TEXT NOT NULL,
                agent TEXT,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )'
        );

        // Ensure the agent column exists for older databases.
        $columns = $this->pdo->query('PRAGMA table_info(messages)')->fetchAll(\PDO::FETCH_ASSOC);
        $hasAgentColumn = array_reduce($columns, static function ($carry, $column) {
            return $carry || $column['name'] === 'agent';
        }, false);
        if (!$hasAgentColumn) {
            $this->pdo->exec('ALTER TABLE messages ADD COLUMN agent TEXT');
        }

        $this->pdo->exec(
            'CREATE TABLE IF NOT EXISTS tickets (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                subject TEXT NOT NULL,
                description TEXT NOT NULL,
                priority TEXT NOT NULL DEFAULT "normal",
                status TEXT NOT NULL DEFAULT "open",
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )'
        );
    }

    public function insertMessage(string $role, string $content, ?string $agent = null): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO messages (role, content, agent) VALUES (:role, :content, :agent)');
        $stmt->execute([
            ':role' => $role,
            ':content' => $content,
            ':agent' => $agent,
        ]);
    }

    /**
     * @return array<int, array{role: string, content: string, created_at: string, agent: ?string}>
     */
    public function getMessages(int $limit = 20): array
    {
        $stmt = $this->pdo->prepare('SELECT role, content, agent, created_at FROM messages ORDER BY id DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
        return array_reverse($rows);
    }

    public function clearMessages(): void
    {
        $this->pdo->exec('DELETE FROM messages');
    }

    /**
     * @return array{id: int, subject: string, description: string, priority: string, status: string, created_at: string}
     */
    public function createTicket(string $subject, string $description, string $priority = 'normal'): array
    {
        $stmt = $this->pdo->prepare('INSERT INTO tickets (subject, description, priority) VALUES (:subject, :description, :priority)');
        $stmt->execute([
            ':subject' => $subject,
            ':description' => $description,
            ':priority' => $priority,
        ]);

        $id = (int) $this->pdo->lastInsertId();
        return $this->getTicketById($id);
    }

    /**
     * @return array{id: int, subject: string, description: string, priority: string, status: string, created_at: string}
     */
    public function getTicketById(int $id): array
    {
        $stmt = $this->pdo->prepare('SELECT id, subject, description, priority, status, created_at FROM tickets WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $ticket = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$ticket) {
            throw new RuntimeException('Ticket not found.');
        }

        return $ticket;
    }

    /**
     * @return array<int, array{id: int, subject: string, description: string, priority: string, status: string, created_at: string}>
     */
    public function getTickets(int $limit = 10): array
    {
        $stmt = $this->pdo->prepare('SELECT id, subject, description, priority, status, created_at FROM tickets ORDER BY id DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * Returns aggregated statistics for the dashboard widgets.
     *
     * @return array{message_count: int, open_tickets: int, resolved_tickets: int, last_ticket_at: ?string}
     */
    public function getDashboardStats(): array
    {
        $messageCount = (int) $this->pdo->query('SELECT COUNT(*) FROM messages')->fetchColumn();
        $openTickets = (int) $this->pdo->query("SELECT COUNT(*) FROM tickets WHERE status = 'open'")->fetchColumn();
        $resolvedTickets = (int) $this->pdo->query("SELECT COUNT(*) FROM tickets WHERE status != 'open'")->fetchColumn();
        $lastTicket = $this->pdo->query('SELECT created_at FROM tickets ORDER BY id DESC LIMIT 1')->fetchColumn();

        return [
            'message_count' => $messageCount,
            'open_tickets' => $openTickets,
            'resolved_tickets' => $resolvedTickets,
            'last_ticket_at' => $lastTicket ?: null,
        ];
    }

    public function clearTickets(): void
    {
        $this->pdo->exec('DELETE FROM tickets');
    }
}
