document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.querySelector('.register-form');
    
    registerForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        // Basic validation
        const password = formData.get('password');
        const confirmPassword = formData.get('confirm_password');
        
        if (password !== confirmPassword) {
            showNotification('Passwords do not match!', 'error');
            return;
        }

        try {
            const response = await fetch('../../server/auth/register.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                showNotification('Registration successful! Redirecting to login...', 'success');
                setTimeout(() => {
                    window.location.href = './login.php';
                }, 2000);
            } else {
                showNotification(data.message || 'Registration failed!', 'error');
            }
        } catch (error) {
            showNotification('An error occurred. Please try again.', 'error');
        }
    });

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification ${type} animate__animated animate__fadeIn`;
        notification.textContent = message;

        const container = document.getElementById('notification-container');
        container.appendChild(notification);

        setTimeout(() => {
            notification.classList.replace('animate__fadeIn', 'animate__fadeOut');
            setTimeout(() => {
                container.removeChild(notification);
            }, 500);
        }, 3000);
    }
});