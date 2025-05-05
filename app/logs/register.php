<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

// Add CSRF Protection
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if(isset($_SESSION['user_id']) && isset($_SESSION['isLoggedIn'])){
    header("Location: ../../index.php");
    exit();
}

// Database connection and roles query
// require_once '../../server/config.php';
try {
    // define('AUTHORIZED_ACCESS', true);
    // $pdo = new PDO(
    //     "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}", 
    //     $config['username'], 
    //     $config['password'], 
    //     $config['options']
    // );
    
    $pdo = new mysqli('localhost', 'root', '', 'elearning');
    if($pdo->connect_error) {
        error_log("Database connection failed: " . $pdo->connect_error);
        die("An error occurred while connecting to the database. Please try again later.");
    }

    // Get roles excluding admin
    $stmt = $pdo->prepare("SELECT id, name FROM roles WHERE name != ? and name != ?");
    $stmt->execute(['admin', 'content_manager']);
    $roles = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    // $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($roles)) {
        error_log("No roles found in database");
        throw new Exception("System configuration error");
    }
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    die("An error occurred while connecting to the database. Please try again later.");
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    die("An error occurred. Please try again later.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - LearnHub</title>
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
        <!-- Registration Section -->
        <section class="register-section">
            <div class="register-container animate__animated animate__fadeIn">
                <h2>Create Account</h2>
                <p>Join LearnHub and start your learning journey today!</p>
                <form class="register-form" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" placeholder="Enter your first name" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" placeholder="Enter your last name" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>

                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="tel" id="phone_number" name="phone_number" placeholder="Enter your phone number" required>
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" required>
                            <option value="">Select gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="role">Role</label>
                        <select id="role" name="role" required>
                            <option value="">Select role</option>
                            <?php foreach($roles as $role): ?>
                                <option value="<?php echo htmlspecialchars($role['id']); ?>">
                                    <?php echo htmlspecialchars(ucfirst($role['name'])); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="profile_picture">Profile Picture (Optional)</label>
                        <input type="file" id="profile_picture" name="profile_picture" accept="image/jpeg,image/png,image/gif">
                        <small class="form-text text-muted">Maximum file size: 5MB. Allowed types: JPG, PNG, GIF</small>
                    </div>

                    <div class="form-group password-group">
                        <label for="password">Password</label>
                        <div class="password-input-group">
                            <input type="password" id="password" name="password" 
                                   placeholder="Enter your password" required 
                                   pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                                   title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 characters">
                            <i class="password-toggle fas fa-eye" onclick="togglePassword('password')"></i>
                        </div>
                        <div class="password-requirements">
                            <small>Password must contain:</small>
                            <ul class="requirements-list">
                                <li id="length">At least 8 characters</li>
                                <li id="uppercase">One uppercase letter</li>
                                <li id="lowercase">One lowercase letter</li>
                                <li id="number">One number</li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-group password-group">
                        <label for="confirm_password">Confirm Password</label>
                        <div class="password-input-group">
                            <input type="password" id="confirm_password" name="confirm_password" 
                                   placeholder="Confirm your password" required>
                            <i class="password-toggle fas fa-eye" onclick="togglePassword('confirm_password')"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn primary-btn">Create Account</button>
                </form>
                <p class="login-link">Already have an account? <a href="./login.php">Log In</a></p>
            </div>
        </section>

        <!-- Notification Container -->
        <div id="notification-container"></div>
    </div>

    <script src="../../assets/js/script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.register-form');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            const submitButton = form.querySelector('button[type="submit"]');

            // Validation functions
            const validators = {
                name: name => /^[a-zA-Z\s]{2,50}$/.test(name.trim()),
                email: email => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email),
                phone: phone => /^[0-9+\-\s()]{8,20}$/.test(phone),
                password: () => {
                    const rules = {
                        length: password.value.length >= 8,
                        uppercase: /[A-Z]/.test(password.value),
                        lowercase: /[a-z]/.test(password.value),
                        number: /\d/.test(password.value)
                    };
                    
                    Object.entries(rules).forEach(([rule, isValid]) => {
                        document.getElementById(rule)?.classList.toggle('valid', isValid);
                    });
                    
                    return Object.values(rules).every(Boolean);
                },
                file: file => {
                    if (!file || file.name === '') return true;
                    const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    const maxSize = 5 * 1024 * 1024;
                    return validTypes.includes(file.type) && file.size <= maxSize;
                }
            };

            // Form submission
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                
                // Validate all fields
                if (!validators.name(formData.get('first_name'))) {
                    showNotification('Invalid first name');
                    return;
                }
                if (!validators.name(formData.get('last_name'))) {
                    showNotification('Invalid last name');
                    return;
                }
                if (!validators.email(formData.get('email'))) {
                    showNotification('Invalid email address');
                    return;
                }
                if (!validators.phone(formData.get('phone_number'))) {
                    showNotification('Invalid phone number');
                    return;
                }
                if (!validators.password()) {
                    showNotification('Please meet all password requirements');
                    return;
                }
                if (password.value !== confirmPassword.value) {
                    showNotification('Passwords do not match');
                    return;
                }
                if (!validators.file(formData.get('profile_picture'))) {
                    showNotification('Invalid file. Please use JPG, PNG, or GIF under 5MB');
                    return;
                }

                try {
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Account...';

                    const response = await fetch('../../server/auth/register.php', {
                        method: 'POST',
                        body: formData
                    });

                    const data = await response.json();
                    
                    if (data.success) {
                        showNotification(data.message, 'success');
                        setTimeout(() => window.location.href = './login.php', 2000);
                    } else {
                        showNotification(data.message);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showNotification('An error occurred. Please try again later.');
                } finally {
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Create Account';
                }
            });
        });

        function showNotification(message, type = 'error') {
            const container = document.getElementById('notification-container');
            const notification = document.createElement('div');
            notification.className = `notification ${type} animate__animated animate__fadeIn`;
            notification.textContent = message;
            container.appendChild(notification);
            setTimeout(() => {
                notification.classList.add('animate__fadeOut');
                setTimeout(() => notification.remove(), 600);
            }, 5000);
        }

        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling;
            input.type = input.type === 'password' ? 'text' : 'password';
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        }
    </script>
    <style>
        .password-input-group {
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

        .password-requirements {
            margin-top: 10px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        .requirements-list {
            list-style: none;
            padding-left: 0;
            margin: 5px 0 0;
        }

        .requirements-list li {
            position: relative;
            padding-left: 20px;
            margin: 5px 0;
            font-size: 0.85em;
            color: #666;
        }

        .requirements-list li::before {
            content: '×';
            position: absolute;
            left: 0;
            color: #dc3545;
        }

        .requirements-list li.valid::before {
            content: '✓';
            color: #28a745;
        }

        .notification {
            padding: 15px;
            margin: 10px;
            border-radius: 4px;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            min-width: 300px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .notification.error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .notification.success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
    </style>
</body>
</html>