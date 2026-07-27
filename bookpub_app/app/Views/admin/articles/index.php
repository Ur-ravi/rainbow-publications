<?php
$pageTitle = 'Article Submissions';
// Defensive defaults — used when this view is rendered from an error fallback (e.g. show() of a missing record).
$articles      = $articles      ?? [];
$total         = $total         ?? 0;
$pag           = $pag           ?? ['total_pages' => 0, 'current_page' => 1];
$journals      = $journals      ?? [];
$q             = $q             ?? '';
$journalFilter = $journalFilter ?? 0;
$status        = $status        ?? '';
$sort          = $sort          ?? 'created_at';
$dir           = $dir           ?? 'desc';
$error         = $error         ?? null;
?>

<?php if (!empty($error)): ?>
<div class="mb-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl p-4 flex items-start gap-3" role="alert">
    <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
    <div>
        <p class="font-semibold text-red-800 text-sm"><?= htmlspecialchars($error) ?></p>
    </div>
</div>
<?php endif; ?>

<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <div>
        <h1 class="text-2xl font-serif font-bold text-primary">Article Submissions</h1>
        <p class="text-gray-500 text-sm mt-1">Manage articles submitted via the public form.</p>
    </div>
    <div class="flex items-center gap-2">
        <div class="relative inline-block">
            <button onclick="document.getElementById('exportMenu').classList.toggle('hidden')"
                    class="px-3 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 transition flex items-center gap-2">
                <i class="fas fa-download"></i> Export <i class="fas fa-caret-down text-xs"></i>
            </button>
            <div id="exportMenu" class="hidden absolute right-0 mt-1 bg-white shadow-lg rounded-xl border border-gray-100 z-20 min-w-[180px] py-1">
                <?php $qs = http_build_query(array_filter(['status' => $status, 'journal_id' => $journalFilter, 'q' => $q])); ?>
                <a href="<?= BASE_URL ?>/admin/articles/export?format=csv&<?= $qs ?>" class="block px-4 py-2 text-sm hover:bg-gray-50"><i class="fas fa-file-csv text-green-500 w-5"></i> CSV</a>
                <a href="<?= BASE_URL ?>/admin/articles/export?format=xlsx&<?= $qs ?>" class="block px-4 py-2 text-sm hover:bg-gray-50"><i class="fas fa-file-excel text-emerald-600 w-5"></i> Excel</a>
                <a href="<?= BASE_URL ?>/admin/articles/export?format=pdf&<?= $qs ?>" class="block px-4 py-2 text-sm hover:bg-gray-50"><i class="fas fa-file-pdf text-red-500 w-5"></i> PDF</a>
            </div>
        </div>
        <span class="text-sm text-gray-500"><strong class="text-gray-800"><?= (int)$total ?></strong> total</span>
    </div>
</div>

