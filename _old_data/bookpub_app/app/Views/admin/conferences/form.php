<?php
$isEdit    = !empty($conference['id']);
$pageTitle = $isEdit ? 'Edit Conference' : 'Add Conference';
$c         = $conference ?? [];
?>

<style>
    /* Custom CSS components to match your form classes */
    .form-label {
        display: block;
        font-size: 0.875rem; /* 14px */
        font-weight: 500;
        color: #374151; /* gray-700 */
        margin-bottom: 0.375rem; /* 6px */
    }

    .form-input {
        display: block;
        width: 100%;
        border-radius: 0.75rem; /* 12px */
        border: 1px solid #e5e7eb; /* gray-200 */
        padding: 0.625rem 0.875rem;
        font-size: 0.95rem;
        color: #1f2937; /* gray-800 */
        background-color: #ffffff;
        transition: all 0.2s ease-in-out;
    }

    .form-input:focus {
        outline: none;
        border-color: #1e3a8a; /* Custom Primary color on focus */
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
    }

    .form-input::placeholder {
        color: #9ca3af; /* gray-400 */
    }

    /* Fallback framework theme custom colors (if not defined in your tailwind.config.js) */
    .text-primary { color: #1e3a8a; }
    .bg-primary { background-color: #1e3a8a; }
    .hover\:bg-primary-dark:hover { background-color: #172554; }
    .accent-secondary { accent-color: #f59e0b; } /* Amber accent for checkboxes */

    /* Animation for the form spinner */
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .fa-spin {
        animation: spin 1s linear infinite;
    }
</style>

<div class="flex items-center gap-3 mb-6">
    <a href="<?= BASE_URL ?>/admin/conferences"
       class="text-gray-400 hover:text-primary p-2 rounded-lg hover:bg-gray-100 transition">
        <i class="fas fa-arrow-left"></i>
    </a>
    <div>
        <h1 class="text-2xl font-serif font-bold text-primary"><?= $pageTitle ?></h1>
        <p class="text-gray-500 text-sm mt-0.5">All fields on the conference detail page are configurable here.</p>
    </div>
</div>

<form id="confForm" enctype="multipart/form-data">
    <?= Security::csrfField() ?>

    <div class="grid lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-info-circle text-primary"></i> Basics
                </h3>
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" required
                               value="<?= htmlspecialchars($c['title'] ?? '') ?>"
                               class="form-input"
                               placeholder="One-Day International Conference">
                    </div>
                    <div>
                        <label class="form-label">Subtitle <span class="text-xs text-gray-400 font-normal">(the small line above the theme)</span></label>
                        <input type="text" name="subtitle"
                               value="<?= htmlspecialchars($c['subtitle'] ?? '') ?>"
                               class="form-input"
                               placeholder="Theme &amp; Organization">
                    </div>
                    <div>
                        <label class="form-label">Theme &amp; Organization Text</label>
                        <textarea name="theme_organization" rows="5"
                                  class="form-input resize-none"
                                  placeholder="Research, Development and Innovation in Health Care...&#10;&amp;&#10;National Education Policy Cell, Department of..."><?= htmlspecialchars($c['theme_organization'] ?? '') ?></textarea>
                        <p class="text-xs text-gray-400 mt-1">Line breaks are preserved.</p>
                    </div>
                    <div>
                        <label class="form-label">Intro Paragraph</label>
                        <textarea name="intro_paragraph" rows="4"
                                  class="form-input resize-none"
                                  placeholder="This international conference offers a unique opportunity for..."><?= htmlspecialchars($c['intro_paragraph'] ?? '') ?></textarea>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Conference Date</label>
                            <input type="date" name="conference_date"
                                   value="<?= htmlspecialchars($c['conference_date'] ?? '') ?>"
                                   class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Slug <span class="text-xs text-gray-400 font-normal">(auto-generated if blank)</span></label>
                            <input type="text" name="slug"
                                   value="<?= htmlspecialchars($c['slug'] ?? '') ?>"
                                   class="form-input font-mono text-sm"
                                   placeholder="one-day-international-conference">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-image text-primary"></i> Conference Poster
                </h3>
                <?php if (!empty($c['poster_image'])): ?>
                <div class="mb-4 p-3 bg-gray-50 rounded-xl border border-gray-100 flex items-center gap-4">
                    <img src="<?= uploadUrl('conferences', $c['poster_image']) ?>" class="h-24 rounded-lg shadow-sm">
                    <div>
                        <p class="text-sm font-medium text-gray-700">Current poster</p>
                        <p class="text-xs text-gray-400 mt-1">Upload a new image below to replace it.</p>
                    </div>
                </div>
                <?php endif; ?>
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center cursor-pointer hover:border-primary transition"
                     onclick="document.getElementById('posterInput').click()">
                    <input type="file" id="posterInput" name="poster_image" accept="image/*" class="hidden" onchange="previewPoster(this)">
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-300 mb-2 block"></i>
                    <p class="text-sm font-medium text-gray-500">Click to upload poster image</p>
                    <p class="text-xs text-gray-400 mt-1">PNG / JPG / WebP — Recommended ratio 3:4</p>
                    <img id="posterPreview" class="hidden mt-3 max-h-48 mx-auto rounded-xl border p-1 bg-white">
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-file-pdf text-primary"></i> Conference Brochure (PDF)
                </h3>
                <?php if (!empty($c['conference_brochure'])): ?>
                <div class="mb-4 p-3 bg-gray-50 rounded-xl border border-gray-100 flex items-center gap-4">
                    <i class="fas fa-file-pdf text-3xl text-red-500"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-700 truncate"><?= htmlspecialchars(basename($c['conference_brochure'])) ?></p>
                        <p class="text-xs text-gray-400 mt-0.5">Upload a new PDF below to replace it.</p>
                    </div>
                    <button type="button" id="removeBrochureBtn"
                            class="text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-1.5 rounded-lg text-sm font-medium transition flex items-center gap-1.5"
                            onclick="removeBrochure()">
                        <i class="fas fa-trash-alt text-xs"></i> Remove
                    </button>
                    <input type="hidden" name="remove_brochure" id="removeBrochureInput" value="0">
                </div>
                <?php endif; ?>
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center cursor-pointer hover:border-primary transition"
                     onclick="document.getElementById('brochureInput').click()">
                    <input type="file" id="brochureInput" name="conference_brochure" accept="application/pdf" class="hidden" onchange="previewBrochure(this)">
                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-300 mb-2 block"></i>
                    <p class="text-sm font-medium text-gray-500"><?= !empty($c['conference_brochure']) ? 'Click to replace brochure PDF' : 'Click to upload brochure PDF' ?></p>
                    <p class="text-xs text-gray-400 mt-1">PDF only — Max 10 MB</p>
                    <p id="brochureName" class="text-xs text-green-600 font-medium mt-2 hidden"></p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-ticket-alt text-primary"></i> Registration
                </h3>
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Registration Link</label>
                        <input type="url" name="registration_link"
                               value="<?= htmlspecialchars($c['registration_link'] ?? '') ?>"
                               class="form-input font-mono text-sm"
                               placeholder="https://forms.gle/...">
                    </div>
                    <div>
                        <label class="form-label">Registration Fee</label>
                        <input type="text" name="registration_fee"
                               value="<?= htmlspecialchars($c['registration_fee'] ?? '') ?>"
                               class="form-input"
                               placeholder="Rs. 400/- Only (For all types of categories)">
                    </div>
                    <div>
                        <label class="form-label">What Registration Includes <span class="text-xs text-gray-400 font-normal">(one per line)</span></label>
                        <textarea name="registration_includes" rows="5"
                                  class="form-input resize-none"
                                  placeholder="Conference Kit&#10;Participation Certificate&#10;Oral/Poster Presentation Certificate&#10;Hospitality and Lunch during Conference"><?= htmlspecialchars($c['registration_includes'] ?? '') ?></textarea>
                    </div>
                    <div>
                        <label class="form-label">Seats Info</label>
                        <input type="text" name="seats_info"
                               value="<?= htmlspecialchars($c['seats_info'] ?? '') ?>"
                               class="form-input"
                               placeholder="Limited seats: Registration on a First-Come, First-Served Basis">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-file-alt text-primary"></i> Abstract Submission
                </h3>
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Abstract Submission Email</label>
                        <input type="email" name="abstract_email"
                               value="<?= htmlspecialchars($c['abstract_email'] ?? '') ?>"
                               class="form-input"
                               placeholder="internationalconference.office@gmail.com">
                    </div>
                    <div>
                        <label class="form-label">Abstract Submission Info</label>
                        <textarea name="abstract_info" rows="3"
                                  class="form-input resize-none"
                                  placeholder="Kindly send abstracts through only email to..."><?= htmlspecialchars($c['abstract_info'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-trophy text-primary"></i> Prizes
                </h3>
                <p class="text-xs text-gray-500 mb-4">Top three presentations will be awarded Cash Prizes, Trophy &amp; Certificate</p>
                <div class="grid sm:grid-cols-3 gap-4">
                    <div>
                        <label class="form-label">🏆 First Prize</label>
                        <input type="text" name="prize_first"
                               value="<?= htmlspecialchars($c['prize_first'] ?? '') ?>"
                               class="form-input" placeholder="Rs. 2000/-">
                    </div>
                    <div>
                        <label class="form-label">🥈 Second Prize</label>
                        <input type="text" name="prize_second"
                               value="<?= htmlspecialchars($c['prize_second'] ?? '') ?>"
                               class="form-input" placeholder="Rs. 1500/-">
                    </div>
                    <div>
                        <label class="form-label">🥉 Third Prize</label>
                        <input type="text" name="prize_third"
                               value="<?= htmlspecialchars($c['prize_third'] ?? '') ?>"
                               class="form-input" placeholder="Rs. 1000/-">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-medal text-primary"></i> Award Categories
                </h3>
                <textarea name="award_categories" rows="4"
                          class="form-input resize-none"
                          placeholder="Award Registration Charges: Conference Registration Fee + Rs. 800/- only.&#10;Interested candidates must send their updated CV to: ..."><?= htmlspecialchars($c['award_categories'] ?? '') ?></textarea>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-address-card text-primary"></i> Organizing Committee Contact
                </h3>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Phone Numbers</label>
                        <input type="text" name="contact_phone"
                               value="<?= htmlspecialchars($c['contact_phone'] ?? '') ?>"
                               class="form-input font-mono text-sm"
                               placeholder="+91-9759331509, +91-9358211655">
                    </div>
                    <div>
                        <label class="form-label">Contact Email</label>
                        <input type="email" name="contact_email"
                               value="<?= htmlspecialchars($c['contact_email'] ?? '') ?>"
                               class="form-input"
                               placeholder="internationalconference.office@gmail.com">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-700 mb-4 flex items-center gap-2">
                    <i class="fas fa-search text-primary"></i> SEO <span class="text-xs text-gray-400 font-normal">(optional)</span>
                </h3>
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Meta Title</label>
                        <input type="text" name="meta_title"
                               value="<?= htmlspecialchars($c['meta_title'] ?? '') ?>"
                               class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Meta Description</label>
                        <textarea name="meta_description" rows="2" class="form-input resize-none"><?= htmlspecialchars($c['meta_description'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>

        </div>

        <aside class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <button type="submit" id="saveBtn"
                        class="w-full bg-primary text-white py-3 rounded-xl font-semibold hover:bg-primary-dark transition flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i> <?= $isEdit ? 'Update Conference' : 'Save Conference' ?>
                </button>
                <a href="<?= BASE_URL ?>/admin/conferences"
                   class="w-full mt-2 inline-block text-center text-gray-500 hover:text-gray-700 font-medium py-2 transition">Cancel</a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                <h3 class="font-semibold text-gray-700">Settings</h3>
                <div>
                    <label class="form-label">Status</label>
                    <input type="hidden" name="is_active" value="0">
                    <label class="flex items-center gap-3 mt-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1"
                               <?= (!isset($c['is_active']) || $c['is_active']) ? 'checked' : '' ?>
                               class="w-5 h-5 rounded accent-secondary">
                        <span class="text-sm text-gray-700">Active (visible on site)</span>
                    </label>
                </div>
                <div>
                    <label class="form-label">Show on Homepage</label>
                    <input type="hidden" name="is_featured" value="0">
                    <label class="flex items-center gap-3 mt-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1"
                               id="isFeaturedCheckbox"
                               <?= !empty($c['is_featured']) ? 'checked' : '' ?>
                               class="w-5 h-5 rounded accent-secondary">
                        <span class="text-sm text-gray-700">Feature on home page (overrides auto-selection)</span>
                    </label>
                    <p class="text-xs text-gray-400 mt-1">When enabled, this conference will be shown on the homepage regardless of date. Only one should be featured at a time.</p>
                </div>
                <div>
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" min="0"
                           value="<?= htmlspecialchars($c['sort_order'] ?? '0') ?>"
                           class="form-input">
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5">
                <h4 class="font-semibold text-blue-800 mb-2 flex items-center gap-2 text-sm">
                    <i class="fas fa-lightbulb text-blue-500"></i> How it appears
                </h4>
                <ul class="text-xs text-blue-700 space-y-2 leading-relaxed">
                    <li>• If you check <strong>"Feature on home page"</strong>, this conference will be shown on the home page.</li>
                    <li>• If no conference is featured, the <strong>most recent upcoming active conference</strong> is shown.</li>
                    <li>• Older conferences automatically move to the <strong>/conferences</strong> ("View All") page.</li>
                    <li>• Set <strong>Conference Date</strong> to control which one is "newest".</li>
                </ul>
            </div>
        </aside>

    </div>
</form>

<script>
function previewPoster(input) {
    const file = input.files[0]; if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const p = document.getElementById('posterPreview');
        p.src = e.target.result;
        p.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
}

function previewBrochure(input) {
    const file = input.files[0]; if (!file) return;
    const nameEl = document.getElementById('brochureName');
    nameEl.textContent = 'Selected: ' + file.name;
    nameEl.classList.remove('hidden');
}

function removeBrochure() {
    document.getElementById('removeBrochureInput').value = '1';
    document.getElementById('brochureInput').value = '';
    document.getElementById('brochureName').classList.add('hidden');
    // Visually hide the existing brochure display
    const btn = document.getElementById('removeBrochureBtn');
    if (btn) btn.closest('.p-3').innerHTML = '<p class="text-sm text-gray-500">Brochure will be removed on save.</p>';
}

document.getElementById('confForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = document.getElementById('saveBtn');
    const orig = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

    const action = '<?= BASE_URL ?>/admin/conferences/<?= $isEdit ? "edit/".$c['id'] : "add" ?>';
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
    } catch(err) {
        console.error(err);
        showToast('Save failed: ' + err.message, 'error');
    } finally {
        btn.disabled = false;
        btn.innerHTML = orig;
    }
});
</script>