<?php
$pageTitle = $service['meta_title'] ?? $service['title'] ?? 'Service Detail';
$heroCrumbs = [['label' => 'Services', 'url' => BASE_URL . '/services']];
?>
<?php include __DIR__ . '/../partials/hero.php'; ?>

<section class="py-16 bg-white">
    <div class="container mx-auto px-4 max-w-5xl">
        <div class="grid lg:grid-cols-3 gap-12">
            <!-- Content -->
            <div class="lg:col-span-2">
                <?php if($service['image']): ?>
                <img src="<?= uploadUrl('services', $service['image']) ?>"
                     alt="<?= htmlspecialchars($service['title']) ?>"
                     class="w-full rounded-2xl shadow-lg mb-8 object-cover max-h-72">
                <?php endif; ?>

                <?php
                // Parse content sections (stored as JSON in 'content' column)
                $sections = [];
                if (!empty($service['content'])) {
                    $decoded = json_decode($service['content'], true);
                    if (is_array($decoded)) $sections = $decoded;
                }
                ?>
                <?php if (!empty($service['short_description'])): ?>
                <div class="text-lg text-gray-700 leading-relaxed mb-8"><?= renderServiceSectionContent($service['short_description']) ?></div>
                <?php endif; ?>

                <?php if (!empty($sections)): ?>
                <div class="space-y-8">
                    <?php foreach ($sections as $sec):
                        if (empty($sec['heading']) && empty($sec['description'])) continue; ?>
                    <div>
                        <?php if (!empty($sec['heading'])): ?>
                        <h2 class="font-serif text-2xl font-bold text-primary mb-3"><?= sanitizeServiceHtml($sec['heading']) ?></h2>
                        <?php endif; ?>
                        <?php if (!empty($sec['description'])): ?>
                        <div class="service-section-content"><?= renderServiceSectionContent($sec['description']) ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php elseif (empty($service['short_description'])): ?>
                <p class="text-gray-500 italic">Content coming soon.</p>
                <?php endif; ?>

                <?php if($service['cta_url']): ?>
                <div class="mt-8 p-6 bg-gray-50 rounded-2xl flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h4 class="font-serif text-primary font-bold text-lg">Ready to get started?</h4>
                        <p class="text-gray-500 text-sm">Contact us to learn more about this service.</p>
                    </div>
                    <a href="<?= htmlspecialchars($service['cta_url']) ?>" class="btn-primary">
                        <?= htmlspecialchars($service['cta_text'] ?? 'Get Started') ?>
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <aside>
                <!-- Other Services -->
                <?php if(!empty($others)): ?>
                <div class="bg-gray-50 rounded-2xl p-6 mb-6">
                    <h3 class="font-serif text-primary font-bold mb-4">Other Services</h3>
                    <div class="flex flex-col gap-2">
                        <?php foreach($others as $s): ?>
                        <a href="<?= BASE_URL ?>/service/<?= $s['slug'] ?>"
                           class="flex items-center gap-3 p-3 rounded-xl hover:bg-white transition group">
                            <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0">
                                <i class="<?= htmlspecialchars($s['icon'] ?? 'fas fa-star') ?> text-primary text-sm"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-primary transition">
                                <?= htmlspecialchars($s['title']) ?>
                            </span>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Contact -->
                <div class="bg-primary rounded-2xl p-6 text-white">
                    <h3 class="font-serif font-bold text-lg mb-2">Need Help?</h3>
                    <p class="text-white/80 text-sm mb-4">Our team is here to assist you with all your publication needs.</p>
                    <?php $email = getSetting('site_email','info@example.com'); ?>
                    <a href="mailto:<?= $email ?>" class="flex items-center gap-2 text-white/90 hover:text-white text-sm mb-2 transition">
                        <i class="fas fa-envelope"></i> <?= $email ?>
                    </a>
                    <?php $phone = getSetting('site_phone',''); if($phone): ?>
                    <a href="tel:<?= $phone ?>" class="flex items-center gap-2 text-white/90 hover:text-white text-sm transition">
                        <i class="fas fa-phone"></i> <?= $phone ?>
                    </a>
                    <?php endif; ?>
                </div>
            </aside>
        </div>
    </div>
</section>

<?php
