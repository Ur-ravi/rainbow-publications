<?php
/**
 * Membership Types — Executive UI View Page
 * Professional, clean card interface with an architectural modal presentation.
 */
$siteName = getSetting('site_name', 'Rainbow Publications');

// Premium Palette — Neutral Slate base with refined, low-saturation accent tones
$palette = [
    'purple' => [
        'bg'          => '#FAF5FF',
        'border'      => '#E9D5FF',
        'text'        => '#581C87',
        'accent'      => '#7E22CE',
        'badge'       => '#F3E8FF',
    ],
    'blue' => [
        'bg'          => '#F0F9FF',
        'border'      => '#BAE6FD',
        'text'        => '#0C4A6E',
        'accent'      => '#0284C7',
        'badge'       => '#E0F2FE',
    ],
    'amber' => [
        'bg'          => '#FFFBEB',
        'border'      => '#FDE68A',
        'text'        => '#78350F',
        'accent'      => '#D97706',
        'badge'       => '#FEF3C7',
    ],
    'green' => [
        'bg'          => '#F0FDF4',
        'border'      => '#BBF7D0',
        'text'        => '#14532D',
        'accent'      => '#15803D',
        'badge'       => '#DCFCE7',
    ],
    'pink' => [
        'bg'          => '#FDF2F8',
        'border'      => '#FBCFE8',
        'text'        => '#831843',
        'accent'      => '#BE185D',
        'badge'       => '#FCE7F3',
    ],
    'teal' => [
        'bg'          => '#F0FDFA',
        'border'      => '#99F6E4',
        'text'        => '#134E4A',
        'accent'      => '#0F766E',
        'badge'       => '#CCFBF1',
    ],
    'coral' => [
        'bg'          => '#FFF1F2',
        'border'      => '#FECDD3',
        'text'        => '#881337',
        'accent'      => '#BE123C',
        'badge'       => '#FFE4E6',
    ],
];

