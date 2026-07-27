<?php
$pageTitle = 'Gallery';
$cats      = $cats ?? [];
$items     = $items ?? [];
$catId     = (int)($catId ?? 0);

// Sabse top par hi array ko ek baar reverse kar dete hain, 
// taaki poore page me sequence bilkul same aur correct rahe.
if (!empty($items)) {
    $items = array_reverse($items);
}
?>
<section class="hero-modern hero-mesh relative overflow-hidden">
    <div class="container mx-auto px-4 py-20 relative z-10">
        <div class="max-w-3xl" data-reveal>
            <nav class="flex items-center gap-2 text-sm text-white/60 mb-4">
                <a href="<?= BASE_URL ?>" class="hover:text-white transition-colors">Home</a>
                <i class="fas fa-angle-right text-xs"></i>
                <span class="text-white">Gallery</span>
            </nav>
            <span class="pill pill-glass mb-4"><i class="fas fa-images text-gold text-[10px]"></i> Media Gallery</span>
            <h1 class="font-modern text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Gallery</h1>
            <p class="text-slate-300 text-lg max-w-xl">Visual highlights from our events, publications, and academic milestones.</p>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 70" class="w-full h-10 md:h-16" preserveAspectRatio="none"><path fill="#f8fafc" d="M0,35 C360,80 720,0 1080,25 C1260,38 1380,48 1440,44 L1440,70 L0,70 Z"/></svg>
    </div>
</section>

