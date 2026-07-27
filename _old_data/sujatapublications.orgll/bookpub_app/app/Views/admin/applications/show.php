<?php
$pageTitle      = 'Application #' . $app['id'];
$formData       = !empty($app['form_data'])      ? (json_decode($app['form_data'], true)      ?: []) : [];
$uploadedFiles  = !empty($app['uploaded_files']) ? (json_decode($app['uploaded_files'], true) ?: []) : [];
$photo          = $app['photo'] ?? ($uploadedFiles['photo'] ?? null);
$isHonorary     = stripos($app['membership_type_name'] ?? '', 'Honorary') !== false;

$prettyLabels = [
    'organization_name'    => 'Organization Name',
    'industry_type'        => 'Industry Type',
    'website'              => 'Website',
    'sponsorship_category' => 'Sponsorship Category',
    'remarks'              => 'Remarks',
    'institution_type'     => 'Institution Type',
    'establishment_year'   => 'Year Established',
    'contact_person_name'  => 'Contact Person Name',
    'degree_category'      => 'Degree Category',
    'degree_name'          => 'Degree Name',
    'degree_year'          => 'Year of Passing',
    'institute_name'       => 'Institute',
    'university_name'      => 'University',
    'degree'               => 'Degree',
    'university'           => 'University',
    'university_country'   => 'University Country',
    'course'               => 'Course',
    'year_semester'        => 'Year / Semester',
    'nominee_name'         => 'Nominee Full Name',
    'nominee_designation'  => 'Nominee Designation',
    'nominee_institution'  => 'Nominee Institution',
    'nominee_email'        => 'Nominee Email',
    'nominee_country'      => 'Nominee Country',
    'expertise'            => 'Field of Expertise',
    'justification'        => 'Justification',
    'publications'         => 'Publications / Awards',
];
$fileLabels = [
    'photo'                  => 'Profile Photo',
    'logo'                   => 'Logo',
    'id_proof'               => 'ID Proof',
    'registration_certificate' => 'Registration Certificate',
    'gst_certificate'        => 'GST Certificate',
    'degree_certificate'     => 'Degree Certificate',
    'age_proof'              => 'Age Proof',
    'passport'               => 'Passport',
    'student_id'             => 'Student ID Card',
    'bonafide_certificate'   => 'Bonafide Certificate',
    'nominee_cv'             => 'Nominee CV',
    'nomination_letter'      => 'Nomination Letter',
];
function prettify_label($k, $labels) { return $labels[$k] ?? ucwords(str_replace('_', ' ', $k)); }

$statusColors = [
    'pending'  => ['bg-amber-100', 'text-amber-700'],
    'approved' => ['bg-green-100', 'text-green-700'],
    'rejected' => ['bg-red-100', 'text-red-700'],
];
$st = $statusColors[$app['status']] ?? ['bg-gray-100', 'text-gray-700'];
?>

<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <div class="flex items-center gap-3 min-w-0">
        <a href="<?= BASE_URL ?>/admin/applications" class="text-gray-400 hover:text-primary p-2 rounded-lg hover:bg-gray-100 transition" title="Back to list">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="min-w-0">
            <h1 class="text-2xl font-serif font-bold text-primary">
                <?= $isHonorary ? 'Nomination' : 'Application' ?> #<?= $app['id'] ?>
            </h1>
            <p class="text-gray-500 text-sm mt-0.5">
                <i class="fas fa-id-card-alt text-xs mr-1"></i> <?= htmlspecialchars($app['membership_type_name']) ?>
                <span class="mx-1.5 text-gray-300">·</span>
                <i class="fas fa-clock text-xs mr-1"></i> <?= formatDate($app['created_at']) ?> at <?= date('H:i', strtotime($app['created_at'])) ?>
                <?php if (!empty($app['membership_id'])): ?>
                <span class="mx-1.5 text-gray-300">·</span>
                <span class="font-mono text-xs px-2 py-0.5 rounded bg-primary/10 text-primary"><?= htmlspecialchars($app['membership_id']) ?></span>
                <?php endif; ?>
            </p>
        </div>
    </div>
    <div class="flex items-center gap-2 flex-wrap">
        <span class="inline-block px-3 py-1.5 rounded-full text-xs font-bold uppercase <?= $st[0] ?> <?= $st[1] ?>">
            <i class="fas fa-circle text-[6px] mr-1"></i> <?= htmlspecialchars($app['status']) ?>
        </span>
        <button onclick="window.print()" class="px-3 py-1.5 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 transition flex items-center gap-1.5">
            <i class="fas fa-print text-xs"></i> Print
        </button>
        <a href="mailto:<?= htmlspecialchars($app['email']) ?>?subject=Re%3A%20<?= urlencode($app['membership_type_name']) ?>%20%23<?= $app['id'] ?>"
           class="px-3 py-1.5 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 transition flex items-center gap-1.5">
            <i class="fas fa-envelope text-xs"></i> Email
        </a>
    </div>
</div>

<div class="space-y-6">

    <?php if ($isHonorary): ?>
    <!-- ============== HONORARY NOMINATION ============== -->

    <!-- Nominator -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
            <i class="fas fa-user-edit text-primary"></i> Nominator (Submitter)
        </h3>
        <div class="grid sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
            <?php
            $nominatorRows = [
                'Name'        => $app['name'],
                'Email'       => $app['email'],
                'Phone'       => $app['phone'],
                'Designation' => $app['designation'],
                'Affiliation' => $app['college'],
            ];
            foreach ($nominatorRows as $label => $val):
                if ($val): ?>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold"><?= htmlspecialchars($label) ?></p>
                <?php if ($label === 'Email'): ?>
                    <a href="mailto:<?= htmlspecialchars($val) ?>" class="font-medium text-primary hover:underline break-words"><?= htmlspecialchars($val) ?></a>
                <?php elseif ($label === 'Phone'): ?>
                    <a href="tel:<?= htmlspecialchars($val) ?>" class="font-medium text-primary hover:underline"><?= htmlspecialchars($val) ?></a>
                <?php else: ?>
                    <p class="font-medium text-gray-800 break-words"><?= htmlspecialchars((string)$val) ?></p>
                <?php endif; ?>
            </div>
            <?php
                endif;
            endforeach; ?>
        </div>
    </div>

    <!-- Nominee -->
    <?php
    $nomineeKeys = ['nominee_name', 'nominee_designation', 'nominee_institution', 'nominee_email', 'nominee_country', 'expertise'];
    $hasNomineeData = false;
    foreach ($nomineeKeys as $k) if (!empty($formData[$k])) { $hasNomineeData = true; break; }
    if ($hasNomineeData):
    ?>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
            <i class="fas fa-user-tie text-primary"></i> Nominee Details
        </h3>
        <div class="grid sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
            <?php foreach ($nomineeKeys as $k):
                if (empty($formData[$k])) continue; ?>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold"><?= htmlspecialchars(prettify_label($k, $prettyLabels)) ?></p>
                <p class="font-medium text-gray-800 break-words"><?= htmlspecialchars((string)$formData[$k]) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Justification -->
    <?php if (!empty($formData['justification'])): ?>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-3 pb-3 border-b border-gray-100 flex items-center gap-2">
            <i class="fas fa-feather-alt text-primary"></i> Justification
        </h3>
        <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap"><?= htmlspecialchars($formData['justification']) ?></p>
    </div>
    <?php endif; ?>

    <?php if (!empty($formData['publications'])): ?>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-3 pb-3 border-b border-gray-100 flex items-center gap-2">
            <i class="fas fa-book text-primary"></i> Publications &amp; Awards
        </h3>
        <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap"><?= htmlspecialchars($formData['publications']) ?></p>
    </div>
    <?php endif; ?>

    <?php else: ?>
    <!-- ============== STANDARD APPLICATION ============== -->

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
            <i class="fas fa-user text-primary"></i> Personal Details
        </h3>
        <div class="flex flex-col md:flex-row gap-6">
            <?php if (!empty($photo)): ?>
            <div class="flex-shrink-0 text-center">
                <img src="<?= uploadUrl('applications/photos', $photo) ?>"
                     class="w-32 h-32 rounded-2xl object-cover border-2 border-gray-100 shadow-sm">
                <a href="<?= BASE_URL ?>/admin/applications/download/<?= $app['id'] ?>?key=photo"
                   class="mt-2 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-primary/10 hover:bg-primary hover:text-white text-primary text-xs font-semibold transition">
                    <i class="fas fa-download"></i> Download
                </a>
            </div>
            <?php else: ?>
            <div class="w-32 h-32 rounded-2xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                <i class="fas fa-user text-4xl text-gray-300"></i>
            </div>
            <?php endif; ?>

            <div class="flex-1 grid sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                <?php
                $rows = [
                    'Full Name'     => $app['name'],
                    'Email'         => $app['email'],
                    'Phone'         => $app['phone'],
                    'Date of Birth' => $app['dob'] ? formatDate($app['dob']) : '',
                    'Blood Group'   => $app['blood_group'],
                    'Gender'        => $app['sex'],
                    'Nationality'   => $app['nationality'],
                    'Specialization'=> $app['specialization'],
                    'Designation'   => $app['designation'],
                ];
                foreach ($rows as $label => $val):
                    if (!empty($val)): ?>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold"><?= htmlspecialchars($label) ?></p>
                    <?php if ($label === 'Email'): ?>
                        <a href="mailto:<?= htmlspecialchars($val) ?>" class="font-medium text-primary hover:underline break-words"><?= htmlspecialchars($val) ?></a>
                    <?php elseif ($label === 'Phone'): ?>
                        <a href="tel:<?= htmlspecialchars($val) ?>" class="font-medium text-primary hover:underline"><?= htmlspecialchars($val) ?></a>
                    <?php else: ?>
                        <p class="font-medium text-gray-800 break-words"><?= htmlspecialchars((string)$val) ?></p>
                    <?php endif; ?>
                </div>
                <?php
                    endif;
                endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Address -->
    <?php if (!empty($app['address']) || !empty($app['city'])): ?>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
            <i class="fas fa-map-marker-alt text-primary"></i> Address
        </h3>
        <p class="text-sm text-gray-700 leading-relaxed mb-2"><?= htmlspecialchars($app['address']) ?></p>
        <p class="text-xs text-gray-500"><?= htmlspecialchars(implode(', ', array_filter([$app['city'], $app['state'], $app['country'], $app['zip_code']]))) ?></p>
        <?php if (!empty($app['college'])): ?>
        <div class="mt-4 pt-3 border-t border-gray-100">
            <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">College / Institution</p>
            <p class="text-sm font-medium text-gray-800"><?= htmlspecialchars($app['college']) ?></p>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Type-specific data -->
    <?php if (!empty($formData)): ?>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
            <i class="fas fa-list-alt text-primary"></i> Type-Specific Information
        </h3>
        <div class="grid sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
            <?php foreach ($formData as $k => $v): if ($v === '' || $v === null) continue; ?>
            <div<?= strlen((string)$v) > 80 ? ' class="sm:col-span-2"' : '' ?>>
                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold"><?= htmlspecialchars(prettify_label($k, $prettyLabels)) ?></p>
                <p class="font-medium text-gray-800 break-words whitespace-pre-wrap"><?= htmlspecialchars((string)$v) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php endif; // end honorary vs standard ?>

    <!-- ============== UPLOADED DOCUMENTS (shown for ALL types) ============== -->
    <?php if (!empty($uploadedFiles)): ?>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-800 mb-4 pb-3 border-b border-gray-100 flex items-center gap-2">
            <i class="fas fa-folder-open text-primary"></i> Uploaded Documents
            <span class="text-xs font-normal text-gray-400">(<?= count(array_filter($uploadedFiles)) ?> files)</span>
        </h3>
        <div class="grid sm:grid-cols-2 gap-3">
            <?php foreach ($uploadedFiles as $key => $filename): if (empty($filename)) continue;
                $isPhotoOrLogo = in_array($key, ['photo', 'logo']);
                $subdir   = $isPhotoOrLogo ? 'applications/photos' : 'applications/docs';
                $url      = uploadUrl($subdir, $filename);
                $ext      = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                $isImage  = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                $isPdf    = $ext === 'pdf';
                $icon     = $isImage ? 'fa-image text-blue-500'
                          : ($isPdf  ? 'fa-file-pdf text-red-500'
                          : (in_array($ext, ['doc','docx']) ? 'fa-file-word text-blue-500'
                          : 'fa-file text-gray-500'));
            ?>
            <div class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 hover:border-primary hover:bg-primary/5 transition group">
                <?php if ($isImage): ?>
                <img src="<?= $url ?>" class="w-12 h-12 rounded-lg object-cover border border-gray-100 flex-shrink-0">
                <?php else: ?>
                <i class="fas <?= $icon ?> text-2xl flex-shrink-0 w-12 text-center"></i>
                <?php endif; ?>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-gray-700 uppercase tracking-wider"><?= htmlspecialchars(prettify_label($key, $fileLabels)) ?></p>
                    <p class="text-xs text-gray-500 truncate font-mono"><?= htmlspecialchars($filename) ?></p>
                </div>
                <div class="flex items-center gap-1 flex-shrink-0">
                    <a href="<?= $url ?>" target="_blank" rel="noopener"
                       class="w-9 h-9 rounded-lg bg-gray-100 hover:bg-primary hover:text-white text-gray-500 inline-flex items-center justify-center transition" title="Preview / Open">
                        <i class="fas fa-eye text-xs"></i>
                    </a>
                    <a href="<?= BASE_URL ?>/admin/applications/download/<?= $app['id'] ?>?key=<?= urlencode($key) ?>"
                       class="w-9 h-9 rounded-lg bg-primary text-white hover:bg-primary-dark inline-flex items-center justify-center transition" title="Download">
                        <i class="fas fa-download text-xs"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- ============== STATUS UPDATE + FEES ============== -->
    <div class="grid md:grid-cols-2 gap-6">
        <!-- Status update form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-tasks text-primary"></i> Workflow Status</h3>
            <form id="statusForm">
                <?= Security::csrfField() ?>
                <div class="space-y-2 mb-4">
                    <?php foreach (['pending' => 'Pending', 'approved' => 'Approve', 'rejected' => 'Reject'] as $s => $l): ?>
                    <label class="flex items-center gap-2.5 cursor-pointer p-2.5 rounded-lg border-2 border-gray-200 has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                        <input type="radio" name="status" value="<?= $s ?>" <?= $app['status'] === $s ? 'checked' : '' ?> class="w-4 h-4 accent-primary">
                        <span class="text-sm font-semibold text-gray-700"><?= $l ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>
                <div class="mb-3">
                    <label class="block text-xs font-semibold text-gray-600 mb-1">
                        Membership Generated ID <span class="text-gray-400 font-normal">(optional)</span>
                    </label>
                    <input type="text" name="membership_id" value="<?= htmlspecialchars($app['membership_id'] ?? '') ?>"
                        placeholder="e.g. SBC-2026-001"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm font-mono focus:outline-none focus:border-primary">
                </div>
                <textarea name="notes" rows="3" placeholder="Internal notes (visible only to admin)" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-primary"><?= htmlspecialchars($app['notes'] ?? '') ?></textarea>
                <button type="submit" class="mt-3 w-full bg-primary text-white py-2.5 rounded-xl font-semibold hover:bg-primary-dark transition flex items-center justify-center gap-2 text-sm">
                    <i class="fas fa-save"></i> Save Status
                </button>
            </form>
        </div>

        <!-- Fees -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2"><i class="fas fa-receipt text-primary"></i> Fee Summary</h3>
            <?php if (!$isHonorary || (float)$app['total_amount'] > 0): ?>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-gray-600">Fee</span><span class="font-semibold">₹<?= number_format((float)$app['fee_amount'], 0, '.', ',') ?></span></div>
                <div class="flex justify-between"><span class="text-gray-600">GST</span><span class="font-semibold">₹<?= number_format((float)$app['gst_amount'], 0, '.', ',') ?></span></div>
                <div class="flex justify-between"><span class="text-gray-600">Txn Charges</span><span class="font-semibold">₹<?= number_format((float)$app['transaction_charges'], 0, '.', ',') ?></span></div>
                <div class="flex justify-between pt-2 mt-2 border-t-2 border-dashed border-gray-200">
                    <span class="text-gray-800 font-bold">Total</span>
                    <span class="font-extrabold text-base text-primary">₹<?= number_format((float)$app['total_amount'], 0, '.', ',') ?></span>
                </div>
            </div>
            <?php else: ?>
            <div class="text-center py-4">
                <i class="fas fa-award text-purple-400 text-3xl mb-2 block"></i>
                <p class="text-sm font-bold text-purple-800">Honorary Nomination</p>
                <p class="text-xs text-purple-600 mt-1">No fee. Reviewed quarterly by Editorial Board.</p>
            </div>
            <?php endif; ?>
        </div>

        <!-- Applicant's Transaction Receipt -->
        <?php if (!$isHonorary && !empty($app['txn_receipt_file'])): ?>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-money-check-alt text-primary"></i> Transaction Receipt
                <?php if (!empty($app['txn_verified'])): ?>
                    <span class="ml-auto inline-flex items-center gap-1 text-xs font-bold px-2 py-1 rounded-full bg-green-100 text-green-700">
                        <i class="fas fa-check-circle"></i> Verified
                    </span>
                <?php else: ?>
                    <span class="ml-auto inline-flex items-center gap-1 text-xs font-bold px-2 py-1 rounded-full bg-amber-100 text-amber-700">
                        <i class="fas fa-clock"></i> Pending Verification
                    </span>
                <?php endif; ?>
            </h3>
            <?php
            $receiptPath = BASE_URL . '/uploads/applications/docs/' . $app['txn_receipt_file'];
            $receiptExt  = strtolower(pathinfo($app['txn_receipt_file'], PATHINFO_EXTENSION));
            ?>
            <?php if (in_array($receiptExt, ['jpg', 'jpeg', 'png', 'gif', 'webp'])): ?>
                <a href="<?= htmlspecialchars($receiptPath) ?>" target="_blank">
                    <img src="<?= htmlspecialchars($receiptPath) ?>" alt="Transaction Receipt" class="max-w-full max-h-72 rounded-xl border border-gray-200 shadow-sm">
                </a>
            <?php else: ?>
                <a href="<?= htmlspecialchars($receiptPath) ?>" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-primary/10 text-primary font-semibold text-sm hover:bg-primary/20 transition">
                    <i class="fas fa-file-pdf"></i> View Receipt (<?= htmlspecialchars($app['txn_receipt_file']) ?>)
                </a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- ============== INTERNAL NOTES ============== -->
    <?php if (!empty($app['notes'])): ?>
    <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-r-xl p-5">
        <h4 class="font-bold text-yellow-900 text-sm mb-2 flex items-center gap-2"><i class="fas fa-sticky-note"></i> Saved Notes</h4>
        <p class="text-sm text-yellow-800 whitespace-pre-wrap"><?= htmlspecialchars($app['notes']) ?></p>
    </div>
    <?php endif; ?>

    <!-- ============== METADATA ============== -->
    <div class="bg-gray-50 rounded-xl p-4 text-xs text-gray-500 grid grid-cols-2 md:grid-cols-4 gap-2">
        <div><strong class="text-gray-600">Application ID:</strong><br>#<?= $app['id'] ?></div>
        <div><strong class="text-gray-600">Submitted:</strong><br><?= formatDate($app['created_at']) ?> · <?= date('H:i', strtotime($app['created_at'])) ?></div>
        <?php if (!empty($app['updated_at']) && $app['updated_at'] !== $app['created_at']): ?>
        <div><strong class="text-gray-600">Last update:</strong><br><?= formatDate($app['updated_at']) ?> · <?= date('H:i', strtotime($app['updated_at'])) ?></div>
        <?php endif; ?>
        <?php if (!empty($app['ip_address'])): ?>
        <div><strong class="text-gray-600">IP:</strong><br><?= htmlspecialchars($app['ip_address']) ?></div>
        <?php endif; ?>
    </div>
