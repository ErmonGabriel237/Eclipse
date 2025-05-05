// Mock course data generator
const courseMockData = {
    categories: ['development', 'design', 'business', 'marketing', 'photography'],
    levels: ['beginner', 'intermediate', 'advanced'],
    titles: {
        development: [
            'Complete Web Development Bootcamp',
            'Python Programming Masterclass',
            'JavaScript Advanced Concepts',
            'React & Redux for Beginners',
            'Full Stack Development with MERN'
        ],
        design: [
            'UI/UX Design Fundamentals',
            'Adobe Creative Suite Masterclass',
            'Web Design Principles',
            'Digital Illustration Techniques',
            'Motion Graphics Design'
        ],
        business: [
            'Business Strategy Fundamentals',
            'Digital Marketing Essentials',
            'Startup Management',
            'Project Management Professional',
            'Financial Analysis & Planning'
        ],
        marketing: [
            'Social Media Marketing',
            'Content Marketing Strategy',
            'SEO & Digital Marketing',
            'Email Marketing Mastery',
            'Growth Hacking Techniques'
        ],
        photography: [
            'Digital Photography Basics',
            'Portrait Photography',
            'Landscape Photography',
            'Mobile Photography',
            'Photo Editing with Lightroom'
        ]
    },
    instructors: [
        { name: 'John Smith', role: 'Senior Developer' },
        { name: 'Sarah Johnson', role: 'Design Expert' },
        { name: 'Michael Brown', role: 'Business Consultant' },
        { name: 'Emily Davis', role: 'Marketing Specialist' },
        { name: 'David Wilson', role: 'Professional Photographer' }
    ]
};

class MockCourseGenerator {
    static generateCourse(category = null) {
        const selectedCategory = category || this.randomItem(courseMockData.categories);
        const level = this.randomItem(courseMockData.levels);
        const title = this.randomItem(courseMockData.titles[selectedCategory]);
        const instructor = this.randomItem(courseMockData.instructors);
        const price = Math.random() < 0.2 ? 0 : Math.floor(Math.random() * 150) + 49;
        const rating = (Math.random() * (5 - 4) + 4).toFixed(1);
        const enrollments = Math.floor(Math.random() * 15000) + 1000;
        const reviews = Math.floor(Math.random() * 1000) + 100;
        const duration = Math.floor(Math.random() * 30) + 10;
        const lectures = Math.floor(Math.random() * 150) + 50;

        return {
            id: this.generateId(),
            title,
            category: selectedCategory,
            level,
            price,
            originalPrice: price * 1.4,
            rating,
            enrollments,
            reviews,
            duration,
            lectures,
            instructor,
            image: `https://source.unsplash.com/300x200/?${selectedCategory},education`,
            isBestseller: enrollments > 10000,
            lastUpdated: this.randomDate(new Date(2024, 0, 1), new Date())
        };
    }

    static generateBatch(count, category = null) {
        return Array(count).fill(null).map(() => this.generateCourse(category));
    }

    static randomItem(array) {
        return array[Math.floor(Math.random() * array.length)];
    }

    static generateId() {
        return Math.random().toString(36).substr(2, 9);
    }

    static randomDate(start, end) {
        return new Date(start.getTime() + Math.random() * (end.getTime() - start.getTime()));
    }
}

// Create course card HTML
function createCourseCardHTML(course) {
    return `
        <div class="course-card glass-effect" 
            data-aos="fade-up" 
            data-category="${course.category}"
            data-level="${course.level}"
            data-price="${course.price}"
            data-rating="${course.rating}"
            data-date="${course.lastUpdated.toISOString()}"
            data-enrollments="${course.enrollments}">
            <div class="course-image">
                <img src="${course.image}" alt="${course.title}">
                <div class="course-overlay">
                    ${course.isBestseller ? '<span class="course-badge">Bestseller</span>' : ''}
                    <div class="course-preview">
                        <button class="preview-btn glass-effect">
                            <i class="fas fa-play"></i> Preview
                        </button>
                    </div>
                </div>
            </div>
            <div class="course-content">
                <div class="course-category">
                    <i class="${getCategoryIcon(course.category)}"></i> 
                    ${capitalizeFirst(course.category)}
                </div>
                <h3>${course.title}</h3>
                <div class="course-meta">
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <span>${course.rating} (${course.reviews.toLocaleString()} reviews)</span>
                    </div>
                    <div class="students">
                        <i class="fas fa-users"></i>
                        <span>${course.enrollments.toLocaleString()}+ students</span>
                    </div>
                </div>
                <div class="course-details">
                    <div class="course-info">
                        <i class="fas fa-clock"></i>
                        <span>${course.duration} hours</span>
                    </div>
                    <div class="course-info">
                        <i class="fas fa-video"></i>
                        <span>${course.lectures} lectures</span>
                    </div>
                    <div class="course-info">
                        <i class="fas fa-signal"></i>
                        <span>${capitalizeFirst(course.level)}</span>
                    </div>
                </div>
                <div class="course-footer">
                    <div class="course-price">
                        ${course.price === 0 ? 
                            '<span class="current-price">Free</span>' :
                            `<span class="current-price">$${course.price.toFixed(2)}</span>
                             <span class="original-price">$${course.originalPrice.toFixed(2)}</span>`
                        }
                    </div>
                    <button class="enroll-btn gradient-btn">Enroll Now</button>
                </div>
            </div>
        </div>
    `;
}

// Helper functions
function getCategoryIcon(category) {
    const icons = {
        development: 'fas fa-code',
        design: 'fas fa-paint-brush',
        business: 'fas fa-chart-line',
        marketing: 'fas fa-bullhorn',
        photography: 'fas fa-camera'
    };
    return icons[category] || 'fas fa-book';
}

function capitalizeFirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}