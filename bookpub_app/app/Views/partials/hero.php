<?php
/**
 * Reusable page hero. All pages should include this for a consistent look.
 *
 * Usage:
 *   $heroCrumbs = [['label' => 'Books', 'url' => BASE_URL . '/books']]; // optional, defaults to []
 *   $heroIntro  = 'Optional intro paragraph shown below the title.';
 *   $heroSize   = 'lg' | 'md' | 'sm';   // controls vertical padding
 *   include __DIR__ . '/../partials/hero.php';
 *
 * Required: $pageTitle must be set.
 */
$heroCrumbs = $heroCrumbs ?? [];
$heroIntro  = $heroIntro  ?? '';
$heroSize   = $heroSize   ?? 'lg';
$padY       = $heroSize === 'sm' ? 'py-12' : ($heroSize === 'md' ? 'py-16' : 'py-20');
$hClass     = $heroSize === 'sm' ? 'text-3xl md:text-4xl'
             : ($heroSize === 'md' ? 'text-3xl md:text-4xl'
             : 'text-4xl md:text-5xl');
?>
<section class="page-hero">

    <div class="hero-mesh"></div>

    <div class="hero-orbs">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <div class="container mx-auto px-4 py-24 relative z-10">
        <div class="max-w-3xl rounded-2xl border border-white/20 bg-white/10 px-6 py-8 shadow-lg backdrop-blur-sm" data-reveal>

            <nav class="flex items-center gap-2 text-sm mb-5 flex-wrap">
                <a href="<?= BASE_URL ?>" class="breadcrumb-link">Home</a>

                <?php foreach ($heroCrumbs as $crumb): ?>
                    <i class="fas fa-angle-right text-xs breadcrumb-sep"></i>
                    <a href="<?= Security::e($crumb['url']) ?>" class="breadcrumb-link">
                        <?= htmlspecialchars($crumb['label']) ?>
                    </a>
                <?php endforeach; ?>

                <?php if (!empty($heroCrumbs)): ?>
                    <i class="fas fa-angle-right text-xs breadcrumb-sep"></i>
                <?php endif; ?>

                <span class="breadcrumb-current">
                    <?= htmlspecialchars($pageTitle ?? '') ?>
                </span>
            </nav>


            <h1 class="hero-title">
                <span class="hero-title-line">
                    <?= htmlspecialchars($pageTitle ?? '') ?>
                </span>
            </h1>


            <div class="hero-divider"></div>


            <?php if ($heroIntro !== ''): ?>
            <p class="hero-subtitle">
                <?= $heroIntro ?>
            </p>
            <?php endif; ?>


        </div>
    </div>


    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 70" class="w-full h-10 md:h-16" preserveAspectRatio="none">
            <path fill="var(--slate-50)" d="M0,35 C360,80 720,0 1080,25 C1260,38 1380,48 1440,44 L1440,70 L0,70 Z"/>
        </svg>
    </div>

</section>

