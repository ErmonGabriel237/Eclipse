$(document).ready(function () {
    $('#loginForm').on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        // Collect form data
        var username = $('#username').val();
        var password = $('#password').val();

        // AJAX call to login script
        $.ajax({
            type: 'POST',
            url: '../server/login.php',
            data: {
                username: username,
                password: password
            },
            dataType: 'json',
            success: function (response) {
                console.log('Hello men');
                if (response.success) {
                    $('#message').html('<p style="color:green;">' + response.message + '</p>');
                    // Redirect to dashboard or home page
                    if (response.userType === 'admin') {
                        window.location.href = './index.php';
                    } else {
                        $('#message').html('<p style="color:green;">' + response.message + '</p>');
                    }
                } else {
                    $('#message').html('<p style="color:red;">' + response.message + '</p>');
                }
            },
            error: function () {
                $('#message').html('<p style="color:red;">An error occurred. Please try again.</p>');
            }
        });
    });
});