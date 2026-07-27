<?php
$boardType  = $boardType ?? $type ?? 'editorial';
$pageTitle  = $boardType === 'reviewer' ? 'Reviewer Board' : 'Editorial Board';
$addUrl     = BASE_URL.'/admin/board/'.$boardType.'/add';
$editBase   = BASE_URL.'/admin/board/'.$boardType.'/edit/';
$deleteBase = BASE_URL.'/admin/board/'.$boardType.'/delete/';
?>
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-serif font-bold text-primary"><?= $pageTitle ?></h1>
        <p class="text-gray-500 text-sm mt-1">Manage board members displayed on the About Us page.</p>
    </div>
    <div class="flex flex-wrap items-center gap-3">
        <div class="flex bg-gray-100 rounded-xl p-1 border border-gray-200/50">
            <a href="<?= BASE_URL ?>/admin/board/editorial"
               class="px-4 py-2 rounded-lg text-xs font-semibold tracking-wide uppercase transition-all duration-200 <?= $boardType==='editorial' ? 'bg-white shadow-sm text-primary font-bold' : 'text-gray-500 hover:text-gray-800' ?>">
                Editorial
            </a>
            <a href="<?= BASE_URL ?>/admin/board/reviewer"
               class="px-4 py-2 rounded-lg text-xs font-semibold tracking-wide uppercase transition-all duration-200 <?= $boardType==='reviewer' ? 'bg-white shadow-sm text-primary font-bold' : 'text-gray-500 hover:text-gray-800' ?>">
                Reviewer
            </a>
        </div>
        <a href="<?= $addUrl ?>"
           class="flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:bg-primary-dark transition shadow-sm shadow-primary/10">
            <i class="fas fa-user-plus text-xs"></i> Add Member
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/30">
        <form method="GET" class="relative w-full max-w-md">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                <i class="fas fa-search text-sm"></i>
            </span>
            <input type="text" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                   placeholder="Search by name, institution or country..."
                   class="w-full bg-white border border-gray-200 rounded-xl pl-10 pr-10 py-2 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all">
            
            <?php if(!empty($_GET['search'])): ?>
                <a href="<?= BASE_URL ?>/admin/board/<?= $boardType ?>" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times-circle"></i>
                </a>
            <?php endif; ?>
        </form>
    </div>

    <?php if(empty($members)): ?>
    <div class="text-center py-20 text-gray-400">
        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
            <i class="fas fa-users text-2xl opacity-40 text-gray-400"></i>
        </div>
        <p class="font-semibold text-gray-700">No <?= $boardType ?> board members found.</p>
        <p class="text-xs text-gray-400 mt-1">Try adjusting your search filters or add a new record.</p>
        <a href="<?= $addUrl ?>" class="text-primary hover:text-primary-dark text-sm font-semibold mt-3 inline-block bg-primary/5 px-4 py-2 rounded-xl border border-primary/10 transition">Add First Member →</a>
    </div>
    <?php else: ?>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead>
                <tr class="bg-gray-50/70 border-b border-gray-100 text-xs font-bold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-3.5 w-[30%]">Member Name</th>
                    <th class="px-4 py-3.5 w-[20%]">Designation</th>
                    <th class="px-4 py-3.5 hidden md:table-cell w-[25%]">Institution / University</th>
                    <th class="px-4 py-3.5 hidden lg:table-cell w-[10%]">Qualification</th>
                    <th class="px-4 py-3.5 w-[10%]">Status</th>
                    <th class="px-6 py-3.5 text-right w-[5%]">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white" id="boardList">
                <?php foreach($members as $member): ?>
                <tr class="hover:bg-gray-50/60 transition-colors group duration-150" data-id="<?= $member['id'] ?>">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <span class="drag-handle text-gray-300 hover:text-gray-500 cursor-grab p-1 transition-colors">
                                <i class="fas fa-grip-vertical text-xs"></i>
                            </span>
                            <div class="relative flex-shrink-0">
                                <?php if($member['photo']): ?>
                                <img src="<?= uploadUrl('board', $member['photo']) ?>"
                                     alt="<?= htmlspecialchars($member['name']) ?>"
                                     class="w-11 h-11 rounded-full object-cover border-2 border-white shadow-sm ring-1 ring-gray-200">
                                <?php else: ?>
                                <div class="w-11 h-11 rounded-full bg-primary/5 border border-primary/10 flex items-center justify-center flex-shrink-0 shadow-sm">
                                    <i class="fas fa-user text-primary/40 text-sm"></i>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 group-hover:text-primary transition-colors text-[14px]"><?= htmlspecialchars($member['name']) ?></p>
                                <?php if(!empty($member['country'])): ?>
                                <p class="text-[11px] text-gray-400 font-medium uppercase tracking-wider mt-0.5"><i class="fas fa-map-marker-alt text-gray-300 mr-1"></i><?= htmlspecialchars($member['country']) ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-4">
                        <p class="text-gray-800 font-medium text-sm max-w-[200px] truncate"><?= htmlspecialchars($member['designation'] ?? '—') ?></p>
                    </td>
                    <td class="px-4 py-4 hidden md:table-cell">
                        <p class="text-gray-600 font-normal text-sm max-w-[240px] truncate"><?= htmlspecialchars($member['institution'] ?? '—') ?></p>
                    </td>
                    <td class="px-4 py-4 hidden lg:table-cell">
                        <?php if(!empty($member['qualification'])): ?>
                        <span class="text-xs font-bold text-amber-700 bg-amber-50 border border-amber-100/70 px-2.5 py-1 rounded-lg uppercase tracking-wide">
                            <?= htmlspecialchars($member['qualification']) ?>
                        </span>
                        <?php else: ?>
                        <span class="text-gray-300">—</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-4">
                        <?php $activeStatus = !empty($member['is_active']) ? 'active' : 'inactive'; ?>
                        <button onclick="toggleMemberStatus(<?= $member['id'] ?>, this)"
                                class="flex items-center gap-1.5 text-xs font-bold px-3 py-1 rounded-full transition-all border shadow-sm duration-200
                                <?= $activeStatus === 'active' ? 'bg-green-50 text-green-700 border-green-200/60 hover:bg-green-100' : 'bg-gray-50 text-gray-500 border-gray-200 hover:bg-gray-100' ?>">
                            <span class="w-1.5 h-1.5 rounded-full <?= $activeStatus === 'active' ? 'bg-green-500 animate-pulse' : 'bg-gray-400' ?>"></span>
                            <?= ucfirst($activeStatus) ?>
                        </button>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end items-center gap-2">
                            <a href="<?= $editBase.$member['id'] ?>"
                               class="text-xs bg-gray-50 text-gray-700 border border-gray-200 px-3 py-1.5 rounded-xl hover:bg-primary hover:text-white hover:border-primary transition-all font-semibold shadow-sm">
                                <i class="fas fa-edit mr-1 text-gray-400 group-hover:text-white"></i>Edit
                            </a>
                            <button onclick="confirmDelete('<?= $deleteBase.$member['id'] ?>')"
                                    class="text-xs bg-white text-red-500 border border-red-100 px-3 py-1.5 rounded-xl hover:bg-red-500 hover:text-white hover:border-red-500 transition-all font-semibold shadow-sm">
                                <i class="fas fa-trash"></i>
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
const tbody = document.getElementById('boardList');
if (tbody) {
    Sortable.create(tbody, {
        handle:    '.drag-handle',
        animation: 150,
        ghostClass: 'bg-primary/5',
        onEnd: async function() {
            const ids = [...tbody.querySelectorAll('tr')].map(r => r.dataset.id);
            const res = await adminPost('<?= BASE_URL ?>/admin/board/<?= $boardType ?>/reorder', { ids: ids.join(',') });
            showToast('Ordering saved successfully!', 'success');
        }
    });
}

async function toggleMemberStatus(id, btn) {
    const origHTML = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin text-xs"></i>';
    btn.disabled = true;

    try {
        const res  = await adminPost(`<?= BASE_URL ?>/admin/board/<?= $boardType ?>/toggle/${id}`, {});
        const data = await res.json();
        showToast(data.message, data.success ? 'success' : 'error');
        if (data.success) {
            setTimeout(() => location.reload(), 500);
        } else {
            btn.innerHTML = origHTML;
            btn.disabled = false;
        }
    } catch(e) {
        showToast('Status could not be updated.', 'error');
        btn.innerHTML = origHTML;
        btn.disabled = false;
    }
}

function confirmDelete(url) {
    showConfirm('Are you sure you want to delete this board member? This action cannot be undone.', async () => {
        try {
            const data = await adminPost(url, {});
            if (data && data.success) {
                showToast(data.message || 'Member deleted successfully', 'success');
                setTimeout(() => location.reload(), 500);
            } else {
                showToast((data && data.message) || 'Error deleting member', 'error');
            }
        } catch (error) {
            showToast('Something went wrong. Please try again.', 'error');
            console.error('Delete flow failure:', error);
        }
    });
}
</script>