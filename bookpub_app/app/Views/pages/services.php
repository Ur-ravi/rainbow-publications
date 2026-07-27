<?php $pageTitle = $seo['page_title'] ?? 'Our Services | ' . APP_NAME; ?>




<section class="page-hero">

    <div class="hero-mesh"></div>

    <div class="hero-orbs">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <div class="container mx-auto px-4 py-20 relative z-10">
        <div class="max-w-3xl" data-reveal>

            <nav class="flex items-center gap-2 text-sm mb-5">
                <a href="<?= BASE_URL ?>" class="breadcrumb-link">
                    Home
                </a>

                <i class="fas fa-angle-right text-xs breadcrumb-sep"></i>

                <span class="breadcrumb-current">
                    Services
                </span>
            </nav>


            <h1 class="hero-title">
                <span class="hero-title-line">
                    Our Services
                </span>
            </h1>


            <div class="hero-divider"></div>


            <p class="hero-subtitle">
                End-to-end academic publishing solutions tailored for researchers, authors, and institutions.
            </p>

        </div>
    </div>


    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 70" class="w-full h-10 md:h-16" preserveAspectRatio="none">
            <path fill="var(--slate-50)" d="M0,35 C360,80 720,0 1080,25 C1260,38 1380,48 1440,44 L1440,70 L0,70 Z"/>
        </svg>
    </div>

</section>


<section class="py-16 bg-white">
    <div class="container mx-auto px-4 max-w-7xl">
        <?php if (empty($services)): ?>
        <div class="text-center py-20">
            <div class="w-24 h-24 bg-gray-50 rounded-3xl flex items-center justify-center mx-auto mb-5">
                <i class="fas fa-concierge-bell text-4xl text-gray-300"></i>
            </div>
            <h3 class="text-xl font-bold text-navy mb-2">No services available</h3>
            <p class="text-gray-400">Services will appear here once added.</p>
        </div>
        <?php else: ?>
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
        <?php endif; ?>
    </div>
</section>

<script>
// Scroll-reveal animation (matches .reveal CSS in style.css)
const revealObserver = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));
</script>
