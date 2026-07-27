<?php
$pageTitle = 'About Us';
?>
<!-- Page Hero -->
<section class="page-hero">
    <div class="hero-mesh"></div>
    <div class="hero-orbs">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>
    <div class="container mx-auto px-4 py-24 relative z-10">
        <div class="max-w-3xl" data-reveal>
            <nav class="flex items-center gap-2 text-sm mb-5">
                <a href="<?= BASE_URL ?>" class="breadcrumb-link">Home</a>
                <i class="fas fa-angle-right text-xs breadcrumb-sep"></i>
                <span class="breadcrumb-current"><?= htmlspecialchars($pageTitle) ?></span>
            </nav>
            <h1 class="hero-title">
                <span class="hero-title-line"><?= htmlspecialchars($pageTitle) ?></span>
            </h1>
            <div class="hero-divider"></div>
            <p class="hero-subtitle">Leading the future of academic publishing through innovation, integrity, and inclusive knowledge sharing.</p>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0 leading-none">
        <svg viewBox="0 0 1440 70" class="w-full h-10 md:h-16" preserveAspectRatio="none"><path fill="var(--slate-50)" d="M0,35 C360,80 720,0 1080,25 C1260,38 1380,48 1440,44 L1440,70 L0,70 Z"/></svg>
    </div>
</section>

<!-- About Rainbow Publications -->
<section class="section-about" id="about-us">
    <div class="section-wave-top"></div>
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="text-center mb-16" data-reveal>
            <div class="section-badge">
                <i class="fas fa-award"></i>
                <span>About Rainbow Publications</span>
            </div>
            <h2 class="heading-lg mt-5">Who We Are</h2>
            <div class="section-divider mt-4"></div>
            <p class="text-secondary max-w-3xl mx-auto mt-8 text-body leading-relaxed">
                Rainbow Publications is a leading academic publisher dedicated to supporting researchers, scholars, and authors in achieving their publication goals. We are committed to excellence in knowledge dissemination, author empowerment, academic integrity, innovation, and inclusion.
            </p>
        </div>
        <div class="grid lg:grid-cols-3 gap-6">
            <div class="value-card reveal">
                <div class="card-icon-wrap">
                    <div class="card-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                </div>
                <h3 class="font-serif text-primary-dark text-xl mb-3">Knowledge Dissemination</h3>
                <p class="text-secondary leading-relaxed">We provide a platform for sharing valuable research findings, innovative ideas, and insightful perspectives with a global audience.</p>
                <div class="card-accent-bar"></div>
            </div>
            <div class="value-card reveal delay-100">
                <div class="card-icon-wrap">
                    <div class="card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <h3 class="font-serif text-primary-dark text-xl mb-3">Author Empowerment</h3>
                <p class="text-secondary leading-relaxed">We offer a comprehensive range of services to guide authors through every stage of the publication journey, from concept development to final publication.</p>
                <div class="card-accent-bar"></div>
            </div>
            <div class="value-card reveal delay-200">
                <div class="card-icon-wrap">
                    <div class="card-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                </div>
                <h3 class="font-serif text-primary-dark text-xl mb-3">Academic Integrity</h3>
                <p class="text-secondary leading-relaxed">We uphold the highest standards of academic rigor and ethics through meticulous editorial processes and peer-review systems.</p>
                <div class="card-accent-bar"></div>
            </div>
            <div class="value-card reveal delay-100">
                <div class="card-icon-wrap">
                    <div class="card-icon">
                        <i class="fas fa-microchip"></i>
                    </div>
                </div>
                <h3 class="font-serif text-primary-dark text-xl mb-3">Innovation and Technology</h3>
                <p class="text-secondary leading-relaxed">We embrace advancements in technology to streamline the publication process, enhance accessibility of published materials, and deliver exceptional service to our clients.</p>
                <div class="card-accent-bar"></div>
            </div>
            <div class="value-card reveal delay-200">
                <div class="card-icon-wrap">
                    <div class="card-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                </div>
                <h3 class="font-serif text-primary-dark text-xl mb-3">Diversity and Inclusion</h3>
                <p class="text-secondary leading-relaxed">We champion diverse voices and perspectives across various academic disciplines.</p>
                <div class="card-accent-bar"></div>
            </div>
        </div>
    </div>
</section>

