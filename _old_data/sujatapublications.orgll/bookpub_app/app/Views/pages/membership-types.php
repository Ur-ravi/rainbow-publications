<?php
$types    = $types ?? [];
$siteName = getSetting('site_name', 'Rainbow Publications');

// Build a lookup map by slug for the JS engine
$typeMap = [];
foreach ($types as $t) {
    $typeMap[$t['slug']] = [
        'id'        => (int)$t['id'],
        'title'     => $t['title'],
        'slug'      => $t['slug'],
        'fee_label' => $t['fee_label'],
        'fee_num'   => (float)preg_replace('/[^\d.]/', '', $t['fee_label'] ?? '0'),
        'currency'  => stripos($t['fee_label'] ?? '', 'USD') !== false ? 'USD' : 'INR',
        'color'     => $t['card_color'],
    ];
}

$indianStates = ['Andhra Pradesh','Arunachal Pradesh','Assam','Bihar','Chhattisgarh','Goa','Gujarat','Haryana','Himachal Pradesh','Jammu & Kashmir','Jharkhand','Karnataka','Kerala','Madhya Pradesh','Maharashtra','Manipur','Meghalaya','Mizoram','Nagaland','Odisha','Punjab','Rajasthan','Sikkim','Tamil Nadu','Telangana','Tripura','Uttar Pradesh','Uttarakhand','West Bengal','Andaman and Nicobar Islands','Chandigarh','Dadra and Nagar Haveli','Daman & Diu','Delhi','Lakshadweep','Pondicherry'];
sort($indianStates);

$countries = ['India','United States','United Kingdom','Canada','Australia','Germany','France','Italy','Spain','Netherlands','Sweden','Switzerland','Norway','Denmark','Finland','Belgium','Austria','Ireland','Singapore','Malaysia','Thailand','Indonesia','Philippines','Vietnam','Japan','South Korea','China','Hong Kong','Taiwan','New Zealand','South Africa','Egypt','Nigeria','Kenya','Brazil','Mexico','Argentina','Chile','Colombia','UAE','Saudi Arabia','Qatar','Kuwait','Oman','Bahrain','Israel','Turkey','Iran','Iraq','Pakistan','Bangladesh','Sri Lanka','Nepal','Bhutan','Maldives','Russia','Ukraine','Poland','Czech Republic','Hungary','Romania','Greece','Portugal'];
sort($countries);

// Color palette
$palette = [
    'purple' => ['bg' => '#EEEDFE', 'border' => '#CECBF6', 'text' => '#3C3489', 'accent' => '#534AB7'],
    'blue'   => ['bg' => '#E6F1FB', 'border' => '#B5D4F4', 'text' => '#0C447C', 'accent' => '#185FA5'],
    'amber'  => ['bg' => '#FAEEDA', 'border' => '#FAC775', 'text' => '#854F0B', 'accent' => '#BA7517'],
    'green'  => ['bg' => '#EAF3DE', 'border' => '#C0DD97', 'text' => '#27500A', 'accent' => '#3B6D11'],
    'pink'   => ['bg' => '#FAECE7', 'border' => '#F5C4B3', 'text' => '#712B13', 'accent' => '#993C1D'],
    'teal'   => ['bg' => '#E1F5EE', 'border' => '#9FE1CB', 'text' => '#085041', 'accent' => '#0F6E56'],
    'coral'  => ['bg' => '#FBF0E6', 'border' => '#FBBF8A', 'text' => '#7C2D12', 'accent' => '#C2410C'],
];

// Helper to print a state/country select
function selectInput($name, $options, $required = false, $extraClass = '') {
    $req = $required ? 'required' : '';
    echo "<select name=\"$name\" $req class=\"form-input $extraClass\"><option value=\"\">— Select —</option>";
    foreach ($options as $opt) {
        echo '<option value="' . htmlspecialchars($opt) . '">' . htmlspecialchars($opt) . '</option>';
    }
    echo "</select>";
}
?>

<!-- ============ HERO ============ -->
<?php
$pageTitle = 'Join Rainbow Publications';
$heroIntro = 'Choose your membership category and complete the application. Each category has its own tailored form with relevant fields for your role.';
include __DIR__ . '/../partials/hero.php';
?>

<!-- ============ STEPPER PROGRESS BAR ============ -->
<div class="bg-white border-b border-gray-100 sticky top-0 z-30">
    <div class="container mx-auto px-4 py-3 max-w-6xl">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 flex-1">
                <!-- Step 1 -->
                <div class="step-indicator flex items-center gap-2" id="indicator1">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold text-white" style="background: #0F4C75;">1</div>
                    <span class="text-sm font-semibold text-gray-800 hidden sm:inline">Choose Type</span>
                </div>
                <div class="flex-1 h-0.5 bg-gray-200 relative">
                    <div id="progressFill" class="absolute inset-0 transition-all duration-500" style="background: linear-gradient(90deg, #0F4C75, #14919B); width:0%;"></div>
                </div>
                <!-- Step 2 -->
                <div class="step-indicator flex items-center gap-2" id="indicator2">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold bg-gray-200 text-gray-500" id="step2Circle">2</div>
                    <span class="text-sm font-semibold text-gray-400 hidden sm:inline" id="step2Label">Fill Application</span>
                </div>
            </div>
            <button type="button" id="backToStep1" onclick="goToStep(1)" class="hidden text-sm font-semibold text-gray-600 hover:text-primary transition flex items-center gap-1.5">
                <i class="fas fa-arrow-left"></i> <span class="hidden sm:inline">Change Type</span>
            </button>
        </div>
    </div>
</div>

<!-- ============================================================
     STEP 1: MEMBERSHIP TYPE SELECTION
============================================================ -->
<a id="apply"></a>
<section id="step1" class="py-10 md:py-14" style="background:#F8FAFC;">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="text-center mb-10">
            <h2 class="font-modern text-2xl md:text-3xl font-extrabold text-gray-800 mb-2">Select Membership Type</h2>
            <p class="text-gray-500 text-sm">Each category has its own application form tailored to its requirements.</p>
        </div>

        <?php if (empty($types)): ?>
        <div class="text-center py-16 bg-white rounded-2xl shadow-sm">
            <i class="fas fa-id-card-alt text-4xl text-gray-300 mb-3 block"></i>
            <p class="text-gray-500">No membership types configured.</p>
        </div>
        <?php else: ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <?php foreach ($types as $type):
                $c = $palette[$type['card_color']] ?? $palette['purple'];
            ?>
            <button type="button"
                    onclick="selectType('<?= htmlspecialchars($type['slug']) ?>', <?= (int)$type['id'] ?>)"
                    class="type-card group text-left rounded-2xl overflow-hidden border-2 transition-all duration-300 hover:shadow-xl hover:-translate-y-1"
                    style="background: <?= $c['bg'] ?>; border-color: <?= $c['border'] ?>;">
                <div class="px-5 py-4" style="background: <?= $c['border'] ?>;">
                    <div class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-full flex items-center justify-center font-extrabold text-white shadow-md" style="background: <?= $c['accent'] ?>;">
                            <?= (int)$type['badge_number'] ?>
                        </span>
                        <h3 class="font-bold text-base leading-tight" style="color: <?= $c['text'] ?>;">
                            <?= htmlspecialchars($type['title']) ?>
                        </h3>
                    </div>
                </div>
                <div class="p-5">
                    <div class="text-xl font-extrabold mb-2" style="color: <?= $c['text'] ?>;">
                        <?= htmlspecialchars($type['fee_label']) ?>
                    </div>
                    <?php if (!empty($type['comparison_eligibility'])): ?>
                    <p class="text-xs text-gray-600 leading-relaxed line-clamp-2"><?= htmlspecialchars($type['comparison_eligibility']) ?></p>
                    <?php endif; ?>
                    <div class="mt-4 pt-3 border-t border-black/5 flex items-center justify-between">
                        <span class="text-xs uppercase tracking-wider font-semibold" style="color: <?= $c['accent'] ?>;">
                            <?= htmlspecialchars($type['duration_label'] ?? 'Lifetime') ?>
                        </span>
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold transition" style="color: <?= $c['accent'] ?>;">
                            Apply Now <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </span>
                    </div>
                </div>
            </button>
            <?php endforeach; ?>
        </div>
        
        <h3 class="text-xl mt-8 "> <strong> Note:</strong> The Scientific Board Committee (SBC) has the discretion to reject any application without ascribing any reasons. </h3>

        <p class="text-xl mt-4">Choose the Right Membership</p>
        <p class=" text-xs text-gray-400 mt-8 italic">
           
           Whether you are a student, researcher, academician, or institution, Rainbow Publications provides a suitable membership category to support your professional journey and research aspirations.
        </p>
        <?php endif; ?>
    </div>
</section>

<!-- ============================================================
     STEP 2: TYPE-SPECIFIC APPLICATION FORM
============================================================ -->
<section id="step2" class="py-10 md:py-14 hidden" style="background:#F8FAFC;">
    <div class="container mx-auto px-4 max-w-6xl">

        <!-- Selected type banner (color theme reflects the chosen membership type) -->
        <div id="selectedTypeBanner" class="rounded-2xl shadow-md mb-6 overflow-hidden transition-all duration-300 border-2"
             style="background:#fff; border-color:#e5e7eb;">
            <div id="selectedTypeBannerInner" class="p-5 flex items-center justify-between gap-4 transition-colors duration-300">
                <div class="flex items-center gap-4 min-w-0 flex-1">
                    <div id="selectedTypeBadge"
                         class="flex-shrink-0 w-14 h-14 rounded-2xl flex items-center justify-center text-white font-extrabold text-xl shadow-md transition-colors duration-300"
                         style="background:#0F4C75;">
                        —
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs uppercase tracking-wider font-semibold opacity-70" id="selectedTypeLabel">Applying for</p>
                        <p id="selectedTypeTitle" class="font-bold text-lg leading-tight truncate" style="color:#0F4C75;">—</p>
                        <p id="selectedTypeEligibility" class="text-xs mt-0.5 hidden opacity-70"></p>
                    </div>
                </div>
                <div class="text-right hidden sm:block flex-shrink-0">
                    <p class="text-xs uppercase tracking-wider font-semibold opacity-70">Fee</p>
                    <p id="selectedTypeFee" class="font-extrabold text-xl" style="color:#0F4C75;">—</p>
                </div>
            </div>
        </div>

        <!-- ===== HONORARY: Nomination Form ===== -->
        <div id="form-honorary" class="form-panel hidden">
            <!-- Information banner -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
                <div class="px-6 py-5" style="background: linear-gradient(135deg, #EEEDFE, #CECBF6);">
                    <h3 class="font-bold text-lg" style="color:#3C3489;">
                        <i class="fas fa-award mr-2"></i> Honorary Membership — Nomination
                    </h3>
                </div>
                <div class="p-6">
                    <div class="bg-purple-50 border-l-4 border-purple-400 rounded-r-xl p-4">
                        <p class="text-purple-900 font-semibold text-sm mb-1">
                            <i class="fas fa-info-circle mr-1"></i> Nomination-based — no fee or payment required.
                        </p>
                        <p class="text-purple-800 text-sm leading-relaxed">
                            Use this form to nominate a distinguished scientist, academician or professional. The Editorial / Advisory Board reviews each nomination quarterly.
                        </p>
                    </div>
                </div>
            </div>

            <?php
            $honorary = null;
            foreach ($types as $t) if (($t['slug'] ?? '') === 'honorary') { $honorary = $t; break; }
            $honoraryId = $honorary['id'] ?? 0;
            $emails = $honorary ? array_values(array_filter(array_map('trim', preg_split('/[,;\s]+/', $honorary['nomination_emails'] ?? '')))) : [];
            ?>

            <!-- Nomination form (separate form, sibling of memberForm) -->
            <form id="honoraryForm" enctype="multipart/form-data" class="space-y-6">
                <?= Security::csrfField() ?>
                <input type="hidden" name="membership_type_id" value="<?= (int)$honoraryId ?>">
                <input type="hidden" name="is_honorary" value="1">

                <!-- Nominator -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4" style="background: linear-gradient(135deg, #EEEDFE, #CECBF6);">
                        <h3 class="font-bold text-base" style="color:#3C3489;"><i class="fas fa-user-edit mr-2"></i> Nominator (Your Details)</h3>
                    </div>
                    <div class="p-6 grid sm:grid-cols-2 gap-4">
                        <div><label class="form-label">Your Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required class="form-input"></div>
                        <div><label class="form-label">Your Designation</label>
                            <input type="text" name="designation" class="form-input" placeholder="e.g. Professor"></div>
                        <div><label class="form-label">Your Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" required class="form-input"></div>
                        <div><label class="form-label">Your Phone <span class="text-red-500">*</span></label>
                            <input type="tel" name="phone" required class="form-input"></div>
                        <div class="sm:col-span-2"><label class="form-label">Your Affiliation / Institution</label>
                            <input type="text" name="college" class="form-input" placeholder="University, Society, Company, etc."></div>
                    </div>
                </div>

                <!-- Nominee -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4" style="background: linear-gradient(135deg, #EEEDFE, #CECBF6);">
                        <h3 class="font-bold text-base" style="color:#3C3489;"><i class="fas fa-user-tie mr-2"></i> Nominee Details</h3>
                    </div>
                    <div class="p-6 grid sm:grid-cols-2 gap-4">
                        <div><label class="form-label">Nominee Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="fd[nominee_name]" required class="form-input"></div>
                        <div><label class="form-label">Nominee Designation</label>
                            <input type="text" name="fd[nominee_designation]" class="form-input" placeholder="e.g. Distinguished Professor"></div>
                        <div class="sm:col-span-2"><label class="form-label">Nominee Institution / Organization <span class="text-red-500">*</span></label>
                            <input type="text" name="fd[nominee_institution]" required class="form-input"></div>
                        <div><label class="form-label">Nominee Email</label>
                            <input type="email" name="fd[nominee_email]" class="form-input"></div>
                        <div><label class="form-label">Nominee Country <span class="text-red-500">*</span></label>
                            <?php
                            echo '<select name="fd[nominee_country]" required class="form-input"><option value="">— Select —</option>';
                            foreach ($countries as $cc) echo '<option value="' . htmlspecialchars($cc) . '"' . ($cc === 'India' ? ' selected' : '') . '>' . htmlspecialchars($cc) . '</option>';
                            echo '</select>';
                            ?></div>
                        <div class="sm:col-span-2"><label class="form-label">Field of Expertise / Specialization</label>
                            <input type="text" name="fd[expertise]" class="form-input" placeholder="e.g. Pharmaceutical Sciences, Drug Discovery"></div>
                    </div>
                </div>

                <!-- Justification -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4" style="background: linear-gradient(135deg, #EEEDFE, #CECBF6);">
                        <h3 class="font-bold text-base" style="color:#3C3489;"><i class="fas fa-feather-alt mr-2"></i> Justification &amp; Contributions</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="form-label">Why does this person deserve Honorary Membership? <span class="text-red-500">*</span></label>
                            <textarea name="fd[justification]" required minlength="100" rows="5" class="form-input resize-none"
                                placeholder="Describe the nominee&#39;s outstanding contributions to pharmaceutical, biomedical, or scientific research. Include their key achievements, awards, publications, and impact on the field."></textarea>
                            <p class="text-xs text-gray-400 mt-1">Minimum 100 characters.</p>
                        </div>
                        <div>
                            <label class="form-label">Key Publications / Awards (optional)</label>
                            <textarea name="fd[publications]" rows="3" class="form-input resize-none"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Documents -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4" style="background: linear-gradient(135deg, #EEEDFE, #CECBF6);">
                        <h3 class="font-bold text-base" style="color:#3C3489;"><i class="fas fa-file-upload mr-2"></i> Supporting Documents</h3>
                    </div>
                    <div class="p-6 grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Nominee CV <span class="text-red-500">*</span></label>
                            <input type="file" name="files[nominee_cv]" accept=".pdf,.doc,.docx,image/*" required class="form-input">
                            <p class="text-xs text-gray-400 mt-1">PDF preferred. Max 5 MB.</p>
                        </div>
                        <div>
                            <label class="form-label">Nomination Letter (optional)</label>
                            <input type="file" name="files[nomination_letter]" accept=".pdf,.doc,.docx,image/*" class="form-input">
                        </div>
                    </div>
                </div>

                <!-- Agreement + Submit -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="agreement" value="1" required class="mt-1 w-5 h-5 rounded accent-primary flex-shrink-0">
                        <span class="text-sm text-gray-700 leading-relaxed">
                            I confirm the information provided is accurate to the best of my knowledge. I understand that the <strong>Editorial / Advisory Board</strong> reviews nominations and reserves the right to accept or decline without ascribing reasons.
                        </span>
                    </label>
                    <button type="submit" id="honorarySubmitBtn"
                        class="mt-5 w-full text-white px-6 py-3.5 rounded-xl font-bold text-base shadow-md hover:shadow-lg transition-all active:scale-[0.98] flex items-center justify-center gap-2"
                        style="background: linear-gradient(135deg, #534AB7, #3C3489);">
                        <i class="fas fa-paper-plane"></i> Submit Nomination
                    </button>
                    <p class="text-xs text-gray-400 text-center mt-3">Your nomination will be reviewed quarterly.</p>
                </div>

                <!-- Email fallback -->
                <?php if (!empty($emails)): ?>
                <div class="text-center text-sm text-gray-500 pt-2">
                    Prefer email? You can also nominate via
                    <?php foreach ($emails as $i => $em): ?><?= $i > 0 ? ' or ' : '' ?><a href="mailto:<?= htmlspecialchars($em) ?>?subject=Honorary%20Membership%20Nomination" class="text-primary font-semibold hover:underline"><?= htmlspecialchars($em) ?></a><?php endforeach; ?>
                </div>
                <?php endif; ?>
            </form>
        </div>

        <!-- ===== ACTUAL FORM (covers all other 6 types) ===== -->
        <form id="memberForm" enctype="multipart/form-data" class="grid lg:grid-cols-3 gap-6">
            <?= Security::csrfField() ?>
            <input type="hidden" name="membership_type_id" id="hiddenTypeId" value="">
            <input type="hidden" name="membership_type_slug" id="hiddenTypeSlug" value="">
            <input type="hidden" name="fee_amount" id="hiddenFee" value="0">
            <input type="hidden" name="gst_amount" id="hiddenGst" value="0">
            <input type="hidden" name="transaction_charges" id="hiddenTxn" value="0">
            <input type="hidden" name="total_amount" id="hiddenTotal" value="0">
            <input type="hidden" name="currency" id="hiddenCurrency" value="INR">

            <div class="lg:col-span-2 space-y-6">

                <!-- =================================================
                     PATRON MEMBERSHIP FORM
                ================================================= -->
                <div id="form-patron" class="form-panel hidden space-y-6">

                    <!-- Personal Info -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #E6F1FB, #B5D4F4);">
                            <h3 class="font-bold text-base" style="color:#0C447C;">
                                <i class="fas fa-user mr-2"></i> Personal Information
                            </h3>
                        </div>
                        <div class="p-6 grid sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="form-label">Profile Photo <span class="text-red-500">*</span></label>
                                <input type="file" name="files[photo]" accept="image/*" class="form-input photo-input" data-preview="patron_photo_preview">
                                <img id="patron_photo_preview" class="hidden mt-2 w-24 h-24 object-cover rounded-xl border-2 border-gray-200">
                            </div>
                            <div><label class="form-label">Full Name <span class="text-red-500">*</span></label><input type="text" name="name" class="form-input"></div>
                            <div><label class="form-label">Date of Birth</label><input type="date" name="dob" class="form-input"></div>
                            <div>
                                <label class="form-label">Gender</label>
                                <select name="sex" class="form-input"><option value="">— Select —</option><option>Male</option><option>Female</option><option>Other</option></select>
                            </div>
                            <div><label class="form-label">Email <span class="text-red-500">*</span></label><input type="email" name="email" class="form-input"></div>
                            <div class="sm:col-span-2"><label class="form-label">Mobile <span class="text-red-500">*</span></label><input type="tel" name="phone" class="form-input"></div>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #E6F1FB, #B5D4F4);">
                            <h3 class="font-bold text-base" style="color:#0C447C;"><i class="fas fa-map-marker-alt mr-2"></i> Address Information</h3>
                        </div>
                        <div class="p-6 grid sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2"><label class="form-label">Address</label><textarea name="address" rows="2" class="form-input resize-none"></textarea></div>
                            <div><label class="form-label">City</label><input type="text" name="city" class="form-input"></div>
                            <div><label class="form-label">State</label><?php selectInput('state', $indianStates); ?></div>
                            <div><label class="form-label">Country</label><?php selectInput('country', $countries); ?></div>
                            <div><label class="form-label">PIN Code</label><input type="text" name="zip_code" class="form-input"></div>
                        </div>
                    </div>

                    <!-- Professional Info -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #E6F1FB, #B5D4F4);">
                            <h3 class="font-bold text-base" style="color:#0C447C;"><i class="fas fa-briefcase mr-2"></i> Professional Information</h3>
                        </div>
                        <div class="p-6 grid sm:grid-cols-2 gap-4">
                            <div><label class="form-label">Organization Name</label><input type="text" name="fd[organization_name]" class="form-input"></div>
                            <div><label class="form-label">Designation</label><input type="text" name="designation" class="form-input"></div>
                            <div>
                                <label class="form-label">Industry Type</label>
                                <select name="fd[industry_type]" class="form-input">
                                    <option value="">— Select —</option>
                                    <option>Pharmaceutical</option><option>Biotechnology</option><option>Healthcare</option>
                                    <option>Academic / Research</option><option>Government</option><option>Other</option>
                                </select>
                            </div>
                            <div><label class="form-label">Website</label><input type="url" name="fd[website]" class="form-input" placeholder="https://"></div>
                        </div>
                    </div>

                    <!-- Contribution -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #E6F1FB, #B5D4F4);">
                            <h3 class="font-bold text-base" style="color:#0C447C;"><i class="fas fa-hand-holding-heart mr-2"></i> Contribution Information</h3>
                        </div>
                        <div class="p-6 grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Sponsorship Category</label>
                                <select name="fd[sponsorship_category]" class="form-input">
                                    <option value="">— Select —</option>
                                    <option>Platinum Sponsor</option><option>Gold Sponsor</option><option>Silver Sponsor</option>
                                    <option>Conference Sponsor</option><option>Journal Sponsor</option><option>Other</option>
                                </select>
                            </div>
                            <div class="sm:col-span-2"><label class="form-label">Remarks / Message</label><textarea name="fd[remarks]" rows="3" class="form-input resize-none"></textarea></div>
                        </div>
                    </div>

                    <!-- Uploads -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #E6F1FB, #B5D4F4);">
                            <h3 class="font-bold text-base" style="color:#0C447C;"><i class="fas fa-upload mr-2"></i> Documents</h3>
                        </div>
                        <div class="p-6 grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">ID Proof (PDF/Image) <span class="text-red-500">*</span></label>
                                <input type="file" name="files[id_proof]" accept=".pdf,image/*" class="form-input">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- =================================================
                     INSTITUTIONAL MEMBERSHIP FORM
                ================================================= -->
                <div id="form-institutional" class="form-panel hidden space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #FAEEDA, #FAC775);">
                            <h3 class="font-bold text-base" style="color:#854F0B;"><i class="fas fa-university mr-2"></i> Institution Information</h3>
                        </div>
                        <div class="p-6 grid sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2"><label class="form-label">Institution Name <span class="text-red-500">*</span></label><input type="text" name="name" class="form-input" placeholder="ABC University / XYZ Pharma Industries"></div>
                            <div>
                                <label class="form-label">Institution Type <span class="text-red-500">*</span></label>
                                <select name="fd[institution_type]" class="form-input">
                                    <option value="">— Select —</option>
                                    <option>University</option><option>College</option><option>Hospital</option>
                                    <option>Research Institute</option><option>Pharmaceutical Industry</option><option>Other</option>
                                </select>
                            </div>
                            <div><label class="form-label">Establishment Year</label><input type="number" min="1800" max="<?= date('Y') ?>" name="fd[establishment_year]" class="form-input"></div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #FAEEDA, #FAC775);">
                            <h3 class="font-bold text-base" style="color:#854F0B;"><i class="fas fa-user-tie mr-2"></i> Contact Person</h3>
                        </div>
                        <div class="p-6 grid sm:grid-cols-2 gap-4">
                            <div><label class="form-label">Name <span class="text-red-500">*</span></label><input type="text" name="fd[contact_person_name]" class="form-input"></div>
                            <div><label class="form-label">Designation</label><input type="text" name="designation" class="form-input"></div>
                            <div><label class="form-label">Email <span class="text-red-500">*</span></label><input type="email" name="email" class="form-input"></div>
                            <div><label class="form-label">Mobile <span class="text-red-500">*</span></label><input type="tel" name="phone" class="form-input"></div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #FAEEDA, #FAC775);">
                            <h3 class="font-bold text-base" style="color:#854F0B;"><i class="fas fa-map-marker-alt mr-2"></i> Institution Address</h3>
                        </div>
                        <div class="p-6 grid sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2"><label class="form-label">Address</label><textarea name="address" rows="2" class="form-input resize-none"></textarea></div>
                            <div><label class="form-label">City</label><input type="text" name="city" class="form-input"></div>
                            <div><label class="form-label">State</label><?php selectInput('state', $indianStates); ?></div>
                            <div><label class="form-label">Country</label><?php selectInput('country', $countries); ?></div>
                            <div><label class="form-label">PIN Code</label><input type="text" name="zip_code" class="form-input"></div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #FAEEDA, #FAC775);">
                            <h3 class="font-bold text-base" style="color:#854F0B;"><i class="fas fa-upload mr-2"></i> Upload Documents</h3>
                        </div>
                        <div class="p-6 grid sm:grid-cols-2 gap-4">
                            <div><label class="form-label">Registration Certificate <span class="text-red-500">*</span></label><input type="file" name="files[registration_certificate]" accept=".pdf,image/*" class="form-input"></div>
                            <div><label class="form-label">GST Certificate</label><input type="file" name="files[gst_certificate]" accept=".pdf,image/*" class="form-input"></div>
                            <div class="sm:col-span-2"><label class="form-label">Institution Logo</label><input type="file" name="files[logo]" accept="image/*" class="form-input photo-input" data-preview="inst_logo_preview"></div>
                            <img id="inst_logo_preview" class="hidden w-24 h-24 object-contain rounded-xl border-2 border-gray-200 bg-white p-2">
                        </div>
                    </div>
                </div>

                <!-- =================================================
                     LIFE MEMBERSHIP FORM (and LIFE-SENIOR — shares fields)
                ================================================= -->
                <?php
                // Helper to render the Life form (used twice: once for life, once for life-senior with extra fields)
                function lifeFormSection($variant, $textColor, $indianStates, $countries) {
                    $isSenior = ($variant === 'senior');
                    $colorVar = $isSenior ? '#FAECE7, #F5C4B3' : '#EAF3DE, #C0DD97';
                ?>
                <div id="form-life<?= $isSenior ? '-senior' : '' ?>" class="form-panel hidden space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, <?= $colorVar ?>);">
                            <h3 class="font-bold text-base" style="color:<?= $textColor ?>;"><i class="fas fa-user mr-2"></i> Personal Details</h3>
                        </div>
                        <div class="p-6 grid sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="form-label">Profile Photo <span class="text-red-500">*</span></label>
                                <input type="file" name="files[photo]" accept="image/*" class="form-input photo-input" data-preview="life<?= $isSenior ? '_senior' : '' ?>_photo_preview">
                                <img id="life<?= $isSenior ? '_senior' : '' ?>_photo_preview" class="hidden mt-2 w-24 h-24 object-cover rounded-xl border-2 border-gray-200">
                            </div>
                            <div><label class="form-label">Full Name <span class="text-red-500">*</span></label><input type="text" name="name" class="form-input"></div>
                            <div><label class="form-label">Date of Birth <span class="text-red-500">*</span></label><input type="date" name="dob" class="form-input"></div>
                            <div>
                                <label class="form-label">Gender</label>
                                <select name="sex" class="form-input"><option value="">— Select —</option><option>Male</option><option>Female</option><option>Other</option></select>
                            </div>
                            <div>
                                <label class="form-label">Blood Group</label>
                                <select name="blood_group" class="form-input">
                                    <option value="">— Select —</option>
                                    <?php foreach (['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $bg) echo "<option>$bg</option>"; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, <?= $colorVar ?>);">
                            <h3 class="font-bold text-base" style="color:<?= $textColor ?>;"><i class="fas fa-phone mr-2"></i> Contact Details</h3>
                        </div>
                        <div class="p-6 grid sm:grid-cols-2 gap-4">
                            <div><label class="form-label">Email <span class="text-red-500">*</span></label><input type="email" name="email" class="form-input"></div>
                            <div><label class="form-label">Mobile <span class="text-red-500">*</span></label><input type="tel" name="phone" class="form-input"></div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, <?= $colorVar ?>);">
                            <h3 class="font-bold text-base" style="color:<?= $textColor ?>;"><i class="fas fa-map-marker-alt mr-2"></i> Address</h3>
                        </div>
                        <div class="p-6 grid sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2"><label class="form-label">Address <span class="text-red-500">*</span></label><textarea name="address" rows="2" class="form-input resize-none"></textarea></div>
                            <div><label class="form-label">City</label><input type="text" name="city" class="form-input"></div>
                            <div><label class="form-label">State</label><?php selectInput('state', $indianStates); ?></div>
                            <div><label class="form-label">Country</label><?php selectInput('country', $countries); ?></div>
                            <div><label class="form-label">PIN</label><input type="text" name="zip_code" class="form-input"></div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, <?= $colorVar ?>);">
                            <h3 class="font-bold text-base" style="color:<?= $textColor ?>;"><i class="fas fa-graduation-cap mr-2"></i> Qualification</h3>
                        </div>
                        <div class="p-6 grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Degree Category <span class="text-red-500">*</span></label>
                                <select name="fd[degree_category]" class="form-input">
                                    <option value="">— Select —</option>
                                    <option>Pharmacy</option><option>Life Sciences</option>
                                    <option>Applied Sciences</option><option>Other</option>
                                </select>
                            </div>
                            <div><label class="form-label">Degree Name <span class="text-red-500">*</span></label><input type="text" name="fd[degree_name]" class="form-input" placeholder="e.g. B.Pharm, M.Sc"></div>
                            <div><label class="form-label">Year of Passing</label><input type="number" min="1950" max="<?= date('Y') ?>" name="fd[degree_year]" class="form-input"></div>
                            <div><label class="form-label">Institute Name <span class="text-red-500">*</span></label><input type="text" name="fd[institute_name]" class="form-input"></div>
                            <div class="sm:col-span-2"><label class="form-label">University Name <span class="text-red-500">*</span></label><input type="text" name="fd[university_name]" class="form-input"></div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, <?= $colorVar ?>);">
                            <h3 class="font-bold text-base" style="color:<?= $textColor ?>;"><i class="fas fa-upload mr-2"></i> Uploads</h3>
                        </div>
                        <div class="p-6 grid sm:grid-cols-2 gap-4">
                            <div><label class="form-label">Degree Certificate <span class="text-red-500">*</span></label><input type="file" name="files[degree_certificate]" accept=".pdf,image/*" class="form-input"></div>
                            <?php if ($isSenior): ?>
                            <div>
                                <label class="form-label">Age Proof <span class="text-red-500">*</span></label>
                                <input type="file" name="files[age_proof]" accept=".pdf,image/*" class="form-input">
                                <p class="text-xs text-amber-700 mt-1"><i class="fas fa-info-circle"></i> Age must be ≥ 60 years. Acceptable: PAN, Aadhaar, Passport.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php } // end lifeFormSection

                // Render both Life and Life-Senior
                lifeFormSection('life',   '#27500A', $indianStates, $countries);
                lifeFormSection('senior', '#712B13', $indianStates, $countries);
                ?>

                <!-- =================================================
                     INTERNATIONAL MEMBERSHIP FORM
                ================================================= -->
                <div id="form-international" class="form-panel hidden space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #E1F5EE, #9FE1CB);">
                            <h3 class="font-bold text-base" style="color:#085041;"><i class="fas fa-globe mr-2"></i> Personal Details</h3>
                        </div>
                        <div class="p-6 grid sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="form-label">Profile Photo <span class="text-red-500">*</span></label>
                                <input type="file" name="files[photo]" accept="image/*" class="form-input photo-input" data-preview="intl_photo_preview">
                                <img id="intl_photo_preview" class="hidden mt-2 w-24 h-24 object-cover rounded-xl border-2 border-gray-200">
                            </div>
                            <div><label class="form-label">Full Name <span class="text-red-500">*</span></label><input type="text" name="name" class="form-input"></div>
                            <div><label class="form-label">Nationality <span class="text-red-500">*</span></label><input type="text" name="nationality" class="form-input" placeholder="e.g. American, British"></div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #E1F5EE, #9FE1CB);">
                            <h3 class="font-bold text-base" style="color:#085041;"><i class="fas fa-phone mr-2"></i> Contact Details</h3>
                        </div>
                        <div class="p-6 grid sm:grid-cols-2 gap-4">
                            <div><label class="form-label">Email <span class="text-red-500">*</span></label><input type="email" name="email" class="form-input"></div>
                            <div><label class="form-label">Mobile (with country code) <span class="text-red-500">*</span></label><input type="tel" name="phone" class="form-input" placeholder="+1 555 123 4567"></div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #E1F5EE, #9FE1CB);">
                            <h3 class="font-bold text-base" style="color:#085041;"><i class="fas fa-map-marker-alt mr-2"></i> International Address</h3>
                        </div>
                        <div class="p-6 grid sm:grid-cols-2 gap-4">
                            <div><label class="form-label">Country <span class="text-red-500">*</span></label><?php selectInput('country', $countries, true); ?></div>
                            <div><label class="form-label">State / Province</label><input type="text" name="state" class="form-input"></div>
                            <div><label class="form-label">City</label><input type="text" name="city" class="form-input"></div>
                            <div><label class="form-label">Postal Code</label><input type="text" name="zip_code" class="form-input"></div>
                            <div class="sm:col-span-2"><label class="form-label">Full Address</label><textarea name="address" rows="2" class="form-input resize-none"></textarea></div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #E1F5EE, #9FE1CB);">
                            <h3 class="font-bold text-base" style="color:#085041;"><i class="fas fa-graduation-cap mr-2"></i> Academic Qualification</h3>
                        </div>
                        <div class="p-6 grid sm:grid-cols-2 gap-4">
                            <div><label class="form-label">Degree <span class="text-red-500">*</span></label><input type="text" name="fd[degree]" class="form-input" placeholder="e.g. Ph.D. in Pharmaceutical Sciences"></div>
                            <div><label class="form-label">University <span class="text-red-500">*</span></label><input type="text" name="fd[university]" class="form-input"></div>
                            <div class="sm:col-span-2"><label class="form-label">Country of University</label><?php selectInput('fd[university_country]', $countries); ?></div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #E1F5EE, #9FE1CB);">
                            <h3 class="font-bold text-base" style="color:#085041;"><i class="fas fa-upload mr-2"></i> Documents</h3>
                        </div>
                        <div class="p-6 grid sm:grid-cols-2 gap-4">
                            <div><label class="form-label">Passport Copy <span class="text-red-500">*</span></label><input type="file" name="files[passport]" accept=".pdf,image/*" class="form-input"></div>
                            <div><label class="form-label">Degree Certificate <span class="text-red-500">*</span></label><input type="file" name="files[degree_certificate]" accept=".pdf,image/*" class="form-input"></div>
                        </div>
                    </div>
                </div>

                <!-- =================================================
                     STUDENT MEMBERSHIP FORM
                ================================================= -->
                <div id="form-student" class="form-panel hidden space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #FBF0E6, #FBBF8A);">
                            <h3 class="font-bold text-base" style="color:#7C2D12;"><i class="fas fa-user-graduate mr-2"></i> Student Information</h3>
                        </div>
                        <div class="p-6 grid sm:grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <label class="form-label">Passport-size Photo <span class="text-red-500">*</span></label>
                                <input type="file" name="files[photo]" accept="image/*" class="form-input photo-input" data-preview="student_photo_preview">
                                <img id="student_photo_preview" class="hidden mt-2 w-24 h-24 object-cover rounded-xl border-2 border-gray-200">
                            </div>
                            <div><label class="form-label">Full Name <span class="text-red-500">*</span></label><input type="text" name="name" class="form-input"></div>
                            <div><label class="form-label">Date of Birth <span class="text-red-500">*</span></label><input type="date" name="dob" class="form-input"></div>
                            <div>
                                <label class="form-label">Gender</label>
                                <select name="sex" class="form-input"><option value="">— Select —</option><option>Male</option><option>Female</option><option>Other</option></select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #FBF0E6, #FBBF8A);">
                            <h3 class="font-bold text-base" style="color:#7C2D12;"><i class="fas fa-book mr-2"></i> Academic Information</h3>
                        </div>
                        <div class="p-6 grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Course <span class="text-red-500">*</span></label>
                                <select name="fd[course]" class="form-input">
                                    <option value="">— Select —</option>
                                    <option>B.Pharm</option><option>M.Pharm</option><option>B.Sc</option>
                                    <option>M.Sc</option><option>PhD</option><option>Pharm.D</option><option>Other</option>
                                </select>
                            </div>
                            <div><label class="form-label">Year / Semester <span class="text-red-500">*</span></label><input type="text" name="fd[year_semester]" class="form-input" placeholder="e.g. 2nd Year / Sem 4"></div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #FBF0E6, #FBBF8A);">
                            <h3 class="font-bold text-base" style="color:#7C2D12;"><i class="fas fa-school mr-2"></i> Institution Details</h3>
                        </div>
                        <div class="p-6 grid sm:grid-cols-2 gap-4">
                            <div><label class="form-label">College Name <span class="text-red-500">*</span></label><input type="text" name="college" class="form-input"></div>
                            <div><label class="form-label">University Name <span class="text-red-500">*</span></label><input type="text" name="fd[university_name]" class="form-input"></div>
                            <div><label class="form-label">City</label><input type="text" name="city" class="form-input"></div>
                            <div><label class="form-label">State</label><?php selectInput('state', $indianStates); ?></div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #FBF0E6, #FBBF8A);">
                            <h3 class="font-bold text-base" style="color:#7C2D12;"><i class="fas fa-phone mr-2"></i> Contact Information</h3>
                        </div>
                        <div class="p-6 grid sm:grid-cols-2 gap-4">
                            <div><label class="form-label">Email <span class="text-red-500">*</span></label><input type="email" name="email" class="form-input"></div>
                            <div><label class="form-label">Mobile <span class="text-red-500">*</span></label><input type="tel" name="phone" class="form-input"></div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4" style="background: linear-gradient(135deg, #FBF0E6, #FBBF8A);">
                            <h3 class="font-bold text-base" style="color:#7C2D12;"><i class="fas fa-upload mr-2"></i> Uploads</h3>
                        </div>
                        <div class="p-6 grid sm:grid-cols-2 gap-4">
                            <div><label class="form-label">Student ID Proof (PDF/Image)  <span class="text-red-500">*</span></label><input type="file" name="files[student_id]" accept=".pdf,image/*" class="form-input"></div>
                            <div><label class="form-label">Upload Degree/Certificate <span class="text-red-500">*</span></label><input type="file" name="files[bonafide_certificate]" accept=".pdf,image/*" class="form-input"></div>
                        </div>
                    </div>
                </div>

                <!-- ===== TRANSACTION RECEIPT (shared for all 6 paid form variants) ===== -->
                <div id="transactionBox" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hidden">
                    <div class="px-6 py-4" style="background: linear-gradient(135deg, #0F4C75, #14919B);">
                        <h3 class="font-bold text-base text-white"><i class="fas fa-receipt mr-2"></i> Transaction Receipt</h3>
                        <p class="text-xs text-white/80 mt-1">Upload a screenshot or PDF of your payment confirmation so we can verify your membership fee.</p>
                    </div>
                    <div class="p-6">
                        <label class="form-label">Transaction Receipt <span class="text-red-500">*</span></label>
                        <input type="file" name="files[transaction_receipt]" accept=".pdf,image/*" required class="form-input">
                        <p class="text-xs text-gray-400 mt-1">PDF, JPG or PNG. Max 5 MB. Upload a clear screenshot of the successful payment confirmation.</p>
                    </div>
                </div>

                <!-- ===== AGREEMENT + SUBMIT (shared for all 6 form variants) ===== -->
                <div id="agreementBox" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hidden">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="agreement" value="1" required class="mt-1 w-5 h-5 rounded accent-primary flex-shrink-0">
                        <span class="text-sm text-gray-700 leading-relaxed">
                            By checking this, I agree to abide by the <strong>rules &amp; regulations</strong> of <?= htmlspecialchars($siteName) ?>.
                            I understand that the <strong>Scientific Board Committee (SBC) has the discretion to approve or reject any application</strong> without ascribing any reasons.
                        </span>
                    </label>
                    <button type="submit" id="submitBtn"
                            class="mt-5 w-full text-white px-6 py-3.5 rounded-xl font-bold text-base shadow-md hover:shadow-lg transition-all active:scale-[0.98] flex items-center justify-center gap-2"
                            style="background: linear-gradient(135deg, #0F4C75, #14919B);">
                        <i class="fas fa-paper-plane"></i>
                        Submit Application
                    </button>
                    <p class="text-xs text-gray-400 text-center mt-3">
                        After submission, our team will review your application and contact you via email within 3–5 business days.
                    </p>
                </div>

            </div>

            <!-- ============ RIGHT: STICKY FEE SUMMARY ============ -->
            <aside class="lg:col-span-1" id="feeSidebar">
                <div class="lg:sticky lg:top-24 space-y-4">

                    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                        <div class="px-5 py-4 text-white" style="background: linear-gradient(135deg, #0F4C75, #14919B);">
                            <h3 class="font-bold text-base flex items-center gap-2"><i class="fas fa-receipt"></i> Fee Summary</h3>
                        </div>
                        <div class="p-5 space-y-3">
                            <div class="bg-primary/5 border border-primary/20 rounded-lg p-3">
                                <p class="text-xs uppercase tracking-wider text-gray-500 font-semibold mb-1">Membership Type</p>
                                <p class="text-sm font-bold text-gray-800" id="sidebarTypeName">—</p>
                            </div>

                            <div class="space-y-2 text-sm pt-2 border-t border-gray-100">
                                <div class="flex justify-between"><span class="text-gray-600">Membership Fee</span><span class="font-semibold" id="sidebarFee">₹0</span></div>
                            </div>
                            <p id="sidebarValidity" class="text-xs text-center text-gray-400 italic pt-1 hidden"></p>
                        </div>
                    </div>

                    <div class="bg-amber-50 border-l-4 border-amber-400 rounded-r-xl p-4">
                        <h4 class="font-bold text-amber-900 text-sm mb-2 flex items-center gap-2">
                            <i class="fas fa-lightbulb text-amber-500"></i>Payment Details
                        </h4>
                        <ul class="text-xs text-amber-800 space-y-1.5 leading-relaxed">
                            <li><strong> Bank Name</strong> -  HDFC</li>
                            <li><strong> Account Holder </strong> -  Global Rainbow Publications LLP </li>
                            <li><strong> Account Number </strong> -  50200108175312 </li>
                            <li><strong> IFSC Code</strong> -  HDFC0002085 </li>
                            
                        </ul>
                    </div>
                    
                    
                    
                       <?php if (!empty($payment['qr_code'])): ?>
            <div class="text-center mt-8 pt-8 border-t border-gray-100">
                <p class="text-sm font-semibold text-gray-500 mb-3">Scan QR Code to Pay</p>
                <img src="<?= uploadUrl('payment', $payment['qr_code']) ?>"
                     alt="Payment QR Code" class="max-w-[250px] mx-auto rounded-xl shadow border border-gray-100">
            </div>
            <?php endif; ?>
                    
                    
                </div>
            </aside>
        </form>
    </div>
</section>

<!-- Footer tagline -->
<section class="py-10 bg-white">
    <div class="container mx-auto px-4 text-center">
        <p class="font-modern text-2xl font-extrabold text-slate-800 mb-1">Rainbow Publications</p>
        <p class="text-slate-500 text-sm tracking-wider">Empowering Research <span class="mx-2 text-slate-300">|</span> Advancing Science <span class="mx-2 text-slate-300">|</span> Connecting Scholars</p>
    </div>
</section>

<style>
/* === Membership Types page polish === */
.type-card {
    cursor: pointer;
    position: relative;
}
.type-card:focus { outline: none; }
.type-card:focus-visible {
    outline: 3px solid #14919B;
    outline-offset: 3px;
}
.type-card:active {
    transform: translateY(0) scale(0.98) !important;
}

/* Smooth fade-in for Step 2 */
#step2:not(.hidden) {
    animation: stepFadeIn 0.4s ease-out;
}
@keyframes stepFadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Form panel fade-in */
.form-panel:not(.hidden) {
    animation: panelSlideIn 0.35s ease-out;
}
@keyframes panelSlideIn {
    from { opacity: 0; transform: translateY(6px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Better focus state for radio cards */
.form-panel label:has(input[type="radio"]:checked),
.form-panel label:has(input[type="checkbox"]:checked) {
    transition: all 0.2s ease;
}

/* Mobile responsiveness — make selected-type banner stack on small screens */
@media (max-width: 640px) {
    #selectedTypeBannerInner {
        flex-direction: column;
        align-items: flex-start !important;
        text-align: left;
    }
    #selectedTypeBanner .text-right {
        text-align: left !important;
    }
}

/* Loading spinner consistency */
.fa-spinner {
    animation: fa-spin 1s linear infinite;
}
@keyframes fa-spin {
    from { transform: rotate(0deg); }
    to   { transform: rotate(360deg); }
}

/* Make file inputs look consistent across browsers */
.form-input[type="file"] {
    padding: 0.5rem 0.75rem;
    cursor: pointer;
}
.form-input[type="file"]::-webkit-file-upload-button {
    background: #f1f5f9;
    border: none;
    padding: 0.4rem 0.8rem;
    border-radius: 0.4rem;
    font-size: 0.85rem;
    font-weight: 600;
    color: #0F4C75;
    cursor: pointer;
    margin-right: 0.75rem;
    transition: background 0.2s;
}
.form-input[type="file"]::-webkit-file-upload-button:hover {
    background: #e2e8f0;
}

/* Disabled inputs should be invisible-feedback only */
input:disabled, select:disabled, textarea:disabled {
    background: #f9fafb;
    cursor: not-allowed;
}

/* Sticky stepper z-index */
.sticky.top-0.z-30 { z-index: 30; }
</style>

<script>
// =============================================================
// MEMBERSHIP FORM WIZARD ENGINE
// =============================================================
const TYPE_MAP = <?= json_encode($typeMap, JSON_UNESCAPED_UNICODE) ?>;
const SLUG_TO_FORM = {
    'honorary':       'form-honorary',
    'patron':         'form-patron',
    'institutional':  'form-institutional',
    'life':           'form-life',
    'life-senior':    'form-life-senior',
    'international':  'form-international',
    'student':        'form-student',
};
const STORAGE_KEY = 'rainbow_membership_draft_v2';
// Clean up any stale v1 draft (which contained csrf_token)
try { localStorage.removeItem('rainbow_membership_draft_v1'); } catch(e) {}

function formatCurrency(n, currency='INR') {
    if (!n || isNaN(n)) return currency === 'USD' ? '$0' : '₹0';
    if (currency === 'USD') return '$' + Math.round(n).toLocaleString('en-US');
    return '₹' + Math.round(n).toLocaleString('en-IN');
}

// ============== STEP NAVIGATION ==============
function goToStep(step) {
    const s1 = document.getElementById('step1');
    const s2 = document.getElementById('step2');
    const fill = document.getElementById('progressFill');
    const back = document.getElementById('backToStep1');
    const c2   = document.getElementById('step2Circle');
    const l2   = document.getElementById('step2Label');

    if (step === 1) {
        s1.classList.remove('hidden');
        s2.classList.add('hidden');
        fill.style.width = '0%';
        back.classList.add('hidden');
        c2.className = 'w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold bg-gray-200 text-gray-500';
        l2.className = 'text-sm font-semibold text-gray-400 hidden sm:inline';
    } else {
        s1.classList.add('hidden');
        s2.classList.remove('hidden');
        fill.style.width = '100%';
        back.classList.remove('hidden');
        c2.className = 'w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold text-white';
        c2.style.background = '#14919B';
        l2.className = 'text-sm font-semibold text-gray-800 hidden sm:inline';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

// ============== TYPE SELECTION ==============
function selectType(slug, id) {
    const type = TYPE_MAP[slug];
    if (!type) { alert('Invalid type'); return; }

    // CRITICAL: First DISABLE all inputs in every form panel.
    // This (a) prevents inactive panels' required fields from blocking submit,
    // and (b) keeps inactive panels' values out of FormData.
    document.querySelectorAll('.form-panel').forEach(p => {
        p.classList.add('hidden');
        p.querySelectorAll('input, select, textarea').forEach(el => { el.disabled = true; });
    });

    // Show the matching panel AND re-enable its inputs
    const panelId = SLUG_TO_FORM[slug];
    const panel = document.getElementById(panelId);
    if (panel) {
        panel.classList.remove('hidden');
        panel.querySelectorAll('input, select, textarea').forEach(el => { el.disabled = false; });
    }

    // Update hidden fields
    document.getElementById('hiddenTypeId').value = id;
    document.getElementById('hiddenTypeSlug').value = slug;
    document.getElementById('hiddenCurrency').value = type.currency;

    // Update banner with type-specific colors
    const COLOR_PALETTE = {
        purple: { bg: '#EEEDFE', border: '#CECBF6', text: '#3C3489', accent: '#534AB7' },
        blue:   { bg: '#E6F1FB', border: '#B5D4F4', text: '#0C447C', accent: '#185FA5' },
        amber:  { bg: '#FAEEDA', border: '#FAC775', text: '#854F0B', accent: '#BA7517' },
        green:  { bg: '#EAF3DE', border: '#C0DD97', text: '#27500A', accent: '#3B6D11' },
        pink:   { bg: '#FAECE7', border: '#F5C4B3', text: '#712B13', accent: '#993C1D' },
        teal:   { bg: '#E1F5EE', border: '#9FE1CB', text: '#085041', accent: '#0F6E56' },
        coral:  { bg: '#FBF0E6', border: '#FBBF8A', text: '#7C2D12', accent: '#C2410C' }
    };
    const c = COLOR_PALETTE[type.color] || { bg:'#F3F4F6', border:'#0F4C75', text:'#0F4C75', accent:'#0F4C75' };

    const banner = document.getElementById('selectedTypeBanner');
    const inner  = document.getElementById('selectedTypeBannerInner');
    const badge  = document.getElementById('selectedTypeBadge');
    const title  = document.getElementById('selectedTypeTitle');
    const fee    = document.getElementById('selectedTypeFee');

    banner.style.borderColor = c.border;
    inner.style.background   = c.bg;
    badge.style.background   = c.accent;
    badge.textContent        = type.title.charAt(0);
    title.style.color        = c.text;
    title.textContent        = type.title;
    fee.style.color          = c.accent;
    fee.textContent          = type.fee_label;

    // Show/hide agreement+submit AND fee sidebar based on type
    const isHonorary = slug === 'honorary';
    document.getElementById('agreementBox').classList.toggle('hidden', isHonorary);
    document.getElementById('feeSidebar').classList.toggle('hidden', isHonorary);
    document.getElementById('transactionBox').classList.toggle('hidden', isHonorary);

    // Calculate fees
    updateFees(type);

    // Advance to step 2
    goToStep(2);

    // Save draft of selected type
    saveDraft();
}

// ============== FEE CALCULATION ==============
function updateFees(type) {
    const fee = type.fee_num || 0;
    const currency = type.currency;

    // UI updates
    document.getElementById('sidebarTypeName').textContent = type.title;
    document.getElementById('sidebarFee').textContent   = formatCurrency(fee, currency);

    // Show validity for student
    const validity = document.getElementById('sidebarValidity');
    if (type.slug === 'student') {
        validity.textContent = 'Validity: 1 Year (renewable)';
        validity.classList.remove('hidden');
    } else {
        validity.classList.add('hidden');
    }

    // Hidden form field
    document.getElementById('hiddenFee').value = fee;
}

// ============== FILE PREVIEW ==============
document.addEventListener('change', function(e) {
    if (e.target.classList && e.target.classList.contains('photo-input')) {
        const previewId = e.target.dataset.preview;
        const file = e.target.files[0]; if (!file || !previewId) return;
        const reader = new FileReader();
        reader.onload = ev => {
            const img = document.getElementById(previewId);
            if (img) { img.src = ev.target.result; img.classList.remove('hidden'); }
        };
        reader.readAsDataURL(file);
    }
});

// ============== AUTO-SAVE DRAFT ==============
// Fields we MUST NOT persist in localStorage — they're regenerated server-side per session
// and would cause stale-token errors if restored from yesterday's draft.
const DRAFT_EXCLUDED_KEYS = new Set(['csrf_token', '_token', 'fee_amount', 'gst_amount', 'transaction_charges', 'total_amount']);

function saveDraft() {
    const form = document.getElementById('memberForm');
    if (!form) return;
    const data = {};
    new FormData(form).forEach((v, k) => {
        if (typeof v !== 'string') return;          // skip file objects
        if (DRAFT_EXCLUDED_KEYS.has(k)) return;     // skip session-bound fields
        data[k] = v;
    });
    try { localStorage.setItem(STORAGE_KEY, JSON.stringify(data)); } catch(e) {}
}
function loadDraft() {
    try {
        const raw = localStorage.getItem(STORAGE_KEY);
        if (!raw) return null;
        return JSON.parse(raw);
    } catch(e) { return null; }
}
function clearDraft() {
    try { localStorage.removeItem(STORAGE_KEY); } catch(e) {}
}
// Auto-save on any input change (debounced)
let saveTimer;
document.addEventListener('input', () => {
    clearTimeout(saveTimer);
    saveTimer = setTimeout(saveDraft, 600);
});

// Restore draft on page load
(function restoreDraft() {
    const draft = loadDraft();
    if (!draft) return;
    const slug = draft['membership_type_slug'];
    if (slug && TYPE_MAP[slug]) {
        selectType(slug, TYPE_MAP[slug].id);
        // Populate visible fields, but NEVER overwrite security tokens or computed fees
        setTimeout(() => {
            for (const [k, v] of Object.entries(draft)) {
                if (DRAFT_EXCLUDED_KEYS.has(k)) continue;
                const el = document.querySelector(`#memberForm [name="${CSS.escape(k)}"]`);
                if (el && el.type !== 'file' && el.type !== 'checkbox') el.value = v;
            }
        }, 100);
    }
})();

// ============== INITIALIZATION ==============
// On page load, disable inputs in all form panels so they don't interfere
// with HTML5 validation. They are re-enabled when the user selects a type.
(function initFormPanels() {
    document.querySelectorAll('.form-panel input, .form-panel select, .form-panel textarea').forEach(el => {
        el.disabled = true;
    });
})();

// ============== AJAX SUBMIT ==============
let isSubmitting = false;
document.getElementById('memberForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    // Prevent duplicate submissions
    if (isSubmitting) return;

    // Manual validation — make sure a type is selected
    const typeId = document.getElementById('hiddenTypeId').value;
    if (!typeId) {
        showToast('Please select a membership type first.', 'error');
        goToStep(1);
        return;
    }

    // Check the agreement checkbox
    const agreement = this.querySelector('[name="agreement"]');
    if (agreement && !agreement.checked) {
        showToast('Please accept the terms to proceed.', 'error');
        agreement.focus();
        return;
    }

    // Native HTML5 validation as final guard
    if (!this.checkValidity()) {
        this.reportValidity();
        return;
    }

    isSubmitting = true;
    const btn = document.getElementById('submitBtn');
    const orig = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting…';

    try {
        const res = await fetch('<?= BASE_URL ?>/membership/apply', {
            method: 'POST',
            body: new FormData(this),
            credentials: 'same-origin',
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });

        // Robust JSON parsing — server might return HTML on error
        const text = await res.text();
        let data;
        try { data = JSON.parse(text); }
        catch (e) {
            console.error('Non-JSON response:', text.substring(0, 500));
            throw new Error('Server returned an invalid response. Check console for details.');
        }

        if (!res.ok || !data.success) {
            showToast(data.message || ('Failed to submit (HTTP ' + res.status + ')'), 'error');
            isSubmitting = false;
            btn.disabled = false;
            btn.innerHTML = orig;
            return;
        }

        showToast(data.message || 'Application submitted!', 'success');
        if (data.warning) {
            setTimeout(() => showToast(data.warning, 'warning'), 1400);
        }
        clearDraft();
        // Hard-disable submit so user cannot double-submit during redirect
        btn.innerHTML = '<i class="fas fa-check"></i> Submitted';
        setTimeout(() => { window.location.href = '<?= BASE_URL ?>/membership/thank-you'; }, 1100);
    } catch (err) {
        console.error('Submit error:', err);
        showToast('Submission failed: ' + err.message, 'error');
        isSubmitting = false;
        btn.disabled = false;
        btn.innerHTML = orig;
    }
});

// ============== HONORARY FORM SUBMIT ==============
const honoraryForm = document.getElementById('honoraryForm');
if (honoraryForm) {
    let isHonoraryBusy = false;
    honoraryForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        if (isHonoraryBusy) return;

        const agreement = this.querySelector('[name="agreement"]');
        if (agreement && !agreement.checked) {
            showToast('Please accept the terms to proceed.', 'error');
            agreement.focus();
            return;
        }

        if (!this.checkValidity()) {
            this.reportValidity();
            return;
        }

        const just = this.querySelector('[name="fd[justification]"]');
        if (just && just.value.trim().length < 100) {
            showToast('Justification must be at least 100 characters.', 'error');
            just.focus();
            return;
        }

        isHonoraryBusy = true;
        const btn  = document.getElementById('honorarySubmitBtn');
        const orig = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting Nomination…';

        try {
            const res = await fetch('<?= BASE_URL ?>/membership/apply', {
                method: 'POST',
                body: new FormData(this),
                credentials: 'same-origin',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            });
            const text = await res.text();
            let data;
            try { data = JSON.parse(text); }
            catch (e) {
                console.error('Non-JSON response:', text.substring(0, 500));
                throw new Error('Server returned an invalid response.');
            }

            if (!res.ok || !data.success) {
                showToast(data.message || ('Failed (HTTP ' + res.status + ')'), 'error');
                isHonoraryBusy = false;
                btn.disabled = false;
                btn.innerHTML = orig;
                return;
            }

            showToast(data.message || 'Nomination submitted!', 'success');
            btn.innerHTML = '<i class="fas fa-check"></i> Submitted';
            setTimeout(() => { window.location.href = '<?= BASE_URL ?>/membership/thank-you'; }, 1100);
        } catch (err) {
            console.error('Honorary submit error:', err);
            showToast('Submission failed: ' + err.message, 'error');
            isHonoraryBusy = false;
            btn.disabled = false;
            btn.innerHTML = orig;
        }
    });
}

</script>
