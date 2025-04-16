<?php
// Set the HTTP response code to 500
http_response_code(500);

// Get the previous page URL
$previousPage = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Internal Server Error</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        h1 {
            font-size: 50px;
            color: #ff0000;
        }
        p {
            font-size: 18px;
            color: #333;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>500</h1>
    <p>Oops! Something went wrong on our end.</p>
    <p><a href="<?php echo htmlspecialchars($previousPage); ?>">Go Back to Previous Page</a></p>
</body>
</html>