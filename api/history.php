<?php
header('Content-Type: application/json');

$config = require __DIR__ . '/../backend/config.php';
require_once __DIR__ . '/../backend/database.php';

try {
    $db = new Database($config['database']);
    $messages = $db->getMessages();
    echo json_encode(['messages' => $messages]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