</div>

<script>
let statusSaving = false;
document.getElementById('statusForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    if (statusSaving) return;
    const btn = this.querySelector('button[type="submit"]');
    const orig = btn.innerHTML;
    statusSaving = true; btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving…';
    try {
        const res = await fetch('<?= BASE_URL ?>/admin/applications/status/<?= $app['id'] ?>', { method: 'POST', body: new FormData(this), headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } });
        const text = await res.text(); let d;
        try { d = JSON.parse(text); } catch (e) { console.error('Non-JSON:', text.substring(0, 500)); throw new Error('Server returned unexpected response.'); }
        if (!res.ok || !d.success) {
            showToast(d.message || ('Failed (HTTP ' + res.status + ')'), 'error');
            statusSaving = false; btn.disabled = false; btn.innerHTML = orig; return;
        }
        showToast(d.message || 'Saved!', 'success');
        btn.innerHTML = '<i class="fas fa-check"></i> Saved';
        setTimeout(() => location.reload(), 700);
    } catch (err) {
        showToast('Save failed: ' + err.message, 'error');
        statusSaving = false; btn.disabled = false; btn.innerHTML = orig;
    }
});
</script>

<style>
@media print {
    aside, .sidebar, header, button, .no-print, form { display: none !important; }
    body { background: white !important; }
    .bg-white { box-shadow: none !important; border: 1px solid #e5e7eb !important; }
}
</style>
