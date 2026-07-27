<?php $editorialBoard = $editorialBoard ?? []; ?>

<!-- Hero -->
<section class="hero-modern hero-mesh relative overflow-hidden">
    <div class="container mx-auto px-4 py-20 relative z-10">
        <div class="max-w-3xl" data-reveal>
            <nav class="flex items-center gap-2 text-sm text-white/60 mb-4">
                <a href="<?= BASE_URL ?>" class="hover:text-white transition-colors">Home</a>
                <i class="fas fa-angle-right text-xs"></i>
                <a href="<?= BASE_URL ?>/about" class="hover:text-white transition-colors">About</a>
                <i class="fas fa-angle-right text-xs"></i>
                <span class="text-white">Editorial Board</span>
            </nav>
            <span class="pill pill-glass mb-4"><i class="fas fa-user-tie text-gold text-[10px]"></i> Editorial Excellence</span>
            <h1 class="font-modern text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Editorial Board</h1>
            <p class="text-slate-300 text-lg max-w-xl">Our distinguished editorial board comprises leading experts and researchers from renowned institutions worldwide.</p>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 70" class="w-full h-10 md:h-16" preserveAspectRatio="none"><path fill="#f8fafc" d="M0,35 C360,80 720,0 1080,25 C1260,38 1380,48 1440,44 L1440,70 L0,70 Z"/></svg>
    </div>
</section>

<section class="py-16 bg-slate-50">
    <div class="container mx-auto px-4">
        <?php if (empty($editorialBoard)): ?>
        <div class="text-center py-20">
            <div class="w-24 h-24 bg-white rounded-3xl shadow-card flex items-center justify-center mx-auto mb-5">
                <i class="fas fa-user-tie text-4xl text-slate-300"></i>
            </div>
            <h3 class="text-xl font-bold text-navy mb-2">No editorial board members yet</h3>
            <p class="text-slate-400">Editorial board members will appear here once added.</p>
        </div>
        <?php else: ?>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach ($editorialBoard as $i => $member): ?>
            <article class="card-modern p-6 text-center" data-reveal data-reveal-delay="<?= ($i % 4) + 1 ?>">
                <div class="flex justify-center mb-4">
                <?php if ($member['photo']): ?>
                    <img src="<?= uploadUrl('board', $member['photo']) ?>"
                         alt="<?= htmlspecialchars($member['name']) ?>"
                         class="w-24 h-24 rounded-full object-cover ring-4 ring-white shadow-card">
                <?php else: ?>
                    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-indigo to-indigo-light flex items-center justify-center ring-4 ring-white shadow-card">
                        <i class="fas fa-user text-3xl text-white/70"></i>
                    </div>
                <?php endif; ?>
                </div>
                <h4 class="font-modern font-bold text-navy mb-1"><?= htmlspecialchars($member['name']) ?></h4>
                <?php if ($member['designation']): ?>
                <p class="text-indigo text-xs font-bold uppercase tracking-wider mb-2"><?= htmlspecialchars($member['designation']) ?></p>
                <?php endif; ?>
                <?php if ($member['institution']): ?>
                <p class="text-slate-500 text-sm leading-snug"><?= htmlspecialchars($member['institution']) ?></p>
                <?php endif; ?>
                <?php if ($member['qualification']): ?>
                <p class="text-slate-400 text-xs italic mt-2"><?= htmlspecialchars($member['qualification']) ?></p>
                <?php endif; ?>
            </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