<section class="section-mission" id="mission-values">
    <div class="section-bg-pattern"></div>
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="grid lg:grid-cols-2 gap-8">
            <div class="mission-card reveal">
                <div class="card-badge">
                    <i class="fas fa-compass"></i>
                    <span>Our Mission</span>
                </div>
                <h2 class="heading-lg mt-5 mb-5">Bridging Research &amp; Impact</h2>
                <div class="card-divider"></div>
                <p class="text-secondary text-body leading-relaxed mt-5">
                    Rainbow Publications is driven by the mission to bridge the gap between cutting-edge research and practical application. We strive to facilitate the dissemination of impactful knowledge that shapes our understanding of the world and fosters positive change.
                </p>
                <div class="mission-stat-row mt-6">
                    <div class="mission-stat">
                        <span class="mission-stat-number">Global</span>
                        <span class="mission-stat-label">Reach</span>
                    </div>
                    <div class="mission-stat-divider"></div>
                    <div class="mission-stat">
                        <span class="mission-stat-number">100%</span>
                        <span class="mission-stat-label">Commitment</span>
                    </div>
                </div>
            </div>
            <div class="mission-card reveal delay-100">
                <div class="card-badge card-badge--alt">
                    <i class="fas fa-gem"></i>
                    <span>Our Values</span>
                </div>
                <h2 class="heading-lg mt-5 mb-5">What We Stand For</h2>
                <div class="card-divider"></div>
                <ul class="space-y-4 mt-5">
                    <li class="value-list-item"><span class="value-bullet"></span><span><strong class="text-primary">Integrity:</strong> <span class="text-secondary">We conduct our business with honesty, transparency, and ethical responsibility.</span></span></li>
                    <li class="value-list-item"><span class="value-bullet"></span><span><strong class="text-primary">Excellence:</strong> <span class="text-secondary">We are committed to delivering the highest quality services and publications.</span></span></li>
                    <li class="value-list-item"><span class="value-bullet"></span><span><strong class="text-primary">Innovation:</strong> <span class="text-secondary">We continuously explore new approaches and technologies to advance the publishing landscape.</span></span></li>
                    <li class="value-list-item"><span class="value-bullet"></span><span><strong class="text-primary">Collaboration:</strong> <span class="text-secondary">We foster strong partnerships with authors, researchers, and academic institutions.</span></span></li>
                    <li class="value-list-item"><span class="value-bullet"></span><span><strong class="text-primary">Inclusivity:</strong> <span class="text-secondary">We celebrate diversity and value the contributions of authors from all backgrounds.</span></span></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="section-aims" id="aims-objective">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="text-center mb-14" data-reveal>
            <div class="section-badge">
                <i class="fas fa-bullseye"></i>
                <span>Aims & Objectives</span>
            </div>
            <h2 class="heading-lg mt-5">Our Strategic Direction</h2>
            <div class="section-divider mt-4"></div>
        </div>
        <div class="grid md:grid-cols-2 gap-8">
            <div class="aims-card reveal delay-100">
                <div class="aims-card-header">
                    <div class="aims-icon-box">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h2 class="heading-md">Our Core Aims</h2>
                </div>
                <div class="card-divider mt-4 mb-5"></div>
                <ul class="space-y-4 text-secondary text-body">
                    <li class="value-list-item"><span class="value-bullet"></span><span><strong class="text-primary-dark">Empower knowledge dissemination:</strong> Leading platform for researchers, academics, and authors to share valuable work globally.</span></li>
                    <li class="value-list-item"><span class="value-bullet"></span><span><strong class="text-primary-dark">Foster academic excellence:</strong> Upholding the highest standards of academic integrity and rigor through editorial processes and support services.</span></li>
                    <li class="value-list-item"><span class="value-bullet"></span><span><strong class="text-primary-dark">Bridge the research gap:</strong> Facilitating publication and dissemination of impactful research findings to connect cutting-edge research with practical application.</span></li>
                    <li class="value-list-item"><span class="value-bullet"></span><span><strong class="text-primary-dark">Collaboration:</strong> Supporting a diverse range of authors and researchers across various disciplines.</span></li>
                </ul>
            </div>

            <div class="aims-card reveal delay-100">
                <div class="aims-card-header">
                    <div class="aims-icon-box">
                        <i class="fas fa-list-check"></i>
                    </div>
                    <h2 class="heading-md">Our Objectives</h2>
                </div>
                <div class="card-divider mt-4 mb-5"></div>
                <ul class="space-y-4 text-secondary text-body">
                    <li class="value-list-item"><span class="value-bullet"></span><span><strong class="text-primary-dark">Comprehensive publication services:</strong> From thesis writing assistance to book publication and conference proceedings management.</span></li>
                    <li class="value-list-item"><span class="value-bullet"></span><span><strong class="text-primary-dark">Strong peer-review system:</strong> Ensuring quality and credibility of published work through rigorous peer-review processes.</span></li>
                    <li class="value-list-item"><span class="value-bullet"></span><span><strong class="text-primary-dark">Technological advancements:</strong> Utilizing innovative technologies to streamline publication processes and enhance accessibility.</span></li>
                    <li class="value-list-item"><span class="value-bullet"></span><span><strong class="text-primary-dark">Strong partnerships:</strong> Fostering collaborative partnerships with academic institutions and research organizations.</span></li>
                    <li class="value-list-item"><span class="value-bullet"></span><span><strong class="text-primary-dark">Open access options:</strong> Implementing open access publishing models to increase research discoverability.</span></li>
                    <li class="value-list-item"><span class="value-bullet"></span><span><strong class="text-primary-dark">Supportive community:</strong> Creating resources, workshops, and networking opportunities for authors and researchers.</span></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="section-join" id="join-us">
    <div class="section-bg-pattern"></div>
    <div class="container mx-auto px-4 max-w-5xl">
        <div class="text-center reveal" data-reveal>
            <div class="section-badge section-badge--light">
                <i class="fas fa-rocket"></i>
                <span>Join Our Community</span>
            </div>
            <h2 class="heading-lg mt-5 mb-5">Join Us</h2>
            <div class="section-divider mt-0 mb-10"></div>
            <p class="max-w-3xl mx-auto text-body leading-relaxed text-secondary">
                Whether you are a seasoned researcher, a budding author, or an academic institution seeking a reliable publishing partner, Rainbow Publications is here to support your success. Explore our website to learn more about our services, browse our esteemed journals, and join our vibrant community of knowledge creators.
            </p>
            <div class="join-highlight mt-8">
                <i class="fas fa-quote-left"></i>
                <p class="join-highlight-text">Together, let's push the boundaries of knowledge and make a lasting impact on the world.</p>
            </div>
            <a href="<?= BASE_URL ?>contact" class="btn-primary mt-10">
                <span>Get In Touch</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<?php if(!empty($editorialBoard)): ?>
