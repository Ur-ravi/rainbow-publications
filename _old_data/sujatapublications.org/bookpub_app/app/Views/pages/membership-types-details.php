<?php
/**
 * Membership Types — Detailed view page
 * Shows the same card UI as membership-types.php, but clicking a card
 * opens a modal with full details instead of going to the application form.
 *
 * All 7 categories are defined inline below; admin can edit by modifying
 * the $categories array.
 */
$siteName = getSetting('site_name', 'Rainbow Publications');

// Color palette (same as membership-types.php)
$palette = [
    'purple' => ['bg' => '#EEEDFE', 'border' => '#CECBF6', 'text' => '#3C3489', 'accent' => '#534AB7'],
    'blue'   => ['bg' => '#E6F1FB', 'border' => '#B5D4F4', 'text' => '#0C447C', 'accent' => '#185FA5'],
    'amber'  => ['bg' => '#FAEEDA', 'border' => '#FAC775', 'text' => '#854F0B', 'accent' => '#BA7517'],
    'green'  => ['bg' => '#EAF3DE', 'border' => '#C0DD97', 'text' => '#27500A', 'accent' => '#3B6D11'],
    'pink'   => ['bg' => '#FAECE7', 'border' => '#F5C4B3', 'text' => '#712B13', 'accent' => '#993C1D'],
    'teal'   => ['bg' => '#E1F5EE', 'border' => '#9FE1CB', 'text' => '#085041', 'accent' => '#0F6E56'],
    'coral'  => ['bg' => '#FBF0E6', 'border' => '#FBBF8A', 'text' => '#7C2D12', 'accent' => '#C2410C'],
];

