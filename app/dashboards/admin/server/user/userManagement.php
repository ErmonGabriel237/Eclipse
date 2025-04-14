<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
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

// Set proper content type
header('Content-Type: application/json');

// Include database configuration
define('AUTHORIZED_ACCESS', true);
$db_config = require_once '../config.php';

try {
    // Create database connection
    $dsn = "mysql:host={$db_config['host']};dbname={$db_config['dbname']};charset={$db_config['charset']}";
    $pdo = new PDO($dsn, $db_config['username'], $db_config['password'], $db_config['options']);
    
    // Get request parameters
    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $search = isset($_POST['search']) ? trim($_POST['search']) : '';
    $role = isset($_POST['role']) ? trim($_POST['role']) : '';
    $status = isset($_POST['status']) ? trim($_POST['status']) : '';
    
    // Set items per page and calculate offset
    $itemsPerPage = 10;
    $offset = ($page - 1) * $itemsPerPage;
    
    // Build the SQL query and parameters
    $params = [];
    $sql = "SELECT userId, username, email, userType, status, avatar FROM user WHERE 1=1 AND userID != 1";
    
    // Add search condition if provided
    if (!empty($search)) {
        $sql .= " AND (username LIKE ? OR email LIKE ?)";
        $searchParam = "%{$search}%";
        $params[] = $searchParam;
        $params[] = $searchParam;
    }
    
    // Add role filter if provided
    if (!empty($role)) {
        $sql .= " AND userType = ?";
        $params[] = $role;
    }
    
    // Add status filter if provided
    if ($status !== '') {
        $sql .= " AND status = ?";
        $params[] = $status;
    }
    
    // Count total records for pagination
    $countStmt = $pdo->prepare("SELECT COUNT(*) FROM ({$sql}) as counted");
    $countStmt->execute($params);
    $totalItems = $countStmt->fetchColumn();
    $totalPages = ceil($totalItems / $itemsPerPage);
    
    // Add pagination
    $sql .= " ORDER BY userId ASC LIMIT ? OFFSET ?";
    $params[] = $itemsPerPage;
    $params[] = $offset;
    
    // Execute query
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Return the results
    echo json_encode([
        'status' => 'success',
        'users' => $users,
        'totalItems' => $totalItems,
        'totalPages' => $totalPages,
        'currentPage' => $page
    ]);
    
} catch (PDOException $e) {
    // Log the error server-side
    error_log("Database error in get_users.php: " . $e->getMessage());
    
    // Return error message to client
    echo json_encode([
        'status' => 'error',
        'message' => 'A database error occurred'
    ]);
}