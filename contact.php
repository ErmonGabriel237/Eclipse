<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - LearnHub</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
</head>
<body>
    <!-- Loader -->
    <div id="loader">
        <div class="spinner"></div>
        <p>Loading LearnHub...</p>
    </div>

    <!-- Main Content -->
    <div id="content" style="display: none;">
        <!-- Navigation -->
        <nav>
            <div class="logo">
                <h1>Learn<span>Hub</span></h1>
            </div>
            <ul class="nav-links">
                <li><a href="./index.php">Home</a></li>
                <li><a href="./courses.php">Courses</a></li>
                <li><a href="./about.php">About</a></li>
                <li><a href="./contact.php" class="active">Contact</a></li>
            </ul>
            <div class="auth-buttons">
                <button class="btn login-btn">Log In</button>
                <button class="btn signup-btn">Sign Up</button>
            </div>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>

        <!-- Contact Section -->
        <section class="contact">
            <h2>Contact Us</h2>
            <p>We'd love to hear from you! Fill out the form below or reach us through our social media channels.</p>
            <div class="contact-container">
                <div class="contact-form">
                    <form action="submit_contact.php" method="POST">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="Your Email" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="5" placeholder="Your Message" required></textarea>
                        </div>
                        <button type="submit" class="btn primary-btn">Send Message</button>
                    </form>
                </div>
                <div class="contact-info">
                    <h3>Our Office</h3>
                    <p>123 LearnHub Street, Education City, 45678</p>
                    <p>Email: support@learnhub.com</p>
                    <p>Phone: +1 234 567 890</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer>
            <div class="footer-content">
                <div class="footer-logo">
                    <h2>Learn<span>Hub</span></h2>
                    <p>Empowering learners worldwide.</p>
                </div>
                <div class="footer-links">
                    <div class="footer-column">
                        <h3>Company</h3>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Press</a></li>
                            <li><a href="#">Blog</a></li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <h3>Learn</h3>
                        <ul>
                            <li><a href="#">Courses</a></li>
                            <li><a href="#">Tutorials</a></li>
                            <li><a href="#">Resources</a></li>
                            <li><a href="#">Webinars</a></li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <h3>Support</h3>
                        <ul>
                            <li><a href="#">Help Center</a></li>
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Community</a></li>
                        </ul>
                    </div>
                </div>
                <div class="footer-social">
                    <h3>Connect With Us</h3>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 LearnHub. All Rights Reserved.</p>
                <ul class="footer-bottom-links">
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Cookie Policy</a></li>
                </ul>
            </div>
        </footer>
    </div>

    <script src="./assets/js/script.js"></script>
</body>
</html>