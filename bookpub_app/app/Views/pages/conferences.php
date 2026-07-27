<?php $conferences = $conferences ?? []; ?>

<!-- HERO -->
<section class="page-hero">

    <div class="hero-mesh"></div>

    <div class="hero-orbs">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <div class="container mx-auto px-4 py-24 relative z-10">
        <div class="max-w-3xl mx-auto text-center" data-reveal>

            <nav class="flex items-center justify-center gap-2 text-sm mb-5">
                <a href="<?= BASE_URL ?>" class="breadcrumb-link">
                    Home
                </a>

                <i class="fas fa-angle-right text-xs breadcrumb-sep"></i>

                <span class="breadcrumb-current">
                    Conferences
                </span>
            </nav>


            <span class="pill pill-glass mb-4">
                <i class="fas fa-calendar-alt text-gold text-[10px]"></i>
                Conferences
            </span>


            <h1 class="hero-title">
                <span class="hero-title-line">
                    Academic Conferences
                </span>
            </h1>


<br>


            <p class="hero-subtitle mx-auto">
                Discover upcoming and past conferences hosted in collaboration with leading academic institutions worldwide.
            </p>


        </div>
    </div>


    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 70" class="w-full h-10 md:h-16" preserveAspectRatio="none">
            <path fill="var(--slate-50)" d="M0,35 C360,80 720,0 1080,25 C1260,38 1380,48 1440,44 L1440,70 L0,70 Z"/>
        </svg>
    </div>

</section>