<section class="section-board" id="editorial-board">
    <div class="container mx-auto px-4">
        <div class="text-center mb-14" data-reveal>
            <div class="section-badge">
                <i class="fas fa-user-tie"></i>
                <span>Editorial Board</span>
            </div>
            <h2 class="heading-lg mt-5">Meet Our Leaders</h2>
            <div class="section-divider mt-4 mb-4"></div>
            <p class="text-secondary max-w-2xl mx-auto text-body">Our distinguished editorial board comprises leading experts and researchers from renowned institutions worldwide.</p>
        </div>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach($editorialBoard as $member): ?>
            <div class="board-card reveal">
                <div class="board-card-shine"></div>
                <div class="board-card-top">
                    <?php if(!empty($member['photo'])): ?>
                    <img src="<?= uploadUrl('board', $member['photo']) ?>"
                         alt="<?= htmlspecialchars($member['name']) ?>"
                         loading="lazy">
                    <?php else: ?>
                    <div class="board-avatar board-avatar-primary">
                        <i class="fas fa-user"></i>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="board-card-body">
                    <h4><?= htmlspecialchars($member['name']) ?></h4>
                    <?php if(!empty($member['designation'])): ?>
                    <p class="board-designation"><?= htmlspecialchars($member['designation']) ?></p>
                    <?php endif; ?>
                    <?php if(!empty($member['institution'])): ?>
                    <p class="board-institution"><strong>Affiliation:</strong> <?= htmlspecialchars($member['institution']) ?></p>
                    <?php endif; ?>
                    <?php if(!empty($member['qualification'])): ?>
                    <p class="board-email"><i class="fas fa-envelope"></i> <?= htmlspecialchars($member['qualification']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if(!empty($reviewerBoard)): ?>
<section class="section-board section-board--alt" id="reviewer-board">
    <div class="container mx-auto px-4">
        <div class="text-center mb-14" data-reveal>
            <div class="section-badge">
                <i class="fas fa-magnifying-glass"></i>
                <span>Reviewer Board</span>
            </div>
            <h2 class="heading-lg mt-5">Peer Review Experts</h2>
            <div class="section-divider mt-4 mb-4"></div>
            <p class="text-secondary max-w-2xl mx-auto text-body">Our rigorous peer review process is managed by expert reviewers who ensure the highest standards of academic quality.</p>
        </div>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
            <?php foreach($reviewerBoard as $member): ?>
            <div class="board-card reveal">
                <div class="board-card-shine"></div>
                <div class="board-card-top">
                    <?php if(!empty($member['photo'])): ?>
                    <img src="<?= uploadUrl('board', $member['photo']) ?>"
                         alt="<?= htmlspecialchars($member['name']) ?>"
                         loading="lazy">
                    <?php else: ?>
                    <div class="board-avatar board-avatar-secondary">
                        <i class="fas fa-user"></i>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="board-card-body">
                    <h4><?= htmlspecialchars($member['name']) ?></h4>
                    <?php if(!empty($member['designation'])): ?>
                    <p class="board-designation"><?= htmlspecialchars($member['designation']) ?></p>
                    <?php endif; ?>
                    <?php if(!empty($member['institution'])): ?>
                    <p class="board-institution"><?= htmlspecialchars($member['institution']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Payment Details -->
<section class="section-payment" id="payment">
    <div class="container mx-auto px-4 max-w-2xl">
        <div class="text-center mb-10" data-reveal>
            <div class="section-badge">
                <i class="fas fa-credit-card"></i>
                <span>Payment Details</span>
            </div>
            <h2 class="heading-lg mt-5">Make a Payment</h2>
            <div class="section-divider mt-4"></div>
        </div>
        <div class="payment-card reveal">
            <div class="payment-card-glow"></div>
            <div class="relative z-10">
                <?php if(!empty($payment)): ?>
                <div class="grid sm:grid-cols-2 gap-3">
                    <?php
                    $fields = [
                        'bank_name'     => ['fas fa-university','Bank Name'],
                        'account_holder'=> ['fas fa-user','Account Holder'],
                        'account_number'=> ['fas fa-hashtag','Account Number'],
                        'ifsc_code'     => ['fas fa-code','IFSC Code'],
                        'upi_id'        => ['fas fa-mobile-alt','UPI ID'],
                    ];
                    foreach($fields as $key => [$icon,$label]):
                        if(empty($payment[$key])) continue;
                    ?>
                    <div class="payment-field">
                        <div class="payment-field-icon">
                            <i class="<?= $icon ?>"></i>
                        </div>
                        <div class="payment-field-info">
                            <p class="payment-field-label"><?= $label ?></p>
                            <p class="payment-field-value"><?= htmlspecialchars($payment[$key]) ?></p>
                        </div>
                        <button class="copy-btn" title="Copy" onclick="copyToClipboard('<?= htmlspecialchars($payment[$key]) ?>', this)">
                            <i class="far fa-copy"></i>
                        </button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php if(!empty($payment['qr_code'])): ?>
                <div class="text-center mt-8 pt-8 border-t border-[var(--border-color)]">
                    <p class="text-sm font-semibold text-primary mb-4">Scan QR Code to Pay</p>
                    <div class="qr-wrapper">
                        <div class="qr-glow"></div>
                        <img src="<?= uploadUrl('payment', $payment['qr_code']) ?>"
                             alt="Payment QR Code" class="qr-code">
                    </div>
                    <p class="text-xs text-slate-600 mt-4">Scan using any UPI app</p>
                </div>
                <?php endif; ?>
                <?php else: ?>
                <div class="text-center py-12">
                    <div class="payment-placeholder-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <p class="text-slate-600 mt-4">Payment details will be available soon.<br>Please <a href="<?= BASE_URL ?>contact" class="text-primary font-semibold hover:underline">contact us</a> for more information.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<style>
/* ================================================================
   MAIN.PHP — Professional Design System
   Palette: Navy (#003098) + Slate — clean, corporate, authoritative
   ================================================================ */

/* ===== CSS Custom Properties ===== */
:root {
    --primary: #003098;
    --primary-light: #0067b2;
    --primary-dark: #05538b;
    --secondary: #1F2937;
    --accent: #003098;
    --slate-50: #F8FAFC;
    --slate-100: #F1F5F9;
    --slate-200: #E2E8F0;
    --slate-300: #CBD5E1;
    --slate-600: #475569;
    --slate-700: #334155;
    --slate-800: #1E293B;
    --slate-900: #0F172A;
    --text-primary: #0F172A;
    --text-secondary: #475569;
    --border-color: #E2E8F0;
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 20px;
    --transition-fast: 0.2s ease;
    --transition-base: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --transition-slow: 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

/* ===== Keyframe Animations ===== */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes fadeIn {
    from { opacity: 0; }
    to   { opacity: 1; }
}
@keyframes slideInLeft {
    from { opacity: 0; transform: translateX(-20px); }
    to   { opacity: 1; transform: translateX(0); }
}
@keyframes float {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33%      { transform: translate(25px, -35px) scale(1.05); }
    66%      { transform: translate(-15px, 15px) scale(0.95); }
}
@keyframes pulse-ring {
    0%   { transform: scale(0.9); opacity: 0.6; }
    50%  { transform: scale(1.1); opacity: 0.2; }
    100% { transform: scale(0.9); opacity: 0.6; }
}
@keyframes shimmer {
    0%   { background-position: -200% center; }
    100% { background-position: 200% center; }
}
@keyframes scaleIn {
    from { opacity: 0; transform: scale(0.9); }
    to   { opacity: 1; transform: scale(1); }
}
@keyframes toastIn {
    from { opacity: 0; transform: translate(-50%, 10px); }
    to   { opacity: 1; transform: translate(-50%, 0); }
}
@keyframes toastOut {
    from { opacity: 1; transform: translate(-50%, 0); }
    to   { opacity: 0; transform: translate(-50%, 10px); }
}

/* ===== Page Hero ===== */
.page-hero {
    position: relative;
    background: linear-gradient(135deg, var(--primary-dark) 0%, #002d8d 50%, #022b49 100%);
    padding-top: calc(var(--header-height, 80px) + 2rem);
    padding-bottom: 5rem;
    overflow: hidden;
}

.hero-mesh {
    position: absolute;
    inset: 0;
    background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M50 50c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10c0 5.523-4.477 10-10 10s-10-4.477-10-10 4.477-10 10-10zM10 10c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10c0 5.523-4.477 10-10 10S0 25.523 0 20s4.477-10 10-10z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.8;
}

.hero-orbs { position: absolute; inset: 0; overflow: hidden; pointer-events: none; }

.orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    animation: float 12s ease-in-out infinite;
}
.orb-1 {
    width: 350px; height: 350px;
    background: rgba(255, 255, 255, 0.06);
    top: -10%; left: -5%;
    animation-delay: 0s;
}
.orb-2 {
    width: 250px; height: 250px;
    background: rgba(0, 103, 178, 0.2);
    top: 50%; right: -8%;
    animation-delay: -4s;
}
.orb-3 {
    width: 200px; height: 200px;
    background: rgba(255, 255, 255, 0.04);
    bottom: -15%; left: 40%;
    animation-delay: -8s;
}

.breadcrumb-link {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    transition: all var(--transition-fast);
    position: relative;
}
.breadcrumb-link::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 0;
    height: 1px;
    background: #fff;
    transition: width var(--transition-fast);
}
.breadcrumb-link:hover { color: #fff; }
.breadcrumb-link:hover::after { width: 100%; }

.breadcrumb-sep { color: rgba(255, 255, 255, 0.35); margin: 0 0.35rem; }
.breadcrumb-current { color: rgba(255, 255, 255, 0.9); font-weight: 500; }

.hero-title {
    font-family: var(--font-display, 'Space Grotesk', system-ui, sans-serif);
    font-size: var(--fs-h1);
    font-weight: 800;
    color: #fff;
    line-height: 1.1;
    letter-spacing: -0.03em;
}
.hero-title-line {
    display: inline-block;
    animation: slideInLeft 0.8s cubic-bezier(0.22, 1, 0.36, 1) 0.1s both;
}

.hero-divider {
    width: 70px;
    height: 4px;
    background: linear-gradient(to right, #fff, rgba(255,255,255,0.3));
    border-radius: 2px;
    margin-top: 1.5rem;
    margin-bottom: 1.5rem;
    animation: scaleIn 0.8s cubic-bezier(0.22, 1, 0.36, 1) 0.3s both;
}

.hero-subtitle {
    color: rgba(255, 255, 255, 0.75);
    font-size: var(--fs-body);
    max-width: 560px;
    line-height: 1.7;
    animation: fadeInUp 0.8s cubic-bezier(0.22, 1, 0.36, 1) 0.5s both;
}

/* ===== Section Badge ===== */
.section-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    color: var(--primary);
    padding: 0.4rem 1.1rem;
    border: 1.5px solid var(--primary);
    border-radius: 100px;
    background: rgba(0, 48, 152, 0.05);
    animation: fadeInUp 0.6s cubic-bezier(0.22, 1, 0.36, 1) both;
}
.section-badge i { font-size: 0.7rem; }

.section-badge--light {
    color: #fff;
    border-color: rgba(255,255,255,0.35);
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(4px);
}

/* ===== Section Divider ===== */
.section-divider {
    width: 50px;
    height: 4px;
    background: linear-gradient(to right, var(--primary), var(--primary-light));
    border-radius: 2px;
    margin-left: auto;
    margin-right: auto;
}

/* ===== Heading System ===== */
.heading-lg {
    font-family: var(--font-display, 'Space Grotesk', system-ui, sans-serif);
    font-size: var(--fs-h2);
    font-weight: 700;
    line-height: 1.2;
    letter-spacing: -0.02em;
    color: var(--text-primary);
}

.heading-md {
    font-family: var(--font-display, 'Space Grotesk', system-ui, sans-serif);
    font-size: var(--fs-h3);
    font-weight: 700;
    line-height: 1.2;
    letter-spacing: -0.01em;
    color: var(--text-primary);
}

/* ===== About Section ===== */
.section-about {
    background: var(--slate-50);
    padding: var(--space-2xl, 5rem) 0;
    position: relative;
}

.section-wave-top {
    position: absolute;
    top: -1px;
    left: 0;
    right: 0;
    overflow: hidden;
    line-height: 0;
}
.section-wave-top svg {
    display: block;
    width: 100%;
    height: 30px;
}

.value-card {
    background: #fff;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: 2rem;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    height: 100%;
    position: relative;
    overflow: hidden;
    transition: all var(--transition-base);
}

.value-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(to right, var(--primary), var(--primary-light));
    transform: scaleX(0);
    transform-origin: left;
    transition: transform var(--transition-slow);
}

.value-card::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 0;
    background: linear-gradient(to top, rgba(0, 48, 152, 0.02), transparent);
    transition: height var(--transition-slow);
    pointer-events: none;
}

.value-card:hover {
    transform: translateY(-8px);
    border-color: var(--primary);
    box-shadow: 0 20px 40px -12px rgba(0, 48, 152, 0.15),
                0 8px 16px -8px rgba(0, 0, 0, 0.08);
}

.value-card:hover::before { transform: scaleX(1); }
.value-card:hover::after  { height: 100%; }

.card-icon-wrap {
    margin-bottom: 1.25rem;
}

.card-icon {
    width: 52px;
    height: 52px;
    border-radius: var(--radius-md);
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 20px -6px rgba(0, 48, 152, 0.35);
    transition: transform var(--transition-base), box-shadow var(--transition-base);
}

.card-icon i {
    font-size: 1.25rem;
    color: #fff;
}

.value-card:hover .card-icon {
    transform: scale(1.08) rotate(-3deg);
    box-shadow: 0 12px 28px -8px rgba(0, 48, 152, 0.45);
}

.card-accent-bar {
    margin-top: auto;
    padding-top: 1rem;
    width: 100%;
    height: 2px;
    background: var(--border-color);
    border-radius: 1px;
    position: relative;
    overflow: hidden;
}
.card-accent-bar::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to right, var(--primary), var(--primary-light));
    transform: scaleX(0);
    transform-origin: left;
    transition: transform var(--transition-slow);
}
.value-card:hover .card-accent-bar::after { transform: scaleX(1); }