<!-- Filters / Search -->
<form method="GET" action="<?= BASE_URL ?>/admin/articles" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-4 grid md:grid-cols-12 gap-3">
    <div class="md:col-span-5">
        <label class="block text-xs font-semibold text-gray-600 mb-1">Search</label>
        <div class="relative">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Title, author name, email…"
                class="w-full pl-9 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary">
        </div>
    </div>
    <div class="md:col-span-3">
        <label class="block text-xs font-semibold text-gray-600 mb-1">Journal</label>
        <select name="journal_id" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary">
            <option value="">— All journals —</option>
            <?php foreach ($journals as $j): ?>
            <option value="<?= (int)$j['id'] ?>" <?= (int)$journalFilter === (int)$j['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($j['name']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="md:col-span-2">
        <label class="block text-xs font-semibold text-gray-600 mb-1">Status</label>
        <select name="status" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary">
            <option value="">— All —</option>
            <?php foreach (['draft' => 'Draft', 'submitted' => 'Submitted', 'under_review' => 'Under Review', 'accepted' => 'Accepted', 'rejected' => 'Rejected', 'published' => 'Published'] as $k => $v): ?>
            <option value="<?= $k ?>" <?= $status === $k ? 'selected' : '' ?>><?= $v ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="md:col-span-2 flex items-end gap-2">
        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-primary-dark transition flex-1">
            <i class="fas fa-filter mr-1"></i> Apply
        </button>
        <a href="<?= BASE_URL ?>/admin/articles" class="px-3 py-2 border border-gray-200 rounded-lg text-sm text-gray-600 hover:bg-gray-50 transition">
            <i class="fas fa-times"></i>
        </a>
    </div>
</form>

<?php if (empty($articles)): ?>
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
    <i class="fas fa-file-alt text-4xl text-gray-300 mb-3 block"></i>
    <h3 class="text-lg font-bold text-gray-700 mb-1">No articles found</h3>
    <p class="text-gray-400 text-sm">Articles submitted via the public form will appear here.</p>
</div>
<?php else: ?>
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <?php
                    function sortLink($field, $label, $currentSort, $currentDir, $baseQS) {
                        $newDir = ($currentSort === $field && $currentDir === 'asc') ? 'desc' : 'asc';
                        $arrow  = $currentSort === $field ? ($currentDir === 'asc' ? '↑' : '↓') : '';
                        $qs     = http_build_query(array_merge($baseQS, ['sort' => $field, 'dir' => $newDir]));
                        return '<a href="' . BASE_URL . '/admin/articles?' . $qs . '" class="hover:text-primary">' . htmlspecialchars($label) . ' <span class="text-primary">' . $arrow . '</span></a>';
                    }
                    $baseQS = array_filter(['q' => $q, 'journal_id' => $journalFilter, 'status' => $status]);
                    ?>
                    <th class="text-left text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3"><?= sortLink('title', 'Title', $sort, $dir, $baseQS) ?></th>
                    <th class="text-left text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3"><?= sortLink('journal_name', 'Journal', $sort, $dir, $baseQS) ?></th>
                    <th class="text-left text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3">Section</th>
                    <th class="text-left text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3">Author(s)</th>
                    <th class="text-center text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3">Status</th>
                    <th class="text-left text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3"><?= sortLink('created_at', 'Submitted', $sort, $dir, $baseQS) ?></th>
                    <th class="text-right text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $a):
                    $contribs = !empty($a['contributors']) ? (json_decode($a['contributors'], true) ?: []) : [];
                    $authorNames = array_slice(array_map(fn($c) => $c['name'] ?? '', $contribs), 0, 3);
                    $statusColors = [
                        'draft'        => 'bg-gray-100 text-gray-600',
                        'submitted'    => 'bg-blue-100 text-blue-700',
                        'under_review' => 'bg-amber-100 text-amber-700',
                        'accepted'     => 'bg-green-100 text-green-700',
                        'rejected'     => 'bg-red-100 text-red-700',
                        'published'    => 'bg-purple-100 text-purple-700',
                    ];
                    $cls = $statusColors[$a['review_status']] ?? 'bg-gray-100 text-gray-700';
                ?>
                <tr class="border-t border-gray-50 hover:bg-gray-50/50 transition">
                    <td class="px-5 py-3">
                        <div class="font-semibold text-gray-800 text-sm leading-tight max-w-[260px]" title="<?= htmlspecialchars($a['title']) ?>">
                            <?= htmlspecialchars(strlen($a['title']) > 60 ? mb_substr($a['title'], 0, 60) . '…' : $a['title']) ?>
                        </div>
                        <?php if (!empty($a['subtitle'])): ?>
                        <div class="text-xs text-gray-400 mt-0.5"><?= htmlspecialchars(mb_substr($a['subtitle'], 0, 60)) ?></div>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-3"><span class="text-sm text-gray-700"><?= htmlspecialchars($a['journal_name']) ?></span></td>
                    <td class="px-5 py-3"><span class="text-xs px-2 py-1 rounded bg-gray-100 text-gray-600 font-semibold"><?= htmlspecialchars($a['section']) ?></span></td>
                    <td class="px-5 py-3 text-sm text-gray-600">
                        <?= htmlspecialchars(implode(', ', $authorNames)) ?>
                        <?php if (count($contribs) > 3): ?> <span class="text-xs text-gray-400">+<?= count($contribs) - 3 ?> more</span><?php endif; ?>
                    </td>
                    <td class="px-5 py-3 text-center">
                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-bold uppercase <?= $cls ?>"><?= htmlspecialchars(str_replace('_', ' ', $a['review_status'])) ?></span>
                    </td>
                    <td class="px-5 py-3 text-xs text-gray-600">
                        <?= formatDate($a['created_at']) ?>
                        <div class="text-gray-400"><?= date('H:i', strtotime($a['created_at'])) ?></div>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="inline-flex items-center gap-1">
                            <a href="<?= BASE_URL ?>/admin/articles/show/<?= $a['id'] ?>" class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-primary/10 text-gray-400 hover:text-primary inline-flex items-center justify-center transition" title="View"><i class="fas fa-eye text-xs"></i></a>
                            <a href="<?= BASE_URL ?>/admin/articles/edit/<?= $a['id'] ?>" class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-blue-50 text-gray-400 hover:text-blue-600 inline-flex items-center justify-center transition" title="Edit"><i class="fas fa-pen text-xs"></i></a>
                            <button onclick="deleteArticle(<?= $a['id'] ?>)" class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-red-50 text-gray-400 hover:text-red-500 inline-flex items-center justify-center transition" title="Delete"><i class="fas fa-trash text-xs"></i></button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if ($pag['total_pages'] > 1): ?>
<div class="pagination mt-6 flex justify-center gap-2 flex-wrap">
    <?php
    $pageBase = array_filter(['q' => $q, 'journal_id' => $journalFilter, 'status' => $status, 'sort' => $sort, 'dir' => $dir]);
    for ($p = 1; $p <= $pag['total_pages']; $p++):
        $pageBase['page'] = $p;
    ?>
    <a href="<?= BASE_URL ?>/admin/articles?<?= http_build_query($pageBase) ?>"
       class="px-3 py-1.5 rounded-lg text-sm font-semibold <?= $p == $pag['current_page'] ? 'bg-primary text-white' : 'bg-white border border-gray-200 text-gray-600' ?>">
        <?= $p ?>
    </a>
    <?php endfor; ?>
</div>
<?php endif; ?>
<?php endif; ?>

<script>
function deleteArticle(id) {
    adminDelete(`/admin/articles/delete/${id}`, 'Delete this article submission? All uploaded files will be removed.', () => {
        setTimeout(() => location.reload(), 500);
    });
}
document.addEventListener('click', e => {
    if (!e.target.closest('#exportMenu') && !e.target.closest('button')) {
        document.getElementById('exportMenu')?.classList.add('hidden');
    }
});
</script>
