<?php $siteName = getSetting('site_name', 'Rainbow Publications'); ?>
<section class="min-h-[60vh] flex items-center justify-center py-16 bg-slate-50">
    <div class="container mx-auto px-4 max-w-2xl text-center">
        <div class="bg-white rounded-3xl shadow-md border border-gray-100 p-10 md:p-14">
            <div class="w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-6"
                 style="background: linear-gradient(135deg, #0D2D57, #2563EB);">
                <i class="fas fa-check text-white text-3xl"></i>
            </div>
            <h1 class="font-modern text-3xl md:text-4xl font-extrabold text-gray-800 mb-3">
                Thank You for Applying!
            </h1>
            <p class="text-gray-600 text-base leading-relaxed mb-2">
                Your membership application has been received successfully.
            </p>
            <p class="text-gray-500 text-sm leading-relaxed">
                Our team at <strong><?= htmlspecialchars($siteName) ?></strong> will review your application and contact you via email within
                <strong>3–5 business days</strong>.
            </p>

            <div class="mt-8 pt-6 border-t border-gray-100 flex flex-wrap gap-3 justify-center">
                <a href="<?= BASE_URL ?>/" class="px-5 py-2.5 rounded-xl bg-primary text-white font-semibold text-sm hover:bg-primary-dark transition flex items-center gap-2">
                    <i class="fas fa-home"></i> Back to Home
                </a>
                <a href="<?= BASE_URL ?>/contact" class="px-5 py-2.5 rounded-xl border-2 border-primary text-primary font-semibold text-sm hover:bg-primary hover:text-white transition flex items-center gap-2">
                    <i class="fas fa-envelope"></i> Contact Us
                </a>
            </div>
        </div>
    </div>
</section>