/* ===== Mission Section ===== */
.section-mission {
    background: var(--slate-100);
    padding: var(--space-2xl, 5rem) 0;
    position: relative;
    overflow: hidden;
}

.section-bg-pattern {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(circle at 1px 1px, var(--border-color) 1px, transparent 0);
    background-size: 28px 28px;
    opacity: 0.6;
}

.mission-card {
    background: #fff;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: 2.5rem;
    position: relative;
    overflow: hidden;
    transition: all var(--transition-base);
}

.mission-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(to right, var(--primary), var(--primary-light), var(--primary));
    background-size: 200% 100%;
    animation: shimmer 3s ease-in-out infinite;
}

.mission-card:hover {
    border-color: var(--primary);
    box-shadow: 0 25px 50px -12px rgba(0, 48, 152, 0.12),
                0 10px 20px -10px rgba(0, 0, 0, 0.06);
    transform: translateY(-4px);
}

.card-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--primary);
    padding: 0.4rem 1rem;
    border: 1.5px solid var(--primary);
    border-radius: 100px;
    background: rgba(0, 48, 152, 0.04);
}
.card-badge--alt {
    color: var(--primary-dark);
    border-color: var(--primary-dark);
    background: rgba(5, 83, 139, 0.04);
}
.card-badge i { font-size: 0.65rem; }

