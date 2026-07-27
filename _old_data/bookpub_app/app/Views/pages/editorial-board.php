<?php $editorialBoard = $editorialBoard ?? []; ?>

<!-- HERO -->
<section class="relative overflow-hidden" style="background: linear-gradient(135deg, #1a1a2e 0%, var(--brand-primary) 60%, var(--brand-primary-lt) 100%);">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 right-0 w-[600px] h-[600px] rounded-full" style="background: var(--brand-secondary); filter: blur(180px); transform: translate(30%, -30%);"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] rounded-full" style="background: var(--brand-primary-lt); filter: blur(140px); transform: translate(-30%, 30%);"></div>
    </div>
    <div class="container mx-auto px-4 py-20 md:py-28 relative z-10">
        <div class="max-w-3xl mx-auto text-center" data-reveal>
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-widest mb-6"
                  style="background: rgba(var(--rgb-primary), 0.2); color: var(--brand-primary-lt); border: 1px solid rgba(var(--rgb-primary), 0.3);">
                <i class="fas fa-user-tie text-[10px]"></i> Leadership
            </span>
            <h1 class="font-modern text-4xl md:text-6xl font-extrabold text-white tracking-tight mb-5">
                Editorial Board
            </h1>
            <p class="text-white/70 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
                Our distinguished editorial board comprises leading experts and researchers from renowned institutions worldwide, ensuring the highest standards of academic publishing.
            </p>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 80" class="w-full h-12 md:h-20" preserveAspectRatio="none">
            <path fill="var(--color-bg)" d="M0,40 C480,100 960,0 1440,50 L1440,80 L0,80 Z"/>
        </svg>
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

<!-- BOARD MEMBERS -->
<section class="pb-20 md:pb-28" style="background: var(--color-bg);">
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