// Category Data
$categories = [
    [
        'slug'     => 'honorary',
        'badge'    => 1,
        'title'    => 'Honorary Membership',
        'fee'      => 'By Nomination',
        'duration' => 'Lifetime',
        'color'    => 'purple',
        'short'    => 'Awarded to distinguished scientists for exceptional research contributions.',
        'content'  => [
            'intro'   => 'Awarded to distinguished scientists, academicians, or professionals for their exceptional contributions to pharmaceutical and biomedical research.',
            'bullets' => [
                'Conferred by the Editorial or Advisory Board',
                'No application required (nomination-based)',
            ],
            'note'    => 'If you would like to nominate a member for this distinguished honor, please forward your nomination as well as supporting biographical data at info@rainbowpublications.org & rainbowpublications@gmail.com.',
        ],
    ],
    [
        'slug'     => 'patron',
        'badge'    => 2,
        'title'    => 'Patron Membership',
        'fee'      => '₹19,999/-',
        'duration' => 'Lifetime Privilege',
        'color'    => 'blue',
        'short'    => 'For individuals or organizations contributing significantly to strategic research activities.',
        'content'  => [
            'intro'   => 'Offered to individuals or organizations contributing significantly to the development and promotion of research activities.',
            'bullets' => [
                'Includes all membership privileges with special recognition status',
                'Ideal for senior professionals, industry leaders, and sponsors',
            ],
            'note'    => 'Patron memberships are typically granted to contributors supporting the organization financially or strategically.',
            'footer'  => '<strong>Membership Fees:</strong> ₹19,999/-',
        ],
    ],
    [
        'slug'     => 'institutional',
        'badge'    => 3,
        'title'    => 'Institutional Membership',
        'fee'      => '₹14,999/-',
        'duration' => 'Institutional Access',
        'color'    => 'amber',
        'short'    => 'Open to universities, colleges, research institutes, and pharmaceutical industries.',
        'content'  => [
            'intro'   => 'Open to universities, colleges, research institutes, hospitals, and pharmaceutical industries.',
            'bullets' => [
                'Enables multiple representatives from the institution to participate',
                'Promotes institutional collaboration in research, publications, and conferences',
            ],
            'note'    => 'Institutions engaged in teaching, research, or pharmaceutical activities are eligible in similar organizations.',
            'footer'  => '<strong>Membership Fees:</strong> ₹14,999/-',
        ],
    ],
    [
        'slug'     => 'life',
        'badge'    => 4,
        'title'    => 'Life Membership',
        'fee'      => '₹499/-',
        'duration' => 'Lifetime Access',
        'color'    => 'green',
        'short'    => 'For qualified professionals seeking one-time registration with long-term benefits.',
        'content'  => [
            'intro'   => 'Any person, other than Patron and Honorary Member, having one or more of the following qualifications and having attained the age of 21 years shall be eligible to be a Life Member of the Publisher. The Scientific Board Committee (SBC) has the discretion to reject any application without ascribing any reasons.',
            'bullets' => [
                'A person possessing a degree in pharmacy or graduation granted by a recognized University in India or abroad.',
                'A person possessing a diploma from a recognized University in India or abroad.',
                'A person who has a Bachelor\'s or higher degree in Basic, Life Sciences and / or applied Sciences conferred by a recognized University.',
                'Available to professionals, academicians, and researchers with relevant qualifications',
                'One-time registration with lifetime benefits and privileges',
                'Ideal for long-term association and academic growth',
            ],
            'note'    => 'Life membership typically provides continuous access to benefits and professional networks.',
            'footer'  => '<strong>Membership Fees:</strong> ₹499/-',
        ],
    ],
    [
        'slug'     => 'life-senior',
        'badge'    => 5,
        'title'    => 'Senior Life Membership',
        'fee'      => '₹399/-',
        'duration' => 'Lifetime Access',
        'color'    => 'pink',
        'short'    => 'Special category for experienced senior professionals with honored privileges.',
        'content'  => [
            'intro'   => 'Special category for experienced professionals (e.g., above 60–65 years).',
            'bullets' => [
                'Offers lifetime benefits with special concessions or recognition',
                'Honors senior contributors to the scientific community',
            ],
            'note'    => 'Senior membership categories are commonly included in professional societies.',
            'footer'  => '<strong>Membership Fees:</strong> ₹399/-',
        ],
    ],
    [
        'slug'     => 'international',
        'badge'    => 6,
        'title'    => 'International Membership',
        'fee'      => '$50 USD',
        'duration' => 'Lifetime Access',
        'color'    => 'teal',
        'short'    => 'Designed for global researchers and professionals residing outside India.',
        'content'  => [
            'intro'   => 'A person staying abroad and satisfying the qualifications of Membership as given below can become a Life Member of the Publisher. A Foreign Life Member shall enjoy all the privileges and shall be bound by the Rules and Regulations, Bye-laws of the Society in respect of a Foreign Life Member. The Scientific Board Committee (SBC) has the discretion to reject any application without ascribing any reasons.',
            'bullets' => [
                'A person possessing a degree in pharmacy or graduation granted by a recognized University.',
                'A person possessing a diploma from a recognized University.',
                'A person who has a Bachelor\'s or higher degree in Basic, Life Sciences and / or applied Sciences.',
                'Life member shall enjoy all the privileges of a member during his / her lifetime.',
                'Designed for researchers and professionals residing outside the country.',
                'Provides access to global collaboration, international publications, and events.',
            ],
            'note'    => 'Global membership models help expand international research collaboration.',
            'footer'  => '<strong>Membership Fees:</strong> $50 USD',
        ],
    ],
    [
        'slug'     => 'student',
        'badge'    => 7,
        'title'    => 'Student Membership',
        'fee'      => '₹299/-',
        'duration' => '1 Year Term',
        'color'    => 'coral',
        'short'    => 'For undergraduate, postgraduate, and doctoral students with academic support.',
        'content'  => [
            'intro'   => 'Open to undergraduate, postgraduate, and doctoral students in relevant fields.',
            'bullets' => [
                'Valid for a limited period: 1 Year Only (renewable or upgradable to life membership)',
                'Offers reduced fees and exclusive academic support',
            ],
            'note'    => 'Student memberships are designed to support early-career researchers and future scientists.',
            'footer'  => '<strong>Membership Fees:</strong> ₹299/-',
        ],
    ],
];
?>

<!-- ============ HERO SECTION ============ -->
<?php
$pageTitle = 'Types of Membership';
$heroIntro = 'Rainbow Publications offers structured membership tiers tailored to support students, individual researchers, academic faculties, and institutional partners in expanding their academic presence.';
include __DIR__ . '/../partials/hero.php';
?>

