<!-- filepath: c:\xampp\htdocs\Eclipse\register.php -->
<?php
    if(session_status() === PHP_SESSION_NONE){
        session_start();
    }

    if(isset($_SESSION['user_id']) && isset($_SESSION['isLoggedIn'])){
        switch($_SESSION['role']){
            case 'admin':
                // code:
                break;
            default:
                header("Location: ../../index.php");
                break;
        }
    }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - LearnHub</title>
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
    <a href="../../index.php" class="back-home-btn">Home</a>

    <!-- Main Content -->
    <div id="content" style="display: none;">
        <!-- Registration Section -->
        <section class="register-section">
            <div class="register-container">
                <h2>Create Your Account</h2>
                <p>Join LearnHub and start your learning journey today.</p>
                <form class="register-form" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="first-name">First Name</label>
                        <input type="text" id="first-name" placeholder="Enter your first name" required>
                    </div>
                    <div class="form-group">
                        <label for="last-name">Last Name</label>
                        <input type="text" id="last-name" placeholder="Enter your last name" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" placeholder="Enter your phone number" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" required>
                            <option value="" disabled selected>Select your gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" placeholder="Enter your password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" id="confirm-password" placeholder="Confirm your password" required>
                    </div>
                    <div class="form-group">
                        <label for="profile-picture">Profile Picture</label>
                        <input type="file" id="profile-picture" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn primary-btn">Register</button>
                </form>
                <p class="login-link">Already have an account? <a href="./login.php">Log In</a></p>
            </div>
        </section>
    </div>
    <script src="../../assets/js/script.js"></script>
    <script src="../../server/js/register.js"></script>
</body>
</html>