<?php
$isEdit    = !empty($type['id']);
$pageTitle = $isEdit ? 'Edit Membership Type' : 'Add Membership Type';
$t         = $type ?? [];
$colors    = ['purple','blue','amber','green','pink','teal','coral','red','gray'];
$colorMap  = [
    'purple' => '#534AB7','blue' => '#185FA5','amber' => '#BA7517',
    'green'  => '#3B6D11','pink' => '#993C1D','teal' => '#0F6E56',
    'coral'  => '#C2410C','red' => '#A32D2D','gray' => '#5F5E5A',
];
?>
<div class="flex items-center gap-3 mb-6">
    <a href="<?= BASE_URL ?>/admin/membership-types"
       class="text-gray-400 hover:text-primary p-2 rounded-lg hover:bg-gray-100 transition">
        <i class="fas fa-arrow-left"></i>
    </a>
    <div>
        <h1 class="text-2xl font-serif font-bold text-primary"><?= $pageTitle ?></h1>
        <p class="text-gray-500 text-sm mt-0.5">All fields shown on the public <a href="<?= BASE_URL ?>/membership-types" target="_blank" class="text-primary underline">/membership-types</a> page.</p>
    </div>
</div>

<form id="mtForm">
    <?= Security::csrfField() ?>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- LEFT: Main fields -->
        <div class="lg:col-span-2 space-y-6">

            <!-- BASICS -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-id-card-alt text-primary"></i> Basic Info
                </h3>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="form-label">Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" required
                               value="<?= htmlspecialchars($t['title'] ?? '') ?>"
                               class="form-input"
                               placeholder="Life Membership">
                    </div>
                    <div>
                        <label class="form-label">Slug <span class="text-xs text-gray-400">(auto-generated)</span></label>
                        <input type="text" name="slug"
                               value="<?= htmlspecialchars($t['slug'] ?? '') ?>"
                               class="form-input font-mono text-sm"
                               placeholder="life">
                    </div>
                    <div>
                        <label class="form-label">Badge Number</label>
                        <input type="number" name="badge_number" min="1" max="99"
                               value="<?= htmlspecialchars($t['badge_number'] ?? '1') ?>"
                               class="form-input"
                               placeholder="1">
                    </div>
                </div>
            </div>

            <!-- FEE -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-tag text-primary"></i> Fee
                </h3>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Full Fee Label <span class="text-xs text-gray-400">(card body)</span></label>
                        <input type="text" name="fee_label"
                               value="<?= htmlspecialchars($t['fee_label'] ?? '') ?>"
                               class="form-input"
                               placeholder="₹999/-">
                    </div>
                    <div>
                        <label class="form-label">Short Fee Chip <span class="text-xs text-gray-400">(card header)</span></label>
                        <input type="text" name="fee_short"
                               value="<?= htmlspecialchars($t['fee_short'] ?? '') ?>"
                               class="form-input"
                               placeholder="₹999">
                    </div>
                </div>
            </div>

            <!-- ELIGIBILITY -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-user-check text-primary"></i> Eligibility <span class="text-xs text-gray-400 font-normal">(optional)</span>
                </h3>
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Eligibility Section Title</label>
                        <input type="text" name="eligibility_title"
                               value="<?= htmlspecialchars($t['eligibility_title'] ?? '') ?>"
                               class="form-input"
                               placeholder="Eligibility (age 21+):">
                    </div>
                    <div>
                        <label class="form-label">Eligibility Lines <span class="text-xs text-gray-400">(one per line)</span></label>
                        <textarea name="eligibility" rows="4" class="form-input resize-none"
                                  placeholder="Degree in pharmacy or graduation...&#10;Diploma from a recognized University..."><?= htmlspecialchars($t['eligibility'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <!-- DETAILS -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-list-ul text-primary"></i> Details <span class="text-red-500">*</span>
                </h3>
                <label class="form-label">Detail Lines <span class="text-xs text-gray-400">(one per line — appears as bullet points)</span></label>
                <textarea name="details" rows="5" class="form-input resize-none"
                          placeholder="One-time registration with lifetime benefits...&#10;Available to professionals, academicians..."><?= htmlspecialchars($t['details'] ?? '') ?></textarea>
            </div>

            <!-- FOOTER NOTE & NOMINATION -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-info-circle text-primary"></i> Footer Note / Nomination
                </h3>
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Italic Footer Note <span class="text-xs text-gray-400">(one per line)</span></label>
                        <textarea name="footer_note" rows="2" class="form-input resize-none"
                                  placeholder="SBC has discretion to reject any application without ascribing reasons"><?= htmlspecialchars($t['footer_note'] ?? '') ?></textarea>
                    </div>
                    <div>
                        <label class="form-label">Nomination Emails <span class="text-xs text-gray-400">(comma-separated, used by Honorary card)</span></label>
                        <input type="text" name="nomination_emails"
                               value="<?= htmlspecialchars($t['nomination_emails'] ?? '') ?>"
                               class="form-input font-mono text-sm"
                               placeholder="info@example.org, contact@example.org">
                    </div>
                </div>
            </div>

            <!-- COMPARISON TABLE FIELDS -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-table text-primary"></i> Fee Comparison Table
                </h3>
                <p class="text-xs text-gray-500 mb-4">These short labels appear in the comparison table at the bottom of the page.</p>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Eligibility (short)</label>
                        <input type="text" name="comparison_eligibility"
                               value="<?= htmlspecialchars($t['comparison_eligibility'] ?? '') ?>"
                               class="form-input"
                               placeholder="Graduates in pharmacy / life sciences">
                    </div>
                    <div>
                        <label class="form-label">Duration</label>
                        <input type="text" name="duration_label"
                               value="<?= htmlspecialchars($t['duration_label'] ?? '') ?>"
                               class="form-input"
                               placeholder="Lifetime">
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: Sidebar -->
        <aside class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <button type="submit" id="saveBtn"
                        class="w-full bg-primary text-white py-3 rounded-xl font-semibold hover:bg-primary-dark transition flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i> <?= $isEdit ? 'Update Type' : 'Save Type' ?>
                </button>
                <a href="<?= BASE_URL ?>/admin/membership-types"
                   class="w-full mt-2 inline-block text-center text-gray-500 hover:text-gray-700 font-medium py-2 transition">Cancel</a>
            </div>

            <!-- APPEARANCE -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                <h3 class="font-semibold text-gray-700 flex items-center gap-2">
                    <i class="fas fa-palette text-primary"></i> Card Color
                </h3>
                <div class="grid grid-cols-3 gap-2">
                    <?php foreach ($colors as $col): ?>
                    <label class="cursor-pointer">
                        <input type="radio" name="card_color" value="<?= $col ?>"
                               <?= ($t['card_color'] ?? 'purple') === $col ? 'checked' : '' ?>
                               class="peer sr-only">
                        <div class="aspect-square rounded-xl border-2 border-gray-200 peer-checked:border-primary peer-checked:ring-2 peer-checked:ring-primary/20 flex flex-col items-center justify-center gap-1 transition">
                            <span class="w-7 h-7 rounded-full shadow" style="background: <?= $colorMap[$col] ?>;"></span>
                            <span class="text-[10px] font-semibold text-gray-600 capitalize"><?= $col ?></span>
                        </div>
                    </label>
                    <?php endforeach; ?>
                </div>

                <div class="pt-3 border-t border-gray-100">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="is_full_width" value="0">
                        <input type="checkbox" name="is_full_width" value="1"
                               <?= !empty($t['is_full_width']) ? 'checked' : '' ?>
                               class="w-5 h-5 rounded accent-secondary">
                        <span class="text-sm text-gray-700">Full-width card <span class="text-xs text-gray-400">(spans 2 columns)</span></span>
                    </label>
                </div>
            </div>

            <!-- SETTINGS -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                <h3 class="font-semibold text-gray-700 flex items-center gap-2">
                    <i class="fas fa-sliders-h text-primary"></i> Settings
                </h3>
                <div>
                    <label class="form-label">Status</label>
                    <input type="hidden" name="is_active" value="0">
                    <label class="flex items-center gap-3 mt-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1"
                               <?= (!isset($t['is_active']) || $t['is_active']) ? 'checked' : '' ?>
                               class="w-5 h-5 rounded accent-secondary">
                        <span class="text-sm text-gray-700">Active (visible on site)</span>
                    </label>
                </div>
                <div>
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" min="0"
                           value="<?= htmlspecialchars($t['sort_order'] ?? '0') ?>"
                           class="form-input">
                    <p class="text-xs text-gray-400 mt-1">Lower number = appears first on the page</p>
                </div>
            </div>
        </aside>
    </div>
</form>

<script>
document.getElementById('mtForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = document.getElementById('saveBtn');
    const orig = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

    const action = '<?= BASE_URL ?>/admin/membership-types/<?= $isEdit ? "edit/".$t['id'] : "add" ?>';
    try {
        const res = await fetch(action, {
            method: 'POST',
            body: new FormData(this),
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (!res.ok) throw new Error('HTTP ' + res.status);
        const data = await res.json();
        showToast(data.message || (data.success ? 'Saved!' : 'Failed'), data.success ? 'success' : 'error');
        if (data.success && data.redirect) {
            setTimeout(() => window.location.href = data.redirect, 600);
        }
    } catch (err) {
        showToast('Save failed: ' + err.message, 'error');
    } finally {
        btn.disabled = false;
        btn.innerHTML = orig;
    }
});
</script>
