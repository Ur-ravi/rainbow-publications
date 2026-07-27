<?php
http_response_code(404);
$pageTitle = '404 — Page Not Found';
?>
<section class="min-h-[70vh] flex items-center justify-center bg-gray-50">
    <div class="text-center px-4 py-20">
        <div class="relative inline-block mb-8">
            <span class="text-[10rem] font-black text-gray-100 leading-none select-none">404</span>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-24 h-24 rounded-full bg-white shadow-xl flex items-center justify-center">
                    <i class="fas fa-search text-4xl text-primary"></i>
                </div>
            </div>
        </div>
        <h1 class="heading-lg font-serif text-primary mb-4">Page Not Found</h1>
        <p class="text-gray-500 max-w-md mx-auto mb-8 text-lg">
            The page you're looking for doesn't exist or has been moved. Let's get you back on track.
        </p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="<?= BASE_URL ?>" class="btn-primary">
                <i class="fas fa-home"></i> Go Home
            </a>
            <a href="<?= BASE_URL ?>/books"
               class="flex items-center gap-2 border-2 border-primary text-primary px-6 py-3 rounded-full font-semibold hover:bg-primary hover:text-white transition">
                <i class="fas fa-book"></i> Browse Books
            </a>
            <a href="<?= BASE_URL ?>/contact"
               class="flex items-center gap-2 border-2 border-gray-300 text-gray-600 px-6 py-3 rounded-full font-semibold hover:border-primary hover:text-primary transition">
                <i class="fas fa-envelope"></i> Contact Us
            </a>
        </div>
    </div>
</section>

<?php
