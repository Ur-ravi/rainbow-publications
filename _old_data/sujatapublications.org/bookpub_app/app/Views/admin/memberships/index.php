<?php $pageTitle = 'Membership Plans'; ?>
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-serif font-bold text-primary">Membership Plans</h1>
        <p class="text-gray-500 text-sm mt-1">Manage subscription plans shown on the membership page.</p>
    </div>
    <a href="<?= BASE_URL ?>/admin/memberships/add"
       class="flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-primary-dark transition">
        <i class="fas fa-plus"></i> Add Plan
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <?php if(empty($memberships)): ?>
    <div class="text-center py-16 text-gray-400">
        <i class="fas fa-id-card text-4xl mb-3 block opacity-30"></i>
        <p class="font-medium">No membership plans yet.</p>
        <a href="<?= BASE_URL ?>/admin/memberships/add" class="text-primary hover:underline text-sm mt-2 inline-block">Create your first plan →</a>
    </div>
    <?php else: ?>

    <!-- Cards -->
    <div class="p-6 grid sm:grid-cols-2 lg:grid-cols-3 gap-6" id="plansList">
        <?php foreach($memberships as $plan): ?>
        <div class="relative border-2 rounded-2xl p-6 group transition
                    <?= $plan['is_featured'] ? 'border-secondary' : 'border-gray-200 hover:border-gray-300' ?>"
             data-id="<?= $plan['id'] ?>">

            <?php if($plan['is_featured']): ?>
            <span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-secondary text-white text-xs px-4 py-1 rounded-full font-bold">
                ★ Featured
            </span>
            <?php endif; ?>

            <!-- Status -->
            <div class="flex justify-between items-start mb-4">
                <span class="text-xs px-2.5 py-1 rounded-full font-bold
                    <?= $plan['status']==='active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-400' ?>">
                    <?= ucfirst($plan['status']) ?>
                </span>
                <span class="drag-handle text-gray-300 cursor-grab">
                    <i class="fas fa-grip-vertical"></i>
                </span>
            </div>

            <h3 class="font-serif text-xl font-bold text-primary mb-1"><?= htmlspecialchars($plan['name']) ?></h3>
            <?php if($plan['description']): ?>
            <p class="text-gray-500 text-xs mb-3"><?= htmlspecialchars($plan['description']) ?></p>
            <?php endif; ?>

            <!-- Price -->
            <div class="text-2xl font-black text-primary mb-4">
                <?= $plan['price'] ? ($plan['currency'] ?? '₹').number_format((float)$plan['price']) : 'Free' ?>
                <?php if($plan['duration']): ?>
                <span class="text-gray-400 text-sm font-normal">/ <?= htmlspecialchars($plan['duration']) ?></span>
                <?php endif; ?>
            </div>

            <!-- Features preview -->
            <?php if($plan['features']): ?>
            <div class="text-xs text-gray-500 mb-4 space-y-1 max-h-24 overflow-hidden">
                <?php
                $fts = is_array($plan['features']) ? $plan['features'] : explode("\n", $plan['features']);
                foreach(array_slice($fts, 0, 4) as $ft):
                    $ft = trim($ft);
                    if(!$ft) continue;
                ?>
                <div class="flex items-center gap-1.5">
                    <i class="fas fa-check text-green-500 text-xs"></i>
                    <?= htmlspecialchars(ltrim($ft, '-')) ?>
                </div>
                <?php endforeach; ?>
                <?php if(count($fts) > 4): ?>
                <p class="text-gray-400 italic">+<?= count($fts)-4 ?> more…</p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- Actions -->
            <div class="flex gap-2 pt-4 border-t border-gray-100">
                <a href="<?= BASE_URL ?>/admin/memberships/edit/<?= $plan['id'] ?>"
                   class="flex-1 text-center text-xs bg-primary/10 text-primary px-3 py-1.5 rounded-lg hover:bg-primary hover:text-white transition font-medium">
                    <i class="fas fa-edit mr-1"></i>Edit
                </a>
                <button onclick="confirmDelete('<?= BASE_URL ?>/admin/memberships/delete/<?= $plan['id'] ?>')"
                        class="text-xs bg-red-50 text-red-500 px-3 py-1.5 rounded-lg hover:bg-red-500 hover:text-white transition font-medium">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>
function confirmDelete(url) {
    adminDelete(url, 'Delete this membership plan? This cannot be undone.', () => {
        setTimeout(() => location.reload(), 500);
    });
}
const plansList = document.getElementById('plansList');
if (plansList) {
    Sortable.create(plansList, {
        handle:'.drag-handle', animation:150,
        onEnd: async function() {
            const ids = [...plansList.children].map(c=>c.dataset.id);
            await adminPost('/admin/memberships/reorder', {ids: ids.join(',')});
            showToast('Order updated!', 'success');
        }
    });
}
</script>
<?php
