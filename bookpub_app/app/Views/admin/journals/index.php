<?php $pageTitle = 'Manage Journals'; ?>
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-serif font-bold text-primary">Our Journals</h1>
        <p class="text-gray-500 text-sm mt-1">Manage journal cards shown on the website.</p>
    </div>
    <a href="<?= BASE_URL ?>/admin/journals/add"
       class="flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-primary-dark transition shadow-sm self-stretch sm:self-auto justify-center">
        <i class="fas fa-plus"></i> Add Journal
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-4 border-b border-gray-100 flex flex-col sm:flex-row gap-4 items-center justify-between">
        <form method="GET" class="flex gap-2 w-full sm:w-auto">
            <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                   placeholder="Search journals…"
                   class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:border-primary w-full sm:w-64">
            <button type="submit" class="bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-lg text-sm text-gray-600 transition shrink-0">
                <i class="fas fa-search"></i>
            </button>
        </form>
        <span class="text-sm text-gray-400 self-end sm:self-auto">
            <?= count($journals ?? []) ?> journal<?= count($journals ?? []) != 1 ? 's' : '' ?>
        </span>
    </div>

    <?php if(empty($journals)): ?>
    <div class="text-center py-16 text-gray-400">
        <i class="fas fa-journal-whills text-4xl mb-3 block opacity-30"></i>
        <p class="font-medium">No journals found.</p>
        <a href="<?= BASE_URL ?>/admin/journals/add" class="text-primary hover:underline text-sm mt-2 inline-block">Add your first journal →</a>
    </div>
    <?php else: ?>

    <div id="journalList" class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        <?php foreach($journals as $j): ?>
        <div class="journal-admin-card border-2 <?= $j['is_active'] ? 'border-gray-100' : 'border-dashed border-gray-200 opacity-70' ?> rounded-xl p-4 bg-gray-50 relative group transition-all duration-200 hover:border-primary/20 hover:shadow-md"
             data-id="<?= $j['id'] ?>">

            <div class="absolute top-3 left-3 text-gray-300 hover:text-gray-500 cursor-grab active:cursor-grabbing drag-handle p-1">
                <i class="fas fa-grip-vertical"></i>
            </div>

            <div class="absolute top-3 right-3">
                <span class="text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider <?= $j['is_active'] ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-500' ?>">
                    <?= ($j['is_active'] ? 'Active' : 'Inactive') ?>
                </span>
            </div>

            <div class="flex justify-center my-4 mt-8">
                <?php if($j['logo']): ?>
                <img src="<?= uploadUrl('journals', $j['logo']) ?>"
                     alt="<?= htmlspecialchars($j['name']) ?>"
                     class="w-16 h-16 object-contain mix-blend-multiply">
                <?php else: ?>
                <div class="w-16 h-16 rounded-xl bg-primary/10 flex items-center justify-center">
                    <i class="fas fa-journal-whills text-primary/50 text-2xl"></i>
                </div>
                <?php endif; ?>
            </div>

            <div class="text-center min-h-[75px] flex flex-col justify-center mb-4">
                <h4 class="text-primary font-bold text-sm leading-tight mb-1 font-serif line-clamp-2 px-2">
                    <?= htmlspecialchars($j['name']) ?>
                </h4>
                <?php if($j['abbreviation']): ?>
                <p class="text-secondary text-xs font-medium mb-0.5">(<?= htmlspecialchars($j['abbreviation']) ?>)</p>
                <?php endif; ?>
                <?php if($j['issn']): ?>
                <p class="text-gray-400 text-[11px]">ISSN: <?= htmlspecialchars($j['issn']) ?></p>
                <?php endif; ?>
            </div>

            <div class="flex gap-1.5 justify-center items-center opacity-100 sm:opacity-0 group-hover:opacity-100 transition-opacity duration-200 border-t border-gray-200/60 pt-3">
                <a href="<?= BASE_URL ?>/admin/journals/edit/<?= $j['id'] ?>"
                   class="text-xs bg-primary text-white px-2.5 py-1.5 rounded-lg hover:bg-primary-dark transition flex items-center gap-1"
                   title="Edit Journal">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <button onclick="confirmDelete('<?= BASE_URL ?>/admin/journals/delete/<?= $j['id'] ?>')"
                        class="text-xs bg-red-500 text-white p-1.5 h-8 w-8 rounded-lg hover:bg-red-600 transition flex items-center justify-center"
                        title="Delete Journal">
                    <i class="fas fa-trash"></i>
                </button>
                <!--<button onclick="toggleStatus(<?= $j['id'] ?>,'journals')"-->
                <!--        class="text-xs bg-white border border-gray-200 text-gray-600 p-1.5 h-8 w-8 rounded-lg hover:bg-gray-50 transition flex items-center justify-center"-->
                <!--        title="Toggle Status">-->
                <!--    <i class="fas fa-toggle-<?= $j['is_active'] ? 'on text-green-600' : 'off' ?> text-sm"></i>-->
                <!--</button>-->
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>
// Drag-to-reorder Engine
const list = document.getElementById('journalList');
if (list) {
    Sortable.create(list, {
        handle: '.drag-handle',
        animation: 150,
        onEnd: async function() {
            try {
                const ids = [...list.querySelectorAll('.journal-admin-card')].map(c => c.dataset.id);
                const res = await adminPost('<?= BASE_URL ?>/admin/journals/reorder', { ids: ids.join(',') });
                const data = (res && typeof res.json === 'function') ? await res.json() : res;
                
                showToast((data && data.message) || 'Order saved!', (data && data.success) ? 'success' : 'error');
            } catch (err) {
                console.error("Reorder error:", err);
                showToast('Failed to save order.', 'error');
            }
        }
    });
}

// Toggle Status Feature
async function toggleStatus(id, module) {
    try {
        const res = await adminPost(`<?= BASE_URL ?>/admin/${module}/toggle/${id}`, {});
        const data = (res && typeof res.json === 'function') ? await res.json() : res;
        
        if (data && data.success) {
            showToast(data.message || 'Status updated!', 'success');
            setTimeout(() => location.reload(), 700);
        } else {
            showToast((data && data.message) || 'Failed to update status.', 'error');
        }
    } catch (err) {
        console.error("Toggle error:", err);
        showToast('Failed to update status.', 'error');
    }
}

function confirmDelete(url) {
    showConfirm("Are you sure you want to delete this journal? This action cannot be undone.", async () => {
        try {
            const res = await adminPost(url, {});
            const data = (res && typeof res.json === 'function') ? await res.json() : res;
            
            if (data && data.success) {
                showToast(data.message || 'Deleted successfully', 'success');
                setTimeout(() => location.reload(), 700);
            } else {
                showToast((data && data.message) || 'Delete failed.', 'error');
            }
        } catch (err) {
            console.error("Delete error:", err);
            showToast('Delete failed. Please try again.', 'error');
        }
    });
}
</script>