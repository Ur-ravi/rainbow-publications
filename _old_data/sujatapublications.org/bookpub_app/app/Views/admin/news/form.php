<?php $isEdit = !empty($article); ?>
<?php $pageTitle = $isEdit ? 'Edit Article' : 'New Article'; ?>

<div class="space-y-6">
  <!-- Header -->
  <div class="flex items-center gap-4">
    <a href="/admin/news" class="p-2 rounded-xl hover:bg-gray-100 text-gray-500 transition-colors">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </a>
    <div>
      <h1 class="text-2xl font-bold text-gray-900"><?= $isEdit ? 'Edit Article' : 'New Article' ?></h1>
      <p class="text-gray-500 text-sm mt-0.5"><?= $isEdit ? 'Update article content and settings' : 'Create a new news article or blog post' ?></p>
    </div>
  </div>

  <form id="newsForm" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <?php if($isEdit): ?><input type="hidden" name="id" value="<?= (int)$article['id'] ?>"><?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Main Content -->
      <div class="lg:col-span-2 space-y-5">
        <!-- Title & Slug -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Article Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" id="titleInput" required
              value="<?= htmlspecialchars($article['title'] ?? '') ?>"
              class="w-full px-4 py-3 border border-gray-200 rounded-xl text-base font-medium focus:outline-none focus:ring-2"
              placeholder="Enter article title...">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">URL Slug</label>
            <div class="flex items-center gap-2">
              <span class="text-sm text-gray-400 flex-shrink-0">/news/</span>
              <input type="text" name="slug" id="slugInput"
                value="<?= htmlspecialchars($article['slug'] ?? '') ?>"
                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-mono focus:outline-none focus:ring-2"
                placeholder="auto-generated-from-title">
              <button type="button" onclick="regenerateSlug()" class="px-3 py-2.5 rounded-xl bg-gray-100 text-gray-600 text-xs hover:bg-gray-200 transition-colors whitespace-nowrap">
                Regenerate
              </button>
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Short Excerpt</label>
            <textarea name="excerpt" rows="2"
              class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 resize-none"
              placeholder="Brief summary shown in listings and previews (optional)"><?= htmlspecialchars($article['excerpt'] ?? '') ?></textarea>
          </div>
        </div>

        <!-- Content (plain textarea, no rich editor) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
          <label class="block text-sm font-medium text-gray-700 mb-3">Article Content <span class="text-red-500">*</span></label>
          <textarea name="content" id="articleContent" rows="14"
            class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"
            placeholder="Write your article content here..."><?= $isEdit ? htmlspecialchars($article['content']) : '' ?></textarea>
          <p class="text-xs text-gray-400 mt-2">Plain text content. Line breaks are preserved.</p>
        </div>

        <!-- Display Data (extra structured fields shown alongside the article) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
          <h3 class="text-base font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fas fa-list-ul text-primary"></i> Display Data
          </h3>
          <div class="grid sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Author Name</label>
              <input type="text" name="author_name"
                     value="<?= htmlspecialchars($article['author_name'] ?? '') ?>"
                     class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"
                     placeholder="e.g. Dr. Rainbow Sharma">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Source / Reference</label>
              <input type="text" name="source"
                     value="<?= htmlspecialchars($article['source'] ?? '') ?>"
                     class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"
                     placeholder="e.g. Times of India">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">External Link</label>
              <input type="url" name="external_link"
                     value="<?= htmlspecialchars($article['external_link'] ?? '') ?>"
                     class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"
                     placeholder="https://example.com/article">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Tags (comma-separated)</label>
              <input type="text" name="tags"
                     value="<?= htmlspecialchars($article['tags'] ?? '') ?>"
                     class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary"
                     placeholder="research, publication, conference">
            </div>
          </div>
        </div>

        <!-- SEO -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
          <button type="button" onclick="toggleSection('seoSection')"
            class="w-full flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition-colors">
            <div class="flex items-center gap-3">
              <span class="text-lg">🔍</span>
              <div class="text-left">
                <p class="font-medium text-gray-900">SEO Settings</p>
                <p class="text-xs text-gray-500">Meta title, description, and keywords</p>
              </div>
            </div>
            <svg id="seoArrow" class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div id="seoSection" class="hidden px-6 pb-6 space-y-4">
            <div>
              <label class="block text-xs font-medium text-gray-600 mb-1">Meta Title</label>
              <input type="text" name="meta_title" value="<?= htmlspecialchars($article['meta_title'] ?? '') ?>"
                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2"
                placeholder="Defaults to article title">
            </div>
            <div>
              <label class="block text-xs font-medium text-gray-600 mb-1">Meta Description</label>
              <textarea name="meta_description" rows="2"
                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 resize-none"
                placeholder="Defaults to excerpt"><?= htmlspecialchars($article['meta_description'] ?? '') ?></textarea>
            </div>
            <div>
              <label class="block text-xs font-medium text-gray-600 mb-1">Keywords</label>
              <input type="text" name="meta_keywords" value="<?= htmlspecialchars($article['meta_keywords'] ?? '') ?>"
                class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2"
                placeholder="keyword1, keyword2, keyword3">
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="space-y-5">
        <!-- Publish Actions -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
          <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Publish</h3>
          </div>
          <div class="p-5 space-y-4">
            <div>
              <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
              <select name="status" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 bg-white">
                <option value="draft" <?= (!$isEdit || $article['status']==='draft') ? 'selected' : '' ?>>Draft</option>
                <option value="published" <?= ($isEdit && $article['status']==='published') ? 'selected' : '' ?>>Published</option>
              </select>
            </div>
            <div>
              <label class="block text-xs font-medium text-gray-600 mb-1">Publish Date</label>
              <input type="datetime-local" name="published_at"
                value="<?= $isEdit && !empty($article['published_at']) ? date('Y-m-d\TH:i', strtotime($article['published_at'])) : date('Y-m-d\TH:i') ?>"
                class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2">
            </div>
            <div>
              <label class="block text-xs font-medium text-gray-600 mb-1">Author</label>
              <input type="text" name="author" value="<?= htmlspecialchars($article['author'] ?? 'Admin') ?>"
                class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2">
            </div>
            <label class="flex items-center gap-2 cursor-pointer p-3 rounded-xl border border-gray-200 hover:bg-gray-50">
              <input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300" style="accent-color:#cc1824"
                <?= ($isEdit && $article['is_featured']) ? 'checked' : '' ?>>
              <div>
                <p class="text-sm font-medium text-gray-700">Featured Article</p>
                <p class="text-xs text-gray-400">Show on homepage and highlighted</p>
              </div>
            </label>
            <div class="flex gap-2 pt-2">
              <button type="button" onclick="saveArticle('draft')"
                class="flex-1 py-2.5 rounded-xl text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
                Save Draft
              </button>
              <button type="button" onclick="saveArticle('published')"
                class="flex-1 py-2.5 rounded-xl text-sm font-medium text-white hover:opacity-90 transition-all"
                style="background:linear-gradient(135deg,#0d3051,#1a5276)">
                <?= $isEdit ? 'Update' : 'Publish' ?>
              </button>
            </div>
          </div>
        </div>

        <!-- Featured Image -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
          <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900">Featured Image</h3>
          </div>
          <div class="p-5">
            <?php if($isEdit && !empty($article['featured_image'])): ?>
            <div class="mb-3 relative group">
              <img id="currentFeatImg" src="<?= BASE_URL ?>/uploads/news/<?= htmlspecialchars($article['featured_image']) ?>"
                alt="" class="w-full h-40 object-cover rounded-xl">
              <button type="button" onclick="removeFeatImg()" class="absolute top-2 right-2 w-7 h-7 bg-red-500 text-white rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-xs">✕</button>
            </div>
            <input type="hidden" name="existing_image" id="existingImage" value="<?= htmlspecialchars($article['featured_image']) ?>">
            <?php endif; ?>
            <div id="imgDropzone" class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center cursor-pointer hover:border-gray-400 transition-colors <?= ($isEdit && !empty($article['featured_image'])) ? 'hidden' : '' ?>" onclick="document.getElementById('featuredImg').click()">
              <input type="file" id="featuredImg" name="featured_image" accept="image/*" class="hidden" onchange="previewFeatImg(this)">
              <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
              <p class="text-xs text-gray-500">Click to upload image</p>
              <p class="text-xs text-gray-400 mt-0.5">1200×630 recommended</p>
            </div>
            <img id="featImgPreview" class="hidden mt-3 w-full h-40 object-cover rounded-xl">
          </div>
        </div>

        <!-- Tags -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
          <label class="block text-sm font-semibold text-gray-900 mb-3">Tags</label>
          <input type="text" name="tags" value="<?= htmlspecialchars($article['tags'] ?? '') ?>"
            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2"
            placeholder="tag1, tag2, tag3">
          <p class="text-xs text-gray-400 mt-1.5">Separate with commas</p>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
