<?php
// This view is rendered inside auth layout (layouts/auth.php)
// Output only the login card — NO html/head/body tags
?>
<div class="auth-card bg-white/10 border border-white/20 rounded-2xl shadow-2xl w-full max-w-md p-8">
    <!-- Logo -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-secondary rounded-xl shadow-lg mb-4">
            <i class="fas fa-book-open  text-2xl"></i>
        </div>
        <h1 class="font-serif text-2xl font-bold  leading-tight">
            <?= Security::e(getSetting('site_name', APP_NAME)) ?>
        </h1>
        <p class="/60 text-sm mt-1">Admin Panel</p>
    </div>

    <?php if (!empty($error)): ?>
    <div class="bg-red-500/20 border border-red-400/40 text-red-200 rounded-xl px-4 py-3 text-sm flex items-center gap-2 mb-5">
        <i class="fas fa-exclamation-circle flex-shrink-0"></i>
        <?= Security::e($error) ?>
    </div>
    <?php endif; ?>

    <form id="loginForm" method="POST" action="<?= BASE_URL ?>/admin/login" autocomplete="off">
        <?= Security::csrfField() ?>
        <!-- Honeypot -->
        <input type="text" name="website" style="display:none" tabindex="-1" autocomplete="off">

        <div class="space-y-4">
            <!-- Email -->
            <div>
                <label class="block text-sm font-semibold /80 mb-1.5">Email Address</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 /40 text-sm"></i>
                    <input type="email" name="email" required
                        value="<?= Security::e($_POST['email'] ?? '') ?>"
                        placeholder="admin@example.com"
                        class="w-full bg-white/10 border border-white/20  placeholder-black/30 rounded-xl pl-11 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition">
                </div>
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-semibold /80 mb-1.5">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 /40 text-sm"></i>
                    <input type="password" name="password" id="passwordField" required
                        placeholder="Enter your password"
                        class="w-full bg-white/10 border border-white/20  placeholder-black/30 rounded-xl pl-11 pr-12 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent transition">
                    <button type="button" onclick="togglePwd()"
                        class="absolute right-4 top-1/2 -translate-y-1/2 /40 hover:/70 transition">
                        <i id="eyeIcon" class="fas fa-eye text-sm"></i>
                    </button>
                </div>
            </div>
        </div>

        <button id="loginBtn" type="submit"
            class="w-full mt-6 bg-secondary hover:bg-secondary-dark  font-bold py-3.5 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl">
            <i class="fas fa-sign-in-alt"></i>
            Sign In to Admin Panel
        </button>
    </form>

    <p class="text-center /40 text-xs mt-6">
        &copy; <?= date('Y') ?> <?= Security::e(getSetting('site_name', APP_NAME)) ?>. All rights reserved.
    </p>
</div>

<script>
function togglePwd() {
    const f = document.getElementById('passwordField');
    const e = document.getElementById('eyeIcon');
    if (f.type === 'password') { f.type = 'text'; e.className = 'fas fa-eye-slash'; }
    else { f.type = 'password'; e.className = 'fas fa-eye'; }
}
document.getElementById('loginForm').addEventListener('submit', function() {
    const btn = document.getElementById('loginBtn');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Signing In...';
    btn.disabled = true;
});
</script>
