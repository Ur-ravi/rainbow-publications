<?php $seo = $seo ?? ['page_title' => APP_NAME, 'meta_description' => '']; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Security::e($seo['page_title'] ?? APP_NAME) ?></title>
    <meta name="description" content="<?= Security::e($seo['meta_description'] ?? '') ?>">
    <?php if (!empty($seo['meta_keywords'])): ?>
    <meta name="keywords" content="<?= Security::e($seo['meta_keywords'] ?? '') ?>">
    <?php endif; ?>

    <!-- Open Graph -->
    <meta property="og:title" content="<?= Security::e($seo['og_title'] ?? $seo['page_title'] ?? APP_NAME) ?>">
    <meta property="og:description" content="<?= Security::e($seo['og_description'] ?? $seo['meta_description'] ?? '') ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= currentUrl() ?>">
    <?php if (!empty($seo['og_image'])): ?>
    <meta property="og:image" content="<?= uploadUrl('seo', $seo['og_image']) ?>">
    <?php endif; ?>

    <!-- Favicon -->
    <?php $_fav = getSetting('site_favicon'); ?>
    <link rel="icon" type="image/x-icon" href="<?= $_fav ? uploadUrl('settings', $_fav) : asset('img/favicon.ico') ?>">

    <!-- Google Fonts: Manrope + Inter (modern) + Playfair (display accents) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,500&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    /* Legacy names kept so existing markup still works */
                    primary:   { DEFAULT: '<?= htmlspecialchars(getSetting("primary_color", "#4355A5")) ?>', light: '#5a6fb5', dark: '#354590', 50: '#e8eef7' },
                    secondary: { DEFAULT: '<?= htmlspecialchars(getSetting("secondary_color", "#E92C28")) ?>', light: '#f04a47', dark: '#d41f1b' },
                    /* Modern palette */
                    navy:      { DEFAULT: '#0F172A', soft: '#1E293B' },
                    indigo:    { DEFAULT: '#4F46E5', light: '#6366F1' },
                    emerald:   { DEFAULT: '#10B981', dark: '#059669' },
                    cyan:      { DEFAULT: '#06B6D4' },
                    gold:      { DEFAULT: '#F59E0B' },
                },
                fontFamily: {
                    display: ['Manrope', 'Playfair Display', 'serif'],
                    body:    ['Inter', 'Manrope', 'sans-serif'],
                    modern:  ['Manrope', 'Inter', 'sans-serif'],
                },
                boxShadow: {
                    soft:  '0 1px 2px rgba(15,23,42,.04), 0 4px 16px rgba(15,23,42,.06)',
                    card:  '0 2px 8px rgba(15,23,42,.05), 0 12px 32px rgba(15,23,42,.08)',
                    glow:  '0 0 0 1px rgba(79,70,229,.1), 0 8px 30px rgba(79,70,229,.18)',
                },
            }
        }
    }
    </script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= asset('css/style.css?v=4') ?>">
    <?php
    // ============================================================
    // DYNAMIC THEME COLORS FROM ADMIN SETTINGS
    // These override the :root defaults in css/style.css.
    // This block MUST load AFTER the stylesheet link above.
    // ============================================================
    $primaryHex   = getSetting('primary_color',   '#4355A5');
    $secondaryHex = getSetting('secondary_color', '#E92C28');

    function themeVariant(string $hex, int $delta): string {
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        $r = (int)hexdec(substr($hex, 0, 2));
        $g = (int)hexdec(substr($hex, 2, 2));
        $b = (int)hexdec(substr($hex, 4, 2));
        $r = max(0, min(255, $r + $delta));
        $g = max(0, min(255, $g + $delta));
        $b = max(0, min(255, $b + $delta));
        return '#' . str_pad(dechex($r), 2, '0', STR_PAD_LEFT)
                 . str_pad(dechex($g), 2, '0', STR_PAD_LEFT)
                 . str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
    }
    function themeRgb(string $hex): string {
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        return ((int)hexdec(substr($hex, 0, 2))) . ', '
             . ((int)hexdec(substr($hex, 2, 2))) . ', '
             . ((int)hexdec(substr($hex, 4, 2)));
    }
    function themeLuminance(string $hex): string {
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        $r = (int)hexdec(substr($hex, 0, 2)) / 255;
        $g = (int)hexdec(substr($hex, 2, 2)) / 255;
        $b = (int)hexdec(substr($hex, 4, 2)) / 255;
        $lum = (0.299 * $r + 0.587 * $g + 0.114 * $b);
        return $lum > 0.55 ? '#1E2525' : '#ffffff';
    }
    ?>
    <style>
    :root {
        --primary:      <?= $primaryHex ?>;
        --primary-lt:   <?= themeVariant($primaryHex, 30) ?>;
        --primary-dk:   <?= themeVariant($primaryHex, -30) ?>;
        --primary-rgb:  <?= themeRgb($primaryHex) ?>;

        --secondary:    <?= $secondaryHex ?>;
        --secondary-lt: <?= themeVariant($secondaryHex, 30) ?>;
        --secondary-dk: <?= themeVariant($secondaryHex, -30) ?>;
        --secondary-rgb:<?= themeRgb($secondaryHex) ?>;

        --heading:       <?= getSetting('heading_color',   '#1E2525') ?>;
        --text:          <?= getSetting('text_color',      '#1E2525') ?>;
        --text-muted:    <?= getSetting('muted_color',     '#5A6565') ?>;
        --btn-bg:        <?= getSetting('btn_bg_color',    $primaryHex) ?>;
        --btn-text:      <?= getSetting('btn_text_color',  '#ffffff') ?>;
        --header-bg:     <?= getSetting('header_bg_color', '#ffffff') ?>;
        --footer-bg:     <?= getSetting('footer_bg_color', '#1E2525') ?>;
        --footer-text:   <?= themeLuminance(getSetting('footer_bg_color', '#1E2525')) ?>;
        --modal-bg:      <?= getSetting('modal_bg_color',  '#ffffff') ?>;

        --success:       <?= getSetting('success_color', '#27A454') ?>;
        --warning:       <?= getSetting('warning_color', '#F68F22') ?>;
        --danger:        <?= getSetting('danger_color',  '#E92C28') ?>;
    }
    </style>
    <?php
    // Google Analytics
    $_ga = getSetting('google_analytics');
    if ($_ga): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= htmlspecialchars($_ga) ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '<?= htmlspecialchars($_ga) ?>');
    </script>
    <?php endif;
    // Google Tag Manager
    $_gtm = getSetting('gtm_id');
    if ($_gtm): ?>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','<?= htmlspecialchars($_gtm) ?>');</script>
    <?php endif;
    // Custom head scripts (admin-controlled). Block closing </script> to
    // prevent an admin from breaking out of the <script> context.
    $_headScripts = getSetting('head_scripts');
    if ($_headScripts) {
        // Strip </script>, on*= handlers, and javascript: URIs as defense-in-depth
        $_headScripts = preg_replace('#</script\s*>#i', '<\\/script>', $_headScripts);
        echo $_headScripts;
    }
    ?>
