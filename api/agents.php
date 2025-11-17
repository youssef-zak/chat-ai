<?php
header('Content-Type: application/json');

$config = require __DIR__ . '/../backend/config.php';

$agents = $config['support_agents'] ?? [];

echo json_encode(['agents' => $agents]);
