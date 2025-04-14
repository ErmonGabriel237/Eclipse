<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in and has admin privileges
if ($_SESSION['userType'] !== 'admin') {
    header('HTTP/1.1 401 Unauthorized');
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit;
}

// Verify CSRF token
// $headers = getallheaders();
// if (!isset($headers['X-Csrf-Token']) || $headers['X-Csrf-Token'] !== $_SESSION['csrf_token']) {
//     header('HTTP/1.1 403 Forbidden');
//     echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF token']);
//     exit;
// }

// Check if this is an AJAX request
// if (!isset($headers['X-Requested-With']) || $headers['X-Requested-With'] !== 'XMLHttpRequest') {
//     header('HTTP/1.1 403 Forbidden');
//     echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
//     exit;
// Set proper content type
header('Content-Type: application/json');

// Get user ID from POST data
$user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;

if ($user_id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid user ID']);
    exit;
}

// Include database configuration
define('AUTHORIZED_ACCESS', true);
$db_config = require_once '../config.php';

try {
    // Create database connection
    $dsn = "mysql:host={$db_config['host']};dbname={$db_config['dbname']};charset={$db_config['charset']}";
    $pdo = new PDO($dsn, $db_config['username'], $db_config['password'], $db_config['options']);
    
    // Prepare and execute query to get user data
    $stmt = $pdo->prepare("
        SELECT u.*, (SELECT COUNT(*) FROM user WHERE userId = u.userId) AS login_count FROM user u WHERE u.userId = ?
               ");
            //    (SELECT ip_address FROM user_logins WHERE user_id = u.id ORDER BY login_time DESC LIMIT 1) AS last_ip
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
        exit;
    }
    
    // Sanitize and return user data
    unset($user['password']); // Never send password hash
    
    echo json_encode([
        'status' => 'success',
        'user' => $user
    ]);
    
} catch (PDOException $e) {
    // Log the error server-side
    error_log("Database error in get_user_profile.php: " . $e->getMessage());
    
    // Return error message to client
    echo json_encode([
        'status' => 'error',
        'message' => 'A database error occurred'
    ]);
}
// } catch (Exception $e) {
//     // Log the error server side
//     error_log("General error in getUser.php: " . $e->getMessage());
//     // Return error message to client
//     echo json_encode([
//         'status' => 'error',
//         'message' => 'An unexpected error occurred'
//     ])
// }