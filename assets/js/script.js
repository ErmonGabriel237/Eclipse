// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Loader functionality
    setTimeout(function() {
        document.getElementById('loader').style.opacity = '0';
        document.getElementById('content').style.display = 'block';
        setTimeout(function() {
            document.getElementById('loader').style.display = 'none';
            document.getElementById('content').style.opacity = '1';
        }, 500);
    }, 1500); // Show loader for 1.5 seconds

    // Mobile navigation toggle
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.nav-links');
    const navLinks = document.querySelectorAll('.nav-links li');
    const authButtons = document.querySelector('.auth-buttons');

    burger.addEventListener('click', function() {
        // Toggle navigation
        nav.classList.toggle('nav-active');
        authButtons.classList.toggle('auth-active');
        
        // Animate links
        navLinks.forEach((link, index) => {
            if (link.style.animation) {
                link.style.animation = '';
            } else {
                link.style.animation = `navLinkFade 0.5s ease forwards ${index / 7 + 0.3}s`;
            }
        });
        
        // Burger animation
        burger.classList.toggle('toggle');
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                window.scrollTo({
                    top: target.offsetTop - 70, // Adjust for nav height
                    behavior: 'smooth'
                });
            }
        });
    });

    // Form submission handling
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const emailInput = this.querySelector('input[type="email"]');
            
            if (emailInput.value) {
                // Here you would typically send the data to a server
                // For now, we'll just show a confirmation message
                const formContainer = this.parentElement;
                const confirmationMsg = document.createElement('p');
                confirmationMsg.className = 'success-message';
                confirmationMsg.textContent = 'Thanks for subscribing! Check your email for confirmation.';
                
                this.style.display = 'none';
                formContainer.appendChild(confirmationMsg);
                
                // Reset the form
                this.reset();
            }
        });
    }

    // Initialize animations on scroll
    const animateOnScroll = function() {
        const elements = document.querySelectorAll('[data-aos]');
        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            
            if (elementPosition < windowHeight - 100) {
                const animationName = element.getAttribute('data-aos');
                const animationDelay = element.getAttribute('data-aos-delay') || 0;
                
                setTimeout(() => {
                    element.classList.add('aos-animate');
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, animationDelay);
            }
        });
    };

    // Apply initial styles to AOS elements
    document.querySelectorAll('[data-aos]').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(50px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    });

    // Run animation check on load and scroll
    window.addEventListener('load', animateOnScroll);
    window.addEventListener('scroll', animateOnScroll);

    // Login and signup button functionality
    const loginBtn = document.querySelector('.login-btn');
    const signupBtn = document.querySelector('.signup-btn');
    const ctaButtons = document.querySelectorAll('.primary-btn');

    if (loginBtn && signupBtn) {
        const showModal = function(type) {
            // For illustration purposes - in a real app, you'd create and show a modal
            console.log(`Show ${type} modal`);
            alert(`${type} functionality would appear here.`);
        };

        loginBtn.addEventListener('click', () => window.location.href = './app/logs/login.php');
        signupBtn.addEventListener('click', () => showModal('signup'));
    }

    // Course card hover effects
    const courseCards = document.querySelectorAll('.course-card');
    courseCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
        
        card.addEventListener('click', function() {
            // In a real app, this would navigate to the course page
            console.log('Navigate to course details');
        });
    });
});