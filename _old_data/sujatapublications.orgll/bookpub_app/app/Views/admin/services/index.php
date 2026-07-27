<?php $pageTitle = 'Services'; ?>
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-serif font-bold text-primary">Services</h1>
        <p class="text-gray-500 text-sm mt-1">Manage services displayed on the website.</p>
    </div>
    <a href="<?= BASE_URL ?>/admin/services/add"
       class="inline-flex items-center justify-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-primary-dark shadow-sm hover:shadow-md transition duration-200">
        <i class="fas fa-plus text-xs"></i> Add Service
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <?php if(empty($services)): ?>
    <div class="text-center py-16 px-4">
        <div class="w-16 h-16 bg-gray-50 text-gray-400 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-cogs text-2xl opacity-60"></i>
        </div>
        <p class="font-semibold text-gray-700">No services yet.</p>
        <p class="text-gray-400 text-sm mt-1 mb-4">Get started by creating your very first service option.</p>
        <a href="<?= BASE_URL ?>/admin/services/add" class="text-primary hover:text-primary-dark font-medium text-sm inline-flex items-center gap-1 transition duration-200">Add first service →</a>
    </div>
    <?php else: ?>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/70 border-b border-gray-100 text-xs font-bold text-gray-500 uppercase tracking-wider select-none">
                    <th class="px-6 py-4 w-12 text-center">Order</th>
                    <th class="px-4 py-4">Service Details</th>
                    <th class="px-4 py-4 hidden md:table-cell">Slug Route</th>
                    <th class="px-4 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody id="servicesList" class="divide-y divide-gray-100">
                <?php foreach($services as $service): ?>
                <tr class="hover:bg-gray-50/60 transition duration-150 group" data-id="<?= $service['id'] ?>">
                    <td class="px-6 py-4.5 text-center whitespace-nowrap">
                        <span class="drag-handle inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-300 hover:text-gray-500 hover:bg-gray-100 cursor-grab active:cursor-grabbing transition duration-150 select-none text-sm font-medium">⠿</span>
                    </td>
                    <td class="px-4 py-4.5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0 border border-primary/5 shadow-sm">
                                <i class="<?= htmlspecialchars($service['icon'] ?? 'fas fa-star') ?> text-sm"></i>
                            </div>
                            <div class="max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg">
                                <p class="font-semibold text-gray-900 truncate"><?= htmlspecialchars($service['title']) ?></p>
                                <?php if(!empty($service['short_description'])): ?>
                                <p class="text-xs text-gray-400 mt-0.5 line-clamp-1"><?= truncate($service['short_description'], 60) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4.5 hidden md:table-cell whitespace-nowrap">
                        <code class="text-xs font-mono bg-gray-50 text-gray-600 border border-gray-100 px-2 py-1 rounded-md select-all">/service/<?= htmlspecialchars($service['slug']) ?></code>
                    </td>
                    <td class="px-4 py-4.5 whitespace-nowrap">
                        <span class="inline-flex items-center text-xs px-2.5 py-1 rounded-full font-bold tracking-wide select-none
                            <?= strtolower($service['status']) === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' ?>">
                            <span class="w-1.5 h-1.5 rounded-full mr-1.5 <?= strtolower($service['status']) === 'active' ? 'bg-emerald-500' : 'bg-slate-400' ?>"></span>
                            <?= ucfirst($service['status']) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4.5 whitespace-nowrap">
                        <div class="flex items-center justify-end gap-2">
                            <a href="<?= BASE_URL ?>/service/<?= $service['slug'] ?>" target="_blank" title="View Public Page"
                               class="inline-flex items-center justify-center w-8 h-8 bg-gray-50 hover:bg-gray-100 text-gray-500 rounded-xl border border-gray-100 transition duration-150 text-xs">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/admin/services/edit/<?= $service['id'] ?>"
                               class="inline-flex items-center justify-center gap-1 h-8 bg-primary/10 text-primary px-3 rounded-xl hover:bg-primary hover:text-white transition duration-150 text-xs font-semibold">
                                <i class="fas fa-edit text-[10px]"></i> Edit
                            </a>
                            <button onclick="confirmDelete('<?= BASE_URL ?>/admin/services/delete/<?= $service['id'] ?>')" title="Delete Service"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-red-50 hover:bg-red-500 text-red-500 hover:text-white rounded-xl border border-red-100/50 hover:border-transparent transition duration-150 text-xs">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
<script>
const sl = document.getElementById('servicesList');
if(sl) {
    Sortable.create(sl, { 
        handle: '.drag-handle', 
        animation: 180,
        ghostClass: 'bg-primary/5',
        chosenClass: 'bg-gray-50/50',
        onEnd: async () => { 
            const ids = [...sl.querySelectorAll('tr')].map(r => r.dataset.id); 
            await adminPost('<?= BASE_URL ?>/admin/services/reorder', { ids: ids.join(',') }); 
            showToast('Order saved!', 'success'); 
        }
    });
}

function confirmDelete(url) {
    adminDelete(url, 'Are you sure you want to delete this service? This action cannot be undone.', () => {
        setTimeout(() => location.reload(), 700);
    });
}
</script>