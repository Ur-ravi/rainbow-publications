<?php
$pageTitle   = 'Edit Content Page';
$page        = $page ?? [];
$pageId      = (int)($page['id'] ?? 0);
$pageSlug    = htmlspecialchars($page['slug'] ?? '');
$pageTitle   = htmlspecialchars($page['title'] ?? '');
$content     = $page['content'] ?? '';
$excerpt     = htmlspecialchars($page['excerpt'] ?? '');
$metaTitle   = htmlspecialchars($page['meta_title'] ?? '');
$metaDesc    = htmlspecialchars($page['meta_description'] ?? '');
$status      = $page['status'] ?? 'published';
$backUrl     = BASE_URL . '/admin/pages';
?>

<!-- Page Header -->
<div class="mb-6">
  <a href="<?= $backUrl ?>" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-primary mb-3 transition-colors">
    <i class="fas fa-arrow-left text-xs"></i> Back to all pages
  </a>
  <h1 class="text-2xl font-serif font-bold text-primary"><?= $page ? 'Edit: ' . htmlspecialchars($page['title']) : 'New Page' ?></h1>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100">
  <div class="p-6 md:p-8">
    <form method="POST" id="pageEditForm">
      <?= Security::csrfField() ?>

      <!-- Hidden ID -->
      <input type="hidden" name="id" value="<?= $pageId ?>">

      <!-- Title -->
      <div class="mb-5">
        <label for="title" class="block text-sm font-semibold text-gray-700 mb-1.5">Page Title</label>
        <input type="text" name="title" id="title" value="<?= $pageTitle ?>"
               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition"
               placeholder="e.g. Benefit of Membership" required>
      </div>

      <!-- Status -->
      <div class="mb-5">
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Status</label>
        <div class="flex items-center gap-4">
          <label class="inline-flex items-center gap-2 cursor-pointer">
            <input type="radio" name="status" value="published" <?= $status === 'published' ? 'checked' : '' ?> class="text-primary focus:ring-primary">
            <span class="text-sm text-gray-700">Published</span>
          </label>
          <label class="inline-flex items-center gap-2 cursor-pointer">
            <input type="radio" name="status" value="draft" <?= $status === 'draft' ? 'checked' : '' ?> class="text-primary focus:ring-primary">
            <span class="text-sm text-gray-700">Draft</span>
          </label>
        </div>
      </div>

      <!-- Slug (readonly) -->
      <div class="mb-5">
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">URL Slug</label>
        <div class="flex items-center gap-2">
          <span class="text-sm text-gray-400">/membership/</span>
          <input type="text" value="<?= $pageSlug ?>" disabled
                 class="flex-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-500">
        </div>
        <p class="text-xs text-gray-400 mt-1">Slug is auto-generated from the title and cannot be changed here.</p>
      </div>

      <!-- Content -->
      <div class="mb-5">
        <label for="content" class="block text-sm font-semibold text-gray-700 mb-1.5">Page Content <span class="text-xs text-gray-400 font-normal">(HTML allowed)</span></label>
        <textarea name="content" id="content" rows="16"
                  class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition resize-y"><?= $content ?></textarea>
        <p class="text-xs text-gray-400 mt-1">Use <code>&lt;h2&gt;</code>, <code>&lt;p&gt;</code>, <code>&lt;ul&gt;</code>, <code>&lt;li&gt;</code> etc.</p>
      </div>

      <!-- Meta title -->
      <div class="mb-5">
        <label for="meta_title" class="block text-sm font-semibold text-gray-700 mb-1.5">SEO Title</label>
        <input type="text" name="meta_title" id="meta_title" value="<?= $metaTitle ?>"
               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition"
               placeholder="e.g. Benefit of Membership | Rainbow Publications">
      </div>

      <!-- Meta description -->
      <div class="mb-5">
        <label for="meta_description" class="block text-sm font-semibold text-gray-700 mb-1.5">SEO Description</label>
        <textarea name="meta_description" id="meta_description" rows="3"
                  class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition"><?= $metaDesc ?></textarea>
      </div>

      <!-- Excerpt -->
      <div class="mb-6">
        <label for="excerpt" class="block text-sm font-semibold text-gray-700 mb-1.5">Short Excerpt <span class="text-xs text-gray-400 font-normal">(optional)</span></label>
        <textarea name="excerpt" id="excerpt" rows="2"
                  class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition"><?= $excerpt ?></textarea>
      </div>

      <!-- Actions -->
      <div class="flex items-center justify-end gap-3">
        <a href="<?= $backUrl ?>" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition">Cancel</a>
        <button type="submit" id="btnSave"
                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-white font-semibold text-sm shadow-md hover:shadow-lg transition-all hover:opacity-90 active:scale-[0.99]"
                style="background:linear-gradient(135deg,#0d3051,#1a5276)">
          <i class="fas fa-save"></i> Save Page
        </button>
      </div>

    </form>
  </div>
</div>

<!-- Toast (reuse global) -->

<script>
document.getElementById('pageEditForm').addEventListener('submit', async function(e) {
  e.preventDefault();

  const btn = document.getElementById('btnSave');
  const orig = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

  try {
    const fd = new FormData(this);
    const res = await fetch('<?= BASE_URL ?>/admin/pages/edit/<?= $pageId ?>', {
      method: 'POST',
      body: fd,
      headers: { 'X-Requested-With': 'XMLHttpRequest' },
    });

    const data = await res.json();
    if (data.success) {
      showToast(data.message || 'Page saved!', 'success');
    } else {
      showToast(data.message || 'Save failed.', 'error');
    }
  } catch (err) {
    showToast('Error: ' + err.message, 'error');
  } finally {
    btn.disabled = false;
    btn.innerHTML = orig;
  }
});
</script>