</head>
<body class="font-body antialiased" style="color:var(--text, #1E2525); background:var(--bg, #F8F5E9);">

<!-- TOP BAR -->
<div class="hidden lg:block" style="background:var(--text); border-bottom:1px solid rgba(255,255,255,.06);">
    <div class="container mx-auto px-6 flex justify-between items-center py-2">
        <div class="flex items-center gap-5 text-white/65 text-[13px]">
            <a href="mailto:<?= getSetting('site_email') ?>" class="flex items-center gap-2 hover:text-white transition-colors duration-200">
                <span class="w-7 h-7 rounded-md bg-white/8 flex items-center justify-center"><i class="fas fa-envelope text-[11px] text-white/70"></i></span>
                <span class="font-medium"><?= Security::e(getSetting('site_email')) ?></span>
            </a>
            <a href="tel:<?= getSetting('site_phone') ?>" class="flex items-center gap-2 hover:text-white transition-colors duration-200">
                <span class="w-7 h-7 rounded-md bg-white/8 flex items-center justify-center"><i class="fas fa-phone text-[11px] text-white/70"></i></span>
                <span class="font-medium"><?= Security::e(getSetting('site_phone')) ?></span>
            </a>
        </div>
        <div class="flex items-center gap-2">
            <?php foreach (['facebook_url'=>'fab fa-facebook-f','twitter_url'=>'fab fa-twitter','linkedin_url'=>'fab fa-linkedin-in','youtube_url'=>'fab fa-youtube'] as $key=>$icon): ?>
            <?php if ($u = getSetting($key)): ?>
            <a href="<?= Security::e($u) ?>" target="_blank" rel="noopener" class="w-8 h-8 rounded-lg bg-white/6 hover:bg-white/15 flex items-center justify-center text-white/70 hover:text-white transition-all duration-200">
                <i class="<?= $icon ?> text-[11px]"></i>
            </a>
            <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- NAVBAR -->