<section class="py-20 md:py-24" style="background: var(--color-bg);">
    <div class="container mx-auto px-4 max-w-7xl">
        <!-- Section Header -->
        <div class="text-center mb-16" data-reveal>
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-4"
                  style="background: rgba(var(--rgb-primary), 0.08); color: var(--brand-primary);">
                <span class="w-1.5 h-1.5 rounded-full" style="background: var(--brand-primary);"></span>
                Events &amp; Gatherings
            </span>
            <h2 class="font-modern text-3xl md:text-5xl font-extrabold tracking-tight mt-3" style="color: var(--color-heading);">
                Upcoming Conferences
            </h2>
            <p class="mt-4 text-base md:text-lg max-w-2xl mx-auto" style="color: var(--color-muted);">
                Join leading researchers and academics at our flagship conferences and symposiums.
            </p>
        </div>

        <?php if (empty($conferences)): ?>
        <div class="text-center py-24" data-reveal>
            <div class="w-28 h-28 rounded-3xl flex items-center justify-center mx-auto mb-6"
                 style="background: var(--color-bg-alt); border: 2px dashed var(--color-border);">
                <i class="fas fa-calendar-alt text-5xl" style="color: var(--color-muted); opacity: 0.4;"></i>
            </div>
            <h3 class="text-2xl font-bold mb-2" style="color: var(--color-heading);">No conferences listed yet</h3>
            <p style="color: var(--color-muted);">Check back soon for upcoming events.</p>
        </div>
        <?php else: ?>

        <!-- Upcoming Conferences (featured) -->
        <?php
        $upcoming = array_filter($conferences, function($c) {
            return !empty($c['conference_date']) && strtotime($c['conference_date']) >= strtotime(date('Y-m-d'));
        });
        $past = array_filter($conferences, function($c) {
            return empty($c['conference_date']) || strtotime($c['conference_date']) < strtotime(date('Y-m-d'));
        });
        ?>
        <?php if (!empty($upcoming)): ?>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-20">
            <?php foreach ($upcoming as $i => $c): ?>
            <article class="conf-card group" data-reveal data-reveal-delay="<?= ($i % 3) + 1 ?>">
                <a href="<?= BASE_URL ?>/conference/<?= htmlspecialchars($c['slug']) ?>" class="block h-full">
                    <div class="relative overflow-hidden rounded-2xl" style="aspect-ratio: 16/10; background: var(--color-bg-alt);">
                        <?php if (!empty($c['poster_image'])): ?>
                        <img src="<?= uploadUrl('conferences', $c['poster_image']) ?>"
                             alt="<?= htmlspecialchars($c['title']) ?>"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                             loading="lazy">
                        <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center"
                             style="background: linear-gradient(135deg, var(--brand-primary-dk), var(--brand-primary));">
                            <i class="fas fa-calendar-alt text-6xl text-white/20"></i>
                        </div>
                        <?php endif; ?>

                        <!-- Gradient overlay -->
                        <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(30,37,37,0.85) 0%, rgba(30,37,37,0.1) 50%, transparent 100%);"></div>

                        <!-- Status badge -->
                        <div class="absolute top-4 right-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider"
                                  style="background: var(--color-success); color: #fff; box-shadow: 0 4px 12px rgba(var(--rgb-success), 0.4);">
                                <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                Upcoming
                            </span>
                        </div>

                        <!-- Date badge -->
                        <?php if (!empty($c['conference_date'])): ?>
                        <div class="absolute bottom-4 left-4 text-white">
                            <div class="text-2xl font-extrabold leading-none"><?= formatDate($c['conference_date'], 'd') ?></div>
                            <div class="text-xs font-semibold uppercase tracking-wider opacity-80"><?= formatDate($c['conference_date'], 'M Y') ?></div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="p-6 md:p-7" style="background: var(--color-bg-white); border: 1px solid var(--color-border); border-top: none; border-radius: 0 0 1rem 1rem;">
                        <h3 class="font-modern font-extrabold text-lg md:text-xl leading-snug mb-2 group-hover:opacity-80 transition-opacity" style="color: var(--color-heading);">
                            <?= htmlspecialchars($c['title']) ?>
                        </h3>
                        <?php if (!empty($c['subtitle'])): ?>
                        <p class="text-sm font-semibold mb-3" style="color: var(--brand-primary);"><?= htmlspecialchars($c['subtitle']) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($c['conference_date'])): ?>
                        <p class="text-sm flex items-center gap-2 mb-3" style="color: var(--color-muted);">
                            <i class="fas fa-map-marker-alt text-xs" style="color: var(--brand-secondary);"></i>
                            <?= formatDate($c['conference_date'], 'F d, Y') ?>
                        </p>
                        <?php endif; ?>
                        <?php if (!empty($c['intro_paragraph'])): ?>
                        <p class="text-sm leading-relaxed line-clamp-2" style="color: var(--color-muted);">
                            <?= htmlspecialchars(truncate($c['intro_paragraph'], 120)) ?>
                        </p>
                        <?php endif; ?>
                        <div class="mt-5 pt-4 flex items-center gap-2 text-sm font-bold" style="border-top: 1px solid var(--color-border); color: var(--brand-primary);">
                            View Details <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </div>
                </a>
            </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Past Conferences -->
        <?php if (!empty($past)): ?>
        <div data-reveal>
            <div class="flex items-center gap-4 mb-10">
                <h3 class="font-modern text-xl font-extrabold" style="color: var(--color-heading);">Past Conferences</h3>
                <div class="flex-1 h-px" style="background: var(--color-border);"></div>
            </div>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($past as $i => $c): ?>
                <article class="conf-card conf-card--past group" data-reveal data-reveal-delay="<?= ($i % 3) + 1 ?>">
                    <a href="<?= BASE_URL ?>/conference/<?= htmlspecialchars($c['slug']) ?>" class="block h-full">
                        <div class="relative overflow-hidden rounded-2xl" style="aspect-ratio: 16/10; background: var(--color-bg-alt);">
                            <?php if (!empty($c['poster_image'])): ?>
                            <img src="<?= uploadUrl('conferences', $c['poster_image']) ?>"
                                 alt="<?= htmlspecialchars($c['title']) ?>"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-80 group-hover:opacity-100"
                                 loading="lazy">
                            <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center" style="background: linear-gradient(135deg, #5A6565, #3a4545);">
                                <i class="fas fa-calendar-check text-5xl text-white/15"></i>
                            </div>
                            <?php endif; ?>
                            <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(30,37,37,0.8) 0%, transparent 60%);"></div>
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider"
                                      style="background: rgba(90,101,101,0.9); color: #fff;">
                                    Past
                                </span>
                            </div>
                            <?php if (!empty($c['conference_date'])): ?>
                            <div class="absolute bottom-3 left-3 text-white/70">
                                <div class="text-lg font-bold leading-none"><?= formatDate($c['conference_date'], 'd') ?></div>
                                <div class="text-[10px] font-semibold uppercase tracking-wider opacity-70"><?= formatDate($c['conference_date'], 'M Y') ?></div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="p-5" style="background: var(--color-bg-white); border: 1px solid var(--color-border); border-top: none; border-radius: 0 0 1rem 1rem;">
                            <h3 class="font-modern font-bold text-base leading-snug group-hover:opacity-70 transition-opacity" style="color: var(--color-heading);">
                                <?= htmlspecialchars($c['title']) ?>
                            </h3>
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold mt-3" style="color: var(--color-muted);">
                                View Archive <i class="fas fa-arrow-right text-[10px]"></i>
                            </span>
                        </div>
                    </a>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php endif; ?>
    </div>
</section>