// Category data — order, title, fee label, color key, short eligibility, full content
$categories = [
    [
        'slug'     => 'honorary',
        'badge'    => 1,
        'title'    => 'Honorary Membership',
        'fee'      => 'By Nomination',
        'duration' => '',
        'color'    => 'purple',
        'short'    => 'Awarded to distinguished scientists for exceptional contributions.',
        'content'  => [
            'intro'   => 'Awarded to distinguished scientists, academicians, or professionals for their exceptional contributions to pharmaceutical and biomedical research.',
            'bullets' => [
                'Conferred by the Editorial or Advisory Board',
                'No application required (nomination-based)',
            ],
            'note'    => 'If you would like to nominate a member for this distinguished honor, please forward your nomination as well as supporting biographical data at info@rainbowpublications.org &amp; rainbowpublications@gmail.com.',
        ],
    ],
    [
        'slug'     => 'patron',
        'badge'    => 2,
        'title'    => 'Patron Membership',
        'fee'      => '₹19,999/-',
        'duration' => '',
        'color'    => 'blue',
        'short'    => 'For individuals or organizations contributing significantly to research activities.',
        'content'  => [
            'intro'   => 'Offered to individuals or organizations contributing significantly to the development and promotion of research activities.',
            'bullets' => [
                'Includes all membership privileges with special recognition status',
                'Ideal for senior professionals, industry leaders, and sponsors',
            ],
            'note'    => 'Patron memberships are typically granted to contributors supporting the organization financially or strategically.',
            'footer'  => '<strong>Membership Fees:</strong> 19,999/-',
        ],
    ],
    [
        'slug'     => 'institutional',
        'badge'    => 3,
        'title'    => 'Institutional Membership',
        'fee'      => '₹14,999/-',
        'duration' => '',
        'color'    => 'amber',
        'short'    => 'Open to universities, colleges, research institutes, and pharmaceutical industries.',
        'content'  => [
            'intro'   => 'Open to universities, colleges, research institutes, hospitals, and pharmaceutical industries.',
            'bullets' => [
                'Enables multiple representatives from the institution to participate',
                'Promotes institutional collaboration in research, publications, and conferences',
            ],
            'note'    => 'Institutions engaged in teaching, research, or pharmaceutical activities are eligible in similar organizations.',
            'footer'  => '<strong>Membership Fees:</strong> 14,999/-',
        ],
    ],
    [
        'slug'     => 'life',
        'badge'    => 4,
        'title'    => 'Life Membership',
        'fee'      => '₹499/-',
        'duration' => '',
        'color'    => 'green',
        'short'    => 'For qualified professionals with one-time registration and lifetime benefits.',
        'content'  => [
            'intro'   => 'Any person, other than Patron and Honorary Member, having one or more of the following qualifications and having attained the age of 21 years shall be eligible to be a Life Member of the Publisher. The Scientific Board Committee (SBC) has the discretion to reject any application without ascribing any reasons.',
            'bullets' => [
                'A person having a degree in pharmacy or graduation granted by a recognized University in India or abroad.',
                'A person possessing a diploma from a recognized University in India or abroad.',
                'A person who has a Bachelor\'s or higher degree in Basic, Life Sciences and / or applied Sciences conferred by a recognized University in India or abroad.',
                'Available to professionals, academicians, and researchers with relevant qualifications',
                'One-time registration with lifetime benefits and privileges',
                'Ideal for long-term association and academic growth',
            ],
            'note'    => 'Life membership typically provides continuous access to benefits and professional networks.',
            'footer'  => '<strong>Membership Fees:</strong> 499/-',
        ],
    ],
    [
        'slug'     => 'life-senior',
        'badge'    => 5,
        'title'    => 'Life Membership (Senior Category)',
        'fee'      => '₹399/-',
        'duration' => '',
        'color'    => 'pink',
        'short'    => 'For experienced professionals with special concessions and recognition.',
        'content'  => [
            'intro'   => 'Special category for experienced professionals (e.g., above 60–65 years).',
            'bullets' => [
                'Offers lifetime benefits with special concessions or recognition',
                'Honors senior contributors to the scientific community',
            ],
            'note'    => 'Senior membership categories are commonly included in professional societies.',
            'footer'  => '<strong>Membership Fees:</strong> 399/-',
        ],
    ],
    [
        'slug'     => 'international',
        'badge'    => 6,
        'title'    => 'International Membership',
        'fee'      => '50 USD',
        'duration' => '',
        'color'    => 'teal',
        'short'    => 'For researchers and professionals residing outside the country.',
        'content'  => [
            'intro'   => 'A person staying abroad and satisfying the qualifications of Membership as given below can become a Life Member of the Publisher. A Foreign Life Member shall enjoy all the privileges and shall be bound by the Rules and Regulations, Bye-laws of the Society in respect of a Foreign Life Member. The Scientific Board Committee (SBC) has the discretion to reject any application without ascribing any reasons.',
            'bullets' => [
                'A person having a degree in pharmacy or graduation granted by a recognized University in India or abroad.',
                'A person possessing a diploma from a recognized University in India or abroad.',
                'A person who has a Bachelor\'s or higher degree in Basic, Life Sciences and / or applied Sciences conferred by a recognized University in India or abroad.',
                'Life member shall enjoy all the privileges of a member during his / her lifetime.',
                'Designed for researchers and professionals residing outside the country.',
                'Provides access to global collaboration, international publications, and events.',
                'Strengthens international academic networking.',
            ],
            'note'    => 'Global membership models help expand international research collaboration.',
            'footer'  => '<strong>Membership Fees:</strong> 50 USD',
        ],
    ],
    [
        'slug'     => 'student',
        'badge'    => 7,
        'title'    => 'Student Membership',
        'fee'      => '₹299/-',
        'duration' => '',
        'color'    => 'coral',
        'short'    => 'For undergraduate, postgraduate, and doctoral students with reduced fees.',
        'content'  => [
            'intro'   => 'Open to undergraduate, postgraduate, and doctoral students in relevant fields.',
            'bullets' => [
                'Valid for a limited period: 1 Year Only (renewable or upgradable to life membership)',
                'Offers reduced fees and exclusive academic support',
            ],
            'note'    => 'Student memberships are designed to support early-career researchers and future scientists.',
            'footer'  => '<strong>Membership Fees:</strong> 299/-',
        ],
    ],
];
?>

