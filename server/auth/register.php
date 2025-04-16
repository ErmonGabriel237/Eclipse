<?php
/**
 * User Registration API
 * 
 * Handles new user registration with validation and image upload
 */

// Define constant to allow config file inclusion
define('AUTHORIZED_ACCESS', true);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set header to return JSON
header('Content-Type: application/json');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit;
}

try {
    // Load database configuration
    $config = require_once __DIR__ . '/../config.php';
    
    // Define constants for role IDs
    define('ROLE_STUDENT', 1);
    
    // Create PDO connection
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
    $pdo = new PDO($dsn, $config['username'], $config['password'], $config['options']);
    
    // Get and sanitize form data
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Additional sanitization for strings
    $firstName = htmlspecialchars(trim($firstName), ENT_QUOTES, 'UTF-8');
    $lastName = htmlspecialchars(trim($lastName), ENT_QUOTES, 'UTF-8');
    $phone = htmlspecialchars(trim($phone), ENT_QUOTES, 'UTF-8');
    $gender = htmlspecialchars(trim($gender), ENT_QUOTES, 'UTF-8');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    
    // Validation
    $errors = [];
    
    // Email validation
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address';
    }
    
    // Check if email already exists
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        $errors[] = 'Email address is already registered';
    }
    
    // Name validation
    if (empty($firstName) || strlen($firstName) < 2) {
        $errors[] = 'First name must be at least 2 characters';
    }
    
    if (empty($lastName) || strlen($lastName) < 2) {
        $errors[] = 'Last name must be at least 2 characters';
    }
    
    // Phone validation (basic format check)
    if (empty($phone) || !preg_match('/^[0-9+\-\s()]{6,20}$/', $phone)) {
        $errors[] = 'Please enter a valid phone number';
    }
    
    // Gender validation
    if (empty($gender) || !in_array($gender, ['male', 'female', 'other'])) {
        $errors[] = 'Please select a valid gender';
    }
    
    // Password validation
    if (empty($password) || strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters';
    }
    
    if ($password !== $confirmPassword) {
        $errors[] = 'Passwords do not match';
    }
    
    // Profile picture validation and upload
    $profilePicturePath = null;
    if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = $_FILES['profilePicture']['type'];
        
        if (!in_array($fileType, $allowedTypes)) {
            $errors[] = 'Profile picture must be a JPG, PNG, or GIF image';
        } else {
            // Create uploads directory if it doesn't exist
            $uploadDir = '../../assets/uploads/profile_pictures/';
            if (!is_dir($uploadDir) && !@mkdir($uploadDir, 0755, true) && !is_dir($uploadDir)) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $uploadDir));
            }
            
            // Generate a unique filename
            $filename = uniqid('profile_') . '_' . basename($_FILES['profilePicture']['name']);
            $uploadPath = $uploadDir . $filename;
            
            // Move the uploaded file
            if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $uploadPath)) {
                $profilePicturePath =  $filename;
            } else {
                $errors[] = 'Failed to upload profile picture';
            }
        }
    } else {
        $errors[] = 'Profile picture is required';
    }
    
    // If there are validation errors, return them
    if (!empty($errors)) {
        echo json_encode(['status' => 'error', 'message' => 'Validation failed', 'errors' => $errors]);
        exit;
    }
    
    // Hash the password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    
    // Begin transaction
    $pdo->beginTransaction();
    
    // Insert user data
    $stmt = $pdo->prepare('INSERT INTO users (email, password_hash, first_name, last_name, phone_number, gender, profile_picture) VALUES (?, ?, ?, ?, ?, ?, ?)');
    // $stmt->execute([$userId, ROLE_STUDENT]); // Use constant for student role ID
    $stmt->execute([$email, $passwordHash, $firstName, $lastName, $phone, $gender, $profilePicturePath]);
    $userId = $pdo->lastInsertId();
    
    // Assign default student role
    $stmt = $pdo->prepare('INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)');
    $stmt->execute([$userId, 1]); // Role ID 1 is 'student' based on seed data
    
    // Create user_profile entry (assuming there's a user_profile table for additional info)
    // This part is optional and depends on your database structure
    // $stmt = $pdo->prepare('INSERT INTO user_profile (user_id, phone, gender) VALUES (?, ?, ?)');
    // $stmt->execute([$userId, $phone, $gender]);
    
    // Commit the transaction
    $pdo->commit();
    
    // Return success response
    echo json_encode([
        'status' => 'success',
        'message' => 'Registration successful! Please check your email to activate your account.',
        'redirect' => './login.php'
    ]);
    
} catch (PDOException $e) {
    // Roll back transaction on error
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    // Log the error (in production, consider using a proper logging system)
    error_log('Registration Error: ' . $e->getMessage());
    
    // Return error message
    echo json_encode(['status' => 'error', 'message' => 'Registration failed. Please try again later.']);
} catch (Exception $e) {
    // Generic error handling
    error_log('System Error: ' . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred.']);
}
?>