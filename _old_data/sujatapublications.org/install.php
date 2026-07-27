<?php
/**
 * BOOK PUBLICATION CMS — INSTALLER
 * Domain: rainbow.edutechy.in
 * DELETE THIS FILE after setup is complete!
 */
define('ROOT_PATH', __DIR__ . '/bookpub_app');
if (!is_dir(ROOT_PATH)) {
    die('<h2 style="color:red;font-family:Arial;padding:20px">Cannot find bookpub_app/ folder inside public_html/</h2>');
}

// If the user submitted new DB credentials, write them to config.php first
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_db'])) {
    $cfgFile = ROOT_PATH . '/config/config.php';
    $cfg     = file_get_contents($cfgFile);
    $host    = trim($_POST['db_host'] ?? 'localhost');
    $name    = trim($_POST['db_name'] ?? '');
    $user    = trim($_POST['db_user'] ?? '');
    $pass    = $_POST['db_pass'] ?? '';
    $cfg     = preg_replace("/define\\('DB_HOST',\\s*'[^']*'\\);/",   "define('DB_HOST',   '" . addslashes($host) . "');", $cfg);
    $cfg     = preg_replace("/define\\('DB_NAME',\\s*'[^']*'\\);/",   "define('DB_NAME',   '" . addslashes($name) . "');", $cfg);
    $cfg     = preg_replace("/define\\('DB_USER',\\s*'[^']*'\\);/",   "define('DB_USER',   '" . addslashes($user) . "');", $cfg);
    // Use single-quoted replacement so $ in password is safe
    $cfg     = preg_replace("/define\\('DB_PASS',\\s*'[^']*'\\);/",   "define('DB_PASS',   '" . addslashes($pass) . "');", $cfg);
    file_put_contents($cfgFile, $cfg);
    header('Location: install.php?step=test_db');
    exit;
}

require_once ROOT_PATH . '/config/config.php';

$step    = isset($_GET['step']) ? $_GET['step'] : '';
$result  = '';
$success = false;

