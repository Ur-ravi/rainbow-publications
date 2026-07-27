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


<section class="hero-modern hero-mesh relative overflow-hidden">
    <div class="container mx-auto px-4 py-20 relative z-10">
        <div class="max-w-3xl" data-reveal>
            <nav class="flex items-center gap-2 text-sm text-white/60 mb-4">
                <a href="<?= BASE_URL ?>" class="hover:text-white transition-colors">Home</a>
              <span class="sep">/</span>
                <a href="<?= $parentCrumb['url'] ?>"><?= htmlspecialchars($parentCrumb['label']) ?></a>
                <span class="sep">/</span>
                <span><?= htmlspecialchars($pageTitle) ?></span>
            </nav>
            
            <h1 class="font-modern text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-4"><?= htmlspecialchars($pageTitle) ?></h1>
            
            
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 70" class="w-full h-10 md:h-16" preserveAspectRatio="none"><path fill="#f8fafc" d="M0,35 C360,80 720,0 1080,25 C1260,38 1380,48 1440,44 L1440,70 L0,70 Z"/></svg>
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
