<?php
header('Content-Type: application/json');

$config = require __DIR__ . '/../backend/config.php';
require_once __DIR__ . '/../backend/database.php';

try {
    $input = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
    $message = trim($input['message'] ?? '');
    $agentId = $input['agent'] ?? ($config['support_agents'][0]['id'] ?? null);

    if ($message === '') {
        http_response_code(400);
        echo json_encode(['error' => 'Message cannot be empty.']);
        exit;
    }

    if (!$agentId) {
        throw new RuntimeException('No support agent configured.');
    }

    $agent = null;
    foreach ($config['support_agents'] as $candidate) {
        if ($candidate['id'] === $agentId) {
            $agent = $candidate;
            break;
        }
    }

    if (!$agent) {
        http_response_code(400);
        echo json_encode(['error' => 'Agent not found.']);
        exit;
    }

    $db = new Database($config['database']);
    $db->insertMessage('user', $message, $agentId);

    $payload = [
        'system_instruction' => [
            'role' => 'system',
            'parts' => [[ 'text' => $agent['prompt'] ]],
        ],
        'contents' => [[
            'role' => 'user',
            'parts' => [[ 'text' => $message ]],
        ]],
    ];

    $ch = curl_init();
    $url = sprintf('%s?key=%s', $config['gemini_endpoint'], urlencode($config['gemini_api_key']));
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
    ]);

    $response = curl_exec($ch);
    $error = curl_error($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);

    if ($error) {
        throw new RuntimeException('Request error: ' . $error);
    }

    $responseData = json_decode($response, true);

    if ($statusCode >= 400 || !isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
        throw new RuntimeException('Gemini API error: ' . ($responseData['error']['message'] ?? 'Unknown error.'));
    }

    $reply = $responseData['candidates'][0]['content']['parts'][0]['text'];
    $db->insertMessage('assistant', $reply, $agentId);

    echo json_encode([
        'reply' => $reply,
        'agent' => $agentId,
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
