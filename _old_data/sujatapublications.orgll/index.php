<?php

/**
 * ================================================================
 * BOOK PUBLICATION CMS — FRONT CONTROLLER
 * Site: rainbow.edutechy.in
 * Structure: Everything inside public_html/
 * public_html/
 * ├── index.php        ← this file
 * ├── bookpub_app/     ← backend (inside public_html)
 * ├── css/
 * ├── uploads/
 * └── .htaccess
 * ================================================================
 */

// NOTE: No declare(strict_types=1) — causes type errors on PHP 7.4 shared hosting

define('APP_START', microtime(true));

// --- ERROR HANDLING ---
// Errors are NEVER displayed in the browser by default. They go to
// bookpub_app/storage/logs/error.log. To debug, set APP_ENV=development
// in .env (see bookpub_app/.env.example) and reload — display_errors
// is then enabled by config.php. We force display off here for safety.
// -------------------------------------------------------------------------
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ALL);
ini_set('log_errors', '1');
// log destination is set in config.php once ROOT_PATH is known
// -------------------------------------------------------------------------

// ---------------------------------------------------------------
// 1. BACKEND PATH  (bookpub_app is INSIDE public_html)
// ---------------------------------------------------------------
define('ROOT_PATH', __DIR__ . '/bookpub_app');

if (!is_dir(ROOT_PATH)) {
    http_response_code(500);
    die(
        '<!DOCTYPE html><html><head><title>Setup Error</title></head>' .
        '<body style="font-family:Arial;padding:40px;">' .
        '<h2 style="color:#cc1824">Configuration Error</h2>' .
        '<p>Cannot find <strong>bookpub_app</strong> folder.</p>' .
        '<p>Expected at: <code>' . ROOT_PATH . '</code></p>' .
        '<p>Make sure bookpub_app/ folder is inside public_html/</p>' .
        '</body></html>'
    );
}

// ---------------------------------------------------------------
// 2. SESSION SETUP
// ---------------------------------------------------------------
$isHttps = (
    (!empty($_SERVER['HTTPS'])                  && $_SERVER['HTTPS']                  !== 'off') ||
    (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ||
    (!empty($_SERVER['SERVER_PORT'])            && (int)$_SERVER['SERVER_PORT']       === 443)
);

// Cookie params must be set BEFORE session_start() so the browser
// keeps the same session id across page-load → submit cycles.
$cookieParams = [
    'lifetime' => 0,           // session cookie — dies with browser
    'path'     => '/',
    'domain'   => '',          // current host only (avoids www./non-www. mismatch)
    'secure'   => $isHttps,
    'httponly' => true,
    'samesite' => 'Lax',       // 'Lax' allows top-level form posts + same-origin XHR
];
session_set_cookie_params($cookieParams);

ini_set('session.use_strict_mode', '0');   // OFF: strict mode can rotate session id between requests, breaking CSRF
ini_set('session.cookie_httponly',  '1');
ini_set('session.cookie_samesite',  'Lax');
ini_set('session.cookie_secure',    $isHttps ? '1' : '0');
ini_set('session.gc_maxlifetime',   '3600');
ini_set('log_errors',  '1');
ini_set('error_log',   ROOT_PATH . '/storage/logs/error.log');

session_start();

// ---------------------------------------------------------------
// 3. LOAD FRAMEWORK (helpers loaded early so polyfills are available)
// ---------------------------------------------------------------
require_once ROOT_PATH . '/config/config.php';
require_once ROOT_PATH . '/config/database.php';
require_once ROOT_PATH . '/app/Helpers/helpers.php';   // PHP 8 polyfills live here
require_once ROOT_PATH . '/app/Controllers/Controller.php';
require_once ROOT_PATH . '/app/Models/Models.php';
require_once ROOT_PATH . '/app/Controllers/AuthController.php';
require_once ROOT_PATH . '/app/Controllers/FrontControllers.php';
require_once ROOT_PATH . '/app/Controllers/AdminControllers.php';
require_once ROOT_PATH . '/routes/Router.php';

// ---------------------------------------------------------------
// 4. PARSE URI
// ---------------------------------------------------------------
$rawUri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
$uri    = parse_url($rawUri, PHP_URL_PATH);
if (!$uri) $uri = '/';
$uri = '/' . ltrim($uri, '/');
// Remove trailing slash except for root
if (strlen($uri) > 1 && substr($uri, -1) === '/') {
    $uri = rtrim($uri, '/');
}
$method = isset($_SERVER['REQUEST_METHOD']) ? strtoupper($_SERVER['REQUEST_METHOD']) : 'GET';

error_log("[INDEX] rawUri=$rawUri parsed_uri=$uri method=$method session_id=" . session_id() . " admin_id=" . ($_SESSION['admin_id'] ?? 'none'));

// ---------------------------------------------------------------
// 5. DISPATCH with error handling
// ---------------------------------------------------------------
try {
    $router = new Router();
    require_once ROOT_PATH . '/routes/web.php';
    $router->dispatch($method, $uri);
} catch (PDOException $e) {
    $msg = (defined('APP_ENV') && APP_ENV === 'development')
        ? htmlspecialchars($e->getMessage())
        : 'Database connection failed. Check your DB settings in bookpub_app/config/config.php';
    http_response_code(500);
    die('<!DOCTYPE html><html><head><title>DB Error</title></head><body style="font-family:Arial;padding:40px">
        <h2 style="color:#cc1824">Database Error</h2><p>' . $msg . '</p>
        <p>Visit <a href="/install.php">install.php</a> to test your connection.</p>
    </body></html>');
} catch (Exception $e) {
    $msg = (defined('APP_ENV') && APP_ENV === 'development')
        ? '<pre>' . htmlspecialchars($e->getMessage() . "\n" . $e->getTraceAsString()) . '</pre>'
        : 'An unexpected error occurred.';
    http_response_code(500);
    die('<!DOCTYPE html><html><head><title>Error</title></head><body style="font-family:Arial;padding:40px">
        <h2 style="color:#cc1824">Application Error</h2>' . $msg . '</body></html>');
}