if ($step === 'test_db') {
    try {
        new PDO('mysql:host=' . DB_HOST . ';charset=utf8mb4', DB_USER, DB_PASS,
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $result  = '&#9989; Connected! Host: <code>' . DB_HOST . '</code> &middot; DB: <code>' . DB_NAME . '</code>';
        $success = true;
    } catch (PDOException $e) {
        $result = '&#10060; Failed: ' . htmlspecialchars($e->getMessage());
    }
}

if ($step === 'migrate_db') {
    try {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS,
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $sql = file_get_contents(ROOT_PATH . '/database/migration.sql');
        // Smart splitter: respects DELIMITER directives so CREATE PROCEDURE bodies
        // (which contain their own semicolons) are kept intact as a single statement.
        $delimiter = ';';
        $buffer    = '';
        $statements = [];
        foreach (preg_split('/\r\n|\r|\n/', $sql) as $line) {
            $trim = trim($line);
            if (preg_match('/^--\s/', $trim) || $trim === '') {
                continue;
            }
            if (preg_match('/^DELIMITER\s+(\S+)/i', $trim, $m)) {
                // Flush the current buffer using the previous delimiter
                if ($buffer !== '') {
                    $statements[] = $buffer;
                    $buffer = '';
                }
                $delimiter = $m[1];
                continue;
            }
            $buffer .= $line . "\n";
            // Check if line ends with the current delimiter
            if (substr($buffer, -strlen($delimiter) - 1) === $delimiter . "\n"
                || substr($buffer, -strlen($delimiter)) === $delimiter) {
                $stmt = rtrim(trim($buffer), $delimiter);
                $stmt = trim($stmt);
                if ($stmt !== '') $statements[] = $stmt;
                $buffer = '';
            }
        }
        if (trim($buffer) !== '') $statements[] = trim($buffer);
        // Reset DB session delimiter (the mysql client uses ;, but PDO exec runs each stmt individually)
        foreach ($statements as $stmt) {
            try { $pdo->exec($stmt); } catch (PDOException $ig) {}
        }
        $result  = '&#9989; Migration applied — schema is up to date.';
        $success = true;
    } catch (PDOException $e) {
        $result = '&#10060; Migration failed: ' . htmlspecialchars($e->getMessage());
    }
}

if ($step === 'import_db') {
    try {
        $pdo = new PDO('mysql:host=' . DB_HOST . ';charset=utf8mb4', DB_USER, DB_PASS,
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $pdo->exec('CREATE DATABASE IF NOT EXISTS `' . DB_NAME . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        $pdo->exec('USE `' . DB_NAME . '`');
        $sql = file_get_contents(ROOT_PATH . '/database/schema.sql');
        foreach (array_filter(array_map('trim', explode(';', $sql))) as $stmt) {
            if (!empty($stmt)) { try { $pdo->exec($stmt); } catch(PDOException $ig) {} }
        }
        $result  = '&#9989; Database imported into <code>' . DB_NAME . '</code>';
        $success = true;
    } catch (PDOException $e) {
        $result = '&#10060; Import failed: ' . htmlspecialchars($e->getMessage());
    }
}

if ($step === 'set_password' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $email   = isset($_POST['email'])    ? trim($_POST['email'])    : 'admin@bookpublication.com';
    $pass    = isset($_POST['password']) ? $_POST['password']       : '';
    $confirm = isset($_POST['confirm'])  ? $_POST['confirm']        : '';
    if (strlen($pass) < 6) {
        $result = '&#10060; Password must be at least 6 characters.';
    } elseif ($pass !== $confirm) {
        $result = '&#10060; Passwords do not match.';
    } else {
        try {
            $pdo  = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $hash = password_hash($pass, PASSWORD_BCRYPT, array('cost' => 10));
            $stmt = $pdo->prepare('UPDATE admins SET password = ? WHERE email = ?');
            $stmt->execute(array($hash, $email));
            if ($stmt->rowCount() === 0) {
                $ins = $pdo->prepare('INSERT INTO admins (name, email, password, role, is_active) VALUES (?,?,?,?,1)');
                $ins->execute(array('Super Admin', $email, $hash, 'super_admin'));
            }
            $result  = '&#9989; Password set! Login with <code>' . htmlspecialchars($email) . '</code> and your new password.';
            $success = true;
        } catch (PDOException $e) {
            $result = '&#10060; Error: ' . htmlspecialchars($e->getMessage());
        }
    }
}

if ($step === 'check_perms') {
    $rows = ''; $allOk = true;
    $dirs = array('books','journals','gallery','board','services','news','payment','seo','settings','content');
    foreach ($dirs as $d) {
        $path = __DIR__ . '/uploads/' . $d;
        if (!is_dir($path)) @mkdir($path, 0755, true);
        $ok = is_writable($path);
        if (!$ok) $allOk = false;
        $rows .= '<tr><td><code>uploads/' . $d . '</code></td><td style="color:' . ($ok ? 'green' : 'red') . '">' . ($ok ? '&#9989; OK' : '&#10060; Not writable') . '</td></tr>';
    }
    $lp = ROOT_PATH . '/storage/logs';
    if (!is_dir($lp)) @mkdir($lp, 0755, true);
    $ok = is_writable($lp); if (!$ok) $allOk = false;
    $rows .= '<tr><td><code>bookpub_app/storage/logs</code></td><td style="color:' . ($ok ? 'green' : 'red') . '">' . ($ok ? '&#9989; OK' : '&#10060; Not writable') . '</td></tr>';
    $result  = '<table style="width:100%">' . $rows . '</table>';
    $success = $allOk;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Installer — Book Publication CMS</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:-apple-system,sans-serif;background:#f0f4f8;padding:20px;min-height:100vh}
.w{max-width:680px;margin:0 auto}
h1{color:#0d3051;font-size:1.4rem;margin-bottom:4px}
.sub{color:#64748b;font-size:.85rem;margin-bottom:20px}
.card{background:#fff;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,.08);margin-bottom:14px;overflow:hidden}
.ch{background:#0d3051;color:#fff;padding:11px 18px;font-weight:600;font-size:.875rem;display:flex;align-items:center;gap:8px}
.n{background:#cc1824;border-radius:50%;width:22px;height:22px;display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:700;flex-shrink:0}
.cb{padding:16px 18px}
.btn{display:inline-block;padding:8px 18px;border-radius:7px;font-size:.82rem;font-weight:600;text-decoration:none;border:none;cursor:pointer;margin-right:8px}
.b{background:#0d3051;color:#fff}.b:hover{background:#1a4a73}
.r{background:#cc1824;color:#fff}.r:hover{background:#a01420}
.g{background:#10b981;color:#fff}
.res{margin-top:10px;padding:10px 14px;border-radius:7px;font-size:.82rem;line-height:1.6}
.ok{background:#d1fae5;border:1px solid #6ee7b7;color:#065f46}
.fail{background:#fee2e2;border:1px solid #fca5a5;color:#991b1b}
pre,code{background:#f1f5f9;padding:2px 5px;border-radius:4px;font-size:.8em}
pre{display:block;padding:10px;overflow-x:auto;line-height:1.5;margin:8px 0}
input[type=text],input[type=email],input[type=password]{width:100%;padding:8px 10px;border:1px solid #d1d5db;border-radius:7px;font-size:.82rem;margin-top:3px;margin-bottom:8px}
label{font-size:.82rem;font-weight:600;color:#374151;display:block}
.warn{background:#fef3c7;border:1px solid #fcd34d;border-radius:8px;padding:12px 16px;color:#92400e;font-size:.82rem;margin-top:10px}
table td{padding:3px 8px}
</style>
</head>
<body>
<div class="w">
<h1>&#128218; Book Publication CMS — Installer</h1>
<p class="sub">Domain: <strong>rainbow.edutechy.in</strong></p>

<div class="card">
<div class="ch"><span class="n">&#9432;</span> Current Structure</div>
<div class="cb" style="font-size:.82rem">
<p style="margin-bottom:8px">Files are deployed like this (everything inside public_html):</p>
<pre>public_html/
  ├── index.php
  ├── install.php  ← this file
  ├── .htaccess
  ├── css/
  ├── uploads/
  └── bookpub_app/
      ├── app/
      ├── config/config.php  ← BASE_URL and DB settings
      └── database/schema.sql</pre>
</div>
</div>

<div class="card">
<div class="ch"><span class="n">1</span>Test Database Connection</div>
<div class="cb">
<p style="font-size:.82rem;margin-bottom:10px">Current DB config: <code><?= DB_HOST ?></code> / <code><?= DB_NAME ?></code> as <code><?= DB_USER ?></code></p>
<a href="?step=test_db" class="btn b">&#128279; Test Connection</a>
<?php if ($step === 'test_db'): ?><div class="res <?= $success ? 'ok' : 'fail' ?>"><?= $result ?></div><?php endif; ?>

<div style="margin-top:14px;padding-top:14px;border-top:1px dashed #e2e8f0">
<p style="font-size:.82rem;margin-bottom:8px;font-weight:600;color:#374151">Update DB credentials (writes to <code>config.php</code>):</p>
<form method="post" style="display:grid;grid-template-columns:1fr 1fr;gap:8px">
    <div><label>Host</label><input type="text" name="db_host" value="<?= htmlspecialchars(DB_HOST) ?>"></div>
    <div><label>Database</label><input type="text" name="db_name" value="<?= htmlspecialchars(DB_NAME) ?>"></div>
    <div><label>User</label><input type="text" name="db_user" value="<?= htmlspecialchars(DB_USER) ?>"></div>
    <div><label>Password</label><input type="password" name="db_pass" value="<?= htmlspecialchars(DB_PASS) ?>"></div>
    <div style="grid-column:1/-1"><button type="submit" name="save_db" value="1" class="btn b">&#128190; Save &amp; Test</button></div>
</form>
<p class="warn" style="margin-top:10px">&#9888;&#65039; For local XAMPP/WAMP use <code>root</code> with no password, then run <strong>Step 2</strong> below to import the database.</p>
</div>
</div>
</div>

<div class="card">
<div class="ch"><span class="n">2</span>Import Database Schema</div>
<div class="cb">
<p style="font-size:.82rem;margin-bottom:10px">Creates all tables + sample data. Run once on fresh install only.</p>
<a href="?step=import_db" class="btn r" onclick="return confirm('Drop and recreate all tables. Continue?')">&#9889; Import Database</a>
<?php if ($step === 'import_db'): ?><div class="res <?= $success ? 'ok' : 'fail' ?>"><?= $result ?></div><?php endif; ?>
</div>
</div>

<div class="card">
<div class="ch"><span class="n">3</span>Apply Latest Schema Updates (for existing installs)</div>
<div class="cb">
<p style="font-size:.82rem;margin-bottom:10px">Only run this if you've already imported the database before and want to apply new column / menu updates.</p>
<a href="?step=migrate_db" class="btn b">&#128260; Run Migrations</a>
<?php if ($step === 'migrate_db'): ?><div class="res <?= $success ? 'ok' : 'fail' ?>"><?= $result ?></div><?php endif; ?>
</div>
</div>

<div class="card">
<div class="ch"><span class="n">4</span>Set Admin Password</div>
<div class="cb">
<form method="POST" action="?step=set_password">
<div style="max-width:340px">
  <label>Admin Email<input type="email" name="email" value="admin@bookpublication.com"></label>
  <label>New Password<input type="password" name="password" placeholder="Min 6 chars" required></label>
  <label>Confirm Password<input type="password" name="confirm" required></label>
  <button type="submit" class="btn b">&#128274; Set Password</button>
</div>
</form>
<?php if ($step === 'set_password'): ?><div class="res <?= $success ? 'ok' : 'fail' ?>"><?= $result ?></div><?php endif; ?>
</div>
</div>

<div class="card">
<div class="ch"><span class="n">5</span>Check File Permissions</div>
<div class="cb">
<a href="?step=check_perms" class="btn b">&#128274; Check Permissions</a>
<?php if ($step === 'check_perms'): ?><div class="res <?= $success ? 'ok' : 'fail' ?>"><?= $result ?></div><?php endif; ?>
</div>
</div>

<div class="card">
<div class="ch"><span class="n">6</span>Login to Admin Panel</div>
<div class="cb">
<p style="font-size:.82rem;margin-bottom:10px">After completing steps 1–3:</p>
<table style="margin-bottom:12px">
<tr><td style="font-weight:600;padding:3px 12px 3px 0;font-size:.82rem">URL</td><td><a href="<?= BASE_URL ?>/admin/login" target="_blank"><?= BASE_URL ?>/admin/login</a></td></tr>
<tr><td style="font-weight:600;padding:3px 12px 3px 0;font-size:.82rem">Email</td><td><code>admin@bookpublication.com</code></td></tr>
<tr><td style="font-weight:600;padding:3px 12px 3px 0;font-size:.82rem">Password</td><td><em>Password you set in Step 3</em></td></tr>
</table>
<a href="<?= BASE_URL ?>/admin/login" class="btn g" target="_blank">&#128640; Go to Admin Login</a>
<a href="<?= BASE_URL ?>/" class="btn b" target="_blank">&#127760; View Website</a>
</div>
</div>

<div class="warn">
&#128465; <strong>Delete install.php after setup!</strong> It exposes database access and must be removed from the server.
</div>
</div>
</body>
</html>
