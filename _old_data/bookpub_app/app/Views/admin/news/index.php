<?php $pageTitle = 'News & Blog'; ?>

<div class="space-y-6">
  <!-- Header -->
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-bold text-gray-900">News & Blog</h1>
      <p class="text-gray-500 text-sm mt-1">Manage articles, announcements and blog posts</p>
    </div>
    <a href="/admin/news/create"
      class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-white font-medium text-sm shadow-lg hover:shadow-xl transition-all"
      style="background:linear-gradient(135deg,#0d3051,#1a5276)">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
      Add Article
    </a>
  </div>

  <!-- Stats Row -->
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <?php
    $stats = [
      ['Total Articles', $totalNews ?? 0, '#0d3051', 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6M7 8h6'],
      ['Published', $publishedCount ?? 0, '#10b981', 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
      ['Drafts', $draftCount ?? 0, '#f59e0b', 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
      ['Featured', $featuredCount ?? 0, '#cc1824', 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
    ];
    foreach($stats as [$label,$val,$color,$icon]):
    ?>
    <div class="bg-white rounded-2xl p-4 border border-gray-100 shadow-sm flex items-center gap-3">
      <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:<?= $color ?>15">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:<?= $color ?>">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $icon ?>"/>
        </svg>
      </div>
      <div>
        <p class="text-2xl font-bold text-gray-900"><?= number_format($val) ?></p>
        <p class="text-xs text-gray-500"><?= $label ?></p>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Filters & Search -->
  <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
    <div class="flex flex-wrap items-center gap-3">
      <div class="flex-1 min-w-48 relative">
        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <input type="text" id="newsSearch" placeholder="Search articles..."
          class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2">
      </div>
      <select id="statusFilter" class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 bg-white">
        <option value="">All Status</option>
        <option value="published">Published</option>
        <option value="draft">Draft</option>
      </select>
      <select id="featuredFilter" class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 bg-white">
        <option value="">All Posts</option>
        <option value="1">Featured Only</option>
      </select>
      <button onclick="loadNews(1)" class="px-4 py-2.5 rounded-xl text-sm font-medium text-white hover:opacity-90 transition-all" style="background:#0d3051">Filter</button>
      <button onclick="clearFilters()" class="px-4 py-2.5 rounded-xl text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200">Clear</button>
    </div>
  </div>

  <!-- News Table -->
  <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr class="border-b border-gray-100">
            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider w-12">
              <input type="checkbox" id="selectAll" class="rounded border-gray-300" style="accent-color:#0d3051">
            </th>
            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Article</th>
            <th class="text-left px-4 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Author</th>
            <th class="text-left px-4 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Published</th>
            <th class="text-left px-4 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
            <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
          </tr>
        </thead>
        <tbody id="newsTableBody">
          <?php if(!empty($news)): foreach($news as $article): ?>
          <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
            <td class="px-6 py-4">
              <input type="checkbox" class="news-check rounded border-gray-300" value="<?= (int)$article['id'] ?>" style="accent-color:#0d3051">
            </td>
            <td class="px-6 py-4">
              <div class="flex items-center gap-3">
                <div class="w-14 h-14 rounded-xl overflow-hidden flex-shrink-0 bg-gray-100">
                  <?php if(!empty($article['featured_image'])): ?>
                  <img src="<?= BASE_URL ?>/uploads/news/<?= htmlspecialchars($article['featured_image']) ?>" alt="" class="w-full h-full object-cover">
                  <?php else: ?>
                  <div class="w-full h-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                  </div>
                  <?php endif; ?>
                </div>
                <div class="min-w-0">
                  <div class="flex items-center gap-2 mb-0.5">
                    <?php if($article['is_featured']): ?>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium text-yellow-700 bg-yellow-100">
                      ⭐ Featured
                    </span>
                    <?php endif; ?>
                  </div>
                  <p class="font-semibold text-gray-900 text-sm truncate max-w-xs"><?= htmlspecialchars($article['title']) ?></p>
                  <p class="text-xs text-gray-400 mt-0.5 truncate max-w-xs">/news/<?= htmlspecialchars($article['slug']) ?></p>
                </div>
              </div>
            </td>
            <td class="px-4 py-4 text-sm text-gray-600 hidden md:table-cell"><?= htmlspecialchars($article['author'] ?? 'Admin') ?></td>
            <td class="px-4 py-4 text-sm text-gray-500 hidden lg:table-cell">
              <?= !empty($article['published_at']) ? date('M d, Y', strtotime($article['published_at'])) : '—' ?>
            </td>
            <td class="px-4 py-4">
              <button onclick="toggleStatus(<?= $article['id'] ?>, this)"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium transition-all <?= $article['status'] === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' ?>">
                <span class="w-1.5 h-1.5 rounded-full inline-block <?= $article['status'] === 'published' ? 'bg-green-500' : 'bg-yellow-500' ?>"></span>
                <?= ucfirst($article['status']) ?>
              </button>
            </td>
            <td class="px-6 py-4">
              <div class="flex items-center justify-end gap-2">
                <a href="/news/<?= htmlspecialchars($article['slug']) ?>" target="_blank"
                  class="p-2 rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors" title="View">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
                <a href="/admin/news/edit/<?= $article['id'] ?>"
                  class="p-2 rounded-lg hover:bg-blue-50 text-gray-400 hover:text-blue-600 transition-colors" title="Edit">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </a>
                <button onclick="confirmDelete(<?= (int)$article['id'] ?>, <?= jsAttr($article['title']) ?>)"
                  class="p-2 rounded-lg hover:bg-red-50 text-gray-400 hover:text-red-600 transition-colors" title="Delete">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
              </div>
            </td>
          </tr>
          <?php endforeach; else: ?>
          <tr>
            <td colspan="6" class="px-6 py-16 text-center">
              <div class="flex flex-col items-center">
                <svg class="w-16 h-16 text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6M7 8h6"/></svg>
                <p class="text-gray-400 font-medium">No articles yet</p>
                <a href="/admin/news/create" class="mt-3 text-sm font-medium hover:underline" style="color:#0d3051">Write your first article →</a>
              </div>
            </td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <?php if(!empty($totalPages) && $totalPages > 1): ?>
    <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
      <p class="text-sm text-gray-500">
        Showing <?= (($currentPage-1)*ADMIN_PER_PAGE)+1 ?>–<?= min($currentPage*ADMIN_PER_PAGE, $totalNews) ?> of <?= $totalNews ?> articles
      </p>
      <div class="flex items-center gap-1">
        <?php for($i=1;$i<=$totalPages;$i++): ?>
        <button onclick="loadNews(<?= $i ?>)"
          class="px-3 py-1.5 rounded-lg text-sm font-medium transition-all <?= $i === $currentPage ? 'text-white' : 'text-gray-600 hover:bg-gray-100' ?>"
          style="<?= $i === $currentPage ? 'background:#0d3051' : '' ?>">
          <?= $i ?>
        </button>
        <?php endfor; ?>
      </div>
    </div>
    <?php endif; ?>
  </div>

  <!-- Bulk Actions -->
  <div id="bulkBar" class="hidden fixed bottom-6 left-1/2 -translate-x-1/2 bg-gray-900 text-white rounded-2xl shadow-2xl px-6 py-3 flex items-center gap-4 z-50">
    <span class="text-sm"><span id="bulkCount">0</span> selected</span>
    <button onclick="bulkPublish()" class="text-sm px-3 py-1.5 rounded-lg bg-green-500 hover:bg-green-600 font-medium">Publish</button>
    <button onclick="bulkDraft()" class="text-sm px-3 py-1.5 rounded-lg bg-yellow-500 hover:bg-yellow-600 font-medium">Draft</button>
    <button onclick="bulkDelete()" class="text-sm px-3 py-1.5 rounded-lg bg-red-500 hover:bg-red-600 font-medium">Delete</button>
    <button onclick="clearSelection()" class="text-gray-400 hover:text-white">✕</button>
  </div>
</div>

<script>
// Select all
document.getElementById('selectAll').addEventListener('change', function() {
  document.querySelectorAll('.news-check').forEach(c => c.checked = this.checked);
  updateBulkBar();
});
document.addEventListener('change', e => { if(e.target.classList.contains('news-check')) updateBulkBar(); });

function updateBulkBar() {
  const selected = document.querySelectorAll('.news-check:checked');
  const bar = document.getElementById('bulkBar');
  document.getElementById('bulkCount').textContent = selected.length;
  bar.classList.toggle('hidden', selected.length === 0);
  bar.classList.toggle('flex', selected.length > 0);
}
function clearSelection() {
  document.querySelectorAll('.news-check').forEach(c => c.checked = false);
  document.getElementById('selectAll').checked = false;
  updateBulkBar();
}
function getSelected() { return [...document.querySelectorAll('.news-check:checked')].map(c => c.value); }

async function toggleStatus(id, btn) {
  try {
    const res = await fetch(`/admin/news/toggle-status/${id}`, { method: 'POST', headers: {'X-Requested-With':'XMLHttpRequest'}, body: new URLSearchParams({csrf_token: '<?= generate_csrf() ?>'}) });
    const data = await res.json();
    if (data.success) {
      const isPublished = data.status === 'published';
      btn.className = `inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium transition-all ${isPublished ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'}`;
      btn.innerHTML = `<span class="w-1.5 h-1.5 rounded-full inline-block ${isPublished ? 'bg-green-500' : 'bg-yellow-500'}"></span>${isPublished ? 'Published' : 'Draft'}`;
      showToast(`Article ${data.status}`, 'success');
    }
  } catch(e) { showToast('Error', 'error'); }
}

function confirmDelete(id, title) {
  adminDelete(`/admin/news/delete/${id}`, `Delete "${title}"? This action cannot be undone.`, () => {
    document.querySelector(`input[value="${id}"].news-check`)?.closest('tr')?.remove();
  });
}

async function bulkDelete() {
  const ids = getSelected();
  if (!ids.length) return;
  adminDelete('/admin/news/bulk-delete', `Delete ${ids.length} articles? This cannot be undone.`, () => {
    setTimeout(() => location.reload(), 600);
  }).then(res => {
    if (res && res.success) location.reload();
  });
}
async function bulkPublish() {
  const ids = getSelected();
  if (!ids.length) return;
  const res = await fetch('/admin/news/bulk-status', { method: 'POST', body: new URLSearchParams({ ids: ids.join(','), status: 'published', csrf_token: '<?= generate_csrf() ?>' }) });
  const data = await res.json();
  if (data.success) { showToast(`${ids.length} articles published`, 'success'); location.reload(); }
}
async function bulkDraft() {
  const ids = getSelected();
  if (!ids.length) return;
  const res = await fetch('/admin/news/bulk-status', { method: 'POST', body: new URLSearchParams({ ids: ids.join(','), status: 'draft', csrf_token: '<?= generate_csrf() ?>' }) });
  const data = await res.json();
  if (data.success) { showToast(`${ids.length} articles set to draft`, 'success'); location.reload(); }
}

function clearFilters() {
  document.getElementById('newsSearch').value = '';
  document.getElementById('statusFilter').value = '';
  document.getElementById('featuredFilter').value = '';
  loadNews(1);
}
function loadNews(page) { window.location.href = `/admin/news?page=${page}&q=${document.getElementById('newsSearch').value}&status=${document.getElementById('statusFilter').value}&featured=${document.getElementById('featuredFilter').value}`; }
document.getElementById('newsSearch').addEventListener('keydown', e => { if(e.key==='Enter') loadNews(1); });
</script>
