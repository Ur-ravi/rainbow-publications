<?php
$journals    = $journals ?? [];
$preselected = $preselected ?? null;
$siteName    = getSetting('site_name', 'Rainbow Publications');

$sections = [
    'Article Text',
    'Research Article',
    'Review Article',
    'Short Communication',
    'Case Study',
    'Editorial',
    'Letter to the Editor',
    'Original Research',
    'Mini Review',
    'Perspective',
];
?>

<!-- HERO -->
<?php
$pageTitle = 'Submit Your Article';
$heroCrumbs = [['label' => 'Journals', 'url' => BASE_URL . '/journals']];
$heroIntro = 'Share your research with our peer-reviewed journals. Fill the form below and our editorial team will review your submission.';
$heroSize = 'md';
include __DIR__ . '/../partials/hero.php';
?>

<section class="py-10 md:py-14" style="background:#F8FAFC;">
<div class="container mx-auto px-4 max-w-5xl">

<form id="articleForm" action="<?= BASE_URL ?>/articles/submit" method="POST" enctype="multipart/form-data" class="space-y-6">
    <?= Security::csrfField() ?>

    <!-- Section 1: Journal Selection -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3" style="background: linear-gradient(135deg, #0D2D57, #2563EB);">
            <span class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-sm font-extrabold" style="color:#0D2D57;">1</span>
            <h2 class="text-white font-bold text-lg">Journal Selection</h2>
        </div>
        <div class="p-6">
            <label class="form-label">Select Journal <span class="text-red-500">*</span></label>
            <select name="journal_id" required class="form-input">
                <option value="">— Select a journal —</option>
                <?php foreach ($journals as $j): ?>
                <option value="<?= (int)$j['id'] ?>" <?= ($preselected && (int)$preselected['id'] === (int)$j['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($j['name']) ?><?= !empty($j['abbreviation']) ? ' (' . htmlspecialchars($j['abbreviation']) . ')' : '' ?>
                </option>
                <?php endforeach; ?>
            </select>
            <p class="text-xs text-gray-500 mt-2">All active journals are loaded automatically. New journals added via admin appear here.</p>
        </div>
    </div>

    <!-- Section 2: Article Information -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3" style="background: linear-gradient(135deg, #0D2D57, #2563EB);">
            <span class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-sm font-extrabold" style="color:#0D2D57;">2</span>
            <h2 class="text-white font-bold text-lg">Article Information</h2>
        </div>
        <div class="p-6 space-y-5">
            <div>
                <label class="form-label">Cover Image <span class="text-gray-400 font-normal">(optional)</span></label>
                <input type="file" name="cover_image" accept="image/*" class="form-input" id="coverInput">
                <img id="coverPreview" class="hidden mt-2 w-32 h-32 object-cover rounded-xl border-2 border-gray-200">
            </div>

            <div>
                <label class="form-label">Section <span class="text-red-500">*</span></label>
                <select name="section" required class="form-input">
                    <option value="">— Select article section —</option>
                    <?php foreach ($sections as $sec): ?>
                    <option value="<?= htmlspecialchars($sec) ?>"><?= htmlspecialchars($sec) ?></option>
                    <?php endforeach; ?>
                </select>
                <p class="text-xs text-gray-500 mt-1">Submissions must be made to one of the journal&#39;s sections.</p>
            </div>

            <div class="grid sm:grid-cols-4 gap-4">
                <div class="sm:col-span-1">
                    <label class="form-label">Prefix</label>
                    <input type="text" name="prefix" class="form-input" placeholder="A, The">
                </div>
                <div class="sm:col-span-3">
                    <label class="form-label">Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" required maxlength="500" class="form-input">
                </div>
            </div>

            <div>
                <label class="form-label">Subtitle</label>
                <input type="text" name="subtitle" maxlength="500" class="form-input">
            </div>

            <div>
                <label class="form-label">Abstract <span class="text-red-500">*</span></label>
                <!-- Lightweight rich text via contenteditable + minimal toolbar -->
                <div class="border-2 border-gray-200 rounded-xl overflow-hidden">
                    <div class="bg-gray-50 border-b border-gray-200 p-2 flex flex-wrap gap-1 text-xs">
                        <button type="button" onclick="rtFormat('bold')" class="px-2.5 py-1.5 rounded hover:bg-white border border-transparent hover:border-gray-200 font-bold" title="Bold (Ctrl+B)">B</button>
                        <button type="button" onclick="rtFormat('italic')" class="px-2.5 py-1.5 rounded hover:bg-white border border-transparent hover:border-gray-200 italic" title="Italic (Ctrl+I)">I</button>
                        <button type="button" onclick="rtFormat('underline')" class="px-2.5 py-1.5 rounded hover:bg-white border border-transparent hover:border-gray-200 underline" title="Underline">U</button>
                        <span class="border-l border-gray-300 mx-1"></span>
                        <button type="button" onclick="rtFormat('insertUnorderedList')" class="px-2.5 py-1.5 rounded hover:bg-white border border-transparent hover:border-gray-200" title="Bullet list"><i class="fas fa-list-ul"></i></button>
                        <button type="button" onclick="rtFormat('insertOrderedList')" class="px-2.5 py-1.5 rounded hover:bg-white border border-transparent hover:border-gray-200" title="Numbered list"><i class="fas fa-list-ol"></i></button>
                        <span class="border-l border-gray-300 mx-1"></span>
                        <button type="button" onclick="rtFormat('superscript')" class="px-2.5 py-1.5 rounded hover:bg-white border border-transparent hover:border-gray-200" title="Superscript">x²</button>
                        <button type="button" onclick="rtFormat('subscript')" class="px-2.5 py-1.5 rounded hover:bg-white border border-transparent hover:border-gray-200" title="Subscript">x₂</button>
                        <span class="border-l border-gray-300 mx-1"></span>
                        <button type="button" onclick="rtLink()" class="px-2.5 py-1.5 rounded hover:bg-white border border-transparent hover:border-gray-200" title="Insert link"><i class="fas fa-link"></i></button>
                        <button type="button" onclick="rtFormat('removeFormat')" class="px-2.5 py-1.5 rounded hover:bg-white border border-transparent hover:border-gray-200" title="Clear formatting"><i class="fas fa-eraser"></i></button>
                    </div>
                    <div id="abstractEditor" contenteditable="true"
                         class="px-4 py-3 min-h-[160px] focus:outline-none text-sm leading-relaxed"
                         data-placeholder="Write your abstract here…"></div>
                </div>
                <input type="hidden" name="abstract" id="abstractInput">
                <p class="text-xs text-gray-500 mt-1">Recommended: 150–300 words. Use formatting for emphasis sparingly.</p>
            </div>

            <div>
                <label class="form-label">Keywords</label>
                <div id="keywordsBox" class="border-2 border-gray-200 rounded-xl px-3 py-2 flex flex-wrap gap-2 min-h-[48px] cursor-text" onclick="document.getElementById('keywordInput').focus()">
                    <input type="text" id="keywordInput" class="outline-none text-sm flex-1 min-w-[120px] bg-transparent" placeholder="Add a keyword and press Enter or comma">
                </div>
                <input type="hidden" name="keywords" id="keywordsField" value="[]">
                <p class="text-xs text-gray-500 mt-1">Press Enter or comma after each keyword. Click × to remove.</p>
            </div>
        </div>
    </div>

    <!-- Section 3: Contributors -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between" style="background: linear-gradient(135deg, #0D2D57, #2563EB);">
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-sm font-extrabold" style="color:#0D2D57;">3</span>
                <h2 class="text-white font-bold text-lg">Contributors <span class="text-white/70 text-sm font-normal">(authors)</span></h2>
            </div>
            <button type="button" onclick="addContributor()" class="bg-white/20 hover:bg-white/30 text-white px-3 py-1.5 rounded-lg text-sm font-semibold flex items-center gap-1.5 transition">
                <i class="fas fa-plus text-xs"></i> Add Contributor
            </button>
        </div>
        <div class="p-6">
            <div id="contributorsList" class="space-y-3">
                <!-- contributor rows are added by JS -->
            </div>
            <div id="contributorsEmpty" class="text-center py-8 text-gray-400 border-2 border-dashed border-gray-200 rounded-xl">
                <i class="fas fa-users text-3xl mb-2 block opacity-50"></i>
                <p class="text-sm">No contributors yet. Click <strong>Add Contributor</strong> above.</p>
            </div>
            <input type="hidden" name="contributors" id="contributorsField" value="[]">
        </div>
    </div>

    <!-- Section 4: Files -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3" style="background: linear-gradient(135deg, #0D2D57, #2563EB);">
            <span class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-sm font-extrabold" style="color:#0D2D57;">4</span>
            <h2 class="text-white font-bold text-lg">Article Files</h2>
        </div>
        <div class="p-6">
            <label for="articleFiles" class="block border-2 border-dashed border-gray-200 rounded-xl p-6 text-center cursor-pointer hover:border-primary hover:bg-primary/5 transition" id="fileDropArea">
                <input type="file" name="article_files[]" id="articleFiles" multiple accept=".pdf,.doc,.docx" class="hidden">
                <i class="fas fa-cloud-upload-alt text-4xl text-gray-300 mb-2 block"></i>
                <p class="text-sm font-bold text-gray-700">Click to upload article files</p>
                <p class="text-xs text-gray-500 mt-1">PDF, DOC, DOCX — multiple files allowed</p>
            </label>
            <div id="filesList" class="mt-3 space-y-2"></div>
        </div>
    </div>

    <!-- Section 5: Submitter Contact Person -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3" style="background: linear-gradient(135deg, #0D2D57, #2563EB);">
            <span class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-sm font-extrabold" style="color:#0D2D57;">5</span>
            <h2 class="text-white font-bold text-lg">Contact Person</h2>
        </div>
        <div class="p-6">
            <p class="text-xs text-gray-500 mb-4">We&#39;ll send the review outcome and any clarification requests to this contact.</p>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="submitter_name" required class="form-input">
                </div>
                <div>
                    <label class="form-label">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="submitter_email" required class="form-input">
                </div>
                <div>
                    <label class="form-label">Affiliation / Organization <span class="text-red-500">*</span></label>
                    <input type="text" name="submitter_affiliation" required class="form-input" placeholder="University, College, Company">
                </div>
                <div>
                    <label class="form-label">Mobile Number <span class="text-red-500">*</span></label>
                    <input type="tel" name="submitter_mobile" required class="form-input">
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-wrap gap-3 justify-end">
        <a href="<?= BASE_URL ?>/journals" class="px-5 py-3 rounded-xl border-2 border-gray-200 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition flex items-center gap-2">
            <i class="fas fa-times"></i> Cancel
        </a>
        <button type="button" onclick="submitForm('draft')" class="px-5 py-3 rounded-xl border-2 border-primary text-primary font-semibold text-sm hover:bg-primary hover:text-white transition flex items-center gap-2">
            <i class="fas fa-save"></i> Save Draft
        </button>
        <button type="button" onclick="submitForm('submitted')" id="submitBtn"
                class="px-6 py-3 rounded-xl text-white font-bold text-sm shadow-md hover:shadow-lg transition-all active:scale-[0.98] flex items-center gap-2"
                style="background: linear-gradient(135deg, #0D2D57, #2563EB);">
            <i class="fas fa-paper-plane"></i> Submit Article
        </button>
    </div>
</form>

</div>
</section>

<script>
// =============================================================
// SUBMIT ARTICLE WIZARD
// =============================================================

// Global state - initialize immediately
const KEYWORD_COLORS = ['#E6F1FB', '#EAF3DE', '#FAEEDA', '#FAECE7', '#E1F5EE', '#FBF0E6'];
let keywords = [];
let contributors = [];
let articleFiles = [];

// Global error handler for debugging (catch any script errors)
window.onerror = function(msg, url, lineNo, columnNo, error) {
    console.error('Global JS Error:', msg, 'at line', lineNo);
    // Only show toast if function exists
    if (typeof showToast !== 'undefined' && document.getElementById('toast')) {
        showToast('Error: ' + msg + ' (line ' + lineNo + ')', 'error');
    }
    return false;
};

console.log('Article submit script loaded');

// Functions (must be global for onclick handlers)
function rtFormat(cmd) { document.execCommand(cmd, false, null); document.getElementById('abstractEditor').focus(); }
function rtLink() {
    const url = prompt('Link URL:', 'https://');
    if (url) document.execCommand('createLink', false, url);
}

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM ready - attaching listeners');

    // ---- Cover image preview ----
    const coverInput = document.getElementById('coverInput');
    if (coverInput) {
        coverInput.addEventListener('change', e => {
            const f = e.target.files[0]; if (!f) return;
            const r = new FileReader();
            r.onload = ev => {
                const p = document.getElementById('coverPreview');
                if (p) {
                    p.src = ev.target.result;
                    p.classList.remove('hidden');
                }
            };
            r.readAsDataURL(f);
        });
    } else {
        console.error('coverInput not found');
    }

    // ---- Placeholder behavior ----
    const ed = document.getElementById('abstractEditor');
    const updatePlaceholder = () => {
        if (ed.textContent.trim().length === 0) {
            ed.classList.add('show-placeholder');
        } else {
            ed.classList.remove('show-placeholder');
        }
    };
    ed.addEventListener('input', updatePlaceholder);
    ed.addEventListener('blur', updatePlaceholder);
    updatePlaceholder();
});

// ---- Attach page-load event listeners (after DOM is ready) ----
// Note: These listeners can run at script-execute time because the script
// is at the bottom of the page and the DOM is already loaded.
const kwInput = document.getElementById('keywordInput');
if (kwInput) {
    kwInput.addEventListener('keydown', e => {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            addKeyword(e.target.value);
            e.target.value = '';
        } else if (e.key === 'Backspace' && !e.target.value && keywords.length) {
            keywords.pop(); renderKeywords();
        }
    });
}

const fileDropArea = document.getElementById('fileDropArea');
if (fileDropArea) {
    fileDropArea.addEventListener('click', e => {
        if (e.target.tagName !== 'INPUT') document.getElementById('articleFiles').click();
    });
}

const articleFilesInput = document.getElementById('articleFiles');
if (articleFilesInput) {
    articleFilesInput.addEventListener('change', e => {
        Array.from(e.target.files).forEach(f => articleFiles.push(f));
        renderFiles();
    });
}
function addKeyword(text) {
    text = text.trim().replace(/,$/, '');
    if (!text || keywords.includes(text)) return;
    keywords.push(text);
    renderKeywords();
}
function removeKeyword(idx) { keywords.splice(idx, 1); renderKeywords(); }
function renderKeywords() {
    const box = document.getElementById('keywordsBox');
    if (!box) return;
    box.querySelectorAll('.kw-tag').forEach(el => el.remove());
    keywords.forEach((kw, i) => {
        const tag = document.createElement('span');
        tag.className = 'kw-tag inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold';
        tag.style.background = KEYWORD_COLORS[i % KEYWORD_COLORS.length];
        tag.style.color = '#0D2D57';
        tag.innerHTML = `<span>${escapeHtml(kw)}</span><button type="button" class="hover:text-red-500" onclick="removeKeyword(${i})">×</button>`;
        box.insertBefore(tag, document.getElementById('keywordInput'));
    });
    const kwField = document.getElementById('keywordsField');
    if (kwField) kwField.value = JSON.stringify(keywords);
}

// Initialize keyword input listener (moved inside DOMContentLoaded above)


// ---- Contributors ----
function addContributor(data = {}) {
    contributors.push({
        name: data.name || '',
        affiliation: data.affiliation || '',
        email: data.email || '',
        phone: data.phone || '',
        role: data.role || 'Author'
    });
    renderContributors();
}
function removeContributor(idx) { contributors.splice(idx, 1); renderContributors(); }
function updateContributor(idx, field, value) {
    if (contributors[idx]) {
        contributors[idx][field] = value;
        document.getElementById('contributorsField').value = JSON.stringify(contributors);
    }
}
function renderContributors() {
    const list = document.getElementById('contributorsList');
    const empty = document.getElementById('contributorsEmpty');
    list.innerHTML = '';
    if (contributors.length === 0) {
        empty.classList.remove('hidden');
    } else {
        empty.classList.add('hidden');
    }
    contributors.forEach((c, i) => {
        const row = document.createElement('div');
        row.className = 'border-2 border-gray-200 rounded-xl p-4 bg-gray-50/30 relative';
        row.innerHTML = `
            <div class="flex items-center justify-between mb-3">
                <h4 class="font-bold text-sm text-gray-700"><i class="fas fa-user-circle text-primary mr-1"></i> Contributor #${i + 1}</h4>
                <button type="button" onclick="removeContributor(${i})" class="text-red-400 hover:text-red-600 text-sm" title="Remove">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            <div class="grid sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" required value="${escapeHtml(c.name)}" oninput="updateContributor(${i}, 'name', this.value)" class="form-input text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Affiliation / Organization <span class="text-red-500">*</span></label>
                    <input type="text" required value="${escapeHtml(c.affiliation)}" oninput="updateContributor(${i}, 'affiliation', this.value)" class="form-input text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Email <span class="text-red-500">*</span></label>
                    <input type="email" required value="${escapeHtml(c.email)}" oninput="updateContributor(${i}, 'email', this.value)" class="form-input text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Mobile <span class="text-red-500">*</span></label>
                    <input type="tel" required value="${escapeHtml(c.phone)}" oninput="updateContributor(${i}, 'phone', this.value)" class="form-input text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">Role</label>
                    <select onchange="updateContributor(${i}, 'role', this.value)" class="form-input text-sm">
                        ${['Author', 'Co-Author', 'Corresponding Author', 'Editor'].map(r =>
                            `<option value="${r}" ${c.role === r ? 'selected' : ''}>${r}</option>`).join('')}
                    </select>
                </div>
            </div>
        `;
        list.appendChild(row);
    });
    document.getElementById('contributorsField').value = JSON.stringify(contributors);
}

// ---- Files ----
// File event listeners are attached inside DOMContentLoaded (above)
function removeFile(idx) {
    articleFiles.splice(idx, 1);
    // Sync the actual file input
    const dt = new DataTransfer();
    articleFiles.forEach(f => dt.items.add(f));
    document.getElementById('articleFiles').files = dt.files;
    renderFiles();
}
function renderFiles() {
    const wrap = document.getElementById('filesList');
    wrap.innerHTML = '';
    articleFiles.forEach((f, i) => {
        const ext  = (f.name.split('.').pop() || '').toLowerCase();
        const icon = ext === 'pdf' ? 'fa-file-pdf text-red-500' :
                    (['doc','docx'].includes(ext) ? 'fa-file-word text-blue-500' : 'fa-file text-gray-500');
        const row = document.createElement('div');
        row.className = 'flex items-center gap-3 p-3 bg-gray-50 rounded-xl';
        row.innerHTML = `
            <i class="fas ${icon} text-2xl flex-shrink-0"></i>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 truncate">${escapeHtml(f.name)}</p>
                <p class="text-xs text-gray-500">${(f.size / 1024).toFixed(1)} KB</p>
            </div>
            <button type="button" onclick="removeFile(${i})" class="text-red-400 hover:text-red-600 text-sm" title="Remove">
                <i class="fas fa-times"></i>
            </button>
        `;
        wrap.appendChild(row);
    });
}

// ---- Helpers ----
function escapeHtml(s) {
    return String(s == null ? '' : s).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
}

// ---- Submit ----
let isSubmitting = false;
function submitForm(reviewStatus) {
    // Debug log
    console.log('submitForm called with reviewStatus:', reviewStatus);

    if (isSubmitting) {
        console.log('Already submitting, ignoring');
        return;
    }

    const form = document.getElementById('articleForm');
    if (!form) {
        console.error('Form not found');
        if (typeof showToast !== 'undefined') {
            showToast('Form error: Please reload the page', 'error');
        }
        return;
    }

    // Sync abstract from contenteditable
    const abstractHtml = document.getElementById('abstractEditor').innerHTML.trim();
    document.getElementById('abstractInput').value = abstractHtml;
    // Sync contributors
    document.getElementById('contributorsField').value = JSON.stringify(contributors);
    // Sync keywords
    document.getElementById('keywordsField').value = JSON.stringify(keywords);

    // Validation
    if (!form.journal_id.value) { showToast('Please select a journal.', 'error'); return; }
    if (!form.section.value) { showToast('Please select a section.', 'error'); return; }
    if (!form.title.value.trim()) { showToast('Title is required.', 'error'); return; }
    if (!abstractHtml || document.getElementById('abstractEditor').textContent.trim().length < 50) {
        showToast('Abstract is required (at least 50 characters).', 'error'); return;
    }
    if (contributors.length === 0) { showToast('Add at least one contributor.', 'error'); return; }
    if (!form.submitter_name.value.trim() || !form.submitter_email.value.trim()
        || !form.submitter_affiliation.value.trim() || !form.submitter_mobile.value.trim()) {
        showToast('Contact Person: name, email, affiliation and mobile are all required.', 'error'); return;
    }
    for (let i = 0; i < contributors.length; i++) {
        const c = contributors[i];
        if (!c.name || !c.affiliation || !c.email || !c.phone) {
            showToast(`Contributor #${i + 1} is missing required fields.`, 'error'); return;
        }
    }

    // Hidden review_status (driven by which button was clicked)
    let hiddenStatus = form.querySelector('input[name="review_status"]');
    if (!hiddenStatus) {
        hiddenStatus = document.createElement('input');
        hiddenStatus.type = 'hidden';
        hiddenStatus.name = 'review_status';
        form.appendChild(hiddenStatus);
    }
    hiddenStatus.value = reviewStatus;

    // Do AJAX submit
    const btn = document.getElementById('submitBtn');
    const orig = btn.innerHTML;
    isSubmitting = true;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting…';

    fetch('<?= BASE_URL ?>/articles/submit', {
        method: 'POST',
        body: new FormData(form),
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(async res => {
        const text = await res.text();
        let d;
        try { d = JSON.parse(text); } catch (e) {
            console.error('Non-JSON response:', text.substring(0, 500));
            throw new Error('Server returned an invalid response.');
        }
        if (!res.ok || !d.success) {
            showToast(d.message || ('Failed (HTTP ' + res.status + ')'), 'error');
            isSubmitting = false; btn.disabled = false; btn.innerHTML = orig;
            return;
        }
        showToast(d.message || 'Article submitted!', 'success');
        if (d.warning) {
            // Show a follow-up warning toast after the success toast disappears.
            setTimeout(() => showToast(d.warning, 'warning'), 1400);
        }
        btn.innerHTML = '<i class="fas fa-check"></i> Submitted';
        setTimeout(() => window.location.href = '<?= BASE_URL ?>/articles/thank-you', 1100);
    })
    .catch(err => {
        console.error('Article submit error:', err);
        showToast('Submission failed: ' + err.message, 'error');
        isSubmitting = false; btn.disabled = false; btn.innerHTML = orig;
    });
}
</script>

<style>
#abstractEditor.show-placeholder::before {
    content: attr(data-placeholder);
    color: #9ca3af;
    pointer-events: none;
    display: block;
}
#abstractEditor a { color: #0D2D57; text-decoration: underline; }
#abstractEditor ul, #abstractEditor ol { padding-left: 1.5rem; margin: 0.5rem 0; }
#abstractEditor ul { list-style: disc; }
#abstractEditor ol { list-style: decimal; }
</style>
