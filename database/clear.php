<?php
$config = require __DIR__ . '/../backend/config.php';
require_once __DIR__ . '/../backend/database.php';

$db = new Database($config['database_path']);
$db->clearMessages();
$db->clearTickets();

echo 'Database cleared';
