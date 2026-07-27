<?php
$c = $conference;
$includesArr = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $c['registration_includes'] ?? ''))));
?>

<!-- HERO -->
<section class="relative overflow-hidden" style="background: linear-gradient(135deg, var(--brand-primary-dk), var(--brand-primary));">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-20 -right-20 w-[500px] h-[500px] rounded-full" style="background: var(--brand-secondary); filter: blur(160px);"></div>
    </div>
    <div class="container mx-auto px-4 py-16 md:py-24 relative z-10">
        <nav class="flex items-center gap-2 text-sm mb-6" style="color: rgba(255,255,255,0.6);">
            <a href="<?= BASE_URL ?>" class="hover:text-white transition-colors">Home</a>
            <i class="fas fa-angle-right text-xs"></i>
            <a href="<?= BASE_URL ?>/conferences" class="hover:text-white transition-colors">Conferences</a>
            <i class="fas fa-angle-right text-xs"></i>
            <span class="text-white font-semibold">Details</span>
        </nav>
        <div class="max-w-4xl mx-auto text-center" data-reveal>
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-5"
                  style="background: rgba(var(--rgb-primary), 0.25); color: var(--brand-primary-lt); border: 1px solid rgba(var(--rgb-primary), 0.4);">
                <i class="fas fa-calendar-alt text-[10px]"></i> Conference
            </span>
            <h1 class="font-modern text-3xl md:text-5xl font-extrabold text-white tracking-tight mb-4 leading-tight">
                <?= htmlspecialchars($c['title']) ?>
            </h1>
            <?php if (!empty($c['subtitle'])): ?>
            <h2 class="text-lg md:text-xl font-semibold mb-4" style="color: var(--brand-primary-lt);"><?= htmlspecialchars($c['subtitle']) ?></h2>
            <?php endif; ?>
            <?php if (!empty($c['conference_date'])): ?>
            <div class="inline-flex items-center gap-2 px-5 py-2 rounded-full text-sm font-semibold" style="background: rgba(255,255,255,0.1); color: #fff; border: 1px solid rgba(255,255,255,0.15);">
                <i class="fas fa-calendar text-xs" style="color: var(--brand-secondary-lt);"></i>
                <?= formatDate($c['conference_date'], 'F d, Y') ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 80" class="w-full h-12 md:h-20" preserveAspectRatio="none">
            <path fill="var(--color-bg)" d="M0,40 C480,100 960,0 1440,50 L1440,80 L0,80 Z"/>
        </svg>
    </div>
</section>

<!-- MAIN CONTENT -->
<section class="py-12 md:py-20" style="background: var(--color-bg);">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto grid lg:grid-cols-5 gap-8 lg:gap-10">

            <!-- LEFT: Poster + Info (3 cols) -->
            <div class="lg:col-span-3 space-y-8">
                <!-- Poster -->
                <div class="rounded-2xl overflow-hidden shadow-xl" style="border: 1px solid var(--color-border);">
                    <?php if (!empty($c['poster_image'])): ?>
                    <img src="<?= uploadUrl('conferences', $c['poster_image']) ?>"
                         alt="<?= htmlspecialchars($c['title']) ?>"
                         class="w-full object-cover" >
                    <?php else: ?>
                    <div class="w-full flex items-center justify-center" style="aspect-ratio: 3/4; background: linear-gradient(135deg, var(--color-bg-alt), var(--color-border));">
                        <div class="text-center">
                            <i class="fas fa-image text-6xl mb-3" style="color: var(--color-muted); opacity: 0.3;"></i>
                            <p class="font-semibold" style="color: var(--color-muted);">Poster not uploaded</p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Theme / Organization -->
                <?php if (!empty($c['theme_organization'])): ?>
                <div class="rounded-2xl p-6 md:p-8" style="background: var(--color-bg-white); border: 1px solid var(--color-border);">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(var(--rgb-primary), 0.08);">
                            <i class="fas fa-bullhorn text-sm" style="color: var(--brand-primary);"></i>
                        </div>
                        <h3 class="font-modern font-extrabold text-lg" style="color: var(--color-heading);">Theme &amp; Organization</h3>
                    </div>
                    <p class="text-sm md:text-base leading-relaxed whitespace-pre-line" style="color: var(--color-muted);"><?= htmlspecialchars($c['theme_organization']) ?></p>
                </div>
                <?php endif; ?>

                <!-- Intro Paragraph -->
                <?php if (!empty($c['intro_paragraph'])): ?>
                <div class="rounded-2xl p-6 md:p-8" style="background: var(--color-bg-white); border: 1px solid var(--color-border);">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(var(--rgb-primary), 0.08);">
                            <i class="fas fa-info-circle text-sm" style="color: var(--brand-primary);"></i>
                        </div>
                        <h3 class="font-modern font-extrabold text-lg" style="color: var(--color-heading);">About the Conference</h3>
                    </div>
                    <p class="text-sm md:text-base leading-relaxed" style="color: var(--color-muted);"><?= nl2br(htmlspecialchars($c['intro_paragraph'])) ?></p>
                </div>
                <?php endif; ?>
            </div>

            <!-- RIGHT: Details sidebar (2 cols) -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Registration Card -->
                <?php if (!empty($c['registration_link']) || !empty($c['registration_fee'])): ?>
                <div class="rounded-2xl p-6" style="background: var(--color-bg-white); border: 1px solid var(--color-border); box-shadow: var(--shadow-sm);">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(var(--rgb-success), 0.1);">
                            <i class="fas fa-ticket-alt text-sm" style="color: var(--color-success);"></i>
                        </div>
                        <h3 class="font-modern font-extrabold text-lg" style="color: var(--color-heading);">Registration</h3>
                    </div>
                    <div class="space-y-3">
                        <?php if (!empty($c['registration_link'])): ?>
                        <a href="<?= htmlspecialchars($c['registration_link']) ?>" target="_blank" rel="noopener"
                           class="flex items-center gap-2 text-sm font-semibold break-all" style="color: var(--brand-primary);">
                            <i class="fas fa-external-link-alt text-xs"></i>
                            <?= htmlspecialchars($c['registration_link']) ?>
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($c['registration_fee'])): ?>
                        <div class="flex items-center gap-2 text-sm font-bold" style="color: var(--color-heading);">
                            <i class="fas fa-rupee-sign text-xs" style="color: var(--brand-secondary);"></i>
                            <?= htmlspecialchars($c['registration_fee']) ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Brochure -->
                <?php if (!empty($c['conference_brochure'])): ?>
                <div class="rounded-2xl p-6" style="background: var(--color-bg-white); border: 1px solid var(--color-border); box-shadow: var(--shadow-sm);">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(var(--rgb-danger), 0.1);">
                            <i class="fas fa-file-pdf text-sm" style="color: var(--color-danger);"></i>
                        </div>
                        <h3 class="font-modern font-extrabold text-lg" style="color: var(--color-heading);">Brochure</h3>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="<?= uploadUrl('conferences/pdfs', $c['conference_brochure']) ?>" target="_blank" rel="noopener"
                           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-white text-sm font-bold shadow-md transition-all hover:shadow-lg"
                           style="background: var(--brand-primary);">
                            <i class="fas fa-eye text-xs"></i> View PDF
                        </a>
                        <a href="<?= uploadUrl('conferences/pdfs', $c['conference_brochure']) ?>" download
                           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold border-2 transition-all hover:bg-gray-50"
                           style="border-color: var(--color-border); color: var(--color-heading);">
                            <i class="fas fa-download text-xs"></i> Download
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Registration Includes -->
                <?php if (!empty($includesArr)): ?>
                <div class="rounded-2xl p-6" style="background: var(--color-bg-white); border: 1px solid var(--color-border); box-shadow: var(--shadow-sm);">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(var(--rgb-primary), 0.08);">
                            <i class="fas fa-list-check text-sm" style="color: var(--brand-primary);"></i>
                        </div>
                        <h3 class="font-modern font-extrabold text-lg" style="color: var(--color-heading);">Registration Includes</h3>
                    </div>
                    <ul class="space-y-2.5">
                        <?php foreach ($includesArr as $item): ?>
                        <li class="flex items-start gap-3 text-sm" style="color: var(--color-muted);">
                            <span class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5" style="background: rgba(var(--rgb-success), 0.12);">
                                <i class="fas fa-check text-[9px]" style="color: var(--color-success);"></i>
                            </span>
                            <span><?= htmlspecialchars($item) ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <!-- Seats Info -->
                <?php if (!empty($c['seats_info'])): ?>
                <div class="rounded-2xl p-5 flex items-start gap-3" style="background: rgba(var(--rgb-warning), 0.06); border: 1px solid rgba(var(--rgb-warning), 0.15);">
                    <i class="fas fa-chair mt-0.5" style="color: var(--color-warning);"></i>
                    <div>
                        <h4 class="text-sm font-bold" style="color: var(--color-heading);">Limited Seats Available</h4>
                        <p class="text-sm mt-0.5" style="color: var(--color-muted);"><?= nl2br(htmlspecialchars($c['seats_info'])) ?></p>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Abstract Submission -->
                <?php if (!empty($c['abstract_email']) || !empty($c['abstract_info'])): ?>
                <div class="rounded-2xl p-6" style="background: var(--color-bg-white); border: 1px solid var(--color-border); box-shadow: var(--shadow-sm);">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(var(--rgb-primary), 0.08);">
                            <i class="fas fa-file-alt text-sm" style="color: var(--brand-primary);"></i>
                        </div>
                        <h3 class="font-modern font-extrabold text-lg" style="color: var(--color-heading);">Abstract Submission</h3>
                    </div>
                    <div class="text-sm leading-relaxed" style="color: var(--color-muted);">
                        <?php if (!empty($c['abstract_info'])): ?>
                        <p><?= nl2br(htmlspecialchars($c['abstract_info'])) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($c['abstract_email'])): ?>
                        <a href="mailto:<?= htmlspecialchars($c['abstract_email']) ?>" class="inline-flex items-center gap-2 mt-3 font-semibold" style="color: var(--brand-primary);">
                            <i class="fas fa-envelope text-xs"></i> <?= htmlspecialchars($c['abstract_email']) ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Prizes -->
                <?php if (!empty($c['prize_first']) || !empty($c['prize_second']) || !empty($c['prize_third'])): ?>
                <div class="rounded-2xl p-6" style="background: linear-gradient(135deg, rgba(var(--rgb-warning), 0.05), rgba(var(--rgb-primary), 0.05)); border: 1px solid rgba(var(--rgb-warning), 0.15);">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(var(--rgb-warning), 0.12);">
                            <i class="fas fa-trophy text-sm" style="color: var(--color-warning);"></i>
                        </div>
                        <h3 class="font-modern font-extrabold text-lg" style="color: var(--color-heading);">Awards &amp; Prizes</h3>
                    </div>
                    <p class="text-sm mb-3" style="color: var(--color-muted);">Top three presentations will be awarded Cash Prizes, Trophy &amp; Certificate</p>
                    <ul class="space-y-2">
                        <?php if (!empty($c['prize_first'])): ?>
                        <li class="flex items-center gap-3 text-sm font-semibold" style="color: var(--color-heading);">
                            <span class="text-lg">🏆</span> First Prize: <?= htmlspecialchars($c['prize_first']) ?>
                        </li>
                        <?php endif; ?>
                        <?php if (!empty($c['prize_second'])): ?>
                        <li class="flex items-center gap-3 text-sm font-semibold" style="color: var(--color-heading);">
                            <span class="text-lg">🥈</span> Second Prize: <?= htmlspecialchars($c['prize_second']) ?>
                        </li>
                        <?php endif; ?>
                        <?php if (!empty($c['prize_third'])): ?>
                        <li class="flex items-center gap-3 text-sm font-semibold" style="color: var(--color-heading);">
                            <span class="text-lg">🥉</span> Third Prize: <?= htmlspecialchars($c['prize_third']) ?>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <!-- Award Categories -->
                <?php if (!empty($c['award_categories'])): ?>
                <div class="rounded-2xl p-6" style="background: var(--color-bg-white); border: 1px solid var(--color-border); box-shadow: var(--shadow-sm);">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(var(--rgb-secondary), 0.08);">
                            <i class="fas fa-medal text-sm" style="color: var(--brand-secondary);"></i>
                        </div>
                        <h3 class="font-modern font-extrabold text-lg" style="color: var(--color-heading);">Award Categories</h3>
                    </div>
                    <p class="text-sm leading-relaxed whitespace-pre-line" style="color: var(--color-muted);"><?= htmlspecialchars($c['award_categories']) ?></p>
                </div>
                <?php endif; ?>

                <!-- Contact -->
                <?php if (!empty($c['contact_phone']) || !empty($c['contact_email'])): ?>
                <div class="rounded-2xl p-6" style="background: var(--color-bg-white); border: 1px solid var(--color-border); box-shadow: var(--shadow-sm);">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(var(--rgb-primary), 0.08);">
                            <i class="fas fa-phone text-sm" style="color: var(--brand-primary);"></i>
                        </div>
                        <h3 class="font-modern font-extrabold text-lg" style="color: var(--color-heading);">Contact Organizers</h3>
                    </div>
                    <div class="space-y-2 text-sm">
                        <p style="color: var(--color-muted);">Regards,</p>
                        <p class="font-bold" style="color: var(--brand-secondary);">Organizing Committee, International Conference</p>
                        <?php if (!empty($c['contact_phone'])): ?>
                        <p class="flex items-center gap-2" style="color: var(--color-muted);">
                            <i class="fas fa-phone text-xs" style="color: var(--brand-primary);"></i>
                            <?= htmlspecialchars($c['contact_phone']) ?>
                        </p>
                        <?php endif; ?>
                        <?php if (!empty($c['contact_email'])): ?>
                        <p class="flex items-center gap-2">
                            <i class="fas fa-envelope text-xs" style="color: var(--brand-primary);"></i>
                            <a href="mailto:<?= htmlspecialchars($c['contact_email']) ?>" class="font-semibold" style="color: var(--brand-primary);"><?= htmlspecialchars($c['contact_email']) ?></a>
                        </p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Back Button -->
                <div>
                    <a href="<?= BASE_URL ?>/conferences"
                       class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-white text-sm font-bold shadow-md transition-all hover:shadow-lg"
                       style="background: var(--brand-primary);">
                        <i class="fas fa-arrow-left text-xs"></i> All Conferences
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>
