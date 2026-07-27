<?php
$pageTitle = 'Membership List';
$heroIntro = 'Join our academic community and unlock exclusive benefits tailored for researchers and institutions.';
?>
<!-- Page Hero -->
<?php include __DIR__ . '/../partials/hero.php'; ?>

<!-- Plans -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        
        <div class="text-center py-20">
            <i class="fas fa-id-card text-5xl text-gray-300 mb-4 block"></i>
            <p class="text-gray-500">Membership List  will be available soon.</p>
        </div>
      

        <!-- CTA Banner -->
        <div class="mt-16 text-center">
            <div class="bg-gradient-to-r from-primary to-primary-light rounded-2xl p-10 max-w-3xl mx-auto text-white">
                <h3 class="font-serif text-2xl font-bold mb-3">Connect With Us</h3>
                <p class="text-white/80 mb-6">Contact us for institutional memberships or tailored packages for your organization.</p>
                <a href="<?= BASE_URL ?>/contact" class="btn-primary">
                    <i class="fas fa-envelope"></i> Contact Us
                </a>
            </div>
        </div>
    </div>
</section>

<?php
