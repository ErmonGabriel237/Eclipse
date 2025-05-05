<?php
session_start();
header('Content-Type: application/json');

require_once '../config.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['token']) || !isset($data['password'])) {
        throw new Exception('Invalid request');
    }

    $token = $data['token'];
    $password = $data['password'];

    // Validate password strength
    if (strlen($password) < 8) {
        throw new Exception('Password must be at least 8 characters long');
    }

    $pdo = new PDO(
        "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}", 
        $config['username'], 
        $config['password'], 
        $config['options']
    );

    // Get reset token info
    $stmt = $pdo->prepare("
        SELECT pr.user_id, pr.expires_at 
        FROM password_resets pr
        WHERE pr.token = ? 
        AND pr.expires_at > NOW()
        AND pr.used = 0
    ");
    $stmt->execute([$token]);
    $resetInfo = $stmt->fetch();

    if (!$resetInfo) {
        throw new Exception('Invalid or expired reset token');
    }

    // Begin transaction
    $pdo->beginTransaction();

    try {
        // Update password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
        $stmt->execute([$passwordHash, $resetInfo['user_id']]);

        // Mark token as used
        $stmt = $pdo->prepare("UPDATE password_resets SET used = 1 WHERE token = ?");
        $stmt->execute([$token]);

        $pdo->commit();

        echo json_encode([
            'success' => true,
            'message' => 'Password successfully reset'
        ]);
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}