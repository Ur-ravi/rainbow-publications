<?php $pageTitle = 'Testimonials'; ?>
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-serif font-bold text-primary">Testimonials</h1>
        <p class="text-gray-500 text-sm mt-1">Manage Google-review style testimonials shown on the home page.</p>
    </div>
    <a href="<?= BASE_URL ?>/admin/testimonials/create"
       class="inline-flex items-center justify-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl font-semibold hover:bg-primary-dark shadow-sm hover:shadow-md transition duration-200">
        <i class="fas fa-plus text-xs"></i> Add Testimonial
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <?php if(empty($testimonials)): ?>
    <div class="text-center py-16 px-4">
        <div class="w-16 h-16 bg-gray-50 text-gray-400 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-quote-right text-2xl opacity-60"></i>
        </div>
        <p class="font-semibold text-gray-700">No testimonials yet.</p>
        <p class="text-gray-400 text-sm mt-1 mb-4">Add the first review to show on the home page.</p>
        <a href="<?= BASE_URL ?>/admin/testimonials/create" class="text-primary hover:text-primary-dark font-medium text-sm inline-flex items-center gap-1 transition duration-200">Add first testimonial →</a>
    </div>
    <?php else: ?>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/70 border-b border-gray-100 text-xs font-bold text-gray-500 uppercase tracking-wider select-none">
                    <th class="px-6 py-4 w-12 text-center">#</th>
                    <th class="px-4 py-4">Reviewer</th>
                    <th class="px-4 py-4 hidden md:table-cell">Review</th>
                    <th class="px-4 py-4">Rating</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach($testimonials as $t):
                    $letter = $t['avatar_letter'] !== '' ? $t['avatar_letter'] : strtoupper(substr($t['reviewer_name'], 0, 1));
                    $color  = $t['avatar_color'] ?: '#1e73be';
                    $initial = $letter ?: 'U';
                ?>
                <tr class="hover:bg-gray-50/60 transition duration-150 group" data-id="<?= $t['id'] ?>">
                    <td class="px-6 py-4.5 text-center whitespace-nowrap text-sm text-gray-400 font-semibold"><?= (int)$t['sort_order'] ?></td>
                    <td class="px-4 py-4.5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0 shadow-sm"
                                 style="background: <?= htmlspecialchars($color) ?>">
                                <?= htmlspecialchars($initial) ?>
                            </div>
                            <div class="max-w-xs sm:max-w-sm md:max-w-md">
                                <p class="font-semibold text-gray-900 truncate"><?= htmlspecialchars($t['reviewer_name']) ?></p>
                                <p class="text-xs text-gray-400 mt-0.5 line-clamp-1">
                                    <?= htmlspecialchars($t['designation']) ?>
                                    <?php if(!empty($t['organization'])): ?>
                                        · <?= htmlspecialchars($t['organization']) ?>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4.5 hidden md:table-cell">
                        <p class="text-xs text-gray-500 line-clamp-2 max-w-sm"><?= htmlspecialchars(truncate($t['content'], 110)) ?></p>
                    </td>
                    <td class="px-4 py-4.5 whitespace-nowrap">
                        <div class="flex items-center gap-0.5 text-amber-400 text-xs">
                            <?php for($i=1;$i<=5;$i++): ?>
                                <i class="fas fa-star<?= $i <= (int)$t['rating'] ? '' : ' text-gray-200' ?>"></i>
                            <?php endfor; ?>
                        </div>
                    </td>
                    <td class="px-6 py-4.5 whitespace-nowrap">
                        <span class="inline-flex items-center text-xs px-2.5 py-1 rounded-full font-bold tracking-wide select-none
                            <?= $t['is_active'] ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' ?>">
                            <span class="w-1.5 h-1.5 rounded-full mr-1.5 <?= $t['is_active'] ? 'bg-emerald-500' : 'bg-slate-400' ?>"></span>
                            <?= $t['is_active'] ? 'Active' : 'Hidden' ?>
                        </span>
                    </td>
                    <td class="px-6 py-4.5 whitespace-nowrap">
                        <div class="flex items-center justify-end gap-2">
                            <a href="<?= BASE_URL ?>/admin/testimonials/edit/<?= $t['id'] ?>"
                               class="inline-flex items-center justify-center gap-1 h-8 bg-primary/10 text-primary px-3 rounded-xl hover:bg-primary hover:text-white transition duration-150 text-xs font-semibold">
                                <i class="fas fa-edit text-[10px]"></i> Edit
                            </a>
                            <button onclick="confirmDelete('<?= BASE_URL ?>/admin/testimonials/delete/<?= $t['id'] ?>')" title="Delete"
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

<script>
function confirmDelete(url) {
    adminDelete(url, 'Are you sure you want to delete this testimonial? This action cannot be undone.', () => {
        setTimeout(() => location.reload(), 700);
    });
}
</script>
