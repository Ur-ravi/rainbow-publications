<?php $pageTitle = 'Our Journals'; ?>
<!-- HERO -->
<section class="hero-modern hero-mesh relative overflow-hidden">
    <div class="container mx-auto px-4 py-20 relative z-10">
        <div class="max-w-3xl" data-reveal>
            <nav class="flex items-center gap-2 text-sm text-white/60 mb-4">
                <a href="<?= BASE_URL ?>" class="hover:text-white transition-colors">Home</a>
                <i class="fas fa-angle-right text-xs"></i>
                <span class="text-white">Our Journals</span>
            </nav>
            <span class="pill pill-glass mb-4"><i class="fas fa-journal-whills text-gold text-[10px]"></i> Peer Reviewed</span>
            <h1 class="font-modern text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Our Journals</h1>
            <p class="text-slate-300 text-lg max-w-xl">Access peer-reviewed academic journals spanning multiple disciplines and research domains.</p>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 70" class="w-full h-10 md:h-16" preserveAspectRatio="none"><path fill="#f8fafc" d="M0,35 C360,80 720,0 1080,25 C1260,38 1380,48 1440,44 L1440,70 L0,70 Z"/></svg>
    </div>
</section>

<!-- GRID -->
<section class="py-16 bg-slate-50">
    <div class="container mx-auto px-4">

        <!-- Search -->
        <div class="max-w-xl mx-auto mb-14" data-reveal>
            <form method="GET" action="<?= BASE_URL ?>/journals">
                <div class="relative">
                    <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                           placeholder="Search journals by name, ISSN…"
                           class="w-full pl-5 pr-14 py-3.5 rounded-2xl border border-slate-200 bg-white text-sm focus:outline-none focus:border-indigo focus:ring-2 focus:ring-indigo/20 transition shadow-soft">
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 w-10 h-10 rounded-xl bg-indigo text-white flex items-center justify-center hover:bg-indigo-light transition-colors">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <?php if (empty($journals)): ?>
        <div class="text-center py-20" data-reveal>
            <div class="w-24 h-24 bg-white rounded-3xl shadow-card flex items-center justify-center mx-auto mb-5">
                <i class="fas fa-journal-whills text-4xl text-slate-300"></i>
            </div>
            <h3 class="text-xl font-bold text-navy mb-2">No journals found</h3>
            <p class="text-slate-400">Try adjusting your search terms.</p>
        </div>
        <?php else: ?>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-7">
            <?php foreach ($journals as $i => $j): ?>
            <article class="card-modern glow-hover group p-7 flex flex-col text-center h-full" data-reveal data-reveal-delay="<?= ($i%4)+1 ?>">
                <!-- Logo -->
                <div class="flex justify-center mb-5">
                    <div class="w-20 h-20 rounded-2xl overflow-hidden flex items-center justify-center bg-slate-50 border border-slate-100 group-hover:scale-105 transition-transform duration-500">
                        <?php if ($j['logo']): ?>
                        <img src="<?= uploadUrl('journals', $j['logo']) ?>" alt="<?= htmlspecialchars($j['name']) ?>" loading="lazy" class="w-full h-full object-contain p-2">
                        <?php else: ?>
                        <div class="w-full h-full bg-gradient-to-br from-indigo to-indigo-light flex items-center justify-center">
                            <span class="text-white font-extrabold text-sm px-1 leading-tight"><?= htmlspecialchars($j['abbreviation'] ?: substr($j['name'],0,4)) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <h3 class="font-modern text-navy font-bold leading-snug mb-1 text-[0.95rem] group-hover:text-indigo transition-colors">
                    <?= htmlspecialchars($j['name']) ?>
                </h3>

                <?php if (!empty($j['abbreviation'])): ?>
                <p class="text-indigo text-xs font-bold tracking-wider mb-3">(<?= htmlspecialchars($j['abbreviation']) ?>)</p>
                <?php endif; ?>

                <?php if (!empty($j['issn'])): ?>
                <span class="pill pill-indigo !text-[10px] !py-1 mx-auto mb-3">ISSN: <?= htmlspecialchars($j['issn']) ?></span>
                <?php endif; ?>

                <?php if (!empty($j['description'])): ?>
                <p class="text-slate-500 text-sm mb-5 leading-relaxed line-clamp-3"><?= truncate(strip_tags($j['description']), 90) ?></p>
                <?php endif; ?>

                <div class="mt-auto pt-2 flex items-center justify-center gap-2">
                    <?php
                    $href   = $j['journal_url'] ?: '#';
                    $target = (strpos($href,'http')===0) ? ' target="_blank" rel="noopener"' : '';
                    ?>
                    <!-- Visit Journal: icon-only link to external journal URL -->
                    <a href="<?= htmlspecialchars($href) ?>" <?= $target ?>
                       class="w-10 h-10 rounded-xl flex items-center justify-center bg-slate-100 hover:bg-indigo hover:text-white text-slate-600 transition shadow-sm"
                       title="Visit Journal Website" aria-label="Visit Journal">
                        <i class="fas fa-external-link-alt text-sm"></i>
                    </a>
                    <!-- Submit Article: primary CTA to submit form -->
                    <a href="<?= BASE_URL ?>/journals/submit/<?= (int)$j['id'] ?>"
                       class="btn-modern btn-modern-primary !py-2.5 !px-4 text-sm flex items-center gap-1.5">
                        <i class="fas fa-paper-plane text-xs"></i> Submit Article
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- CTA strip -->
        <div class="mt-16 relative rounded-3xl overflow-hidden hero-modern hero-mesh p-10 md:p-12 text-center" data-reveal>
            <div class="relative z-10">
                <h3 class="font-modern text-2xl md:text-3xl font-extrabold text-white mb-3">Interested in Publishing with Us?</h3>
                <p class="text-slate-300 mb-7 max-w-xl mx-auto">Submit your research to one of our peer-reviewed journals and contribute to global academic knowledge.</p>
                <a href="<?= BASE_URL ?>/contact" class="btn-modern btn-modern-primary"><i class="fas fa-envelope"></i> Contact Us</a>
            </div>
        </div>
    </div>
</section>
