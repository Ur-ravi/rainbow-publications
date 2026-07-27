<?php
$service   = $service ?? [];
$isEdit    = !empty($service['id']);
$pageTitle = $isEdit ? 'Edit Service' : 'Add Service';
?>
<div class="flex items-center gap-3 mb-6">
    <a href="<?= BASE_URL ?>/admin/services" class="text-gray-400 hover:text-primary p-2 rounded-xl hover:bg-gray-100 transition duration-200">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h1 class="text-2xl font-serif font-bold text-primary"><?= $pageTitle ?></h1>
</div>

<form id="serviceForm" enctype="multipart/form-data" action="<?= BASE_URL ?>/admin/services/<?= $isEdit ? 'edit/'.$service['id'] : 'add' ?>" method="POST">
    <?= Security::csrfField() ?>
    <?php if ($isEdit): ?>
    <input type="hidden" name="id" value="<?= (int)$service['id'] ?>">
    <?php endif; ?>
    
    <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h3 class="font-semibold text-gray-800 mb-5 text-base tracking-wide flex items-center gap-2">
                    <i class="fas fa-info-circle text-gray-400"></i> Basic Information
                </h3>
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Service Title <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="titleInput" required
                               value="<?= htmlspecialchars($service['title'] ?? '') ?>"
                               class="w-full px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition duration-200" 
                               placeholder="e.g. Book Publication Service">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">URL Slug</label>
                        <div class="flex rounded-xl shadow-none">
                            <span class="inline-flex items-center px-3.5 bg-gray-50 text-sm text-gray-500 border border-gray-200 border-r-0 rounded-l-xl whitespace-nowrap select-none">service/</span>
                            <input type="text" name="slug" id="slugInput"
                                   value="<?= htmlspecialchars($service['slug'] ?? '') ?>"
                                   class="block w-full min-w-0 flex-1 px-4 py-2.5 text-sm text-gray-800 border border-gray-200 rounded-r-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition duration-200">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Short Description</label>
                        <textarea name="short_description" id="shortDescriptionInput" rows="2" 
                                  class="w-full px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition duration-200 resize-none"
                                  placeholder="Brief description. Auto-fills from title. HTML allowed: &lt;strong&gt;, &lt;b&gt;, &lt;em&gt;, &lt;a&gt;…"><?= htmlspecialchars($service['short_description'] ?? '') ?></textarea>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Font Awesome Icon Class</label>
                            <div class="relative flex items-center">
                                <input type="text" name="icon" id="iconInput"
                                       value="<?= htmlspecialchars($service['icon'] ?? 'fas fa-star') ?>"
                                       class="w-full pl-4 pr-14 py-2.5 text-sm text-gray-800 placeholder-gray-400 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition duration-200"
                                       placeholder="fas fa-book">
                                <div class="absolute right-2.5 w-9 h-9 bg-primary rounded-lg flex items-center justify-center text-white shadow-sm pointer-events-none">
                                    <i id="iconPreview" class="<?= htmlspecialchars($service['icon'] ?? 'fas fa-star') ?> text-sm"></i>
                                </div>
                            </div>
                            <div id="iconSuggestions" class="hidden mt-2.5">
                                <p class="text-xs text-gray-500 mb-1.5">Suggested icons (click to use):</p>
                                <div id="iconSuggestionsList" class="flex flex-wrap gap-2"></div>
                            </div>
                            <p class="text-xs text-gray-400 mt-2">
                                Icon auto-suggests from title. <a href="https://fontawesome.com/icons" target="_blank" class="text-primary hover:text-primary-dark font-medium inline-flex items-center gap-1 transition duration-200">Browse all icons →</a>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                            <input type="hidden" name="is_active" value="0">
                            <label class="flex items-center gap-3 cursor-pointer p-3 rounded-xl border border-gray-200 hover:bg-gray-50/70 transition duration-200">
                                <input type="checkbox" name="is_active" value="1"
                                       <?= (!isset($service['is_active']) || $service['is_active']) ? 'checked' : '' ?>
                                       class="w-5 h-5 rounded accent-primary border-gray-300 text-primary cursor-pointer focus:ring-0 focus:ring-offset-0">
                                <span class="text-sm font-medium text-gray-700 select-none">Active (visible on site)</span>
                            </label>
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">CTA Button Text</label>
                            <input type="text" name="cta_text"
                                   value="<?= htmlspecialchars($service['cta_text'] ?? '') ?>"
                                   class="w-full px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition duration-200" placeholder="e.g. Get Started">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">CTA Button URL</label>
                            <input type="text" name="cta_url"
                                   value="<?= htmlspecialchars($service['cta_url'] ?? '') ?>"
                                   class="w-full px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition duration-200" placeholder="/contact or https://...">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h3 class="font-semibold text-gray-800 mb-1 flex items-center gap-2 text-base tracking-wide">
                    <i class="fas fa-align-left text-gray-400"></i> Content Sections
                </h3>
                <p class="text-xs text-gray-400 mb-6 ml-6">Add heading + description blocks. Use lines starting with • for bullet lists, or HTML tags for formatting: <code class="bg-gray-100 px-1 rounded">&lt;strong&gt;</code>, <code class="bg-gray-100 px-1 rounded">&lt;b&gt;</code>, <code class="bg-gray-100 px-1 rounded">&lt;em&gt;</code>, <code class="bg-gray-100 px-1 rounded">&lt;u&gt;</code>, <code class="bg-gray-100 px-1 rounded">&lt;a href="..."&gt;</code>, <code class="bg-gray-100 px-1 rounded">&lt;ul&gt;&lt;li&gt;</code>.</p>
                <?php
                $sectionCount = 6;
                $sections = [];
                if (!empty($service['content'])) {
                    $decoded = json_decode($service['content'], true);
                    if (is_array($decoded)) $sections = $decoded;
                }
                while (count($sections) < $sectionCount) $sections[] = ['heading' => '', 'description' => ''];
                ?>
                
                <?php for ($i = 0; $i < $sectionCount; $i++): ?>
                <div class="border border-gray-200 rounded-xl p-5 mb-4 bg-gradient-to-br from-gray-50/50 to-white hover:border-primary/30 transition duration-200">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="w-6 h-6 rounded-full bg-primary text-white flex items-center justify-center text-xs font-bold flex-shrink-0"><?= $i + 1 ?></span>
                        <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Section <?= $i + 1 ?></span>
                    </div>
                    <div class="space-y-4 ml-8">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Heading</label>
                            <input type="text" name="section_heading[]"
                                   value="<?= htmlspecialchars($sections[$i]['heading'] ?? '') ?>"
                                   class="w-full px-4 py-2 text-sm text-gray-800 placeholder-gray-400 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition duration-200" placeholder="Section title">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Description</label>
                            <textarea name="section_description[]" rows="6" 
                                      class="w-full px-4 py-2 text-sm text-gray-800 placeholder-gray-400 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition duration-200 resize-y"
                                      placeholder="Section body. Use • for bullets or HTML: &lt;strong&gt;bold&lt;/strong&gt;, &lt;em&gt;italic&lt;/em&gt;, &lt;a href=&quot;...&quot;&gt;link&lt;/a&gt;"><?= htmlspecialchars($sections[$i]['description'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h3 class="font-semibold text-gray-800 mb-5 text-base tracking-wide flex items-center gap-2">
                    <i class="fas fa-search text-primary"></i> SEO Settings
                </h3>
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Meta Title</label>
                        <input type="text" name="meta_title" id="metaTitleInput"
                               value="<?= htmlspecialchars($service['meta_title'] ?? '') ?>"
                               class="w-full px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition duration-200"
                               placeholder="Auto-fills from title (max 60 characters)">
                        <p class="text-xs text-gray-400 mt-1.5">Auto-filled from title. Appears in search results and browser tabs.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Meta Description</label>
                        <textarea name="meta_description" id="metaDescriptionInput" rows="2" 
                                  class="w-full px-4 py-2.5 text-sm text-gray-800 placeholder-gray-400 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition duration-200 resize-none"
                                  placeholder="Auto-fills from title (max 160 characters)"><?= htmlspecialchars($service['meta_description'] ?? '') ?></textarea>
                        <p class="text-xs text-gray-400 mt-1.5">Auto-filled from title. Appears in search results below the title.</p>
                    </div>
                </div>
            </div>
        </div>

        <aside class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4 text-sm tracking-wide flex items-center gap-2">
                    <i class="fas fa-image text-gray-400"></i> Service Image
                </h3>
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center cursor-pointer hover:border-primary hover:bg-primary/5 transition duration-200 group"
                     onclick="document.getElementById('serviceImage').click()">
                    <?php if(!empty($service['image'])): ?>
                    <img id="imgPreview" src="<?= uploadUrl('services', $service['image']) ?>"
                         class="max-h-40 mx-auto rounded-xl mb-3 object-cover border border-gray-100 shadow-sm">
                    <p class="text-xs text-gray-500 font-medium group-hover:text-primary transition duration-200">Click to change media image</p>
                    <?php else: ?>
                    <div id="imgPlaceholder">
                        <i class="fas fa-image text-4xl text-gray-300 mb-2.5 block group-hover:text-primary/40 transition duration-200"></i>
                        <p class="text-sm text-gray-600 font-medium group-hover:text-primary transition duration-200">Click to upload image</p>
                        <p class="text-xs text-gray-400 mt-1">PNG, JPG, SVG (Max 5MB)</p>
                    </div>
                    <img id="imgPreview" class="max-h-40 mx-auto rounded-xl mb-3 hidden object-cover border border-gray-100 shadow-sm">
                    <?php endif; ?>
                    <input type="file" id="serviceImage" name="image" accept="image/*" class="hidden">
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                <button type="submit"
                        class="w-full bg-primary hover:bg-primary-dark text-white py-3 px-4 rounded-xl font-semibold transition-all duration-200 flex items-center justify-center gap-2 shadow-sm hover:shadow-md">
                    <i class="fas fa-save"></i> <span><?= $isEdit ? 'Update Service' : 'Create Service' ?></span>
                </button>
                <a href="<?= BASE_URL ?>/admin/services"
                   class="block text-center text-gray-500 hover:text-gray-700 hover:bg-gray-50 text-sm font-medium mt-3 transition duration-200 py-2.5 rounded-xl border border-transparent hover:border-gray-100">Cancel</a>
            </div>
        </aside>
    </div>
</form>

<script>
const isEditService = <?= $isEdit ? 'true' : 'false' ?>;
const siteName = <?= json_encode(getSetting('site_name', APP_NAME), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

const iconRules = [
    { keys: ['book', 'publication', 'publish'], icon: 'fas fa-book', label: 'Book' },
    { keys: ['journal'], icon: 'fas fa-newspaper', label: 'Journal' },
    { keys: ['conference', 'seminar', 'proceeding'], icon: 'fas fa-chalkboard-teacher', label: 'Conference' },
    { keys: ['research', 'science', 'laboratory'], icon: 'fas fa-flask', label: 'Research' },
    { keys: ['plagiarism', 'originality'], icon: 'fas fa-shield-alt', label: 'Plagiarism' },
    { keys: ['certificate', 'certification'], icon: 'fas fa-certificate', label: 'Certificate' },
    { keys: ['edit', 'editing', 'proofread'], icon: 'fas fa-spell-check', label: 'Editing' },
    { keys: ['write', 'writing', 'author', 'manuscript'], icon: 'fas fa-pen-nib', label: 'Writing' },
    { keys: ['pharma', 'drug', 'pharmaceutical', 'medicine'], icon: 'fas fa-pills', label: 'Pharma' },
    { keys: ['clinical', 'medical', 'health', 'patient'], icon: 'fas fa-stethoscope', label: 'Clinical' },
    { keys: ['support', 'assist', 'help'], icon: 'fas fa-hands-helping', label: 'Support' },
    { keys: ['print', 'printing'], icon: 'fas fa-print', label: 'Print' },
    { keys: ['global', 'international', 'world'], icon: 'fas fa-globe', label: 'Global' },
    { keys: ['review', 'peer', 'reviewer'], icon: 'fas fa-user-check', label: 'Review' },
    { keys: ['index', 'indexing', 'database'], icon: 'fas fa-search', label: 'Indexing' },
    { keys: ['copyright', 'legal', 'license'], icon: 'fas fa-gavel', label: 'Legal' },
    { keys: ['design', 'cover', 'layout'], icon: 'fas fa-palette', label: 'Design' },
    { keys: ['digital', 'ebook', 'online'], icon: 'fas fa-tablet-alt', label: 'Digital' },
    { keys: ['contact', 'enquiry', 'inquiry'], icon: 'fas fa-envelope', label: 'Contact' },
    { keys: ['management', 'manage'], icon: 'fas fa-tasks', label: 'Management' },
];

function autoSlug(v) {
    if (!document.getElementById('slugInput').dataset.manual) {
        document.getElementById('slugInput').value = v.toLowerCase().replace(/[^a-z0-9\s-]/g,'').replace(/\s+/g,'-').replace(/-+/g,'-').replace(/^-|-$/g,'');
    }
}

function matchIconsFromTitle(title) {
    const text = title.toLowerCase().trim();
    const matched = [];
    const seen = new Set();

    iconRules.forEach(rule => {
        if (rule.keys.some(key => text.includes(key)) && !seen.has(rule.icon)) {
            seen.add(rule.icon);
            matched.push(rule);
        }
    });

    if (!matched.length && text) {
        return [
            { icon: 'fas fa-star', label: 'Default' },
            { icon: 'fas fa-cog', label: 'Service' },
            { icon: 'fas fa-briefcase', label: 'Business' },
        ];
    }

    return matched.slice(0, 5);
}

function setServiceIcon(icon, manual = false) {
    const input = document.getElementById('iconInput');
    input.value = icon;
    document.getElementById('iconPreview').className = (icon || 'fas fa-star') + ' text-sm';
    if (manual) input.dataset.manual = 'true';
    renderIconSuggestions(document.getElementById('titleInput').value, icon);
}

function renderIconSuggestions(title, activeIcon = '') {
    const wrap = document.getElementById('iconSuggestions');
    const list = document.getElementById('iconSuggestionsList');
    const suggestions = matchIconsFromTitle(title);

    if (!title.trim()) {
        wrap.classList.add('hidden');
        list.innerHTML = '';
        return;
    }

    wrap.classList.remove('hidden');
    list.innerHTML = suggestions.map(item => {
        const active = item.icon === activeIcon ? ' ring-2 ring-primary bg-primary/10 border-primary/30' : ' border-gray-200 hover:border-primary/40 hover:bg-primary/5';
        return `<button type="button" class="icon-suggest-btn inline-flex items-center gap-2 px-2.5 py-1.5 rounded-lg border bg-white text-xs text-gray-700 transition duration-200${active}" data-icon="${item.icon}" title="${item.icon}">
            <i class="${item.icon} text-primary"></i><span>${item.label}</span>
        </button>`;
    }).join('');

    list.querySelectorAll('.icon-suggest-btn').forEach(btn => {
        btn.addEventListener('click', () => setServiceIcon(btn.dataset.icon, true));
    });
}

function suggestIconFromTitle(title) {
    const input = document.getElementById('iconInput');
    const suggestions = matchIconsFromTitle(title);

    renderIconSuggestions(title, input.value);

    if (!input.dataset.manual && suggestions.length) {
        setServiceIcon(suggestions[0].icon);
    }
}

function truncateText(text, max) {
    const value = text.trim();
    if (value.length <= max) return value;
    return value.slice(0, max - 3).trimEnd() + '...';
}

function suggestDescriptionsFromTitle(title) {
    const cleanTitle = title.trim();
    const shortDesc = document.getElementById('shortDescriptionInput');
    const metaTitle = document.getElementById('metaTitleInput');
    const metaDesc = document.getElementById('metaDescriptionInput');

    if (!cleanTitle) {
        if (!shortDesc.dataset.manual) shortDesc.value = '';
        if (!metaTitle.dataset.manual) metaTitle.value = '';
        if (!metaDesc.dataset.manual) metaDesc.value = '';
        return;
    }

    if (!shortDesc.dataset.manual) {
        shortDesc.value = truncateText(
            `${cleanTitle} — professional academic publishing and research support from ${siteName}.`,
            500
        );
    }

    if (!metaTitle.dataset.manual) {
        metaTitle.value = truncateText(`${cleanTitle} | ${siteName}`, 60);
    }

    if (!metaDesc.dataset.manual) {
        metaDesc.value = truncateText(
            `Discover ${cleanTitle} at ${siteName}. Expert publishing, research assistance, and academic support for scholars worldwide.`,
            160
        );
    }
}

function syncFieldsFromTitle(title) {
    autoSlug(title);
    suggestIconFromTitle(title);
    suggestDescriptionsFromTitle(title);
}

document.getElementById('titleInput').addEventListener('input', function() {
    syncFieldsFromTitle(this.value);
});

document.getElementById('slugInput').addEventListener('input', function() { this.dataset.manual = 'true'; });

document.getElementById('iconInput').addEventListener('input', function() {
    this.dataset.manual = 'true';
    document.getElementById('iconPreview').className = (this.value || 'fas fa-star') + ' text-sm';
    renderIconSuggestions(document.getElementById('titleInput').value, this.value);
});

['shortDescriptionInput', 'metaTitleInput', 'metaDescriptionInput'].forEach(id => {
    document.getElementById(id).addEventListener('input', function() {
        this.dataset.manual = 'true';
    });
});

if (isEditService) {
    document.getElementById('iconInput').dataset.manual = 'true';
    document.getElementById('shortDescriptionInput').dataset.manual = 'true';
    document.getElementById('metaTitleInput').dataset.manual = 'true';
    document.getElementById('metaDescriptionInput').dataset.manual = 'true';
} else if (document.getElementById('titleInput').value.trim()) {
    syncFieldsFromTitle(document.getElementById('titleInput').value);
}

// Image Async Stream Render
document.getElementById('serviceImage').addEventListener('change', function() {
    const file = this.files[0]; if(!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const img = document.getElementById('imgPreview');
        const ph  = document.getElementById('imgPlaceholder');
        img.src = e.target.result;
        img.classList.remove('hidden');
        if(ph) ph.classList.add('hidden');
    };
    reader.readAsDataURL(file);
});

// Form submission handler
document.getElementById('serviceForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = document.querySelector('button[type="submit"]');
    const orig = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
    btn.disabled = true;
    try {
        const res = await fetch(this.action, { method: 'POST', body: new FormData(this) });
        const data = await res.json();
        showToast(data.message, data.success ? 'success' : 'error');
        if (data.success) {
            setTimeout(() => window.location.href = '<?= BASE_URL ?>/admin/services', 1000);
        }
    } catch(e) {
        showToast('Error saving service', 'error');
    }
    btn.innerHTML = orig;
    btn.disabled = false;
});
</script>