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

    <!-- Fonts: Manrope (headings) + Inter (body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary:   { DEFAULT: '<?= htmlspecialchars(getSetting("primary_color", "#4355A5")) ?>', light: '#5a6fb5', dark: '#354590', 50: '#e8eef7' },
                    secondary: { DEFAULT: '<?= htmlspecialchars(getSetting("secondary_color", "#E92C28")) ?>', light: '#f04a47', dark: '#d41f1b' },
                    navy:      { DEFAULT: '#0F172A', soft: '#1E293B' },
                    indigo:    { DEFAULT: '#4F46E5', light: '#6366F1' },
                    emerald:   { DEFAULT: '#10B981', dark: '#059669' },
                    cyan:      { DEFAULT: '#06B6D4' },
                    gold:      { DEFAULT: '#F59E0B' },
                },
                fontFamily: {
                    display: ['Manrope', 'sans-serif'],
                    body:    ['Inter', 'Manrope', 'sans-serif'],
                    modern:  ['Manrope', 'Inter', 'sans-serif'],
                },
            }
        }
    }
    </script>

    <!-- Global Stylesheet -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">

    <?php
    // Analytics / GTM / head scripts
    $_ga = getSetting('google_analytics');
    if ($_ga): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id="<?= htmlspecialchars($_ga) ?>"></script>
    <script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?= htmlspecialchars($_ga) ?>');</script>
    <?php endif;
    $_gtm = getSetting('gtm_id');
    if ($_gtm): ?>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','<?= htmlspecialchars($_gtm) ?>');</script>
    <?php endif;
    $_headScripts = getSetting('head_scripts');
    if ($_headScripts) {
        $_headScripts = preg_replace('#</script\s*>#i', '<\\/script>', $_headScripts);
        echo $_headScripts;
    }
    ?>
</head>
<body class="font-body antialiased" style="color:var(--text, #1E2525); background:var(--bg, #F8F5E9);">

<?php
/*
  ============================================================
  HOME PAGE — Client B Redesigned Layout
  ============================================================
  All dynamic PHP bindings are 100% preserved.
  Only the wrapper markup, structural classes, grid layouts,
  and visual styling have been updated.
  ============================================================
*/
?>

<!-- ═══════════════════════════════════════════════════════════
     SECTION 1 — HERO
     Full-viewport hero with animated gradient, floating
     book mockups, stat counters, and dual CTAs.
     ═══════════════════════════════════════════════════════════ -->
