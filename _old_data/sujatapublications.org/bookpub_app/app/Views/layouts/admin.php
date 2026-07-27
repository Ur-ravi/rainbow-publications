<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= Security::generateCsrfToken() ?>">
    <meta name="base-url" content="<?= BASE_URL ?>">
    <title><?= $pageTitle ?? 'Admin Panel' ?> | <?= APP_NAME ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: { DEFAULT: '#0d3051', light: '#1a4a73', dark: '#081e35', 50: '#e8f0f7' },
                    secondary: { DEFAULT: '#cc1824', light: '#e02230', dark: '#a01420' },
                },
                fontFamily: {
                    display: ['"Playfair Display"', 'serif'],
                    body: ['Inter', 'sans-serif'],
                }
            }
        }
    }
    </script>
    <style>
        .sidebar-link.active { background: rgba(204,24,36,0.15); color: #cc1824; border-left: 3px solid #cc1824; }
        .sidebar-link:not(.active):hover { background: rgba(255,255,255,0.05); }
        .sidebar-group-title { font-size: 10px; text-transform: uppercase; letter-spacing: 0.1em; color: rgba(255,255,255,0.35); padding: 0 1rem; margin-top: 1.5rem; margin-bottom: 0.5rem; }
        #sidebar { transition: width 0.3s ease; }
        body.sidebar-collapsed #sidebar { width: 4rem; }
        body.sidebar-collapsed .sidebar-label { display: none; }
        body.sidebar-collapsed .sidebar-group-title { display: none; }
        body.sidebar-collapsed #mainContent { margin-left: 4rem; }
        #mainContent { transition: margin-left 0.3s ease; }
    </style>
</head>
<body class="font-body bg-gray-100">

<!-- SIDEBAR -->
<aside id="sidebar" class="fixed left-0 top-0 h-full w-64 bg-primary-dark text-white z-50 flex flex-col overflow-hidden">

    <!-- Logo -->
    <div class="flex items-center gap-3 px-4 h-16 border-b border-white/10 flex-shrink-0">
        <div class="w-8 h-8 bg-secondary rounded flex items-center justify-center flex-shrink-0">
            <i class="fas fa-book-open text-white text-sm"></i>
        </div>
        <span class="sidebar-label font-display font-bold text-white text-sm leading-tight">Rainbow Publications<br><span class="text-gray-400 text-xs font-normal">Admin Panel</span></span>
    </div>

    <!-- Nav -->
    <nav class="flex-1 overflow-y-auto py-4 scrollbar-thin">

        <div class="sidebar-group-title">Main</div>
        <a href="<?= BASE_URL ?>/admin/dashboard" class="sidebar-link flex items-center gap-3 px-4 py-2.5 text-gray-300 text-sm <?= str_contains($_SERVER['REQUEST_URI'], 'dashboard') ? 'active' : '' ?>">
            <i class="fas fa-tachometer-alt w-5 text-center"></i><span class="sidebar-label">Dashboard</span>
        </a>

        <div class="sidebar-group-title">Content</div>
        <a href="<?= BASE_URL ?>/admin/books" class="sidebar-link flex items-center gap-3 px-4 py-2.5 text-gray-300 text-sm <?= str_contains($_SERVER['REQUEST_URI'], '/admin/books') ? 'active' : '' ?>">
            <i class="fas fa-books w-5 text-center"></i><span class="sidebar-label">Books</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/journals" class="sidebar-link flex items-center gap-3 px-4 py-2.5 text-gray-300 text-sm <?= str_contains($_SERVER['REQUEST_URI'], '/admin/journals') ? 'active' : '' ?>">
            <i class="fas fa-journal-whills w-5 text-center"></i><span class="sidebar-label">Journals</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/articles" class="sidebar-link flex items-center gap-3 px-4 py-2.5 text-gray-300 text-sm <?= str_contains($_SERVER['REQUEST_URI'], '/admin/articles') ? 'active' : '' ?>">
            <i class="fas fa-file-alt w-5 text-center"></i><span class="sidebar-label">Articles</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/news" class="sidebar-link flex items-center gap-3 px-4 py-2.5 text-gray-300 text-sm <?= str_contains($_SERVER['REQUEST_URI'], '/admin/news') ? 'active' : '' ?>">
            <i class="fas fa-newspaper w-5 text-center"></i><span class="sidebar-label">News / Blog</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/conferences" class="sidebar-link flex items-center gap-3 px-4 py-2.5 text-gray-300 text-sm <?= str_contains($_SERVER['REQUEST_URI'], '/admin/conferences') ? 'active' : '' ?>">
            <i class="fas fa-calendar-alt w-5 text-center"></i><span class="sidebar-label">Conferences</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/gallery" class="sidebar-link flex items-center gap-3 px-4 py-2.5 text-gray-300 text-sm <?= str_contains($_SERVER['REQUEST_URI'], '/admin/gallery') ? 'active' : '' ?>">
            <i class="fas fa-images w-5 text-center"></i><span class="sidebar-label">Gallery</span>
        </a>

        <div class="sidebar-group-title">Members & Plans</div>
        <a href="<?= BASE_URL ?>/admin/memberships" class="sidebar-link flex items-center gap-3 px-4 py-2.5 text-gray-300 text-sm <?= str_contains($_SERVER['REQUEST_URI'], '/admin/memberships') ? 'active' : '' ?>">
            <i class="fas fa-id-card w-5 text-center"></i><span class="sidebar-label">Memberships</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/membership-types" class="sidebar-link flex items-center gap-3 px-4 py-2.5 text-gray-300 text-sm <?= str_contains($_SERVER['REQUEST_URI'], '/admin/membership-types') ? 'active' : '' ?>">
            <i class="fas fa-layer-group w-5 text-center"></i><span class="sidebar-label">Membership Types</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/applications" class="sidebar-link flex items-center gap-3 px-4 py-2.5 text-gray-300 text-sm <?= str_contains($_SERVER['REQUEST_URI'], '/admin/applications') ? 'active' : '' ?>">
            <i class="fas fa-file-signature w-5 text-center"></i><span class="sidebar-label">Applications</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/services" class="sidebar-link flex items-center gap-3 px-4 py-2.5 text-gray-300 text-sm <?= str_contains($_SERVER['REQUEST_URI'], '/admin/services') ? 'active' : '' ?>">
            <i class="fas fa-concierge-bell w-5 text-center"></i><span class="sidebar-label">Services</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/testimonials" class="sidebar-link flex items-center gap-3 px-4 py-2.5 text-gray-300 text-sm <?= str_contains($_SERVER['REQUEST_URI'], '/admin/testimonials') ? 'active' : '' ?>">
            <i class="fas fa-quote-right w-5 text-center"></i><span class="sidebar-label">Testimonials</span>
        </a>

        <div class="sidebar-group-title">Board</div>
        <a href="<?= BASE_URL ?>/admin/board/editorial" class="sidebar-link flex items-center gap-3 px-4 py-2.5 text-gray-300 text-sm <?= str_contains($_SERVER['REQUEST_URI'], '/admin/board/editorial') ? 'active' : '' ?>">
            <i class="fas fa-user-tie w-5 text-center"></i><span class="sidebar-label">Editorial Board</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/board/reviewer" class="sidebar-link flex items-center gap-3 px-4 py-2.5 text-gray-300 text-sm <?= str_contains($_SERVER['REQUEST_URI'], '/admin/board/reviewer') ? 'active' : '' ?>">
            <i class="fas fa-users w-5 text-center"></i><span class="sidebar-label">Reviewer Board</span>
        </a>

        <div class="sidebar-group-title">Communication</div>
        <a href="<?= BASE_URL ?>/admin/contact" class="sidebar-link flex items-center gap-3 px-4 py-2.5 text-gray-300 text-sm <?= str_contains($_SERVER['REQUEST_URI'], '/admin/contact') ? 'active' : '' ?>">
            <i class="fas fa-envelope w-5 text-center"></i>
            <span class="sidebar-label">Messages</span>
            <?php $unread = getAdminUnreadCount(); if ($unread > 0): ?>
            <span class="sidebar-label ml-auto bg-secondary text-white text-xs px-2 py-0.5 rounded-full"><?= $unread ?></span>
            <?php endif; ?>
        </a>
        <a href="<?= BASE_URL ?>/admin/payment" class="sidebar-link flex items-center gap-3 px-4 py-2.5 text-gray-300 text-sm <?= str_contains($_SERVER['REQUEST_URI'], '/admin/payment') ? 'active' : '' ?>">
            <i class="fas fa-credit-card w-5 text-center"></i><span class="sidebar-label">Payment Details</span>
        </a>

        <div class="sidebar-group-title">Configuration</div>
        <a href="<?= BASE_URL ?>/admin/menus" class="sidebar-link flex items-center gap-3 px-4 py-2.5 text-gray-300 text-sm <?= str_contains($_SERVER['REQUEST_URI'], '/admin/menus') ? 'active' : '' ?>">
            <i class="fas fa-bars w-5 text-center"></i><span class="sidebar-label">Menus</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/pages" class="sidebar-link flex items-center gap-3 px-4 py-2.5 text-gray-300 text-sm <?= str_contains($_SERVER['REQUEST_URI'], '/admin/pages') ? 'active' : '' ?>">
            <i class="fas fa-file-alt w-5 text-center"></i><span class="sidebar-label">Content Pages</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/seo" class="sidebar-link flex items-center gap-3 px-4 py-2.5 text-gray-300 text-sm <?= str_contains($_SERVER['REQUEST_URI'], '/admin/seo') ? 'active' : '' ?>">
            <i class="fas fa-search w-5 text-center"></i><span class="sidebar-label">SEO Settings</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/settings" class="sidebar-link flex items-center gap-3 px-4 py-2.5 text-gray-300 text-sm <?= str_contains($_SERVER['REQUEST_URI'], '/admin/settings') ? 'active' : '' ?>">
            <i class="fas fa-cog w-5 text-center"></i><span class="sidebar-label">Website Settings</span>
        </a>
    </nav>

    <!-- Footer -->
    <div class="px-4 py-4 border-t border-white/10 flex-shrink-0">
        <a href="<?= BASE_URL ?>/" target="_blank" class="sidebar-link flex items-center gap-3 text-gray-400 hover:text-white text-sm py-2 transition-colors">
            <i class="fas fa-external-link-alt w-5 text-center text-xs"></i>
            <span class="sidebar-label">View Website</span>
        </a>
        <a href="<?= BASE_URL ?>/admin/logout" class="sidebar-link flex items-center gap-3 text-gray-400 hover:text-red-400 text-sm py-2 transition-colors mt-1">
            <i class="fas fa-sign-out-alt w-5 text-center"></i>
            <span class="sidebar-label">Logout</span>
        </a>
    </div>
</aside>

<!-- MAIN CONTENT -->
<div id="mainContent" class="ml-64">

    <!-- TOP BAR -->
    <header class="sticky top-0 z-40 bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 shadow-sm">
        <div class="flex items-center gap-4">
            <button id="sidebarToggle" class="text-gray-500 hover:text-primary transition-colors p-1">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <div class="hidden md:block">
                <h1 class="text-gray-800 font-semibold text-sm"><?= $pageTitle ?? 'Dashboard' ?></h1>
                <?php if (!empty($breadcrumb)): ?>
                <div class="flex items-center gap-1 text-xs text-gray-400 mt-0.5">
                    <a href="<?= BASE_URL ?>/admin/dashboard" class="hover:text-primary">Dashboard</a>
                    <?php foreach ($breadcrumb as $label => $url): ?>
                    <i class="fas fa-chevron-right text-[10px]"></i>
                    <?php if ($url): ?><a href="<?= $url ?>" class="hover:text-primary"><?= $label ?></a>
                    <?php else: ?><span class="text-gray-600"><?= $label ?></span>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <!-- Notifications -->
            <div class="relative">
                <?php $unread = getAdminUnreadCount(); ?>
                <a href="<?= BASE_URL ?>/admin/contact" class="relative text-gray-500 hover:text-primary transition-colors">
                    <i class="fas fa-bell text-lg"></i>
                    <?php if ($unread > 0): ?>
                    <span class="absolute -top-1.5 -right-1.5 bg-secondary text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold"><?= $unread ?></span>
                    <?php endif; ?>
                </a>
            </div>

            <!-- Admin profile -->
            <div class="relative group">
                <button class="flex items-center gap-2.5 hover:opacity-80 transition-opacity">
                    <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white font-bold text-sm">
                        <?= strtoupper(substr($adminUser['name'] ?? 'A', 0, 1)) ?>
                    </div>
                    <div class="hidden md:block text-left">
                        <div class="text-sm font-semibold text-gray-700"><?= Security::e($adminUser['name'] ?? 'Admin') ?></div>
                        <div class="text-xs text-gray-400 capitalize"><?= Security::e($adminUser['role'] ?? 'admin') ?></div>
                    </div>
                    <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                </button>
                <div class="absolute right-0 top-full mt-2 w-44 bg-white shadow-xl rounded-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    <a href="<?= BASE_URL ?>/admin/settings" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-primary-50 rounded-t-xl transition-colors">
                        <i class="fas fa-cog text-gray-400 w-4"></i> Settings
                    </a>
                    <a href="<?= BASE_URL ?>/" target="_blank" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-primary-50 transition-colors">
                        <i class="fas fa-external-link-alt text-gray-400 w-4"></i> View Site
                    </a>
                    <hr class="border-gray-100">
                    <a href="<?= BASE_URL ?>/admin/logout" class="flex items-center gap-2 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 rounded-b-xl transition-colors">
                        <i class="fas fa-sign-out-alt w-4"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- PAGE CONTENT -->
    <main class="p-6">
        <?= $content ?? '' ?>
    </main>
</div>

<!-- Toast -->
<div id="toast" class="fixed bottom-5 right-5 z-[9999] hidden">
    <div id="toastInner" class="px-5 py-3 rounded-xl shadow-2xl text-white flex items-center gap-3 min-w-[280px]">
        <i id="toastIcon" class="fas fa-check-circle text-lg"></i>
        <span id="toastMsg" class="text-sm font-medium"></span>
    </div>
</div>

<!-- Confirm Modal -->
<div id="confirmModal" class="fixed inset-0 bg-black/50 z-[9998] hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6 text-center">
        <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-trash-alt text-secondary text-xl"></i>
        </div>
        <h3 class="font-semibold text-gray-900 text-lg mb-2">Confirm Delete</h3>
        <p id="confirmMsg" class="text-gray-500 text-sm mb-6">Are you sure you want to delete this item? This action cannot be undone.</p>
        <div class="flex gap-3">
            <button onclick="closeConfirm()" class="flex-1 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">Cancel</button>
            <button id="confirmBtn" class="flex-1 py-2.5 bg-secondary text-white rounded-xl text-sm font-semibold hover:bg-secondary-dark transition-colors">Delete</button>
        </div>
    </div>
</div>

<script>
// Sidebar toggle
document.getElementById('sidebarToggle').addEventListener('click', () => {
    document.body.classList.toggle('sidebar-collapsed');
});

// Toast
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const inner = document.getElementById('toastInner');
    const msg   = document.getElementById('toastMsg');
    const icon  = document.getElementById('toastIcon');
    msg.textContent = message;
    inner.className = `px-5 py-3 rounded-xl shadow-2xl text-white flex items-center gap-3 min-w-[280px] ${type === 'success' ? 'bg-green-600' : 'bg-red-600'}`;
    icon.className  = `fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} text-lg`;
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('hidden'), 4000);
}

