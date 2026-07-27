<?php
$pageTitle = $pageTitle ?? 'Policy';
$sections  = $sections ?? [];
$parentCrumb = $parentCrumb ?? ['label' => 'Policies', 'url' => BASE_URL . '/policies'];
$heroCrumbs = [['label' => $parentCrumb['label'], 'url' => $parentCrumb['url']]];
$heroIntro = $intro ?? '';
?>
<?php include __DIR__ . '/../partials/hero.php'; ?>

<section class="py-16 bg-white">
    <div class="container mx-auto px-4 max-w-4xl">
        <?php if (!empty($lastUpdated)): ?>
        <p class="text-sm text-gray-400 mb-10">Last updated: <?= htmlspecialchars($lastUpdated) ?></p>
        <?php endif; ?>

        <div class="space-y-10">
            <?php foreach ($sections as $section): ?>
            <div>
                <?php if (!empty($section['title'])): ?>
                <h2 class="font-serif text-2xl font-bold text-primary mb-4"><?= htmlspecialchars($section['title']) ?></h2>
                <?php endif; ?>

                <?php foreach (($section['paragraphs'] ?? []) as $paragraph): ?>
                <p class="text-gray-700 leading-relaxed mb-4"><?= $paragraph ?></p>
                <?php endforeach; ?>

                <?php if (!empty($section['list'])): ?>
                <ul class="list-disc pl-6 space-y-2 text-gray-700 mb-4">
                    <?php foreach ($section['list'] as $item): ?>
                    <li><?= $item ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>

        <?php
        $siteEmail = htmlspecialchars(getSetting('site_email', 'info@example.com'));
        $sitePhone = htmlspecialchars(getSetting('site_phone', ''));
        ?>
        <div class="mt-12 p-6 bg-gray-50 rounded-2xl border border-gray-100">
            <h3 class="font-serif text-lg font-bold text-primary mb-2">Questions about this policy?</h3>
            <p class="text-gray-600 text-sm mb-3">Contact our team for clarification or support.</p>
            <div class="flex flex-wrap gap-4 text-sm">
                <a href="mailto:<?= $siteEmail ?>" class="text-primary hover:text-primary-dark font-medium inline-flex items-center gap-2">
                    <i class="fas fa-envelope"></i> <?= $siteEmail ?>
                </a>
                <?php if ($sitePhone): ?>
                <a href="tel:<?= $sitePhone ?>" class="text-primary hover:text-primary-dark font-medium inline-flex items-center gap-2">
                    <i class="fas fa-phone"></i> <?= $sitePhone ?>
                </a>
                <?php endif; ?>
                <a href="<?= BASE_URL ?>/contact" class="text-primary hover:text-primary-dark font-medium inline-flex items-center gap-2">
                    <i class="fas fa-comment-dots"></i> Contact Form
                </a>
            </div>
        </div>
    </div>
</section>