<nav id="navbar" class="sticky top-0 z-50 transition-all duration-300 border-b border-transparent"
     style="background:var(--header-bg, #ffffff); color:var(--text, #1E2525);"
     aria-label="Main navigation">
    <div class="container mx-auto px-6">
        <div class="flex items-center justify-between h-16 lg:h-[68px]">

            <!-- Logo -->
            <a href="<?= BASE_URL ?>/" class="flex items-center gap-3 flex-shrink-0 group">
                <?php $logo = getSetting('site_logo'); ?>
                <?php if ($logo): ?>
                <img src="<?= uploadUrl('settings', $logo) ?>" alt="<?= Security::e(getSetting('site_name')) ?>" class="h-14 sm:h-12 md:h-14 w-auto max-w-[330px] object-contain">
                <?php else: ?>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-gradient-to-br from-[var(--primary)] to-[var(--primary-lt)] shadow-lg group-hover:scale-105 transition-transform duration-300" style="background:linear-gradient(135deg, var(--primary), var(--primary-lt));">
                        <i class="fas fa-book-open text-white text-base"></i>
                    </div>
                    <div>
                        <div class="font-modern font-extrabold text-[var(--heading)] text-[15px] leading-tight tracking-tight"><?= Security::e(getSetting('site_name', APP_NAME)) ?></div>
                        <div class="text-[var(--text-muted)] text-[10px] leading-tight hidden lg:block font-medium"><?= Security::e(getSetting('site_tagline')) ?></div>
                    </div>
                </div>
                <?php endif; ?>
            </a>

            <!-- Desktop Nav -->
            <div class="hidden lg:flex items-center gap-0.5">
                <?php foreach (getNavMenus() as $item): ?>
                <?php
                    $_url = (string)($item['url'] ?? '');
                    if (preg_match('/^\s*(javascript|vbscript|data):/i', $_url)) $_url = '#';
                    if (preg_match('~^(https?:|mailto:|tel:|#)~i', $_url)) {
                        $_href = $_url;
                    } else {
                        $_href = rtrim(BASE_URL, '/') . '/' . ltrim($_url, '/');
                    }
                    $_target = ($item['target'] ?? '') === '_blank' ? '_blank' : '_self';
                    $_rel    = $_target === '_blank' ? 'rel="noopener noreferrer"' : '';
                ?>
                <?php if (empty($item['children'])): ?>
                <a href="<?= Security::e($_href) ?>"
                   target="<?= $_target ?>" <?= $_rel ?>
                   class="nav-modern px-3.5 py-2 text-[13.5px] font-semibold text-[var(--text-muted)] hover:text-[var(--primary)] rounded-lg transition-colors duration-200">
                    <?= Security::e($item['label']) ?>
                </a>
                <?php else: ?>
                <div class="relative group">
                    <button type="button" aria-haspopup="true" aria-expanded="false" class="parent-dropdown-toggle px-3.5 py-2 text-[13.5px] font-semibold text-[var(--text-muted)] hover:text-[var(--primary)] rounded-lg flex items-center gap-1.5 transition-colors duration-200 cursor-pointer">
                        <?= Security::e($item['label']) ?>
                        <i class="fas fa-chevron-down text-[9px] transition-transform duration-200 group-hover:rotate-180"></i>
                    </button>
                    <div class="absolute top-full left-0 min-w-[240px] pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="bg-[#F8F5E9] rounded-2xl shadow-lg p-1.5 border border-slate-100/80">
                            <?php foreach ($item['children'] as $child): ?>
                            <?php
                                $_cUrl = (string)($child['url'] ?? '');
                                if (preg_match('/^\s*(javascript|vbscript|data):/i', $_cUrl)) $_cUrl = '#';
                                if (preg_match('~^(https?:|mailto:|tel:|#)~i', $_cUrl)) {
                                    $_cHref = $_cUrl;
                                } else {
                                    $_cHref = rtrim(BASE_URL, '/') . '/' . ltrim($_cUrl, '/');
                                }
                                $_cTarget = ($child['target'] ?? '') === '_blank' ? '_blank' : '_self';
                                $_cRel    = $_cTarget === '_blank' ? 'rel="noopener noreferrer"' : '';
                            ?>
                            <a href="<?= Security::e($_cHref) ?>" target="<?= $_cTarget ?>" <?= $_cRel ?>
                               class="flex items-center gap-2.5 px-4 py-2.5 text-sm font-medium text-[var(--text)] hover:bg-[var(--primary)] hover:text-white rounded-xl transition-all duration-200">
                                <i class="fas fa-angle-right text-[10px] opacity-50"></i><?= Security::e($child['label']) ?>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <!-- Mobile hamburger -->
            <button id="mobileMenuBtn" class="lg:hidden p-2.5 rounded-xl text-[var(--text)] hover:bg-black/5 transition-colors" aria-label="Open menu" aria-expanded="false">
                <span class="flex flex-col gap-1.5 w-5">
                    <span class="block h-[2px] bg-current rounded-full transition-all duration-300 origin-center" id="bar1"></span>
                    <span class="block h-[2px] bg-current rounded-full transition-all duration-300" id="bar2"></span>
                    <span class="block h-[2px] bg-current rounded-full transition-all duration-300 origin-center" id="bar3"></span>
                </span>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden lg:hidden border-t border-slate-100 bg-white/95 backdrop-blur-lg">
        <div class="px-4 pb-5 pt-2 max-h-[70vh] overflow-y-auto">
        <?php foreach (getNavMenus() as $item): ?>
        <?php
            $_mUrl = (string)($item['url'] ?? '');
            if (preg_match('/^\s*(javascript|vbscript|data):/i', $_mUrl)) $_mUrl = '#';
            if (preg_match('~^(https?:|mailto:|tel:|#)~i', $_mUrl)) {
                $_mHref = $_mUrl;
            } else {
                $_mHref = rtrim(BASE_URL, '/') . '/' . ltrim($_mUrl, '/');
            }
        ?>
        <?php if (empty($item['children'])): ?>
        <a href="<?= Security::e($_mHref) ?>" class="block py-3 px-3 text-sm font-semibold text-[var(--text)] hover:text-[var(--primary)] hover:bg-black/[.03] rounded-xl transition-colors">
            <?= Security::e($item['label']) ?>
        </a>
        <?php else: ?>
        <div>
            <div class="flex items-center justify-between hover:bg-black/[.03] rounded-xl">
                <span class="mobile-parent-label flex-1 py-3 px-3 text-sm font-semibold text-[var(--text)] cursor-pointer select-none" role="button" tabindex="0" aria-haspopup="true" aria-expanded="false">
                    <?= Security::e($item['label']) ?>
                </span>
                <button type="button" class="mobile-dropdown-btn p-3 text-[var(--text-muted)]" aria-label="Toggle submenu">
                    <i class="fas fa-chevron-down text-[10px] transition-transform"></i>
                </button>
            </div>
            <div class="mobile-dropdown hidden pl-5 pb-1">
                <?php foreach ($item['children'] as $child): ?>
                <?php
                    $_mcUrl = (string)($child['url'] ?? '');
                    if (preg_match('/^\s*(javascript|vbscript|data):/i', $_mcUrl)) $_mcUrl = '#';
                    if (preg_match('~^(https?:|mailto:|tel:|#)~i', $_mcUrl)) {
                        $_mcHref = $_mcUrl;
                    } else {
                        $_mcHref = rtrim(BASE_URL, '/') . '/' . ltrim($_mcUrl, '/');
                    }
                ?>
                <a href="<?= Security::e($_mcHref) ?>" class="block py-2.5 text-sm text-[var(--text-muted)] hover:text-[var(--primary)]">
                    <?= Security::e($child['label']) ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        <?php endforeach; ?>
        </div>
    </div>
</nav>

<!-- MAIN CONTENT -->
<main>
<?= $content ?? '' ?>
</main>

<!-- FOOTER -->
<footer class="relative site-footer" style="background: linear-gradient(160deg,#003098 0%,#0049b7 35%,#0067b2 70%,#efeacd 100%);">
    <div class="footer-topborder"></div>

    <!-- Newsletter strip -->
    <div class="border-b border-white/8">
        <div class="container mx-auto px-6 py-12">
            <div class="grid lg:grid-cols-2 gap-8 items-center max-w-5xl mx-auto text-center lg:text-left">
                <div>
                    <h3 class="font-modern font-extrabold text-2xl text-white mb-2 tracking-tight">Stay in the loop</h3>
                    <p class="text-white text-sm leading-relaxed">Get the latest publications, journal calls, and academic news delivered to your inbox.</p>
                </div>
                <form onsubmit="event.preventDefault(); showToast('Thank you for subscribing!','success'); this.reset();" class="flex gap-3 max-w-md lg:ml-auto w-full mx-auto lg:mx-0">
                    <input type="email" required placeholder="Enter your email address" class="newsletter-input flex-1">
                    <button type="submit" class="btn-modern btn-modern-primary whitespace-nowrap text-sm !py-3 !px-5">Subscribe</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main footer -->
    <div class="pt-16 pb-8">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-10 lg:gap-8">

                <!-- Brand -->
                <div class="lg:col-span-2">
                    <a href="<?= BASE_URL ?>/" class="flex items-center gap-3 flex-shrink-0 group mb-5">
                        <?php $logo = getSetting('site_logo'); ?>
                        <?php if ($logo): ?>
                        <img src="<?= uploadUrl('settings', $logo) ?>" alt="<?= Security::e(getSetting('site_name')) ?>" class="h-10 w-auto object-contain">
                        <?php else: ?>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-white group-hover:scale-105 transition-transform duration-300">
                                <i class="fas fa-book-open text-white text-base"></i>
                            </div>
                            <div>
                                <div class="font-modern font-extrabold text-white text-[15px] leading-tight tracking-tight"><?= Security::e(getSetting('site_name', APP_NAME)) ?></div>
                                <div class="text-white text-[10px] leading-tight font-medium"><?= Security::e(getSetting('site_tagline')) ?></div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </a>
                    <p class="text-white text-sm leading-relaxed max-w-sm"><?= Security::e(getSetting('footer_about')) ?></p>
                    <div class="flex gap-2.5 mt-6">
                        <?php foreach (['facebook_url'=>'fab fa-facebook-f','twitter_url'=>'fab fa-twitter','linkedin_url'=>'fab fa-linkedin-in','instagram_url'=>'fab fa-instagram','youtube_url'=>'fab fa-youtube'] as $key=>$icon): ?>
                        <?php if ($url = getSetting($key)): ?>
                        <a href="<?= Security::e($url) ?>" target="_blank" rel="noopener" class="w-9 h-9 bg-white/6 hover:bg-white/15 rounded-xl flex items-center justify-center text-sm text-white hover:text-white transition-all duration-200">
                            <i class="<?= $icon ?>"></i>
                        </a>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-modern font-bold text-white text-[13px] uppercase tracking-wider mb-5">Quick Links</h4>
                    <ul class="space-y-3">
                        <?php foreach ([['Home','/'],['About Us','/about'],['All Books','/books'],['Our Journals','/journals'],['Membership','/membership'],['Contact Us','/contact']] as [$label,$url]): ?>
                        <li><a href="<?= BASE_URL . $url ?>" class="text-white hover:text-white/70 text-[13.5px] flex items-center gap-2.5 transition-all duration-200 hover:translate-x-0.5">
                            <span class="w-1 h-1 rounded-full bg-white/20 group-hover:bg-white/60 transition-colors"></span><?= $label ?>
                        </a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Policies -->
                <div>
                    <h4 class="font-modern font-bold text-white text-[13px] uppercase tracking-wider mb-5">Policies</h4>
                    <ul class="space-y-3">
                        <?php foreach ([
                            ['Privacy Policy', '/policies/privacy-policy'],
                            ['Cancellation & Refund', '/policies/cancellation-refund'],
                            ['Shipping & Delivery', '/policies/shipping-delivery'],
                        ] as [$label, $url]): ?>
                        <li><a href="<?= BASE_URL . $url ?>" class="text-white hover:text-white/70 text-[13.5px] flex items-center gap-2.5 transition-all duration-200 hover:translate-x-0.5">
                            <span class="w-1 h-1 rounded-full bg-white/20"></span><?= $label ?>
                        </a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-modern font-bold text-white text-[13px] uppercase tracking-wider mb-5">Contact Info</h4>
                    <ul class="space-y-3.5">
                        <li class="flex gap-3 text-white text-[13.5px]">
                            <i class="fas fa-map-marker-alt mt-0.5 flex-shrink-0 hover:text-white/70 text-white/40 text-xs"></i>
                            <span><?= Security::e(getSetting('site_address')) ?></span>
                        </li>
                        <li>
                            <a href="mailto:<?= getSetting('site_email') ?>" class="flex gap-3 text-white hover:text-white/70 text-[13.5px] transition-colors">
                                <i class="fas fa-envelope mt-0.5 flex-shrink-0 text-white/30 text-xs"></i>
                                <span><?= Security::e(getSetting('site_email')) ?></span>
                            </a>
                        </li>
                        <li>
                            <a href="tel:<?= getSetting('site_phone') ?>" class="flex gap-3 text-white hover:text-white/70 text-[13.5px] transition-colors">
                                <i class="fas fa-phone mt-0.5 flex-shrink-0 text-white/30 text-xs"></i>
                                <span><?= Security::e(getSetting('site_phone')) ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="border-t border-black/8 py-6">
        <div class="container mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-black text-[13px]"><?= Security::e(getSetting('footer_copyright')) ?></p>
            <div class="flex flex-wrap justify-center gap-x-6 gap-y-2 text-[13px]">
                <a href="<?= BASE_URL ?>/policies/privacy-policy" class="text-black hover:text-white/80 transition-colors">Privacy Policy</a>
                <a href="<?= BASE_URL ?>/policies/cancellation-refund" class="text-black hover:text-white/80 transition-colors">Cancellation & Refund</a>
                <a href="<?= BASE_URL ?>/policies/shipping-delivery" class="text-black hover:text-white/80 transition-colors">Shipping & Delivery</a>
                <a href="<?= BASE_URL ?>/contact" class="text-black hover:text-white/80 transition-colors">Contact</a>
            </div>
        </div>
    </div>
</footer>

<!-- Toast Notification -->
<div id="toast" class="fixed bottom-5 right-5 z-[9999] hidden">
    <div id="toastInner" class="px-5 py-3.5 rounded-2xl shadow-2xl text-white flex items-center gap-3 min-w-[280px]">
        <i id="toastIcon" class="fas fa-check-circle text-lg"></i>
        <span id="toastMsg" class="text-sm font-semibold"></span>
    </div>
</div>

<!-- Scripts -->
<script>
// Mobile menu
document.getElementById('mobileMenuBtn').addEventListener('click', () => {
    document.getElementById('mobileMenu').classList.toggle('hidden');
});
document.querySelectorAll('.mobile-dropdown-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        btn.nextElementSibling.classList.toggle('hidden');
        btn.querySelector('i').classList.toggle('rotate-180');
        const expanded = !btn.nextElementSibling.classList.contains('hidden');
        btn.setAttribute('aria-expanded', expanded ? 'true' : 'false');
    });
});

// Mobile parent label: clicking the label itself should toggle the dropdown
// (parent dropdown items must NOT navigate — they only act as toggles)
document.querySelectorAll('.mobile-parent-label').forEach(label => {
    const toggle = () => {
        const dropdown = label.parentElement.nextElementSibling;
        const chevronBtn = label.parentElement.querySelector('.mobile-dropdown-btn');
        if (!dropdown) return;
        dropdown.classList.toggle('hidden');
        if (chevronBtn) {
            chevronBtn.querySelector('i').classList.toggle('rotate-180');
            const expanded = !dropdown.classList.contains('hidden');
            chevronBtn.setAttribute('aria-expanded', expanded ? 'true' : 'false');
            label.setAttribute('aria-expanded', expanded ? 'true' : 'false');
        }
    };
    label.addEventListener('click', toggle);
    label.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); toggle(); }
    });
});

// Desktop parent dropdown toggles: support click + keyboard activation
// (parent items act only as toggles, not navigation)
document.querySelectorAll('.parent-dropdown-toggle').forEach(toggle => {
    toggle.addEventListener('click', (e) => {
        e.preventDefault();
        const expanded = toggle.getAttribute('aria-expanded') === 'true';
        toggle.setAttribute('aria-expanded', expanded ? 'false' : 'true');
    });
    toggle.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            const expanded = toggle.getAttribute('aria-expanded') === 'true';
            toggle.setAttribute('aria-expanded', expanded ? 'false' : 'true');
        }
    });
});