<section class="hero-modern hero-mesh hero-grid relative overflow-hidden">
    <!-- Floating book mockups (desktop only) -->
    <div class="absolute inset-0 pointer-events-none hidden lg:block" aria-hidden="true">
        <div class="float-1 absolute right-[8%] top-[18%] w-40 h-52 rounded-2xl bg-gradient-to-br from-[var(--primary)] to-[var(--primary-lt)] shadow-2xl rotate-6 opacity-90 border border-white/10">
            <div class="p-4">
                <i class="fas fa-book-open text-white/80 text-2xl"></i>
                <div class="mt-3 h-1.5 w-3/4 bg-white/30 rounded"></div>
                <div class="mt-2 h-1.5 w-1/2 bg-white/20 rounded"></div>
            </div>
        </div>
        <div class="float-2 absolute right-[22%] top-[42%] w-32 h-44 rounded-2xl bg-gradient-to-br from-emerald to-cyan shadow-2xl -rotate-12 opacity-90 border border-white/10">
            <div class="p-3">
                <i class="fas fa-microscope text-white/80 text-xl"></i>
                <div class="mt-3 h-1.5 w-2/3 bg-white/30 rounded"></div>
            </div>
        </div>
        <div class="float-3 absolute right-[5%] bottom-[14%] w-28 h-28 rounded-2xl glass-dark flex items-center justify-center">
            <i class="fas fa-award text-gold text-3xl"></i>
        </div>
    </div>

    <div class="container mx-auto px-6 lg:px-8 py-24 lg:py-32 relative z-10">
        <div class="max-w-3xl" data-reveal>
            <div class="pill pill-glass mb-6">
                <i class="fas fa-star text-gold text-[10px]"></i>
                Get Your Dreams Inked
            </div>

            <h1 class="font-modern text-4xl md:text-5xl lg:text-[64px] font-extrabold text-white leading-[1.05] tracking-tight mb-6">
                Welcome to the<br>
                Rainbow <span class="text-gradient">Publications</span>
            </h1>

            <div class="flex flex-wrap gap-4">
                <a href="<?= BASE_URL ?>/books" class="btn-modern btn-modern-primary">
                    <i class="fas fa-book"></i> Explore Books
                </a>
                <a href="<?= BASE_URL ?>/journals" class="btn-modern btn-modern-glass">
                    <i class="fas fa-journal-whills"></i> Browse Journals
                </a>
            </div>

            <!-- Stat counters -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 mt-16">
                <?php
                $counterData = [
                    [(int)getSetting('counter_total_books', '500'),     '+',  'Books Published'],
                    [(int)getSetting('counter_total_journals', '50'),   '+',  'Research Journals'],
                    [(int)getSetting('counter_total_members', '10000'), '+',  'Members Worldwide'],
                    [(int)getSetting('counter_years_exp', '15'),        '+',  'Years Experience'],
                ];
                foreach ($counterData as [$num, $suf, $label]):
                ?>
                <div data-reveal data-reveal-delay="1">
                    <div class="font-modern text-4xl font-extrabold text-white counter-num"
                         data-counter="<?= $num ?>" data-suffix="<?= $suf ?>">0<?= $suf ?></div>
                    <div class="text-white/40 text-xs uppercase tracking-wider mt-1.5 font-semibold"><?= $label ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Bottom wave transition -->
    <div class="absolute bottom-0 left-0 right-0 leading-none pointer-events-none">
        <svg viewBox="0 0 1440 80" class="w-full h-12 md:h-20" preserveAspectRatio="none">
            <path fill="var(--bg)" d="M0,40 C360,90 720,0 1080,30 C1260,45 1380,55 1440,50 L1440,80 L0,80 Z"/>
        </svg>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     SECTION 2 — TRUST STRIP
     Scrolling marquee of quality badges
     ═══════════════════════════════════════════════════════════ -->
<section class="bg-white py-8 border-b border-slate-100">
    <div class="container mx-auto px-6">
        <p class="text-center text-[11px] font-bold uppercase tracking-[0.2em] text-slate-400 mb-6">Indexing &amp; Quality Standards</p>
        <div class="marquee-wrap overflow-hidden">
            <div class="marquee-track flex items-center">
                <?php $badges = ['Scopus Indexed','Peer Reviewed','DOI Registered','Open Access','ISSN Certified','Crossref Member','Google Scholar','Double-Blind Review'];
                for ($i = 0; $i < 2; $i++): foreach ($badges as $b): ?>
                <span class="flex items-center gap-2 text-slate-400 font-semibold text-sm whitespace-nowrap mx-4">
                    <i class="fas fa-check-circle text-emerald text-xs"></i><?= $b ?>
                </span>
                <?php endforeach; endfor; ?>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     SECTION 3 — FEATURED CONFERENCE
     Highlighted event card with poster, details, and CTA
     ═══════════════════════════════════════════════════════════ -->
