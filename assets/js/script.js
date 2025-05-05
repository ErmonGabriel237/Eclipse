// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Preloader functionality
    const preloader = document.getElementById('preloader');
    const content = document.getElementById('content');

    // Show content and hide preloader after 2 seconds
    setTimeout(() => {
        preloader.style.opacity = '0';
        setTimeout(() => {
            preloader.style.display = 'none';
            content.style.display = 'block';
            // Trigger fade-in animation for content
            setTimeout(() => {
                content.style.opacity = '1';
            }, 50);
        }, 500);
    }, 2000);

    // Initialize AOS animation library
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        mirror: false
    });

    // Mobile Navigation Toggle
    const burger = document.querySelector('.burger');
    const navLinks = document.querySelector('.nav-links');
    const authButtons = document.querySelector('.auth-buttons');

    if (burger) {
        burger.addEventListener('click', () => {
            // Toggle Nav
            navLinks.classList.toggle('nav-active');
            authButtons.classList.toggle('nav-active');
            
            // Animate Links
            const links = document.querySelectorAll('.nav-links li');
            links.forEach((link, index) => {
                if (link.style.animation) {
                    link.style.animation = '';
                } else {
                    link.style.animation = `navLinkFade 0.5s ease forwards ${index / 7 + 0.3}s`;
                }
            });
            
            // Burger Animation
            burger.classList.toggle('toggle');
        });
    }

    // Initialize Swiper sliders
    // Courses Slider
    const coursesSlider = new Swiper('.courses-slider', {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        pagination: {
            el: '.courses-slider .swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.courses-slider .swiper-button-next',
            prevEl: '.courses-slider .swiper-button-prev',
        },
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 40,
            },
        }
    });

    // Testimonials Slider
    const testimonialsSlider = new Swiper('.testimonials-slider', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: '.testimonials-slider .swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 6000,
            disableOnInteraction: false,
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 40,
            },
        }
    });

    // Scroll to top button functionality
    const scrollToTopBtn = document.getElementById('scrollToTop');
    
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            scrollToTopBtn.classList.add('show');
        } else {
            scrollToTopBtn.classList.remove('show');
        }
    });
    
    scrollToTopBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Modal functionality for login/signup
    const loginBtn = document.querySelector('.login-btn');
    const signupBtn = document.querySelector('.signup-btn');
    
    if (loginBtn) {
        loginBtn.addEventListener('click', () => {
            // Redirect to login page or show login modal
            window.location.href = './app/logs/login.php';
        });
    }
    
    if (signupBtn) {
        signupBtn.addEventListener('click', () => {
            // Redirect to signup page or show signup modal
            window.location.href = './app/logs/register.php';
        });
    }

    // Explore Courses button functionality
    const exploreCourseBtn = document.querySelector('.primary-btn');
    if (exploreCourseBtn) {
        exploreCourseBtn.addEventListener('click', () => {
            window.location.href = './courses.php';
        });
    }

    // Watch Demo button functionality
    const watchDemoBtn = document.querySelector('.secondary-btn');
    if (watchDemoBtn) {
        watchDemoBtn.addEventListener('click', () => {
            // Here you could show a video modal or redirect to a demo page
            // For now, let's create an alert
            alert('Demo video coming soon!');
        });
    }

    // Add scroll effect to navigation
    window.addEventListener('scroll', () => {
        const nav = document.querySelector('nav');
        if (window.scrollY > 50) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    });

    // Newsletter form submission
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const emailInput = newsletterForm.querySelector('input[type="email"]');
            const email = emailInput.value;
            
            // Here you would typically send this to your server
            // For now, let's simulate a successful subscription
            emailInput.value = '';
            alert(`Thank you for subscribing with ${email}! You'll receive our updates soon.`);
        });
    }

    // Add hover effects to course cards for better interaction
    const courseCards = document.querySelectorAll('.course-card');
    courseCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.classList.add('hover');
        });
        
        card.addEventListener('mouseleave', () => {
            card.classList.remove('hover');
        });
    });

    // Add click event to course cards
    const courseButtons = document.querySelectorAll('.course-btn');
    courseButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const courseId = button.getAttribute('data-id') || '1';
            window.location.href = `./course-details.php?id=${courseId}`;
        });
    });

    // User profile dropdown functionality
    const profileBtn = document.querySelector('.profile-btn');
    if (profileBtn) {
        const dropdown = document.createElement('div');
        dropdown.className = 'profile-dropdown glass-effect';
        dropdown.innerHTML = `
            <ul>
                <li><a href="./app/dashboards/profile.php"><i class="fas fa-user-circle"></i> My Profile</a></li>
                <li><a href="./app/dashboards/my-courses.php"><i class="fas fa-book-open"></i> My Courses</a></li>
                <li><a href="./app/dashboards/settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                <li><a href="./auth/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        `;
        dropdown.style.display = 'none';
        
        const userProfile = document.querySelector('.user-profile');
        if (userProfile) {
            userProfile.appendChild(dropdown);
            
            profileBtn.addEventListener('click', () => {
                if (dropdown.style.display === 'none') {
                    dropdown.style.display = 'block';
                } else {
                    dropdown.style.display = 'none';
                }
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!userProfile.contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });
        }
    }

    // Add CSS animation for floating cards
    const floatingCards = document.querySelectorAll('.floating-cards .course-card-mini');
    floatingCards.forEach((card, index) => {
        card.style.animation = `float ${2 + index * 0.5}s ease-in-out infinite alternate`;
    });
});

// Add CSS styles programmatically for some animations
const style = document.createElement('style');
style.textContent = `
    @keyframes float {
        0% {
            transform: translateY(0px);
        }
        100% {
            transform: translateY(-15px);
        }
    }
    
    @keyframes navLinkFade {
        from {
            opacity: 0;
            transform: translateX(50px);
        }
        to {
            opacity: 1;
            transform: translateX(0px);
        }
    }
    
    #content {
        opacity: 0;
        transition: opacity 0.5s ease;
    }
    
    #preloader {
        transition: opacity 0.5s ease;
    }
    
    .scroll-top-btn {
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    
    .scroll-top-btn.show {
        opacity: 1;
        visibility: visible;
    }
    
    nav.scrolled {
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(20px);
    }
    
    .course-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .course-card.hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .profile-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        width: 200px;
        margin-top: 10px;
        padding: 10px 0;
        border-radius: 10px;
        z-index: 100;
        animation: fadeIn 0.3s ease;
    }
    
    .profile-dropdown ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .profile-dropdown ul li {
        padding: 0;
    }
    
    .profile-dropdown ul li a {
        display: flex;
        align-items: center;
        padding: 10px 20px;
        color: var(--text-color);
        text-decoration: none;
        transition: background-color 0.2s ease;
    }
    
    .profile-dropdown ul li a:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }
    
    .profile-dropdown ul li a i {
        margin-right: 10px;
        width: 16px;
        text-align: center;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
document.head.appendChild(style);