<?php
// Database configuration
$host = 'localhost';
$db   = 'fitness';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// PDO Connection
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Response array
$response = [
    'success' => false,
    'message' => '',
    'errors' => []
];

try {
    // Create PDO connection
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Validate input
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    // $fullName = filter_input(INPUT_POST, 'fullName', FILTER_SANITIZE_STRING);

    // Server-side validation
    $errors = [];

    // Username validation
    if (empty($username) || strlen($username) < 3) {
        $errors['username'] = 'Username must be at least 3 characters';
    }

    // Email validation
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email address';
    }

    // Password validation
    if (empty($password) || strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters';
    }

    // Check if username or email already exists
    $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        if ($existingUser['username'] === $username) {
            $errors['username'] = 'Username already exists';
        }
        if ($existingUser['email'] === $email) {
            $errors['email'] = 'Email already registered';
        }
    }

    // If there are validation errors, return them
    if (!empty($errors)) {
        $response['errors'] = $errors;
        $response['message'] = 'Registration failed. Please check the errors.';
        echo json_encode($response);
        exit;
    }

    // Hash password
    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL to insert new user
    $stmt = $pdo->prepare("
        INSERT INTO user (username, email, password) 
        VALUES (?, ?, ?)
    ");

    // Execute insertion
    $result = $stmt->execute([
        $username, 
        $email, 
        $password
    ]);

    // Check if insertion was successful
    if ($result) {
        $response['success'] = true;
        $response['message'] = 'Registration successful! You can now log in.';
    } else {
        $response['message'] = 'Registration failed. Please try again.';
    }

} catch (PDOException $e) {
    // Handle database errors
    $response['message'] = 'Database error: ' . $e->getMessage();
} catch (Exception $e) {
    // Handle other errors
    $response['message'] = 'An error occurred: ' . $e->getMessage();
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit;