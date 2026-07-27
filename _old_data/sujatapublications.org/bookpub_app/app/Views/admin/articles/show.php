<?php
$pageTitle    = 'Article #' . $article['id'];
$contributors = !empty($article['contributors'])  ? (json_decode($article['contributors'], true)  ?: []) : [];
$keywords     = !empty($article['keywords'])      ? (json_decode($article['keywords'], true)      ?: []) : [];
$files        = !empty($article['article_files']) ? (json_decode($article['article_files'], true) ?: []) : [];
$statusColors = [
    'draft'        => ['bg-gray-100',   'text-gray-700'],
    'submitted'    => ['bg-blue-100',   'text-blue-700'],
    'under_review' => ['bg-amber-100',  'text-amber-700'],
    'accepted'     => ['bg-green-100',  'text-green-700'],
    'rejected'     => ['bg-red-100',    'text-red-700'],
    'published'    => ['bg-purple-100', 'text-purple-700'],
];
$st = $statusColors[$article['review_status']] ?? ['bg-gray-100', 'text-gray-700'];
?>

<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <div class="flex items-center gap-3 min-w-0">
        <a href="<?= BASE_URL ?>/admin/articles" class="text-gray-400 hover:text-primary p-2 rounded-lg hover:bg-gray-100 transition" title="Back to list">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="min-w-0">
            <h1 class="text-2xl font-serif font-bold text-primary truncate"><?= htmlspecialchars($article['title']) ?></h1>
            <p class="text-gray-500 text-sm mt-0.5">
                <i class="fas fa-book text-xs mr-1"></i> <?= htmlspecialchars($article['journal_name']) ?>
                <span class="mx-1.5 text-gray-300">·</span>
                <span class="text-xs px-2 py-0.5 rounded bg-gray-100 text-gray-700 font-semibold"><?= htmlspecialchars($article['section']) ?></span>
            </p>
        </div>
    </div>
    <div class="flex items-center gap-2 flex-wrap">
        <span class="inline-block px-3 py-1.5 rounded-full text-xs font-bold uppercase <?= $st[0] ?> <?= $st[1] ?>">
            <?= htmlspecialchars(str_replace('_', ' ', $article['review_status'])) ?>
        </span>
        <a href="<?= BASE_URL ?>/admin/articles/edit/<?= $article['id'] ?>" class="px-3 py-1.5 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 transition flex items-center gap-1.5">
            <i class="fas fa-pen text-xs"></i> Edit
        </a>
        <button onclick="window.print()" class="px-3 py-1.5 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 transition flex items-center gap-1.5">
            <i class="fas fa-print text-xs"></i> Print
        </button>
        <button onclick="deleteArticle(<?= $article['id'] ?>)" class="px-3 py-1.5 bg-white border border-red-200 rounded-xl text-sm font-semibold text-red-600 hover:bg-red-50 transition flex items-center gap-1.5">
            <i class="fas fa-trash text-xs"></i> Delete
        </button>
    </div>
</div>

