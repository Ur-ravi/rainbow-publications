<?php
$t        = $t ?? $testimonial ?? [];
$isEdit   = !empty($t['id']);
$pageTitle = $isEdit ? 'Edit Testimonial' : 'Add Testimonial';

// Derive live letter for preview
$letter  = strtoupper(substr($t['avatar_letter'] ?? ($t['reviewer_name'] ?? 'U'), 0, 1));
$color   = $t['avatar_color'] ?? '#1e73be';
$rating  = (int)($t['rating'] ?? 5);
?>
<div class="flex items-center gap-3 mb-6">
    <a href="<?= BASE_URL ?>/admin/testimonials" class="text-gray-400 hover:text-primary p-2 rounded-xl hover:bg-gray-100 transition duration-200">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h1 class="text-2xl font-serif font-bold text-primary"><?= $pageTitle ?></h1>
</div>

<form id="testimonialForm" action="<?= BASE_URL ?>/admin/testimonials/<?= $isEdit ? 'update/'.$t['id'] : 'store' ?>" method="POST">
    <?= Security::csrfField() ?>

    <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h3 class="font-semibold text-gray-800 mb-5 text-base tracking-wide flex items-center gap-2">
                    <i class="fas fa-user text-gray-400"></i> Reviewer Details
                </h3>
                <div class="space-y-5">
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Reviewer Name <span class="text-red-500">*</span></label>
                            <input type="text" name="reviewer_name" id="nameInput" required
                                   value="<?= htmlspecialchars($t['reviewer_name'] ?? '') ?>"
                                   class="w-full px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition duration-200"
                                   placeholder="e.g. Dr. Lavanya Yaidikar">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Designation</label>
                            <input type="text" name="designation"
                                   value="<?= htmlspecialchars($t['designation'] ?? '') ?>"
                                   class="w-full px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition duration-200"
                                   placeholder="e.g. Associate Professor">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Organization / Affiliation</label>
                        <input type="text" name="organization"
                               value="<?= htmlspecialchars($t['organization'] ?? '') ?>"
                               class="w-full px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition duration-200"
                               placeholder="e.g. Delhi University">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h3 class="font-semibold text-gray-800 mb-5 text-base tracking-wide flex items-center gap-2">
                    <i class="fas fa-quote-right text-gray-400"></i> Review
                </h3>
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Review Content <span class="text-red-500">*</span></label>
                        <textarea name="content" rows="4" required
                                  class="w-full px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition duration-200 resize-y"
                                  placeholder="e.g. Excellent support system. The team was responsive…"><?= htmlspecialchars($t['content'] ?? '') ?></textarea>
                    </div>

                    <div class="grid sm:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Rating</label>
                            <select name="rating"
                                    class="w-full px-4 py-2.5 text-sm text-gray-800 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition duration-200">
                                <?php for($i=5;$i>=1;$i--): ?>
                                    <option value="<?= $i ?>" <?= $i === $rating ? 'selected' : '' ?>><?= $i ?> Star<?= $i>1?'s':'' ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Reviewer Activity</label>
                            <input type="text" name="review_count"
                                   value="<?= htmlspecialchars($t['review_count'] ?? '1 review') ?>"
                                   class="w-full px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition duration-200"
                                   placeholder="e.g. 3 reviews">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Date Label</label>
                            <input type="text" name="review_date"
                                   value="<?= htmlspecialchars($t['review_date'] ?? '') ?>"
                                   class="w-full px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition duration-200"
                                   placeholder="e.g. 2 months ago">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Source</label>
                        <input type="text" name="source"
                               value="<?= htmlspecialchars($t['source'] ?? 'Google') ?>"
                               class="w-full px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition duration-200"
                               placeholder="e.g. Google">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h3 class="font-semibold text-gray-800 mb-5 text-base tracking-wide flex items-center gap-2">
                    <i class="fas fa-palette text-gray-400"></i> Avatar
                </h3>
                <div class="grid sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Avatar Letter (1 character)</label>
                        <input type="text" name="avatar_letter" id="letterInput" maxlength="2"
                               value="<?= htmlspecialchars($t['avatar_letter'] ?? '') ?>"
                               class="w-full px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition duration-200"
                               placeholder="Auto from name">
                        <p class="text-xs text-gray-400 mt-1.5">Leave empty to auto-use first letter of the name.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Background Color</label>
                        <div class="flex items-center gap-3">
                            <input type="color" name="avatar_color" id="colorInput"
                                   value="<?= htmlspecialchars($color) ?>"
                                   class="h-11 w-14 p-1 rounded-xl border border-gray-200 cursor-pointer">
                            <input type="text" id="colorHex" value="<?= htmlspecialchars($color) ?>" readonly
                                   class="flex-1 px-4 py-2.5 text-sm text-gray-800 border border-gray-200 rounded-xl bg-gray-50 font-mono">
                        </div>
                        <p class="text-xs text-gray-400 mt-1.5">Suggested: #1e73be, #0f766e, #9333ea, #dc2626</p>
                    </div>
                </div>
            </div>

        </div>

        <aside class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4 text-sm tracking-wide flex items-center gap-2">
                    <i class="fas fa-eye text-gray-400"></i> Live Preview
                </h3>
                <div id="previewCard" class="border border-gray-200 rounded-2xl p-5 bg-white">
                    <div class="flex items-center gap-3 mb-3">
                        <div id="previewAvatar" class="w-11 h-11 rounded-full flex items-center justify-center text-white text-lg font-bold shadow-sm"
                             style="background: <?= htmlspecialchars($color) ?>">
                            <?= htmlspecialchars($letter ?: 'U') ?>
                        </div>
                        <div>
                            <p id="previewName" class="font-bold text-gray-900 text-sm leading-tight"><?= htmlspecialchars($t['reviewer_name'] ?? 'Reviewer Name') ?></p>
                            <p id="previewCount" class="text-xs text-gray-400 leading-tight"><?= htmlspecialchars($t['review_count'] ?? '1 review') ?></p>
                        </div>
                    </div>
                    <div id="previewStars" class="flex items-center gap-0.5 text-amber-400 text-sm mb-1.5">
                        <?php for($i=1;$i<=5;$i++): ?>
                            <i class="fas fa-star<?= $i <= $rating ? '' : ' text-gray-200' ?>"></i>
                        <?php endfor; ?>
                        <span id="previewDate" class="text-xs text-gray-400 ml-1.5"><?= htmlspecialchars($t['review_date'] ?? 'just now') ?></span>
                    </div>
                    <p id="previewContent" class="text-sm text-gray-700 leading-relaxed mt-2">
                        <?= htmlspecialchars($t['content'] ?? 'Your review text appears here.') ?>
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4 text-sm tracking-wide flex items-center gap-2">
                    <i class="fas fa-cog text-gray-400"></i> Display Options
                </h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Sort Order</label>
                        <input type="number" name="sort_order"
                               value="<?= htmlspecialchars($t['sort_order'] ?? 0) ?>"
                               class="w-full px-4 py-2.5 text-sm text-gray-800 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition duration-200">
                        <p class="text-xs text-gray-400 mt-1.5">Lower numbers appear first.</p>
                    </div>
                    <div>
                        <input type="hidden" name="is_active" value="0">
                        <label class="flex items-center gap-3 cursor-pointer p-3 rounded-xl border border-gray-200 hover:bg-gray-50/70 transition duration-200">
                            <input type="checkbox" name="is_active" value="1"
                                   <?= (!isset($t['is_active']) || $t['is_active']) ? 'checked' : '' ?>
                                   class="w-5 h-5 rounded accent-primary border-gray-300 text-primary cursor-pointer focus:ring-0 focus:ring-offset-0">
                            <span class="text-sm font-medium text-gray-700 select-none">Active (visible on site)</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <button type="submit"
                        class="w-full bg-primary hover:bg-primary-dark text-white py-3 px-4 rounded-xl font-semibold transition-all duration-200 flex items-center justify-center gap-2 shadow-sm hover:shadow-md">
                    <i class="fas fa-save"></i> <span><?= $isEdit ? 'Update Testimonial' : 'Create Testimonial' ?></span>
                </button>
                <a href="<?= BASE_URL ?>/admin/testimonials"
                   class="block text-center text-gray-500 hover:text-gray-700 hover:bg-gray-50 text-sm font-medium mt-3 transition duration-200 py-2.5 rounded-xl border border-transparent hover:border-gray-100">Cancel</a>
            </div>
        </aside>
    </div>
