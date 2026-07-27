<?php $pageTitle = 'Gallery'; ?>
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-serif font-bold text-primary">Gallery</h1>
        <p class="text-gray-500 text-sm mt-1">Manage images and videos displayed in the gallery.</p>
    </div>
    <div class="flex gap-3">
        <a href="<?= BASE_URL ?>/admin/gallery/categories"
           class="flex items-center gap-2 bg-gray-100 text-gray-700 px-4 py-2.5 rounded-xl font-semibold hover:bg-gray-200 transition text-sm">
            <i class="fas fa-folder"></i> Categories
        </a>
        <a href="<?= BASE_URL ?>/admin/gallery/add"
           class="flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-primary-dark transition">
            <i class="fas fa-plus"></i> Add Item
        </a>
    </div>
</div>

<div class="flex gap-2 mb-6">
    <?php
    $currentType = $_GET['type'] ?? '';
    $tabs = ['' => 'All', 'image' => 'Images', 'video' => 'Videos'];
    foreach($tabs as $val => $label):
        $active = $currentType === $val;
    ?>
    <a href="<?= BASE_URL ?>/admin/gallery<?= $val ? '?type='.$val : '' ?>"
       class="px-4 py-2 rounded-xl text-sm font-semibold transition
       <?= $active ? 'bg-primary text-white' : 'bg-white border border-gray-200 text-gray-600 hover:border-primary hover:text-primary' ?>">
        <?= $label ?>
        <?php if(!$active): ?>
        <span class="text-xs opacity-60 ml-1">(<?= $counts[$val] ?? 0 ?>)</span>
        <?php endif; ?>
    </a>
    <?php endforeach; ?>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <?php if(empty($items)): ?>
    <div class="text-center py-16 text-gray-400">
        <i class="fas fa-images text-4xl mb-3 block opacity-30"></i>
        <p class="font-medium">No gallery items yet.</p>
        <a href="<?= BASE_URL ?>/admin/gallery/add" class="text-primary hover:underline text-sm mt-2 inline-block">Add first item →</a>
    </div>
    <?php else: ?>

    <div class="p-6 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        <?php foreach($items as $item): ?>
        <div class="relative group rounded-xl overflow-hidden bg-gray-100 aspect-square cursor-pointer transition transform hover:scale-[1.02] shadow-sm"
             onclick="openPreviewModal(<?= htmlspecialchars(json_encode([
                 'type' => $item['media_type'] ?? 'image',
                 'title' => $item['title'] ?? 'Untitled Asset',
                 'file_url' => !empty($item['file_path']) ? uploadUrl('gallery', $item['file_path']) : '',
                 'video_url' => $item['video_url'] ?? ''
             ])) ?>)">
            
            <?php if(($item['media_type'] ?? 'image')==='video'): ?>
            <div class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center">
                <?php if(!empty($item['file_path'])): ?>
                <img src="<?= uploadUrl('gallery', $item['file_path']) ?>" class="w-full h-full object-cover opacity-60">
                <?php else: ?>
                <div class="absolute inset-0 bg-slate-950/40"></div>
                <?php endif; ?>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-12 h-12 bg-white/90 text-gray-900 rounded-full flex items-center justify-center shadow-md group-hover:scale-110 transition">
                        <i class="fas fa-play ml-0.5"></i>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <img src="<?= uploadUrl('gallery', $item['file_path']) ?>"
                 alt="<?= htmlspecialchars($item['title'] ?? '') ?>"
                 loading="lazy"
                 class="w-full h-full object-cover">
            <?php endif; ?>

            <div class="absolute top-2 left-2 z-10">
                <span class="text-[10px] px-2 py-0.5 rounded-full font-bold bg-black/50 text-white backdrop-blur-sm">
                    <?= ($item['media_type'] ?? 'image') === 'video' ? '📹 Video' : '🖼 Image' ?>
                </span>
            </div>

            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex flex-col items-center justify-center gap-2 p-3">
                <?php if(!empty($item['title'])): ?>
                <p class="text-white text-xs text-center font-medium leading-tight mb-1 truncate w-full px-2"><?= htmlspecialchars($item['title']) ?></p>
                <?php endif; ?>
                
                <div class="flex gap-2" onclick="event.stopPropagation()">
                    <a href="<?= BASE_URL ?>/admin/gallery/edit/<?= $item['id'] ?>"
                       class="bg-white text-gray-800 hover:bg-primary hover:text-white text-xs p-2 rounded-lg transition shadow-md flex items-center justify-center w-8 h-8" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button onclick="confirmDelete('<?= BASE_URL ?>/admin/gallery/delete/<?= $item['id'] ?>')"
                            class="bg-white text-gray-800 hover:bg-red-500 hover:text-white text-xs p-2 rounded-lg transition shadow-md flex items-center justify-center w-8 h-8" title="Delete">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if(($pagination['total_pages'] ?? 1) > 1): ?>
    <div class="px-6 pb-6">
        <div class="pagination">
            <?php
            $base = BASE_URL.'/admin/gallery?'.($currentType ? 'type='.$currentType.'&' : '').'page=';
            for($p=1; $p<=$pagination['total_pages']; $p++): ?>
            <<?= $p==$pagination['current_page'] ? 'span class="current"' : 'a href="'.$base.$p.'"' ?>>
                <?= $p ?>
            </<?= $p==$pagination['current_page'] ? 'span' : 'a' ?>>
            <?php endfor; ?>
        </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>
