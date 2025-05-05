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
    <title>LearnHub - Courses</title>
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
        <div class="loader-text">Loading Courses...</div>
    </div>

    <!-- Main Content -->
    <div id="content" style="display: none;">
        <!-- Navigation -->
        <nav class="nav-glass">
            <div class="logo">
                <h1><span class="gradient-text">Learn</span>Hub</h1>
            </div>
            <ul class="nav-links">
                <li><a href="./index.php">Home</a></li>
                <li><a href="./courses.php" class="active">Courses</a></li>
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
                    <a href="app/dashboards/dashboard.php" class="btn dashboard-btn glass-effect">
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

        <!-- Courses Header -->
        <section class="courses-header gradient-bg">
            <div class="courses-header-content" data-aos="fade-up">
                <h1 class="gradient-text">Explore Our Courses</h1>
                <p>Discover thousands of courses to start or advance your career, pursue a passion, or expand your knowledge.</p>
                <div class="search-container glass-effect">
                    <input type="text" id="course-search" class="glass-input" placeholder="Search for courses...">
                    <button class="search-btn gradient-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </section>

        <!-- Filters Section -->
        <section class="filters-section">
            <div class="filters-container glass-effect" data-aos="fade-up">
                <div class="filter-group">
                    <label for="category-filter">Category</label>
                    <select id="category-filter" class="glass-input">
                        <option value="all">All Categories</option>
                        <option value="programming">Programming</option>
                        <option value="design">Design</option>
                        <option value="business">Business</option>
                        <option value="marketing">Marketing</option>
                        <option value="data-science">Data Science</option>
                        <option value="ai-ml">AI & Machine Learning</option>
                        <option value="photography">Photography</option>
                        <option value="music">Music</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="level-filter">Level</label>
                    <select id="level-filter" class="glass-input">
                        <option value="all">All Levels</option>
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="price-filter">Price</label>
                    <select id="price-filter" class="glass-input">
                        <option value="all">All Prices</option>
                        <option value="free">Free</option>
                        <option value="paid">Paid</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="sort-filter">Sort By</label>
                    <select id="sort-filter" class="glass-input">
                        <option value="popular">Most Popular</option>
                        <option value="newest">Newest</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                        <option value="rating">Highest Rated</option>
                    </select>
                </div>
                <button class="btn reset-filter-btn glass-effect">
                    <i class="fas fa-redo-alt"></i> Reset Filters
                </button>
            </div>
        </section>

        <!-- Course Categories -->
        <section class="course-categories">
            <h2 class="section-title gradient-text" data-aos="fade-up">Browse Categories</h2>
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
                <div class="category-card glass-effect" data-aos="zoom-in" data-aos-delay="400">
                    <i class="fas fa-bullhorn"></i>
                    <h3>Marketing</h3>
                    <span>120+ Courses</span>
                </div>
                <div class="category-card glass-effect" data-aos="zoom-in" data-aos-delay="500">
                    <i class="fas fa-database"></i>
                    <h3>Data Science</h3>
                    <span>80+ Courses</span>
                </div>
                <div class="category-card glass-effect" data-aos="zoom-in" data-aos-delay="600">
                    <i class="fas fa-brain"></i>
                    <h3>AI & Machine Learning</h3>
                    <span>90+ Courses</span>
                </div>
                <div class="category-card glass-effect" data-aos="zoom-in" data-aos-delay="700">
                    <i class="fas fa-camera"></i>
                    <h3>Photography</h3>
                    <span>70+ Courses</span>
                </div>
                <div class="category-card glass-effect" data-aos="zoom-in" data-aos-delay="800">
                    <i class="fas fa-music"></i>
                    <h3>Music</h3>
                    <span>60+ Courses</span>
                </div>
            </div>
        </section>

        <!-- Featured Courses -->
        <section class="featured-courses gradient-bg">
            <h2 class="section-title" data-aos="fade-up">Featured Courses</h2>
            <div class="swiper featured-courses-slider">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="course-card glass-effect">
                            <div class="course-image">
                                <img src="https://via.placeholder.com/300x200" alt="Web Development">
                                <div class="course-overlay">
                                    <span class="course-badge">Featured</span>
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
                    <div class="swiper-slide">
                        <div class="course-card glass-effect">
                            <div class="course-image">
                                <img src="https://via.placeholder.com/300x200" alt="UI/UX Design">
                                <div class="course-overlay">
                                    <span class="course-badge">Featured</span>
                                </div>
                            </div>
                            <div class="course-content">
                                <div class="course-category">Design</div>
                                <h3>Complete UI/UX Design Masterclass</h3>
                                <div class="course-meta">
                                    <div class="course-rating">
                                        <i class="fas fa-star"></i>
                                        <span>4.9 (1.8k reviews)</span>
                                    </div>
                                    <div class="course-students">
                                        <i class="fas fa-users"></i>
                                        <span>12,500+ students</span>
                                    </div>
                                </div>
                                <div class="course-price">
                                    <span class="price">$94.99</span>
                                    <button class="btn course-btn">Learn More</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="course-card glass-effect">
                            <div class="course-image">
                                <img src="https://via.placeholder.com/300x200" alt="Machine Learning">
                                <div class="course-overlay">
                                    <span class="course-badge">Featured</span>
                                </div>
                            </div>
                            <div class="course-content">
                                <div class="course-category">AI & ML</div>
                                <h3>Machine Learning A-Z: Hands-On Python</h3>
                                <div class="course-meta">
                                    <div class="course-rating">
                                        <i class="fas fa-star"></i>
                                        <span>4.7 (3.2k reviews)</span>
                                    </div>
                                    <div class="course-students">
                                        <i class="fas fa-users"></i>
                                        <span>20,000+ students</span>
                                    </div>
                                </div>
                                <div class="course-price">
                                    <span class="price">$99.99</span>
                                    <button class="btn course-btn">Learn More</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </section>

        <!-- All Courses -->
        <section class="all-courses">
            <div class="courses-header-row">
                <h2 class="section-title gradient-text" data-aos="fade-up">All Courses</h2>
                <div class="courses-count">Showing <span id="courses-count">12</span> courses</div>
            </div>
            
            <div class="courses-grid">
                <!-- Course Card 1 -->
                <div class="course-card glass-effect" data-aos="fade-up">
                    <div class="course-image">
                        <img src="https://via.placeholder.com/300x200" alt="Web Development">
                        <div class="course-overlay">
                            <span class="course-badge">Bestseller</span>
                        </div>
                    </div>
                    <div class="course-content">
                        <div class="course-category">Development</div>
                        <h3>Advanced Web Development Bootcamp</h3>
                        <p class="course-instructor">By John Doe</p>
                        <div class="course-meta">
                            <div class="course-rating">
                                <i class="fas fa-star"></i>
                                <span>4.8 (2.4k reviews)</span>
                            </div>
                            <div class="course-level">
                                <i class="fas fa-signal"></i>
                                <span>Advanced</span>
                            </div>
                        </div>
                        <div class="course-details">
                            <div class="detail-item">
                                <i class="fas fa-clock"></i>
                                <span>42 hours</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-video"></i>
                                <span>84 lectures</span>
                            </div>
                        </div>
                        <div class="course-price">
                            <span class="price">$89.99</span>
                            <button class="btn course-btn">Learn More</button>
                        </div>
                    </div>
                </div>

                <!-- Course Card 2 -->
                <div class="course-card glass-effect" data-aos="fade-up" data-aos-delay="100">
                    <div class="course-image">
                        <img src="https://via.placeholder.com/300x200" alt="UI/UX Design">
                        <div class="course-overlay">
                            <span class="course-badge">Hot</span>
                        </div>
                    </div>
                    <div class="course-content">
                        <div class="course-category">Design</div>
                        <h3>Complete UI/UX Design Masterclass</h3>
                        <p class="course-instructor">By Jane Smith</p>
                        <div class="course-meta">
                            <div class="course-rating">
                                <i class="fas fa-star"></i>
                                <span>4.9 (1.8k reviews)</span>
                            </div>
                            <div class="course-level">
                                <i class="fas fa-signal"></i>
                                <span>All Levels</span>
                            </div>
                        </div>
                        <div class="course-details">
                            <div class="detail-item">
                                <i class="fas fa-clock"></i>
                                <span>32 hours</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-video"></i>
                                <span>65 lectures</span>
                            </div>
                        </div>
                        <div class="course-price">
                            <span class="price">$94.99</span>
                            <button class="btn course-btn">Learn More</button>
                        </div>
                    </div>
                </div>

                <!-- Course Card 3 -->
                <div class="course-card glass-effect" data-aos="fade-up" data-aos-delay="200">
                    <div class="course-image">
                        <img src="https://via.placeholder.com/300x200" alt="Machine Learning">
                        <div class="course-overlay">
                            <span class="course-badge">New</span>
                        </div>
                    </div>
                    <div class="course-content">
                        <div class="course-category">AI & ML</div>
                        <h3>Machine Learning A-Z: Hands-On Python</h3>
                        <p class="course-instructor">By Robert Johnson</p>
                        <div class="course-meta">
                            <div class="course-rating">
                                <i class="fas fa-star"></i>
                                <span>4.7 (3.2k reviews)</span>
                            </div>
                            <div class="course-level">
                                <i class="fas fa-signal"></i>
                                <span>Intermediate</span>
                            </div>
                        </div>
                        <div class="course-details">
                            <div class="detail-item">
                                <i class="fas fa-clock"></i>
                                <span>38 hours</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-video"></i>
                                <span>72 lectures</span>
                            </div>
                        </div>
                        <div class="course-price">
                            <span class="price">$99.99</span>
                            <button class="btn course-btn">Learn More</button>
                        </div>
                    </div>
                </div>

                <!-- Course Card 4 -->
                <div class="course-card glass-effect" data-aos="fade-up" data-aos-delay="300">
                    <div class="course-image">
                        <img src="https://via.placeholder.com/300x200" alt="Digital Marketing">
                        <div class="course-overlay">
                            <span class="course-badge">Popular</span>
                        </div>
                    </div>
                    <div class="course-content">
                        <div class="course-category">Marketing</div>
                        <h3>Complete Digital Marketing Course</h3>
                        <p class="course-instructor">By Emily Wilson</p>
                        <div class="course-meta">
                            <div class="course-rating">
                                <i class="fas fa-star"></i>
                                <span>4.6 (1.5k reviews)</span>
                            </div>
                            <div class="course-level">
                                <i class="fas fa-signal"></i>
                                <span>Beginner</span>
                            </div>
                        </div>
                        <div class="course-details">
                            <div class="detail-item">
                                <i class="fas fa-clock"></i>
                                <span>28 hours</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-video"></i>
                                <span>56 lectures</span>
                            </div>
                        </div>
                        <div class="course-price">
                            <span class="price">$84.99</span>
                            <button class="btn course-btn">Learn More</button>
                        </div>
                    </div>
                </div>

                <!-- Course Card 5 -->
                <div class="course-card glass-effect" data-aos="fade-up">
                    <div class="course-image">
                        <img src="https://via.placeholder.com/300x200" alt="Data Science">
                        <div class="course-overlay">
                            <span class="course-badge">Trending</span>
                        </div>
                    </div>
                    <div class="course-content">
                        <div class="course-category">Data Science</div>
                        <h3>Data Science Bootcamp: Python & R</h3>
                        <p class="course-instructor">By Michael Brown</p>
                        <div class="course-meta">
                            <div class="course-rating">
                                <i class="fas fa-star"></i>
                                <span>4.8 (2.1k reviews)</span>
                            </div>
                            <div class="course-level">
                                <i class="fas fa-signal"></i>
                                <span>Intermediate</span>
                            </div>
                        </div>
                        <div class="course-details">
                            <div class="detail-item">
                                <i class="fas fa-clock"></i>
                                <span>45 hours</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-video"></i>
                                <span>90 lectures</span>
                            </div>
                        </div>
                        <div class="course-price">
                            <span class="price">$94.99</span>
                            <button class="btn course-btn">Learn More</button>
                        </div>
                    </div>
                </div>

                <!-- Course Card 6 -->
                <div class="course-card glass-effect" data-aos="fade-up" data-aos-delay="100">
                    <div class="course-image">
                        <img src="https://via.placeholder.com/300x200" alt="Photography">
                        <div class="course-overlay">
                            <span class="course-badge">Beginner</span>
                        </div>
                    </div>
                    <div class="course-content">
                        <div class="course-category">Photography</div>
                        <h3>Photography Masterclass: Complete Guide</h3>
                        <p class="course-instructor">By Sarah Taylor</p>
                        <div class="course-meta">
                            <div class="course-rating">
                                <i class="fas fa-star"></i>
                                <span>4.7 (1.3k reviews)</span>
                            </div>
                            <div class="course-level">
                                <i class="fas fa-signal"></i>
                                <span>All Levels</span>
                            </div>
                        </div>
                        <div class="course-details">
                            <div class="detail-item">
                                <i class="fas fa-clock"></i>
                                <span>22 hours</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-video"></i>
                                <span>45 lectures</span>
                            </div>
                        </div>
                        <div class="course-price">
                            <span class="price">$79.99</span>
                            <button class="btn course-btn">Learn More</button>
                        </div>
                    </div>
                </div>

                <!-- Course Card 7 -->
                <div class="course-card glass-effect" data-aos="fade-up" data-aos-delay="200">
                    <div class="course-image">
                        <img src="https://via.placeholder.com/300x200" alt="Music Production">
                        <div class="course-overlay">
                            <span class="course-badge free">Free</span>
                        </div>
                    </div>
                    <div class="course-content">
                        <div class="course-category">Music</div>
                        <h3>Introduction to Music Production</h3>
                        <p class="course-instructor">By David Miller</p>
                        <div class="course-meta">
                            <div class="course-rating">
                                <i class="fas fa-star"></i>
                                <span>4.5 (980 reviews)</span>
                            </div>
                            <div class="course-level">
                                <i class="fas fa-signal"></i>
                                <span>Beginner</span>
                            </div>
                        </div>
                        <div class="course-details">
                            <div class="detail-item">
                                <i class="fas fa-clock"></i>
                                <span>12 hours</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-video"></i>
                                <span>28 lectures</span>
                            </div>
                        </div>
                        <div class="course-price">
                            <span class="price free-course">Free</span>
                            <button class="btn course-btn">Enroll Now</button>
                        </div>
                    </div>
                </div>

                <!-- Course Card 8 -->
                <div class="course-card glass-effect" data-aos="fade-up" data-aos-delay="300">
                    <div class="course-image">
                        <img src="https://via.placeholder.com/300x200" alt="Business">
                        <div class="course-overlay">
                            <span class="course-badge">Popular</span>
                        </div>
                    </div>
                    <div class="course-content">
                        <div class="course-category">Business</div>
                        <h3>MBA: Business Strategy Masterclass</h3>
                        <p class="course-instructor">By Christopher Lee</p>
                        <div class="course-meta">
                            <div class="course-rating">
                                <i class="fas fa-star"></i>
                                <span>4.9 (2.7k reviews)</span>
                            </div>
                            <div class="course-level">
                                <i class="fas fa-signal"></i>
                                <span>Advanced</span>
                            </div>
                        </div>
                        <div class="course-details">
                            <div class="detail-item">
                                <i class="fas fa-clock"></i>
                                <span>36 hours</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-video"></i>
                                <span>68 lectures</span>
                            </div>
                        </div>
                        <div class="course-price">
                            <span class="old-price">$129.99</span>
                            <span class="price">$99.99</span>
                            <button class="btn course-btn">Learn More</button>
                        </div>
                    </div>
                </div>

                <!-- Course Card 9 -->
                <div class="course-card glass-effect" data-aos="fade-up">
                    <div class="course-image">
                        <img src="https://via.placeholder.com/300x200" alt="Mobile Development">
                        <div class="course-overlay">
                            <span class="course-badge">New</span>
                        </div>
                    </div>
                    <div class="course-content">
                        <div class="course-category">Development</div>
                        <h3>Flutter & Dart: Complete App Development</h3>
                        <p class="course-instructor">By James Wilson</p>
                        <div class="course-meta">
                            <div class="course-rating">
                                <i class="fas fa-star"></i>
                                <span>4.8 (1.2k reviews)</span>
                            </div>
                            <div class="course-level">
                                <i class="fas fa-signal"></i>
                                <span>Intermediate</span>
                            </div>
                        </div>
                        <div class="course-details">
                            <div class="detail-item">
                                <i class="fas fa-clock"></i>
                                <span>30 hours</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-video"></i>
                                <span>62 lectures</span>
                            </div>
                        </div>
                        <div class="course-price">
                            <span class="price">$89.99</span>
                            <button class="btn course-btn">Learn More</button>
                        </div>
                    </div>
                </div>

                <!-- Course Card 10 -->
                <div class="course-card glass-effect" data-aos="fade-up" data-aos-delay="100">
                    <div class="course-image">
                        <img src="https://via.placeholder.com/300x200" alt="Graphic Design">
                        <div class="course-overlay">
                            <span class="course-badge">Popular</span>
                        </div>
                    </div>
                    <div class="course-content">
                        <div class="course-category">Design</div>
                        <h3>Graphic Design Masterclass</h3>
                        <p class="course-instructor">By Lisa Thompson</p>
                        <div class="course-meta">
                            <div class="course-rating">
                                <i class="fas fa-star"></i>
                                <span>4.7 (1.5k reviews)</span>
                            </div>
                            <div class="course-level">
                                <i class="fas fa-signal"></i>
                                <span>All Levels</span>
                            </div>
                        </div>
                        <div class="course-details">
                            <div class="detail-item">
                                <i class="fas fa-clock"></i>
                                <span>25 hours</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-video"></i>
                                <span>50 lectures</span>
                            </div>
                        </div>
                        <div class="course-price">
                            <span class="price">$84.99</span>
                            <button class="btn course-btn">Learn More</button>
                        </div>
                    </div>
                </div>

                <!-- Course Card 11 -->
                <div class="course-card glass-effect" data-aos="fade-up" data-aos-delay="200">
                    <div class="course-image">
                        <img src="https://via.placeholder.com/300x200" alt="Cybersecurity">
                        <div class="course-overlay">
                            <span class="course-badge">Bestseller</span>
                        </div>
                    </div>
                    <div class="course-content">
                        <div class="course-category">Security</div>
                        <h3>Complete Cybersecurity Course</h3>
                        <p class="course-instructor">By Mark Johnson</p>
                        <div class="course-meta">
                            <div class="course-rating">
                                <i class="fas fa-star"></i>
                                <span>4.9 (2.3k reviews)</span>
                            </div>
                            <div class="course-level">
                                <i class="fas fa-signal"></i>
                                <span>Advanced</span>
                            </div>
                        </div>
                        <div class="course-details">
                            <div class="detail-item">
                                <i class="fas fa-clock"></i>
                                <span>40 hours</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-video"></i>
                                <span>80 lectures</span>
                            </div>
                        </div>
                        <div class="course-price">
                            <span class="price">$109.99</span>
                            <button class="btn course-btn">Learn More</button>
                        </div>
                    </div>
                </div>

                <!-- Course Card 12 -->
                <div class="course-card glass-effect" data-aos="fade-up" data-aos-delay="300">
                    <div class="course-image">
                        <img src="https://via.placeholder.com/300x200" alt="Python">
                        <div class="course-overlay">
                            <span class="course-badge free">Free</span>
                        </div>
                    </div>
                    <div class="course-content">
                        <div class="course-category">Programming</div>
                        <h3>Python for Beginners</h3>
                        <p class="course-instructor">By Alex Parker</p>
                        <div class="course-meta">
                            <div class="course-rating">
                                <i class="fas fa-star"></i>
                                <span>4.6 (3.5k reviews)</span>
                            </div>
                            <div class="course-level">
                                <i class="fas fa-signal"></i>
                                <span>Beginner</span>
                            </div>
                        </div>
                        <div class="course-details">
                            <div class="detail-item">
                                <i class="fas fa-clock"></i>
                                <span>15 hours</span>
                            </div>
                            <div class="detail-item">
                                <i class="fas fa-video"></i>
                                <span>30 lectures</span>
                            </div>
                        </div>
                        <div class="course-price">
                            <span class="price free-course">Free</span>
                            <button class="btn course-btn">Enroll Now</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="pagination" data-aos="fade-up">
                <button class="btn pagination-btn glass-effect"><i class="fas fa-chevron-left"></i></button>
                <button class="btn pagination-btn active glass-effect">1</button>
                <button class="btn pagination-btn glass-effect">2</button>
                <button class="btn pagination-btn glass-effect">3</button>
                <button class="btn pagination-btn glass-effect">4</button>
                <button class="btn pagination-btn glass-effect"><i class="fas fa-chevron-right"></i></button>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="cta-section gradient-bg">
            <div class="cta-container" data-aos="fade-up">
                <h2>Ready to start learning?</h2>
                <p>Join thousands of students worldwide who are already learning with LearnHub.</p>
                <?php if (!$isLoggedIn) : ?>
                    <button class="btn cta-btn gradient-btn">Sign Up Now</button>
                <?php else: ?>
                    <button class="btn cta-btn gradient-btn">Browse More Courses</button>
                <?php endif; ?>
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
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="./assets/js/course.js"></script>
