<?php
header('Content-Type: application/json');

$config = require __DIR__ . '/../backend/config.php';
require_once __DIR__ . '/../backend/database.php';

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

try {
    $db = new Database($config['database_path']);

    if ($method === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
        $subject = trim($input['subject'] ?? '');
        $description = trim($input['description'] ?? '');
        $priority = $input['priority'] ?? 'normal';

        if ($subject === '' || $description === '') {
            http_response_code(400);
            echo json_encode(['error' => 'Subject and description are required.']);
            exit;
        }

        $ticket = $db->createTicket($subject, $description, $priority);
        echo json_encode(['ticket' => $ticket]);
        exit;
    }

    if ($method === 'GET') {
        $tickets = $db->getTickets();
        echo json_encode(['tickets' => $tickets]);
        exit;
    }

    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed.']);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