.card-divider {
    width: 100%;
    height: 1px;
    background: var(--border-color);
}

.value-list-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    line-height: 1.6;
}
.value-list-item span:last-child { flex: 1; }

.value-bullet {
    width: 7px;
    height: 7px;
    min-width: 7px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    margin-top: 0.5em;
    box-shadow: 0 0 0 3px rgba(0, 48, 152, 0.1);
}

.mission-stat-row {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding-top: 1.25rem;
    border-top: 1px solid var(--border-color);
    margin-top: 1.5rem;
}
.mission-stat {
    display: flex;
    flex-direction: column;
}
.mission-stat-number {
    font-family: var(--font-display, 'Space Grotesk', system-ui, sans-serif);
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--primary);
}
.mission-stat-label {
    font-size: 0.7rem;
    color: var(--slate-600);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-top: 0.15rem;
}
.mission-stat-divider {
    width: 1px;
    height: 36px;
    background: var(--border-color);
}

/* ===== Aims Section ===== */
.section-aims {
    background: var(--slate-50);
    padding: var(--space-2xl, 5rem) 0;
    position: relative;
}

.aims-card {
    background: #fff;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: 2.5rem;
    position: relative;
    overflow: hidden;
    transition: all var(--transition-base);
}

.aims-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(to bottom, var(--primary), var(--primary-light));
    opacity: 0;
    transition: opacity var(--transition-base);
}

