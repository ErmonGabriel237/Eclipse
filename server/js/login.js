// First, let's create a JavaScript file for handling the AJAX request
// Save this as ../../assets/js/login.js

document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.querySelector('.login-form');
    
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Get form values
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const remember = document.getElementById('remember').checked;
        
        // Create FormData object
        const formData = new FormData();
        formData.append('email', email);
        formData.append('password', password);
        formData.append('remember', remember);
        formData.append('action', 'login');
        
        // Show loader
        document.getElementById('loader').style.display = 'flex';
        document.getElementById('content').style.display = 'none';
        
        // Send AJAX request
        fetch('../../server/auth/login.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Hide loader
            document.getElementById('loader').style.display = 'none';
            document.getElementById('content').style.display = 'block';
            
            if (data.success) {
                // Display success message
                showNotification('success', data.message);
                
                // Redirect to dashboard after short delay
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1500);
            } else {
                // Display error message
                showNotification('error', data.message);
            }
        })
        .catch(error => {
            // Hide loader
            document.getElementById('loader').style.display = 'none';
            document.getElementById('content').style.display = 'block';
            
            // Display error message
            showNotification('error', 'An error occurred. Please try again later.');
            console.error('Error:', error);
        });
    });
    
    // Function to show notification
    function showNotification(type, message) {
        // Check if notification container exists, if not create it
        let notificationContainer = document.querySelector('.notification-container');
        if (!notificationContainer) {
            notificationContainer = document.createElement('div');
            notificationContainer.className = 'notification-container';
            document.body.appendChild(notificationContainer);
        }
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification ${type} animate__animated animate__fadeIn`;
        
        // Icon based on type
        const icon = type === 'success' ? 'check-circle' : 'exclamation-circle';
        
        // Set notification content
        notification.innerHTML = `
            <i class="fas fa-${icon}"></i>
            <p>${message}</p>
        `;
        
        // Append notification to container
        notificationContainer.appendChild(notification);
        
        // Remove notification after 5 seconds
        setTimeout(() => {
            notification.classList.remove('animate__fadeIn');
            notification.classList.add('animate__fadeOut');
            
            notification.addEventListener('animationend', () => {
                notification.remove();
            });
        }, 5000);
    }
});