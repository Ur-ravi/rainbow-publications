<?php
$pageTitle = ($book['meta_title'] ?? $book['title'] ?? 'Book Detail');
// Controller passes $related; keep backward-compat with $relatedBooks
$related = $related ?? ($relatedBooks ?? []);
?>
<!-- HERO -->
<section class="page-hero">

    <div class="hero-mesh"></div>

    <div class="hero-orbs">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <div class="container mx-auto px-4 py-16 relative z-10">
        <div class="max-w-3xl" data-reveal>

            <nav class="flex items-center gap-2 text-sm mb-5 flex-wrap">
                <a href="<?= BASE_URL ?>" class="breadcrumb-link">
                    Home
                </a>

                <i class="fas fa-angle-right text-xs breadcrumb-sep"></i>

                <a href="<?= BASE_URL ?>/books" class="breadcrumb-link">
                    Books
                </a>

                <i class="fas fa-angle-right text-xs breadcrumb-sep"></i>

                <span class="breadcrumb-current">
                    <?= Security::e(truncate($book['title'], 40)) ?>
                </span>
            </nav>


        </div>
    </div>


    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 60" class="w-full h-8 md:h-12" preserveAspectRatio="none">
            <path fill="var(--slate-50)" d="M0,30 C360,70 720,0 1080,22 C1260,33 1380,42 1440,38 L1440,60 L0,60 Z"/>
        </svg>
    </div>

</section>