// Confirm modal
let confirmCallback = null;
function showConfirm(msg, cb) {
    document.getElementById('confirmMsg').textContent = msg || 'Are you sure?';
    document.getElementById('confirmModal').classList.remove('hidden');
    document.getElementById('confirmModal').classList.add('flex');
    confirmCallback = cb;
}
function closeConfirm() {
    document.getElementById('confirmModal').classList.add('hidden');
    document.getElementById('confirmModal').classList.remove('flex');
    confirmCallback = null;
}
document.getElementById('confirmBtn').addEventListener('click', () => {
    if (confirmCallback) confirmCallback();
    closeConfirm();
});
document.getElementById('confirmModal').addEventListener('click', (e) => {
    if (e.target === e.currentTarget) closeConfirm();
});

// ============================================================
// AJAX helpers
// ============================================================
// Read the CSRF token from the meta tag (always current, not baked at page-load).
function getCsrfToken() {
    const m = document.querySelector('meta[name="csrf-token"]');
    return m ? m.getAttribute('content') : '';
}
function getBaseUrl() {
    const m = document.querySelector('meta[name="base-url"]');
    return m ? m.getAttribute('content').replace(/\/+$/, '') : '';
}
// Resolve a path against the site base. Accepts either a full URL or a path.
function apiUrl(path) {
    if (!path) return getBaseUrl();
    if (/^https?:/i.test(path)) return path;
    return getBaseUrl() + (path.startsWith('/') ? path : '/' + path);
}