<!-- ============ CARDS GRID SECTION ============ -->
<section class="py-20 bg-slate-50">
    <div class="container mx-auto px-4 max-w-7xl">
        
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 pb-6 border-b border-slate-200 gap-4">
            <div>
                <span class="text-xs font-semibold uppercase tracking-widest text-slate-500 mb-2 block">Membership Programs</span>
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">Select a Membership Tier</h2>
            </div>
            <p class="text-slate-500 text-sm max-w-md">
                Click any plan to review comprehensive eligibility criteria, privileges, and nomination details.
            </p>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($categories as $cat):
                $c = $palette[$cat['color']] ?? $palette['purple'];
            ?>
            <div class="group relative bg-white rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-xl hover:border-slate-300 transition-all duration-300 flex flex-col justify-between overflow-hidden">
                
                <!-- Inner Content Container -->
                <div class="p-7">
                    <!-- Card Top Info -->
                    <div class="flex items-center justify-between gap-3 mb-6">
                        <span class="inline-flex items-center justify-center text-xs font-semibold px-2.5 py-1 rounded-md" style="background-color: <?= $c['badge'] ?>; color: <?= $c['text'] ?>;">
                            0<?= (int)$cat['badge'] ?>
                        </span>
                        <?php if(!empty($cat['duration'])): ?>
                            <span class="text-[11px] font-medium tracking-wide uppercase text-slate-400">
                                <?= htmlspecialchars($cat['duration']) ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Title & Pricing -->
                    <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-indigo-600 transition-colors">
                        <?= htmlspecialchars($cat['title']) ?>
                    </h3>
                    
                    <div class="text-2xl font-extrabold text-slate-900 tracking-tight mb-4">
                        <?= htmlspecialchars($cat['fee']) ?>
                    </div>

                    <p class="text-slate-600 text-xs md:text-sm leading-relaxed line-clamp-3 mb-6">
                        <?= htmlspecialchars($cat['short']) ?>
                    </p>
                </div>

                <!-- Card Footer Action -->
                <div class="px-7 py-4 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between">
                    <button type="button"
                            onclick="openDetails('<?= htmlspecialchars($cat['slug']) ?>')"
                            class="w-full text-xs font-semibold text-slate-700 hover:text-indigo-600 inline-flex items-center justify-between gap-2 transition-colors focus:outline-none">
                        <span>View Details</span>
                        <i class="fas fa-arrow-right text-[10px] text-slate-400 group-hover:text-indigo-600 group-hover:translate-x-1 transition-all"></i>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Information Notice -->
        <div class="mt-12 p-6 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-start gap-4 text-slate-700">
            <div class="w-8 h-8 rounded-lg bg-blue-50 border border-blue-200 text-blue-700 flex items-center justify-center flex-shrink-0 mt-0.5">
                <i class="fas fa-info text-xs"></i>
            </div>
            <div class="text-xs md:text-sm leading-relaxed">
                <strong class="font-semibold text-slate-900">Application Review Policy:</strong>
                <span class="text-slate-600"> The Scientific Board Committee (SBC) retains full editorial discretion to evaluate and approve or decline any membership application in accordance with the journal governance policies.</span>
            </div>
        </div>

    </div>
</section>

