<?php $pageTitle = $seo['page_title'] ?? 'Our Services | ' . APP_NAME; ?>




<section class="hero-modern hero-mesh relative overflow-hidden">
    <div class="container mx-auto px-4 py-20 relative z-10">
        <div class="max-w-3xl" data-reveal>
            <nav class="flex items-center gap-2 text-sm text-white/60 mb-4">
                <a href="<?= BASE_URL ?>" class="hover:text-white transition-colors">Home</a>
                <i class="fas fa-angle-right text-xs"></i>
                <span class="text-white">Services</span>
            </nav>
            
            <h1 class="font-modern text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Our Services</h1>
            <p class="text-slate-300 text-lg max-w-xl">End-to-end academic publishing solutions tailored for researchers, authors, and institutions.</p>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 70" class="w-full h-10 md:h-16" preserveAspectRatio="none"><path fill="#f8fafc" d="M0,35 C360,80 720,0 1080,25 C1260,38 1380,48 1440,44 L1440,70 L0,70 Z"/></svg>
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
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($services as $i => $service): ?>
            <a href="<?= BASE_URL ?>/service/<?= Security::e($service['slug']) ?>"
               class="card p-7 group block reveal" data-reveal-delay="<?= ($i % 3) + 1 ?>">
                <?php if (!empty($service['icon'])): ?>
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary to-primary-light flex items-center justify-center mb-5 shadow-lg shadow-primary/20 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500">
                    <i class="<?= Security::e($service['icon']) ?> text-white text-2xl"></i>
                </div>
                <?php else: ?>
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary to-primary-light flex items-center justify-center mb-5 shadow-lg shadow-primary/20 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500">
                    <i class="fas fa-book text-white text-2xl"></i>
                </div>
                <?php endif; ?>
                <h3 class="font-serif font-bold text-navy text-xl mb-3 group-hover:text-primary transition-colors">
                    <?= Security::e($service['title']) ?>
                </h3>
                <?php if (!empty($service['short_description'])): ?>
                <p class="text-gray-600 text-sm leading-relaxed mb-5">
                    <?= Security::e($service['short_description']) ?>
                </p>
                <?php endif; ?>
                <span class="inline-flex items-center gap-1.5 text-primary text-sm font-bold group-hover:gap-2.5 transition-all">
                    <?= Security::e($service['cta_text'] ?? 'Learn more') ?>
                    <i class="fas fa-arrow-right text-xs"></i>
                </span>
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
