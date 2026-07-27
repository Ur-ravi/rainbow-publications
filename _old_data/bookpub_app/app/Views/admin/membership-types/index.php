<?php
$pageTitle = 'Membership Types';
$palette = [
    'purple' => '#534AB7', 'blue' => '#185FA5', 'amber' => '#BA7517',
    'green'  => '#3B6D11', 'pink' => '#993C1D', 'teal' => '#0F6E56',
    'coral'  => '#C2410C', 'red' => '#A32D2D', 'gray' => '#5F5E5A',
];
?>
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-serif font-bold text-primary">Membership Types</h1>
        <p class="text-gray-500 text-sm mt-1">Manage the detailed cards shown on <a href="<?= BASE_URL ?>/membership-types" target="_blank" class="text-primary underline">/membership-types</a></p>
    </div>
    <a href="<?= BASE_URL ?>/admin/membership-types/add"
       class="bg-secondary text-white px-5 py-2.5 rounded-xl font-semibold text-sm flex items-center gap-2 hover:bg-secondary-dark transition">
        <i class="fas fa-plus"></i> Add Type
    </a>
</div>

<?php if (empty($types)): ?>
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
    <div class="w-20 h-20 mx-auto bg-gray-50 rounded-2xl flex items-center justify-center mb-4">
        <i class="fas fa-id-card-alt text-3xl text-gray-300"></i>
    </div>
    <h3 class="text-lg font-bold text-gray-700 mb-1">No membership types yet</h3>
    <p class="text-gray-400 text-sm mb-4">Start by adding your first membership category.</p>
    <a href="<?= BASE_URL ?>/admin/membership-types/add"
       class="inline-flex items-center gap-2 text-secondary font-semibold text-sm hover:underline">
        <i class="fas fa-plus"></i> Add your first type
    </a>
</div>
<?php else: ?>
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-100">
            <tr>
                <th class="text-left text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3 w-16">#</th>
                <th class="text-left text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3">Title</th>
                <th class="text-left text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3">Fee</th>
                <th class="text-center text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3">Color</th>
                <th class="text-center text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3">Status</th>
                <th class="text-right text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($types as $t):
                $accent = $palette[$t['card_color']] ?? $palette['purple'];
            ?>
            <tr class="border-t border-gray-50 hover:bg-gray-50/50 transition">
                <td class="px-5 py-3">
                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-white font-bold text-xs" style="background: <?= $accent ?>;">
                        <?= (int)$t['badge_number'] ?>
                    </span>
                </td>
                <td class="px-5 py-3">
                    <div class="font-semibold text-gray-800 text-sm"><?= htmlspecialchars($t['title']) ?></div>
                    <div class="text-xs text-gray-400 font-mono mt-0.5"><?= htmlspecialchars($t['slug']) ?></div>
                </td>
                <td class="px-5 py-3 font-semibold text-sm" style="color: <?= $accent ?>;">
                    <?= htmlspecialchars($t['fee_label'] ?? '—') ?>
                </td>
                <td class="px-5 py-3 text-center">
                    <span class="inline-block w-6 h-6 rounded-full border-2 border-white shadow-sm" style="background: <?= $accent ?>;" title="<?= htmlspecialchars($t['card_color']) ?>"></span>
                </td>
                <td class="px-5 py-3 text-center">
                    <button onclick="toggleStatus(<?= $t['id'] ?>)" class="inline-flex items-center gap-1.5 transition" title="Click to toggle">
                        <i class="fas fa-toggle-<?= $t['is_active'] ? 'on text-green-500' : 'off text-gray-400' ?> text-xl"></i>
                        <span class="text-xs font-semibold <?= $t['is_active'] ? 'text-green-600' : 'text-gray-400' ?>">
                            <?= $t['is_active'] ? 'Active' : 'Inactive' ?>
                        </span>
                    </button>
                </td>
                <td class="px-5 py-3 text-right">
                    <div class="inline-flex items-center gap-1">
                        <a href="<?= BASE_URL ?>/admin/membership-types/edit/<?= $t['id'] ?>"
                           class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-primary/10 text-gray-400 hover:text-primary inline-flex items-center justify-center transition" title="Edit">
                            <i class="fas fa-edit text-xs"></i>
                        </a>
                        <button onclick="deleteType(<?= $t['id'] ?>)"
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
async function toggleStatus(id) {
    try {
        const d = await adminPost('/admin/membership-types/toggle/' + id, {});
        showToast(d.message || 'Updated', d.success ? 'success' : 'error');
        if (d.success) setTimeout(() => location.reload(), 400);
    } catch (e) { showToast('Network error', 'error'); }
}
function deleteType(id) {
    adminDelete('/admin/membership-types/delete/' + id, 'Delete this membership type? This cannot be undone.', () => {
        setTimeout(() => location.reload(), 500);
    });
}
</script>
