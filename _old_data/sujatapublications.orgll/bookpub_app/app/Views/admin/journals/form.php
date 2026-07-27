<?php $pageTitle = ($journal['id'] ?? false) ? 'Edit Journal' : 'Add Journal'; ?>

<style>
/* ── Form CSS Fallbacks if not globally defined ── */
.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151; /* text-gray-700 */
    margin-bottom: 0.5rem;
}
.form-input {
    width: 100%;
    border: 1px solid #e5e7eb; /* border-gray-200 */
    border-radius: 0.75rem; /* rounded-xl */
    padding: 0.625rem 1rem;
    font-size: 0.875rem;
    color: #1f2937;
    background-color: #ffffff;
    transition: all 0.2s ease-in-out;
}
.form-input:focus {
    outline: none;
    border-color: var(--primary, #5E9E63); /* Custom dynamic fallback */
    box-shadow: 0 0 0 3px rgba(94, 158, 99, 0.15);
}
</style>

<div class="flex items-center gap-3 mb-6">
    <a href="<?= BASE_URL ?>/admin/journals"
       class="text-gray-400 hover:text-primary transition p-2 rounded-lg hover:bg-gray-100">
        <i class="fas fa-arrow-left"></i>
    </a>
    <div>
        <h1 class="text-2xl font-serif font-bold text-primary"><?= $pageTitle ?></h1>
        <p class="text-gray-500 text-sm mt-0.5">Fill in the journal card details below.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2">
        <form id="journalForm" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
            <?= Security::csrfField() ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
                <div class="sm:col-span-2">
                    <label class="form-label">Journal Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required
                           value="<?= htmlspecialchars($journal['name'] ?? '') ?>"
                           class="form-input" placeholder="Full journal name">
                </div>
                <div>
                    <label class="form-label">Abbreviation / Short Name</label>
                    <input type="text" name="abbreviation"
                           value="<?= htmlspecialchars($journal['abbreviation'] ?? '') ?>"
                           class="form-input" placeholder="e.g. IJPDD">
                </div>
                <div>
                    <label class="form-label">ISSN (Optional)</label>
                    <input type="text" name="issn"
                           value="<?= htmlspecialchars($journal['issn'] ?? '') ?>"
                           class="form-input" placeholder="e.g. 2345-6789">
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label">Journal URL <span class="text-red-500">*</span></label>
                    <input type="url" name="journal_url" required
                           value="<?= htmlspecialchars($journal['journal_url'] ?? '') ?>"
                           class="form-input" placeholder="https://journal-url.com">
                    <p class="text-xs text-gray-400 mt-1.5 flex items-center gap-1">
                        <i class="fas fa-info-circle text-gray-400"></i> Users will be redirected here when they click "Visit Journal"
                    </p>
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label">Short Description</label>
                    <textarea name="description" rows="3" class="form-input resize-none"
                              placeholder="Brief description of the journal's focus area…"><?= htmlspecialchars($journal['description'] ?? '') ?></textarea>
                </div>
                <div>
                    <label class="form-label">Status</label>
                    <input type="hidden" name="is_active" value="0">
                    <label class="flex items-center gap-3 mt-3 cursor-pointer select-none">
                        <input type="checkbox" name="is_active" value="1"
                               <?= (!isset($journal['is_active']) || $journal['is_active']) ? 'checked' : '' ?>
                               class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary accent-primary">
                        <span class="text-sm text-gray-700 font-medium">Active (visible on website)</span>
                    </label>
                </div>
                <div>
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" min="0"
                           value="<?= htmlspecialchars($journal['sort_order'] ?? '0') ?>"
                           class="form-input" placeholder="0">
                </div>
            </div>

            <div class="mb-8">
                <label class="form-label">Journal Logo</label>
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-primary/50 transition duration-200 cursor-pointer relative bg-gray-50/50 hover:bg-white"
                     onclick="document.getElementById('logoInput').click()">
                    
                    <div id="logoPreviewWrap" class="<?= empty($journal['logo']) ? 'hidden' : '' ?>">
                        <img id="logoPreview"
                             src="<?= !empty($journal['logo']) ? uploadUrl('journals', $journal['logo']) : '' ?>"
                             class="max-h-28 mx-auto rounded-lg mb-3 object-contain mix-blend-multiply">
                        <p class="text-xs text-primary font-semibold">Click to change logo</p>
                    </div>
                    
                    <div id="logoPlaceholder" class="<?= !empty($journal['logo']) ? 'hidden' : '' ?>">
                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-300 mb-2 block"></i>
                        <p class="text-gray-600 text-sm font-medium">Click to upload logo</p>
                        <p class="text-gray-400 text-xs mt-1">PNG, JPG, SVG — Max 2MB</p>
                    </div>
                    <input type="file" id="logoInput" name="logo" accept="image/*" class="hidden">
                </div>
            </div>

            <div class="flex items-center gap-4 border-t border-gray-100 pt-6">
                <button type="submit"
                        class="bg-primary text-white px-6 sm:px-8 py-3 rounded-xl font-semibold hover:bg-primary-dark transition shadow-sm flex items-center gap-2 text-sm sm:text-base">
                    <i class="fas fa-save"></i>
                    <?= isset($journal['id']) ? 'Update Journal' : 'Add Journal' ?>
                </button>
                <a href="<?= BASE_URL ?>/admin/journals"
                   class="text-gray-500 hover:text-gray-700 font-semibold transition text-sm sm:text-base">Cancel</a>
            </div>
        </form>
    </div>

    <aside class="w-full">
        <div class="bg-blue-50/60 border border-blue-100 rounded-2xl p-6 sticky top-6">
            <h4 class="font-bold text-blue-900 mb-3 flex items-center gap-2">
                <i class="fas fa-lightbulb text-blue-500 text-lg"></i> Quick Guidelines
            </h4>
            <ul class="text-sm text-blue-800 space-y-2.5 leading-relaxed">
                <li class="flex items-start gap-2">
                    <span class="text-blue-500">•</span>
                    <span>Use a high-quality, transparent or clean background logo (square format works best).</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-blue-500">•</span>
                    <span>The acronym/abbreviation appears automatically below the core title.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-blue-500">•</span>
                    <span>Make sure the external target link contains proper secure protocol tags (`https://`).</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-blue-500">•</span>
                    <span>Toggling visibility immediately changes deployment state live on the homepage dashboard.</span>
                </li>
            </ul>
        </div>
    </aside>
</div>

<script>
// Live Interactive Image Preview Loader
document.getElementById('logoInput').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('logoPreview').src = e.target.result;
        document.getElementById('logoPreviewWrap').classList.remove('hidden');
        document.getElementById('logoPlaceholder').classList.add('hidden');
    };
    reader.readAsDataURL(file);
});

// Clean and Consistent AJAX Engine
document.getElementById('journalForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    try {
        const res  = await fetch('<?= BASE_URL ?>/admin/journals/<?= isset($journal['id']) ? 'edit/'.$journal['id'] : 'add' ?>', {
            method: 'POST', 
            body: new FormData(this)
        });
        const data = await res.json();
        
        showToast(data.message, data.success ? 'success' : 'error');
        
        // Redirect upon successful creation or modification back to the management panel
        if (data.success) {
            setTimeout(() => window.location.href = '<?= BASE_URL ?>/admin/journals', 1000);
        }
    } catch (error) {
        showToast('Something went wrong. Please try again.', 'error');
    }
});
</script>