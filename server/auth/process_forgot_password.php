<?php
if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

// require_once '../config.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email address format');
    }

    // $pdo = new PDO(
    //     "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}", 
    //     $config['username'], 
    //     $config['password'], 
    //     $config['options']
    // );

    $pdo = new mysqli('localhost', 'root', '', 'elearning');

    // Check if email exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        // For security, we don't want to reveal if the email exists or not
        echo json_encode([
            'success' => true,
            'message' => 'If your email is registered, you will receive password reset instructions.'
        ]);
        exit;
    }

    // Generate unique token
    // $token = bin2hex(random_bytes(32));
    $token = 1234; // For testing purposes, use a fixed token
    $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

    // Store reset token in database
    $stmt = $pdo->prepare("
        INSERT INTO password_resets (user_id, token, expires_at) 
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE token = VALUES(token), expires_at = VALUES(expires_at)
    ");
    $stmt->execute([$user['id'], $token, $expires]);

    // Create reset link
    $resetLink = "http://{$_SERVER['HTTP_HOST']}/Eclipse/app/logs/resetPassword.php?token=" . $token;

    // header('Location: ../../app/logs/resetPassword.php?token=' . $token);
    
    echo json_encode([
        'success' => true,
        'token' => $token,
    ]);
        
    exit;
    // // Send email with reset link
    // $to = $email;
    // $subject = "Password Reset Request";
    // $message = "
    // <html>
    // <head>
    //     <title>Password Reset Request</title>
    // </head>
    // <body>
    //     <h2>Password Reset Request</h2>
    //     <p>You recently requested to reset your password. Click the link below to reset it:</p>
    //     <p><a href='{$resetLink}'>{$resetLink}</a></p>
    //     <p>This link will expire in 1 hour.</p>
    //     <p>If you didn't request this, please ignore this email.</p>
    // </body>
    // </html>
    // ";

    // $headers = "MIME-Version: 1.0" . "\r\n";
    // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    // $headers .= "From: noreply@yourdomain.com" . "\r\n";

    // if(mail($to, $subject, $message, $headers)) {
    //     echo json_encode([
    //         'success' => true,
    //         'message' => 'Password reset instructions have been sent to your email.'
    //     ]);
    // } else {
    //     throw new Exception('Failed to send email');
    // }

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred. Please try again later.'
    ]);
}