.aims-card:hover {
    border-color: var(--primary);
    box-shadow: 0 25px 50px -12px rgba(0, 48, 152, 0.1);
    transform: translateY(-4px);
}
.aims-card:hover::before { opacity: 1; }

.aims-card-header {
    display: flex;
    align-items: center;
    gap: 0.875rem;
}

.aims-icon-box {
    width: 44px;
    height: 44px;
    border-radius: var(--radius-md);
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 6px 16px -4px rgba(0, 48, 152, 0.3);
}

.aims-icon-box i {
    font-size: 1.1rem;
    color: #fff;
}

/* ===== Join Section ===== */
.section-join {
    background: linear-gradient(135deg, var(--secondary) 0%, var(--slate-900) 100%);
    padding: var(--space-2xl, 5rem) 0;
    position: relative;
    overflow: hidden;
}

.section-join::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at 30% 50%, rgba(0, 48, 152, 0.3) 0%, transparent 60%),
                radial-gradient(ellipse at 70% 80%, rgba(0, 103, 178, 0.15) 0%, transparent 50%);
    pointer-events: none;
}

.join-highlight {
    max-width: 580px;
    margin-left: auto;
    margin-right: auto;
    padding: 1.5rem 2rem;
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: var(--radius-lg);
    backdrop-filter: blur(10px);
    position: relative;
}
.join-highlight::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(to right, transparent, rgba(255,255,255,0.2), transparent);
}
.join-highlight i {
    color: var(--primary-light);
    font-size: 1.5rem;
    display: block;
    margin-bottom: 0.5rem;
    opacity: 0.7;
}
.join-highlight-text {
    font-family: var(--font-display, 'Space Grotesk', system-ui, sans-serif);
    font-size: 1.15rem;
    font-weight: 600;
    color: #fff;
    line-height: 1.6;
    font-style: italic;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.85rem 2rem;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
    color: #fff;
    font-weight: 600;
    font-size: var(--fs-small);
    border-radius: var(--radius-sm);
    text-decoration: none;
    box-shadow: 0 8px 24px -6px rgba(0, 48, 152, 0.4);
    transition: all var(--transition-base);
    border: none;
    cursor: pointer;
}
.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 32px -8px rgba(0, 48, 152, 0.5);
}
.btn-primary i {
    font-size: 0.8rem;
    transition: transform var(--transition-fast);
}
.btn-primary:hover i { transform: translateX(3px); }

