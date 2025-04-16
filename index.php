<?php
    if(session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $isLoggedIn = isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] === true;
    $username = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnHub - Modern E-Learning Platform</title>
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
                <li><a href="./index.php" class="active">Home</a></li>
                <li><a href="./courses.php">Courses</a></li>
                <li><a href="./about.php">About</a></li>
                <li><a href="./contact.php">Contact</a></li>
            </ul>
            <?php if (!$isLoggedIn) :?>
                <div class="auth-buttons">
                    <button class="btn login-btn">Log In</button>
                    <button class="btn signup-btn">Sign Up</button>
                </div>
            <?php else: ?>
                <div class="auth-buttons">
                    <button class="btn">DashBoard</button>
                    <button class="btn signup-btn"><?php echo $_SESSION['user_name'];?>></button>
                </div>
            <?php endif;?>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <h1 class="animate__animated animate__fadeInUp">Learn Anything, Anytime, Anywhere</h1>
                <p class="animate__animated animate__fadeInUp animate__delay-1s">
                    Access thousands of high-quality courses taught by expert instructors.
                    Start your learning journey today!
                </p>
                <div class="hero-buttons animate__animated animate__fadeInUp animate__delay-2s">
                    <button class="btn primary-btn">Get Started</button>
                    <button class="btn secondary-btn">Browse Courses</button>
                </div>
            </div>
            <!-- animate__animated animate__fadeIn animate__delay-1s -->
            <div class="hero-image">
                <img src="./assets/img/hero/hero.png" alt="Students learning online">
            </div>
        </section>

        <!-- Features Section -->
        <section class="features">
            <h2>Why Choose LearnHub?</h2>
            <div class="features-container">
                <div class="feature-card" data-aos="fade-up">
                    <div class="feature-icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <h3>Learn Anywhere</h3>
                    <p>Access courses on any device, anytime, anywhere.</p>
                </div>
                <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-icon">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3>Certified Courses</h3>
                    <p>Earn certificates recognized by top companies worldwide.</p>
                </div>
                <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Expert Instructors</h3>
                    <p>Learn from industry experts with years of experience.</p>
                </div>
            </div>
        </section>

        <!-- Popular Courses Section -->
        <section class="courses">
            <h2>Popular Courses</h2>
            <div class="courses-container">
                <div class="course-card">
                    <div class="course-image">
                        <img src="/api/placeholder/300/200" alt="Web Development">
                        <div class="course-badge">Bestseller</div>
                    </div>
                    <div class="course-content">
                        <div class="course-category">Development</div>
                        <h3>Complete Web Development Bootcamp</h3>
                        <div class="course-info">
                            <div class="course-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>4.8 (2.4k reviews)</span>
                            </div>
                            <div class="course-price">$89.99</div>
                        </div>
                    </div>
                </div>
                <div class="course-card">
                    <div class="course-image">
                        <img src="/api/placeholder/300/200" alt="Data Science">
                    </div>
                    <div class="course-content">
                        <div class="course-category">Data Science</div>
                        <h3>Data Science & Machine Learning</h3>
                        <div class="course-info">
                            <div class="course-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span>5.0 (1.8k reviews)</span>
                            </div>
                            <div class="course-price">$99.99</div>
                        </div>
                    </div>
                </div>
                <div class="course-card">
                    <div class="course-image">
                        <img src="/api/placeholder/300/200" alt="Digital Marketing">
                        <div class="course-badge">New</div>
                    </div>
                    <div class="course-content">
                        <div class="course-category">Marketing</div>
                        <h3>Digital Marketing Masterclass</h3>
                        <div class="course-info">
                            <div class="course-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>4.2 (980 reviews)</span>
                            </div>
                            <div class="course-price">$79.99</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="courses-cta">
                <button class="btn primary-btn">View All Courses</button>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="testimonials">
            <h2>What Our Students Say</h2>
            <div class="testimonials-container">
                <div class="testimonial">
                    <div class="testimonial-content">
                        <p>"LearnHub transformed my career. The courses are comprehensive and the instructors are amazing. I landed my dream job after completing just two courses!"</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">
                            <img src="/api/placeholder/60/60" alt="Student">
                        </div>
                        <div class="testimonial-info">
                            <h4>Alex Johnson</h4>
                            <p>Web Developer</p>
                        </div>
                    </div>
                </div>
                <div class="testimonial">
                    <div class="testimonial-content">
                        <p>"The flexibility of LearnHub's platform allowed me to learn at my own pace while working full-time. The mobile app is a game-changer for busy professionals!"</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">
                            <img src="/api/placeholder/60/60" alt="Student">
                        </div>
                        <div class="testimonial-info">
                            <h4>Sarah Miller</h4>
                            <p>Data Analyst</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Newsletter Section -->
        <section class="newsletter">
            <div class="newsletter-content">
                <h2>Stay Updated</h2>
                <p>Subscribe to our newsletter for the latest course updates and special offers.</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Enter your email" required>
                    <button type="submit" class="btn primary-btn">Subscribe</button>
                </form>
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