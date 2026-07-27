<?php $pageTitle = 'Our Journals'; ?>
<!-- HERO -->
<section class="page-hero">
    <div class="hero-mesh"></div>
    <div class="hero-orbs">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <div class="container mx-auto px-4 py-24 relative z-10">
        <div class="max-w-3xl" data-reveal>

            <nav class="flex items-center gap-2 text-sm mb-5">
                <a href="<?= BASE_URL ?>" class="breadcrumb-link">Home</a>
                <i class="fas fa-angle-right text-xs breadcrumb-sep"></i>
                <span class="breadcrumb-current"><?= htmlspecialchars($pageTitle) ?></span>
            </nav>

            <span class="pill pill-glass mb-4">
                <i class="fas fa-journal-whills text-gold text-[10px]"></i>
                Peer Reviewed
            </span>

            <h1 class="hero-title">
                <span class="hero-title-line"><?= htmlspecialchars($pageTitle) ?></span>
            </h1>

            <div class="hero-divider"></div>

            <p class="hero-subtitle">
                Access peer-reviewed academic journals spanning multiple disciplines and research domains.
            </p>

        </div>
    </div>

    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 70" class="w-full h-10 md:h-16" preserveAspectRatio="none">
            <path fill="var(--slate-50)" d="M0,35 C360,80 720,0 1080,25 C1260,38 1380,48 1440,44 L1440,70 L0,70 Z"/>
        </svg>
    </div>
</section>

<!-- GRID -->
    <section class="py-24" style="background: white;">
        <div class="container mx-auto px-6">
            <div class="section-header flex justify-between items-end flex-wrap gap-4" data-reveal>
                <div>
                    <span class="section-label">Peer Reviewed</span>
                    <h2 class="heading-lg">Our Journals</h2>
                </div>
                
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
