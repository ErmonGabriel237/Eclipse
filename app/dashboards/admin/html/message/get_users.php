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
    
    // Get all users except current user
    $stmt = $pdo->prepare("
        SELECT id, first_name, last_name, profile_picture, status 
        FROM users 
        WHERE id != ? AND status = 'active'
        ORDER BY first_name, last_name
    ");
    $stmt->execute([$_SESSION['user_id']]);
    
    while ($user = $stmt->fetch()) {
        echo "<a href='javascript:void(0)' onclick='loadChat({$user['id']}, \"{$user['first_name']} {$user['last_name']}\")' 
                 class='list-group-item list-group-item-action'>
                <div class='d-flex align-items-center'>
                    <img src='" . ($user['profile_picture'] ?: '../../assets/images/profile/user-1.jpg') . "' 
                         class='user-avatar me-3'>
                    <div>
                        <h6 class='mb-0'>{$user['first_name']} {$user['last_name']}</h6>
                        <small class='text-muted'>{$user['status']}</small>
                    </div>
                </div>
              </a>";
    }
} catch (PDOException $e) {
    error_log($e->getMessage());
    echo "Error loading users";
}