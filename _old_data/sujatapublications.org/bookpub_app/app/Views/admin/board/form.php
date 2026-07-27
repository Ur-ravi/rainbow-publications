<?php
$member    = $member ?? [];
$boardType = $boardType ?? $type ?? 'editorial';
$isEdit    = !empty($member['id']);
$pageTitle = ($isEdit ? 'Edit' : 'Add') . ' ' . ucfirst($boardType) . ' Board Member';
?>
<div class="flex items-center gap-3 mb-6">
    <a href="<?= BASE_URL ?>/admin/board/<?= $boardType ?>"
       class="text-gray-400 hover:text-primary transition p-2 rounded-lg hover:bg-gray-100">
        <i class="fas fa-arrow-left"></i>
    </a>
    <div>
        <h1 class="text-2xl font-serif font-bold text-primary"><?= $pageTitle ?></h1>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2">
        <form id="memberForm" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
            <?= Security::csrfField() ?>
            <input type="hidden" name="board_type" value="<?= $boardType ?>">
            <input type="hidden" name="type" value="<?= $boardType ?>">
            <?php if($isEdit): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($member['id'] ?? '') ?>">
            <?php endif; ?>

            <div class="grid sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required
                           value="<?= htmlspecialchars($member['name'] ?? '') ?>"
                           class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 focus:bg-white transition-all duration-200" placeholder="Dr. John Smith">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Designation</label>
                    <input type="text" name="designation"
                           value="<?= htmlspecialchars($member['designation'] ?? '') ?>"
                           class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 focus:bg-white transition-all duration-200" placeholder="e.g. Associate Professor">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                    <input type="text" name="qualification"
                           value="<?= htmlspecialchars($member['qualification'] ?? '') ?>"
                           class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 focus:bg-white transition-all duration-200" placeholder="e.g. PhD, MBBS, MSc">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Institution / University</label>
                    <input type="text" name="institution"
                           value="<?= htmlspecialchars($member['institution'] ?? '') ?>"
                           class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 focus:bg-white transition-all duration-200" placeholder="University or Organization name">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Country</label>
                    <input type="text" name="country"
                           value="<?= htmlspecialchars($member['country'] ?? '') ?>"
                           class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 focus:bg-white transition-all duration-200" placeholder="e.g. India, USA, UK">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Status</label>
                    <select name="status" class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 focus:bg-white transition-all duration-200">
                        <?php $selectedStatus = isset($member['is_active']) ? ($member['is_active'] ? 'active' : 'inactive') : 'active'; ?>
                        <option value="active" <?= $selectedStatus === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= $selectedStatus === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Sort Order</label>
                    <input type="number" name="sort_order" min="0"
                           value="<?= htmlspecialchars($member['sort_order'] ?? '0') ?>"
                           class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 focus:bg-white transition-all duration-200">
                </div>
            </div>

            <div class="mt-6 border-t border-gray-100 pt-6">
                <label class="block text-sm font-semibold text-gray-700 mb-3">Profile Photo</label>
                <div class="flex items-center gap-5 bg-gray-50/50 border border-gray-100 rounded-2xl p-4 w-full sm:w-fit">
                    <div class="flex-shrink-0">
                        <?php if(!empty($member['photo'])): ?>
                        <img id="photoPreview"
                             src="<?= uploadUrl('board', $member['photo']) ?>"
                             class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-sm ring-1 ring-gray-200/50">
                        <?php else: ?>
                        <div id="photoPlaceholder" class="w-20 h-20 rounded-full bg-white flex items-center justify-center border-4 border-white shadow-sm ring-1 ring-gray-200/50">
                            <i class="fas fa-user text-gray-300 text-2xl"></i>
                        </div>
                        <img id="photoPreview" class="w-20 h-20 rounded-full object-cover border-4 border-white shadow-sm ring-1 ring-gray-200/50 hidden">
                        <?php endif; ?>
                    </div>
                    <div class="space-y-1">
                        <label for="photoInput"
                               class="cursor-pointer bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 px-4 py-2 rounded-xl font-semibold text-xs shadow-sm transition flex items-center gap-2 w-fit">
                            <i class="fas fa-camera text-gray-400"></i> Upload Photo
                        </label>
                        <input type="file" id="photoInput" name="photo" accept="image/*" class="hidden">
                        <p class="text-xs text-gray-400">JPG or PNG, max 2MB. Square 1:1 format works best.</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex items-center gap-4 border-t border-gray-100 pt-6">
                <button type="submit"
                        class="bg-primary text-white px-6 py-3 rounded-xl font-semibold hover:bg-primary-dark transition flex items-center gap-2 shadow-sm shadow-primary/20">
                    <i class="fas fa-save"></i> <?= $isEdit ? 'Update Member' : 'Add Member' ?>
                </button>
                <a href="<?= BASE_URL ?>/admin/board/<?= $boardType ?>" class="text-gray-500 hover:text-gray-700 font-semibold transition py-3 text-sm">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <aside>
        <div class="bg-amber-50 border border-amber-100 rounded-2xl p-6 sticky top-6">
            <h4 class="font-semibold text-amber-800 mb-3 flex items-center gap-2">
                <i class="fas fa-star text-amber-500"></i> Board Tips
            </h4>
            <ul class="text-sm text-amber-700 space-y-2.5">
                <li class="flex items-start gap-1.5"><span>•</span> <span>Use a professional headshot photo.</span></li>
                <li class="flex items-start gap-1.5"><span>•</span> <span>Square photos (1:1) display best.</span></li>
                <li class="flex items-start gap-1.5"><span>•</span> <span>Include full designation for credibility.</span></li>
                <li class="flex items-start gap-1.5"><span>•</span> <span>Inactive members won't appear on website.</span></li>
                <li class="flex items-start gap-1.5"><span>•</span> <span>Drag to reorder on the list page.</span></li>
            </ul>
        </div>
    </aside>
</div>

<script>
// Live Image Preview Handler
document.getElementById('photoInput').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const preview = document.getElementById('photoPreview');
        const placeholder = document.getElementById('photoPlaceholder');
        preview.src = e.target.result;
        preview.classList.remove('hidden');
        if (placeholder) placeholder.classList.add('hidden');
    };
    reader.readAsDataURL(file);
});

// Fixed Submission Async Thread & State Locking Loop
document.getElementById('memberForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // UI submission block lagane ke liye standard state control
    const btn = this.querySelector('button[type="submit"]');
    const origHTML = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
    btn.disabled = true;

    try {
        const action = '<?= BASE_URL ?>/admin/board/<?= $boardType ?>/<?= $isEdit ? 'edit/'.($member['id'] ?? '') : 'add' ?>';
        const res    = await fetch(action, { method:'POST', body: new FormData(this) });
        const data   = await res.json();
        
        showToast(data.message, data.success ? 'success' : 'error');
        if (data.success) {
            // Edit aur Add dono scenarios me 1 second baad safe auto redirect back configuration
            setTimeout(() => window.location.href = '<?= BASE_URL ?>/admin/board/<?= $boardType ?>', 1000);
        } else {
            // Failure par button control restore karega
            btn.innerHTML = origHTML;
            btn.disabled = false;
        }
    } catch (error) {
        showToast('Something went wrong. Please try again.', 'error');
        btn.innerHTML = origHTML;
        btn.disabled = false;
        console.error('Board logic error trace:', error);
    }
});
</script>