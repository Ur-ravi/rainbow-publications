<?php
// ============================================================
// BOOK PUBLICATION CMS — CONFIGURATION
// Site: sujatapublications.org
// ============================================================
// FOLDER STRUCTURE (everything inside public_html):
//
//   public_html/
//     ├── index.php
//     ├── .htaccess
//     ├── install.php
//     ├── css/
//     ├── uploads/          ← file uploads go here
//     └── bookpub_app/      ← backend code (this folder)
//         ├── app/
//         ├── config/       ← you are here (config.php)
//         ├── database/
//         ├── routes/
//         └── storage/
//
// ROOT_PATH is defined in index.php as: __DIR__ . '/bookpub_app'
// i.e. ROOT_PATH = /home/uXXX/domains/sujatapublications.org/public_html/bookpub_app
// ============================================================

define('APP_NAME',    'Rainbow Publications');
define('APP_VERSION', '2.0.0');
// APP_ENV / APP_DEBUG are loaded from .env (see config/env.php). Override in .env to 'development' / true for verbose errors.
$__env = function_exists('env') ? env('APP_ENV', 'production') : 'development';
$__debug = function_exists('env') ? env('APP_DEBUG', false) : false;
define('APP_ENV',   is_string($__env) ? $__env : 'production');
define('APP_DEBUG', (bool)$__debug);

// ============================================================
// PATH CONSTANTS — Do NOT change these
// ROOT_PATH is set in index.php before config.php loads
// ============================================================
define('APP_PATH',    ROOT_PATH . '/app');
// PUBLIC_PATH = the public_html folder (one level up from bookpub_app)
define('PUBLIC_PATH', dirname(ROOT_PATH));
define('UPLOAD_PATH', PUBLIC_PATH . '/uploads');

// ============================================================
// BASE URL
// *** YOUR ACTUAL DOMAIN — no trailing slash ***
// ============================================================
define('BASE_URL', 'https://rainbowpublications.edutechy.in');

// ============================================================
// DATABASE CREDENTIALS — loaded from environment (.env)
// Copy bookpub_app/.env.example to .env and fill in real values.
// NEVER commit real credentials. The old hard-coded ones were
// rotated out as part of a security audit on 2026-06-18.
// ============================================================
if (!function_exists('env')) { require_once __DIR__ . '/env.php'; }

$_dbHost = env('DB_HOST', 'localhost');
$_dbName = env('DB_NAME', '');
$_dbUser = env('DB_USER', '');
$_dbPass = env('DB_PASS', '');
$_dbChar = env('DB_CHARSET', 'utf8mb4');

// Refuse to boot with empty credentials on non-localhost.
// Local XAMPP (root with no password) is allowed.
if ($_dbPass === '' && $_dbHost !== 'localhost') {
    http_response_code(500);
    die('Database credentials are not configured. Copy bookpub_app/.env.example to .env and set DB_PASS.');
}

define('DB_HOST',    $_dbHost);
define('DB_NAME',    $_dbName);
define('DB_USER',    $_dbUser);
define('DB_PASS',    $_dbPass);
define('DB_CHARSET', $_dbChar);

// ============================================================
// SECURITY
// ============================================================
define('SECRET_KEY',        'IBP_Rainbow_2025_Key_' . substr(md5(__FILE__), 0, 16));
$_sl = env('SESSION_LIFETIME', 3600);
$_ce = env('CSRF_TOKEN_EXPIRE', 7200);
define('SESSION_LIFETIME',  is_numeric($_sl) ? (int)$_sl : 3600);   // 1 hour
define('CSRF_TOKEN_EXPIRE', is_numeric($_ce) ? (int)$_ce : 7200);   // 2 hours

// ============================================================
// UPLOADS
// ============================================================
define('MAX_UPLOAD_SIZE',     10 * 1024 * 1024); // 10MB
// H9: SVG is intentionally excluded — it can carry <script> and onload handlers.
// If a site feature truly needs SVG, sanitize with enshrined/svg-sanitize or similar.
define('ALLOWED_IMAGE_TYPES', array('image/jpeg', 'image/png', 'image/gif', 'image/webp'));
define('ALLOWED_DOC_TYPES',   array('application/pdf'));

// ============================================================
// PAGINATION
// ============================================================
define('BOOKS_PER_PAGE',   12);
define('NEWS_PER_PAGE',     9);
define('GALLERY_PER_PAGE', 16);
define('ADMIN_PER_PAGE',   15);

// ============================================================
// ERROR HANDLING
// ============================================================
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    ini_set('display_errors', '0');
}

date_default_timezone_set('Asia/Kolkata');
