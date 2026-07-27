<?php
$pageTitle = 'Membership Applications';
$error     = $error ?? null;
// Defensive defaults — when this view is rendered from an error fallback (e.g. show() of a missing record), these may be undefined.
$applications = $applications ?? [];
$total        = $total        ?? 0;
$counts       = $counts       ?? ['all' => 0, 'pending' => 0, 'approved' => 0, 'rejected' => 0];
$status       = $status       ?? '';
$pag          = $pag          ?? ['total_pages' => 0, 'current_page' => 1];
// Type color map for visual differentiation
$typeColors = [
    'Honorary Membership'              => ['#EEEDFE', '#3C3489', 'fa-award'],
    'Patron Membership'                => ['#E6F1FB', '#0C447C', 'fa-medal'],
    'Institutional Membership'         => ['#FAEEDA', '#854F0B', 'fa-university'],
    'Life Membership'                  => ['#EAF3DE', '#27500A', 'fa-id-card'],
    'Life Membership (Senior Category)'=> ['#FAECE7', '#712B13', 'fa-user-clock'],
    'International Membership'         => ['#E1F5EE', '#085041', 'fa-globe'],
    'Student Membership'               => ['#FBF0E6', '#7C2D12', 'fa-user-graduate'],
];
?>

<?php if (!empty($error)): ?>
<div class="mb-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl p-4 flex items-start gap-3" role="alert">
    <i class="fas fa-exclamation-circle text-red-500 mt-0.5"></i>
    <div>
        <p class="font-semibold text-red-800 text-sm"><?= htmlspecialchars($error) ?></p>
    </div>
</div>
<?php endif; ?>

<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <div>
        <h1 class="text-2xl font-serif font-bold text-primary">Membership Applications</h1>
        <p class="text-gray-500 text-sm mt-1">Review and process applications submitted via the membership form.</p>
    </div>
    <div class="flex items-center gap-3">
        <span class="text-sm text-gray-500"><strong class="text-gray-800"><?= (int)$total ?></strong> total applications</span>
    </div>
</div>

<!-- Filter tabs -->
<div class="flex flex-wrap gap-2 mb-4">
    <?php
    $tabs = [
        ''         => ['All',      $counts['all'],      'gray'],
        'pending'  => ['Pending',  $counts['pending'],  'amber'],
        'approved' => ['Approved', $counts['approved'], 'green'],
        'rejected' => ['Rejected', $counts['rejected'], 'red'],
    ];
    foreach ($tabs as $k => [$label, $cnt, $color]):
        $active = $status === $k;
    ?>
    <a href="<?= BASE_URL ?>/admin/applications<?= $k ? '?status=' . $k : '' ?>"
       class="px-4 py-2 rounded-xl text-sm font-semibold transition border-2 <?= $active ? 'bg-primary text-white border-primary' : 'bg-white text-gray-600 border-gray-200 hover:border-primary' ?>">
        <?= $label ?>
        <span class="ml-1.5 inline-flex items-center justify-center w-5 h-5 rounded-full text-xs <?= $active ? 'bg-white/20' : 'bg-gray-100' ?>"><?= (int)$cnt ?></span>
    </a>
    <?php endforeach; ?>
</div>

<!-- Search bar -->
<div class="mb-6 bg-white rounded-2xl shadow-sm border border-gray-100 p-3">
    <div class="relative">
        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
        <input type="text" id="appSearch" placeholder="Search by name, email, phone, or membership type…"
               class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:border-primary text-sm">
    </div>
</div>

<?php if (empty($applications)): ?>
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
    <div class="w-20 h-20 mx-auto bg-gray-50 rounded-2xl flex items-center justify-center mb-4">
        <i class="fas fa-inbox text-3xl text-gray-300"></i>
    </div>
    <h3 class="text-lg font-bold text-gray-700 mb-1">No applications<?= $status ? ' with status "' . htmlspecialchars($status) . '"' : '' ?></h3>
    <p class="text-gray-400 text-sm">Applications submitted via the form will appear here.</p>