<!-- ============ DETAILS MODAL ============ -->
<div id="detailsModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6" role="dialog" aria-modal="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" onclick="closeDetails()"></div>

    <!-- Modal Box -->
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[85vh] overflow-hidden flex flex-col relative z-10 border border-slate-200 transition-all" onclick="event.stopPropagation()">
        
        <!-- Header -->
        <div id="modalHeader" class="px-6 py-5 flex items-center justify-between border-b border-slate-100 bg-white">
            <div class="flex items-center gap-3">
                <span id="modalBadge" class="w-8 h-8 rounded-md flex items-center justify-center text-xs font-bold text-slate-700 bg-slate-100">
                    01
                </span>
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-wider text-slate-400 block">Category Specification</span>
                    <h2 id="modalTitle" class="font-bold text-base md:text-lg text-slate-900 leading-none">—</h2>
                </div>
            </div>
            <button type="button" onclick="closeDetails()" class="w-8 h-8 rounded-md hover:bg-slate-100 text-slate-400 hover:text-slate-600 flex items-center justify-center transition focus:outline-none">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>

        <!-- Body -->
        <div class="overflow-y-auto p-6 md:p-8 space-y-6 flex-1 text-slate-700 text-xs md:text-sm">
            
            <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                <div>
                    <span class="text-[11px] text-slate-400 block font-medium">Fee Structure</span>
                    <span id="modalFee" class="text-base font-extrabold text-slate-900">—</span>
                </div>
                <div class="h-8 w-px bg-slate-200 mx-2"></div>
                <div>
                    <span class="text-[11px] text-slate-400 block font-medium">Validity Period</span>
                    <span id="modalDuration" class="text-xs font-semibold text-slate-700">—</span>
                </div>
            </div>

            <div>
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-2">Description</h4>
                <p id="modalIntro" class="text-slate-600 leading-relaxed font-normal"></p>
            </div>

            <div>
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-3">Key Features & Conditions</h4>
                <ul id="modalBullets" class="space-y-2.5 text-slate-600"></ul>
            </div>

            <div id="modalNoteContainer" class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                <span class="text-[11px] font-bold uppercase text-slate-500 block mb-1">Notice</span>
                <p id="modalNote" class="text-xs text-slate-600 leading-relaxed"></p>
            </div>

            <p id="modalFooter" class="text-slate-900 font-semibold border-t border-slate-100 pt-3"></p>
        </div>

        <!-- Footer Actions -->
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200/80 flex items-center justify-end gap-3">
            <button type="button" onclick="closeDetails()" class="px-4 py-2 rounded-lg bg-white border border-slate-300 text-slate-700 font-medium text-xs hover:bg-slate-100 transition">
                Close
            </button>
            <a href="<?= BASE_URL ?>/membership/types" class="px-4 py-2 rounded-lg bg-slate-900 hover:bg-slate-800 text-white font-medium text-xs inline-flex items-center gap-2 shadow-sm transition">
                <span>Apply Now</span>
                <i class="fas fa-chevron-right text-[10px]"></i>
            </a>
        </div>
    </div>
</div>

<!-- ============ MODAL DATA & CONTROLLER ============ -->
<script>
window.__membershipDetails = <?= json_encode(array_map(function($c) use ($palette){
    $p = $palette[$c['color']] ?? $palette['purple'];
    return [
        'slug'     => $c['slug'],
        'badge'    => (int)$c['badge'],
        'title'    => $c['title'],
        'fee'      => $c['fee'],
        'duration' => $c['duration'],
        'color'    => $c['color'],
        'palette'  => $p,
        'content'  => $c['content'],
    ];
}, $categories), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

function openDetails(slug) {
    const cat = (window.__membershipDetails || []).find(c => c.slug === slug);
    if (!cat) return;

    const modal    = document.getElementById('detailsModal');
    const badge    = document.getElementById('modalBadge');
    const title    = document.getElementById('modalTitle');
    const fee      = document.getElementById('modalFee');
    const dur      = document.getElementById('modalDuration');
    const intro    = document.getElementById('modalIntro');
    const ul       = document.getElementById('modalBullets');
    const note     = document.getElementById('modalNote');
    const noteCont = document.getElementById('modalNoteContainer');
    const footer   = document.getElementById('modalFooter');

    badge.textContent  = '0' + String(cat.badge);
    title.textContent  = cat.title;
    fee.textContent    = cat.fee;
    dur.textContent    = cat.duration || 'Standard';
    intro.textContent  = cat.content.intro || '';

    ul.innerHTML = '';
    (cat.content.bullets || []).forEach(function(b) {
        const li = document.createElement('li');
        li.className = 'flex items-start gap-2.5';
        li.innerHTML = '<i class="fas fa-check text-indigo-600 text-xs flex-shrink-0 mt-1"></i><span class="leading-relaxed">' + escapeHtml(b) + '</span>';
        ul.appendChild(li);
    });

    if (cat.content.note) {
        noteCont.style.display = 'block';
        note.textContent = cat.content.note;
    } else {
        noteCont.style.display = 'none';
    }

    if (cat.content.footer) {
        footer.style.display = 'block';
        footer.innerHTML = cat.content.footer;
    } else {
        footer.style.display = 'none';
    }

    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDetails() {
    document.getElementById('detailsModal').classList.add('hidden');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDetails();
});

function escapeHtml(s) {
    return String(s)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}
</script>