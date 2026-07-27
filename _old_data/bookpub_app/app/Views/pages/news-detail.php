<?php
$pageTitle = $article['seo_title'] ?? $article['title'] ?? 'News Article';
?>
<!-- Page Hero -->



<section class="hero-modern hero-mesh relative overflow-hidden">
    <div class="container mx-auto px-4 py-20 relative z-10">
        <div class="max-w-3xl" data-reveal>
            <nav class="flex items-center gap-2 text-sm text-white/60 mb-4">
                <a href="<?= BASE_URL ?>" class="hover:text-white transition-colors">Home</a>
                <i class="fas fa-calendar text-xs"></i>
                <span class="text-white">News</span>
            </nav>
            <span class="pill pill-glass mb-4"><i class="fas fa-images text-gold text-[10px]"></i> Media Gallery</span>
            <h1 class="font-modern text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-4"><?= htmlspecialchars($article['title']) ?></h1>

        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 70" class="w-full h-10 md:h-16" preserveAspectRatio="none"><path fill="#f8fafc" d="M0,35 C360,80 720,0 1080,25 C1260,38 1380,48 1440,44 L1440,70 L0,70 Z"/></svg>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="container mx-auto px-4 max-w-5xl">
        <div class="grid lg:grid-cols-3 gap-12">

            <!-- Article -->
            <article class="lg:col-span-2">
                <?php if($article['featured_image']): ?>
                <img src="<?= uploadUrl('news', $article['featured_image']) ?>"
                     alt="<?= htmlspecialchars($article['title']) ?>"
                     class="w-full rounded-2xl shadow-lg mb-8 object-cover max-h-80">
                <?php endif; ?>

                <div class="prose prose-lg max-w-none text-gray-700
                            [&>p]:mb-4 [&>h2]:font-serif [&>h2]:text-primary [&>h2]:text-2xl [&>h2]:mt-8 [&>h2]:mb-3
                            [&>ul]:mb-4 [&>ul>li]:mb-2 [&>blockquote]:border-l-4 [&>blockquote]:border-secondary
                            [&>blockquote]:pl-4 [&>blockquote]:italic [&>blockquote]:text-gray-600">
                    <?= sanitizeRichHtml($article['content'] ?? '<p>Content coming soon.</p>') ?>
                </div>

                <!-- Share -->
                <div class="mt-10 pt-8 border-t border-gray-100 flex items-center gap-4 flex-wrap">
                    <span class="text-sm font-semibold text-gray-600">Share:</span>
                    <?php
                    $shareUrl   = urlencode(BASE_URL.'/news/'.$article['slug']);
                    $shareTitle = urlencode($article['title']);
                    $socials = [
                        ['fab fa-facebook-f','#1877f2','https://www.facebook.com/sharer/sharer.php?u='.$shareUrl],
                        ['fab fa-x-twitter','#000','https://twitter.com/intent/tweet?url='.$shareUrl.'&text='.$shareTitle],
                        ['fab fa-linkedin-in','#0a66c2','https://www.linkedin.com/sharing/share-offsite/?url='.$shareUrl],
                        ['fab fa-whatsapp','#25d366','https://wa.me/?text='.$shareTitle.'%20'.$shareUrl],
                    ];
                    foreach($socials as [$icon,$color,$url]):
                    ?>
                    <a href="<?= $url ?>" target="_blank" rel="noopener"
                       style="background:<?= $color ?>"
                       class="w-9 h-9 rounded-full flex items-center justify-center text-white text-sm hover:opacity-80 transition">
                        <i class="<?= $icon ?>"></i>
                    </a>
                    <?php endforeach; ?>
                </div>
            </article>

            <!-- Sidebar -->
            <aside>
                <!-- Recent Posts -->
                <?php if(!empty($recentNews)): ?>
                <div class="bg-gray-50 rounded-2xl p-6 mb-6">
                    <h3 class="font-serif text-primary font-bold text-lg mb-4 pb-3 border-b border-gray-200">
                        Recent Articles
                    </h3>
                    <div class="flex flex-col gap-4">
                        <?php foreach($recentNews as $recent):
                            if($recent['id'] === $article['id']) continue; ?>
                        <a href="<?= BASE_URL ?>/news/<?= $recent['slug'] ?>" class="group flex gap-3">
                            <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0">
                                <?php if($recent['featured_image']): ?>
                                <img src="<?= uploadUrl('news', $recent['featured_image']) ?>"
                                     alt="" class="w-full h-full object-cover group-hover:scale-110 transition">
                                <?php else: ?>
                                <div class="w-full h-full bg-primary/10 flex items-center justify-center">
                                    <i class="fas fa-newspaper text-primary/50"></i>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-800 group-hover:text-secondary transition leading-tight mb-1 line-clamp-2">
                                    <?= htmlspecialchars($recent['title']) ?>
                                </h4>
                                <p class="text-xs text-gray-400"><?= formatDate($recent['created_at'] ?? '') ?></p>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Back to News -->
                <a href="<?= BASE_URL ?>/news"
                   class="flex items-center gap-2 text-primary hover:text-secondary font-semibold text-sm transition">
                    <i class="fas fa-arrow-left text-xs"></i> Back to All News
                </a>
            </aside>
        </div>
    </div>
</section>

<?php
