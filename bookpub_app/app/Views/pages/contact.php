<?php
$pageTitle = 'Contact Us';
?>

<!-- Page Hero -->


<section class="page-hero">

    <div class="hero-mesh"></div>

    <div class="hero-orbs">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <div class="container mx-auto px-4 py-20 relative z-10">
        <div class="max-w-3xl" data-reveal>

            <nav class="flex items-center gap-2 text-sm mb-5">
                <a href="<?= BASE_URL ?>" class="breadcrumb-link">
                    Home
                </a>

                <i class="fas fa-angle-right text-xs breadcrumb-sep"></i>

                <span class="breadcrumb-current">
                    Contact Us
                </span>
            </nav>


            <h1 class="hero-title">
                <span class="hero-title-line">
                    Get In Touch
                </span>
            </h1>


            <div class="hero-divider"></div>


            <p class="hero-subtitle">
                We'd love to hear from you. Send us a message and we'll respond as soon as possible.
            </p>


        </div>
    </div>


    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 70" class="w-full h-10 md:h-16" preserveAspectRatio="none">
            <path fill="var(--slate-50)" d="M0,35 C360,80 720,0 1080,25 C1260,38 1380,48 1440,44 L1440,70 L0,70 Z"/>
        </svg>
    </div>

</section>

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="grid lg:grid-cols-3 gap-12">

            <!-- Contact Info -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-md p-8 mb-6">
                    <h3 class="font-serif text-xl font-bold text-primary mb-6">Contact Information</h3>
                    <?php
                    $infos = [
                        ['fas fa-map-marker-alt','Address', getSetting('site_address','Your Address Here')],
                        ['fas fa-phone','Phone', getSetting('site_phone','+91 XXXXXXXXXX')],
                        ['fas fa-envelope','Email', getSetting('site_email','info@example.com')],
                        ['fas fa-clock','Office Hours', getSetting('business_hours','Mon–Sat: 9:00 AM – 6:00 PM')],
                    ];
                    foreach($infos as [$icon, $label, $val]): if(!$val) continue;
                    ?>
                    <div class="contact-info-item flex gap-3 mb-4">
                        <div class="contact-icon">
                            <i class="<?= $icon ?>"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-0.5"><?= $label ?></p>
                            <p class="text-gray-800 font-medium text-sm"><?= nl2br(htmlspecialchars($val)) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Social Links -->
                <div class="bg-primary rounded-2xl p-6 text-white">
                    <h4 class="font-serif font-bold mb-4">Follow Us</h4>
                    <div class="flex gap-3 flex-wrap">
                        <?php
                        $socials = [
                            'facebook'  => ['fab fa-facebook-f', getSetting('facebook_url','')],
                            'twitter'   => ['fab fa-x-twitter',  getSetting('twitter_url','')],
                            'linkedin'  => ['fab fa-linkedin-in',getSetting('linkedin_url','')],
                            'instagram' => ['fab fa-instagram',  getSetting('instagram_url','')],
                            'youtube'   => ['fab fa-youtube',    getSetting('youtube_url','')],
                        ];
                        foreach($socials as $key => [$icon, $url]):
                            if(!$url) continue;
                        ?>
                        <a href="<?= htmlspecialchars($url) ?>" target="_blank" rel="noopener"
                           class="social-btn">
                            <i class="<?= $icon ?>"></i>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-md p-8">
                    <h3 class="font-serif text-xl font-bold text-primary mb-6">Send Us a Message</h3>

                    <form id="contactForm">
                        <?= Security::csrfField() ?>
                        <input type="text" name="honeypot" class="hidden" tabindex="-1" autocomplete="off">

                        <?php $subject = htmlspecialchars($_GET['subject'] ?? ''); ?>

                        <div class="grid sm:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="form-label">Full Name <span class="text-secondary">*</span></label>
                                <input type="text" name="name" required class="form-input" placeholder="Dr. John Smith">
                            </div>
                            <div>
                                <label class="form-label">Email Address <span class="text-secondary">*</span></label>
                                <input type="email" name="email" required class="form-input" placeholder="john@university.edu">
                            </div>
                        </div>
                        <div class="grid sm:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="form-label">Phone Number</label>
                                <input type="tel" name="phone" class="form-input" placeholder="+91 XXXXXXXXXX">
                            </div>
                            <div>
                                <label class="form-label">Subject <span class="text-secondary">*</span></label>
                                <input type="text" name="subject" required class="form-input" value="<?= $subject ?>" placeholder="e.g., Book Publication Enquiry">
                            </div>
                        </div>
                        <div class="mb-5">
                            <label class="form-label">Service of Interest</label>
                            <select name="service" id="serviceSelect" class="form-input" onchange="toggleOtherService(this.value)">
                                <option value="">— Select Service —</option>
                                <?php foreach($services ?? [] as $s): ?>
                                <option value="<?= htmlspecialchars($s['title']) ?>"><?= htmlspecialchars($s['title']) ?></option>
                                <?php endforeach; ?>
                                <option value="Other">Other (please specify)</option>
                            </select>
                            <div id="serviceOtherWrap" class="mt-3 hidden">
                                <input type="text" name="service_other" id="serviceOther"
                                       class="form-input" placeholder="Please specify your service of interest">
                            </div>
                        </div>
                        <div class="mb-6">
                            <label class="form-label">Your Message <span class="text-secondary">*</span></label>
                            <textarea name="message" rows="5" required class="form-input resize-none"
                                      placeholder="Please describe your inquiry in detail…"></textarea>
                        </div>

                        <button type="submit" id="submitBtn"
                                class="btn-primary w-full justify-center text-base">
                            <span id="btnText"><i class="fas fa-paper-plane mr-2"></i>Send Message</span>
                            <span id="btnLoading" class="hidden"><i class="fas fa-spinner fa-spin mr-2"></i>Sending…</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Map -->
        <?php $mapEmbed = getSetting('google_map_embed',''); if($mapEmbed): ?>
        <div class="mt-12">
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="font-serif font-bold text-primary text-xl">
                        <i class="fas fa-map-marker-alt text-secondary mr-2"></i>Our Location
                    </h3>
                </div>
                <div class="h-80">
                    <?= $mapEmbed ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<script>
function toggleOtherService(val) {
    document.getElementById('serviceOtherWrap').classList.toggle('hidden', val !== 'Other');
    if (val !== 'Other') document.getElementById('serviceOther').value = '';
}

document.getElementById('contactForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn  = document.getElementById('submitBtn');
    const text = document.getElementById('btnText');
    const load = document.getElementById('btnLoading');

    text.classList.add('hidden');
    load.classList.remove('hidden');
    btn.disabled = true;

    try {
        const res  = await fetch('<?= BASE_URL ?>/contact/send', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            method: 'POST',
            body:   new FormData(this)
        });
        const data = await res.json();
        showToast(data.message, data.success ? 'success' : 'error');
        if (data.success) this.reset();
    } catch(err) {
        showToast('Something went wrong. Please try again.', 'error');
    }

    text.classList.remove('hidden');
    load.classList.add('hidden');
    btn.disabled = false;
});
</script>

<?php
