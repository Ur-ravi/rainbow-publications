<?php
$isEdit    = !empty($membership['id']);
$pageTitle = $isEdit ? 'Edit Membership Plan' : 'Add Membership Plan';
?>
<div class="flex items-center gap-3 mb-6">
    <a href="<?= BASE_URL ?>/admin/memberships"
       class="text-gray-400 hover:text-primary transition p-2 rounded-lg hover:bg-gray-100">
        <i class="fas fa-arrow-left"></i>
    </a>
    <div>
        <h1 class="text-2xl font-serif font-bold text-primary"><?= $pageTitle ?></h1>
        <p class="text-gray-500 text-sm mt-0.5">Define a membership tier with price and benefits.</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2">
        <form id="memForm" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <?= Security::csrfField() ?>

            <div class="grid sm:grid-cols-2 gap-5 mb-6">
                <div class="sm:col-span-2">
                    <label class="form-label">Plan Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required
                           value="<?= htmlspecialchars($membership['name'] ?? '') ?>"
                           class="form-input" placeholder="e.g. Premium Member">
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label">Short Description</label>
                    <input type="text" name="description"
                           value="<?= htmlspecialchars($membership['description'] ?? '') ?>"
                           class="form-input" placeholder="Brief tagline shown on the card">
                </div>
                <div>
                    <label class="form-label">Price (in <?= getSetting('currency_symbol','₹') ?>) <span class="text-xs text-gray-400">(blank = Free)</span></label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-semibold">
                            <?= getSetting('currency_symbol','₹') ?>
                        </span>
                        <input type="number" name="price" step="0.01" min="0"
                               value="<?= htmlspecialchars($membership['price'] ?? '0') ?>"
                               class="form-input pl-8" placeholder="0.00">
                    </div>
                </div>
                <div>
                    <label class="form-label">Duration (months)</label>
                    <input type="number" name="duration_months" min="1"
                           value="<?= htmlspecialchars($membership['duration_months'] ?? '12') ?>"
                           class="form-input" placeholder="12">
                </div>
                <div>
                    <label class="form-label">Badge Colour</label>
                    <input type="color" name="badge_color"
                           value="<?= htmlspecialchars($membership['badge_color'] ?? '#0d3051') ?>"
                           class="form-input h-11 cursor-pointer p-1">
                </div>
                <div>
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" min="0"
                           value="<?= htmlspecialchars($membership['sort_order'] ?? '0') ?>"
                           class="form-input">
                </div>
            </div>

            <!-- Toggles -->
            <div class="grid sm:grid-cols-2 gap-4 mb-6">
                <label class="flex items-center gap-3 cursor-pointer bg-gray-50 px-4 py-3 rounded-xl border border-gray-200">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1"
                           <?= (!isset($membership['is_active']) || $membership['is_active']) ? 'checked' : '' ?>
                           class="w-5 h-5 rounded accent-secondary">
                    <span class="text-sm text-gray-700 font-medium">Active (visible on site)</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer bg-gray-50 px-4 py-3 rounded-xl border border-gray-200">
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" name="is_featured" value="1"
                           <?= !empty($membership['is_featured']) ? 'checked' : '' ?>
                           class="w-5 h-5 rounded accent-secondary">
                    <span class="text-sm text-gray-700 font-medium">Featured (★ Most Popular)</span>
                </label>
            </div>

            <!-- Features -->
            <div class="mb-6">
                <label class="form-label">Plan Features
                    <span class="text-xs font-normal text-gray-400 ml-2">(one per line)</span>
                </label>
                <textarea name="features" rows="8" class="form-input resize-none font-mono text-sm"
                          placeholder="Access to all books&#10;Priority email support&#10;Digital certificate&#10;Quarterly publications"><?php
$f = $membership['features'] ?? '';
if (is_string($f) && $f !== '' && $f[0] === '[') { $decoded = json_decode($f, true); if (is_array($decoded)) $f = implode("\n", $decoded); }
elseif (is_array($f)) { $f = implode("\n", $f); }
echo htmlspecialchars($f); ?></textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="bg-primary text-white px-8 py-3 rounded-xl font-semibold hover:bg-primary-dark transition flex items-center gap-2">
                    <i class="fas fa-save"></i> <?= $isEdit ? 'Update Plan' : 'Save Plan' ?>
                </button>
                <a href="<?= BASE_URL ?>/admin/memberships" class="text-gray-500 hover:text-gray-700 font-medium py-3 transition">Cancel</a>
            </div>
        </form>
    </div>

    <aside>
        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6">
            <h4 class="font-semibold text-blue-800 mb-3 flex items-center gap-2">
                <i class="fas fa-lightbulb text-blue-500"></i> Tips
            </h4>
            <ul class="text-sm text-blue-700 space-y-2">
                <li>• Mark exactly <strong>one</strong> plan as Featured</li>
                <li>• Use whole months for the duration (12 = 1 year)</li>
                <li>• Features are shown as a checklist with ✓ icons</li>
                <li>• Drag plan cards on the list to reorder</li>
            </ul>
        </div>
    </aside>
</div>

<script>
document.getElementById('memForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const action = '<?= BASE_URL ?>/admin/memberships/<?= $isEdit ? 'edit/'.$membership['id'] : 'add' ?>';
    const res    = await fetch(action, { method:'POST', body: new FormData(this) });
    const data   = await res.json();
    showToast(data.message, data.success ? 'success' : 'error');
    if (data.success) {
        setTimeout(() => window.location.href = '<?= BASE_URL ?>/admin/memberships', 1000);
    }
});
</script>
