<?php
// process_login.php - Handle login requests using PDO

// Start or resume session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set header to return JSON
header('Content-Type: application/json');

// Define constant to allow access to the config file
define('AUTHORIZED_ACCESS', true);

// Include database configuration
$db_config = require_once '../config.php';

// Response array
$response = array(
    'success' => false,
    'message' => '',
    'redirect' => ''
);

try {
    // Create DSN string from config
    $dsn = "mysql:host={$db_config['host']};dbname={$db_config['dbname']};charset={$db_config['charset']}";

    // Create PDO instance
    $pdo = new PDO($dsn, $db_config['username'], $db_config['password'], $db_config['options']);

    // Check if it's a POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
        // Get form data
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $remember = isset($_POST['remember']) ? filter_var($_POST['remember'], FILTER_VALIDATE_BOOLEAN) : false;

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $response['message'] = 'Please enter a valid email address.';
            echo json_encode($response);
            exit;
        }

        // Validate password (not empty)
        if (empty($password)) {
            $response['message'] = 'Please enter your password.';
            echo json_encode($response);
            exit;
        }

        // Prepare the SQL query
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND status = 'inactive'");
        $stmt->execute([$email]);

        // Check if user exists
        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt = $pdo->prepare("select r.name as role from roles r join user_roles ur on r.id = ur.role_id where ur.user_id = ?");
            $stmt->execute([$user['id']]);
            $user['role'] = $stmt->fetchColumn(); // Fetch the role name

            // Verify password
            // Hash the password
            // $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            if ($user['password_hash'] && password_verify($password, $user['password_hash'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['first_name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['isLoggedIn'] = true;

                // Handle "Remember Me" functionality
                if ($remember) {
                    // Generate a unique token
                    $token = bin2hex(random_bytes(32));
                    $token_hash = password_hash($token, PASSWORD_DEFAULT);

                    // Store token in database
                    // $expiry = date('Y-m-d H:i:s', strtotime('+30 days'));
                    // $stmt = $pdo->prepare("INSERT INTO user_tokens (user_id, token_hash, expiry_date) VALUES (?, ?, ?)");
                    // $stmt->execute([$user['id'], $token_hash, $expiry]);

                    // Set cookies (30 days expiration)
                    setcookie('remember_token', $token, time() + 30 * 24 * 60 * 60, '/', '', true, true);
                    setcookie('remember_user', $user['id'], time() + 30 * 24 * 60 * 60, '/', '', true, false);
                }

                // Update last login timestamp
                $stmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                $stmt->execute([$user['id']]);

                // Prepare successful response
                $response['success'] = true;
                $response['message'] = 'Login successful! Redirecting to dashboard... '.$passwordHash.' '.$user['password_hash'];

                // Set redirect based on user role
                if ($user['role'] === 'admin') {
                    $response['redirect'] = 'admin/dashboard.php';
                } else if ($user['role'] === 'instructor') {
                    $response['redirect'] = 'instructor/dashboard.php';
                } else {
                    $response['redirect'] = '../../index.php'; // Default redirect for students
                }
            } else {
                $response['message'] = 'Invalid email or password.';
            }
        } else {
            $response['message'] = 'Invalid email or password.';
        }
    } else {
        $response['message'] = 'Invalid request.';
    }
} catch (PDOException $e) {
    $response['message'] = 'Database error. Please try again later.';

    // Log error based on environment settings
    if ($db_config['dev_environment'] ?? false) {
        error_log('Login error: ' . $e->getMessage());
    }
}

// Return JSON response
echo json_encode($response);
