<?php
// ============================================================
// SECURITY CLASS
// ============================================================
class Security {
    public static function generateCsrfToken(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token']      = bin2hex(random_bytes(32));
            $_SESSION['csrf_token_time'] = time();
        }
        return $_SESSION['csrf_token'];
    }

    public static function validateCsrf(string $token): bool {
        if (empty($_SESSION['csrf_token'])) return false;
        if (time() - ($_SESSION['csrf_token_time'] ?? 0) > CSRF_TOKEN_EXPIRE) {
            unset($_SESSION['csrf_token'], $_SESSION['csrf_token_time']);
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    public static function csrfField(): string {
        return '<input type="hidden" name="csrf_token" value="' . self::generateCsrfToken() . '">';
    }

    // PHP 7.4: use $data type as no type hint (was 'mixed' which is PHP 8.0+)
    public static function clean($data) {
        if (is_array($data)) return array_map([self::class, 'clean'], $data);
        return htmlspecialchars(strip_tags(trim((string)$data)), ENT_QUOTES, 'UTF-8');
    }

    public static function e(string $str): string {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }

    public static function cleanHtml($data) {
        if (is_array($data)) {
            return array_map([self::class, 'cleanHtml'], $data);
        }
        return sanitizeServiceHtml((string)$data);
    }

    public static function hashPassword(string $password): string {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    public static function verifyPassword(string $password, string $hash): bool {
        return password_verify($password, $hash);
    }
}

// ============================================================
// TEMPLATE HELPERS
// ============================================================
function csrf_field(): string  { return Security::csrfField(); }
function generate_csrf(): string { return Security::generateCsrfToken(); }
function e(string $s): string  { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

// ============================================================
// URL HELPERS — always absolute, safe from any route depth
// ============================================================

/**
 * Absolute URL to a public asset (css, js, img).
 * Usage: asset('css/style.css') → https://yourdomain.com/css/style.css
 */
function asset(string $path): string {
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}

/**
 * Absolute URL to an app route.
 * Usage: url('about') → https://yourdomain.com/about
 */
function url(string $path = ''): string {
    if (empty($path)) return rtrim(BASE_URL, '/') . '/';
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}

/**
 * Absolute URL to an uploaded file.
 * Usage: uploadUrl('books', 'cover.jpg')
 */
function uploadUrl(string $dir, string $filename): string {
    return rtrim(BASE_URL, '/') . '/uploads/' . trim($dir, '/') . '/' . $filename;
}

/**
 * Upload URL with null safety.
 */
function uploadedImg(string $dir, ?string $filename, string $placeholder = ''): string {
    if (!$filename) return $placeholder ?: asset('img/placeholder.png');
    return uploadUrl($dir, $filename);
}

// ============================================================
// REDIRECT & JSON — PHP 7.4 compatible (no 'never' return type)
// ============================================================

function redirect(string $url): void {
    // Ensure absolute URL
    if (strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
        $url = rtrim(BASE_URL, '/') . '/' . ltrim($url, '/');
    }
    if (headers_sent()) {
        echo '<script>window.location.href="' . htmlspecialchars($url, ENT_QUOTES) . '";</script>';
        exit;
    }
    header('Location: ' . $url, true, 302);
    exit;
}

function jsonResponse(array $data, int $status = 200): void {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    exit;
}

// ============================================================
// AUTHENTICATION
// ============================================================

function isLoggedIn(): bool {
    if (empty($_SESSION['admin_id'])) return false;
    if (!empty($_SESSION['login_time']) && (time() - $_SESSION['login_time']) > SESSION_LIFETIME) {
        session_destroy();
        return false;
    }
    return true;
}

function requireAdmin(): void {
    $sessionId = session_id();
    $adminId   = $_SESSION['admin_id'] ?? 'none';
    $loginTime = $_SESSION['login_time'] ?? 'none';
    $uri       = $_SERVER['REQUEST_URI'] ?? '?';
    error_log("[REQUIRE_ADMIN] uri=$uri session_id=$sessionId admin_id=$adminId login_time=$loginTime");

    if (!isLoggedIn()) {
        error_log("[REQUIRE_ADMIN] BLOCKED — redirecting to login, uri=$uri");
        redirect(BASE_URL . '/admin/login');
    }
    error_log("[REQUIRE_ADMIN] ALLOWED uri=$uri admin_id=$adminId");
}

// ============================================================
// FILE UPLOAD — PHP 7.4: return type string|false → removed union
// ============================================================

function uploadFile(array $file, string $dir, array $allowedTypes = [], int $maxSize = 0) {
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) return false;
    $maxSize = $maxSize ?: MAX_UPLOAD_SIZE;
    if ($file['size'] > $maxSize) return false;
    if (!is_uploaded_file($file['tmp_name'] ?? '')) return false;

    // Reject ANY filename with a path-traversal pattern or null byte or weird chars.
    $origName = (string)($file['name'] ?? '');
    if ($origName === '' || preg_match('/\0|\.\.|\\|\//', $origName)) {
        return false;
    }

    $ext  = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
    // Only allow [a-z0-9] extensions to keep things clean
    if (!preg_match('/^[a-z0-9]{1,8}$/', $ext)) return false;

    // SVG is rejected outright (it can carry <script> / onload).
    // If a caller really needs SVG, they should sanitize it with a dedicated library.
    if ($ext === 'svg') return false;

    $mime = '';
    if (function_exists('finfo_open')) {
        $f    = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($f, $file['tmp_name']);
        finfo_close($f);
    } elseif (function_exists('mime_content_type')) {
        $mime = mime_content_type($file['tmp_name']);
    }

    // For images, do an additional getimagesize() check so a renamed .php.jpg
    // (which would have an image/jpeg MIME only because it isn't really a JPEG)
    // is rejected.
    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true);
    if ($isImage) {
        $info = @getimagesize($file['tmp_name']);
        if ($info === false) return false;
        // Map PHP image-type constant to MIME
        $imagemime = $info['mime'] ?? '';
        if (!in_array($imagemime, $allowedTypes, true)) return false;
    } else {
        // Documents: rely on MIME from finfo. Fall back to a small extension map
        // ONLY for Office files where the MIME reported by finfo is unreliable
        // (.docx → application/zip). The extension map must be one of the
        // explicitly-allowed types in $allowedTypes.
        $extMimeMap = [
            'pdf'  => 'application/pdf',
            'doc'  => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls'  => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];
        $declaredMime = $extMimeMap[$ext] ?? $mime;
        if (!in_array($declaredMime, $allowedTypes, true)) return false;

        // Magic-byte check for PDFs
        if ($ext === 'pdf') {
            $head = @file_get_contents($file['tmp_name'], false, null, 0, 4);
            if ($head !== '%PDF') return false;
        }
        // Magic-byte check for ZIP-based Office formats
        if (in_array($ext, ['docx', 'xlsx'], true)) {
            $head = @file_get_contents($file['tmp_name'], false, null, 0, 4);
            // ZIP magic: PK\x03\x04 OR PK\x05\x06 (empty zip)
            if (!in_array(substr($head, 0, 2), ["PK"], true)) return false;
        }
        // Magic-byte check for legacy .doc / .xls (OLE compound)
        if (in_array($ext, ['doc', 'xls'], true)) {
            $head = @file_get_contents($file['tmp_name'], false, null, 0, 8);
            // OLE2 magic: D0 CF 11 E0 A1 B1 1A E1
            if (bin2hex($head) !== 'd0cf11e0a1b11ae1') return false;
        }
    }

    // Re-check final allowedTypes against the resolved MIME
    if ($allowedTypes && !in_array($mime, $allowedTypes, true) && !in_array(($extMimeMap[$ext] ?? ''), $allowedTypes, true)) {
        return false;
    }

    $filename = bin2hex(random_bytes(8)) . '_' . time() . '.' . $ext;
    $destDir  = rtrim(UPLOAD_PATH, '/') . '/' . trim($dir, '/');
    if (!is_dir($destDir) && !mkdir($destDir, 0755, true)) return false;
    if (!move_uploaded_file($file['tmp_name'], $destDir . '/' . $filename)) return false;
    return $filename;
}

function deleteFile(string $path): bool {
    // H19: prevent path traversal. Resolve the real path and confirm it lives
    // inside UPLOAD_PATH before unlinking.
    $full = rtrim(UPLOAD_PATH, '/') . '/' . ltrim($path, '/');
    $real = realpath($full);
    $base = realpath(UPLOAD_PATH);
    if ($real === false || $base === false) return false;
    if (strpos($real, $base . DIRECTORY_SEPARATOR) !== 0 && $real !== $base) return false;
    return @unlink($real);
}

// ============================================================
// SLUG
// ============================================================

function slug(string $text): string {
    $text = mb_strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}

// ============================================================
// TEXT UTILITIES
// ============================================================

function truncate(string $text, int $length = 150): string {
    $text = strip_tags($text);
    if (mb_strlen($text) <= $length) return $text;
    return mb_substr($text, 0, $length) . '...';
}

function formatDate(string $date, string $format = 'M d, Y'): string {
    return $date ? date($format, strtotime($date)) : '';
}

function timeAgo(string $datetime): string {
    $diff = time() - strtotime($datetime);
    if ($diff < 60)     return 'just now';
    if ($diff < 3600)   return floor($diff / 60) . 'm ago';
    if ($diff < 86400)  return floor($diff / 3600) . 'h ago';
    if ($diff < 604800) return floor($diff / 86400) . 'd ago';
    return date('M d, Y', strtotime($datetime));
}

// ============================================================
// DATABASE-BACKED HELPERS — all wrapped in try/catch
// ============================================================

function getSetting(string $key, string $default = ''): string {
    static $cache = [];
    if (array_key_exists($key, $cache)) return $cache[$key];
    try {
        $db   = Database::getInstance();
        $stmt = $db->prepare("SELECT setting_value FROM settings WHERE setting_key = ? LIMIT 1");
        $stmt->execute([$key]);
        $val       = $stmt->fetchColumn();
        $cache[$key] = ($val !== false && $val !== null) ? (string)$val : $default;
    } catch (Exception $e) {
        $cache[$key] = $default;
    }
    return $cache[$key];
}

function getNavMenus(): array {
    static $menus = null;
    if ($menus !== null) return $menus;
    try {
        $db   = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM menus WHERE parent_id IS NULL AND is_active = 1 ORDER BY sort_order ASC");
        $stmt->execute();
        $parents = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($parents as &$p) {
            $s = $db->prepare("SELECT * FROM menus WHERE parent_id = ? AND is_active = 1 ORDER BY sort_order ASC");
            $s->execute([$p['id']]);
            $p['children'] = $s->fetchAll(PDO::FETCH_ASSOC);
        }
        $menus = $parents;
    } catch (Exception $e) {
        $menus = [];
    }
    return $menus;
}

function getSeo(string $pageKey): array {
    static $cache = [];
    if (isset($cache[$pageKey])) return $cache[$pageKey];
    try {
        $db   = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM seo_settings WHERE page_key = ? LIMIT 1");
        $stmt->execute([$pageKey]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $cache[$pageKey] = $row ?: ['page_title' => APP_NAME, 'meta_description' => ''];
    } catch (Exception $e) {
        $cache[$pageKey] = ['page_title' => APP_NAME, 'meta_description' => ''];
    }
    return $cache[$pageKey];
}

function currentUrl(): string {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    return $scheme . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . ($_SERVER['REQUEST_URI'] ?? '/');
}

function getAdminUnreadCount(): int {
    try {
        $db   = Database::getInstance();
        $stmt = $db->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = 0");
        return (int)$stmt->fetchColumn();
    } catch (Exception $e) {
        return 0;
    }
}

function sanitizeServiceHtml(string $html): string {
    $allowed = '<p><br><strong><b><em><i><u><ul><ol><li><a><span><h3><h4><sub><sup>';
    $html    = strip_tags(trim($html), $allowed);
    $html    = preg_replace('/\s+on\w+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html);
    $html    = preg_replace_callback(
        '/<a\s+([^>]*?)href\s*=\s*(["\'])(.*?)\2([^>]*)>/i',
        function (array $m): string {
            $url = trim($m[3]);
            if (!preg_match('/^(https?:|mailto:|tel:|#|\/)/i', $url)) {
                return '<a href="#" rel="noopener noreferrer">';
            }
            return '<a href="' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . '" rel="noopener noreferrer">';
        },
        $html
    );

    return $html;
}

/**
 * Rich HTML sanitizer for long-form CMS content (books, articles, news, pages).
 * Allows a wider tag set than sanitizeServiceHtml.
 *
 * NOTE: This is a hand-rolled allow-list. For high-stakes deployments with
 *       untrusted authors, swap this for HTMLPurifier or a maintained library.
 */
function sanitizeRichHtml(string $html): string {
    $allowed = '<p><br><hr><strong><b><em><i><u><s><ul><ol><li><a><span><div>'
             . '<h1><h2><h3><h4><h5><h6><blockquote><pre><code><img>'
             . '<table><thead><tbody><tfoot><tr><th><td><sub><sup><figure><figcaption>';
    $html = trim($html);
    $html = strip_tags($html, $allowed);
    // Strip any inline event handlers and javascript: URIs
    $html = preg_replace('/\s+on[a-z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html);
    $html = preg_replace('/javascript\s*:/i', '', $html);
    $html = preg_replace('/vbscript\s*:/i', '', $html);
    $html = preg_replace('/data\s*:\s*text\/html/i', '', $html);
    // Whitelist URLs in href / src
    $html = preg_replace_callback(
        '/(href|src)\s*=\s*(["\'])(.*?)\2/i',
        function (array $m): string {
            $attr  = strtolower($m[1]);
            $quote = $m[2];
            $url   = trim($m[3]);
            // Relative URLs and safe absolute schemes
            if (preg_match('/^(\/|#|https?:|mailto:|tel:)/i', $url)) {
                return $attr . '=' . $quote . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . $quote;
            }
            return $attr . '="about:blank"';
        },
        $html
    );
    return $html;
}

/**
 * Convenience: escape plain text for HTML output. Use this for any DB value
 * that is plain text (not HTML). nl2br keeps line breaks.
 */
function eText(?string $text): string {
    return nl2br(htmlspecialchars((string)$text, ENT_QUOTES, 'UTF-8'));
}

/**
 * H2: Encode a value for safe use inside an HTML attribute that runs JS,
 * e.g. onclick="deleteCat(<?= jsAttr($name) ?>)". This is just a small wrapper
 * around json_encode that produces a quoted, HTML-safe string for inline JS.
 *
 * Usage: onclick="fn(<?= jsAttr($item['name']) ?>)"   -> onclick="fn(&quot;...&quot;)"
 * Or:    onclick='fn(<?= jsAttr($item['name']) ?>)'   -> onclick='fn("...")'  (the JSON quotes are valid JS)
 */
function jsAttr($value): string {
    if ($value === null) return '""';
    if (is_bool($value)) return $value ? 'true' : 'false';
    if (is_int($value) || is_float($value)) return (string)$value;
    return json_encode((string)$value, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
}

function serviceContentHasHtml(string $text): bool {
    return (bool) preg_match('/<\s*\/?\s*(p|br|strong|b|em|i|u|ul|ol|li|a|span|h3|h4|sub|sup)\b/i', $text);
}

function renderServiceSectionContent(string $text): string {
    $text = trim($text);
    if ($text === '') {
        return '';
    }

    if (serviceContentHasHtml($text)) {
        return '<div class="service-rich-content text-gray-700 leading-relaxed space-y-3">' . sanitizeServiceHtml($text) . '</div>';
    }

    $lines  = preg_split('/\r\n|\r|\n/', $text);
    $html   = '';
    $inList = false;

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '') {
            if ($inList) {
                $html .= '</ul>';
                $inList = false;
            }
            continue;
        }

        if (preg_match('/^[•\-\*]\s*(.+)$/u', $line, $m)) {
            if (!$inList) {
                $html .= '<ul class="list-disc pl-5 space-y-2 my-3 text-gray-700">';
                $inList = true;
            }
            $html .= '<li>' . sanitizeServiceHtml($m[1]) . '</li>';
            continue;
        }

        if ($inList) {
            $html .= '</ul>';
            $inList = false;
        }
        $html .= '<p class="text-gray-700 leading-relaxed mb-3">' . sanitizeServiceHtml($line) . '</p>';
    }

    if ($inList) {
        $html .= '</ul>';
    }

    return $html;
}

// ============================================================
// PHP 8.0 POLYFILLS for PHP 7.4 compatibility
// ============================================================
if (!function_exists('str_starts_with')) {
    function str_starts_with(string $haystack, string $needle): bool {
        return strlen($needle) === 0 || strpos($haystack, $needle) === 0;
    }
}
if (!function_exists('str_ends_with')) {
    function str_ends_with(string $haystack, string $needle): bool {
        return strlen($needle) === 0 || substr($haystack, -strlen($needle)) === $needle;
    }
}
if (!function_exists('str_contains')) {
    function str_contains(string $haystack, string $needle): bool {
        return $needle === '' || strpos($haystack, $needle) !== false;
    }
}
