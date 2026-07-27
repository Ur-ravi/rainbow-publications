<?php
$pageTitle = 'Policies';
$policies = [
    [
        'title'       => 'Privacy Policy',
        'description' => 'How we collect, use, and protect your personal information when you use our website and services.',
        'url'         => BASE_URL . '/policies/privacy-policy',
        'icon'        => 'fas fa-user-shield',
    ],
    [
        'title'       => 'Cancellation and Refund Policy',
        'description' => 'Terms for cancellations, refunds, and adjustments on publications, memberships, and paid services.',
        'url'         => BASE_URL . '/policies/cancellation-refund',
        'icon'        => 'fas fa-undo-alt',
    ],
    [
        'title'       => 'Shipping and Delivery',
        'description' => 'Information on delivery timelines for books, certificates, and digital publication materials.',
        'url'         => BASE_URL . '/policies/shipping-delivery',
        'icon'        => 'fas fa-truck',
    ],
];
?>
<section class="page-hero text-white">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl animate-fade-up">
            <div class="breadcrumb mb-3">
                <a href="<?= BASE_URL ?>">Home</a>
                <span class="sep">/</span>
                <span><?= htmlspecialchars($pageTitle) ?></span>
            </div>
            <h1 class="heading-xl font-serif mb-3"><?= htmlspecialchars($pageTitle) ?></h1>
            <p class="text-white/80 text-lg">Review our policies governing privacy, refunds, and delivery of academic publishing services.</p>
        </div>
    </div>
</section>


<section class="hero-modern hero-mesh relative overflow-hidden">
    <div class="container mx-auto px-4 py-20 relative z-10">
        <div class="max-w-3xl" data-reveal>
            <nav class="flex items-center gap-2 text-sm text-white/60 mb-4">
                <a href="<?= BASE_URL ?>" class="hover:text-white transition-colors">Home</a>
                <i class="fas fa-angle-right text-xs"></i>
                <span class="text-white"><?= htmlspecialchars($pageTitle) ?></span>
            </nav>
            
            <h1 class="font-modern text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-4"><?= htmlspecialchars($pageTitle) ?></h1>
            <p class="text-slate-300 text-lg max-w-xl">Review our policies governing privacy, refunds, and delivery of academic publishing services.</p>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 70" class="w-full h-10 md:h-16" preserveAspectRatio="none"><path fill="#f8fafc" d="M0,35 C360,80 720,0 1080,25 C1260,38 1380,48 1440,44 L1440,70 L0,70 Z"/></svg>
    </div>
</section>


<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 max-w-5xl">
        <div class="grid md:grid-cols-3 gap-6">
            <?php foreach ($policies as $policy): ?>
            <a href="<?= $policy['url'] ?>"
               class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 hover:shadow-md hover:border-primary/20 transition duration-200 group">
                <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center mb-5 group-hover:bg-primary group-hover:text-white transition duration-200">
                    <i class="<?= $policy['icon'] ?> text-lg"></i>
                </div>
                <h2 class="font-serif text-xl font-bold text-primary mb-3 group-hover:text-primary-dark"><?= htmlspecialchars($policy['title']) ?></h2>
                <p class="text-gray-600 text-sm leading-relaxed mb-4"><?= htmlspecialchars($policy['description']) ?></p>
                <span class="text-primary text-sm font-semibold inline-flex items-center gap-1">
                    Read policy <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                </span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