// Slug generation
document.getElementById('titleInput').addEventListener('input', function() {
  if (!document.getElementById('slugInput').dataset.manual) {
    document.getElementById('slugInput').value = slugify(this.value);
  }
});
document.getElementById('slugInput').addEventListener('input', function() { this.dataset.manual = 'true'; });
function slugify(str) { return str.toLowerCase().replace(/[^a-z0-9\s-]/g,'').replace(/\s+/g,'-').replace(/-+/g,'-').replace(/^-|-$/g,''); }
function regenerateSlug() {
  delete document.getElementById('slugInput').dataset.manual;
  document.getElementById('slugInput').value = slugify(document.getElementById('titleInput').value);
}

function previewFeatImg(input) {
  const file = input.files[0]; if (!file) return;
  const reader = new FileReader();
  reader.onload = e => {
    document.getElementById('imgDropzone').classList.add('hidden');
    const prev = document.getElementById('featImgPreview');
    prev.src = e.target.result; prev.classList.remove('hidden');
  };
  reader.readAsDataURL(file);
}
function removeFeatImg() {
  document.getElementById('currentFeatImg')?.remove();
  document.getElementById('existingImage').value = '';
  document.getElementById('imgDropzone').classList.remove('hidden');
}

function toggleSection(id) {
  document.getElementById(id).classList.toggle('hidden');
  document.getElementById('seoArrow').classList.toggle('rotate-180');
}

async function saveArticle(status) {
  // (removed TinyMCE)
  const fd = new FormData(document.getElementById('newsForm'));
  fd.set('status', status);
  const btn = event.target;
  btn.disabled = true; btn.textContent = 'Saving...';
  try {
    const url = '<?= BASE_URL ?>' + (<?= $isEdit ? '"/admin/news/update"' : '"/admin/news/store"' ?>);
    const res = await fetch(url, { method: 'POST', body: fd });
    const data = await res.json();
    showToast(data.message || 'Saved!', data.success ? 'success' : 'error');
    if (data.success && data.redirect) window.location.href = data.redirect;
  } catch(e) { showToast('Error saving', 'error'); }
  finally { btn.disabled = false; btn.textContent = status === 'draft' ? 'Save Draft' : '<?= $isEdit ? "Update" : "Publish" ?>'; }
}
</script>
