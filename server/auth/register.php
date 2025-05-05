<?php
header('Content-Type: application/json');
define('AUTHORIZED_ACCESS', true);
$config = require_once '../config.php';

function validateInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

try {
    // Check if request method is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Validate input fields
    $required_fields = ['email', 'password', 'first_name', 'last_name', 'phone_number', 'gender', 'role'];
    $sanitized_input = [];
    
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            throw new Exception("Field '$field' is required");
        }
        $sanitized_input[$field] = validateInput($_POST[$field]);
    }

    // Validate email format
    if (!filter_var($sanitized_input['email'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email format');
    }

    // Validate password strength
    if (strlen($sanitized_input['password']) < 8) {
        throw new Exception('Password must be at least 8 characters long');
    }

    // Validate phone number format
    if (!preg_match('/^[0-9+\-\s()]{8,20}$/', $sanitized_input['phone_number'])) {
        throw new Exception('Invalid phone number format');
    }

    // Validate gender
    $allowed_genders = ['male', 'female', 'other'];
    if (!in_array(strtolower($sanitized_input['gender']), $allowed_genders)) {
        throw new Exception('Invalid gender value');
    }

    // Handle profile picture upload
    $profile_picture = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5MB
        
        // Validate file type using mime type
        $file_info = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($file_info, $_FILES['profile_picture']['tmp_name']);
        finfo_close($file_info);

        if (!in_array($mime_type, $allowed_types)) {
            throw new Exception('Invalid file type. Only JPG, PNG and GIF are allowed');
        }

        if ($_FILES['profile_picture']['size'] > $max_size) {
            throw new Exception('File size too large. Maximum size is 5MB');
        }

        // Create upload directory if it doesn't exist
        $upload_dir = '../uploads/profiles/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Generate safe filename
        $ext = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
        $upload_name = bin2hex(random_bytes(16)) . '.' . $ext;
        $upload_path = $upload_dir . $upload_name;
        
        if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_path)) {
            throw new Exception('Failed to upload image');
        }
        
        $profile_picture = $upload_name;
    }

    $pdo = new PDO(
        "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}", 
        $config['username'], 
        $config['password'], 
        $config['options']
    );

    // Hash password with strong algorithm
    $password_hash = password_hash($sanitized_input['password'], PASSWORD_ARGON2ID);

    // Begin transaction
    $pdo->beginTransaction();

    try {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$sanitized_input['email']]);
        if ($stmt->fetchColumn()) {
            throw new Exception('Email already exists');
        }

        // Verify role exists
        $stmt = $pdo->prepare("SELECT id FROM roles WHERE id = ?");
        $stmt->execute([$sanitized_input['role']]);
        if (!$stmt->fetch()) {
            throw new Exception('Invalid role selected');
        }

        // Insert user
        $sql = "INSERT INTO users (
            email, password_hash, first_name, last_name, 
            phone_number, gender, profile_picture, status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, 'inactive')";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $sanitized_input['email'],
            $password_hash,
            $sanitized_input['first_name'],
            $sanitized_input['last_name'],
            $sanitized_input['phone_number'],
            strtolower($sanitized_input['gender']),
            $profile_picture
        ]);

        $user_id = $pdo->lastInsertId();

        // Assign role to user
        $sql = "INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id, $sanitized_input['role']]);

        // Commit transaction
        $pdo->commit();

        // Log successful registration
        error_log("New user registered: {$sanitized_input['email']} with role {$sanitized_input['role']}");

        echo json_encode([
            'success' => true, 
            'message' => 'Registration successful! Please wait for admin approval.'
        ]);
        
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
    
} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => 'A database error occurred. Please try again later.'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
} finally {
    // Clean up any temporary files if registration failed
    if (isset($upload_path) && file_exists($upload_path) && 
        (isset($pdo) && !$pdo->inTransaction())) {
        unlink($upload_path);
    }
}