<?php
$pageTitle  = 'All Books';
$search     = $search ?? '';
$pag        = $pag ?? ['total'=>($total ?? 0), 'total_pages'=>1, 'current_page'=>1];
$totalBooks = $total ?? ($pag['total'] ?? 0);
?>
<!-- HERO -->
<section class="hero-modern hero-mesh relative overflow-hidden">
    <div class="container mx-auto px-4 py-20 relative z-10">
        <div class="max-w-3xl" data-reveal>
            <nav class="flex items-center gap-2 text-sm text-white/60 mb-4">
                <a href="<?= BASE_URL ?>" class="hover:text-white transition-colors">Home</a>
                <i class="fas fa-angle-right text-xs"></i>
                <span class="text-white">Books</span>
            </nav>
            <span class="pill pill-glass mb-4"><i class="fas fa-book text-gold text-[10px]"></i> Academic Catalog</span>
            <h1 class="font-modern text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Our Publications</h1>
            <p class="text-slate-300 text-lg max-w-xl">Explore our comprehensive collection of academic and research publications.</p>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 70" class="w-full h-10 md:h-16" preserveAspectRatio="none"><path fill="#f8fafc" d="M0,35 C360,80 720,0 1080,25 C1260,38 1380,48 1440,44 L1440,70 L0,70 Z"/></svg>
    </div>
</section>

<!-- CONTENT -->
<section class="py-16 bg-slate-50">
    <div class="container mx-auto px-4">

        <!-- Search + results bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10" data-reveal>
            <p class="text-slate-500 text-sm">
                Showing <strong class="text-navy"><?= (int)$totalBooks ?></strong> result<?= $totalBooks == 1 ? '' : 's' ?>
                <?= $search ? 'for "<strong class="text-navy">'.htmlspecialchars($search).'</strong>"' : '' ?>
            </p>
            <form method="GET" action="<?= BASE_URL ?>/books" class="w-full md:w-auto md:min-w-[360px]">
                <div class="relative">
                    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>"
                        placeholder="Search by title, ISBN, author…"
                        class="w-full pl-5 pr-12 py-3 rounded-xl border border-slate-200 bg-white text-sm focus:outline-none focus:border-indigo focus:ring-2 focus:ring-indigo/20 transition">
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 w-9 h-9 rounded-lg bg-indigo text-white flex items-center justify-center hover:bg-indigo-light transition-colors">
                        <i class="fas fa-search text-sm"></i>
                    </button>
                </div>
            </form>
        </div>

        <?php if (empty($books)): ?>
        <div class="text-center py-24" data-reveal>
            <div class="w-24 h-24 bg-white rounded-3xl shadow-card flex items-center justify-center mx-auto mb-5">
                <i class="fas fa-book-open text-4xl text-slate-300"></i>
            </div>
            <h3 class="text-xl font-bold text-navy mb-2">No books found</h3>
            <p class="text-slate-400 mb-6">Try adjusting your search criteria.</p>
            <a href="<?= BASE_URL ?>/books" class="btn-modern btn-modern-primary">View All Books</a>
        </div>
        <?php else: ?>

        <!-- Grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-7 mb-12">
            <?php foreach ($books as $i => $book): ?>
            <article class="card-modern group" data-reveal data-reveal-delay="<?= ($i%4)+1 ?>">
                <div class="relative overflow-hidden book-3d bg-slate-100" style="aspect-ratio:3/2">
                    <a href="<?= BASE_URL ?>/book/<?= Security::e($book['slug']) ?>" class="block w-full h-full book-3d-inner">
                        <?php if ($book['cover_image']): ?>
                        <img data-src="<?= uploadUrl('books', $book['cover_image']) ?>"
                             src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                             alt="<?= Security::e($book['title']) ?>"
                             class="w-full h-full object-cover">
                        <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-navy to-indigo">
                            <i class="fas fa-book text-5xl text-white/30"></i>
                        </div>
                        <?php endif; ?>
                    </a>
                    <?php if (!empty($book['category'])): ?>
                    <span class="absolute top-3 left-3 pill pill-glass backdrop-blur-md text-navy"><?= Security::e($book['category']) ?></span>
                    <?php endif; ?>
                </div>
                <div class="p-5">
                    <h3 class="font-modern text-navy font-bold text-base mb-1.5 leading-snug line-clamp-2 group-hover:text-indigo transition-colors">
                        <a href="<?= BASE_URL ?>/book/<?= Security::e($book['slug']) ?>"><?= Security::e($book['title']) ?></a>
                    </h3>
                    <?php if (!empty($book['authors'])): ?>
                    <p class="text-slate-500 text-sm mb-2 flex items-center gap-1.5">
                        <i class="fas fa-user-pen text-indigo text-xs"></i><?= Security::e($book['authors']) ?>
                    </p>
                    <?php endif; ?>
                    <?php if (!empty($book['isbn'])): ?>
                    <p class="text-slate-400 text-xs mb-3">ISBN: <?= Security::e($book['isbn']) ?></p>
                    <?php endif; ?>
                    <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                        <a href="<?= BASE_URL ?>/book/<?= Security::e($book['slug']) ?>"
                           class="text-indigo hover:text-indigo-light font-bold text-sm transition flex items-center gap-1.5">
                            View Details <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <?php if (!empty($book['pdf_file'])): ?>
                        <a href="<?= uploadUrl('books', $book['pdf_file']) ?>" target="_blank"
                           class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white flex items-center justify-center transition-colors" title="Download PDF">
                            <i class="fas fa-file-pdf text-sm"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if (($pag['total_pages'] ?? 1) > 1):
            $cur  = (int)($pag['current_page'] ?? 1);
            $tp   = (int)$pag['total_pages'];
            $base = BASE_URL.'/books?'.http_build_query(array_filter(['search'=>$search])).($search?'&':'').'page=';
        ?>
        <div class="pagination mt-10">
            <?php if ($cur > 1): ?>
            <a href="<?= $base.($cur-1) ?>"><i class="fas fa-chevron-left text-xs"></i></a>
            <?php endif; ?>
            <?php for ($p=1; $p<=$tp; $p++):
                if ($p==1 || $p==$tp || abs($p-$cur)<=2): ?>
                <?php if ($p==$cur): ?><span class="current"><?= $p ?></span>
                <?php else: ?><a href="<?= $base.$p ?>"><?= $p ?></a><?php endif; ?>
            <?php elseif (abs($p-$cur)==3): ?><span class="dots">…</span><?php endif; endfor; ?>
            <?php if ($cur < $tp): ?>
            <a href="<?= $base.($cur+1) ?>"><i class="fas fa-chevron-right text-xs"></i></a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
