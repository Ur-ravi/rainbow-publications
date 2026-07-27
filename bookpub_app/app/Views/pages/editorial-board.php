<?php $editorialBoard = $editorialBoard ?? []; ?>

<!-- HERO -->
<section class="page-hero">
    <div class="hero-mesh"></div>

    <div class="hero-orbs">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <div class="container mx-auto px-4 py-24 relative z-10">
        <div class="max-w-3xl mx-auto text-center" data-reveal>

            <nav class="flex items-center justify-center gap-2 text-sm mb-5">
                <a href="<?= BASE_URL ?>" class="breadcrumb-link">Home</a>
                <i class="fas fa-angle-right text-xs breadcrumb-sep"></i>
                <span class="breadcrumb-current">Editorial Board</span>
            </nav>

            <span class="pill pill-glass mb-4">
                <i class="fas fa-user-tie text-gold text-[10px]"></i>
                Leadership
            </span>

            <h1 class="hero-title">
                <span class="hero-title-line">Editorial Board</span>
            </h1>
<br>

            <p class="hero-subtitle mx-auto">
                Our distinguished editorial board comprises leading experts and researchers from renowned institutions worldwide, ensuring the highest standards of academic publishing.
            </p>

        </div>
    </div>

    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 70" class="w-full h-10 md:h-16" preserveAspectRatio="none">
            <path fill="var(--slate-50)" d="M0,35 C360,80 720,0 1080,25 C1260,38 1380,48 1440,44 L1440,70 L0,70 Z"/>
        </svg>
    </div>
</section>


<!-- BOARD MEMBERS -->
<section class="pb-20 md:pb-28 mt-5" style="background: var(--color-bg);">
    <div class="container mx-auto px-4">
        <?php if (empty($editorialBoard)): ?>
        <div class="text-center py-24" data-reveal>
            <div class="w-28 h-28 rounded-3xl flex items-center justify-center mx-auto mb-6"
                 style="background: var(--color-bg-alt); border: 2px dashed var(--color-border);">
                <i class="fas fa-user-tie text-5xl" style="color: var(--color-muted); opacity: 0.3;"></i>
            </div>
            <h3 class="text-2xl font-bold mb-2" style="color: var(--color-heading);">No board members yet</h3>
            <p style="color: var(--color-muted);">Editorial board members will appear here once added.</p>
        </div>
        <?php else: ?>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 md:gap-7">
            <?php foreach ($editorialBoard as $i => $member): ?>
            <article class="board-card group" data-reveal data-reveal-delay="<?= ($i % 4) + 1 ?>">
                <div class="relative h-full rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-xl"
                     style="background: var(--color-bg-white); border: 1px solid var(--color-border);">

                    <!-- Top accent -->
                    <div class="h-1 w-full" style="background: linear-gradient(90deg, var(--brand-primary), var(--brand-primary-lt));"></div>

                    <div class="p-6 md:p-7 text-center">
                        <!-- Photo -->
                        <div class="relative inline-block mb-5">
                            <div class="absolute -inset-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                                 style="background: linear-gradient(135deg, var(--brand-primary), var(--brand-secondary));"></div>
                            <?php if ($member['photo']): ?>
                            <img src="<?= uploadUrl('board', $member['photo']) ?>"
                                 alt="<?= htmlspecialchars($member['name']) ?>"
                                 class="relative w-24 h-24 md:w-28 md:h-28 rounded-full object-cover border-4 border-white shadow-lg"
                                 loading="lazy">
                            <?php else: ?>
                            <div class="relative w-24 h-24 md:w-28 md:h-28 rounded-full flex items-center justify-center border-4 border-white shadow-lg"
                                 style="background: linear-gradient(135deg, var(--brand-primary), var(--brand-primary-lt));">
                                <i class="fas fa-user text-3xl text-white/80"></i>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Name -->
                        <h4 class="font-modern font-extrabold text-base md:text-lg leading-tight mb-2" style="color: var(--color-heading);">
                            <?= htmlspecialchars($member['name']) ?>
                        </h4>

                        <!-- Designation -->
                        <?php if ($member['designation']): ?>
                        <p class="text-xs font-bold uppercase tracking-widest mb-2" style="color: var(--brand-primary);">
                            <?= htmlspecialchars($member['designation']) ?>
                        </p>
                        <?php endif; ?>

                        <!-- Institution -->
                        <?php if ($member['institution']): ?>
                        <p class="text-sm leading-relaxed" style="color: var(--color-muted);">
                            <?= htmlspecialchars($member['institution']) ?>
                        </p>
                        <?php endif; ?>

                        <!-- Qualification -->
                        <?php if ($member['qualification']): ?>
                        <p class="text-xs italic mt-2 pt-3" style="color: var(--color-muted); border-top: 1px solid var(--color-border);">
                            <?= htmlspecialchars($member['qualification']) ?>
                        </p>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>


<!-- STATS BAR -->
<section class="relative z-10 -mt-6 mb-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto rounded-2xl p-6 md:p-8" style="background: var(--color-bg-white); border: 1px solid var(--color-border); box-shadow: var(--shadow-md);">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div>
                    <div class="text-3xl md:text-4xl font-extrabold" style="color: var(--brand-primary);"><?= count($editorialBoard) ?>+</div>
                    <div class="text-xs font-semibold uppercase tracking-wider mt-1" style="color: var(--color-muted);">Board Members</div>
                </div>
                <div>
                    <div class="text-3xl md:text-4xl font-extrabold" style="color: var(--brand-primary);">25+</div>
                    <div class="text-xs font-semibold uppercase tracking-wider mt-1" style="color: var(--color-muted);">Countries</div>
                </div>
                <div>
                    <div class="text-3xl md:text-4xl font-extrabold" style="color: var(--brand-primary);">50+</div>
                    <div class="text-xs font-semibold uppercase tracking-wider mt-1" style="color: var(--color-muted);">Institutions</div>
                </div>
                <div>
                    <div class="text-3xl md:text-4xl font-extrabold" style="color: var(--brand-primary);">10+</div>
                    <div class="text-xs font-semibold uppercase tracking-wider mt-1" style="color: var(--color-muted);">Years Average</div>
                </div>
            </div>
        </div>
    </div>
</section>


