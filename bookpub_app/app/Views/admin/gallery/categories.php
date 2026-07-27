<?php $pageTitle = 'Gallery Categories'; ?>

<div class="space-y-6">
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-serif font-bold text-gray-900">Gallery Categories</h1>
      <p class="text-gray-500 text-sm mt-1">Organize gallery items into categories</p>
    </div>
    <a href="<?= BASE_URL ?? '/admin/gallery' ?>" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
      Back to Gallery
    </a>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
    <div class="lg:col-span-2">
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-6">
        <div class="px-6 py-4 border-b border-gray-100">
          <h2 class="font-semibold text-gray-900" id="formTitle">Add New Category</h2>
        </div>
        <form id="catForm" class="p-6 space-y-4">
          <?= function_exists('csrf_field') ? csrf_field() : (class_exists('Security') ? Security::csrfField() : '') ?>
          <input type="hidden" name="id" id="catId" value="">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" id="catName" required
              class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-gray-400 focus:ring-0 transition-colors"
              placeholder="e.g. Events, Campus, Publications">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
            <input type="text" name="slug" id="catSlug"
              class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-mono focus:outline-none focus:border-gray-400 focus:ring-0 bg-gray-50 transition-colors"
              placeholder="auto-generated">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-gray-400 font-normal">(optional)</span></label>
            <textarea name="description" id="catDesc" rows="2"
              class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-gray-400 focus:ring-0 resize-none transition-colors"
              placeholder="Brief description of this category"></textarea>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Color Tag</label>
            <div class="flex flex-wrap gap-2" id="colorPicker">
              <?php $colors = ['#0d3051','#cc1824','#10b981','#f59e0b','#8b5cf6','#06b6d4','#ec4899','#6b7280']; ?>
              <?php foreach($colors as $c): ?>
              <label class="cursor-pointer">
                <input type="radio" name="color" value="<?= $c ?>" class="sr-only color-radio">
                <span class="w-7 h-7 rounded-full block border-2 border-transparent transition-all hover:scale-110"
                  style="background:<?= $c ?>" data-color="<?= $c ?>"></span>
              </label>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="flex gap-2 pt-2">
            <button type="submit"
              class="flex-1 py-2.5 rounded-xl text-white font-medium text-sm hover:opacity-90 transition-all shadow-sm"
              style="background:linear-gradient(135deg,#0d3051,#1a5276)" id="submitBtn">
              Add Category
            </button>
            <button type="button" onclick="resetForm()"
              class="px-4 py-2.5 rounded-xl bg-gray-100 text-gray-700 font-medium text-sm hover:bg-gray-200 transition-colors hidden" id="cancelBtn">
              Cancel
            </button>
          </div>
        </form>
      </div>
    </div>

    <div class="lg:col-span-3">
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
          <h2 class="font-semibold text-gray-900">All Categories</h2>
          <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full"><?= count($categories ?? []) ?> total</span>
        </div>
        <div id="catList">
          <?php if(!empty($categories)): foreach($categories as $cat): ?>
          <div class="cat-row flex items-center gap-4 px-6 py-4 border-b border-gray-50 hover:bg-gray-50 transition-colors" data-id="<?= $cat['id'] ?>">
            <div class="w-3 h-3 rounded-full flex-shrink-0" style="background:<?= htmlspecialchars($cat['color'] ?? '#0d3051') ?>"></div>
            <div class="flex-1 min-w-0">
              <p class="font-medium text-gray-900 text-sm"><?= htmlspecialchars($cat['name']) ?></p>
              <p class="text-xs text-gray-400 font-mono"><?= htmlspecialchars($cat['slug']) ?></p>
              <?php if(!empty($cat['description'])): ?>
              <p class="text-xs text-gray-500 mt-0.5 truncate"><?= htmlspecialchars($cat['description']) ?></p>
              <?php endif; ?>
            </div>
            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 flex-shrink-0">
              <?= $cat['item_count'] ?? 0 ?> items
            </span>
            <div class="flex items-center gap-1 flex-shrink-0">
              <button onclick="editCategory(<?= htmlspecialchars(json_encode($cat)) ?>)"
                class="p-2 rounded-lg hover:bg-blue-50 text-gray-400 hover:text-blue-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
              </button>
              <button onclick="deleteCategory(<?= (int)$cat['id'] ?>, <?= jsAttr($cat['name']) ?>)"
                class="p-2 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
              </button>
            </div>
          </div>
          <?php endforeach; else: ?>
          <div class="px-6 py-16 text-center">
            <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
            <p class="text-gray-400">No categories yet — add one from the left!</p>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('.color-radio').forEach(r => {
  r.addEventListener('change', function() {
    document.querySelectorAll('.color-radio').forEach(o => o.nextElementSibling.classList.remove('ring-2','ring-offset-2'));
    this.nextElementSibling.classList.add('ring-2','ring-offset-2');
    this.nextElementSibling.style.setProperty('--tw-ring-color', this.value);
  });
});
document.querySelector('.color-radio')?.click();

