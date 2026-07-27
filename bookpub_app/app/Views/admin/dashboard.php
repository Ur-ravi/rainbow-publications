<?php 
$pageTitle = 'Dashboard';
$stats = $stats ?? ['books' => 0, 'journals' => 0, 'messages' => 0, 'unread' => 0, 'news' => 0, 'members' => 0];
$recentBooks = $recentBooks ?? [];
$recentMessages = $recentMessages ?? [];
?>

<!-- STATS CARDS -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <?php $cards = [
        ['Books Published', $stats['books'],    'fa-books',         'bg-blue-500',   BASE_URL.'/admin/books'],
        ['Journals',        $stats['journals'], 'fa-journal-whills','bg-indigo-500',  BASE_URL.'/admin/journals'],
        ['Total Messages',  $stats['messages'], 'fa-envelope',      'bg-emerald-500', BASE_URL.'/admin/contact'],
        ['Unread Messages', $stats['unread'],   'fa-bell',          'bg-secondary',   BASE_URL.'/admin/contact'],
    ]; ?>
    <?php foreach ($cards as [$label,$value,$icon,$color,$link]): ?>
    <a href="<?= $link ?>" class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 p-6 flex items-center gap-4 group hover:-translate-y-0.5">
        <div class="w-12 h-12 <?= $color ?> rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg group-hover:scale-110 transition-transform">
            <i class="fas <?= $icon ?> text-white text-lg"></i>
        </div>
        <div>
            <div class="text-2xl font-bold text-gray-800"><?= number_format($value) ?></div>
            <div class="text-gray-500 text-sm"><?= $label ?></div>
        </div>
    </a>
    <?php endforeach; ?>
</div>

<!-- RECENT BOOKS + RECENT MESSAGES -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    <!-- Recent Books -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-800">Recent Books</h3>
            <a href="<?= BASE_URL ?>/admin/books/create" class="text-sm text-secondary hover:text-secondary-dark font-semibold flex items-center gap-1">
                <i class="fas fa-plus text-xs"></i> Add New
            </a>
        </div>
        <?php if (empty($recentBooks)): ?>
        <div class="px-6 py-10 text-center text-gray-400">
            <i class="fas fa-books text-3xl mb-2 opacity-30"></i>
            <p class="text-sm">No books yet. <a href="<?= BASE_URL ?>/admin/books/create" class="text-secondary">Add one</a></p>
        </div>
        <?php else: ?>
        <div class="divide-y divide-gray-50">
            <?php foreach ($recentBooks as $book): ?>
            <div class="px-6 py-4 flex items-center gap-4 hover:bg-gray-50 transition-colors">
                <div class="w-10 h-12 bg-primary-50 rounded overflow-hidden flex-shrink-0">
                    <?php if ($book['cover_image']): ?>
                    <img src="<?= uploadUrl('books', $book['cover_image']) ?>" alt="" class="w-full h-full object-cover">
                    <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center">
                        <i class="fas fa-book text-primary/40 text-lg"></i>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-medium text-gray-800 text-sm truncate"><?= Security::e($book['title']) ?></div>
                    <div class="text-gray-400 text-xs truncate"><?= Security::e($book['authors']) ?></div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs px-2 py-0.5 rounded-full <?= $book['is_published'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' ?>">
                        <?= $book['is_published'] ? 'Live' : 'Draft' ?>
                    </span>
                    <a href="<?= BASE_URL ?>/admin/books/edit/<?= $book['id'] ?>" class="text-gray-400 hover:text-primary transition-colors">
                        <i class="fas fa-edit text-xs"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="px-6 py-3 border-t border-gray-50">
            <a href="<?= BASE_URL ?>/admin/books" class="text-sm text-primary hover:text-secondary font-semibold">View all books →</a>
        </div>
        <?php endif; ?>
    </div>

    <!-- Recent Messages -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-800">Recent Messages</h3>
            <a href="<?= BASE_URL ?>/admin/contact" class="text-sm text-secondary hover:text-secondary-dark font-semibold">View All</a>
        </div>
        <?php if (empty($recentMessages)): ?>
        <div class="px-6 py-10 text-center text-gray-400">
            <i class="fas fa-inbox text-3xl mb-2 opacity-30"></i>
            <p class="text-sm">No messages yet.</p>
        </div>
        <?php else: ?>
        <div class="divide-y divide-gray-50">
            <?php foreach ($recentMessages as $msg): ?>
            <div class="px-6 py-4 hover:bg-gray-50 transition-colors <?= !$msg['is_read'] ? 'bg-blue-50/40' : '' ?>">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <span class="font-medium text-gray-800 text-sm"><?= Security::e($msg['name']) ?></span>
                            <?php if (!$msg['is_read']): ?>
                            <span class="w-2 h-2 bg-secondary rounded-full flex-shrink-0"></span>
                            <?php endif; ?>
                        </div>
                        <div class="text-xs text-gray-500 truncate"><?= Security::e($msg['email']) ?></div>
                        <?php if ($msg['subject']): ?>
                        <div class="text-xs text-gray-600 mt-1 truncate"><?= Security::e($msg['subject']) ?></div>
                        <?php endif; ?>
                    </div>
                    <span class="text-xs text-gray-400 flex-shrink-0"><?= formatDate($msg['created_at'], 'M j') ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- QUICK ACTIONS -->
<div class="mt-6 bg-white rounded-2xl shadow-sm p-6">
    <h3 class="font-semibold text-gray-800 mb-4">Quick Actions</h3>
    <div class="flex flex-wrap gap-3">
        <?php $actions = [
            ['Add Book',      BASE_URL.'/admin/books/create',    'fa-plus', 'bg-blue-500'],
            ['Add Journal',   BASE_URL.'/admin/journals',        'fa-plus', 'bg-indigo-500'],
            ['Write News',    BASE_URL.'/admin/news/create',     'fa-pen',  'bg-emerald-500'],
            ['View Messages', BASE_URL.'/admin/contact',         'fa-inbox','bg-amber-500'],
            ['SEO Settings',  BASE_URL.'/admin/seo',             'fa-search','bg-purple-500'],
            ['Settings',      BASE_URL.'/admin/settings',        'fa-cog',  'bg-gray-600'],
        ]; ?>
        <?php foreach ($actions as [$label,$url,$icon,$color]): ?>
        <a href="<?= $url ?>" class="flex items-center gap-2 px-4 py-2.5 <?= $color ?> text-white text-sm font-semibold rounded-xl hover:opacity-90 transition-opacity shadow-sm">
            <i class="fas <?= $icon ?> text-xs"></i> <?= $label ?>
        </a>
        <?php endforeach; ?>
    </div>
</div>
