<?php
$isEdit    = !empty($item['id']);
$pageTitle = $isEdit ? 'Edit Gallery Item' : 'Add Gallery Item';
?>
<div class="flex items-center gap-3 mb-6">
    <a href="<?= BASE_URL ?>/admin/gallery" class="text-gray-400 hover:text-primary p-2 rounded-lg hover:bg-gray-100 transition">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h1 class="text-2xl font-serif font-bold text-primary"><?= $pageTitle ?></h1>
</div>

<form id="galleryForm" enctype="multipart/form-data" action="<?= BASE_URL ?>/admin/gallery/<?= $isEdit ? 'edit/'.$item['id'] : 'add' ?>" method="POST">
    <?= Security::csrfField() ?>
    <?php if ($isEdit): ?>
    <input type="hidden" name="id" value="<?= (int)$item['id'] ?>">
    <?php endif; ?>
    <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <div class="grid sm:grid-cols-2 gap-6">
                    <div class="sm:col-span-2">
                        <label class="form-label">Title (Optional)</label>
                        <input type="text" name="title"
                               value="<?= htmlspecialchars($item['title'] ?? '') ?>"
                               class="form-input" placeholder="Gallery item caption">
                    </div>
                    <div>
                        <label class="form-label">Type <span class="text-red-500">*</span></label>
                        <select name="media_type" id="typeSelect" class="form-input" onchange="toggleType(this.value)">
                            <option value="image" <?= ($item['media_type'] ?? 'image')==='image' ? 'selected' : '' ?>>Image</option>
                            <option value="video" <?= ($item['media_type'] ?? '')==='video' ? 'selected' : '' ?>>Video</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-input">
                            <option value="">— No Category —</option>
                            <?php foreach($cats ?? [] as $cat): ?>
                            <option value="<?= (int)$cat['id'] ?>" <?= (int)($item['category_id'] ?? 0) === (int)$cat['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-input">
                            <option value="1" <?= ($item['is_active'] ?? 1) == 1 ? 'selected' : '' ?>>Active</option>
                            <option value="0" <?= ($item['is_active'] ?? 1) == 0 ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" min="0"
                               value="<?= htmlspecialchars($item['sort_order'] ?? '0') ?>"
                               class="form-input">
                    </div>
                </div>

                <div id="imageUploadSection" class="mt-6 <?= ($item['media_type'] ?? 'image')==='video' ? 'hidden' : '' ?>">
                    <label class="form-label">Image File</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center cursor-pointer hover:border-primary transition"
                         onclick="document.getElementById('imageFile').click()">
                        <?php if(!empty($item['file_path']) && ($item['media_type'] ?? 'image')==='image'): ?>
                        <img id="imgPreview" src="<?= uploadUrl('gallery', $item['file_path']) ?>" class="max-h-48 mx-auto rounded-xl mb-2">
                        <p class="text-xs text-gray-400">Click to change</p>
                        <?php else: ?>
                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-300 mb-2 block"></i>
                        <p class="text-gray-500 text-sm">Click to upload image</p>
                        <p class="text-gray-400 text-xs mt-1">JPG, PNG, WebP — Max 5MB</p>
                        <img id="imgPreview" class="hidden max-h-48 mx-auto rounded-xl mt-3">
                        <?php endif; ?>
                        <input type="file" id="imageFile" name="file_path" accept="image/*" class="hidden">
                    </div>
                </div>

                <div id="videoSection" class="mt-6 <?= ($item['media_type'] ?? 'image')==='image' ? 'hidden' : '' ?>">
                    <label class="form-label">Video URL (YouTube / Vimeo / Live)</label>
                    <input type="url" name="video_url"
                           value="<?= htmlspecialchars($item['video_url'] ?? '') ?>"
                           class="form-input mb-4" placeholder="https://youtube.com/watch?v=... ya youtube.com/live/...">

                    <label class="form-label">Or Upload Video File</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center cursor-pointer hover:border-primary transition"
                         onclick="document.getElementById('videoFile').click()">
                        <i class="fas fa-video text-2xl text-gray-300 mb-1 block"></i>
                        <p id="videoStatusText" class="text-sm text-gray-500">Click to upload video</p>
                        <p class="text-xs text-gray-400">MP4, WebM — Max 50MB</p>
                        <input type="file" id="videoFile" name="file_path" accept="video/*" class="hidden">
                    </div>

                    <label class="form-label mt-4">Thumbnail Image</label>
                    <input type="file" name="thumbnail" accept="image/*" class="form-input text-sm">
                </div>
            </div>
        </div>

        <aside>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <button type="submit"
                        class="w-full bg-primary text-white py-3 rounded-xl font-semibold hover:bg-primary-dark transition flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i> <?= $isEdit ? 'Update' : 'Add to Gallery' ?>
                </button>
                <a href="<?= BASE_URL ?>/admin/gallery"
                   class="block text-center text-gray-500 text-sm mt-3 hover:text-gray-700 transition">Cancel</a>
            </div>
        </aside>
    </div>
</form>

<script>
function toggleType(val) {
    const isVideo = val === 'video';
    document.getElementById('imageUploadSection').classList.toggle('hidden', isVideo);
    document.getElementById('videoSection').classList.toggle('hidden', !isVideo);
    
    // Duplicate name conflict completely resolved here
    document.getElementById('imageFile').disabled = isVideo;
    document.getElementById('videoFile').disabled = !isVideo;
}

// Page load par initialization handle karne ke liye
document.addEventListener('DOMContentLoaded', function() {
    toggleType(document.getElementById('typeSelect').value);
});

document.getElementById('imageFile').addEventListener('change', function() {
    const file = this.files[0]; if(!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById('imgPreview');
        img.src = e.target.result;
        img.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
});

document.getElementById('videoFile').addEventListener('change', function() {
    const file = this.files[0]; if(!file) return;
    document.getElementById('videoStatusText').innerHTML = `<span class="text-green-600 font-semibold"><i class="fas fa-check-circle"></i> Selected: ${file.name}</span>`;
});

document.getElementById('galleryForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    const btn = document.querySelector('button[type="submit"]');
    const orig = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
    btn.disabled = true;
    try {
        const res = await fetch(this.action, { method: 'POST', body: fd });
        const data = await res.json();
        showToast(data.message || 'Saved!', data.success ? 'success' : 'error');
        if (data.success) {
            setTimeout(() => window.location.href = '<?= BASE_URL ?>/admin/gallery', 1000);
        }
    } catch(e) {
        showToast('Error saving gallery item', 'error');
    }
    btn.innerHTML = orig;
    btn.disabled = false;
});
</script>