<?php $pageTitle = 'Conferences'; ?>
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-serif font-bold text-primary">Conferences</h1>
        <p class="text-gray-500 text-sm mt-1">Manage all conferences shown on your website. Use "Show on Home" in each conference's settings to pick which one appears on the home page.</p>
    </div>
    <a href="<?= BASE_URL ?>/admin/conferences/add"
       class="bg-secondary text-white px-5 py-2.5 rounded-xl font-semibold text-sm flex items-center gap-2 hover:bg-secondary-dark transition">
        <i class="fas fa-plus"></i> Add Conference
    </a>
</div>

<?php if (empty($conferences)): ?>
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
    <div class="w-20 h-20 mx-auto bg-gray-50 rounded-2xl flex items-center justify-center mb-4">
        <i class="fas fa-calendar-alt text-3xl text-gray-300"></i>
    </div>
    <h3 class="text-lg font-bold text-gray-700 mb-1">No conferences yet</h3>
    <p class="text-gray-400 text-sm mb-4">Start by adding your first conference.</p>
    <a href="<?= BASE_URL ?>/admin/conferences/add"
       class="inline-flex items-center gap-2 text-secondary font-semibold text-sm hover:underline">
       <i class="fas fa-plus"></i> Add your first conference
    </a>
</div>
<?php else: ?>
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3">Poster</th>
                <th class="text-left text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3">Title</th>
                <th class="text-left text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3">Date</th>
                <th class="text-center text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3">Home</th>
                <th class="text-center text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3">Status</th>
                <th class="text-right text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($conferences as $c): ?>
            <tr class="border-t border-gray-50 hover:bg-gray-50/50 transition">
                <td class="px-5 py-3">
                    <?php if (!empty($c['poster_image'])): ?>
                    <img src="<?= uploadUrl('conferences', $c['poster_image']) ?>"
                         alt="" class="w-14 h-14 object-cover rounded-lg border border-gray-100">
                    <?php else: ?>
                    <div class="w-14 h-14 bg-gray-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-image text-gray-300"></i>
                    </div>
                    <?php endif; ?>
                </td>
                <td class="px-5 py-3">
                    <div class="font-semibold text-gray-800 text-sm leading-snug"><?= htmlspecialchars($c['title']) ?></div>
                    <?php if (!empty($c['subtitle'])): ?>
                    <div class="text-xs text-gray-400 mt-0.5"><?= htmlspecialchars(mb_strimwidth($c['subtitle'], 0, 70, '…')) ?></div>
                    <?php endif; ?>
                </td>
                <td class="px-5 py-3">
                    <?php if (!empty($c['conference_date'])): ?>
                    <span class="text-sm text-gray-700 font-medium"><?= formatDate($c['conference_date']) ?></span>
                    <?php else: ?>
                    <span class="text-xs text-gray-400 italic">No date set</span>
                    <?php endif; ?>
                </td>
                <td class="px-5 py-3 text-center">
                    <?php if (!empty($c['is_featured'])): ?>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold" title="Featured on home page">
                            <i class="fas fa-home text-[10px]"></i> Home
                        </span>
                    <?php else: ?>
                        <span class="text-xs text-gray-400">—</span>
                    <?php endif; ?>
                </td>
                <td class="px-5 py-3 text-center">
                    <button onclick="toggleStatus(<?= $c['id'] ?>, this)" class="inline-flex items-center gap-1.5 transition"
                            title="Click to toggle status">
                        <i class="fas fa-toggle-<?= $c['is_active'] ? 'on text-green-500' : 'off text-gray-400' ?> text-xl"></i>
                        <span class="text-xs font-semibold <?= $c['is_active'] ? 'text-green-600' : 'text-gray-400' ?>">
                            <?= $c['is_active'] ? 'Active' : 'Inactive' ?>
                        </span>
                    </button>
                </td>
                <td class="px-5 py-3 text-right">
                    <div class="inline-flex items-center gap-1">
                        <button onclick="toggleFeatured(<?= $c['id'] ?>, this)"
                                class="w-8 h-8 rounded-lg <?= !empty($c['is_featured']) ? 'bg-amber-100 text-amber-600 hover:bg-amber-200' : 'bg-gray-50 hover:bg-amber-50 text-gray-400 hover:text-amber-500' ?> inline-flex items-center justify-center transition"
                                title="<?= !empty($c['is_featured']) ? 'Showing on home page — click to remove' : 'Show on home page' ?>">
                            <i class="fas fa-home text-xs"></i>
                        </button>
                        <a href="<?= BASE_URL ?>/conference/<?= htmlspecialchars($c['slug']) ?>" target="_blank"
                           class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-blue-50 text-gray-400 hover:text-blue-500 inline-flex items-center justify-center transition" title="View">
                            <i class="fas fa-eye text-xs"></i>
                        </a>
                        <a href="<?= BASE_URL ?>/admin/conferences/edit/<?= $c['id'] ?>"
                           class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-primary/10 text-gray-400 hover:text-primary inline-flex items-center justify-center transition" title="Edit">
                            <i class="fas fa-edit text-xs"></i>
                        </a>
                        <button onclick="deleteConference(<?= $c['id'] ?>)"
                                class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-red-50 text-gray-400 hover:text-red-500 inline-flex items-center justify-center transition" title="Delete">
                            <i class="fas fa-trash text-xs"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>

<script>
async function toggleStatus(id, btn) {
    try {
        const d = await adminPost('/admin/conferences/toggle/' + id, {});
        if (d.success) {
            showToast(d.message || 'Updated', 'success');
            setTimeout(() => location.reload(), 400);
        } else {
            showToast(d.message || 'Failed', 'error');
        }
    } catch (e) { showToast('Network error', 'error'); }
}

async function toggleFeatured(id, btn) {
    try {
        const d = await adminPost('/admin/conferences/toggle-featured/' + id, {});
        showToast(d.message || 'Updated', d.success ? 'success' : 'error');
        if (d.success) setTimeout(() => location.reload(), 400);
    } catch (e) { showToast('Network error', 'error'); }
}

function deleteConference(id) {
    adminDelete('/admin/conferences/delete/' + id, 'Delete this conference? This cannot be undone.', () => {
        setTimeout(() => location.reload(), 500);
    });
}
</script>