</div>

<div id="previewModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-3xl w-full overflow-hidden shadow-2xl relative flex flex-col max-h-[90vh]">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-white">
            <h3 id="modalTitle" class="font-bold text-gray-900 text-base truncate pr-4">Preview</h3>
            <button onclick="closePreviewModal()" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-lg hover:bg-gray-50 transition">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <div class="bg-black p-2 flex items-center justify-center min-h-[300px] md:min-h-[450px]">
            <img id="modalImg" class="hidden max-w-full max-h-[70vh] object-contain rounded" src="">
            
            <video id="modalLocalVideo" controls class="hidden w-full max-h-[70vh] rounded" src=""></video>
            
            <iframe id="modalIframeVideo" class="hidden w-full aspect-video rounded" src="" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</div>

<script>
// Highly advanced regex handler jo normal, live, aur shorts links sabhi ko convert kar dega
function getYoutubeEmbedUrl(url) {
    if (!url) return '';
    // This regex catches regular links, live urls, and shorts urls flawlessly
    let regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\/live\/|\/shorts\/)([^#\&\?]*).*/;
    let match = url.match(regExp);
    if (match && match[2].length === 11) {
        return "https://www.youtube.com/embed/" + match[2] + "?autoplay=1";
    }
    return url;
}

function openPreviewModal(data) {
    const modal = document.getElementById('previewModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalImg = document.getElementById('modalImg');
    const modalLocalVideo = document.getElementById('modalLocalVideo');
    const modalIframeVideo = document.getElementById('modalIframeVideo');

    // Purane instances clear karne ke liye
    modalImg.classList.add('hidden');
    modalImg.src = '';
    modalLocalVideo.classList.add('hidden');
    modalLocalVideo.src = '';
    modalLocalVideo.pause();
    modalIframeVideo.classList.add('hidden');
    modalIframeVideo.src = '';

    modalTitle.textContent = data.title;

    if (data.type === 'video') {
        if (data.video_url && data.video_url.trim() !== '') {
            // Agar YouTube live stream ya normal URL h
            modalIframeVideo.src = getYoutubeEmbedUrl(data.video_url);
            modalIframeVideo.classList.remove('hidden');
        } else if (data.file_url) {
            // Agar server par uploaded local mp4 file h
            modalLocalVideo.src = data.file_url;
            modalLocalVideo.classList.remove('hidden');
            modalLocalVideo.load();
            modalLocalVideo.play().catch(err => console.log("Autoplay context locked:", err));
        }
    } else {
        // Image viewer
        modalImg.src = data.file_url;
        modalImg.classList.remove('hidden');
    }

    modal.classList.remove('hidden');
}

function closePreviewModal() {
    const modal = document.getElementById('previewModal');
    const modalLocalVideo = document.getElementById('modalLocalVideo');
    const modalIframeVideo = document.getElementById('modalIframeVideo');
    
    modalLocalVideo.pause();
    modalLocalVideo.src = '';
    modalIframeVideo.src = '';
    modal.classList.add('hidden');
}

window.addEventListener('keydown', e => {
    if(e.key === 'Escape') closePreviewModal();
});

function confirmDelete(url) {
  adminDelete(url, 'Delete this gallery item? This action cannot be undone.', () => {
    setTimeout(() => location.reload(), 500);
  });
}
</script>