<!-- ============ HERO ============ -->
<?php
$pageTitle = 'Types of Membership';
$heroIntro = 'Rainbow Publications offers a range of membership categories to accommodate students, researchers, academicians, and institutions, ensuring inclusivity and professional growth across all levels of the scientific community.';
include __DIR__ . '/../partials/hero.php';
?>

<!-- ============ CARDS GRID ============ -->
<section class="py-12 md:py-16" style="background:#F8FAFC;">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="text-center mb-10">
            <h2 class="font-modern text-2xl md:text-3xl font-extrabold text-gray-800 mb-2">Explore Our Membership Categories</h2>
            <p class="text-gray-500 text-sm">Click any card to view full details, eligibility, and benefits.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <?php foreach ($categories as $cat):
                $c = $palette[$cat['color']] ?? $palette['purple'];
            ?>
            <button type="button"
                    onclick="openDetails('<?= htmlspecialchars($cat['slug']) ?>')"
                    class="type-card group text-left rounded-2xl overflow-hidden border-2 transition-all duration-300 hover:shadow-xl hover:-translate-y-1 cursor-pointer"
                    style="background: <?= $c['bg'] ?>; border-color: <?= $c['border'] ?>;">
                <div class="px-5 py-4" style="background: <?= $c['border'] ?>;">
                    <div class="flex items-center gap-3">
                        <span class="w-10 h-10 rounded-full flex items-center justify-center font-extrabold text-white shadow-md flex-shrink-0" style="background: <?= $c['accent'] ?>;">
                            <?= (int)$cat['badge'] ?>
                        </span>
                        <h3 class="font-bold text-base leading-tight" style="color: <?= $c['text'] ?>;">
                            <?= htmlspecialchars($cat['title']) ?>
                        </h3>
                    </div>
                </div>
                <div class="p-5">
                    <div class="text-xl font-extrabold mb-2" style="color: <?= $c['text'] ?>;">
                        <?= htmlspecialchars($cat['fee']) ?>
                    </div>
                    <p class="text-xs text-gray-600 leading-relaxed line-clamp-2"><?= htmlspecialchars($cat['short']) ?></p>
                    <div class="mt-4 pt-3 border-t border-black/5 flex items-center justify-between">
                        <span class="text-xs uppercase tracking-wider font-semibold" style="color: <?= $c['accent'] ?>;">
                            <?= htmlspecialchars($cat['duration']) ?>
                        </span>
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold transition" style="color: <?= $c['accent'] ?>;">
                            View Details <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </span>
                    </div>
                </div>
            </button>
            <?php endforeach; ?>
        </div>

        <h3 class="text-lg md:text-xl mt-10 text-gray-700"><strong>Note:</strong> The Scientific Board Committee (SBC) has the discretion to reject any application without ascribing any reasons.</h3>

        <div class="mt-8 p-6 rounded-2xl bg-white border border-gray-100 shadow-sm">
            <h3 class="text-xl font-bold text-gray-800 mb-2">Choose the Right Membership</h3>
            <p class="text-gray-500 text-sm leading-relaxed">
                Whether you are a student, researcher, academician, or institution, Rainbow Publications provides a suitable membership category to support your professional journey and research aspirations.
            </p>
        </div>
    </div>
</section>

