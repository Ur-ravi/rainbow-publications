<?php $pageTitle = 'Content Pages'; ?>

<div class="space-y-6">
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-serif font-bold text-primary">Content Pages</h1>
      <p class="text-gray-500 text-sm mt-1">Edit CMS-driven pages such as <em>Benefit of Membership</em> and <em>Types of Membership</em></p>
    </div>
  </div>

  <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
      <thead class="bg-gray-50">
        <tr>
          <th class="text-left px-5 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Title</th>
          <th class="text-left px-5 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Slug</th>
          <th class="text-left px-5 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Status</th>
          <th class="text-right px-5 py-3 font-semibold text-gray-600 text-xs uppercase tracking-wider">Action</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        <?php if (empty($pages)): ?>
        <tr><td colspan="4" class="px-5 py-10 text-center text-gray-400">No pages found.</td></tr>
        <?php else: foreach ($pages as $p): ?>
        <tr>
          <td class="px-5 py-4 font-semibold text-gray-800"><?= htmlspecialchars($p['title']) ?></td>
          <td class="px-5 py-4 text-gray-500 font-mono text-xs"><?= htmlspecialchars($p['slug']) ?></td>
          <td class="px-5 py-4">
            <?php if (($p['status'] ?? 'published') === 'published'): ?>
              <span class="text-xs font-semibold text-green-700 bg-green-50 border border-green-200 rounded-full px-2.5 py-1">Published</span>
            <?php else: ?>
              <span class="text-xs font-semibold text-gray-600 bg-gray-100 border border-gray-200 rounded-full px-2.5 py-1">Draft</span>
            <?php endif; ?>
          </td>
          <td class="px-5 py-4 text-right">
            <a href="<?= BASE_URL ?>/admin/pages/edit/<?= (int)$p['id'] ?>"
               class="inline-flex items-center gap-1.5 text-primary hover:text-primary-dark font-semibold text-xs">
              <i class="fas fa-pen"></i> Edit
            </a>
          </td>
        </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
