<?php $conferences = $conferences ?? []; ?>

<!-- HERO -->
<section class="hero-modern hero-mesh relative overflow-hidden">
    <div class="container mx-auto px-4 py-20 relative z-10">
        <div class="max-w-3xl" data-reveal>
            <nav class="flex items-center gap-2 text-sm text-white/60 mb-4">
                <a href="<?= BASE_URL ?>" class="hover:text-white transition-colors">Home</a>
                <i class="fas fa-angle-right text-xs"></i>
                <span class="text-white">Conferences</span>
            </nav>
            <span class="pill pill-glass mb-4"><i class="fas fa-calendar-alt text-gold text-[10px]"></i> Conferences</span>
            <h1 class="font-modern text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-4">
                Conferences
            </h1>
            <p class="text-slate-300 text-lg max-w-xl">
                Upcoming and past conferences hosted in collaboration with leading academic institutions.
            </p>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 70" class="w-full h-10 md:h-16" preserveAspectRatio="none"><path fill="#f8fafc" d="M0,35 C360,80 720,0 1080,25 C1260,38 1380,48 1440,44 L1440,70 L0,70 Z"/></svg>
    </div>
</section>

<section class="py-16 bg-slate-50">
    <div class="container mx-auto px-4 max-w-6xl">
        <?php if (empty($conferences)): ?>
        <div class="text-center py-20" data-reveal>
            <div class="w-24 h-24 bg-white rounded-3xl shadow-card flex items-center justify-center mx-auto mb-5">
                <i class="fas fa-calendar-alt text-4xl text-slate-300"></i>
            </div>
            <h3 class="text-xl font-bold text-navy mb-2">No conferences listed yet</h3>
            <p class="text-slate-400">Check back soon for upcoming events.</p>
        </div>
        <?php else: ?>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-7">
            <?php foreach ($conferences as $i => $c):
                $isUpcoming = !empty($c['conference_date']) && strtotime($c['conference_date']) >= strtotime(date('Y-m-d'));
            ?>
            <article class="card-modern group" data-reveal data-reveal-delay="<?= ($i % 3) + 1 ?>">
                <a href="<?= BASE_URL ?>/conference/<?= htmlspecialchars($c['slug']) ?>" class="block">
                    <div class="relative overflow-hidden bg-slate-100" style="aspect-ratio:4/3">
                        <?php if (!empty($c['poster_image'])): ?>
                        <img src="<?= uploadUrl('conferences', $c['poster_image']) ?>"
                             alt="<?= htmlspecialchars($c['title']) ?>"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-navy to-indigo">
                            <i class="fas fa-calendar-alt text-5xl text-white/30"></i>
                        </div>
                        <?php endif; ?>
                        <?php if ($isUpcoming): ?>
                        <span class="absolute top-3 right-3 bg-emerald text-white text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-lg">Upcoming</span>
                        <?php elseif (!empty($c['conference_date'])): ?>
                        <span class="absolute top-3 right-3 bg-slate-600/80 backdrop-blur text-white text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-lg">Past</span>
                        <?php endif; ?>
                    </div>
                    <div class="p-5">
                        <h3 class="font-modern font-bold text-navy text-base leading-snug mb-2 line-clamp-2 group-hover:text-indigo transition-colors">
                            <?= htmlspecialchars($c['title']) ?>
                        </h3>
                        <?php if (!empty($c['subtitle'])): ?>
                        <p class="text-secondary text-xs font-semibold mb-2"><?= htmlspecialchars($c['subtitle']) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($c['conference_date'])): ?>
                        <p class="text-slate-500 text-sm mb-3 flex items-center gap-1.5">
                            <i class="fas fa-calendar text-indigo text-xs"></i>
                            <?= formatDate($c['conference_date'], 'F d, Y') ?>
                        </p>
                        <?php endif; ?>
                        <?php if (!empty($c['intro_paragraph'])): ?>
                        <p class="text-slate-500 text-sm line-clamp-2 mb-3"><?= htmlspecialchars(truncate($c['intro_paragraph'], 110)) ?></p>
                        <?php endif; ?>
                        <span class="inline-flex items-center gap-1.5 text-indigo text-sm font-bold">
                            View Details <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                        </span>
                    </div>
                </a>
            </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