</form>

<script>
const $ = id => document.getElementById(id);
const nameInput  = $('nameInput');
const letterInput = $('letterInput');
const colorInput = $('colorInput');
const colorHex   = $('colorHex');
const ratingSel  = document.querySelector('select[name="rating"]');
const contentEl  = document.querySelector('textarea[name="content"]');
const countInput = document.querySelector('input[name="review_count"]');
const dateInput  = document.querySelector('input[name="review_date"]');

function updatePreview() {
    const name   = nameInput.value.trim() || 'Reviewer Name';
    const letter = (letterInput.value || name).charAt(0).toUpperCase();
    const color  = colorInput.value;
    const rating = parseInt(ratingSel.value || 5);

    $('previewName').textContent    = name;
    $('previewCount').textContent   = countInput.value || '1 review';
    $('previewDate').textContent    = dateInput.value || 'just now';
    $('previewContent').textContent = contentEl.value || 'Your review text appears here.';
    $('previewAvatar').textContent  = letter;
    $('previewAvatar').style.background = color;
    colorHex.value = color;

    $('previewStars').innerHTML = Array.from({length:5}, (_,i) =>
        `<i class="fas fa-star${i < rating ? '' : ' text-gray-200'}"></i>`
    ).join('') + `<span class="text-xs text-gray-400 ml-1.5">${dateInput.value || 'just now'}</span>`;
}

[nameInput, letterInput, contentEl, countInput, dateInput].forEach(el => el && el.addEventListener('input', updatePreview));
colorInput.addEventListener('input', updatePreview);
ratingSel.addEventListener('change', updatePreview);

document.getElementById('testimonialForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = this.querySelector('button[type="submit"]');
    const orig = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
    btn.disabled = true;
    try {
        const res = await fetch(this.action, { method: 'POST', body: new FormData(this) });
        const data = await res.json();
        showToast(data.message, data.success ? 'success' : 'error');
        if (data.success) {
            setTimeout(() => window.location.href = '<?= BASE_URL ?>/admin/testimonials', 1000);
        }
    } catch(e) {
        showToast('Error saving testimonial', 'error');
        console.error(e);
    }
    btn.innerHTML = orig;
    btn.disabled = false;
});
</script>