// Navbar scroll -> glass effect
const nav = document.getElementById('navbar');
function onScroll() {
    if (window.scrollY > 30) {
        nav.classList.add('glass-nav','shadow-soft');
        nav.classList.remove('bg-white/95');
    } else {
        nav.classList.remove('glass-nav','shadow-soft');
        nav.classList.add('bg-white/95');
    }
}
window.addEventListener('scroll', onScroll); onScroll();

// Toast
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast'), inner = document.getElementById('toastInner');
    const msg = document.getElementById('toastMsg'), icon = document.getElementById('toastIcon');
    msg.textContent = message;
    let bg = 'bg-emerald';
    let ic = 'fa-check-circle';
    if (type === 'error')  { bg = 'bg-rose-600'; ic = 'fa-exclamation-circle'; }
    if (type === 'warning'){ bg = 'bg-amber-500'; ic = 'fa-exclamation-triangle'; }
    inner.className = `px-5 py-3.5 rounded-2xl shadow-2xl text-white flex items-center gap-3 min-w-[280px] ${bg}`;
    icon.className = `fas ${ic} text-lg`;
    toast.classList.remove('hidden');
    toast.style.animation = 'slideIn 0.3s ease';
    setTimeout(() => { toast.classList.add('hidden'); }, 4500);
}
async function ajaxPost(url, formData) {
    const res = await fetch(url, { method: 'POST', body: formData });
    return await res.json();
}

