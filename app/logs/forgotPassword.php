<!-- filepath: c:\xampp\htdocs\Eclipse\forgot-password.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - LearnHub</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Loader -->
    <div id="loader">
        <div class="spinner"></div>
        <p>Loading LearnHub...</p>
    </div>

    <!-- Back to Home Button -->
    <a href="./login.php" class="back-home-btn">Back</a>

    <!-- Main Content -->
    <div id="content" style="display: none;">
        <!-- Forgot Password Section -->
        <section class="register-section">
            <div class="register-container">
                <h2>Forgot Your Password?</h2>
                <p>Enter your email address to reset your password.</p>
                <div id="messageBox" class="alert hidden"></div>
                <form id="forgotPasswordForm" class="register-form" method="post">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <button type="submit" class="btn primary-btn">Reset Password</button>
                </form>
                <p class="login-link">Remembered your password? <a href="./login.php">Log In</a></p>
            </div>
        </section>
    </div>
    <script src="../../assets/js/script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('forgotPasswordForm');
            const messageBox = document.getElementById('messageBox');

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const email = document.getElementById('email').value;

                // Show loading state
                const submitButton = form.querySelector('button[type="submit"]');
                submitButton.disabled = true;
                submitButton.innerHTML = 'Processing...';

                fetch('../../server/auth/process_forgot_password.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ email: email })
                })
                .then(response => response.json())
                .then(data => {
                    messageBox.classList.remove('hidden');
                    if (data.success) {
                        messageBox.className = 'alert alert-success';
                        messageBox.textContent = 'Password reset instructions have been sent to your email.';
                        window.location.href = './resetPassword.php?token=' + data.token; // Redirect to reset password page
                        form.reset();
                    } else {
                        messageBox.className = 'alert alert-danger';
                        messageBox.textContent = data.message || 'An error occurred. Please try again.';
                    }
                })
                .catch(error => {
                    messageBox.classList.remove('hidden');
                    messageBox.className = 'alert alert-danger';
                    messageBox.textContent = 'An error occurred. Please try again later.';
                })
                .finally(() => {
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Reset Password';
                });
            });
        });
    </script>
</body>
</html>