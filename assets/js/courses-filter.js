// Course Loading and Filtering System
class CourseManager {
    constructor() {
        this.currentPage = 1;
        this.coursesPerPage = 9;
        this.isLoading = false;
        this.allCoursesLoaded = false;
        this.activeFilters = new Map();
        
        this.init();
    }

    init() {
        this.bindEvents();
        this.setupIntersectionObserver();
        this.updateActiveFilterTags();
        // Load initial courses
        this.loadCourses(true);
    }

    bindEvents() {
        // Filter button click event
        const filterBtn = document.querySelector('.filter-btn');
        if (filterBtn) {
            filterBtn.addEventListener('click', () => {
                filterBtn.classList.add('active');
                this.applyAllFilters();
                setTimeout(() => {
                    filterBtn.classList.remove('active');
                }, 1000);
            });
        }

        // Filter select changes
        document.querySelectorAll('.glass-select[data-filter]').forEach(select => {
            select.addEventListener('change', () => {
                this.handleFilterChange(select);
            });
        });

        // Search input with debounce
        const searchInput = document.querySelector('.search-filter input');
        if (searchInput) {
            searchInput.addEventListener('input', debounce(() => {
                this.activeFilters.set('search', searchInput.value);
                this.resetAndReload();
            }, 500));
        }

        // Reset filters button
        const resetBtn = document.querySelector('.reset-filters-btn');
        if (resetBtn) {
            resetBtn.addEventListener('click', () => this.resetFilters());
        }

        // Sort select
        const sortSelect = document.querySelector('.sort-select');
        if (sortSelect) {
            sortSelect.addEventListener('change', () => this.handleSort(sortSelect.value));
        }

        // Load more button
        const loadMoreBtn = document.querySelector('.load-more-btn');
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', () => this.loadMoreCourses());
        }
    }

    async applyAllFilters() {
        const filterBtn = document.querySelector('.filter-btn');
        const gridContainer = document.querySelector('.grid-container');
        
        // Add loading states
        filterBtn.classList.add('active');
        gridContainer.style.opacity = '0.7';
        gridContainer.style.pointerEvents = 'none';

        // Collect all current filter values
        document.querySelectorAll('.glass-select[data-filter]').forEach(select => {
            const filterType = select.getAttribute('data-filter');
            if (select.value) {
                this.activeFilters.set(filterType, select.value);
            } else {
                this.activeFilters.delete(filterType);
            }
        });

        // Get search value
        const searchInput = document.querySelector('.search-filter input');
        if (searchInput && searchInput.value) {
            this.activeFilters.set('search', searchInput.value);
        }

        // Simulate network delay for smoother animation
        await new Promise(resolve => setTimeout(resolve, 600));

        this.resetAndReload();
        this.updateActiveFilterTags();

        // Remove loading states
        filterBtn.classList.remove('active');
        gridContainer.style.opacity = '1';
        gridContainer.style.pointerEvents = 'auto';

        // Show/hide no results message with animation
        const noResultsMessage = document.querySelector('.no-results-message');
        if (gridContainer.children.length === 0) {
            noResultsMessage.classList.add('visible');
        } else {
            noResultsMessage.classList.remove('visible');
        }
    }

    handleFilterChange(select) {
        const filterType = select.getAttribute('data-filter');
        if (filterType) {
            if (select.value) {
                this.activeFilters.set(filterType, select.value);
            } else {
                this.activeFilters.delete(filterType);
            }
        }
    }

    updateActiveFilterTags() {
        const container = document.querySelector('.active-filters');
        if (!container) return;

        container.innerHTML = '';
        this.activeFilters.forEach((value, key) => {
            if (key !== 'search') {
                const tag = document.createElement('div');
                tag.className = 'filter-tag';
                tag.innerHTML = `
                    <span>${key}: ${value}</span>
                    <i class="fas fa-times" data-filter="${key}"></i>
                `;
                
                tag.querySelector('i').addEventListener('click', () => {
                    this.removeFilter(key);
                });
                
                container.appendChild(tag);
            }
        });
    }

    removeFilter(key) {
        this.activeFilters.delete(key);
        const select = document.querySelector(`.glass-select[data-filter="${key}"]`);
        if (select) select.value = '';
        this.resetAndReload();
        this.updateActiveFilterTags();
    }

    resetFilters() {
        this.activeFilters.clear();
        document.querySelectorAll('.glass-select').forEach(select => {
            select.value = '';
        });
        document.querySelector('.search-filter input').value = '';
        this.resetAndReload();
        this.updateActiveFilterTags();
    }

    resetAndReload() {
        this.currentPage = 1;
        this.allCoursesLoaded = false;
        this.loadCourses(true);
    }

    handleSort(sortValue) {
        const container = document.querySelector('.grid-container');
        const cards = Array.from(container.children);
        
        cards.sort((a, b) => {
            const aValue = this.getSortValue(a, sortValue);
            const bValue = this.getSortValue(b, sortValue);
            
            return sortValue.includes('asc') ? aValue - bValue : bValue - aValue;
        });

        // Animate cards out
        cards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'scale(0.95)';
        });

        // Reorder and animate in
        setTimeout(() => {
            container.innerHTML = '';
            cards.forEach(card => {
                container.appendChild(card);
                requestAnimationFrame(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'scale(1)';
                });
            });
        }, 300);
    }

    getSortValue(card, sortType) {
        switch(sortType) {
            case 'price-low':
            case 'price-high':
                return parseFloat(card.dataset.price) || 0;
            case 'rating':
                return parseFloat(card.dataset.rating) || 0;
            case 'newest':
                return new Date(card.dataset.date).getTime();
            default: // popular
                return parseInt(card.dataset.enrollments) || 0;
        }
    }

    setupIntersectionObserver() {
        const options = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !this.isLoading && !this.allCoursesLoaded) {
                    this.loadMoreCourses();
                }
            });
        }, options);

        const loadMoreTrigger = document.querySelector('.load-more-section');
        if (loadMoreTrigger) {
            observer.observe(loadMoreTrigger);
        }
    }

    async loadMoreCourses() {
        if (this.isLoading || this.allCoursesLoaded) return;

        this.isLoading = true;
        const loadMoreBtn = document.querySelector('.load-more-btn');
        loadMoreBtn.classList.add('loading');

        try {
            // Simulate API call
            await new Promise(resolve => setTimeout(resolve, 1500));
            
            // In a real implementation, you would fetch courses from your backend
            const newCourses = this.getMockCourses();
            
            if (newCourses.length === 0) {
                this.allCoursesLoaded = true;
                loadMoreBtn.textContent = 'All courses loaded';
                loadMoreBtn.disabled = true;
            } else {
                this.appendCourses(newCourses);
                this.currentPage++;
            }
        } catch (error) {
            console.error('Error loading courses:', error);
        } finally {
            this.isLoading = false;
            loadMoreBtn.classList.remove('loading');
        }
    }

    appendCourses(courses) {
        const container = document.querySelector('.grid-container');
        courses.forEach((course, index) => {
            const card = this.createCourseCard(course);
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            container.appendChild(card);

            // Stagger the animation of new cards
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    }

    createCourseCard(course) {
        const tempContainer = document.createElement('div');
        tempContainer.innerHTML = createCourseCardHTML(course);
        const card = tempContainer.firstElementChild;
        
        // Add event listeners for the card
        const previewBtn = card.querySelector('.preview-btn');
        if (previewBtn) {
            previewBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                previewBtn.classList.add('clicked');
                // Add preview functionality here
                setTimeout(() => previewBtn.classList.remove('clicked'), 200);
            });
        }

        return card;
    }

    getMockCourses() {
        // Generate mock courses using the MockCourseGenerator
        return MockCourseGenerator.generateBatch(this.coursesPerPage);
    }

    loadCourses(isReset = false) {
        const container = document.querySelector('.grid-container');
        if (isReset) {
            container.innerHTML = '';
        }

        const courses = this.getMockCourses();
        if (courses.length === 0 && isReset) {
            document.querySelector('.no-results-message').style.display = 'block';
        } else {
            document.querySelector('.no-results-message').style.display = 'none';
            this.appendCourses(courses);
        }
    }
}

// Utility function for debounce
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Initialize Course Manager when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    const courseManager = new CourseManager();
});