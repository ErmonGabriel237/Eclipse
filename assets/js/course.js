document.addEventListener('DOMContentLoaded', function() {
    // Preloader
    const preloader = document.getElementById('preloader');
    const content = document.getElementById('content');

    // Simulate loading (in a real app, you'd wait for assets to load)
    setTimeout(() => {
        preloader.style.opacity = '0';
        preloader.style.visibility = 'hidden';
        content.style.display = 'block';
        
        // Initialize animations and other JS functionality
        initFunctionality();
    }, 1500);

    function initFunctionality() {
        // Initialize AOS (Animate On Scroll)
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });

        // Initialize Swiper for featured courses slider
        const featuredSwiper = new Swiper('.featured-courses-slider', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30
                }
            }
        });

        // Course filtering functionality
        const categoryFilter = document.getElementById('category-filter');
        const levelFilter = document.getElementById('level-filter');
        const priceFilter = document.getElementById('price-filter');
        const sortFilter = document.getElementById('sort-filter');
        const resetFilterBtn = document.querySelector('.reset-filter-btn');
        const courseSearch = document.getElementById('course-search');
        const courseCards = document.querySelectorAll('.course-card');
        const coursesCount = document.getElementById('courses-count');

        // Filter courses based on selected filters
        function filterCourses() {
            const categoryValue = categoryFilter.value;
            const levelValue = levelFilter.value;
            const priceValue = priceFilter.value;
            const sortValue = sortFilter.value;
            const searchTerm = courseSearch.value.toLowerCase();
            
            let visibleCount = 0;
            
            courseCards.forEach(card => {
                const cardCategory = card.querySelector('.course-category').textContent.toLowerCase();
                const cardLevel = card.querySelector('.course-level span').textContent.toLowerCase();
                const cardPrice = card.querySelector('.price').textContent.toLowerCase();
                const cardTitle = card.querySelector('h3').textContent.toLowerCase();
                const cardInstructor = card.querySelector('.course-instructor').textContent.toLowerCase();
                
                // Check if card matches filters
                const matchesCategory = categoryValue === 'all' || cardCategory.includes(categoryValue);
                const matchesLevel = levelValue === 'all' || cardLevel.includes(levelValue);
                const matchesPrice = priceValue === 'all' || 
                                    (priceValue === 'free' && cardPrice === 'free') || 
                                    (priceValue === 'paid' && cardPrice !== 'free');
                const matchesSearch = searchTerm === '' || 
                                     cardTitle.includes(searchTerm) || 
                                     cardInstructor.includes(searchTerm);
                
                if (matchesCategory && matchesLevel && matchesPrice && matchesSearch) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Update visible courses count
            coursesCount.textContent = visibleCount;
            
            // Sort courses based on selected option
            sortCourses(sortValue);
        }

        // Sort courses based on selected option
        function sortCourses(sortValue) {
            const coursesGrid = document.querySelector('.courses-grid');
            const cards = Array.from(document.querySelectorAll('.course-card[style="display: block"]'));
            
            cards.sort((a, b) => {
                switch(sortValue) {
                    case 'newest':
                        // In a real app, you would compare dates
                        return 0;
                    case 'price-low':
                        const priceA = parseFloat(a.querySelector('.price').textContent.replace('$', '')) || 0;
                        const priceB = parseFloat(b.querySelector('.price').textContent.replace('$', '')) || 0;
                        return priceA - priceB;
                    case 'price-high':
                        const priceHighA = parseFloat(a.querySelector('.price').textContent.replace('$', '')) || 0;
                        const priceHighB = parseFloat(b.querySelector('.price').textContent.replace('$', '')) || 0;
                        return priceHighB - priceHighA;
                    case 'rating':
                        const ratingA = parseFloat(a.querySelector('.course-rating span').textContent.split(' ')[0]);
                        const ratingB = parseFloat(b.querySelector('.course-rating span').textContent.split(' ')[0]);
                        return ratingB - ratingA;
                    case 'popular':
                    default:
                        // Default is 'popular' which we'll assume is based on student count
                        const studentsA = parseInt(a.querySelector('.course-students span').textContent.replace(/\D/g, ''));
                        const studentsB = parseInt(b.querySelector('.course-students span').textContent.replace(/\D/g, ''));
                        return studentsB - studentsA;
                }
            });
            
            // Re-append sorted cards
            cards.forEach(card => {
                coursesGrid.appendChild(card);
            });
        }

        // Event listeners for filters
        categoryFilter.addEventListener('change', filterCourses);
        levelFilter.addEventListener('change', filterCourses);
        priceFilter.addEventListener('change', filterCourses);
        sortFilter.addEventListener('change', filterCourses);
        resetFilterBtn.addEventListener('click', () => {
            categoryFilter.value = 'all';
            levelFilter.value = 'all';
            priceFilter.value = 'all';
            sortFilter.value = 'popular';
            courseSearch.value = '';
            filterCourses();
        });
        
        // Search functionality with debounce
        let searchTimeout;
        courseSearch.addEventListener('input', () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(filterCourses, 300);
        });

        // Initialize with filtered courses
        filterCourses();

        // Scroll to top button
        const scrollToTopBtn = document.getElementById('scrollToTop');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.style.opacity = '1';
                scrollToTopBtn.style.visibility = 'visible';
            } else {
                scrollToTopBtn.style.opacity = '0';
                scrollToTopBtn.style.visibility = 'hidden';
            }
        });
        
        scrollToTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Mobile navigation toggle
        const burger = document.querySelector('.burger');
        const navLinks = document.querySelector('.nav-links');
        const navGlass = document.querySelector('.nav-glass');
        
        burger.addEventListener('click', () => {
            navLinks.classList.toggle('nav-active');
            burger.classList.toggle('toggle');
            navGlass.classList.toggle('nav-expanded');
        });

        // Close mobile menu when clicking on a link
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('nav-active');
                burger.classList.remove('toggle');
                navGlass.classList.remove('nav-expanded');
            });
        });

        // Course card hover effects
        courseCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-5px)';
                card.style.boxShadow = '0 10px 20px rgba(0, 0, 0, 0.2)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
                card.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
            });
        });

        // Login/Signup button functionality (would connect to your auth system)
        const loginBtn = document.querySelector('.login-btn');
        const signupBtn = document.querySelector('.signup-btn');
        const ctaBtn = document.querySelector('.cta-btn');
        
        if (loginBtn) {
            loginBtn.addEventListener('click', () => {
                window.location.href = 'login.php';
            });
        }
        
        if (signupBtn) {
            signupBtn.addEventListener('click', () => {
                window.location.href = 'signup.php';
            });
        }
        
        if (ctaBtn) {
            ctaBtn.addEventListener('click', () => {
                if (document.body.classList.contains('logged-in')) {
                    window.location.href = 'courses.php';
                } else {
                    window.location.href = 'signup.php';
                }
            });
        }

        // "Learn More" button functionality for course cards
        document.querySelectorAll('.course-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const courseCard = e.target.closest('.course-card');
                const courseTitle = courseCard.querySelector('h3').textContent;
                // In a real app, you would redirect to the course detail page
                alert(`You clicked on "${courseTitle}". In a real app, this would take you to the course details page.`);
            });
        });
    }
});

// Additional utility functions
function debounce(func, wait) {
    let timeout;
    return function() {
        const context = this, args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            func.apply(context, args);
        }, wait);
    };
}