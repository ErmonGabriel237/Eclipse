/**
 * LearnHub Registration Form Handler
 * 
 * Handles form submission, validation, and AJAX request for user registration
 */

document.addEventListener('DOMContentLoaded', function() {
    // Show content and hide loader after page loads
    setTimeout(() => {
        document.getElementById('loader').style.display = 'none';
        document.getElementById('content').style.display = 'block';
    }, 1000);
    
    // Get the registration form
    const registerForm = document.querySelector('.register-form');
    
    // Form submission handler
    registerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Display loading state
        showLoading(true);
        
        // Clear previous error messages
        clearErrors();
        
        // Get form fields
        const email = document.getElementById('email').value;
        const firstName = document.getElementById('first-name').value;
        const lastName = document.getElementById('last-name').value;
        const phone = document.getElementById('phone').value;
        const gender = document.getElementById('gender').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm-password').value;
        const profilePicture = document.getElementById('profile-picture').files[0];
        
        // Client-side validation
        const errors = validateForm(email, firstName, lastName, phone, gender, password, confirmPassword, profilePicture);
        
        if (errors.length > 0) {
            displayErrors(errors);
            showLoading(false);
            return;
        }
        
        // Create FormData object for file upload
        const formData = new FormData();
        formData.append('email', email);
        formData.append('firstName', firstName);
        formData.append('lastName', lastName);
        formData.append('phone', phone);
        formData.append('gender', gender);
        formData.append('password', password);
        formData.append('confirmPassword', confirmPassword);
        formData.append('profilePicture', profilePicture);
        
        // Send AJAX request
        fetch('../../server/auth/register.php', {
            method: 'POST',
            body: formData,
            // Don't set Content-Type header as FormData will set it automatically with boundary
        })
        .then(response => response.json())
        .then(data => {
            showLoading(false);
            
            if (data.status === 'success') {
                // Show success message
                showNotification('success', data.message);
                
                // Redirect after success
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 2000);
            } else {
                // Show error messages
                if (data.errors && Array.isArray(data.errors)) {
                    displayErrors(data.errors);
                } else {
                    displayErrors([data.message || 'Registration failed']);
                }
            }
        })
        .catch(error => {
            showLoading(false);
            displayErrors(['Network error. Please try again later.']);
            console.error('Registration error:', error);
        });
    });
    
    /**
     * Validate form data
     */
    function validateForm(email, firstName, lastName, phone, gender, password, confirmPassword, profilePicture) {
        const errors = [];
        
        // Email validation
        if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            errors.push('Please enter a valid email address');
        }
        
        // Name validation
        if (!firstName || firstName.length < 2) {
            errors.push('First name must be at least 2 characters');
        }
        
        if (!lastName || lastName.length < 2) {
            errors.push('Last name must be at least 2 characters');
        }
        
        // Phone validation
        if (!phone || !/^[0-9+\-\s()]{6,20}$/.test(phone)) {
            errors.push('Please enter a valid phone number');
        }
        
        // Gender validation
        if (!gender || !['male', 'female', 'other'].includes(gender)) {
            errors.push('Please select your gender');
        }
        
        // Password validation
        if (!password || password.length < 8) {
            errors.push('Password must be at least 8 characters');
        }
        
        if (password !== confirmPassword) {
            errors.push('Passwords do not match');
        }
        
        // Profile picture validation
        if (!profilePicture) {
            errors.push('Please upload a profile picture');
        } else {
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!allowedTypes.includes(profilePicture.type)) {
                errors.push('Profile picture must be a JPG, PNG, or GIF image');
            }
        }
        
        return errors;
    }
    
    /**
     * Display error messages
     */
    function displayErrors(errors) {
        // Create error container if it doesn't exist
        let errorContainer = document.querySelector('.form-errors');
        if (!errorContainer) {
            errorContainer = document.createElement('div');
            errorContainer.className = 'form-errors animate__animated animate__fadeIn';
            registerForm.insertBefore(errorContainer, registerForm.firstChild);
        }
        
        // Clear previous errors
        errorContainer.innerHTML = '';
        
        // Create error list
        const errorList = document.createElement('ul');
        errors.forEach(error => {
            const listItem = document.createElement('li');
            listItem.textContent = error;
            errorList.appendChild(listItem);
        });
        
        errorContainer.appendChild(errorList);
        
        // Scroll to error container
        errorContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    
    /**
     * Clear error messages
     */
    function clearErrors() {
        const errorContainer = document.querySelector('.form-errors');
        if (errorContainer) {
            errorContainer.remove();
        }
    }
    
    /**
     * Show/hide loading overlay
     */
    function showLoading(show) {
        const loader = document.getElementById('loader');
        if (show) {
            loader.style.display = 'flex';
        } else {
            loader.style.display = 'none';
        }
    }
    
    /**
     * Show notification
     */
    function showNotification(type, message) {
        // Remove existing notification
        const existingNotification = document.querySelector('.notification');
        if (existingNotification) {
            existingNotification.remove();
        }
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification ${type} animate__animated animate__fadeIn`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                <p>${message}</p>
            </div>
        `;
        
        // Add to document
        document.body.appendChild(notification);
        
        // Remove notification after 5 seconds
        setTimeout(() => {
            notification.classList.remove('animate__fadeIn');
            notification.classList.add('animate__fadeOut');
            setTimeout(() => {
                notification.remove();
            }, 500);
        }, 5000);
    }
});