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
<section class="hero-modern hero-mesh relative overflow-hidden">
    <div class="container mx-auto px-4 <?= $padY ?> relative z-10">
        <div class="max-w-3xl" data-reveal>
            <nav class="flex items-center gap-2 text-sm text-white/60 mb-4 flex-wrap">
                <a href="<?= BASE_URL ?>" class="hover:text-white transition-colors">Home</a>
                <?php foreach ($heroCrumbs as $crumb): ?>
                <i class="fas fa-angle-right text-xs"></i>
                <a href="<?= Security::e($crumb['url']) ?>" class="hover:text-white transition-colors"><?= htmlspecialchars($crumb['label']) ?></a>
                <?php endforeach; ?>
                <?php if (!empty($heroCrumbs)): ?>
                <i class="fas fa-angle-right text-xs"></i>
                <?php endif; ?>
                <span class="text-white"><?= htmlspecialchars($pageTitle ?? '') ?></span>
            </nav>

            <h1 class="font-modern <?= $hClass ?> font-extrabold text-white tracking-tight mb-4"><?= htmlspecialchars($pageTitle ?? '') ?></h1>

            <?php if ($heroIntro !== ''): ?>
            <p class="text-white/85 text-base md:text-lg leading-relaxed max-w-3xl"><?= $heroIntro ?></p>
            <?php endif; ?>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 70" class="w-full h-10 md:h-16" preserveAspectRatio="none"><path fill="#f8fafc" d="M0,35 C360,80 720,0 1080,25 C1260,38 1380,48 1440,44 L1440,70 L0,70 Z"/></svg>
    </div>
</section>