document.getElementById('catName').addEventListener('input', function() {
  if (!document.getElementById('catSlug').dataset.manual) {
    document.getElementById('catSlug').value = slugify(this.value);
  }
});
document.getElementById('catSlug').addEventListener('input', function() { this.dataset.manual = 'true'; });
function slugify(s) { return s.toLowerCase().replace(/[^a-z0-9\s-]/g,'').replace(/\s+/g,'-').replace(/-+/g,'-').replace(/^-|-$/g,''); }

document.getElementById('catForm').addEventListener('submit', async e => {
  e.preventDefault();
  const fd = new FormData(e.target);
  const id = document.getElementById('catId').value;
  const url = id ? '<?= BASE_URL ?? "" ?>/admin/gallery/categories/update' : '<?= BASE_URL ?? "" ?>/admin/gallery/categories/store';
  const btn = document.getElementById('submitBtn');
  btn.disabled = true; btn.textContent = 'Saving...';
  try {
    const res = await fetch(url, { method: 'POST', body: fd });
    const data = await res.json();
    if(typeof showToast === 'function') showToast(data.message || 'Saved', data.success ? 'success' : 'error');
    if (data.success) { location.reload(); }
  } catch(err) { if(typeof showToast === 'function') showToast('Error', 'error'); }
  finally { btn.disabled = false; btn.textContent = id ? 'Update Category' : 'Add Category'; }
});

function editCategory(cat) {
  document.getElementById('catId').value = cat.id;
  document.getElementById('catName').value = cat.name;
  document.getElementById('catSlug').value = cat.slug;
  document.getElementById('catDesc').value = cat.description || '';
  document.getElementById('catSlug').dataset.manual = 'true';
  const radio = document.querySelector(`.color-radio[value="${cat.color}"]`);
  if (radio) { radio.checked = true; radio.dispatchEvent(new Event('change')); }
  document.getElementById('formTitle').textContent = 'Edit Category';
  document.getElementById('submitBtn').textContent = 'Update Category';
  document.getElementById('cancelBtn').classList.remove('hidden');
  document.getElementById('catForm').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function resetForm() {
  document.getElementById('catForm').reset();
  document.getElementById('catId').value = '';
  delete document.getElementById('catSlug').dataset.manual;
  document.getElementById('formTitle').textContent = 'Add New Category';
  document.getElementById('submitBtn').textContent = 'Add Category';
  document.getElementById('cancelBtn').classList.add('hidden');
  document.querySelector('.color-radio')?.click();
}

function deleteCategory(id, name) {
  adminDelete(`/admin/gallery/categories/delete/${id}`, `Delete "${name}"? This will uncategorize related gallery items.`, () => {
    document.querySelector(`.cat-row[data-id="${id}"]`)?.remove();
  });
}
</script>