// Lazy load images
document.addEventListener('DOMContentLoaded', () => {
    const imgs = document.querySelectorAll('img[data-src]');
    const obs = new IntersectionObserver((entries) => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.src = e.target.dataset.src; obs.unobserve(e.target); } });
    });
    imgs.forEach(img => obs.observe(img));
});

// Scroll reveal (AOS-style, no library)
(function() {
    const els = document.querySelectorAll('[data-reveal]');
    if (!els.length) return;
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    els.forEach(el => io.observe(el));
})();

// Animated counters
(function() {
    const counters = document.querySelectorAll('[data-counter]');
    if (!counters.length) return;
    const animate = (el) => {
        const target = parseFloat(el.dataset.counter);
        const suffix = el.dataset.suffix || '';
        const dur = 1600; const start = performance.now();
        const step = (now) => {
            const p = Math.min((now - start) / dur, 1);
            const eased = 1 - Math.pow(1 - p, 3);
            const val = target * eased;
            el.textContent = (target % 1 === 0 ? Math.floor(val) : val);
        };
        const raf = (t) => { step(t); if (performance.now() - start < dur) requestAnimationFrame(raf); };
        requestAnimationFrame(raf);
    };
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => { if (e.isIntersecting) { animate(e.target); io.unobserve(e.target); } });
    }, { threshold: 0.5 });
    counters.forEach(c => io.observe(c));
})();
</script>

<style>
@keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
</style>
<?php
// Custom body scripts (admin-controlled). Block closing </script> to
// prevent an admin from breaking out of the <script> context.
$_bodyScripts = getSetting('body_scripts');
if ($_bodyScripts) {
    $_bodyScripts = preg_replace('#</script\s*>#i', '<\\/script>', $_bodyScripts);
    echo $_bodyScripts;
}
?>
</body>
</html>
