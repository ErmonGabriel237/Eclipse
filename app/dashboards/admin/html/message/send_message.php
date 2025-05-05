<?php
session_start();
define('AUTHORIZED_ACCESS', true);
$config = require_once '../../../../../server/config.php';

// if ($_SERVER['REQUEST_METHOD'] !== 'POST' || 
//     !isset($_POST['csrf_token']) || 
//     $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
//     http_response_code(403);
//     exit('Invalid request');
// }

try {
    $pdo = new PDO(
        "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}", 
        $config['username'], 
        $config['password'], 
        $config['options']
    );
    
    $stmt = $pdo->prepare("
        INSERT INTO messages (sender_id, recipient_id, message_text) 
        VALUES (?, ?, ?)
    ");
    
    $stmt->execute([
        $_SESSION['user_id'],
        $_POST['recipient_id'],
        $_POST['message']
    ]);
    
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error sending message']);
}