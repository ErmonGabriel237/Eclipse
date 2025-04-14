<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - LearnHub E-Learning Platform</title>
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
                <li><a href="./courses.php" class="active">Courses</a></li>
                <li><a href="./about.php">About</a></li>
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

        <!-- Courses Header -->
        <section class="courses-header">
            <div class="courses-header-content">
                <h1 class="animate__animated animate__fadeInUp">Expand Your Knowledge</h1>
                <p class="animate__animated animate__fadeInUp animate__delay-1s">
                    Browse our extensive collection of courses taught by industry experts.
                    Find the perfect course to achieve your learning goals.
                </p>
            </div>
        </section>

        <!-- Courses Filter -->
        <section class="courses-filter">
            <div class="filter-container">
                <div class="search-filter">
                    <input type="text" placeholder="Search courses..." id="course-search">
                    <button class="search-btn"><i class="fas fa-search"></i></button>
                </div>
                <div class="category-filter">
                    <select id="category-select">
                        <option value="all">All Categories</option>
                        <option value="development">Development</option>
                        <option value="design">Design</option>
                        <option value="business">Business</option>
                        <option value="marketing">Marketing</option>
                        <option value="it-software">IT & Software</option>
                        <option value="data-science">Data Science</option>
                        <option value="personal-dev">Personal Development</option>
                    </select>
                </div>
                <div class="price-filter">
                    <select id="price-select">
                        <option value="all">All Prices</option>
                        <option value="free">Free</option>
                        <option value="paid">Paid</option>
                        <option value="under-50">Under $50</option>
                        <option value="50-100">$50 - $100</option>
                        <option value="over-100">Over $100</option>
                    </select>
                </div>
                <div class="level-filter">
                    <select id="level-select">
                        <option value="all">All Levels</option>
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                    </select>
                </div>
                <button class="btn filter-btn">Apply Filters</button>
            </div>
        </section>

        <!-- Featured Courses -->
        <section class="featured-courses">
            <h2>Featured Courses</h2>
            <div class="courses-container">
                <div class="course-card featured">
                    <div class="course-image">
                        <img src="/api/placeholder/300/200" alt="AWS Cloud Computing">
                        <div class="course-badge">Featured</div>
                    </div>
                    <div class="course-content">
                        <div class="course-category">IT & Software</div>
                        <h3>AWS Certified Cloud Practitioner</h3>
                        <div class="course-details">
                            <div class="course-level">
                                <i class="fas fa-signal"></i> Beginner
                            </div>
                            <div class="course-duration">
                                <i class="far fa-clock"></i> 12 hours
                            </div>
                            <div class="course-lectures">
                                <i class="fas fa-book-open"></i> 24 lectures
                            </div>
                        </div>
                        <div class="course-info">
                            <div class="course-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>4.7 (3.2k reviews)</span>
                            </div>
                            <div class="course-price">$119.99</div>
                        </div>
                    </div>
                    <a href="#" class="course-link"></a>
                </div>
            </div>
        </section>

        <!-- All Courses -->
        <section class="all-courses">
            <h2>All Courses</h2>
            <div class="courses-container">
                <div class="course-card">
                    <div class="course-image">
                        <img src="/api/placeholder/300/200" alt="Web Development">
                        <div class="course-badge">Bestseller</div>
                    </div>
                    <div class="course-content">
                        <div class="course-category">Development</div>
                        <h3>Complete Web Development Bootcamp</h3>
                        <div class="course-details">
                            <div class="course-level">
                                <i class="fas fa-signal"></i> All Levels
                            </div>
                            <div class="course-duration">
                                <i class="far fa-clock"></i> 65 hours
                            </div>
                            <div class="course-lectures">
                                <i class="fas fa-book-open"></i> 115 lectures
                            </div>
                        </div>
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
                    <a href="#" class="course-link"></a>
                </div>
                <div class="course-card">
                    <div class="course-image">
                        <img src="/api/placeholder/300/200" alt="Data Science">
                    </div>
                    <div class="course-content">
                        <div class="course-category">Data Science</div>
                        <h3>Data Science & Machine Learning</h3>
                        <div class="course-details">
                            <div class="course-level">
                                <i class="fas fa-signal"></i> Intermediate
                            </div>
                            <div class="course-duration">
                                <i class="far fa-clock"></i> 48 hours
                            </div>
                            <div class="course-lectures">
                                <i class="fas fa-book-open"></i> 87 lectures
                            </div>
                        </div>
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
                    <a href="#" class="course-link"></a>
                </div>
                <div class="course-card">
                    <div class="course-image">
                        <img src="/api/placeholder/300/200" alt="Digital Marketing">
                        <div class="course-badge">New</div>
                    </div>
                    <div class="course-content">
                        <div class="course-category">Marketing</div>
                        <h3>Digital Marketing Masterclass</h3>
                        <div class="course-details">
                            <div class="course-level">
                                <i class="fas fa-signal"></i> Beginner
                            </div>
                            <div class="course-duration">
                                <i class="far fa-clock"></i> 32 hours
                            </div>
                            <div class="course-lectures">
                                <i class="fas fa-book-open"></i> 56 lectures
                            </div>
                        </div>
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
                    <a href="#" class="course-link"></a>
                </div>
                <div class="course-card">
                    <div class="course-image">
                        <img src="/api/placeholder/300/200" alt="UX Design">
                    </div>
                    <div class="course-content">
                        <div class="course-category">Design</div>
                        <h3>UX/UI Design: From Beginner to Expert</h3>
                        <div class="course-details">
                            <div class="course-level">
                                <i class="fas fa-signal"></i> All Levels
                            </div>
                            <div class="course-duration">
                                <i class="far fa-clock"></i> 40 hours
                            </div>
                            <div class="course-lectures">
                                <i class="fas fa-book-open"></i> 72 lectures
                            </div>
                        </div>
                        <div class="course-info">
                            <div class="course-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span>4.7 (1.5k reviews)</span>
                            </div>
                            <div class="course-price">$94.99</div>
                        </div>
                    </div>
                    <a href="#" class="course-link"></a>
                </div>
                <div class="course-card">
                    <div class="course-image">
                        <img src="/api/placeholder/300/200" alt="Business">
                    </div>
                    <div class="course-content">
                        <div class="course-category">Business</div>
                        <h3>The Complete Business Plan Course</h3>
                        <div class="course-details">
                            <div class="course-level">
                                <i class="fas fa-signal"></i> Intermediate
                            </div>
                            <div class="course-duration">
                                <i class="far fa-clock"></i> 24 hours
                            </div>
                            <div class="course-lectures">
                                <i class="fas fa-book-open"></i> 45 lectures
                            </div>
                        </div>
                        <div class="course-info">
                            <div class="course-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span>4.3 (750 reviews)</span>
                            </div>
                            <div class="course-price">$69.99</div>
                        </div>
                    </div>
                    <a href="#" class="course-link"></a>
                </div>
                <div class="course-card">
                    <div class="course-image">
                        <img src="/api/placeholder/300/200" alt="Python Programming">
                    </div>
                    <div class="course-content">
                        <div class="course-category">Development</div>
                        <h3>Python Programming: Zero to Hero</h3>
                        <div class="course-details">
                            <div class="course-level">
                                <i class="fas fa-signal"></i> Beginner
                            </div>
                            <div class="course-duration">
                                <i class="far fa-clock"></i> 38 hours
                            </div>
                            <div class="course-lectures">
                                <i class="fas fa-book-open"></i> 64 lectures
                            </div>
                        </div>
                        <div class="course-info">
                            <div class="course-rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span>4.9 (3.6k reviews)</span>
                            </div>
                            <div class="course-price">$84.99</div>
                        </div>
                    </div>
                    <a href="#" class="course-link"></a>
                </div>
            </div>
            <div class="pagination">
                <a href="#" class="pagination-item active">1</a>
                <a href="#" class="pagination-item">2</a>
                <a href="#" class="pagination-item">3</a>
                <a href="#" class="pagination-item">4</a>
                <a href="#" class="pagination-item">5</a>
                <a href="#" class="pagination-item">...</a>
                <a href="#" class="pagination-item">Next <i class="fas fa-chevron-right"></i></a>
            </div>
        </section>

        <!-- Course Categories -->
        <section class="course-categories">
            <h2>Browse By Category</h2>
            <div class="categories-container">
                <a href="#" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-code"></i>
                    </div>
                    <h3>Development</h3>
                    <p>450+ Courses</p>
                </a>
                <a href="#" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-paint-brush"></i>
                    </div>
                    <h3>Design</h3>
                    <p>320+ Courses</p>
                </a>
                <a href="#" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Business</h3>
                    <p>380+ Courses</p>
                </a>
                <a href="#" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h3>Marketing</h3>
                    <p>290+ Courses</p>
                </a>
                <a href="#" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-server"></i>
                    </div>
                    <h3>IT & Software</h3>
                    <p>410+ Courses</p>
                </a>
                <a href="#" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <h3>Data Science</h3>
                    <p>220+ Courses</p>
                </a>
                <a href="#" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3>Personal Development</h3>
                    <p>350+ Courses</p>
                </a>
                <a href="#" class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-language"></i>
                    </div>
                    <h3>Languages</h3>
                    <p>180+ Courses</p>
                </a>
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
    <script src="./assets/js/courses.js"></script>
</body>
</html>