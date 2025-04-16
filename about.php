<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - LearnHub</title>
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
        <!-- Navigation -->
        <nav>
            <div class="logo">
                <h1>Learn<span>Hub</span></h1>
            </div>
            <ul class="nav-links">
                <li><a href="./index.php">Home</a></li>
                <li><a href="./courses.php">Courses</a></li>
                <li><a href="./about.php" class="active">About</a></li>
                <li><a href="./contact.php">Contact</a></li>
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

        <!-- About Hero Section -->
        <section class="about-hero">
            <div class="about-hero-content">
                <h1 class="animate__animated animate__fadeInUp">About LearnHub</h1>
                <p class="animate__animated animate__fadeInUp animate__delay-1s">
                    Empowering learners worldwide with accessible, high-quality education.
                </p>
            </div>
        </section>

        <!-- Our Story Section -->
        <section class="our-story">
            <div class="story-container">
                <div class="story-image animate__animated animate__fadeIn animate__delay-1s">
                    <img src="/api/placeholder/500/400" alt="LearnHub founding team">
                </div>
                <div class="story-content">
                    <h2>Our Story</h2>
                    <p>
                        Founded in 2020, LearnHub began with a simple mission: to make quality education accessible to everyone, everywhere. 
                        What started as a small collection of coding tutorials has grown into a comprehensive learning platform with thousands 
                        of courses across dozens of disciplines.
                    </p>
                    <p>
                        Our founders, a team of educators and technology enthusiasts, recognized the limitations of traditional education systems 
                        and set out to create something revolutionary. Today, we're proud to have helped over 2 million learners worldwide 
                        transform their lives through education.
                    </p>
                </div>
            </div>
        </section>

        <!-- Our Mission Section -->
        <section class="our-mission">
            <h2>Our Mission</h2>
            <div class="mission-content">
                <div class="mission-statement" data-aos="fade-up">
                    <div class="mission-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>Vision</h3>
                    <p>To create a world where anyone, anywhere can transform their life through access to high-quality education.</p>
                </div>
                <div class="mission-statement" data-aos="fade-up" data-aos-delay="200">
                    <div class="mission-icon">
                        <i class="fas fa-compass"></i>
                    </div>
                    <h3>Mission</h3>
                    <p>To provide accessible, affordable, and engaging learning experiences that empower individuals to achieve their personal and professional goals.</p>
                </div>
                <div class="mission-statement" data-aos="fade-up" data-aos-delay="400">
                    <div class="mission-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3>Values</h3>
                    <p>Excellence, inclusivity, innovation, and lifelong learning are at the core of everything we do.</p>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="team">
            <h2>Meet Our Leadership</h2>
            <div class="team-container">
                <div class="team-member">
                    <div class="member-image">
                        <img src="/api/placeholder/200/200" alt="Team Member">
                    </div>
                    <h3>Jennifer Chen</h3>
                    <p class="member-role">CEO & Co-Founder</p>
                    <p class="member-bio">Former education technology researcher with a passion for democratizing knowledge.</p>
                    <div class="member-social">
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="team-member">
                    <div class="member-image">
                        <img src="/api/placeholder/200/200" alt="Team Member">
                    </div>
                    <h3>Michael Rodriguez</h3>
                    <p class="member-role">CTO & Co-Founder</p>
                    <p class="member-bio">Software engineer with 15+ years of experience building educational platforms.</p>
                    <div class="member-social">
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="team-member">
                    <div class="member-image">
                        <img src="/api/placeholder/200/200" alt="Team Member">
                    </div>
                    <h3>Sarah Johnson</h3>
                    <p class="member-role">Chief Learning Officer</p>
                    <p class="member-bio">Former university professor with expertise in online pedagogy and curriculum design.</p>
                    <div class="member-social">
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="team-member">
                    <div class="member-image">
                        <img src="/api/placeholder/200/200" alt="Team Member">
                    </div>
                    <h3>David Okafor</h3>
                    <p class="member-role">Head of Partnerships</p>
                    <p class="member-bio">Builds relationships with top companies and instructors to bring quality content to our platform.</p>
                    <div class="member-social">
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Achievement Section -->
        <section class="achievements">
            <h2>Our Impact</h2>
            <div class="achievements-container">
                <div class="achievement-card">
                    <div class="achievement-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="achievement-count">2M+</div>
                    <div class="achievement-title">Learners</div>
                </div>
                <div class="achievement-card">
                    <div class="achievement-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="achievement-count">5,000+</div>
                    <div class="achievement-title">Courses</div>
                </div>
                <div class="achievement-card">
                    <div class="achievement-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="achievement-count">1,200+</div>
                    <div class="achievement-title">Expert Instructors</div>
                </div>
                <div class="achievement-card">
                    <div class="achievement-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <div class="achievement-count">150+</div>
                    <div class="achievement-title">Countries</div>
                </div>
            </div>
        </section>

        <!-- Partners Section -->
        <section class="partners">
            <h2>Our Partners</h2>
            <p>We collaborate with leading companies and institutions to provide cutting-edge curriculum and career opportunities.</p>
            <div class="partners-logos">
                <div class="partner-logo">
                    <img src="/api/placeholder/150/80" alt="Partner Logo">
                </div>
                <div class="partner-logo">
                    <img src="/api/placeholder/150/80" alt="Partner Logo">
                </div>
                <div class="partner-logo">
                    <img src="/api/placeholder/150/80" alt="Partner Logo">
                </div>
                <div class="partner-logo">
                    <img src="/api/placeholder/150/80" alt="Partner Logo">
                </div>
                <div class="partner-logo">
                    <img src="/api/placeholder/150/80" alt="Partner Logo">
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta">
            <div class="cta-content">
                <h2>Join Our Learning Community</h2>
                <p>Start your learning journey today and transform your career.</p>
                <button class="btn primary-btn">Get Started</button>
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
                            <li><a href="./about.html">About Us</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Press</a></li>
                            <li><a href="#">Blog</a></li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <h3>Learn</h3>
                        <ul>
                            <li><a href="./courses.php">Courses</a></li>
                            <li><a href="#">Tutorials</a></li>
                            <li><a href="#">Resources</a></li>
                            <li><a href="#">Webinars</a></li>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <h3>Support</h3>
                        <ul>
                            <li><a href="#">Help Center</a></li>
                            <li><a href="./contact.html">Contact Us</a></li>
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