<div class="space-y-6">

    <!-- ============== ARTICLE DETAILS ============== -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
            <i class="fas fa-file-alt text-primary"></i> Article Details
        </h3>
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Cover image with download -->
            <?php if (!empty($article['cover_image'])): ?>
            <div class="flex-shrink-0 text-center">
                <img src="<?= uploadUrl('articles/covers', $article['cover_image']) ?>"
                     class="w-40 h-40 rounded-2xl object-cover border-2 border-gray-100 shadow-sm">
                <a href="<?= BASE_URL ?>/admin/articles/download/<?= $article['id'] ?>?file=cover"
                   class="mt-3 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-primary/10 hover:bg-primary hover:text-white text-primary text-xs font-semibold transition"
                   title="Download cover image">
                    <i class="fas fa-download"></i> Download Cover
                </a>
            </div>
            <?php endif; ?>

            <!-- Article info -->
            <div class="flex-1 grid sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                <?php if (!empty($article['prefix'])): ?>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Prefix</p>
                    <p class="font-medium text-gray-800"><?= htmlspecialchars($article['prefix']) ?></p>
                </div>
                <?php endif; ?>
                <div class="sm:col-span-2">
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Title</p>
                    <p class="font-bold text-gray-800 text-lg leading-tight"><?= htmlspecialchars($article['title']) ?></p>
                </div>
                <?php if (!empty($article['subtitle'])): ?>
                <div class="sm:col-span-2">
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Subtitle</p>
                    <p class="font-medium text-gray-700"><?= htmlspecialchars($article['subtitle']) ?></p>
                </div>
                <?php endif; ?>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Journal</p>
                    <p class="font-medium text-gray-800"><?= htmlspecialchars($article['journal_name']) ?></p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Section</p>
                    <p class="font-medium text-gray-800"><?= htmlspecialchars($article['section']) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- ============== ABSTRACT ============== -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-3 pb-3 border-b border-gray-100 flex items-center gap-2">
            <i class="fas fa-align-left text-primary"></i> Abstract
        </h3>
        <div class="text-sm text-gray-700 leading-relaxed prose-sm max-w-none article-abstract">
            <?= sanitizeRichHtml($article['abstract'] ?? '') ?>
        </div>
    </div>

    <!-- ============== KEYWORDS ============== -->
    <?php if (!empty($keywords)): ?>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-3 pb-3 border-b border-gray-100 flex items-center gap-2">
            <i class="fas fa-tags text-primary"></i> Keywords <span class="text-xs font-normal text-gray-400">(<?= count($keywords) ?>)</span>
        </h3>
        <div class="flex flex-wrap gap-2">
            <?php foreach ($keywords as $kw): ?>
            <span class="inline-block px-3 py-1 rounded-lg text-xs font-semibold bg-primary/10 text-primary"><?= htmlspecialchars($kw) ?></span>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- ============== CONTRIBUTORS ============== -->
    <?php if (!empty($contributors)): ?>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
            <i class="fas fa-users text-primary"></i> Contributors <span class="text-xs font-normal text-gray-400">(<?= count($contributors) ?>)</span>
        </h3>
        <div class="grid sm:grid-cols-2 gap-3">
            <?php foreach ($contributors as $i => $c): ?>
            <div class="border border-gray-200 rounded-xl p-4 hover:shadow-sm transition">
                <div class="flex items-start justify-between mb-2 gap-2">
                    <div class="min-w-0">
                        <p class="font-bold text-gray-800 truncate"><?= htmlspecialchars($c['name'] ?? '') ?></p>
                        <p class="text-xs text-gray-500 truncate"><?= htmlspecialchars($c['affiliation'] ?? '') ?></p>
                    </div>
                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-primary/10 text-primary flex-shrink-0"><?= htmlspecialchars($c['role'] ?? 'Author') ?></span>
                </div>
                <div class="space-y-1 text-xs text-gray-600 mt-3 pt-3 border-t border-gray-100">
                    <a href="mailto:<?= htmlspecialchars($c['email'] ?? '') ?>" class="flex items-center gap-2 hover:text-primary transition">
                        <i class="fas fa-envelope w-4 text-gray-400"></i> <?= htmlspecialchars($c['email'] ?? '') ?>
                    </a>
                    <a href="tel:<?= htmlspecialchars($c['phone'] ?? '') ?>" class="flex items-center gap-2 hover:text-primary transition">
                        <i class="fas fa-phone w-4 text-gray-400"></i> <?= htmlspecialchars($c['phone'] ?? '') ?>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- ============== CONTACT PERSON ============== -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
            <i class="fas fa-user-circle text-primary"></i> Contact Person (Submitter)
        </h3>
        <div class="grid sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
            <?php
            $contactRows = [
                'Name'        => $article['submitter_name'] ?? '',
                'Email'       => $article['submitter_email'] ?? '',
                'Affiliation' => $article['submitter_affiliation'] ?? '',
                'Mobile'      => $article['submitter_mobile'] ?? '',
            ];
            foreach ($contactRows as $label => $val):
                if (!$val) continue;
                $isEmail = ($label === 'Email');
                $isPhone = ($label === 'Mobile');
            ?>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold"><?= $label ?></p>
                <?php if ($isEmail): ?>
                    <a href="mailto:<?= htmlspecialchars($val) ?>?subject=Re%3A%20Article%20%23<?= $article['id'] ?>" class="font-medium text-primary hover:underline break-all"><?= htmlspecialchars($val) ?></a>
                <?php elseif ($isPhone): ?>
                    <a href="tel:<?= htmlspecialchars($val) ?>" class="font-medium text-primary hover:underline"><?= htmlspecialchars($val) ?></a>
                <?php else: ?>
                    <p class="font-medium text-gray-800 break-words"><?= htmlspecialchars($val) ?></p>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- ============== ARTICLE FILES (downloadable) ============== -->
    <?php if (!empty($files)): ?>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
            <i class="fas fa-folder-open text-primary"></i> Article Files <span class="text-xs font-normal text-gray-400">(<?= count($files) ?>)</span>
        </h3>
        <div class="grid sm:grid-cols-2 gap-3">
            <?php foreach ($files as $idx => $f):
                $ext  = strtolower(pathinfo($f['filename'] ?? '', PATHINFO_EXTENSION));
                $icon = $ext === 'pdf'           ? 'fa-file-pdf text-red-500'
                      : (in_array($ext, ['doc','docx']) ? 'fa-file-word text-blue-500'
                      : 'fa-file text-gray-500');
                $sizeKB = isset($f['size']) ? number_format(((int)$f['size']) / 1024, 1) : '?';
            ?>
            <div class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 hover:border-primary hover:bg-primary/5 transition group">
                <i class="fas <?= $icon ?> text-3xl flex-shrink-0"></i>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate" title="<?= htmlspecialchars($f['original'] ?? $f['filename']) ?>">
                        <?= htmlspecialchars($f['original'] ?? $f['filename']) ?>
                    </p>
                    <p class="text-xs text-gray-500"><?= $sizeKB ?> KB · <?= strtoupper($ext) ?></p>
                </div>
                <div class="flex items-center gap-1 flex-shrink-0">
                    <a href="<?= uploadUrl('articles/files', $f['filename']) ?>" target="_blank" rel="noopener"
                       class="w-9 h-9 rounded-lg bg-gray-100 hover:bg-primary hover:text-white text-gray-500 inline-flex items-center justify-center transition" title="Preview / Open">
                        <i class="fas fa-eye text-xs"></i>
                    </a>
                    <a href="<?= BASE_URL ?>/admin/articles/download/<?= $article['id'] ?>?file=article&idx=<?= $idx ?>"
                       class="w-9 h-9 rounded-lg bg-primary text-white hover:bg-primary-dark inline-flex items-center justify-center transition" title="Download">
                        <i class="fas fa-download text-xs"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- ============== INTERNAL NOTES ============== -->
    <?php if (!empty($article['notes'])): ?>
    <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-r-xl p-5">
        <h4 class="font-bold text-yellow-900 text-sm mb-2 flex items-center gap-2">
            <i class="fas fa-sticky-note"></i> Internal Notes
        </h4>
        <p class="text-sm text-yellow-800 whitespace-pre-wrap"><?= htmlspecialchars($article['notes']) ?></p>
    </div>
    <?php endif; ?>

    <!-- ============== METADATA ============== -->
    <div class="bg-gray-50 rounded-xl p-4 text-xs text-gray-500 grid grid-cols-2 md:grid-cols-4 gap-2">
        <div><strong class="text-gray-600">Submission ID:</strong><br>#<?= $article['id'] ?></div>
        <div><strong class="text-gray-600">Submitted:</strong><br><?= formatDate($article['created_at']) ?> · <?= date('H:i', strtotime($article['created_at'])) ?></div>
        <?php if (!empty($article['updated_at']) && $article['updated_at'] !== $article['created_at']): ?>
        <div><strong class="text-gray-600">Updated:</strong><br><?= formatDate($article['updated_at']) ?> · <?= date('H:i', strtotime($article['updated_at'])) ?></div>
        <?php endif; ?>
        <?php if (!empty($article['ip_address'])): ?>
        <div><strong class="text-gray-600">IP Address:</strong><br><?= htmlspecialchars($article['ip_address']) ?></div>
        <?php endif; ?>
    </div>
</div>

<script>
function deleteArticle(id) {
    showConfirm('Delete this article and all uploaded files? This cannot be undone.', async () => {
        const fd = new FormData();
        fd.append('csrf_token', '<?= Security::generateCsrfToken() ?>');
        try {
            const r = await fetch('<?= BASE_URL ?>/admin/articles/delete/' + id, { method: 'POST', body: fd });
            const text = await r.text();
            let d;
            try { d = JSON.parse(text); } catch (e) { throw new Error('Invalid server response'); }
            showToast(d.message, d.success ? 'success' : 'error');
            if (d.success) setTimeout(() => window.location.href = '<?= BASE_URL ?>/admin/articles', 500);
        } catch (e) { showToast('Delete failed: ' + e.message, 'error'); }
    });
}
</script>

<style>
@media print {
    aside, .sidebar, header, button, .no-print { display: none !important; }
    body { background: white !important; }
    .bg-white { box-shadow: none !important; border: 1px solid #e5e7eb !important; }
}
.article-abstract a { color: #0F4C75; text-decoration: underline; }
.article-abstract ul, .article-abstract ol { padding-left: 1.5rem; margin: 0.5rem 0; }
.article-abstract ul { list-style: disc; }
.article-abstract ol { list-style: decimal; }
</style>
