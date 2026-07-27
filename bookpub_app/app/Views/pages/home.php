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

    <!-- Fonts: Inter (display + body) + IBM Plex Mono (data) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '<?= htmlspecialchars(getSetting("primary_color", "#10B981")) ?>',
                            light: '#34D399',
                            dark: '#059669',
                            50: '#F0FDF4'
                        },
                        secondary: {
                            DEFAULT: '<?= htmlspecialchars(getSetting("secondary_color", "#1F2937")) ?>',
                            light: '#374151',
                            dark: '#111827'
                        },
                        accent: {
                            DEFAULT: '#0EA5E9',
                            light: '#38BDF8',
                            dark: '#0284C7'
                        },
                        slate: {
                            50: '#F8FAFC',
                            100: '#F1F5F9',
                            200: '#E2E8F0',
                            300: '#CBD5E1',
                            400: '#94A3B8',
                            500: '#64748B',
                            600: '#475569',
                            700: '#334155',
                            800: '#1E293B',
                            900: '#0F172A'
                        },
                    },
                    fontFamily: {
                        display: ['Inter', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                        mono: ['IBM Plex Mono', 'monospace'],
                    },
                    borderRadius: {
                        sm: '4px',
                        md: '8px',
                        lg: '12px',
                        xl: '16px',
                    }
                }
            }
        }
    </script>

    <!-- Global Stylesheet -->
    <!-- GSAP + ScrollTrigger -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">

    <!-- Modern Minimalist Design System -->
    <style>
        :root {
            --primary: #003098;
            --primary-light: #0067b2;
            --primary-dark: #05538b;
            --secondary: #1F2937;
            --accent: #003098;
            --slate-50: #F8FAFC;
            --slate-100: #F1F5F9;
            --slate-200: #E2E8F0;
            --slate-300: #CBD5E1;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-800: #1E293B;
            --slate-900: #0F172A;
            --text-primary: #0F172A;
            --text-secondary: #475569;
            --border-color: #E2E8F0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            background: var(--slate-50);
        }

        /* Typography System */
        .heading-xl {
            font-size: 3.5rem;
            line-height: 1.1;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .heading-lg {
            font-size: 2.5rem;
            line-height: 1.2;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        .heading-md {
            font-size: 1.875rem;
            line-height: 1.3;
            font-weight: 700;
        }

        .heading-sm {
            font-size: 1.25rem;
            line-height: 1.4;
            font-weight: 600;
        }

        .label {
            font-size: 0.75rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            font-weight: 600;
            color: var(--slate-600);
        }

        .caption {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        /* Gradient Accent Line */
        .gradient-line {
            height: 3px;
            background: linear-gradient(90deg, #003098 0%, #0067b2 50%, #05538b 100%);
            margin: 2rem 0;
            border-radius: 2px;
        }

        /* Card System */
        .card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card:hover {
            border-color: var(--primary);
            box-shadow: 0 10px 30px rgba(0, 48, 152, 0.08);
            transform: translateY(-2px);
        }

        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.875rem 1.5rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: 1.5px solid transparent;
            cursor: pointer;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            box-shadow: 0 8px 20px rgba(0, 48, 152, 0.25);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: transparent;
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-secondary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        .btn-ghost {
            background: var(--slate-100);
            color: var(--secondary);
            border-color: transparent;
        }

        .btn-ghost:hover {
            background: var(--slate-200);
            transform: translateY(-2px);
        }

        /* Link Arrow */
        .link-arrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--primary);
            text-decoration: none;
            transition: gap 0.3s ease;
        }

        .link-arrow:hover {
            gap: 0.75rem;
        }

        .link-arrow i {
            font-size: 0.75rem;
            transition: transform 0.3s ease;
        }

        .link-arrow:hover i {
            transform: translateX(3px);
        }

        /* Section Styling */
        section {
            position: relative;
        }

        .section-header {
            margin-bottom: 3rem;
        }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.75rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .section-label::before {
            content: '';
            width: 24px;
            height: 3px;
            background: var(--primary);
            border-radius: 2px;
        }

        /* Badge/Tag */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 0.8rem;
            background: var(--slate-100);
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-secondary);
        }

        .badge-primary {
            background: rgba(0, 48, 152, 0.1);
            color: var(--primary-dark);
        }

        .badge-accent {
            background: rgba(0, 103, 178, 0.1);
            color: var(--accent);
        }

        /* Hero Section */
        .hero {
            /*background: linear-gradient(135deg, var(--slate-900) 0%, var(--secondary) 100%);*/
            background: url('/uploads/hero.jpg') no-repeat center center;
            background-size: cover;

            color: white;
            padding: 6rem 0;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            right: -30%;
            width: 60%;
            height: 100%;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        /* Grid Animations */
        [data-reveal] {
            opacity: 1;
        }

        /* Stat Counter */
        .counter-num {
            font-weight: 800;
            font-family: 'IBM Plex Mono', monospace;
        }

        /* News/Blog Grid */
        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
        }

        /* Board Members Grid */
        .board-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
        }

        .board-member {
            text-align: center;
            padding: 1.5rem;
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .board-member:hover {
            border-color: var(--primary);
            box-shadow: 0 8px 20px rgba(0, 48, 152, 0.08);
            transform: translateY(-4px);
        }

        .board-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 1rem;
            object-fit: cover;
            border: 3px solid var(--border-color);
        }

        .board-ring {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--primary);
            color: white;
            font-size: 2rem;
        }

        /* Testimonial Card */
        .testimonial-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            border-color: var(--primary);
            box-shadow: 0 10px 30px rgba(0, 48, 152, 0.08);
            transform: translateY(-4px);
        }

        .stars {
            display: flex;
            gap: 0.25rem;
            color: #FBBF24;
            font-size: 0.875rem;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        .testimonial-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            flex-shrink: 0;
        }

        /* Trust Badges Strip */
        .trust-strip {
            background: white;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            padding: 2rem 0;
        }

        .trust-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: center;
            align-items: center;
        }

        .trust-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .trust-badge i {
            color: var(--primary);
            font-size: 1rem;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            color: white;
            padding: 5rem 2rem;
            text-align: center;
            border-radius: 16px;
        }

        .cta-section .heading-lg {
            color: white;
            margin-bottom: 1rem;
        }

        /* Service Card */
        .service-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 2rem;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .service-card:hover {
            border-color: var(--primary);
            box-shadow: 0 10px 30px rgba(0, 48, 152, 0.08);
            transform: translateY(-4px);
        }

        .service-icon {
            width: 56px;
            height: 56px;
            border-radius: 8px;
            background: rgba(0, 48, 152, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .service-card:hover .service-icon {
            background: var(--primary);
            color: white;
            transform: scale(1.1);
        }

        /* Journal Card */
        .journal-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .journal-card:hover {
            border-color: var(--primary);
            box-shadow: 0 8px 20px rgba(0, 48, 152, 0.08);
            transform: translateY(-2px);
        }

        .journal-logo {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            background: var(--slate-100);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-bottom: 1rem;
        }

        /* Book Card */
        .book-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .book-card:hover {
            border-color: var(--primary);
            box-shadow: 0 12px 30px rgba(0, 48, 152, 0.1);
            transform: translateY(-4px);
        }

        .book-cover {
            width: 100%;
            height: 250px;
            background: var(--slate-200);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: var(--text-secondary);
        }

        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .book-card:hover .book-cover img {
            transform: scale(1.05);
        }

        .book-info {
            padding: 1.5rem;
        }

        /* Conference Card */
        .conference-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .conference-card:hover {
            border-color: var(--primary);
            box-shadow: 0 12px 30px rgba(0, 48, 152, 0.1);
            transform: translateY(-4px);
        }

        .conference-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(0, 48, 152, 0.1);
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 1rem;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 3rem;
            color: var(--slate-300);
            margin-bottom: 1rem;
            display: block;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .heading-xl {
                font-size: 2rem;
            }

            .heading-lg {
                font-size: 1.875rem;
            }

            .hero {
                padding: 4rem 0;
            }

            .trust-badges {
                gap: 1rem;
            }

            .board-grid {
                grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            }
        }

        /* Motion Preferences */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation: none !important;
                transition: none !important;
            }
        }

        /* ══════════════════════════════════════════════
           INTERACTIVE BOX EFFECTS
           Cursor-follow spotlight glow + depth, applied to
           every card/box type already used across the page.
           ══════════════════════════════════════════════ */
        .card,
        .book-card,
        .service-card,
        .journal-card,
        .testimonial-card,
        .board-member,
        .conference-card {
            position: relative;
            overflow: hidden;
            will-change: transform;
        }

        .card::before,
        .book-card::before,
        .service-card::before,
        .journal-card::before,
        .testimonial-card::before,
        .board-member::before,
        .conference-card::before {
            content: '';
            position: absolute;
            inset: 0;
            z-index: -1;
            background: radial-gradient(280px circle at var(--mx, 50%) var(--my, 50%), rgba(0, 48, 152, 0.14), transparent 70%);
            opacity: 0;
            transition: opacity .4s ease;
            pointer-events: none;
        }

        .card:hover::before,
        .book-card:hover::before,
        .service-card:hover::before,
        .journal-card:hover::before,
        .testimonial-card:hover::before,
        .board-member:hover::before,
        .conference-card:hover::before {
            opacity: 1;
        }

        /* Sheen sweep on primary buttons */
        .btn-primary {
            position: relative;
            overflow: hidden;
        }

        .btn-primary::after {
            content: '';
            position: absolute;
            top: 0;
            left: -60%;
            width: 40%;
            height: 100%;
            background: linear-gradient(115deg, transparent, rgba(0, 48, 152, 0.35), transparent);
            transform: skewX(-20deg);
            transition: left .6s ease;
        }

        .btn-primary:hover::after {
            left: 130%;
        }

        /* Hero stat cards — used as a GSAP hook, no visual change */
        .hero-stats .bg-white\/10 {
            will-change: transform, opacity;
        }
    </style>

    <?php
    // Analytics / GTM / head scripts
    $_ga = getSetting('google_analytics');
    if ($_ga): ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?= htmlspecialchars($_ga) ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '<?= htmlspecialchars($_ga) ?>');
        </script>
    <?php endif;
    $_gtm = getSetting('gtm_id');
    if ($_gtm): ?>
        <script>
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', '<?= htmlspecialchars($_gtm) ?>');
        </script>
    <?php endif;
    $_headScripts = getSetting('head_scripts');
    if ($_headScripts) {
        $_headScripts = preg_replace('#</script\s*>#i', '<\\/script>', $_headScripts);
        echo $_headScripts;
    }
    ?>
</head>

<body>

    <?php
    /*
  ════════════════════════════════════════════════════════════════
  REDESIGNED HOME PAGE — Modern Minimalist Aesthetic
  ════════════════════════════════════════════════════════════════
  All PHP functionality preserved. Only visual design and section
  order changed. All data-reveal, counter-num, loops, conditionals
  remain 100% intact.
  ════════════════════════════════════════════════════════════════
*/
    ?>

    <!-- ═══════════════════════════════════════════════════════════
     SECTION 1 — HERO
     ═══════════════════════════════════════════════════════════ -->
    <?php
    /**
     * Rainbow Publications — "image letters" hero
     * Converted from React/TSX to plain PHP + HTML + vanilla JS.
     */

    $letters = [
        ["char" => "R", "img" => "https://images.unsplash.com/photo-1615012553971-f7251c225e01?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", "label" => "red"],
        ["char" => "A", "img" => "https://images.unsplash.com/photo-1613216512260-494def845d68?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", "label" => "amber"],
        ["char" => "I", "img" => "https://images.unsplash.com/photo-1527190997915-67ce3b53cc58?w=400&h=600&fit=crop&auto=format", "label" => "indigo"],
        ["char" => "N", "img" => "https://images.unsplash.com/photo-1618890334461-c33a04c4c916?w=400&h=600&fit=crop&auto=format", "label" => "night"],
        ["char" => "B", "img" => "https://images.unsplash.com/photo-1552083940-86877723de7a?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", "label" => "blue"],
        ["char" => "O", "img" => "https://images.unsplash.com/photo-1615917063963-ea6376145a96?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", "label" => "orchid"],
        ["char" => "W", "img" => "https://images.unsplash.com/photo-1563089145-599997674d42?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D", "label" => "wine"],
    ];

    // letter float offsets from original array [0, -8, 4, -6, 2, -4, 0]
    $letterOffsets = [0, -8, 4, -6, 2, -4, 0];

    $cards = [
        [
            "title" => "The Midnight Library",
            "author" => "Matt Haig",
            "genre" => "Fiction",
            "year" => "2024",
            "img" => "https://images.unsplash.com/photo-1663735498345-39c452a6d5d8?w=260&h=360&fit=crop&auto=format",
            "bg" => "#0d1225",
            "accent" => "#003098",
            "pos" => "top:8%; left:5%;",
            "rotate" => -6,
            "parallax" => 0.055,
            "delay" => "0s",
        ],
        [
            "title" => "Sapiens",
            "author" => "Yuval Noah Harari",
            "genre" => "Non-Fiction",
            "year" => "2024",
            "img" => "https://images.unsplash.com/photo-1529589941132-43606325dfb4?w=260&h=360&fit=crop&auto=format",
            "bg" => "#0d2218",
            "accent" => "#0067b2",
            "pos" => "top:5%; right:5%;",
            "rotate" => 7,
            "parallax" => -0.065,
            "delay" => "-3s",
        ],
        [
            "title" => "Invisible Cities",
            "author" => "Italo Calvino",
            "genre" => "Literary",
            "year" => "2023",
            "img" => "https://images.unsplash.com/photo-1502979932800-33d311b7ce56?w=260&h=360&fit=crop&auto=format",
            "bg" => "#0b1820",
            "accent" => "#0067b2",
            "pos" => "bottom:10%; left:5%;",
            "rotate" => 5,
            "parallax" => 0.04,
            "delay" => "-5s",
        ],
        [
            "title" => "One Hundred Years",
            "author" => "G. García Márquez",
            "genre" => "Classic",
            "year" => "2023",
            "img" => "https://images.unsplash.com/photo-1648563643923-2091f9c0c12f?w=260&h=360&fit=crop&auto=format",
            "bg" => "#1a0f22",
            "accent" => "#0067b2",
            "pos" => "bottom:8%; right:5%;",
            "rotate" => -5,
            "parallax" => -0.05,
            "delay" => "-8s",
        ],
        [
            "title" => "Ficciones",
            "author" => "Jorge Luis Borges",
            "genre" => "Short Stories",
            "year" => "2023",
            "img" => "https://images.unsplash.com/photo-1603058817990-2b9a9abbce86?w=260&h=360&fit=crop&auto=format",
            "bg" => "#1c1508",
            "accent" => "#0067b2",
            "pos" => "top:42%; left:7%;",
            "rotate" => -8,
            "parallax" => 0.07,
            "delay" => "-1.5s",
        ],
        [
            "title" => "The Trial",
            "author" => "Franz Kafka",
            "genre" => "Classic",
            "year" => "2024",
            "img" => "https://images.unsplash.com/photo-1625053376622-e462848c453f?w=260&h=360&fit=crop&auto=format",
            "bg" => "#1a1010",
            "accent" => "#0067b2",
            "pos" => "top:38%; right:7%;",
            "rotate" => 9,
            "parallax" => -0.06,
            "delay" => "-6s",
        ],
    ];

    $stats = [
        ["value" => "2,400+", "label" => "Titles"],
        ["value" => "180", "label" => "Countries"],
        ["value" => "94", "label" => "Awards"],
        ["value" => "312", "label" => "Authors"],
    ];
    $statGradients = [
        "linear-gradient(135deg,#0067b2,#0067b2)",
        "linear-gradient(135deg,#003098,#0067b2)",
        "linear-gradient(135deg,#0067b2,#731c84)",
        "linear-gradient(135deg,#731c84,#003098)",
    ];

    $genres = [
        "Literary Fiction",
        "Historical",
        "Poetry",
        "Biography",
        "Science",
        "Philosophy",
        "Translations",
        "Essays",
        "Short Stories",
        "Nature Writing"
    ];
    $genresDoubled = array_merge($genres, $genres);
    ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Bodoni+Moda:ital,wght@0,400;0,600;1,600&family=Figtree:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Custom brand palette */
            --rp-green: #48961d;
            /* primary text */
            --rp-blue-d: #003098;
            /* primary color  */
            --rp-blue-l: #0067b2;
            /* light blue      */
            --rp-purple: #731c84;
            /* accent          */

            --rp-background: #06060e;
            --rp-foreground: #f0eeea;
            --rp-muted-foreground: #120b44;
            --rp-border: rgba(240, 238, 234, 0.12);
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            background: var(--rp-background);
            color: var(--rp-foreground);
            font-family: 'Figtree', sans-serif;
            overflow-x: hidden;
        }

        ::-webkit-scrollbar {
            display: none;
        }

        * {
            scrollbar-width: none;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .rp-text-muted-foreground {
            color: var(--rp-muted-foreground);
        }

        /* ── Custom cursor ─────────────────────────────── */
        #rp-cursorRing {
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            top: 0;
            left: 0;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1.5px solid rgba(240, 238, 234, 0.5);
            mix-blend-mode: difference;
            transition: width .3s, height .3s, border-color .3s, margin .3s;
        }

        #rp-cursorDot {
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            top: 0;
            left: 0;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #fff;
        }

        /* ── Nav ─────────────────────────────────────────── */
        nav.rp-top-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 32px;
            background: linear-gradient(to bottom, rgba(6, 6, 14, 0.92) 0%, transparent 100%);
        }

        @media(min-width:768px) {
            nav.rp-top-nav {
                padding: 20px 56px;
            }
        }

        .rp-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .rp-brand-badge {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #818cf8, #f472b6, #fb923c);
        }

        .rp-brand-badge span {
            font-size: 9px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.02em;
        }

        .rp-brand-name {
            font-family: 'Bodoni Moda', serif;
            font-weight: 600;
            font-size: 0.875rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--rp-foreground);
        }

        .rp-nav-links {
            display: none;
            align-items: center;
            gap: 32px;
        }

        @media(min-width:768px) {
            .rp-nav-links {
                display: flex;
            }
        }

        .rp-nav-links a {
            font-size: 0.75rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--rp-muted-foreground);
            transition: color .2s;
        }

        .rp-nav-links a:hover {
            color: var(--rp-foreground);
        }

        .rp-submit-btn {
            display: none;
            align-items: center;
            gap: 8px;
            font-size: 0.75rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            padding: 10px 20px;
            border-radius: 2px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(192, 132, 252, 0.2));
            border: 1px solid rgba(99, 102, 241, 0.35);
            color: #a5b4fc;
        }

        @media(min-width:768px) {
            .rp-submit-btn {
                display: flex;
            }
        }

        /* ── Hero ────────────────────────────────────────── */
        .rp-hero {
            position: relative;
            width: 100%;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100svh;
            min-height: 640px;
            /*background: linear-gradient(160deg, #06060e 0%, #003098 50%, #48961d 100%);*/
        }

        .rp-orb-layer {
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .rp-orb1 {
            position: absolute;
            top: -30%;
            left: -20%;
            width: 70vw;
            height: 70vw;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(72, 150, 29, 0.25) 0%, transparent 65%);
            animation: orb1 20s ease-in-out infinite alternate;
        }

        .rp-orb2 {
            position: absolute;
            bottom: -30%;
            right: -20%;
            width: 75vw;
            height: 75vw;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0, 48, 152, 0.2) 0%, transparent 65%);
            animation: orb2 25s ease-in-out infinite alternate;
        }

        .rp-orb3 {
            position: absolute;
            top: 20%;
            right: 5%;
            width: 40vw;
            height: 40vw;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(115, 28, 132, 0.15) 0%, transparent 65%);
            animation: orb3 17s ease-in-out infinite alternate;
        }

        .rp-grain {
            position: absolute;
            inset: 0;
            opacity: 0.025;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='200' height='200'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='200' height='200' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E");
        }

        /* ── Floating cards ── */
        .rp-card {
            position: absolute;
            z-index: 10;
            display: none;
            transform-origin: center center;
            transition: transform 0.1s linear;
            opacity: 0;
            animation: float-bob 6s ease-in-out infinite;
        }

        @media(min-width:1024px) {
            .rp-card {
                display: block;
            }
        }

        .rp-card.rp-entered {
            opacity: 1;
        }

        .rp-card-inner {
            position: relative;
            width: 108px;
            height: 151px;
            border-radius: 2px;
            overflow: hidden;
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.35s;
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.75), inset -3px 0 10px rgba(0, 0, 0, 0.5);
        }

        .rp-card-spine {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 10px;
            z-index: 10;
        }

        .rp-card-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            mix-blend-mode: overlay;
            opacity: 0.75;
        }

        .rp-card-shade {
            position: absolute;
            inset: 0;
        }

        .rp-card-text {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 10px;
            z-index: 5;
        }

        .rp-card-text-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .rp-card-genre {
            font-size: 7px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
        }

        .rp-card-year {
            font-size: 7px;
            color: rgba(255, 255, 255, 0.4);
        }

        .rp-card-title {
            color: #fff;
            font-size: 8.5px;
            line-height: 1.2;
            margin: 0 0 2px 0;
            font-weight: 600;
            font-family: 'Bodoni Moda', serif;
        }

        .rp-card-author {
            color: rgba(255, 255, 255, 0.45);
            font-size: 7px;
            letter-spacing: 0.03em;
            margin: 0;
        }

        .rp-card-edge {
            position: absolute;
            inset: 0;
            border-radius: 2px;
        }

        /* ── Center content ── */
        .rp-center {
            position: relative;
            z-index: 20;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 0 16px;
            width: 100%;
        }

        .rp-top-label {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            opacity: 0;
            transform: translateY(16px);
            transition: opacity .9s .2s, transform .9s .2s;
        }

        .rp-top-label.rp-entered {
            opacity: 1;
            transform: translateY(0);
        }

        .rp-top-label .rp-line-l {
            height: 1px;
            width: 40px;
            background: linear-gradient(to right, transparent, rgba(240, 238, 234, 0.25));
        }

        .rp-top-label .rp-line-r {
            height: 1px;
            width: 40px;
            background: linear-gradient(to left, transparent, rgba(240, 238, 234, 0.25));
        }

        .rp-top-label span.rp-txt {
            font-size: 10px;
            letter-spacing: 0.35em;
            text-transform: uppercase;
            color: #48961d;
        }

        /* RAINBOW letters */
        .rp-rainbow-row {
            position: relative;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            line-height: 0.88;
            user-select: none;
            margin-bottom: 4px;
            opacity: 0;
            transform: scale(0.94);
            transition: opacity 1.1s .35s cubic-bezier(0.16, 1, 0.3, 1), transform 1.1s .35s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .rp-rainbow-row.rp-entered {
            opacity: 1;
            transform: scale(1);
        }

        .rp-rletter {
            display: inline-block;
            will-change: transform;
            font-family: 'Abril Fatface', serif;
            font-size: clamp(4.5rem, 13.5vw, 12rem);
            line-height: 0.88;
            letter-spacing: -0.015em;
            background-size: cover;
            background-position: center;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: brightness(1.05) saturate(1.1);
            transition: filter 0.3s;

        }

        .rp-rletter.rp-hovered {
            filter: brightness(1.4) saturate(1.3);
        }

        .rp-publications-label {
            font-family: 'Bodoni Moda', serif;
            font-weight: 800;
            font-size: clamp(1rem, 2.5vw, 2.2rem);
            letter-spacing: clamp(0.25em, 1vw, 0.55em);
            text-transform: uppercase;
            -webkit-text-stroke: 2px rgba(240, 238, 234, 0.35);

            background: linear-gradient(135deg, #48961d 0%, #0067b2 50%, #731c84 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: clamp(1.5rem, 3vw, 2.5rem);
            opacity: 0;
            transform: translateY(12px);
            transition: opacity .9s .65s, transform .9s .65s;
        }

        .rp-publications-label.rp-entered {
            opacity: 1;
            transform: translateY(0);
        }

        .rp-sub {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity .9s .8s, transform .9s .8s;
            will-change: transform;
        }

        .rp-sub.rp-entered {
            opacity: 1;
            transform: translateY(0);
        }

        .rp-tagline {
            color: var(--rp-muted-foreground);
            margin: 0 auto 28px auto;
            max-width: 28rem;
            line-height: 1.65;
            font-size: clamp(0.75rem, 1.3vw, 0.9rem);
            letter-spacing: 0.04em;
        }

        .rp-cta-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
            margin-bottom: 40px;
        }

        .rp-btn-primary {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 32px;
            font-size: 0.75rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            border-radius: 8px;
            border: none;
            color: #fff;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #003098 0%, #0067b2 50%, #48961d 100%);
            background-size: 200% 200%;
            box-shadow: 0 0 30px rgba(0, 48, 152, 0.5), 0 8px 32px rgba(0, 0, 0, 0.4);
            transition: box-shadow .3s, transform .3s;
        }

        .rp-btn-primary:hover {
            box-shadow: 0 0 50px rgba(0, 103, 178, 0.65), 0 8px 32px rgba(0, 0, 0, 0.4);
            transform: translateY(-2px);
        }

        .rp-btn-primary svg {
            transition: transform .2s;
        }

        .rp-btn-primary:hover svg {
            transform: translateX(2px);
        }

        .rp-btn-secondary {
            padding: 14px 32px;
            font-size: 0.75rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            border-radius: 8px;
            border: 1px solid rgba(72, 150, 29, 0.5);
            color: #48961d;
            background: transparent;
            transition: all .3s;
            cursor: pointer;
        }

        .rp-btn-secondary:hover {
            border-color: #48961d;
            color: #48961d;
            box-shadow: 0 0 25px rgba(72, 150, 29, 0.3);
            transform: translateY(-2px);
        }

        .rp-stats-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 24px;
            border-top: 1px solid rgba(240, 238, 234, 0.06);
            padding-top: clamp(1rem, 2vw, 1.5rem);
        }

        @media(min-width:768px) {
            .rp-stats-row {
                gap: 40px;
            }
        }

        .rp-stat {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .rp-stat-value {
            font-family: 'Bodoni Moda', serif;
            font-weight: 800;
            font-size: clamp(1.3rem, 2.5vw, 1.8rem);
            line-height: 1.2;

            background: linear-gradient(135deg, #48961d 0%, #0067b2 50%, #731c84 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .rp-stat-label {
            font-size: 11px;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: #3a3942;
            margin-top: 2px;
        }

        /* ── Scroll indicator ── */
        .rp-scroll-indicator {
            position: absolute;
            bottom: 28px;
            left: 50%;
            z-index: 20;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 1s 1.6s;
        }

        .rp-scroll-indicator.rp-entered {
            opacity: 0.6;
        }

        .rp-scroll-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: #48961d;
        }

        .rp-scroll-bar {
            width: 1px;
            height: 28px;
            background: linear-gradient(to bottom, #48961d, transparent);
            animation: scrollPulse 2s ease-in-out infinite;
        }

        /* ── Marquee strip ── */
        .rp-marquee-wrap {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 10;
            overflow: hidden;
            border-top: 1px solid rgba(240, 238, 234, 0.05);
            opacity: 0;
            transition: opacity 1s 1.8s;
        }

        .rp-marquee-wrap.rp-entered {
            opacity: 1;
        }

        .rp-marquee-track {
            display: flex;
            white-space: nowrap;
            padding: 10px 0;
            animation: marquee 30s linear infinite;
            width: max-content;
        }

        .rp-marquee-track span.rp-item {
            margin: 0 20px;
            font-size: 10px;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: var(--rp-muted-foreground);
        }

        .rp-marquee-track span.rp-item .rp-dot {
            margin-left: 20px;
            color: var(--rp-border);
            opacity: 0.4;
        }

        @keyframes orb1 {
            0% {
                transform: translate(0, 0) scale(1);
            }

            100% {
                transform: translate(8%, 10%) scale(1.15);
            }
        }

        @keyframes orb2 {
            0% {
                transform: translate(0, 0) scale(1);
            }

            100% {
                transform: translate(-10%, -8%) scale(1.12);
            }
        }

        @keyframes orb3 {
            0% {
                transform: translate(0, 0) scale(1);
            }

            100% {
                transform: translate(6%, 12%) scale(1.1);
            }
        }

        @keyframes float-bob {

            0%,
            100% {
                margin-top: 0px;
            }

            50% {
                margin-top: -12px;
            }
        }

        @keyframes scrollPulse {

            0%,
            100% {
                opacity: .4;
                transform: scaleY(1);
            }

            50% {
                opacity: 1;
                transform: scaleY(1.25);
            }
        }

        @keyframes marquee {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        /* ── 3D canvas ── */
        #rp-3d-canvas {
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            opacity: 0;
            transition: opacity 1.2s ease;
        }

        #rp-3d-canvas.rp-loaded {
            opacity: 1;
        }
        
        

  
  
.about-wrapper {
    background: linear-gradient(135deg, var(--secondary) 0%, var(--slate-900) 100%);
    padding: var(--space-2xl, 5rem) 0;
    position: relative;
    overflow: hidden;
}

.about-wrapper::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at 30% 50%, rgba(0, 48, 152, 0.3) 0%, transparent 60%),
                radial-gradient(ellipse at 70% 80%, rgba(0, 103, 178, 0.15) 0%, transparent 50%);
   background-size: 100% 100%, 20px 20px;
      background-position: center, 0 0;
} 
    /* Main Section Wrapper (Grid dot background and gradient here instead of body) */
    /*.about-wrapper {*/
    /*  width: 100%;*/
    /*  padding: 100px 20px;*/
    /*  background-color: #02182e;*/
    /*  background-image: radial-gradient(ellipse at 30% 50%, rgba(0, 48, 152, 0.3) 0%, transparent 60%),*/
    /*            radial-gradient(ellipse at 70% 80%, rgba(0, 103, 178, 0.15) 0%, transparent 50%);*/
    /*  background-size: 100% 100%, 20px 20px;*/
    /*  background-position: center, 0 0;*/
    /*}*/

    /* Inner Container */
    .about-main {
      max-width: 1200px;
      margin: 0 auto;
      color: #ffffff;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    /* Section Header */
    .about-header {
      text-align: center;
      margin-bottom: 50px;
    }

    .about-header .badge {
      display: inline-block;
      text-transform: uppercase;
      font-size: 0.85rem;
      font-weight: 700;
      letter-spacing: 2px;
      color: #60a5fa;
      background-color: rgba(255, 255, 255, 0.08);
      padding: 6px 16px;
      border-radius: 20px;
      margin-bottom: 12px;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .about-header h1 {
      font-size: 3rem;
      color: #ffffff;
      font-weight: 800;
      letter-spacing: -0.5px;
    }

    /* Paragraph Text */
    .about-paragraph {
      font-size: 1.1rem;
      color: #d1d5db;
      margin-bottom: 24px;
      max-width: 1000px;
      text-align: center;
      line-height: 1.6;
    }

    /* Centered Quote Container */
    .quote-container {
      background: rgba(255, 255, 255, 0.03);
      border-radius: 16px;
      padding: 40px 30px;
      margin-top: 40px;
      margin-bottom: 50px;
      max-width: 580px;
      width: 100%;
      border: 1px solid rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(10px);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      text-align: center;
      position: relative;
    }
    
    .quote-container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 2px;
      background: linear-gradient(to right, transparent, rgba(255,255,255,0.2), transparent);
    }

    .quote-icon {
      color: #60a5fa;
      font-size: 1.5rem;
      display: block;
      margin-bottom: 12px;
      opacity: 0.7;
    }

    .quote-text {
      font-family: 'Space Grotesk', system-ui, sans-serif;
      font-size: 1.25rem;
      font-weight: 600;
      color: #ffffff;
      line-height: 1.6;
      font-style: italic;
    }

    /* CTA Button */
    .cta-button {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      background: linear-gradient(135deg, #02417a 0%, #01294f 100%);
      color: #ffffff;
      padding: 14px 28px;
      border-radius: 30px;
      text-decoration: none;
      font-weight: 700;
      font-size: 1rem;
      transition: transform 0.2s ease, box-shadow 0.3s ease;
      box-shadow: 0 5px 15px rgba(1, 41, 79, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .cta-button:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(1, 41, 79, 0.5);
    }

    .cta-button i {
      font-size: 0.9rem;
    }
  
    </style>


    <canvas id="rp-3d-canvas"></canvas>
    <div id="rp-cursorRing"></div>
    <div id="rp-cursorDot"></div>



    <section class="rp-hero" id="rp-hero">
        <div class="rp-orb-layer">
            <div class="rp-orb1"></div>
            <div class="rp-orb2"></div>
            <div class="rp-orb3"></div>
            <div class="rp-grain"></div>
        </div>

        <!-- Three.js 3D canvas (rendered by the script at the bottom of the page) -->
        <!--<canvas id="rp-3d-canvas"></canvas>-->

        <!--<?php foreach ($cards as $i => $card): ?>-->
        <!--    <div class="rp-card" id="rp-card<?php echo $i; ?>"-->
        <!--        data-parallax="<?php echo $card['parallax']; ?>" data-rotate="<?php echo $card['rotate']; ?>"-->
        <!--        style="<?php echo $card['pos']; ?> animation-delay:<?php echo $card['delay']; ?>; transition-delay:<?php echo 0.3 + $i * 0.15; ?>s;">-->
        <!--        <div class="rp-card-inner">-->
        <!--            <div class="rp-card-spine" style="background:linear-gradient(to right, <?php echo htmlspecialchars($card['accent']); ?>40, transparent); border-right:1px solid <?php echo htmlspecialchars($card['accent']); ?>30;"></div>-->
        <!--            <img class="rp-card-img" src="<?php echo htmlspecialchars($card['img']); ?>" alt="<?php echo htmlspecialchars($card['title']); ?>" loading="lazy">-->
        <!--            <div class="rp-card-shade" style="background:linear-gradient(170deg, <?php echo htmlspecialchars($card['bg']); ?>bb 0%, transparent 50%, rgba(0,0,0,0.7) 100%);"></div>-->
        <!--            <div class="rp-card-text">-->
        <!--                <div class="rp-card-text-top">-->
        <!--                    <span class="rp-card-genre" style="color:<?php echo htmlspecialchars($card['accent']); ?>; opacity:0.9;"><?php echo htmlspecialchars($card['genre']); ?></span>-->
        <!--                    <span class="rp-card-year"><?php echo htmlspecialchars($card['year']); ?></span>-->
        <!--                </div>-->
        <!--                <div>-->
        <!--                    <p class="rp-card-title"><?php echo htmlspecialchars($card['title']); ?></p>-->
        <!--                    <p class="rp-card-author"><?php echo htmlspecialchars($card['author']); ?></p>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--            <div class="rp-card-edge" style="box-shadow:inset 0 0 0 1px <?php echo htmlspecialchars($card['accent']); ?>18;"></div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--<?php endforeach; ?>-->

        <div class="rp-center">
            <div class="rp-top-label" id="rp-topLabel">
                <span class="rp-line-l"></span>
                <span class="rp-txt">A Publishing Universe · Est. 1987</span>
                <span class="rp-line-r"></span>
            </div>

            <div class="rp-rainbow-row" id="rp-rainbowRow">
                <?php foreach ($letters as $i => $l): ?>
                    <span class="rp-rletter" id="rp-rletter<?php echo $i; ?>"
                        style="background-image:url(<?php echo htmlspecialchars($l['img']); ?>); transform:translateY(<?php echo $letterOffsets[$i]; ?>px);"
                        data-base-offset="<?php echo $letterOffsets[$i]; ?>"
                        data-factor="<?php echo (($i % 3) - 1) * 6; ?>"><?php echo htmlspecialchars($l['char']); ?></span>
                <?php endforeach; ?>
            </div>

            <div class="rp-publications-label" id="rp-pubLabel">Publications</div>

            <div class="rp-sub" id="rp-sub">
                <p class="rp-tagline">Inspiring knowledge and creativity through books <br> and journals that enlighten minds and shape the future.</p>

                <div class="rp-cta-row">
                    <button class="rp-btn-primary" onclick="window.location.href='/books';" >
                       View Books
                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                            <path d="M1 6.5h11M8 2l5 4.5-5 4.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <button onclick="window.location.href='/journals';" class="rp-btn-secondary">Explore Journals</button>
                </div>

                <div class="rp-stats-row">
                    <?php foreach ($stats as $i => $stat): ?>
                        <div class="rp-stat">
                            <span class="rp-stat-value"><?php echo htmlspecialchars($stat['value']); ?></span>
                            <span class="rp-stat-label"><?php echo htmlspecialchars($stat['label']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="rp-scroll-indicator" id="rp-scrollIndicator">
            <span class="rp-scroll-label">Scroll</span>
            <div class="rp-scroll-bar"></div>
        </div>

        <div class="rp-marquee-wrap" id="rp-marqueeWrap">
            <div class="rp-marquee-track">
                <?php foreach ($genresDoubled as $g): ?>
                    <span class="rp-item"><?php echo htmlspecialchars($g); ?><span class="rp-dot">·</span></span>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <script>
        (() => {
            const hero = document.getElementById('rp-hero');
            const cursorRing = document.getElementById('rp-cursorRing');
            const cursorDot = document.getElementById('rp-cursorDot');
            const cardEls = Array.from(document.querySelectorAll('.rp-card'));
            const letterEls = Array.from(document.querySelectorAll('.rp-rletter'));
            const sub = document.getElementById('rp-sub');

            const CARD_ACCENTS = <?php echo json_encode(array_map(fn($c) => $c['accent'], $cards)); ?>;

            let hoveredCard = null;
            let hoveredLetter = null;

            const mouse = {
                x: window.innerWidth / 2,
                y: window.innerHeight / 2
            };
            const cursorSmooth = {
                x: mouse.x,
                y: mouse.y
            };
            const ringSmooth = {
                x: mouse.x,
                y: mouse.y
            };

            window.addEventListener('mousemove', (e) => {
                mouse.x = e.clientX;
                mouse.y = e.clientY;
            });

            /* entrance — GSAP-powered stagger */
            if (typeof gsap !== 'undefined') {
                gsap.registerPlugin(ScrollTrigger);
                var tl = gsap.timeline({
                    defaults: {
                        ease: 'power4.out'
                    }
                });
                tl.to('#rp-topLabel', {
                        opacity: 1,
                        y: 0,
                        duration: 0.8
                    }, 0.2)
                    .to('#rp-rainbowRow', {
                        opacity: 1,
                        scale: 1,
                        duration: 1.1,
                        ease: 'expo.out'
                    }, 0.35)
                    .to('#rp-pubLabel', {
                        opacity: 1,
                        y: 0,
                        duration: 0.7
                    }, 0.55)
                    .to('#rp-sub', {
                        opacity: 1,
                        y: 0,
                        duration: 0.7
                    }, 0.7)
                    .to('#rp-scrollIndicator', {
                        opacity: 0.6,
                        duration: 0.6
                    }, 1.4)
                    .to('#rp-marqueeWrap', {
                        opacity: 1,
                        duration: 0.6
                    }, 1.5)
                    .to('.rp-card', {
                        opacity: 1,
                        duration: 0.8,
                        stagger: {
                            each: 0.12,
                            from: 'random'
                        }
                    }, 0.4);

                /* gradient sweep on primary button */
                gsap.to('.rp-btn-primary', {
                    backgroundPosition: '200% center',
                    duration: 5,
                    repeat: -1,
                    ease: 'none',
                });

                /* hover magnetic effect on primary CTA */
                var primaryBtn = document.querySelector('.rp-btn-primary');
                if (primaryBtn) {
                    primaryBtn.addEventListener('mousemove', function(e) {
                        var r = primaryBtn.getBoundingClientRect();
                        var x = e.clientX - r.left - r.width / 2;
                        var y = e.clientY - r.top - r.height / 2;
                        gsap.to(primaryBtn, {
                            x: x * 0.18,
                            y: y * 0.18,
                            duration: 0.4,
                            ease: 'power3.out'
                        });
                    });
                    primaryBtn.addEventListener('mouseleave', function() {
                        gsap.to(primaryBtn, {
                            x: 0,
                            y: 0,
                            duration: 0.6,
                            ease: 'elastic.out(1, 0.4)'
                        });
                    });
                }

                /* ── GSAP-enhanced hero extras ── */
                cardEls.forEach(function(el, i) {
                    gsap.set(el, {
                        transformPerspective: 600
                    });
                    gsap.to(el, {
                        y: '+=22',
                        duration: 3 + (i % 3),
                        ease: 'sine.inOut',
                        yoyo: true,
                        repeat: -1,
                        delay: i * 0.2,
                    });
                });
                gsap.from('.rp-stat', {
                    opacity: 0,
                    y: 16,
                    duration: 0.6,
                    stagger: 0.1,
                    delay: 1.2,
                    ease: 'power3.out',
                });
            } else {
                /* fallback: just add classes */
                setTimeout(() => {
                    document.getElementById('rp-topLabel').classList.add('rp-entered');
                    document.getElementById('rp-rainbowRow').classList.add('rp-entered');
                    document.getElementById('rp-pubLabel').classList.add('rp-entered');
                    sub.classList.add('rp-entered');
                    document.getElementById('rp-scrollIndicator').classList.add('rp-entered');
                    document.getElementById('rp-marqueeWrap').classList.add('rp-entered');
                    cardEls.forEach(el => el.classList.add('rp-entered'));
                }, 80);
            }

            /* card hover */
            cardEls.forEach((el, i) => {
                el.addEventListener('mouseenter', () => {
                    hoveredCard = i;
                    const inner = el.querySelector('.rp-card-inner');
                    const accent = CARD_ACCENTS[i];
                    inner.style.boxShadow = `0 0 28px ${accent}60, 0 24px 48px rgba(0,0,0,0.8), inset -3px 0 10px rgba(0,0,0,0.5)`;
                    inner.style.transform = 'scale(1.08) translateY(-4px)';
                    cursorRing.style.borderColor = accent;
                    cursorRing.style.width = '56px';
                    cursorRing.style.height = '56px';
                    cursorRing.style.marginLeft = '-8px';
                    cursorRing.style.marginTop = '-8px';
                });
                el.addEventListener('mouseleave', () => {
                    hoveredCard = null;
                    const inner = el.querySelector('.rp-card-inner');
                    inner.style.boxShadow = '0 16px 48px rgba(0,0,0,0.75), inset -3px 0 10px rgba(0,0,0,0.5)';
                    inner.style.transform = 'scale(1)';
                    cursorRing.style.borderColor = 'rgba(240,238,234,0.5)';
                    cursorRing.style.width = '40px';
                    cursorRing.style.height = '40px';
                    cursorRing.style.marginLeft = '0';
                    cursorRing.style.marginTop = '0';
                });
            });

            /* letter hover */
            letterEls.forEach((el, i) => {
                el.addEventListener('mouseenter', () => {
                    hoveredLetter = i;
                    el.classList.add('rp-hovered');
                });
                el.addEventListener('mouseleave', () => {
                    hoveredLetter = null;
                    el.classList.remove('rp-hovered');
                });
            });

            function tick() {
                const mx = mouse.x,
                    my = mouse.y;

                /* cursor dot (fast) */
                cursorSmooth.x += (mx - cursorSmooth.x) * 0.35;
                cursorSmooth.y += (my - cursorSmooth.y) * 0.35;
                cursorDot.style.transform = `translate(${cursorSmooth.x - 4}px, ${cursorSmooth.y - 4}px)`;

                /* cursor ring (laggy) */
                ringSmooth.x += (mx - ringSmooth.x) * 0.1;
                ringSmooth.y += (my - ringSmooth.y) * 0.1;
                cursorRing.style.transform = `translate(${ringSmooth.x - 20}px, ${ringSmooth.y - 20}px)`;

                /* hero-center normalized offset */
                const r = hero.getBoundingClientRect();
                const cx = r.left + r.width / 2;
                const cy = r.top + r.height / 2;
                const nx = (mx - cx) / (r.width / 2);
                const ny = (my - cy) / (r.height / 2);

                /* parallax on cards */
                cardEls.forEach((el) => {
                    const f = parseFloat(el.dataset.parallax) * 80;
                    const rot = parseFloat(el.dataset.rotate);
                    el.style.transform = `rotate(${rot}deg) translate(${nx * f}px, ${ny * f}px)`;
                });

                /* parallax on RAINBOW letters */
                letterEls.forEach((el) => {
                    const f = parseFloat(el.dataset.factor);
                    const base = parseFloat(el.dataset.baseOffset);
                    el.style.transform = `translateY(${base + ny * f}px) translateX(${nx * f * 0.4}px)`;
                });

                /* sub content gentle parallax */
                sub.style.transform = `translateY(${ny * 8}px)`;

                requestAnimationFrame(tick);
            }
            requestAnimationFrame(tick);
        })();
    </script>


    <!-- ═══════════════════════════════════════════════════════════
     SECTION 2 — LATEST NEWS
     ═══════════════════════════════════════════════════════════ -->
    <?php if (!empty($latestNews)): ?>
        <section class="py-24" style="background: var(--slate-50);">
            <div class="container mx-auto px-6">
                <div class="section-header flex justify-between items-end flex-wrap gap-4" data-reveal>
                    <div>
                        <span class="section-label">Stay Updated</span>
                        <h2 class="heading-lg">Latest News</h2>
                    </div>
                    <a href="<?= BASE_URL ?>/news" class="link-arrow">All News <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="news-grid">
                    <?php foreach ($latestNews as $i => $article): ?>
                        <article class="card overflow-hidden group" data-reveal data-reveal-delay="<?= ($i % 3) + 1 ?>">
                            <div class="h-40 bg-slate-200 overflow-hidden relative">
                                <?php if ($article['featured_image']): ?>
                                    <img data-src="<?= uploadUrl('news', $article['featured_image']) ?>"
                                        src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                        alt="<?= Security::e($article['title']) ?>"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-slate-400">
                                        <i class="fas fa-newspaper text-4xl"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="p-5">
                                <div class="flex items-center gap-2 mb-3">
                                    <?php if ($article['category']): ?>
                                        <span class="badge badge-primary text-xs"><?= Security::e($article['category']) ?></span>
                                    <?php endif; ?>
                                    <span class="caption text-xs"><?= formatDate($article['published_at']) ?></span>
                                </div>
                                <h3 class="heading-sm mb-2 line-clamp-2">
                                    <a href="<?= BASE_URL ?>/news/<?= Security::e($article['slug']) ?>" class="hover:text-primary transition-colors">
                                        <?= Security::e($article['title']) ?>
                                    </a>
                                </h3>
                                <p class="caption line-clamp-2 mb-4"><?= Security::e($article['excerpt'] ?: truncate($article['content'], 110)) ?></p>
                                <a href="<?= BASE_URL ?>/news/<?= Security::e($article['slug']) ?>" class="link-arrow text-sm">
                                    Read more <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>


    <!-- ═══════════════════════════════════════════════════════════
     SECTION 5 — JOURNALS
     ═══════════════════════════════════════════════════════════ -->
    <section class="py-24" style="background: white;">
        <div class="container mx-auto px-6">
            <div class="section-header flex justify-between items-end flex-wrap gap-4" data-reveal>
                <div>
                    <span class="section-label">Peer Reviewed</span>
                    <h2 class="heading-lg">Our Journals</h2>
                </div>
                <a href="<?= BASE_URL ?>/journals" class="link-arrow">View all <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($journals as $i => $journal): ?>
                    <div class="journal-card" data-reveal data-reveal-delay="<?= ($i % 3) + 1 ?>">
                        <div class="journal-logo">
                            <?php if ($journal['logo']): ?>
                                <img src="<?= uploadUrl('journals', $journal['logo']) ?>" alt="<?= Security::e($journal['name']) ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <span class="font-extrabold text-sm text-center leading-tight px-1" style="color: var(--primary);">
                                    <?= Security::e($journal['abbreviation'] ?: substr($journal['name'], 0, 4)) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <h3 class="heading-sm line-clamp-2 mb-1"><?= Security::e($journal['name']) ?></h3>
                        <?php if ($journal['issn']): ?>
                            <p class="caption text-xs mb-2">ISSN <?= Security::e($journal['issn']) ?></p>
                        <?php endif; ?>
                        <p class="caption text-xs line-clamp-2 mb-4"><?= Security::e($journal['description']) ?></p>
                        <div class="flex gap-2">
                            <?php
                            $href   = $journal['journal_url'] ?: '#';
                            $target = (strpos($href, 'http') === 0) ? ' target="_blank" rel="noopener"' : '';
                            ?>
                            <a href="<?= htmlspecialchars($href) ?>" <?= $target ?> class="btn btn-ghost flex-1 justify-center" title="Visit Journal">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/journals/submit/<?= (int)$journal['id'] ?>" class="btn btn-primary flex-1 justify-center">
                                <i class="fas fa-paper-plane"></i> Submit
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>



    <!-- ═══════════════════════════════════════════════════════════
     SECTION 3 — ABOUT SECTION
     ═══════════════════════════════════════════════════════════ -->


  <!-- Outer Section Wrapper -->
  <div class="about-wrapper">
    <main class="about-main">
      
      <!-- Section Header -->
      <div class="about-header">
        <span class="badge">Who We Are</span>
        <h1>Rainbow Publications</h1>
      </div>

      <!-- Paragraphs -->
      <p class="about-paragraph">
        Rainbow Publications, a shining beacon of knowledge and creativity, steps forward to begin an exciting journey in the world of publishing. With unwavering dedication to quality, innovation, and intellectual growth, we proudly introduce our newest chapter, focused on inspiring curiosity, fostering creativity, and nurturing ideas.
      </p>
      <p class="about-paragraph">
        Our passionate team of editors, designers, and thought leaders work tirelessly to craft a wide range of literary works that engage minds and spark imagination. As we embark on this inspiring adventure, we warmly welcome readers, writers, and literary enthusiasts to join us in celebrating the transformative power of words. Together, we aim to explore new horizons of understanding, creativity, and insight, with Rainbow Publications leading the way.
      </p>

      <!-- Highlight Quote Box -->
      <div class="quote-container">
        <i class="fa-solid fa-quote-left quote-icon"></i>
        <p class="quote-text">
          "Let's work together to expand horizons and leave a lasting impact on the academic world."
        </p>
      </div>

      <!-- CTA Button -->
     <div class="rp-cta-row">
                    <button class="rp-btn-primary" onclick="window.location.href='/about';" >
                       Read More
                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
                            <path d="M1 6.5h11M8 2l5 4.5-5 4.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>

    </main>
  </div>

    <!-- ═══════════════════════════════════════════════════════════
     SECTION 3 — FEATURED BOOKS
     ═══════════════════════════════════════════════════════════ -->
    <section class="py-24" style="background: white;">
        <div class="container mx-auto px-6">
            <div class="section-header flex justify-between items-end flex-wrap gap-4" data-reveal>
                <div>
                    <span class="section-label">Latest Publications</span>
                    <h2 class="heading-lg">Featured Books</h2>
                </div>
                <a href="<?= BASE_URL ?>/books" class="link-arrow">View all books <i class="fas fa-arrow-right"></i></a>
            </div>

            <?php if (empty($featuredBooks)): ?>
                <div class="empty-state">
                    <i class="fas fa-book"></i>
                    <p>Books will appear here once added.</p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($featuredBooks as $i => $book): ?>
                        <article class="book-card" data-reveal data-reveal-delay="<?= ($i % 3) + 1 ?>">
                            <div class="book-cover">
                                <?php if ($book['cover_image']): ?>
                                    <img data-src="<?= uploadUrl('books', $book['cover_image']) ?>"
                                        src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                        alt="<?= Security::e($book['title']) ?>">
                                <?php else: ?>
                                    <div class="flex items-center justify-center text-3xl">
                                        <i class="fas fa-book text-slate-400"></i>
                                    </div>
                                <?php endif; ?>
                                <?php if ($book['is_featured']): ?>
                                    <span class="absolute top-3 right-3 badge badge-primary">Featured</span>
                                <?php endif; ?>
                            </div>
                            <div class="book-info">
                                <?php if ($book['category']): ?>
                                    <span class="badge text-xs mb-2"><?= Security::e($book['category']) ?></span>
                                <?php endif; ?>
                                <h3 class="heading-sm mb-2 line-clamp-2">
                                    <a href="<?= BASE_URL ?>/book/<?= Security::e($book['slug']) ?>" class="hover:text-primary transition-colors">
                                        <?= Security::e($book['title']) ?>
                                    </a>
                                </h3>
                                <p class="caption flex items-center gap-1 mb-3">
                                    <i class="fas fa-user-pen text-xs" style="color: var(--primary);"></i>
                                    <?= Security::e($book['authors']) ?>
                                </p>
                                <?php if ($book['description']): ?>
                                    <p class="caption line-clamp-2 mb-4"><?= truncate($book['description'], 110) ?></p>
                                <?php endif; ?>
                                <div class="flex items-center justify-between pt-4 border-t border-slate-200">
                                    <?php if ($book['publication_date']): ?>
                                        <span class="caption text-xs"><?= formatDate($book['publication_date'], 'Y') ?></span>
                                    <?php else: ?><span></span><?php endif; ?>
                                    <a href="<?= BASE_URL ?>/book/<?= Security::e($book['slug']) ?>" class="link-arrow text-sm">
                                        Read <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════
     SECTION 4 — FEATURED CONFERENCE
     ═══════════════════════════════════════════════════════════ -->
    <?php if (!empty($conference)): ?>
        <section class="py-24" style="background: var(--slate-50);">
            <div class="container mx-auto px-6">
                <div class="section-header flex justify-between items-end flex-wrap gap-4" data-reveal>
                    <div>
                        <span class="section-label">Featured Event</span>
                        <h2 class="heading-lg"><?= htmlspecialchars($conference['title']) ?></h2>
                    </div>
                    <a href="<?= BASE_URL ?>/conferences" class="link-arrow">View all events <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="conference-card grid lg:grid-cols-2 gap-8 items-center" data-reveal>
                    <!-- Event Image -->
                    <div class="flex justify-center">
                        <?php if (!empty($conference['poster_image'])): ?>
                            <img src="<?= uploadUrl('conferences', $conference['poster_image']) ?>"
                                alt="<?= htmlspecialchars($conference['title']) ?>"
                                class="w-full max-w-md rounded-lg shadow-lg">
                        <?php else: ?>
                            <div class="w-full max-w-md aspect-[3/4] flex items-center justify-center bg-gradient-to-br from-primary to-accent rounded-lg text-white">
                                <i class="fas fa-calendar-alt text-6xl opacity-30"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Event Details -->
                    <div>
                        <span class="conference-badge">
                            <i class="fas fa-calendar"></i>
                            <?php if (!empty($conference['conference_date'])): ?>
                                <?= formatDate($conference['conference_date'], 'l, F d, Y') ?>
                            <?php endif; ?>
                        </span>

                        <?php if (!empty($conference['subtitle'])): ?>
                            <h3 class="heading-md text-primary italic mb-4"><?= htmlspecialchars($conference['subtitle']) ?></h3>
                        <?php endif; ?>

                        <?php if (!empty($conference['intro_paragraph'])): ?>
                            <p class="caption text-base mb-6"><?= htmlspecialchars(truncate($conference['intro_paragraph'], 280)) ?></p>
                        <?php endif; ?>

                        <?php
                        $incl = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $conference['registration_includes'] ?? ''))));
                        if (!empty($incl)):
                        ?>
                            <div class="mb-6">
                                <p class="label mb-3">Registration includes</p>
                                <ul class="space-y-2">
                                    <?php foreach (array_slice($incl, 0, 4) as $line): ?>
                                        <li class="flex items-start gap-2 caption">
                                            <i class="fas fa-check text-primary mt-0.5"></i>
                                            <span><?= htmlspecialchars($line) ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($conference['registration_fee'])): ?>
                            <div class="flex items-center gap-2 py-4 border-t border-b border-slate-200 mb-6">
                                <i class="fas fa-tag text-primary"></i>
                                <span class="font-semibold"><?= htmlspecialchars($conference['registration_fee']) ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="flex flex-wrap gap-3">
                            <a href="<?= BASE_URL ?>/conference/<?= htmlspecialchars($conference['slug']) ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-right"></i> View Details
                            </a>
                            <?php if (!empty($conference['registration_link'])): ?>
                                <a href="<?= htmlspecialchars($conference['registration_link']) ?>" target="_blank" rel="noopener" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Register Now
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- ═══════════════════════════════════════════════════════════
     SECTION 6 — SERVICES
     ═══════════════════════════════════════════════════════════ -->
    <section class="py-24" style="background: var(--slate-50);">
        <div class="container mx-auto px-6">
            <div class="text-center mb-16" data-reveal>
                <span class="section-label justify-center mb-4">What We Offer</span>
                <h2 class="heading-lg mb-4">Our Services</h2>
                <p class="caption text-base max-w-2xl mx-auto">
                    End-to-end academic publishing solutions tailored for researchers and institutions.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($services as $i => $service): ?>
                    <a href="<?= BASE_URL ?>/service/<?= Security::e($service['slug']) ?>" class="service-card" data-reveal data-reveal-delay="<?= ($i % 3) + 1 ?>">
                        <div class="service-icon">
                            <i class="<?= Security::e($service['icon'] ?: 'fas fa-book') ?>"></i>
                        </div>
                        <h3 class="heading-sm mb-2"><?= Security::e($service['title']) ?></h3>
                        <p class="caption mb-4"><?= Security::e($service['short_description']) ?></p>
                        <span class="link-arrow text-sm">Learn more <i class="fas fa-arrow-right"></i></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════
     SECTION 7 — TESTIMONIALS
     ═══════════════════════════════════════════════════════════ -->
    <?php if (!empty($testimonials)): ?>
        <section class="py-24" style="background: white;">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16" data-reveal>
                    <span class="section-label justify-center mb-4">What People Say</span>
                    <h2 class="heading-lg mb-4">Testimonials</h2>

                    <!-- Rating Summary -->
                    <div class="inline-flex items-center gap-4 bg-slate-100 px-4 py-3 rounded-lg mt-6">
                        <div class="stars flex gap-0.5">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="font-bold text-lg">4.8</span>
                        <span class="caption">/ 5 Based on community reviews</span>
                    </div>
                </div>

                <!-- Featured Testimonial -->
                <?php if (count($testimonials) > 0):
                    $featured = $testimonials[0];
                    $fLetter  = $featured['avatar_letter'] !== '' ? $featured['avatar_letter'] : strtoupper(substr($featured['reviewer_name'], 0, 1));
                    $fColor   = $featured['avatar_color'] ?: '#10B981';
                    $fInitial = $fLetter ?: 'U';
                    $fRating  = max(1, min(5, (int)($featured['rating'] ?? 5)));
                ?>
                    <div class="max-w-3xl mx-auto mb-12" data-reveal>
                        <div class="testimonial-card">
                            <div class="stars mb-4">
                                <?php for ($s = 1; $s <= 5; $s++): ?>
                                    <i class="fas fa-star<?= $s > $fRating ? ' opacity-20' : '' ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <p class="heading-md italic mb-6 text-slate-800">
                                &quot;<?= Security::e($featured['content']) ?>&quot;
                            </p>
                            <div class="testimonial-author">
                                <div class="testimonial-avatar" style="background: <?= Security::e($fColor) ?>">
                                    <?= Security::e($fInitial) ?>
                                </div>
                                <div class="text-left">
                                    <p class="font-semibold"><?= Security::e($featured['reviewer_name']) ?></p>
                                    <?php if (!empty($featured['designation']) || !empty($featured['organization'])): ?>
                                        <p class="caption text-xs">
                                            <?= Security::e($featured['designation']) ?>
                                            <?php if (!empty($featured['designation']) && !empty($featured['organization'])): ?> · <?php endif; ?>
                                            <?= Security::e($featured['organization']) ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Additional Testimonials Grid -->
                <?php if (count($testimonials) > 1): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php foreach (array_slice($testimonials, 1, 4) as $i => $t):
                            $letter  = $t['avatar_letter'] !== '' ? $t['avatar_letter'] : strtoupper(substr($t['reviewer_name'], 0, 1));
                            $color   = $t['avatar_color'] ?: '#10B981';
                            $initial = $letter ?: 'U';
                            $rating  = max(1, min(5, (int)($t['rating'] ?? 5)));
                        ?>
                            <div class="testimonial-card" data-reveal data-reveal-delay="<?= ($i % 2) + 1 ?>">
                                <div class="stars mb-3">
                                    <?php for ($s = 1; $s <= 5; $s++): ?>
                                        <i class="fas fa-star<?= $s > $rating ? ' opacity-20' : '' ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <p class="caption line-clamp-3 mb-4"><?= Security::e($t['content']) ?></p>
                                <div class="testimonial-author">
                                    <div class="testimonial-avatar" style="background: <?= Security::e($color) ?>">
                                        <?= Security::e($initial) ?>
                                    </div>
                                    <div class="text-left">
                                        <p class="font-semibold text-sm"><?= Security::e($t['reviewer_name']) ?></p>
                                        <?php if (!empty($t['designation']) || !empty($t['organization'])): ?>
                                            <p class="caption text-xs">
                                                <?= Security::e($t['designation']) ?>
                                                <?php if (!empty($t['designation']) && !empty($t['organization'])): ?> · <?php endif; ?>
                                                <?= Security::e($t['organization']) ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- ═══════════════════════════════════════════════════════════
     SECTION 8 — EDITORIAL BOARD
     ═══════════════════════════════════════════════════════════ -->
    <?php if (!empty($editorialBoard)): ?>
        <section class="py-24" style="background: var(--slate-50);">
            <div class="container mx-auto px-6">
                <div class="section-header flex justify-between items-end flex-wrap gap-4" data-reveal>
                    <div>
                        <span class="section-label">Meet Our Leaders</span>
                        <h2 class="heading-lg">Editorial Board</h2>
                    </div>
                    <a href="<?= BASE_URL ?>/editorial-board" class="link-arrow">View all <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="board-grid">
                    <?php foreach ($editorialBoard as $i => $member): ?>
                        <article class="board-member" data-reveal data-reveal-delay="<?= ($i % 4) + 1 ?>">
                            <?php if ($member['photo']): ?>
                                <img src="<?= uploadUrl('board', $member['photo']) ?>" alt="<?= htmlspecialchars($member['name']) ?>" class="board-avatar">
                            <?php else: ?>
                                <div class="board-ring"><i class="fas fa-user"></i></div>
                            <?php endif; ?>
                            <h4 class="heading-sm text-base mb-1"><?= htmlspecialchars($member['name']) ?></h4>
                            <?php if ($member['designation']): ?>
                                <p class="text-xs font-semibold mb-1" style="color: var(--primary-dark);"><?= htmlspecialchars($member['designation']) ?></p>
                            <?php endif; ?>
                            <?php if ($member['institution']): ?>
                                <p class="caption text-xs"><?= htmlspecialchars($member['institution']) ?></p>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- ═══════════════════════════════════════════════════════════
     SECTION 9 — TRUST STRIP
     ═══════════════════════════════════════════════════════════ -->
    <section class="trust-strip">
        <div class="container mx-auto px-6">
            <p class="label text-center mb-6">Indexing &amp; Quality Standards</p>
            <div class="trust-badges">
                <?php $badges = ['Scopus Indexed', 'Peer Reviewed', 'DOI Registered', 'Open Access', 'ISSN Certified', 'Crossref Member', 'Google Scholar', 'Double-Blind Review'];
                foreach ($badges as $b): ?>
                    <div class="trust-badge">
                        <i class="fas fa-check-circle"></i>
                        <span><?= $b ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ═══════════════════════════════════════════════════════════
     SECTION 10 — CTA BANNER
     ═══════════════════════════════════════════════════════════ -->
    <section class="py-24 px-6">
        <div class="container mx-auto">
            <div class="cta-section" data-reveal>
                <span class="section-label justify-center mb-4" style="color: white; --tw-text-opacity: 1;">Get Started</span>
                <h2 class="heading-lg mb-4">Ready to Publish Your Research?</h2>
                <p class="text-lg text-slate-100 mb-8 max-w-xl mx-auto">
                    Join thousands of researchers and academics who trust us with their publications.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="<?= BASE_URL ?>/contact" class="btn" style="background: white; color: var(--primary);">
                        Get In Touch <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="<?= BASE_URL ?>/services" class="btn" style="background: rgba(255,255,255,.2); color: white; border-color: rgba(255,255,255,.3);">
                        Our Services
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Three.js for 3D hero background -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script>
        /* ============================================================
   THREE.JS 3D HERO BACKGROUND — colorful wireframe sphere + particles
   Renders on #rp-3d-canvas (behind .rp-center, in front of orbs)
   Brand palette: green #48961d | dark blue #003098 | light blue #0067b2 | purple #731c84
   ============================================================ */
        (function() {
            if (typeof THREE === 'undefined') return;
            var canvas = document.getElementById('rp-3d-canvas');
            if (!canvas) return;
            var heroEl = canvas.closest('.rp-hero');
            if (!heroEl) return;

            var scene = new THREE.Scene();
            var camera = new THREE.PerspectiveCamera(60, 1, 0.1, 100);
            camera.position.set(0, 0, 8);

            var renderer = new THREE.WebGLRenderer({
                canvas: canvas,
                alpha: true,
                antialias: true
            });
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
            renderer.setClearColor(0x000000, 0);

            /* ---- Lights ---- */
            scene.add(new THREE.AmbientLight(0xffffff, 0.2));
            var p1 = new THREE.PointLight(0x48961d, 1.2, 20);
            p1.position.set(4, 2, 4);
            scene.add(p1);
            var p2 = new THREE.PointLight(0x003098, 1, 20);
            p2.position.set(-4, -2, 3);
            scene.add(p2);
            var p3 = new THREE.PointLight(0x731c84, 0.8, 20);
            p3.position.set(0, 4, -2);
            scene.add(p3);
            var p4 = new THREE.PointLight(0x0067b2, 0.8, 20);
            p4.position.set(0, -4, 2);
            scene.add(p4);

            /* ---- Wireframe sphere (big, slow) ---- */
            var sphereGeo = new THREE.IcosahedronGeometry(2.2, 3);
            var sphereMat = new THREE.MeshBasicMaterial({
                color: 0x48961d,
                wireframe: true,
                transparent: true,
                opacity: 0.08,
            });
            var sphere = new THREE.Mesh(sphereGeo, sphereMat);
            sphere.position.set(2.5, -0.5, -3);
            scene.add(sphere);

            /* ---- Second wireframe shell ---- */
            var shellGeo = new THREE.IcosahedronGeometry(3, 2);
            var shellMat = new THREE.MeshBasicMaterial({
                color: 0x003098,
                wireframe: true,
                transparent: true,
                opacity: 0.06,
            });
            var shell = new THREE.Mesh(shellGeo, shellMat);
            shell.position.set(2.5, -0.5, -3);
            scene.add(shell);

            /* ---- Floating geometric accents ---- */
            var accentGroup = new THREE.Group();
            var accentDefs = [{
                    geo: new THREE.OctahedronGeometry(0.22, 0),
                    pos: [3.8, 1.2, -2.5],
                    color: 0x0067b2
                },
                {
                    geo: new THREE.TetrahedronGeometry(0.18, 0),
                    pos: [-4.5, -1.5, -3],
                    color: 0x731c84
                },
                {
                    geo: new THREE.TorusGeometry(0.25, 0.07, 6, 12),
                    pos: [4.2, -2.8, -2],
                    color: 0x48961d
                },
                {
                    geo: new THREE.TorusKnotGeometry(0.16, 0.04, 24, 6),
                    pos: [-3.8, 2.5, -2.8],
                    color: 0x003098
                },
                {
                    geo: new THREE.OctahedronGeometry(0.15, 0),
                    pos: [0, 3, -2],
                    color: 0x48961d
                },
                {
                    geo: new THREE.DodecahedronGeometry(0.2, 0),
                    pos: [-5, 0.5, -3.5],
                    color: 0x0067b2
                },
            ];
            accentDefs.forEach(function(d) {
                var mat = new THREE.MeshBasicMaterial({
                    color: d.color,
                    wireframe: true,
                    transparent: true,
                    opacity: 0.15,
                });
                var m = new THREE.Mesh(d.geo, mat);
                m.position.set(d.pos[0], d.pos[1], d.pos[2]);
                m.userData = {
                    basePos: [d.pos[0], d.pos[1], d.pos[2]],
                    speed: 0.2 + Math.random() * 0.4,
                    amp: 0.3 + Math.random() * 0.6,
                    offset: Math.random() * Math.PI * 2,
                    rot: {
                        x: (Math.random() - 0.5) * 0.03,
                        y: (Math.random() - 0.5) * 0.03,
                        z: (Math.random() - 0.5) * 0.02
                    },
                };
                accentGroup.add(m);
            });
            scene.add(accentGroup);

            /* ---- Particles (3-color dust) ---- */
            var PCOUNT = 200;
            var posArr = new Float32Array(PCOUNT * 3);
            var velArr = [];
            var colorArr = new Float32Array(PCOUNT * 3);

            var palette = [
                new THREE.Color(0x48961d),
                new THREE.Color(0x003098),
                new THREE.Color(0x0067b2),
                new THREE.Color(0x731c84),
            ];

            for (var i = 0; i < PCOUNT; i++) {
                posArr[i * 3] = (Math.random() - 0.5) * 14;
                posArr[i * 3 + 1] = (Math.random() - 0.5) * 10;
                posArr[i * 3 + 2] = (Math.random() - 0.5) * 8;
                velArr.push({
                    x: (Math.random() - 0.5) * 0.004,
                    y: (Math.random() - 0.5) * 0.002 + 0.001,
                    z: (Math.random() - 0.5) * 0.002,
                });
                var c = palette[Math.floor(Math.random() * palette.length)];
                colorArr[i * 3] = c.r;
                colorArr[i * 3 + 1] = c.g;
                colorArr[i * 3 + 2] = c.b;
            }

            var pGeo = new THREE.BufferGeometry();
            pGeo.setAttribute('position', new THREE.BufferAttribute(posArr, 3));
            pGeo.setAttribute('color', new THREE.BufferAttribute(colorArr, 3));

            /* glow sprite for each particle */
            var glowCanvas = document.createElement('canvas');
            glowCanvas.width = glowCanvas.height = 32;
            var gctx = glowCanvas.getContext('2d');
            var ggrad = gctx.createRadialGradient(16, 16, 0, 16, 16, 16);
            ggrad.addColorStop(0, 'rgba(255, 255, 255, 0.9)');
            ggrad.addColorStop(0.3, 'rgba(255, 255, 255, 0.3)');
            ggrad.addColorStop(0.7, 'rgba(255, 255, 255, 0.05)');
            ggrad.addColorStop(1, 'rgba(0, 0, 0, 0)');
            gctx.fillStyle = ggrad;
            gctx.fillRect(0, 0, 32, 32);
            var glowTex = new THREE.CanvasTexture(glowCanvas);

            var pMat = new THREE.PointsMaterial({
                size: 0.08,
                map: glowTex,
                vertexColors: true,
                transparent: true,
                opacity: 0.7,
                depthWrite: false,
                blending: THREE.AdditiveBlending,
            });
            var particles = new THREE.Points(pGeo, pMat);
            scene.add(particles);

            /* ---- Mouse parallax ---- */
            var mx = 0,
                my = 0,
                tmx = 0,
                tmy = 0;
            heroEl.addEventListener('mousemove', function(e) {
                tmx = (e.clientX / window.innerWidth) * 2 - 1;
                tmy = -(e.clientY / window.innerHeight) * 2 + 1;
            });

            /* ---- Resize ---- */
            function onResize() {
                var r = heroEl.getBoundingClientRect();
                renderer.setSize(r.width, r.height);
                camera.aspect = r.width / r.height;
                camera.updateProjectionMatrix();
            }
            window.addEventListener('resize', onResize);
            onResize();

            /* ---- Render loop ---- */
            var clock = new THREE.Clock();
            var mouseActive = false;
            heroEl.addEventListener('mouseenter', function() {
                mouseActive = true;
            });
            heroEl.addEventListener('mouseleave', function() {
                mouseActive = false;
            });

            function animate() {
                requestAnimationFrame(animate);
                var t = clock.getElapsedTime();

                mx += (tmx - mx) * 0.02;
                my += (tmy - my) * 0.02;

                sphere.rotation.y = t * 0.05;
                sphere.rotation.x = t * 0.03;
                sphere.position.x = 2.5 + mx * 0.4;
                sphere.position.y = -0.5 + my * 0.3;

                shell.rotation.y = -t * 0.04;
                shell.rotation.z = t * 0.025;
                shell.position.x = 2.5 - mx * 0.2;
                shell.position.y = -0.5 - my * 0.2;

                accentGroup.children.forEach(function(m) {
                    var ud = m.userData;
                    m.rotation.x += ud.rot.x;
                    m.rotation.y += ud.rot.y;
                    m.rotation.z += ud.rot.z;
                    m.position.y = ud.basePos[1] + Math.sin(t * ud.speed + ud.offset) * ud.amp;
                    m.position.x = ud.basePos[0] + Math.cos(t * ud.speed * 0.7 + ud.offset) * ud.amp * 0.5;
                });

                /* particles drift */
                for (var i = 0; i < PCOUNT; i++) {
                    posArr[i * 3] += velArr[i].x;
                    posArr[i * 3 + 1] += velArr[i].y;
                    posArr[i * 3 + 2] += velArr[i].z;
                    if (posArr[i * 3] > 7) posArr[i * 3] = -7;
                    if (posArr[i * 3] < -7) posArr[i * 3] = 7;
                    if (posArr[i * 3 + 1] > 5) posArr[i * 3 + 1] = -5;
                    if (posArr[i * 3 + 1] < -5) posArr[i * 3 + 1] = 5;
                    if (posArr[i * 3 + 2] > 4) posArr[i * 3 + 2] = -4;
                    if (posArr[i * 3 + 2] < -4) posArr[i * 3 + 2] = 4;
                }
                pGeo.attributes.position.needsUpdate = true;

                /* lights dance */
                p1.position.x = 4 + Math.sin(t * 0.3) * 2;
                p1.position.y = 2 + Math.cos(t * 0.4) * 1.5;
                p2.position.x = -4 + Math.cos(t * 0.25) * 2;
                p2.position.y = -2 + Math.sin(t * 0.35) * 1.5;

                renderer.render(scene, camera);
            }
            animate();

            /* fade canvas in */
            setTimeout(function() {
                canvas.classList.add('rp-loaded');
            }, 300);
        })();
    </script>

    <script>
        (function() {
            if (typeof gsap === 'undefined') return; // fail-safe: page already looks correct without JS
            gsap.registerPlugin(ScrollTrigger);

            var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            /* ---------- Animated counters (data-counter / data-suffix) ---------- */
            function animateCounters(root) {
                (root || document).querySelectorAll('.counter-num').forEach(function(el) {
                    var target = parseFloat(el.getAttribute('data-counter')) || 0;
                    var suffix = el.getAttribute('data-suffix') || '';
                    if (reduceMotion) {
                        el.textContent = target.toLocaleString() + suffix;
                        return;
                    }
                    var obj = {
                        val: 0
                    };
                    gsap.to(obj, {
                        val: target,
                        duration: 1.8,
                        ease: 'power2.out',
                        onUpdate: function() {
                            el.textContent = Math.floor(obj.val).toLocaleString() + suffix;
                        }
                    });
                });
            }

            /* ---------- Hero entrance timeline ---------- */
            if (reduceMotion) {
                animateCounters(document);
            } else {
                var heroTl = gsap.timeline({
                    defaults: {
                        ease: 'power3.out'
                    }
                });
                heroTl
                    .from('.hero-content .section-label', {
                        opacity: 0,
                        y: 18,
                        duration: 0.6
                    })
                    .from('.hero-content h1', {
                        opacity: 0,
                        y: 28,
                        duration: 0.8
                    }, '-=0.35')
                    .from('.hero-content p', {
                        opacity: 0,
                        y: 18,
                        duration: 0.7
                    }, '-=0.5')
                    .from('.hero-buttons a', {
                        opacity: 0,
                        y: 18,
                        duration: 0.6,
                        stagger: 0.15
                    }, '-=0.4')
                    .from('.hero-stats > div', {
                        opacity: 0,
                        y: 22,
                        duration: 0.6,
                        stagger: 0.1
                    }, '-=0.3')
                    .add(function() {
                        animateCounters(document);
                    }, '-=0.2');
            }

            /* ---------- Scroll-triggered reveal for every other [data-reveal] ---------- */
            gsap.utils.toArray('[data-reveal]').forEach(function(el) {
                if (el.closest('.hero')) return; // already handled by the hero timeline
                var delayAttr = parseInt(el.getAttribute('data-reveal-delay') || '0', 10);
                gsap.from(el, {
                    opacity: 0,
                    y: 26,
                    duration: 0.7,
                    delay: reduceMotion ? 0 : delayAttr * 0.12,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: el,
                        start: 'top 88%',
                        toggleActions: 'play none none reverse'
                    }
                });
            });

            if (reduceMotion) return; // skip all pointer-driven micro-interactions below

            /* ---------- Cursor-follow spotlight glow on every box/card ---------- */
            var glowSelectors = '.card, .book-card, .service-card, .journal-card, .testimonial-card, .board-member, .conference-card';
            document.querySelectorAll(glowSelectors).forEach(function(el) {
                el.addEventListener('mousemove', function(e) {
                    var r = el.getBoundingClientRect();
                    el.style.setProperty('--mx', (e.clientX - r.left) + 'px');
                    el.style.setProperty('--my', (e.clientY - r.top) + 'px');
                });
            });

            /* ---------- Subtle 3D tilt on interactive boxes ---------- */
            var tiltSelectors = '.book-card, .service-card, .journal-card, .testimonial-card, .board-member, .conference-card';
            document.querySelectorAll(tiltSelectors).forEach(function(el) {
                gsap.set(el, {
                    transformPerspective: 800,
                    transformStyle: 'preserve-3d'
                });
                var qx = gsap.quickTo(el, 'rotationY', {
                    duration: 0.5,
                    ease: 'power3.out'
                });
                var qy = gsap.quickTo(el, 'rotationX', {
                    duration: 0.5,
                    ease: 'power3.out'
                });
                el.addEventListener('mousemove', function(e) {
                    var r = el.getBoundingClientRect();
                    var px = (e.clientX - r.left) / r.width - 0.5;
                    var py = (e.clientY - r.top) / r.height - 0.5;
                    qx(px * 5);
                    qy(-py * 5);
                });
                el.addEventListener('mouseleave', function() {
                    qx(0);
                    qy(0);
                });
            });

            /* ---------- Magnetic primary buttons ---------- */
            document.querySelectorAll('.btn-primary').forEach(function(btn) {
                var qx = gsap.quickTo(btn, 'x', {
                    duration: 0.3,
                    ease: 'power3.out'
                });
                var qy = gsap.quickTo(btn, 'y', {
                    duration: 0.3,
                    ease: 'power3.out'
                });
                btn.addEventListener('mousemove', function(e) {
                    var r = btn.getBoundingClientRect();
                    qx((e.clientX - r.left - r.width / 2) * 0.25);
                    qy((e.clientY - r.top - r.height / 2) * 0.3);
                });
                btn.addEventListener('mouseleave', function() {
                    qx(0);
                    qy(0);
                });
            });

            /* ---------- Subtle hero background parallax ---------- */
            gsap.to('.hero', {
                backgroundPositionY: '65%',
                ease: 'none',
                scrollTrigger: {
                    trigger: '.hero',
                    start: 'top top',
                    end: 'bottom top',
                    scrub: true
                }
            });
        })();
    </script>

</body>

</html>