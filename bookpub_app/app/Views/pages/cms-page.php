<?php
$page    = $page ?? null;
$seo     = $seo ?? ['page_title' => '', 'meta_description' => ''];

if (!$page) {
    http_response_code(404);
    $page = ['title' => 'Page Not Found', 'content' => '<p>The page you are looking for is currently being prepared. Please check back soon.</p>'];
}

// Breadcrumb parent is "Membership" → /membership
$parentCrumb = ['label' => 'Membership', 'url' => BASE_URL . '/membership'];
$pageTitle   = $page['title'];
?>


<section class="page-hero">

    <div class="hero-mesh"></div>

    <div class="hero-orbs">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <div class="container mx-auto px-4 py-20 relative z-10">
        <div class="max-w-3xl" data-reveal>

            <nav class="flex items-center gap-2 text-sm mb-5 flex-wrap">

                <a href="<?= BASE_URL ?>" class="breadcrumb-link">
                    Home
                </a>

                <i class="fas fa-angle-right text-xs breadcrumb-sep"></i>

                <a href="<?= $parentCrumb['url'] ?>" class="breadcrumb-link">
                    <?= htmlspecialchars($parentCrumb['label']) ?>
                </a>

                <i class="fas fa-angle-right text-xs breadcrumb-sep"></i>

                <span class="breadcrumb-current">
                    <?= htmlspecialchars($pageTitle) ?>
                </span>

            </nav>


            <h1 class="hero-title">
                <span class="hero-title-line">
                    <?= htmlspecialchars($pageTitle) ?>
                </span>
            </h1>


            <div class="hero-divider"></div>


        </div>
    </div>


    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 70" class="w-full h-10 md:h-16" preserveAspectRatio="none">
            <path fill="var(--slate-50)" d="M0,35 C360,80 720,0 1080,25 C1260,38 1380,48 1440,44 L1440,70 L0,70 Z"/>
        </svg>
    </div>

</section>

<section class="py-16 bg-white">
    <div class="container mx-auto px-4 max-w-4xl">
        <article class="prose-content space-y-6 text-gray-700 leading-relaxed">
            <?= sanitizeRichHtml($page['content'] ?? '') ?>
        </article>

        <div class="mt-12 p-6 bg-gray-50 rounded-2xl border border-gray-100">
            <h3 class="font-serif text-lg font-bold text-primary mb-2">Ready to join?</h3>
            <p class="text-gray-600 text-sm mb-3">Browse our membership categories or apply online.</p>
            <div class="flex flex-wrap gap-3 text-sm">
                <a href="<?= BASE_URL ?>/membership-types" class="inline-flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-lg font-semibold hover:opacity-90 transition">
                    <i class="fas fa-id-card"></i> Apply for Membership
                </a>
                <a href="<?= BASE_URL ?>/membership" class="inline-flex items-center gap-2 text-primary hover:text-primary-dark font-medium">
                    <i class="fas fa-list"></i> View Membership List
                </a>
            </div>
        </div>
    </div>
</section>
