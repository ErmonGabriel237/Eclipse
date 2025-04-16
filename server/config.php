<?php
/**
 * Database Configuration
 * 
 * This file contains database connection parameters and should be kept outside
 * the web root directory for security purposes.
 */

// Prevent direct access to this file
if (!defined('AUTHORIZED_ACCESS') && basename($_SERVER['SCRIPT_FILENAME']) == basename(__FILE__)) {
    header('HTTP/1.0 403 Forb idden');
    exit('Direct access to this file is forbidden.');
}

// Set to true for development, false for production
$dev_environment = false;

// Configure error display based on environment
if ($dev_environment) {
    // For development only
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    // For production
    ini_set('display_errors', 0);
    error_reporting(0);
}

// Database credentials
// For production, consider using environment variables instead of hardcoded values
return [
    'host'     => getenv('DB_HOST') ?: 'localhost',
    'dbname'   => getenv('DB_NAME') ?: 'elearning',
    'username' => getenv('DB_USER') ?: 'root',
    'password' => getenv('DB_PASS') ?: '',
    'charset'  => 'utf8mb4',
    'options'  => [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        // Persistent connections can improve performance but use with caution
        // PDO::ATTR_PERSISTENT         => true,
    ]
];