/* ===== Editorial / Reviewer Board ===== */
.section-board {
    background: var(--slate-50);
    padding: var(--space-2xl, 5rem) 0;
}
.section-board--alt { background: var(--slate-100); }

.board-card {
    background: #fff;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 100%;
    position: relative;
    transition: all var(--transition-base);
}

.board-card-shine {
    position: absolute;
    top: 0;
    left: -100%;
    width: 60%;
    height: 100%;
    background: linear-gradient(to right, transparent, rgba(255,255,255,0.7), transparent);
    transform: skewX(-15deg);
    transition: left 0.6s ease;
    pointer-events: none;
    z-index: 5;
}
.board-card:hover .board-card-shine {
    left: 120%;
}

.board-card-top {
    padding: 2rem 1.5rem 1rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    position: relative;
}

.board-card-top::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 40px;
    height: 2px;
    background: var(--border-color);
    border-radius: 1px;
    transition: all var(--transition-base);
}
.board-card:hover .board-card-top::after {
    width: 60px;
    background: var(--primary);
}

.board-card img {
    width: 88px;
    height: 88px;
    object-fit: cover;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    transition: transform var(--transition-base), box-shadow var(--transition-base);
}

.board-card:hover img {
    transform: scale(1.06);
    box-shadow: 0 10px 30px rgba(0, 48, 152, 0.2);
}

.board-avatar {
    width: 88px;
    height: 88px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid #fff;
    transition: transform var(--transition-base), box-shadow var(--transition-base);
}
.board-card:hover .board-avatar { transform: scale(1.06); }
.board-avatar i {
    font-size: 1.75rem;
    color: rgba(255, 255, 255, 0.8);
}
.board-avatar-primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    box-shadow: 0 6px 20px rgba(0, 48, 152, 0.3);
}
.board-avatar-secondary {
    background: linear-gradient(135deg, var(--primary-dark), var(--primary));
    box-shadow: 0 6px 20px rgba(5, 83, 139, 0.3);
}

.board-card-body {
    padding: 1.25rem 1.5rem 1.75rem;
    width: 100%;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.2rem;
}

.board-card h4 {
    font-family: var(--font-display, 'Space Grotesk', system-ui, sans-serif);
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
    line-height: 1.3;
}

.board-card:hover {
    transform: translateY(-8px);
    border-color: var(--primary);
    box-shadow: 0 24px 48px -12px rgba(0, 48, 152, 0.15);
}

.board-designation {
    color: var(--primary);
    font-size: 0.78rem;
    font-weight: 600;
}

.board-institution {
    color: var(--slate-600);
    font-size: 0.78rem;
}

.board-email {
    color: var(--slate-600);
    font-size: 0.75rem;
    margin-top: 0.75rem;
    padding-top: 0.75rem;
    width: 100%;
    border-top: 1px solid var(--border-color);
    font-style: normal;
}
.board-email i {
    color: var(--primary);
    font-size: 0.65rem;
    margin-right: 0.35rem;
}

/* ===== Payment Section ===== */
.section-payment {
    background: var(--slate-100);
    padding: var(--space-2xl, 5rem) 0;
}

