<!-- filepath: c:\xampp\htdocs\Eclipse\login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LearnHub</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/verifNot.css">
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
    <a href="../../index.php" class="back-home-btn">Home</a>

    <!-- Main Content -->
    <div id="content" style="display: none;">
        <!-- Login Section -->
        <section class="login-section">
            <div class="login-container">
                <h2>Welcome Back!</h2>
                <p>Log in to access your account and continue learning.</p>
                <form class="login-form" method="POST">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" placeholder="Enter your password" required>
                    </div>
                    <div class="form-options">
                        <div class="remember-me">
                            <input type="checkbox" id="remember">
                            <label for="remember">Remember Me</label>
                        </div>
                        <a href="./forgotPassword.php" class="forgot-password">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn primary-btn">Log In</button>
                </form>
                <p class="signup-link">Don't have an account? <a href="./register.php">Sign Up</a></p>
            </div>
        </section>
    </div>
    <script src="../../assets/js/script.js"></script>

    <script src="../../server/js/login.js"></script>
</body>
</html>