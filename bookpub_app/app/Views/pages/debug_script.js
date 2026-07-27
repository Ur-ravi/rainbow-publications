
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
        tag.style.color = '#0F4C75';
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
    if (isSubmitting) return;

    const form = document.getElementById('articleForm');

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