</div>
<?php else: ?>
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3">Applicant</th>
                    <th class="text-left text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3">Type</th>
                    <th class="text-left text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3">Contact</th>
                    <th class="text-left text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3">Submitted</th>
                    <th class="text-right text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3">Total</th>
                    <th class="text-center text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3">Status</th>
                    <th class="text-right text-xs uppercase tracking-wider text-gray-500 font-semibold px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody id="appTableBody">
                <?php foreach ($applications as $app):
                    $typeColor = $typeColors[$app['membership_type_name']] ?? ['#F3F4F6', '#374151', 'fa-id-card'];
                    // Honorary: load nominee from form_data
                    $formDataDecoded = !empty($app['form_data']) ? (json_decode($app['form_data'], true) ?: []) : [];
                    $isHonorary = stripos($app['membership_type_name'] ?? '', 'Honorary') !== false;
                    $displayName = $isHonorary && !empty($formDataDecoded['nominee_name'])
                        ? $formDataDecoded['nominee_name'] . ' (nominee)'
                        : $app['name'];
                ?>
                <tr class="border-t border-gray-50 hover:bg-gray-50/50 transition app-row"
                    data-search="<?= htmlspecialchars(strtolower($app['name'] . ' ' . $app['email'] . ' ' . $app['phone'] . ' ' . $app['membership_type_name'])) ?>">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <?php if (!empty($app['photo'])): ?>
                            <img src="<?= uploadUrl('applications/photos', $app['photo']) ?>" class="w-10 h-10 rounded-full object-cover border border-gray-100 flex-shrink-0">
                            <?php else: ?>
                            <div class="w-10 h-10 rounded-full text-white flex items-center justify-center font-bold text-sm flex-shrink-0" style="background:<?= $typeColor[1] ?>;">
                                <?= strtoupper(substr($app['name'], 0, 1)) ?>
                            </div>
                            <?php endif; ?>
                            <div class="min-w-0">
                                <div class="font-semibold text-gray-800 text-sm leading-tight truncate" title="<?= htmlspecialchars($displayName) ?>">
                                    <?= htmlspecialchars($displayName) ?>
                                </div>
                                <?php if ($isHonorary && !empty($app['name'])): ?>
                                <div class="text-xs text-gray-400 mt-0.5">by <?= htmlspecialchars($app['name']) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold" style="background:<?= $typeColor[0] ?>; color:<?= $typeColor[1] ?>;">
                            <i class="fas <?= $typeColor[2] ?> text-[10px]"></i>
                            <?= htmlspecialchars($app['membership_type_name']) ?>
                        </span>
                    </td>
                    <td class="px-5 py-3">
                        <div class="text-xs text-gray-700 truncate max-w-[180px]" title="<?= htmlspecialchars($app['email']) ?>">
                            <i class="fas fa-envelope text-gray-300 mr-1 text-[10px]"></i><?= htmlspecialchars($app['email']) ?>
                        </div>
                        <?php if (!empty($app['phone'])): ?>
                        <div class="text-xs text-gray-500 mt-0.5"><i class="fas fa-phone text-gray-300 mr-1 text-[10px]"></i><?= htmlspecialchars($app['phone']) ?></div>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-3 text-xs text-gray-600">
                        <?= formatDate($app['created_at']) ?>
                        <div class="text-gray-400"><?= date('H:i', strtotime($app['created_at'])) ?></div>
                    </td>
                    <td class="px-5 py-3 text-right font-bold text-sm" style="color:#0F4C75;">
                        <?php if ((float)$app['total_amount'] > 0): ?>
                        ₹<?= number_format((float)$app['total_amount'], 0, '.', ',') ?>
                        <?php else: ?>
                        <span class="text-xs text-gray-400 font-normal italic">Free</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-5 py-3 text-center">
                        <?php
                        $statusColors = [
                            'pending'  => 'bg-amber-100 text-amber-700',
                            'approved' => 'bg-green-100 text-green-700',
                            'rejected' => 'bg-red-100 text-red-700',
                        ];
                        $cls = $statusColors[$app['status']] ?? 'bg-gray-100 text-gray-700';
                        ?>
                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-bold uppercase <?= $cls ?>">
                            <?= htmlspecialchars($app['status']) ?>
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="inline-flex items-center gap-1">
                            <a href="<?= BASE_URL ?>/admin/applications/show/<?= $app['id'] ?>"
                               class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-primary/10 text-gray-400 hover:text-primary inline-flex items-center justify-center transition" title="View Details">
                                <i class="fas fa-eye text-xs"></i>
                            </a>
                            <a href="mailto:<?= htmlspecialchars($app['email']) ?>"
                               class="w-8 h-8 rounded-lg bg-gray-50 hover:bg-blue-50 text-gray-400 hover:text-blue-600 inline-flex items-center justify-center transition" title="Email">
                                <i class="fas fa-envelope text-xs"></i>
                            </a>
                            <button onclick="deleteApp(<?= $app['id'] ?>)"
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
</div>

<?php if ($pag['total_pages'] > 1): ?>
<div class="pagination mt-6 flex justify-center gap-2">
    <?php for ($p = 1; $p <= $pag['total_pages']; $p++): ?>
    <a href="<?= BASE_URL ?>/admin/applications?<?= $status ? 'status=' . $status . '&' : '' ?>page=<?= $p ?>"
       class="px-3 py-1.5 rounded-lg text-sm font-semibold <?= $p == $pag['current_page'] ? 'bg-primary text-white' : 'bg-white border border-gray-200 text-gray-600' ?>">
        <?= $p ?>
    </a>
    <?php endfor; ?>
</div>
<?php endif; ?>
<?php endif; ?>

<script>
// Live search (client-side filter on visible rows)
document.getElementById('appSearch').addEventListener('input', function(e) {
    const q = e.target.value.trim().toLowerCase();
    document.querySelectorAll('.app-row').forEach(row => {
        const data = row.dataset.search || '';
        row.style.display = (!q || data.includes(q)) ? '' : 'none';
    });
});

function deleteApp(id) {
    adminDelete(`/admin/applications/delete/${id}`, 'Delete this application? All uploaded files will also be removed.', () => {
        setTimeout(() => location.reload(), 500);
    });
}
</script>