.payment-card {
    background: #fff;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-lg);
    padding: 2.5rem;
    position: relative;
    overflow: hidden;
}

.payment-card-glow {
    position: absolute;
    top: -120px;
    right: -120px;
    width: 350px;
    height: 350px;
    background: radial-gradient(circle, rgba(0, 48, 152, 0.05) 0%, transparent 70%);
    pointer-events: none;
}

.payment-field {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    padding: 0.85rem 1rem;
    background: var(--slate-50);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    transition: all var(--transition-fast);
    position: relative;
}

.payment-field:hover {
    border-color: var(--primary);
    background: #fff;
    box-shadow: 0 4px 12px -4px rgba(0, 48, 152, 0.1);
}

.payment-field-icon {
    width: 2.25rem;
    height: 2.25rem;
    border-radius: var(--radius-sm);
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.payment-field-icon i {
    font-size: 0.85rem;
    color: #fff;
}

.payment-field-label {
    font-size: 0.68rem;
    color: var(--slate-600);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.15rem;
}

.payment-field-value {
    font-size: 0.875rem;
    color: var(--text-primary);
    font-weight: 600;
    font-family: 'Space Grotesk', 'Courier New', monospace;
    letter-spacing: 0.01em;
}

.copy-btn {
    margin-left: auto;
    width: 32px;
    height: 32px;
    border-radius: var(--radius-sm);
    border: 1px solid transparent;
    background: transparent;
    color: var(--slate-600);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all var(--transition-fast);
    flex-shrink: 0;
}
.copy-btn:hover {
    border-color: var(--primary);
    color: var(--primary);
    background: rgba(0, 48, 152, 0.04);
}
.copy-btn.copied {
    border-color: #16a34a;
    color: #16a34a;
    background: rgba(22, 163, 74, 0.05);
}

.qr-wrapper {
    display: inline-block;
    position: relative;
    padding: 1rem;
    background: #fff;
    border-radius: var(--radius-md);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    border: 1px solid var(--border-color);
}
.qr-glow {
    position: absolute;
    inset: -8px;
    border-radius: calc(var(--radius-md) + 8px);
    background: radial-gradient(circle, rgba(0, 48, 152, 0.06) 0%, transparent 70%);
    pointer-events: none;
}
.qr-code {
    max-width: 180px;
    display: block;
    position: relative;
    z-index: 2;
}

.payment-placeholder-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: var(--slate-100);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}
.payment-placeholder-icon i {
    font-size: 1.5rem;
    color: var(--slate-600);
}

/* ===== Scroll Reveal ===== */
[data-reveal] {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.8s cubic-bezier(0.22, 1, 0.36, 1),
                transform 0.8s cubic-bezier(0.22, 1, 0.36, 1);
}
[data-reveal].visible {
    opacity: 1;
    transform: translateY(0);
}

.reveal {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.8s cubic-bezier(0.22, 1, 0.36, 1),
                transform 0.8s cubic-bezier(0.22, 1, 0.36, 1);
}
.reveal.visible {
    opacity: 1;
    transform: translateY(0);
}

.delay-100 { transition-delay: 0.1s !important; }
.delay-200 { transition-delay: 0.2s !important; }
.delay-300 { transition-delay: 0.3s !important; }

/* ===== Scroll Reveal Script ===== */
</style>

<script>
(function() {
    var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (reducedMotion) {
        document.querySelectorAll('[data-reveal], .reveal').forEach(function(el) {
            el.classList.add('visible');
            el.style.opacity = '1';
            el.style.transform = 'none';
        });
        return;
    }

    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(e) {
            if (e.isIntersecting) {
                e.target.classList.add('visible');
                observer.unobserve(e.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

    document.querySelectorAll('[data-reveal], .reveal').forEach(function(el) {
        observer.observe(el);
    });
})();

/* Copy-to-clipboard for payment fields */
function copyToClipboard(text, btn) {
    navigator.clipboard.writeText(text).then(function() {
        btn.classList.add('copied');
        btn.querySelector('i').className = 'fas fa-check';
        setTimeout(function() {
            btn.classList.remove('copied');
            btn.querySelector('i').className = 'far fa-copy';
        }, 1800);
    }).catch(function() {
        var tmp = document.createElement('input');
        tmp.value = text;
        document.body.appendChild(tmp);
        tmp.select();
        document.execCommand('copy');
        document.body.removeChild(tmp);
        btn.classList.add('copied');
        btn.querySelector('i').className = 'fas fa-check';
        setTimeout(function() {
            btn.classList.remove('copied');
            btn.querySelector('i').className = 'far fa-copy';
        }, 1800);
    });
}
</script>

<?php if(!empty($editorialBoard)): ?>
<?php endif; ?>
<?php if(!empty($reviewerBoard)): ?>
<?php endif; ?>
