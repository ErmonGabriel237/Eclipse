<?php
// Database configuration
$host = 'localhost';
$db   = 'fitness';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// PDO options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Response array
$response = [
    'success' => false,
    'userType' => 'client',
    'message' => ''
];

try {
    // Create PDO connection
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Check if form was submitted via POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitize and validate input
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        // Validate input
        if (empty($username) || empty($password)) {
            $response['message'] = 'Please enter both username and password.';
            echo json_encode($response);
            exit;
        }

        // Prepare SQL to prevent SQL injection
        $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Verify password
        // echo '<script>console.log('.$username+$password.')</script>';
        if ($user) {
            if($password === $user['password']){
                // Successful login
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user['userId'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['userType'] = $user['userType'];
    
                $response['success'] = true;
                $response['userType'] = $_SESSION['userType'];

                // Updating the user status from Offline to Onlline
                $stmt = $pdo->prepare("UPDATE user SET status='online' WHERE username = ?");
                $stmt->execute([$username]);

                $response['message'] = 'Login successful!';
            }else{
                $response['message'] = 'Invalid Username or Password.';
            }
        } else {
            // Failed login
            $response['message'] = 'Invalid Username or Password.';
        }
    } else {
        $response['message'] = 'Invalid request method.';
    }
} catch (PDOException $e) {
    // Database error
    $response['message'] = 'Database error: ' . $e->getMessage();
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit;