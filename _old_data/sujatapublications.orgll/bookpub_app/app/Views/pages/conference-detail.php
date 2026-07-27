<?php
$c = $conference;
$includesArr = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $c['registration_includes'] ?? ''))));
?>

<!-- HERO TOP SECTION (matches the image: title + theme & organization + intro paragraph) -->
<section class="bg-white border-2 border-gray-200 rounded-lg max-w-6xl mx-auto my-8 mt-12">
    <div class="px-6 py-8 md:py-10">
        <h1 class="text-center text-2xl md:text-3xl font-bold text-primary mb-4">
            <?= htmlspecialchars($c['title']) ?>
        </h1>

        <?php if (!empty($c['subtitle'])): ?>
        <h2 class="text-center text-secondary font-semibold text-lg mb-4">
            <?= htmlspecialchars($c['subtitle']) ?>
        </h2>
        <?php endif; ?>

        <?php if (!empty($c['theme_organization'])): ?>
        <div class="text-center text-gray-700 leading-relaxed text-sm md:text-base whitespace-pre-line max-w-4xl mx-auto">
<?= htmlspecialchars($c['theme_organization']) ?>
        </div>
        <?php endif; ?>

        <?php if (!empty($c['intro_paragraph'])): ?>
        <hr class="my-6 max-w-md mx-auto border-gray-300">
        <p class="text-center text-gray-700 text-sm md:text-[15px] leading-relaxed max-w-4xl mx-auto">
            <?= htmlspecialchars($c['intro_paragraph']) ?>
        </p>
        <?php endif; ?>
    </div>
</section>

<!-- TWO-COLUMN BODY: poster on left, details on right -->
<section class="max-w-6xl mx-auto px-4 pb-12">
    <div class="grid lg:grid-cols-2 gap-8 items-start border-2 border-gray-200 rounded-lg p-4 md:p-6 bg-white">

        <!-- LEFT: Poster image -->
        <div class="flex justify-center">
            <?php if (!empty($c['poster_image'])): ?>
            <img src="<?= uploadUrl('conferences', $c['poster_image']) ?>"
                 alt="<?= htmlspecialchars($c['title']) ?>"
                 class="w-full max-w-lg rounded-lg shadow-md">
            <?php else: ?>
            <div class="w-full max-w-lg aspect-[3/4] bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                <div class="text-center text-gray-400">
                    <i class="fas fa-image text-5xl mb-3"></i>
                    <p class="font-medium">Poster not uploaded</p>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- RIGHT: Dynamic details -->
        <div class="space-y-5 text-sm md:text-[15px]">

            <?php if (!empty($c['registration_link']) || !empty($c['registration_fee'])): ?>
            <div>
                <?php if (!empty($c['registration_link'])): ?>
                <p class="text-red-600 font-semibold break-all">
                    <a href="<?= htmlspecialchars($c['registration_link']) ?>" target="_blank" rel="noopener" class="hover:underline">
                        <?= htmlspecialchars($c['registration_link']) ?>
                    </a>
                </p>
                <?php endif; ?>
                <?php if (!empty($c['registration_fee'])): ?>
                <p class="text-red-600 font-semibold mt-1"><?= htmlspecialchars($c['registration_fee']) ?></p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($includesArr)): ?>
            <div>
                <h3 class="text-red-600 font-bold mb-2">Registration includes:</h3>
                <ul class="space-y-1 text-gray-800">
                    <?php foreach ($includesArr as $item): ?>
                    <li class="flex items-start gap-2">
                        <span class="text-red-500 mt-0.5">👉</span>
                        <span><?= htmlspecialchars($item) ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <?php if (!empty($c['seats_info'])): ?>
            <div>
                <h3 class="text-red-600 font-bold mb-1">Limited seats:</h3>
                <p class="text-gray-800"><?= nl2br(htmlspecialchars($c['seats_info'])) ?></p>
            </div>
            <?php endif; ?>

            <?php if (!empty($c['conference_brochure'])): ?>
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 rounded-xl p-5">
                <h3 class="text-primary font-bold mb-3 flex items-center gap-2">
                    <i class="fas fa-file-pdf text-red-500"></i> Conference Brochure
                </h3>
                <div class="flex flex-wrap gap-3">
                    <a href="<?= uploadUrl('conferences/pdfs', $c['conference_brochure']) ?>" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-primary-dark transition text-sm shadow-sm">
                        <i class="fas fa-eye"></i> View PDF
                    </a>
                    <a href="<?= uploadUrl('conferences/pdfs', $c['conference_brochure']) ?>" download
                       class="inline-flex items-center gap-2 bg-white text-primary border border-primary px-5 py-2.5 rounded-lg font-semibold hover:bg-blue-50 transition text-sm">
                        <i class="fas fa-download"></i> Download PDF
                    </a>
                </div>
            </div>
            <?php endif; ?>

            <?php if (!empty($c['abstract_email']) || !empty($c['abstract_info'])): ?>
            <div>
                <h3 class="text-red-600 font-bold mb-1">Abstract Submission :</h3>
                <?php if (!empty($c['abstract_info'])): ?>
                <p class="text-gray-800 leading-relaxed">
                    <?= nl2br(htmlspecialchars($c['abstract_info'])) ?>
                    <?php if (!empty($c['abstract_email'])): ?>
                    <a href="mailto:<?= htmlspecialchars($c['abstract_email']) ?>" class="text-primary hover:underline font-medium ml-1">
                        <?= htmlspecialchars($c['abstract_email']) ?>
                    </a>
                    <?php endif; ?>
                </p>
                <?php elseif (!empty($c['abstract_email'])): ?>
                <p class="text-gray-800">
                    Kindly send abstracts through email to:
                    <a href="mailto:<?= htmlspecialchars($c['abstract_email']) ?>" class="text-primary hover:underline font-medium">
                        <?= htmlspecialchars($c['abstract_email']) ?>
                    </a>
                </p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($c['prize_first']) || !empty($c['prize_second']) || !empty($c['prize_third'])): ?>
            <div>
                <p class="text-gray-800 mb-2">Top three presentations will be awarded Cash Prizes, Trophy &amp; Certificate</p>
                <ul class="space-y-1 text-gray-800">
                    <?php if (!empty($c['prize_first'])): ?>
                    <li>🏆 First Prize: <?= htmlspecialchars($c['prize_first']) ?></li>
                    <?php endif; ?>
                    <?php if (!empty($c['prize_second'])): ?>
                    <li>🥈 Second Prize: <?= htmlspecialchars($c['prize_second']) ?></li>
                    <?php endif; ?>
                    <?php if (!empty($c['prize_third'])): ?>
                    <li>🥉 Third Prize: <?= htmlspecialchars($c['prize_third']) ?></li>
                    <?php endif; ?>
                </ul>
            </div>
            <?php endif; ?>

            <?php if (!empty($c['award_categories'])): ?>
            <div>
                <h3 class="text-red-600 font-bold mb-1">AWARD CATEGORIES</h3>
                <p class="text-gray-800 leading-relaxed whitespace-pre-line"><?= htmlspecialchars($c['award_categories']) ?></p>
            </div>
            <?php endif; ?>

            <?php if (!empty($c['contact_phone']) || !empty($c['contact_email'])): ?>
            <div class="pt-3 mt-4 border-t border-gray-100 text-right">
                <p class="text-gray-700">Regards,</p>
                <p class="text-red-600 font-bold">Organizing Committee, International Conference</p>
                <?php if (!empty($c['contact_phone'])): ?>
                <p class="text-gray-700"><?= htmlspecialchars($c['contact_phone']) ?></p>
                <?php endif; ?>
                <?php if (!empty($c['contact_email'])): ?>
                <p class="text-gray-700">
                    <a href="mailto:<?= htmlspecialchars($c['contact_email']) ?>" class="hover:underline">
                        <?= htmlspecialchars($c['contact_email']) ?>
                    </a>
                </p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- View All button -->
            <div class="pt-2">
                <a href="<?= BASE_URL ?>/conferences"
                   class="inline-flex items-center gap-2 bg-red-600 text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-red-700 transition shadow-md">
                    View All <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

        </div>
    </div>
</section>
