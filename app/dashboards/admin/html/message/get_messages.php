<?php
session_start();
define('AUTHORIZED_ACCESS', true);
$config = require_once '../../../../../server/config.php';

try {
    $pdo = new PDO(
        "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}", 
        $config['username'], 
        $config['password'], 
        $config['options']
    );
    
    $userId = $_GET['user_id'] ?? 0;
    
    $stmt = $pdo->prepare("
        SELECT m.*, 
               u_sender.first_name as sender_name,
               u_sender.profile_picture as sender_picture
        FROM messages m
        JOIN users u_sender ON m.sender_id = u_sender.id
        WHERE (sender_id = ? AND recipient_id = ? AND deleted_by_sender = 0)
           OR (sender_id = ? AND recipient_id = ? AND deleted_by_recipient = 0)
        ORDER BY sent_at ASC
    ");
    
    $stmt->execute([$_SESSION['user_id'], $userId, $userId, $_SESSION['user_id']]);
    
    echo "<div data-user-id='$userId'>";
    while ($message = $stmt->fetch()) {
        $isOwn = $message['sender_id'] == $_SESSION['user_id'];
        $alignClass = $isOwn ? 'justify-content-end' : 'justify-content-start';
        $bgClass = $isOwn ? 'bg-primary text-white' : 'bg-light';
        
        echo "<div class='d-flex $alignClass mb-3'>
                <div class='p-3 rounded $bgClass' style='max-width: 70%'>
                    <div class='small mb-1'>{$message['sender_name']}</div>
                    {$message['message_text']}
                    <div class='small text-" . ($isOwn ? 'light' : 'muted') . " mt-1'>
                        " . date('M j, Y g:i A', strtotime($message['sent_at'])) . "
                    </div>
                </div>
              </div>";
    }
    echo "</div>";
} catch (PDOException $e) {
    error_log($e->getMessage());
    echo "Error loading messages";
}