<section class="py-16 bg-slate-50">
    <div class="container mx-auto px-4">

        <?php if (!empty($cats)): ?>
        <div class="flex flex-wrap justify-center gap-2.5 mb-12" data-reveal>
            <a href="<?= BASE_URL ?>/gallery"
               class="px-5 py-2 rounded-full text-sm font-bold transition-all <?= !$catId ? 'bg-indigo text-white shadow-lg shadow-indigo/30' : 'bg-white text-slate-600 hover:text-indigo border border-slate-200' ?>">
                All
            </a>
            <?php foreach ($cats as $cat): ?>
            <a href="<?= BASE_URL ?>/gallery?cat=<?= urlencode($cat['id']) ?>"
               class="px-5 py-2 rounded-full text-sm font-bold transition-all <?= $catId === (int)$cat['id'] ? 'bg-indigo text-white shadow-lg shadow-indigo/30' : 'bg-white text-slate-600 hover:text-indigo border border-slate-200' ?>">
                <?= htmlspecialchars($cat['name']) ?>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if (empty($items)): ?>
        <div class="text-center py-20" data-reveal>
            <div class="w-24 h-24 bg-white rounded-3xl shadow-card flex items-center justify-center mx-auto mb-5">
                <i class="fas fa-images text-4xl text-slate-300"></i>
            </div>
            <h3 class="text-xl font-bold text-navy mb-2">No media yet</h3>
            <p class="text-slate-400">Gallery items will appear here once added.</p>
        </div>
        <?php else: ?>

        <div class="masonry">
            <?php foreach ($items as $idx => $item):
                $isVideo = ($item['media_type'] ?? 'image') === 'video';
            ?>
            <div class="gallery-item group rounded-2xl overflow-hidden shadow-card cursor-pointer relative" onclick="openLightbox(<?= $idx ?>)" data-reveal data-reveal-delay="<?= ($idx%5)+1 ?>">
                <?php if ($isVideo): ?>
                    <?php if (!empty($item['file_path'])): ?>
                    <img src="<?= uploadUrl('gallery', $item['file_path']) ?>" alt="<?= htmlspecialchars($item['title'] ?? '') ?>" loading="lazy" class="w-full object-cover">
                    <?php else: ?>
                    <div class="w-full h-56 bg-gradient-to-br from-navy to-indigo flex items-center justify-center"><i class="fas fa-video text-4xl text-white/40"></i></div>
                    <?php endif; ?>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-16 h-16 rounded-full glass-dark flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fas fa-play text-white text-xl ml-1"></i>
                        </div>
                    </div>
                <?php else: ?>
                    <img src="<?= uploadUrl('gallery', $item['file_path'] ?? '') ?>" alt="<?= htmlspecialchars($item['title'] ?? '') ?>" loading="lazy" class="w-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                        <div class="w-9 h-9 rounded-xl glass-dark flex items-center justify-center"><i class="fas fa-expand text-white text-sm"></i></div>
                    </div>
                <?php endif; ?>
                <div class="absolute inset-0 bg-gradient-to-t from-navy/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-4">
                    <?php if (!empty($item['title'])): ?>
                    <p class="text-white text-sm font-bold"><?= htmlspecialchars($item['title']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<div id="lightbox" class="lightbox" onclick="closeLightboxOnBg(event)">
    <button class="lightbox-close" onclick="closeLightbox()"><i class="fas fa-times"></i></button>
    <button id="lb-prev" onclick="changeLightbox(-1)" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full glass-dark text-white hover:bg-white/25 transition flex items-center justify-center"><i class="fas fa-chevron-left"></i></button>
    <div id="lightbox-content" class="max-w-4xl mx-4"></div>
    <button id="lb-next" onclick="changeLightbox(1)" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full glass-dark text-white hover:bg-white/25 transition flex items-center justify-center"><i class="fas fa-chevron-right"></i></button>
    <div id="lb-caption" class="absolute bottom-6 left-0 right-0 text-center text-white text-sm font-semibold"></div>
</div>

<script>
// Kyunki $items upar hi reverse ho chuka hai, ab yahan hum seedhe array_map chalayenge
const galleryData = <?= json_encode(array_map(function($item) {
    return [
        'type'  => $item['media_type'] ?? 'image',
        'file'  => $item['file_path'] ?? '',
        'video' => $item['video_url'] ?? '',
        'title' => $item['title'] ?? '',
    ];
}, $items)) ?>;

let currentIdx = 0;
const baseUrl = '<?= rtrim(BASE_URL,'/') ?>/uploads/gallery/';

function openLightbox(idx) {
    currentIdx = idx;
    renderLightbox();
    document.getElementById('lightbox').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function renderLightbox() {
    const item = galleryData[currentIdx];
    const cont = document.getElementById('lightbox-content');
    document.getElementById('lb-caption').textContent = item.title || '';
    if (item.type === 'video') {
        if (item.video && (item.video.includes('youtube') || item.video.includes('youtu.be'))) {
            const m = item.video.match(/(?:v=|youtu\.be\/)([^&\s]+)/);
            const id = m ? m[1] : '';
            cont.innerHTML = `<iframe class="rounded-xl" width="800" height="450" src="https://www.youtube.com/embed/${id}?autoplay=1" frameborder="0" allow="autoplay" allowfullscreen style="max-width:90vw"></iframe>`;
        } else {
            cont.innerHTML = `<video src="${baseUrl}${item.file}" controls autoplay class="rounded-xl max-h-[80vh]"></video>`;
        }
    } else {
        cont.innerHTML = `<img src="${baseUrl}${item.file}" alt="${item.title}" class="rounded-xl shadow-2xl max-h-[80vh] max-w-[90vw]">`;
    }
    document.getElementById('lb-prev').style.display = currentIdx > 0 ? 'flex' : 'none';
    document.getElementById('lb-next').style.display = currentIdx < galleryData.length-1 ? 'flex' : 'none';
}
function changeLightbox(dir) {
    const n = currentIdx + dir;
    if (n >= 0 && n < galleryData.length) { currentIdx = n; renderLightbox(); }
}
function closeLightbox() {
    document.getElementById('lightbox').classList.remove('open');
    document.getElementById('lightbox-content').innerHTML = '';
    document.body.style.overflow = '';
}
function closeLightboxOnBg(e) { if (e.target.id === 'lightbox') closeLightbox(); }
document.addEventListener('keydown', e => {
    if (!document.getElementById('lightbox').classList.contains('open')) return;
    if (e.key === 'ArrowLeft')  changeLightbox(-1);
    if (e.key === 'ArrowRight') changeLightbox(1);
    if (e.key === 'Escape')     closeLightbox();
});
</script>