<?php if (!empty($conference)): ?>
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="flex items-end justify-between mb-10" data-reveal>
            <div>
                <span class="eyebrow mb-3">Featured Event</span>
                <h2 class="font-modern text-3xl md:text-[42px] font-extrabold text-[var(--heading)] tracking-tight mt-2">
                    <?= htmlspecialchars($conference['title']) ?>
                </h2>
                <?php if (!empty($conference['conference_date'])): ?>
                <p class="text-[var(--text-muted)] mt-2 text-sm font-semibold">
                    <i class="fas fa-calendar text-[var(--primary)] mr-1.5"></i>
                    <?= formatDate($conference['conference_date'], 'l, F d, Y') ?>
                </p>
                <?php endif; ?>
            </div>
            <a href="<?= BASE_URL ?>/conferences"
               class="hidden md:inline-flex items-center gap-2 text-[var(--primary)] hover:text-[var(--primary-lt)] font-bold text-sm transition-colors">
                View All <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid lg:grid-cols-2 gap-8 items-start bg-[var(--bg)] rounded-3xl p-6 md:p-8" data-reveal>
            <!-- Poster image -->
            <div class="flex justify-center">
                <?php if (!empty($conference['poster_image'])): ?>
                <img src="<?= uploadUrl('conferences', $conference['poster_image']) ?>"
                     alt="<?= htmlspecialchars($conference['title']) ?>"
                     class="w-full max-w-md rounded-2xl shadow-card">
                <?php else: ?>
                <div class="w-full max-w-md aspect-[3/4] bg-gradient-to-br from-[var(--text)] to-[var(--primary)] rounded-2xl flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-6xl text-white/30"></i>
                </div>
                <?php endif; ?>
            </div>

            <!-- Event details -->
            <div class="space-y-5">
                <?php if (!empty($conference['subtitle'])): ?>
                <span class="pill pill-indigo"><?= htmlspecialchars($conference['subtitle']) ?></span>
                <?php endif; ?>

                <?php if (!empty($conference['intro_paragraph'])): ?>
                <p class="text-[var(--text-muted)] leading-relaxed text-[15px]"><?= htmlspecialchars(truncate($conference['intro_paragraph'], 280)) ?></p>
                <?php endif; ?>

                <?php
                $incl = array_values(array_filter(array_map('trim', preg_split('/
|
|
/', $conference['registration_includes'] ?? ''))));
                if (!empty($incl)):
                ?>
                <div>
                    <p class="text-[var(--secondary)] font-bold text-sm mb-2">Registration includes:</p>
                    <ul class="space-y-2">
                        <?php foreach (array_slice($incl, 0, 4) as $line): ?>
                        <li class="flex items-start gap-2.5 text-[var(--text)] text-sm">
                            <i class="fas fa-check-circle text-emerald text-xs mt-1 flex-shrink-0"></i>
                            <span><?= htmlspecialchars($line) ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <?php if (!empty($conference['registration_fee'])): ?>
                <div class="flex items-center gap-2.5 text-sm">
                    <i class="fas fa-tag text-[var(--secondary)]"></i>
                    <span class="text-[var(--text)] font-semibold"><?= htmlspecialchars($conference['registration_fee']) ?></span>
                </div>
                <?php endif; ?>

                <div class="flex flex-wrap gap-3 pt-2">
                    <a href="<?= BASE_URL ?>/conference/<?= htmlspecialchars($conference['slug']) ?>"
                       class="btn-modern btn-modern-primary !py-2.5 !px-5 text-sm">
                        View Details <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                    <?php if (!empty($conference['registration_link'])): ?>
                    <a href="<?= htmlspecialchars($conference['registration_link']) ?>" target="_blank" rel="noopener"
                       class="btn-modern btn-modern-emerald !py-2.5 !px-5 text-sm">
                        <i class="fas fa-edit text-xs"></i> Register Now
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="text-center mt-8 md:hidden">
            <a href="<?= BASE_URL ?>/conferences" class="btn-modern btn-modern-primary text-sm">View All Conferences <i class="fas fa-arrow-right text-xs"></i></a>
        </div>
    </div>
</section>
<?php endif; ?>


<!-- ═══════════════════════════════════════════════════════════
     SECTION 4 — FEATURED BOOKS
     3-column card grid with cover images, hover 3D effect,
     category pills, and "Read More" actions
     ═══════════════════════════════════════════════════════════ -->
<section class="py-24" style="background:var(--bg);">
    <div class="container mx-auto px-6">
        <div class="flex items-end justify-between mb-14" data-reveal>
            <div>
                <span class="eyebrow mb-3">Latest Publications</span>
                <h2 class="font-modern text-3xl md:text-[42px] font-extrabold text-[var(--heading)] tracking-tight mt-2">Featured Books</h2>
            </div>
            <a href="<?= BASE_URL ?>/books" class="hidden md:inline-flex items-center gap-2 text-[var(--primary)] hover:text-[var(--primary-lt)] font-bold text-sm transition-colors">
                View All Books <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        <?php if (empty($featuredBooks)): ?>
        <div class="empty-state">
            <i class="fas fa-book"></i>
            <p>Books will appear here once added.</p>
        </div>
        <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($featuredBooks as $i => $book): ?>
            <article class="card-modern group" data-reveal data-reveal-delay="<?= ($i % 3) + 1 ?>">
                <!-- Cover image with 3D hover -->
                <div class="relative overflow-hidden h-72 book-3d bg-slate-100">
                    <div class="book-3d-inner w-full h-full">
                        <?php if ($book['cover_image']): ?>
                        <img data-src="<?= uploadUrl('books', $book['cover_image']) ?>"
                             src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                             alt="<?= Security::e($book['title']) ?>"
                             class="w-full h-full object-cover">
                        <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[var(--text)] to-[var(--primary)]">
                            <i class="fas fa-book text-white/30 text-6xl"></i>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="absolute top-3 left-3 flex gap-2">
                        <?php if ($book['is_featured']): ?>
                        <span class="pill pill-gold !bg-gold !text-white shadow-lg">Featured</span>
                        <?php endif; ?>
                    </div>
                    <?php if ($book['category']): ?>
                    <span class="absolute top-3 right-3 pill pill-glass backdrop-blur-md"><?= Security::e($book['category']) ?></span>
                    <?php endif; ?>
                </div>

                <!-- Card body -->
                <div class="p-6">
                    <h3 class="font-modern font-bold text-[var(--heading)] text-lg leading-snug mb-2 line-clamp-2 group-hover:text-[var(--primary)] transition-colors">
                        <a href="<?= BASE_URL ?>/book/<?= Security::e($book['slug']) ?>"><?= Security::e($book['title']) ?></a>
                    </h3>
                    <p class="text-[var(--text-muted)] text-sm mb-3 flex items-center gap-1.5">
                        <i class="fas fa-user-pen text-[var(--primary)] text-xs"></i>
                        <?= Security::e($book['authors']) ?>
                    </p>
                    <?php if ($book['description']): ?>
                    <p class="text-[var(--text-muted)] text-sm line-clamp-2 mb-4 leading-relaxed"><?= truncate($book['description'], 110) ?></p>
                    <?php endif; ?>
                    <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                        <?php if ($book['publication_date']): ?>
                        <span class="text-[var(--text-muted)] text-xs font-semibold"><?= formatDate($book['publication_date'], 'Y') ?></span>
                        <?php else: ?><span></span><?php endif; ?>
                        <a href="<?= BASE_URL ?>/book/<?= Security::e($book['slug']) ?>" class="inline-flex items-center gap-1.5 text-[var(--primary)] hover:text-[var(--primary-lt)] text-sm font-bold transition-colors">
                            Read More <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="text-center mt-12 md:hidden">
            <a href="<?= BASE_URL ?>/books" class="btn-modern btn-modern-primary text-sm">View All Books <i class="fas fa-arrow-right text-xs"></i></a>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     SECTION 5 — SERVICES
     3-column icon cards with hover animations
     ═══════════════════════════════════════════════════════════ -->
<section class="py-24 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-14" data-reveal>
            <span class="eyebrow mb-3 justify-center" style="display:inline-flex">What We Offer</span>
            <h2 class="font-modern text-3xl md:text-[42px] font-extrabold text-[var(--heading)] tracking-tight mt-2">Our Services</h2>
            <p class="text-[var(--text-muted)] mt-3 max-w-xl mx-auto text-[15px]">End-to-end academic publishing solutions tailored for researchers and institutions.</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($services as $i => $service): ?>
            <a href="<?= BASE_URL ?>/service/<?= Security::e($service['slug']) ?>"
               class="card-modern group p-7 block" data-reveal data-reveal-delay="<?= ($i % 3) + 1 ?>">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[var(--primary)] to-[var(--primary-lt)] flex items-center justify-center mb-5 shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500" style="background:linear-gradient(135deg, var(--primary), var(--primary-lt));">
                    <i class="<?= Security::e($service['icon'] ?: 'fa-solid fa-book') ?> text-white text-2xl"></i>
                </div>
                <h3 class="font-modern font-bold text-[var(--heading)] text-lg mb-2 group-hover:text-[var(--primary)] transition-colors"><?= Security::e($service['title']) ?></h3>
                <p class="text-[var(--text-muted)] text-sm leading-relaxed mb-4"><?= Security::e($service['short_description']) ?></p>
                <span class="inline-flex items-center gap-1.5 text-[var(--primary)] text-sm font-bold">Learn more <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     SECTION 6 — JOURNALS
     Dark-themed section with glass cards and journal CTAs
     ═══════════════════════════════════════════════════════════ -->
<section class="py-24 hero-modern hero-mesh relative overflow-hidden">
    <div class="container mx-auto px-6 relative z-10">
        <div class="flex items-end justify-between mb-14" data-reveal>
            <div>
                <span class="eyebrow mb-3" style="color:#A5B4FC">Peer Reviewed</span>
                <h2 class="font-modern text-3xl md:text-[42px] font-extrabold text-white tracking-tight mt-2">Our Journals</h2>
            </div>
            <a href="<?= BASE_URL ?>/journals" class="hidden md:inline-flex items-center gap-2 text-white/60 hover:text-white font-bold text-sm transition-colors">
                View All <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($journals as $i => $journal): ?>
            <div class="glass-dark glow-hover rounded-2xl p-6 group" data-reveal data-reveal-delay="<?= ($i % 3) + 1 ?>">
                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center flex-shrink-0 overflow-hidden shadow-lg">
                        <?php if ($journal['logo']): ?>
                        <img src="<?= uploadUrl('journals', $journal['logo']) ?>" alt="<?= Security::e($journal['name']) ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                        <span class="text-[var(--primary)] font-extrabold text-sm text-center leading-tight px-1"><?= Security::e($journal['abbreviation'] ?: substr($journal['name'], 0, 4)) ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-white text-sm leading-snug mb-1.5 line-clamp-2"><?= Security::e($journal['name']) ?></h3>
                        <?php if ($journal['issn']): ?>
                        <span class="pill pill-glass !text-[10px] !py-1 mb-2">ISSN: <?= Security::e($journal['issn']) ?></span>
                        <?php endif; ?>
                        <p class="text-white/50 text-xs line-clamp-2 mt-2"><?= Security::e($journal['description']) ?></p>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-white/8 flex items-center gap-2">
                    <?php
                    $href   = $journal['journal_url'] ?: '#';
                    $target = (strpos($href, 'http') === 0) ? ' target="_blank" rel="noopener"' : '';
                    ?>
                    <a href="<?= htmlspecialchars($href) ?>" <?= $target ?>
                       class="w-10 h-10 rounded-xl flex items-center justify-center bg-white/10 hover:bg-[var(--primary)] text-white/70 hover:text-white transition shadow-sm"
                       title="Visit Journal Website" aria-label="Visit Journal">
                        <i class="fas fa-external-link-alt text-sm"></i>
                    </a>
                    <a href="<?= BASE_URL ?>/journals/submit/<?= (int)$journal['id'] ?>"
                       class="btn-modern btn-modern-primary !py-2.5 !px-4 text-sm flex items-center gap-1.5">
                        <i class="fas fa-paper-plane text-xs"></i> Submit Article
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════
     SECTION 7 — EDITORIAL BOARD
     4-column avatar cards with name, designation, institution
     ═══════════════════════════════════════════════════════════ -->
<?php if (!empty($editorialBoard)): ?>
<section class="py-24 bg-white">
    <div class="container mx-auto px-6">
        <div class="flex items-end justify-between mb-14" data-reveal>
            <div>
                <span class="eyebrow mb-3">Meet Our Leaders</span>
                <h2 class="font-modern text-3xl md:text-[42px] font-extrabold text-[var(--heading)] tracking-tight mt-2">Editorial Board</h2>
            </div>
            <a href="<?= BASE_URL ?>/editorial-board" class="hidden md:inline-flex items-center gap-2 text-[var(--primary)] hover:text-[var(--primary-lt)] font-bold text-sm transition-colors">
                View All <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach ($editorialBoard as $i => $member): ?>
            <article class="card-modern group p-6 text-center" data-reveal data-reveal-delay="<?= ($i % 4) + 1 ?>">
                <div class="relative mb-4">
                    <?php if ($member['photo']): ?>
                        <img src="<?= uploadUrl('board', $member['photo']) ?>"
                             alt="<?= htmlspecialchars($member['name']) ?>"
                             class="w-20 h-20 rounded-full object-cover mx-auto ring-4 ring-white shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <?php else: ?>
                        <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto ring-4 ring-white shadow-lg group-hover:scale-110 transition-transform duration-300" style="background:linear-gradient(135deg, var(--primary), var(--primary-lt));">
                            <i class="fas fa-user text-2xl text-white/80"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <h4 class="font-modern font-bold text-[var(--heading)] text-sm leading-snug mb-1"><?= htmlspecialchars($member['name']) ?></h4>
                <?php if ($member['designation']): ?>
                    <p class="text-[var(--primary)] text-xs font-bold uppercase tracking-wider mb-2"><?= htmlspecialchars($member['designation']) ?></p>
                <?php endif; ?>
                <?php if ($member['institution']): ?>
                    <p class="text-[var(--text-muted)] text-xs leading-relaxed"><?= htmlspecialchars($member['institution']) ?></p>
                <?php endif; ?>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>


<!-- ═══════════════════════════════════════════════════════════
     SECTION 8 — TESTIMONIALS
     Google-review style cards with ratings and avatars
     ═══════════════════════════════════════════════════════════ -->
<?php if (!empty($testimonials)): ?>
<section class="py-24 relative overflow-hidden" style="background:var(--bg);">
    <!-- Decorative blurs -->
    <div class="absolute -top-20 -right-20 w-80 h-80 rounded-full blur-3xl pointer-events-none" style="background:rgba(var(--primary-rgb),.05);"></div>
    <div class="absolute -bottom-20 -left-20 w-80 h-80 rounded-full blur-3xl pointer-events-none" style="background:rgba(var(--primary-rgb),.05);"></div>

    <div class="container mx-auto px-6 relative">
        <div class="text-center max-w-3xl mx-auto mb-16" data-reveal>
            <span class="eyebrow mb-3 justify-center" style="display:inline-flex">What People Say</span>
            <h2 class="font-modern text-3xl md:text-[42px] font-extrabold text-[var(--heading)] tracking-tight mt-2">Voices From Our Community</h2>
            <p class="text-[var(--text-muted)] mt-4 text-lg leading-relaxed">Authentic reviews from authors, researchers, and academic institutions we've worked with.</p>

            <!-- Google review badge -->
            <div class="inline-flex items-center gap-3 mt-6 bg-white px-5 py-2.5 rounded-full border border-slate-200 shadow-sm" data-reveal>
                <span class="w-7 h-7 rounded-full bg-white flex items-center justify-center shadow-sm border border-slate-200">
                    <svg viewBox="0 0 24 24" class="w-4 h-4"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                </span>
                <span class="text-sm font-semibold text-[var(--heading)]">Google Reviews</span>
                <span class="flex items-center gap-0.5 text-amber-400 text-sm">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                </span>
                <span class="text-xs text-[var(--text-muted)] font-semibold">4.8 / 5</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
            <?php foreach (array_slice($testimonials, 0, 8) as $i => $t):
                $letter  = $t['avatar_letter'] !== '' ? $t['avatar_letter'] : strtoupper(substr($t['reviewer_name'], 0, 1));
                $color   = $t['avatar_color'] ?: '#1e73be';
                $initial = $letter ?: 'U';
                $rating  = max(1, min(5, (int)($t['rating'] ?? 5)));
            ?>
            <div class="bg-white rounded-2xl p-6 border border-slate-200/70 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-500 group" data-reveal data-reveal-delay="<?= ($i % 4) + 1 ?>">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-11 h-11 rounded-full flex items-center justify-center text-white text-lg font-bold flex-shrink-0 shadow-sm"
                         style="background: <?= Security::e($color) ?>">
                        <?= Security::e($initial) ?>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-bold text-[var(--heading)] text-sm leading-tight truncate"><?= Security::e($t['reviewer_name']) ?></p>
                        <p class="text-xs text-[var(--text-muted)] leading-tight truncate">
                            <?= Security::e($t['review_count'] ?: '1 review') ?>
                        </p>
                    </div>
                    <div class="w-7 h-7 rounded-full bg-white flex items-center justify-center flex-shrink-0 shadow-sm border border-slate-200">
                        <svg viewBox="0 0 24 24" class="w-3.5 h-3.5"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                    </div>
                </div>

                <div class="flex items-center gap-1.5 mb-3">
                    <div class="flex items-center gap-0.5 text-amber-400 text-sm">
                        <?php for($s = 1; $s <= 5; $s++): ?>
                            <i class="fas fa-star<?= $s <= $rating ? '' : ' text-slate-200' ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <span class="text-xs text-[var(--text-muted)] font-medium"><?= Security::e($t['review_date'] ?: 'just now') ?></span>
                </div>

                <p class="text-[var(--text)] text-sm leading-relaxed line-clamp-5">
                    <i class="fas fa-quote-left text-[var(--primary)] opacity-15 text-2xl -ml-1 -mt-1 mr-1 align-top"></i>
                    <?= Security::e($t['content']) ?>
                </p>

                <?php if (!empty($t['designation']) || !empty($t['organization'])): ?>
                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center gap-2">
                    <i class="fas fa-graduation-cap text-[var(--primary)] opacity-40 text-xs"></i>
                    <p class="text-xs text-[var(--text-muted)] font-medium leading-tight truncate">
                        <?= Security::e($t['designation']) ?>
                        <?php if (!empty($t['designation']) && !empty($t['organization'])): ?>·<?php endif; ?>
                        <?= Security::e($t['organization']) ?>
                    </p>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>


<!-- ═══════════════════════════════════════════════════════════
     SECTION 9 — LATEST NEWS
     3-column article cards with image, category, date, excerpt
     ═══════════════════════════════════════════════════════════ -->
<?php if (!empty($latestNews)): ?>
<section class="py-24 bg-white">
    <div class="container mx-auto px-6">
        <div class="flex items-end justify-between mb-14" data-reveal>
            <div>
                <span class="eyebrow mb-3">Stay Updated</span>
                <h2 class="font-modern text-3xl md:text-[42px] font-extrabold text-[var(--heading)] tracking-tight mt-2">Latest News</h2>
            </div>
            <a href="<?= BASE_URL ?>/news" class="hidden md:inline-flex items-center gap-2 text-[var(--primary)] hover:text-[var(--primary-lt)] font-bold text-sm transition-colors">
                All News <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($latestNews as $i => $article): ?>
            <article class="card-modern group overflow-hidden" data-reveal data-reveal-delay="<?= ($i % 3) + 1 ?>">
                <div class="relative overflow-hidden h-52 bg-slate-100">
                    <?php if ($article['featured_image']): ?>
                    <img data-src="<?= uploadUrl('news', $article['featured_image']) ?>"
                         src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                         alt="<?= Security::e($article['title']) ?>"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[var(--text)] to-[var(--primary)]"><i class="fas fa-newspaper text-white/30 text-5xl"></i></div>
                    <?php endif; ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-[var(--text)]/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-3">
                        <?php if ($article['category']): ?>
                        <span class="pill pill-indigo !text-[10px] !py-1"><?= Security::e($article['category']) ?></span>
                        <?php endif; ?>
                        <span class="text-xs text-[var(--text-muted)] font-semibold"><?= formatDate($article['published_at']) ?></span>
                    </div>
                    <h3 class="font-modern font-bold text-[var(--heading)] text-lg leading-snug mb-2 group-hover:text-[var(--primary)] transition-colors line-clamp-2">
                        <a href="<?= BASE_URL ?>/news/<?= Security::e($article['slug']) ?>"><?= Security::e($article['title']) ?></a>
                    </h3>
                    <p class="text-[var(--text-muted)] text-sm line-clamp-2 mb-4"><?= Security::e($article['excerpt'] ?: truncate($article['content'], 110)) ?></p>
                    <a href="<?= BASE_URL ?>/news/<?= Security::e($article['slug']) ?>" class="inline-flex items-center gap-1.5 text-[var(--primary)] text-sm font-bold">Read article <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i></a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>


<!-- ═══════════════════════════════════════════════════════════
     SECTION 10 — CTA BANNER
     Final call-to-action with gradient background
     ═══════════════════════════════════════════════════════════ -->
<section class="py-20">
    <div class="container mx-auto px-6">
        <div class="relative rounded-3xl overflow-hidden hero-modern hero-mesh p-12 md:p-16 text-center" data-reveal>
            <div class="relative z-10">
                <h2 class="font-modern text-3xl md:text-[40px] font-extrabold text-white mb-4 tracking-tight">Ready to Publish Your Research?</h2>
                <p class="text-white/60 max-w-xl mx-auto mb-8 text-[15px]">Join thousands of researchers and academics who trust us with their publications.</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="<?= BASE_URL ?>/contact" class="btn-modern btn-modern-primary">Get In Touch <i class="fas fa-arrow-right text-xs"></i></a>
                    <a href="<?= BASE_URL ?>/services" class="btn-modern btn-modern-glass">Our Services</a>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>
