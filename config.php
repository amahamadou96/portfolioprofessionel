<?php
/**
 * Configuration - Portfolio
 * Fichier de configuration centralisé
 */

// ===================
// ENVIRONMENT SETTINGS
// ===================

define('ENVIRONMENT', 'production'); // development | production
define('DEBUG_MODE', false);

// ===================
// SITE CONFIGURATION
// ===================

// Personal Information
define('SITE_NAME', 'Abdoulahi Mahamadou Soumaila');
define('SITE_TITLE', 'Portfolio - Cybersécurité');
define('SITE_DESCRIPTION', 'Portfolio professionnel d\'un étudiant spécialisé en cybersécurité et analyse de sécurité des réseaux');
define('SITE_AUTHOR', 'Abdoulahi Mahamadou Soumaila');

// Contact Information
define('CONTACT_NAME', 'Abdoulahi Mahamadou Soumaila');
define('CONTACT_EMAIL', 'mahamadouabdoulahi566@gmail.com');
define('CONTACT_PHONE', '+221 77 382 33 07');
define('CONTACT_LOCATION', 'Sénégal');

// ===================
// EMAIL CONFIGURATION
// ===================

// Mail settings
define('MAIL_FROM_EMAIL', 'mahamadouabdoulahi566@gmail.com');
define('MAIL_FROM_NAME', 'Abdoulahi Portfolio');
define('MAIL_REPLY_TO', 'mahamadouabdoulahi566@gmail.com');

// SMTP Configuration (if needed)
define('MAIL_SMTP_HOST', 'smtp.gmail.com');
define('MAIL_SMTP_PORT', 587);
define('MAIL_SMTP_USER', 'your-email@gmail.com');
define('MAIL_SMTP_PASS', 'your-app-password');

// ===================
// SOCIAL MEDIA LINKS
// ===================

$socialLinks = [
    'linkedin' => 'https://linkedin.com/in/abdoulahi',
    'github' => 'https://github.com/abdoulahi',
    'twitter' => 'https://twitter.com/abdoulahi',
    'email' => 'mailto:abdoulahim10@gmail.com'
];

// ===================
// SECURITY SETTINGS
// ===================

// CSRF Token
define('CSRF_TOKEN_ENABLED', true);
define('CSRF_TOKEN_LENGTH', 32);

// Rate Limiting
define('RATE_LIMIT_ENABLED', true);
define('RATE_LIMIT_REQUESTS', 5); // Max requests
define('RATE_LIMIT_WINDOW', 3600); // Per hour

// Input Validation
define('MAX_NAME_LENGTH', 100);
define('MAX_EMAIL_LENGTH', 255);
define('MAX_MESSAGE_LENGTH', 5000);
define('MIN_MESSAGE_LENGTH', 10);

// ===================
// FILE PATHS
// ===================

define('ROOT_PATH', dirname(__FILE__));
define('LOG_PATH', ROOT_PATH . '/logs/');
define('UPLOADS_PATH', ROOT_PATH . '/uploads/');

// Create directories if they don't exist
if (!is_dir(LOG_PATH)) {
    mkdir(LOG_PATH, 0755, true);
}
if (!is_dir(UPLOADS_PATH)) {
    mkdir(UPLOADS_PATH, 0755, true);
}

// ===================
// DATABASE CONFIGURATION (if needed)
// ===================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'portfolio');
define('DB_CHARSET', 'utf8mb4');

// ===================
// RECAPTCHA (Optional)
// ===================

define('RECAPTCHA_ENABLED', false);
define('RECAPTCHA_SITE_KEY', 'your-site-key');
define('RECAPTCHA_SECRET_KEY', 'your-secret-key');

// ===================
// GOOGLE ANALYTICS (Optional)
// ===================

define('GOOGLE_ANALYTICS_ID', 'UA-XXXXXXXXX-X');

// ===================
// HELPER FUNCTIONS
// ===================

/**
 * Sanitize string input
 */
function sanitize($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate email
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Log message
 */
function logMessage($message, $type = 'info') {
    $timestamp = date('Y-m-d H:i:s');
    $logFile = LOG_PATH . 'portfolio_' . date('Y-m-d') . '.log';
    
    $logEntry = "[{$timestamp}] [{$type}] {$message}\n";
    file_put_contents($logFile, $logEntry, FILE_APPEND);
}

/**
 * Get environment variable
 */
function getEnv($key, $default = null) {
    return $_ENV[$key] ?? $_SERVER[$key] ?? $default;
}

/**
 * Check if production environment
 */
function isProduction() {
    return ENVIRONMENT === 'production';
}

/**
 * Check if development environment
 */
function isDevelopment() {
    return ENVIRONMENT === 'development';
}

// ===================
// ERROR HANDLING
// ===================

if (isDevelopment()) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
}

// ===================
// SESSION CONFIGURATION
// ===================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    
    // Session settings
    ini_set('session.gc_maxlifetime', 3600);
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', isProduction() ? 1 : 0);
    ini_set('session.cookie_samesite', 'Strict');
}

// ===================
// TIMEZONE
// ===================

date_default_timezone_set('Africa/Dakar');

?>
