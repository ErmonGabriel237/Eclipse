<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in and has admin privileges
if (!isset($_SESSION['user_id']) || $_SESSION['userType'] !== 'admin') {
    header('Location: ../authentication-login.php');
    exit;
}

// Generate CSRF token if not exists
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Check if user ID is provided in the URL
$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($user_id <= 0) {
    header('Location: ../account.php');
    exit;
}

// Load user data if form is not submitted
$userData = null;
$errorMessage = null;
$successMessage = null;

// Include database configuration
define('AUTHORIZED_ACCESS', true);
$db_config = require_once 'config.php';

try {
    // Create database connection
    $dsn = "mysql:host={$db_config['host']};dbname={$db_config['dbname']};charset={$db_config['charset']}";
    $pdo = new PDO($dsn, $db_config['username'], $db_config['password'], $db_config['options']);
    
    // Process form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verify CSRF token
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $errorMessage = 'Invalid security token. Please try again.';
        } else {
            // Validate inputs
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $role = trim($_POST['role'] ?? '');
            $active = isset($_POST['active']) ? 1 : 0;
            $notes = trim($_POST['notes'] ?? '');
            
            if (empty($name) || empty($email) || empty($role)) {
                $errorMessage = 'Name, email and role are required fields.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorMessage = 'Please enter a valid email address.';
            } else {
                // Check if email is already taken by another user
                $checkStmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
                $checkStmt->execute([$email, $user_id]);
                if ($checkStmt->fetchColumn()) {
                    $errorMessage = 'Email address is already in use by another user.';
                } else {
                    // Update user data
                    $updateStmt = $pdo->prepare("
                        UPDATE users 
                        SET name = ?, email = ?, role = ?, active = ?, notes = ?
                        WHERE id = ?
                    ");
                    $updateStmt->execute([$name, $email, $role, $active, $notes, $user_id]);
                    
                    $successMessage = 'User information has been updated successfully.';
                    
                    // Reload user data
                    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
                    $stmt->execute([$user_id]);
                    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
                }
            }
        }
    } else {
        // Load user data
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$userData) {
            header('Location: users.php');
            exit;
        }
    }
} catch (PDOException $e) {
    $errorMessage = 'A database error occurred. Please try again later.';
    error_log("Database error in edit_user.php: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <meta name="csrf-token" content="<?php echo $_SESSION['csrf_token']; ?>">
    <style>
        .form-section {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .section-title {
            border-bottom: 2px solid #f1f1f1;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .required-field::after {
            content: "*";
            color: red;
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Navigation breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="users.php">Users</a></li>
                <li class="breadcrumb-item"><a href="view_user.php?id=<?php echo $user_id; ?>">User Profile</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit User</li>
            </ol>
        </nav>
        
        <!-- Back button -->
        <div class="mb-4">
            <a href="view_user.php?id=<?php echo $user_id; ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to User Profile
            </a>
        </div>
        
        <h1 class="mb-4">Edit User</h1>
        
        <?php //if ($errorMessage):  ?>