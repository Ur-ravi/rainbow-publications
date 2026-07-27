<?php
$pageTitle  = 'All Books';
$search     = $search ?? '';
$pag        = $pag ?? ['total'=>($total ?? 0), 'total_pages'=>1, 'current_page'=>1];
$totalBooks = $total ?? ($pag['total'] ?? 0);
?>
<!-- HERO -->
<section class="page-hero">

    <div class="hero-mesh"></div>

    <div class="hero-orbs">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <div class="container mx-auto px-4 py-24 relative z-10">
        <div class="max-w-3xl" data-reveal>

            <nav class="flex items-center gap-2 text-sm mb-5">
                <a href="<?= BASE_URL ?>" class="breadcrumb-link">Home</a>
                <i class="fas fa-angle-right text-xs breadcrumb-sep"></i>
                <span class="breadcrumb-current">Books</span>
            </nav>


            <span class="pill pill-glass mb-4">
                <i class="fas fa-book text-gold text-[10px]"></i>
                Academic Catalog
            </span>


            <h1 class="hero-title">
                <span class="hero-title-line">Our Publications</span>
            </h1>


            <div class="hero-divider"></div>


            <p class="hero-subtitle">
                Explore our comprehensive collection of academic and research publications.
            </p>


        </div>
    </div>


    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 70" class="w-full h-10 md:h-16" preserveAspectRatio="none">
            <path fill="var(--slate-50)" d="M0,35 C360,80 720,0 1080,25 C1260,38 1380,48 1440,44 L1440,70 L0,70 Z"/>
        </svg>
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
       <article class="book-card" data-reveal data-reveal-delay="<?= ($i % 3) + 1 ?>">
                            <div class="book-cover">
                                <?php if ($book['cover_image']): ?>
                                    <img data-src="<?= uploadUrl('books', $book['cover_image']) ?>"
                                        src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                                        alt="<?= Security::e($book['title']) ?>">
                                <?php else: ?>
                                    <div class="flex items-center justify-center text-3xl">
                                        <i class="fas fa-book text-slate-400"></i>
                                    </div>
                                <?php endif; ?>
                                <?php if ($book['is_featured']): ?>
                                    <span class="absolute top-3 right-3 badge badge-primary">Featured</span>
                                <?php endif; ?>
                            </div>
                            <div class="book-info">
                                <?php if ($book['category']): ?>
                                    <span class="badge text-xs mb-2"><?= Security::e($book['category']) ?></span>
                                <?php endif; ?>
                                <h3 class="heading-sm mb-2 line-clamp-2">
                                    <a href="<?= BASE_URL ?>/book/<?= Security::e($book['slug']) ?>" class="hover:text-primary transition-colors">
                                        <?= Security::e($book['title']) ?>
                                    </a>
                                </h3>
                                <p class="caption flex items-center gap-1 mb-3">
                                    <i class="fas fa-user-pen text-xs" style="color: var(--primary);"></i>
                                    <?= Security::e($book['authors']) ?>
                                </p>
                                <?php if ($book['description']): ?>
                                    <p class="caption line-clamp-2 mb-4"><?= truncate($book['description'], 110) ?></p>
                                <?php endif; ?>
                                <div class="flex items-center justify-between pt-4 border-t border-slate-200">
                                    <?php if ($book['publication_date']): ?>
                                        <span class="caption text-xs"><?= formatDate($book['publication_date'], 'Y') ?></span>
                                    <?php else: ?><span></span><?php endif; ?>
                                    <a href="<?= BASE_URL ?>/book/<?= Security::e($book['slug']) ?>" class="link-arrow text-sm">
                                        Read <i class="fas fa-arrow-right"></i>
                                    </a>
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
  <div class="flex items-center justify-center mt-10">
    <nav class="inline-flex items-center gap-2">

        <!-- Previous -->
        <?php if ($cur > 1): ?>
            <a href="<?= $base.($cur-1) ?>"
               class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 bg-white text-gray-600 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-200 shadow-sm">
                <i class="fas fa-chevron-left text-xs"></i>
            </a>
        <?php endif; ?>

        <!-- Page Numbers -->
        <?php
        $dotsShown = false;
        for ($p = 1; $p <= $tp; $p++):
            if ($p == 1 || $p == $tp || abs($p - $cur) <= 2):
                $dotsShown = false;
        ?>
                <?php if ($p == $cur): ?>
                    <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-600 text-white font-semibold shadow-md">
                        <?= $p ?>
                    </span>
                <?php else: ?>
                    <a href="<?= $base.$p ?>"
                       class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-200 shadow-sm">
                        <?= $p ?>
                    </a>
                <?php endif; ?>

        <?php
            elseif (!$dotsShown):
                $dotsShown = true;
        ?>
                <span class="px-2 text-gray-500 font-medium">...</span>
        <?php
            endif;
        endfor;
        ?>

        <!-- Next -->
        <?php if ($cur < $tp): ?>
            <a href="<?= $base.($cur+1) ?>"
               class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 bg-white text-gray-600 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all duration-200 shadow-sm">
                <i class="fas fa-chevron-right text-xs"></i>
            </a>
        <?php endif; ?>

    </nav>
</div>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
