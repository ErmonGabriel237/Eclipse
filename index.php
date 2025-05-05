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
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
</head>
<body>
    <!-- Preloader -->
    <div id="preloader" id="loader">
        <div class="loader">
            <svg viewBox="0 0 80 80">
                <circle id="test" cx="40" cy="40" r="32"></circle>
            </svg>
        </div>
        <div class="loader-text">Welcome to LearnHub</div>
    </div>

    <!-- Main Content -->
    <div id="content" style="display: none;">
        <!-- Navigation -->+
         
        <nav class="nav-glass">
            <div class="logo">
                <h1><span class="gradient-text">Learn</span>Hub</h1>
            </div>
            <ul class="nav-links">
                <li><a href="./index.php" class="active">Home</a></li>
                <li><a href="./courses.php">Courses</a></li>
                <li><a href="./about.php">About</a></li>
                <li><a href="./contact.php">Contact</a></li>
            </ul>
            <?php if (!$isLoggedIn) :?>
                <div class="auth-buttons">
                    <button class="btn login-btn glass-effect">Log In</button>
                    <button class="btn signup-btn gradient-btn">Sign Up</button>
                </div>
            <?php else: ?>
                <div class="auth-buttons">
                    <a href="./app/dashboards/admin/html/index.php" class="btn dashboard-btn glass-effect">
                        <i class="fas fa-columns"></i> Dashboard
                    </a>
                    <div class="user-profile">
                        <button class="btn profile-btn glass-effect">
                            <i class="fas fa-user"></i>
                            <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                        </button>
                    </div>
                </div>
            <?php endif;?>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero gradient-bg">
            <div class="hero-content" data-aos="fade-right">
                <h1 class="gradient-text animate__animated animate__fadeInUp">
                    Transform Your Future with Digital Learning
                </h1>
                <p class="animate__animated animate__fadeInUp animate__delay-1s">
                    Join millions of learners worldwide and explore top-quality courses 
                    taught by industry experts. Start your learning journey today!
                </p>
                <div class="hero-buttons animate__animated animate__fadeInUp animate__delay-2s">
                    <button class="btn primary-btn pulse-effect">Explore Courses</button>
                    <button class="btn secondary-btn glass-effect">Watch Demo</button>
                </div>
                <div class="hero-stats" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-item">
                        <span class="stat-number">1M+</span>
                        <span class="stat-label">Students</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">500+</span>
                        <span class="stat-label">Courses</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">250+</span>
                        <span class="stat-label">Instructors</span>
                    </div>
                </div>
            </div>
            <div class="hero-image" data-aos="fade-left">
                <div class="floating-cards">
                    <div class="course-card-mini glass-effect">
                        <i class="fas fa-code"></i>
                        <span>Web Development</span>
                    </div>
                    <div class="course-card-mini glass-effect">
                        <i class="fas fa-palette"></i>
                        <span>UI/UX Design</span>
                    </div>
                    <div class="course-card-mini glass-effect">
                        <i class="fas fa-brain"></i>
                        <span>AI & ML</span>
                    </div>
                </div>
                <img src="./assets/img/hero/hero.png" alt="Digital Learning" class="main-hero-image">
            </div>
        </section>

        <!-- Features Section -->
        <section class="features">
            <h2 class="section-title gradient-text" data-aos="fade-up">Why Choose LearnHub?</h2>
            <div class="features-container">
                <div class="feature-card glass-effect" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-icon gradient-text">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3>Interactive Learning</h3>
                    <p>Engage with hands-on projects and real-world applications</p>
                </div>
                <div class="feature-card glass-effect" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-icon gradient-text">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3>Certified Courses</h3>
                    <p>Earn industry-recognized certificates upon completion</p>
                </div>
                <div class="feature-card glass-effect" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-icon gradient-text">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Expert Instructors</h3>
                    <p>Learn from industry professionals with years of experience</p>
                </div>
            </div>
        </section>

        <!-- Popular Courses Section -->
        <section class="courses">
            <h2 class="section-title gradient-text" data-aos="fade-up">Trending Courses</h2>
            <div class="swiper courses-slider">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="course-card glass-effect">
                            <div class="course-image">
                                <img src="https://via.placeholder.com/300x200" alt="Web Development">
                                <div class="course-overlay">
                                    <span class="course-badge">Bestseller</span>
                                </div>
                            </div>
                            <div class="course-content">
                                <div class="course-category">Development</div>
                                <h3>Advanced Web Development Bootcamp</h3>
                                <div class="course-meta">
                                    <div class="course-rating">
                                        <i class="fas fa-star"></i>
                                        <span>4.8 (2.4k reviews)</span>
                                    </div>
                                    <div class="course-students">
                                        <i class="fas fa-users"></i>
                                        <span>15,000+ students</span>
                                    </div>
                                </div>
                                <div class="course-price">
                                    <span class="price">$89.99</span>
                                    <button class="btn course-btn">Learn More</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Add more course slides here -->
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </section>

        <!-- Categories Section with Icons -->
        <section class="categories gradient-bg">
            <h2 class="section-title" data-aos="fade-up">Popular Categories</h2>
            <div class="categories-grid">
                <div class="category-card glass-effect" data-aos="zoom-in" data-aos-delay="100">
                    <i class="fas fa-code"></i>
                    <h3>Programming</h3>
                    <span>150+ Courses</span>
                </div>
                <div class="category-card glass-effect" data-aos="zoom-in" data-aos-delay="200">
                    <i class="fas fa-paint-brush"></i>
                    <h3>Design</h3>
                    <span>200+ Courses</span>
                </div>
                <div class="category-card glass-effect" data-aos="zoom-in" data-aos-delay="300">
                    <i class="fas fa-chart-line"></i>
                    <h3>Business</h3>
                    <span>300+ Courses</span>
                </div>
                <!-- Add more categories -->
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="testimonials">
            <h2 class="section-title gradient-text" data-aos="fade-up">What Our Students Say</h2>
            <div class="swiper testimonials-slider">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="testimonial-card glass-effect">
                            <div class="testimonial-content">
                                <i class="fas fa-quote-left"></i>
                                <p>"LearnHub transformed my career. The courses are comprehensive and the instructors are amazing. I landed my dream job after completing just two courses!"</p>
                            </div>
                            <div class="testimonial-author">
                                <img src="https://via.placeholder.com/60x60" alt="Student" class="author-image">
                                <div class="author-info">
                                    <h4>Alex Johnson</h4>
                                    <p>Web Developer</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Add more testimonials -->
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </section>

        <!-- Newsletter Section -->
        <section class="newsletter gradient-bg">
            <div class="newsletter-content glass-effect" data-aos="fade-up">
                <h2>Stay Updated</h2>
                <p>Subscribe to our newsletter for the latest course updates and special offers.</p>
                <form class="newsletter-form">
                    <div class="form-group">
                        <input type="email" placeholder="Enter your email" required class="glass-input">
                        <button type="submit" class="btn primary-btn pulse-effect">Subscribe</button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Footer -->
        <footer>
            <div class="footer-content">
                <div class="footer-logo">
                    <h2><span class="gradient-text">Learn</span>Hub</h2>
                    <p>Empowering learners worldwide</p>
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
                        <a href="#" class="glass-effect"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="glass-effect"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="glass-effect"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="glass-effect"><i class="fab fa-linkedin-in"></i></a>
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

    <!-- Scroll to Top Button -->
    <button id="scrollToTop" class="scroll-top-btn glass-effect">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="./assets/js/script.js"></script>
</body>
</html>