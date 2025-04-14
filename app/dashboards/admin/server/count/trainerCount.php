<?php
// Enable error reporting during development
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// Start session if not already started
// Check if a session has not already been started to avoid session conflicts
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set proper content type
header('Content-Type: application/json');

// Verify user is authenticated
if (!isset($_SESSION['user_id']) || !isset($_SESSION['userType'])) {
    // Return unauthorized status code
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized access']);
    exit;
}

// Check if user has permission to view user count
if ($_SESSION['userType'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Access denied: Admin privileges required']);
    exit;
}

// Set proper content type (moved to the top after session check)

// Prevent caching of this response
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

try {
    $config_path = '../config.php';
    if (!file_exists($config_path)) {
        http_response_code(500);
        echo json_encode(['error' => 'Configuration file not found']);
        exit;
    }
    // $db_config = require_once $config_path;
    $db_config = require_once $config_path;
    
    // Use PDO for database connection
    $pdo = new PDO(
        "mysql:host={$db_config['host']};dbname={$db_config['dbname']};charset=utf8mb4",
        $db_config['username'],
        $db_config['password'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
    
    // Prepare and execute query
    // Ensure the userType column is indexed for better performance
    // Note: Index creation should be handled during database setup or migration
    // $pdo->exec("CREATE INDEX IF NOT EXISTS idx_user_userType ON user(userType)");
    
    // Count all non-admin users in the database
    $stmt = $pdo->prepare("SELECT COUNT(*) as trainer FROM user WHERE userType = 'trainer'");
    $stmt->execute();
    $result = $stmt->fetch();
    
    if ($result !== false && isset($result['trainer'])) {
        echo json_encode(['count' => $result['trainer']]);
    } else {
        echo json_encode(['count' => 0]);
    }
    
    
    // echo json_encode(['count' => $result['trainer']]);
    
} catch (PDOException $e) {
    // Log the error server-side
    error_log("Database error: " . $e->getMessage() . " | Query: SELECT COUNT(*) as trainer FROM user WHERE userType != 'admin'");
    
    // Return generic error to trainer
    http_response_code(500);
    echo json_encode(['error' => 'Database error occurred']);
}