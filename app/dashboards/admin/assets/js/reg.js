$(document).ready(function() {
    // Clear error messages on input
    $('input').on('input', function() {
        $(this).next('.error').text('');
        $('#registration-message').text('');
    });

    // Form submission
    $('#registrationForm').on('submit', function(e) {
        e.preventDefault();
        
        // Reset previous error messages
        $('.error').text('');
        
        // Collect form data
        var formData = {
            username: $('#username').val(),
            email: $('#email').val(),
            password: $('#password').val(),
            confirmPassword: $('#confirmPassword').val()
        };

        // Client-side validation
        var isValid = true;

        // Username validation
        if (formData.username.length < 3) {
            $('#username-error').text('Username must be at least 3 characters');
            isValid = false;
        }

        // Email validation
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(formData.email)) {
            $('#email-error').text('Please enter a valid email address');
            isValid = false;
        }

        // Password validation
        if (formData.password.length < 8) {
            $('#password-error').text('Password must be at least 8 characters');
            isValid = false;
        }

        // Confirm password validation
        if (formData.password !== formData.confirmPassword) {
            $('#confirm-password-error').text('Passwords do not match');
            isValid = false;
        }

        // Full name validation
        // if (formData.fullName.length < 2) {
        //     $('#full-name-error').text('Please enter your full name');
        //     isValid = false;
        // }

        // If validation fails, stop
        if (!isValid) return;

        // AJAX submission
        $.ajax({
            type: 'POST',
            url: '../server/reg.php',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#registration-message').html('<p style="color:green;">' + response.message + '</p>');
                    // Optional: redirect or clear form
                    $('#registrationForm')[0].reset();
                    window.location.href = './index.php'; // Redirect to Login page after successful registration 
                } else {
                    // Show error messages
                    if (response.errors) {
                        if (response.errors.username) {
                            $('#username-error').text(response.errors.username);
                        }
                        if (response.errors.email){
                            $('#email-error').text(response.errors.email);
                        }
                    }
                    $('#registration-message').html('<p style="color:red;">' + response.message + '</p>');
                }
            },
            error: function() {
                $('#registration-message').html('<p style="color:red;">An error occurred. Please try again.</p>');
            }
        });
    });
});