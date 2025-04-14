// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterBtn = document.querySelector('.filter-btn');
    const courseSearch = document.getElementById('course-search');
    const categorySelect = document.getElementById('category-select');
    const priceSelect = document.getElementById('price-select');
    const levelSelect = document.getElementById('level-select');
    const courseCards = document.querySelectorAll('.course-card');
    
    // Search functionality - Filter as you type
    courseSearch.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        filterCourses();
    });
    
    // Apply filters when clicking the filter button
    if (filterBtn) {
        filterBtn.addEventListener('click', function() {
            filterCourses();
        });
    }

    // Filter courses function
    function filterCourses() {
        const searchTerm = courseSearch.value.toLowerCase();
        const category = categorySelect.value;
        const price = priceSelect.value;
        const level = levelSelect.value;
        
        courseCards.forEach(card => {
            // Get card details for filtering
            const cardTitle = card.querySelector('h3').textContent.toLowerCase();
            const cardCategory = card.querySelector('.course-category').textContent.toLowerCase();
            const cardPrice = card.querySelector('.course-price').textContent;
            const cardLevel = card.querySelector('.course-level') ? 
                              card.querySelector('.course-level').textContent.toLowerCase() : "";
            
            // Check if card matches all filter criteria
            const matchesSearch = cardTitle.includes(searchTerm);
            const matchesCategory = category === 'all' || cardCategory.includes(category.replace('-', ' '));
            
            // Price filter logic
            let matchesPrice = price === 'all';
            if (price === 'free' && cardPrice.includes('Free')) matchesPrice = true;
            if (price === 'paid' && !cardPrice.includes('Free')) matchesPrice = true;
            
            const priceValue = parseFloat(cardPrice.replace(/[^0-9.]/g, ''));
            if (price === 'under-50' && priceValue < 50) matchesPrice = true;
            if (price === '50-100' && priceValue >= 50 && priceValue <= 100) matchesPrice = true;
            if (price === 'over-100' && priceValue > 100) matchesPrice = true;
            
            // Level filter logic
            const matchesLevel = level === 'all' || cardLevel.includes(level);
            
            // Show or hide card based on all filter criteria
            if (matchesSearch && matchesCategory && matchesPrice && matchesLevel) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
        
        // Check if there are any visible cards
        const visibleCards = Array.from(courseCards).filter(card => card.style.display !== 'none');
        const noResultsMsg = document.querySelector('.no-results-message');
        
        if (visibleCards.length === 0) {
            // If no cards are visible, show "no results" message
            if (!noResultsMsg) {
                const coursesContainer = document.querySelector('.all-courses .courses-container');
                const message = document.createElement('div');
                message.className = 'no-results-message';
                message.innerHTML = '<p>No courses match your search criteria. Try adjusting your filters.</p>';
                coursesContainer.appendChild(message);
            }
        } else {
            // Remove "no results" message if it exists
            if (noResultsMsg) {
                noResultsMsg.remove();
            }
        }
    }
    
    // Course card hover effects
    courseCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Handle pagination
    const paginationItems = document.querySelectorAll('.pagination-item');
    paginationItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all items
            paginationItems.forEach(item => item.classList.remove('active'));
            
            // Add active class to clicked item
            this.classList.add('active');
            
            // In a real implementation, this would load new course data
            // For demo purposes, we'll just scroll to the top of the courses section
            document.querySelector('.all-courses').scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
    
    // Category cards hover effects
    const categoryCards = document.querySelectorAll('.category-card');
    categoryCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Scroll to top button functionality (optional)
    const scrollToTopBtn = document.createElement('button');
    scrollToTopBtn.className = 'scroll-top-btn';
    scrollToTopBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
    document.body.appendChild(scrollToTopBtn);
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            scrollToTopBtn.classList.add('show');
        } else {
            scrollToTopBtn.classList.remove('show');
        }
    });
    
    scrollToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    // Initialize any animations on scroll for this page
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
});