<!-- DETAIL -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="grid lg:grid-cols-3 gap-12">

            <!-- Cover + actions -->
            <div class="lg:col-span-1">
                <div class="sticky top-28" data-reveal data-reveal="left">
                    <div class="book-3d mb-6">
                        <div class="book-3d-inner rounded-2xl overflow-hidden shadow-2xl shadow-navy/20">
                            <?php if ($book['cover_image']): ?>
                            <img src="<?= uploadUrl('books', $book['cover_image']) ?>"
                                 alt="<?= Security::e($book['title']) ?>" class="w-full">
                            <?php else: ?>
                            <div class="aspect-[3/4] bg-gradient-to-br from-navy to-indigo flex items-center justify-center">
                                <i class="fas fa-book text-7xl text-white/30"></i>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <?php if ($book['pdf_file']): ?>
                        <a href="<?= uploadUrl('books', $book['pdf_file']) ?>" target="_blank" class="btn-modern btn-modern-primary justify-center">
                            <i class="fas fa-file-pdf"></i> Download PDF
                        </a>
                        <?php endif; ?>
                        <a href="<?= BASE_URL ?>/contact" class="btn-modern btn-modern-emerald justify-center">
                            <i class="fas fa-envelope"></i> Enquire Now
                        </a>
                    </div>

                    <!-- Share -->
                    <div class="mt-6 p-5 rounded-2xl bg-slate-50 border border-slate-100">
                        <p class="text-sm font-bold text-navy mb-3">Share This Book</p>
                        <div class="flex gap-2">
                            <?php
                            $shareUrl   = urlencode(BASE_URL.'/book/'.$book['slug']);
                            $shareTitle = urlencode($book['title']);
                            $socials = [
                                ['fab fa-facebook-f','#1877f2','https://www.facebook.com/sharer/sharer.php?u='.$shareUrl],
                                ['fab fa-x-twitter','#0f172a','https://twitter.com/intent/tweet?url='.$shareUrl.'&text='.$shareTitle],
                                ['fab fa-linkedin-in','#0a66c2','https://www.linkedin.com/sharing/share-offsite/?url='.$shareUrl],
                                ['fab fa-whatsapp','#25d366','https://wa.me/?text='.$shareTitle.'%20'.$shareUrl],
                            ];
                            foreach ($socials as [$icon,$color,$url]):
                            ?>
                            <a href="<?= $url ?>" target="_blank" rel="noopener" style="background:<?= $color ?>"
                               class="w-10 h-10 rounded-xl flex items-center justify-center text-white text-sm hover:-translate-y-1 transition-transform">
                                <i class="<?= $icon ?>"></i>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info -->
            <div class="lg:col-span-2" data-reveal data-reveal="right">
                <?php if ($book['category']): ?>
                <span class="pill pill-indigo mb-4"><?= Security::e($book['category']) ?></span>
                <?php endif; ?>

                <h1 class="font-modern text-3xl md:text-[40px] font-extrabold text-navy mb-6 leading-tight tracking-tight">
                    <?= Security::e($book['title']) ?>
                </h1>

                <!-- Meta cards -->
                <div class="grid sm:grid-cols-2 gap-3 mb-8">
                    <?php
                    $metas = [
                        ['fas fa-user-pen','Authors', $book['authors'] ?? null],
                        ['fas fa-barcode','ISBN', $book['isbn'] ?? null],
                        ['fas fa-calendar-alt','Published', !empty($book['publication_date']) ? formatDate($book['publication_date']) : null],
                        ['fas fa-building','Publisher', $book['publisher'] ?? null],
                        ['fas fa-layer-group','Pages', !empty($book['pages_count']) ? $book['pages_count'].' pages' : null],
                        ['fas fa-language','Language', $book['language'] ?? null],
                    ];
                    foreach ($metas as [$icon,$label,$value]):
                        if (!$value) continue;
                    ?>
                    <div class="meta-chip">
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-indigo to-indigo-light flex items-center justify-center text-white flex-shrink-0">
                            <i class="<?= $icon ?> text-sm"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider"><?= $label ?></p>
                            <p class="text-navy font-semibold text-sm"><?= Security::e((string)$value) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <?php if (!empty($book['price']) && (float)$book['price'] > 0): ?>
                <div class="flex items-baseline gap-2 mb-8">
                    <span class="font-modern text-4xl font-extrabold text-navy">₹<?= number_format((float)$book['price']) ?></span>
                    <span class="text-slate-400 text-sm">per copy</span>
                </div>
                <?php endif; ?>

                <!-- Description -->
                <?php if ($book['description']): ?>
                <div class="mb-8">
                    <h2 class="font-modern text-2xl font-extrabold text-navy mb-4">About This Book</h2>
                    <div class="divider-gradient mb-5"></div>
                    <div class="text-slate-600 leading-relaxed text-[1.05rem] [&>p]:mb-4">
                        <?= sanitizeRichHtml($book['description'] ?? '') ?>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ($book['is_featured']): ?>
                <div class="flex items-center gap-3 p-4 rounded-2xl bg-amber-50 border border-amber-200">
                    <i class="fas fa-award text-gold text-lg"></i>
                    <span class="text-amber-700 font-bold text-sm">Featured Publication</span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Related -->
        <?php if (!empty($related)): ?>
        <div class="mt-20 pt-12 border-t border-slate-100">
            <div class="mb-8" data-reveal>
                <span class="eyebrow mb-2">You may also like</span>
                <h2 class="font-modern text-2xl md:text-3xl font-extrabold text-navy mt-2">Related Books</h2>
            </div>
            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach ($related as $i => $rel): ?>
                <a href="<?= BASE_URL ?>/book/<?= Security::e($rel['slug']) ?>" class="card-modern group block" data-reveal data-reveal-delay="<?= ($i%4)+1 ?>">
                    <div class="overflow-hidden book-3d bg-slate-100" style="aspect-ratio:3/4">
                        <div class="book-3d-inner w-full h-full">
                        <?php if ($rel['cover_image']): ?>
                        <img data-src="<?= uploadUrl('books', $rel['cover_image']) ?>"
                             src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                             alt="<?= Security::e($rel['title']) ?>" class="w-full h-full object-cover">
                        <?php else: ?>
                        <div class="w-full h-full bg-gradient-to-br from-navy to-indigo flex items-center justify-center">
                            <i class="fas fa-book text-3xl text-white/40"></i>
                        </div>
                        <?php endif; ?>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="font-modern text-navy text-sm font-bold leading-tight line-clamp-2 group-hover:text-indigo transition-colors">
                            <?= Security::e($rel['title']) ?>
                        </h4>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>
