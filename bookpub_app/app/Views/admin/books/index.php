<?php $pageTitle = 'Books Management'; ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">All Books</h2>
        <p class="text-gray-400 text-sm mt-0.5">Manage your book catalog</p>
    </div>
    <a href="<?= BASE_URL ?>/admin/books/create" class="inline-flex items-center gap-2 bg-primary text-white font-bold px-5 py-2.5 rounded-xl hover:bg-primary-light transition-colors shadow-sm">
        <i class="fas fa-plus"></i> Add New Book
    </a>
</div>

<!-- Search -->
<div class="bg-white rounded-2xl shadow-sm p-4 mb-5">
    <form action="<?= BASE_URL ?>/admin/books" method="GET" class="flex gap-3">
        <div class="relative flex-1">
            <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="text" name="q" value="<?= Security::e($search ?? '') ?>" placeholder="Search by title, author, ISBN..."
                   class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
        </div>
        <button type="submit" class="bg-primary text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-primary-light transition-colors">Search</button>
        <?php if (!empty($search)): ?>
        <a href="<?= BASE_URL ?>/admin/books" class="bg-gray-100 text-gray-600 px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-200 transition-colors">Clear</a>
        <?php endif; ?>
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <?php if (empty($books)): ?>
    <div class="py-20 text-center text-gray-400">
        <i class="fas fa-book text-5xl mb-4 opacity-20"></i>
        <p class="font-semibold">No books found</p>
        <a href="<?= BASE_URL ?>/admin/books/create" class="inline-flex items-center gap-2 mt-4 text-secondary hover:text-secondary-dark text-sm">
            <i class="fas fa-plus"></i> Add your first book
        </a>
    </div>
    <?php else: ?>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Book</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Authors</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">ISBN</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Category</th>
                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="text-right px-6 py-3.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($books as $book): ?>
                <tr class="hover:bg-gray-50 transition-colors" id="book-row-<?= $book['id'] ?>">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-12 bg-primary-50 rounded overflow-hidden flex-shrink-0">
                                <?php if (!empty($book['cover_image'])): ?>
                                <img src="<?= uploadUrl('books', $book['cover_image']) ?>" alt="" class="w-full h-full object-cover">
                                <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center"><i class="fas fa-book text-primary/40"></i></div>
                                <?php endif; ?>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-800 text-sm max-w-[200px] truncate"><?= Security::e($book['title']) ?></div>
                                <div class="text-xs text-gray-400"><?= formatDate($book['created_at'], 'M j, Y') ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600 hidden md:table-cell">
                        <div class="max-w-[150px] truncate text-sm"><?= Security::e($book['authors']) ?></div>
                    </td>
                    <td class="px-6 py-4 text-gray-500 text-xs hidden lg:table-cell"><?= Security::e($book['isbn'] ?: '—') ?></td>
                    <td class="px-6 py-4 hidden lg:table-cell">
                        <?php if (!empty($book['category'])): ?>
                        <span class="text-xs bg-primary-50 text-primary px-2 py-1 rounded-full"><?= Security::e($book['category']) ?></span>
                        <?php else: ?><span class="text-gray-400">—</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col gap-1">
                            <span class="inline-block text-xs px-2 py-0.5 rounded-full w-fit <?= $book['is_published'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' ?>">
                                <?= $book['is_published'] ? 'Published' : 'Draft' ?>
                            </span>
                            <?php if (!empty($book['is_featured'])): ?>
                            <span class="inline-block text-xs px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 w-fit">Featured</span>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="<?= BASE_URL ?>/book/<?= Security::e($book['slug']) ?>" target="_blank"
                               class="w-8 h-8 flex items-center justify-center rounded-lg bg-primary-50 text-primary hover:bg-primary hover:text-white transition-colors" title="View">
                                <i class="fas fa-eye text-xs"></i>
                            </a>
                            <a href="<?= BASE_URL ?>/admin/books/edit/<?= $book['id'] ?>"
                               class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-500 hover:text-white transition-colors" title="Edit">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                            <button onclick="deleteBook(<?= (int)$book['id'] ?>, '<?= Security::e(addslashes($book['title'])) ?>')"
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors" title="Delete">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if (isset($pag['total_pages']) && $pag['total_pages'] > 1): ?>
    <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
        <div class="text-sm text-gray-500">Showing <?= $pag['offset'] + 1 ?>–<?= min($pag['offset'] + $pag['per_page'], $pag['total']) ?> of <?= $pag['total'] ?></div>
        <div class="flex gap-1">
            <?php for ($i = 1; $i <= $pag['total_pages']; $i++): ?>
            <a href="?page=<?= $i ?><?= !empty($search) ? '&q=' . urlencode($search) : '' ?>"
               class="w-9 h-9 flex items-center justify-center rounded-lg text-sm <?= $i === $pag['current_page'] ? 'bg-primary text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' ?> transition-colors">
                <?= $i ?>
            </a>
            <?php endfor; ?>
        </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>
</div>

<!-- Hidden CSRF token for standalone AJAX requests -->
<form id="csrfForm" class="hidden">
    <?= Security::csrfField() ?>
</form>

<script>
// Helper for Toast or Alert
function notify(msg, type) {
    if (typeof showToast === 'function') {
        showToast(msg, type);
    } else {
        alert(msg);
    }
}

async function deleteBook(id, title) {
    if (!confirm(`Delete "${title}"? This cannot be undone.`)) return;

    try {
        const csrfForm = document.getElementById('csrfForm');
        const fd = new FormData(csrfForm);

        const response = await fetch(`<?= BASE_URL ?>/admin/books/delete/${id}`, {
            method: 'POST',
            body: fd
        });

        const data = await response.json();

        notify(data.message || 'Book deleted successfully', data.success ? 'success' : 'error');

        if (data.success) {
            const row = document.getElementById(`book-row-${id}`);
            if (row) {
                row.style.transition = 'opacity 0.3s ease';
                row.style.opacity = '0';
                setTimeout(() => row.remove(), 300);
            } else {
                setTimeout(() => location.reload(), 600);
            }
        }
    } catch (err) {
        console.error(err);
        notify('Failed to delete book.', 'error');
    }
}
</script>