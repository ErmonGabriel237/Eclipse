<!-- filepath: c:\xampp\htdocs\Eclipse\reset-password.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - LearnHub</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
</head>
<body>
    <!-- Loader -->
    <div id="loader">
        <div class="spinner"></div>
        <p>Loading LearnHub...</p>
    </div>

    <!-- Back to Home Button -->
    <a href="./forgotPassword.php" class="back-home-btn">Back</a>

    <!-- Main Content -->
    <div id="content" style="display: none;">
        <!-- Reset Password Section -->
        <section class="register-section">
            <div class="register-container">
                <h2>Reset Your Password</h2>
                <p>Enter your new password below to reset your account password.</p>
                <form class="register-form">
                    <div class="form-group">
                        <label for="new-password">New Password</label>
                        <input type="password" id="new-password" placeholder="Enter your new password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" id="confirm-password" placeholder="Confirm your new password" required>
                    </div>
                    <button type="submit" class="btn primary-btn">Reset Password</button>
                </form>
                <p class="login-link">Remembered your password? <a href="./login.php">Log In</a></p>
            </div>
        </section>
    </div>
    <script src="../../assets/js/script.js"></script>
</body>
</html>