<!-- ============ DETAILS MODAL ============ -->
<div id="detailsModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(15,23,42,0.65); backdrop-filter: blur(4px);">
    <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col" onclick="event.stopPropagation()">
        <div id="modalHeader" class="px-6 py-5 flex items-center justify-between gap-4" style="background:#0F4C75;">
            <div class="flex items-center gap-3 min-w-0">
                <span id="modalBadge" class="w-12 h-12 rounded-full flex items-center justify-center text-white font-extrabold text-lg shadow-md flex-shrink-0" style="background:#534AB7;">1</span>
                <div class="min-w-0">
                    <p class="text-xs uppercase tracking-wider font-semibold text-white/70">Membership Category</p>
                    <h2 id="modalTitle" class="font-bold text-lg text-white leading-tight truncate">—</h2>
                </div>
            </div>
            <button type="button" onclick="closeDetails()" class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition flex-shrink-0" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="overflow-y-auto p-6 md:p-8 space-y-5 flex-1">
            <div class="flex items-center gap-3 flex-wrap">
                <span id="modalFee" class="inline-block px-3 py-1 rounded-full text-sm font-extrabold" style="background:#EEEDFE; color:#3C3489;">—</span>
                <span id="modalDuration" class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-gray-100 text-gray-700">—</span>
            </div>

            <p id="modalIntro" class="text-gray-700 leading-relaxed"></p>

            <ul id="modalBullets" class="space-y-2.5 text-gray-700"></ul>

            <p id="modalNote" class="text-gray-500 italic border-l-4 pl-4" style="border-color:#14919B;"></p>

            <p id="modalFooter" class="text-gray-800 font-semibold"></p>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-wrap items-center justify-between gap-3">
            <a href="<?= BASE_URL ?>/membership/types" class="text-sm font-semibold text-primary hover:text-secondary inline-flex items-center gap-2">
                <i class="fas fa-arrow-right text-xs"></i> Apply for this category
            </a>
            <button type="button" onclick="closeDetails()" class="px-5 py-2 rounded-xl bg-gray-200 text-gray-700 font-semibold text-sm hover:bg-gray-300 transition">Close</button>
        </div>
    </div>
</div>

<!-- ============ MODAL DATA (passed via JSON for safe rendering) ============ -->
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

function openDetails(slug){
    const cat = (window.__membershipDetails || []).find(c => c.slug === slug);
    if (!cat) return;
    const palette = cat.palette || {};

    const modal = document.getElementById('detailsModal');
    const header = document.getElementById('modalHeader');
    const badge  = document.getElementById('modalBadge');
    const title  = document.getElementById('modalTitle');
    const fee    = document.getElementById('modalFee');
    const dur    = document.getElementById('modalDuration');
    const intro  = document.getElementById('modalIntro');
    const ul     = document.getElementById('modalBullets');
    const note   = document.getElementById('modalNote');
    const footer = document.getElementById('modalFooter');

    header.style.background = palette.accent || '#0F4C75';
    badge.style.background  = palette.accent || '#534AB7';
    badge.textContent       = String(cat.badge);
    title.textContent       = cat.title;
    fee.textContent         = cat.fee;
    fee.style.background    = palette.bg     || '#EEEDFE';
    fee.style.color         = palette.text   || '#3C3489';
    dur.textContent         = cat.duration;
    intro.textContent       = cat.content.intro || '';

    ul.innerHTML = '';
    (cat.content.bullets || []).forEach(function(b){
        const li = document.createElement('li');
        li.className = 'flex items-start gap-2.5';
        li.innerHTML = '<i class="fas fa-check-circle text-sm flex-shrink-0 mt-0.5" style="color:' + (palette.accent || '#0F4C75') + ';"></i><span>' + escapeHtml(b) + '</span>';
        ul.appendChild(li);
    });

    if (cat.content.note) {
        note.style.display = '';
        note.textContent   = cat.content.note;
    } else {
        note.style.display = 'none';
    }

    if (cat.content.footer) {
        footer.style.display = '';
        footer.innerHTML     = cat.content.footer;
    } else {
        footer.style.display = 'none';
    }

    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDetails(){
    document.getElementById('detailsModal').classList.add('hidden');
    document.body.style.overflow = '';
}

// Close on backdrop click
document.getElementById('detailsModal').addEventListener('click', function(e){
    if (e.target === this) closeDetails();
});

// Close on ESC
document.addEventListener('keydown', function(e){
    if (e.key === 'Escape') closeDetails();
});

function escapeHtml(s){
    return String(s)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}
</script>
