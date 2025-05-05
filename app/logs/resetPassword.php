<!-- filepath: c:\xampp\htdocs\Eclipse\reset-password.php -->
<?php
session_start();

// Validate token
// if (!isset($_GET['token'])) {
//     header('Location: ./login.php');
//     exit;
// }

$token = $_GET['token'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - LearnHub</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
        .password-group {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
        }
    </style>
</head>
<body>
    <!-- Loader -->
    <div id="loader">
        <div class="spinner"></div>
        <p>Loading LearnHub...</p>
    </div>

    <!-- Main Content -->
    <div id="content" style="display: none;">
        <section class="register-section">
            <div class="register-container">
                <h2>Reset Your Password</h2>
                <p>Please enter your new password below.</p>
                <div id="messageBox" class="alert hidden"></div>
                <form id="resetPasswordForm" class="register-form">
                    <input type="hidden" id="token" value="<?php echo htmlspecialchars($token); ?>">
                    
                    <div class="form-group password-group">
                        <label for="password">New Password</label>
                        <input type="password" id="password" name="password" required 
                               minlength="8" placeholder="Enter your new password">
                        <i class="password-toggle fas fa-eye" onclick="togglePassword('password')"></i>
                    </div>

                    <div class="form-group password-group">
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" required 
                               minlength="8" placeholder="Confirm your new password">
                        <i class="password-toggle fas fa-eye" onclick="togglePassword('confirmPassword')"></i>
                    </div>

                    <button type="submit" class="btn primary-btn">Reset Password</button>
                </form>
            </div>
        </section>
    </div>

    <script src="../../assets/js/script.js"></script>
    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling;
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('resetPasswordForm');
            const messageBox = document.getElementById('messageBox');

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirmPassword').value;
                const token = document.getElementById('token').value;

                if (password !== confirmPassword) {
                    messageBox.classList.remove('hidden');
                    messageBox.className = 'alert alert-danger';
                    messageBox.textContent = 'Passwords do not match!';
                    return;
                }

                // Show loading state
                const submitButton = form.querySelector('button[type="submit"]');
                submitButton.disabled = true;
                submitButton.innerHTML = 'Processing...';

                fetch('../../server/auth/process_reset_password.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        token: token,
                        password: password
                    })
                })
                .then(response => response.json())
                .then(data => {
                    messageBox.classList.remove('hidden');
                    if (data.success) {
                        messageBox.className = 'alert alert-success';
                        messageBox.textContent = 'Password successfully reset! Redirecting to login...';
                        form.reset();
                        setTimeout(() => {
                            window.location.href = './login.php';
                        }, 2000);
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