// Generic JSON POST. Accepts a FormData or a plain object. Always returns parsed JSON.
async function adminPost(url, data) {
    const fd   = (data instanceof FormData) ? data : new FormData();
    if (!(data instanceof FormData)) {
        for (const [k, v] of Object.entries(data || {})) {
            if (v !== undefined && v !== null) fd.append(k, v);
        }
    }
    // Always set/replace the CSRF token (use the latest one from the meta tag)
    fd.set('csrf_token', getCsrfToken());

    const res = await fetch(apiUrl(url), {
        method:  'POST',
        body:    fd,
        credentials: 'same-origin',
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    });

    // Try to parse JSON regardless of status — server always returns JSON for our routes
    let payload = null;
    try { payload = await res.json(); }
    catch (e) {
        // Server returned HTML (likely login redirect / 404 / 500)
        if (res.status === 401 || res.status === 403) {
            showToast('Session expired. Please log in again.', 'error');
            setTimeout(() => location.href = getBaseUrl() + '/admin/login', 1200);
        } else {
            showToast('Server error (' + res.status + '). Please try again.', 'error');
        }
        throw new Error('Non-JSON response (HTTP ' + res.status + ')');
    }
    return payload;
}

// Standard delete-with-confirm flow. `url` may be a full URL or a path.
// onSuccess: optional callback called with the JSON payload if delete succeeded.
async function adminDelete(url, confirmMsg, onSuccess) {
    if (!confirmMsg) confirmMsg = 'Are you sure? This action cannot be undone.';
    return new Promise((resolve) => {
        showConfirm(confirmMsg, async () => {
            try {
                const res = await adminPost(url, {});
                showToast(res.message || (res.success ? 'Deleted.' : 'Action failed.'),
                          res.success ? 'success' : 'error');
                if (res.success && typeof onSuccess === 'function') onSuccess(res);
                resolve(res);
            } catch (e) {
                showToast('Delete failed. Please try again.', 'error');
                resolve(null);
            }
        });
    });
}

// Generic AJAX form submit with file support
function ajaxForm(formId, successCallback) {
    document.getElementById(formId).addEventListener('submit', async function(e) {
        e.preventDefault();
        const fd    = new FormData(this);
        const btn   = this.querySelector('[type=submit]');
        const orig  = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
        btn.disabled  = true;
        try {
            const res = await fetch(this.action, { method: 'POST', body: fd });
            const d   = await res.json();
            showToast(d.message, d.success ? 'success' : 'error');
            if (d.success && successCallback) successCallback(d);
        } catch(err) {
            showToast('Request failed. Please try again.', 'error');
        }
        btn.innerHTML = orig;
        btn.disabled  = false;
    });
}
</script>
</body>
</html>
