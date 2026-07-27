<?php
$pageTitle = 'News & Updates';
$heroIntro = 'Stay informed with the latest news from the world of academic publishing.';
?>
<!-- Page Hero -->
<?php include __DIR__ . '/../partials/hero.php'; ?>


<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 max-w-5xl">

        <!-- Search -->
        <div class="max-w-xl mx-auto mb-12">
            <form method="GET">
                <div class="search-box">
                    <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Search news articles…">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>

        <?php if(empty($news)): ?>
        <div class="text-center py-20">
            <i class="fas fa-newspaper text-5xl text-gray-300 mb-4 block"></i>
            <h3 class="text-xl font-bold text-gray-400 mb-2">No articles found</h3>
            <?php if(!empty($_GET['search'])): ?>
            <a href="<?= BASE_URL ?>/news" class="text-secondary hover:underline text-sm">Clear search</a>
            <?php endif; ?>
        </div>
        <?php else: ?>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
            <?php foreach($news as $article): ?>
            <article class="card news-card group overflow-hidden reveal">
                <div class="overflow-hidden">
                    <a href="<?= BASE_URL ?>/news/<?= $article['slug'] ?>">
                        <?php if($article['featured_image']): ?>
                        <img src="<?= uploadUrl('news', $article['featured_image']) ?>"
                             alt="<?= htmlspecialchars($article['title']) ?>"
                             loading="lazy"
                             class="news-img group-hover:scale-105 transition-transform duration-500">
                        <?php else: ?>
                        <div class="aspect-video bg-gradient-to-br from-primary/80 to-primary flex items-center justify-center">
                            <i class="fas fa-newspaper text-4xl text-white/30"></i>
                        </div>
                        <?php endif; ?>
                    </a>
                </div>
                <div class="p-5">
                    <p class="news-date mb-2 flex items-center gap-2">
                        <i class="fas fa-calendar text-xs"></i>
                        <?= formatDate($article['created_at'] ?? $article['published_at'] ?? '') ?>
                    </p>
                    <h3 class="font-serif text-primary font-bold text-lg leading-tight mb-3">
                        <a href="<?= BASE_URL ?>/news/<?= $article['slug'] ?>"
                           class="hover:text-secondary transition line-clamp-2">
                            <?= htmlspecialchars($article['title']) ?>
                        </a>
                    </h3>
                    <?php if($article['excerpt'] ?? false): ?>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">
                        <?= htmlspecialchars($article['excerpt']) ?>
                    </p>
                    <?php endif; ?>
                    <a href="<?= BASE_URL ?>/news/<?= $article['slug'] ?>"
                       class="text-secondary hover:text-secondary-dark font-semibold text-sm flex items-center gap-1 transition">
                        Read More <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if(($pagination['total_pages'] ?? 1) > 1):
            $base = BASE_URL.'/news?'.http_build_query(array_filter(['search' => $_GET['search'] ?? ''])).'&page=';
        ?>
        <div class="pagination">
            <?php if($pagination['current_page'] > 1): ?>
            <a href="<?= $base.($pagination['current_page']-1) ?>"><i class="fas fa-chevron-left text-xs"></i></a>
            <?php endif; ?>
            <?php for($p=1; $p<=$pagination['total_pages']; $p++): ?>
            <<?= $p==$pagination['current_page'] ? 'span class="current"' : 'a href="'.$base.$p.'"' ?>>
                <?= $p ?>
            </<?= $p==$pagination['current_page'] ? 'span' : 'a' ?>>
            <?php endfor; ?>
            <?php if($pagination['current_page'] < $pagination['total_pages']): ?>
            <a href="<?= $base.($pagination['current_page']+1) ?>"><i class="fas fa-chevron-right text-xs"></i></a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<script>
const obs = new IntersectionObserver(es=>es.forEach(e=>e.isIntersecting&&e.target.classList.add('visible')),{threshold:.1});
document.querySelectorAll('.reveal').forEach(el=>obs.observe(el));
</script>

<?php
