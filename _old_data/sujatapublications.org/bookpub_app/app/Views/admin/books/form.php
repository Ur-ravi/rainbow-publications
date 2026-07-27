<?php $pageTitle = $book ? 'Edit Book' : 'Add New Book'; ?>

<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800"><?= $book ? 'Edit Book' : 'Add New Book' ?></h2>
        <p class="text-gray-400 text-sm mt-0.5"><?= $book ? 'Update book details' : 'Add a new book to your catalog' ?></p>
    </div>
    <a href="<?= BASE_URL ?>/admin/books" class="inline-flex items-center gap-2 text-gray-600 hover:text-primary text-sm font-semibold transition-colors">
        <i class="fas fa-arrow-left text-xs"></i> Back to Books
    </a>
</div>

<form action="<?= BASE_URL ?>/admin/books/<?= $book ? 'update/' . $book['id'] : 'store' ?>" method="POST" enctype="multipart/form-data" id="bookForm">
    <?= Security::csrfField() ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Main Fields -->
        <div class="lg:col-span-2 space-y-5">

            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-5 pb-3 border-b border-gray-100">Book Details</h3>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Book Title <span class="text-secondary">*</span></label>
                    <input type="text" name="title" required value="<?= Security::e($book['title'] ?? '') ?>"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm" placeholder="Enter book title">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Author(s) <span class="text-secondary">*</span></label>
                    <input type="text" name="authors" required value="<?= Security::e($book['authors'] ?? '') ?>"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm" placeholder="e.g. Dr. John Smith, Prof. Jane Doe">
                </div>

                <div class="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">ISBN</label>
                        <input type="text" name="isbn" value="<?= Security::e($book['isbn'] ?? '') ?>"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm" placeholder="978-X-XXXXX-XXX-X">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                        <input type="text" name="category" value="<?= Security::e($book['category'] ?? '') ?>"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm" placeholder="e.g. Pharmacology">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Publisher</label>
                        <input type="text" name="publisher" value="<?= Security::e($book['publisher'] ?? '') ?>"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Publication Date</label>
                        <input type="date" name="publication_date" value="<?= Security::e($book['publication_date'] ?? '') ?>"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pages</label>
                        <input type="number" name="pages_count" value="<?= Security::e($book['pages_count'] ?? '') ?>" min="0"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Language</label>
                        <input type="text" name="language" value="<?= Security::e($book['language'] ?? 'English') ?>"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Price (₹)</label>
                        <input type="number" name="price" value="<?= Security::e($book['price'] ?? '0') ?>" min="0" step="0.01"
                               class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="6"
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm"
                              placeholder="Book description..."><?= Security::e($book['description'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- SEO -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-5 pb-3 border-b border-gray-100">SEO Settings</h3>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Meta Title</label>
                    <input type="text" name="meta_title" value="<?= Security::e($book['meta_title'] ?? '') ?>"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm" maxlength="255">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Meta Description</label>
                    <textarea name="meta_description" rows="3"
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm"
                              maxlength="320"><?= Security::e($book['meta_description'] ?? '') ?></textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Keywords</label>
                    <input type="text" name="meta_keywords" value="<?= Security::e($book['meta_keywords'] ?? '') ?>"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary text-sm" placeholder="keyword1, keyword2, ...">
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-5">

            <!-- Publish -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Publish</h3>
                <div class="space-y-3 mb-5">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="is_published" value="0">
                        <input type="checkbox" name="is_published" value="1" <?= ($book['is_published'] ?? 1) ? 'checked' : '' ?>
                               class="w-4 h-4 text-primary rounded border-gray-300 focus:ring-primary">
                        <span class="text-sm text-gray-700">Published (visible on site)</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="is_featured" value="0">
                        <input type="checkbox" name="is_featured" value="1" <?= ($book['is_featured'] ?? 0) ? 'checked' : '' ?>
                               class="w-4 h-4 text-secondary rounded border-gray-300 focus:ring-secondary">
                        <span class="text-sm text-gray-700">Featured on homepage</span>
                    </label>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sort Order</label>
                    <input type="number" name="sort_order" value="<?= Security::e($book['sort_order'] ?? '0') ?>" min="0"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/30 text-sm">
                </div>
                <button type="submit"
                        class="w-full bg-primary hover:bg-primary-light text-white font-bold py-3 rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i> <?= $book ? 'Update Book' : 'Save Book' ?>
                </button>
            </div>

            <!-- Cover Image -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Cover Image</h3>
                <?php if (!empty($book['cover_image'])): ?>
                <div class="mb-3 rounded-xl overflow-hidden h-48 bg-gray-100">
                    <img src="<?= uploadUrl('books', $book['cover_image']) ?>" alt="" class="w-full h-full object-cover">
                </div>
                <?php endif; ?>
                <label class="block">
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center hover:border-primary cursor-pointer transition-colors" id="coverDropzone">
                        <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl mb-2"></i>
                        <p class="text-sm text-gray-500">Click or drag to upload</p>
                        <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP (max 10MB)</p>
                    </div>
                    <input type="file" name="cover_image" accept="image/*" class="hidden" id="coverInput" onchange="previewImage(this, 'coverDropzone')">
                </label>
            </div>

            <!-- PDF Upload -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4">PDF File</h3>
                <?php if (!empty($book['pdf_file'])): ?>
                <div class="mb-3 p-3 bg-red-50 rounded-xl flex items-center gap-2 text-sm text-red-700">
                    <i class="fas fa-file-pdf"></i> <span class="truncate">Current PDF uploaded</span>
                </div>
                <?php endif; ?>
                <label class="block">
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center hover:border-secondary cursor-pointer transition-colors" id="pdfDropzone">
                        <i class="fas fa-file-pdf text-gray-400 text-2xl mb-2"></i>
                        <p class="text-sm text-gray-500">Upload PDF</p>
                        <p class="text-xs text-gray-400 mt-1">PDF only (max 50MB)</p>
                    </div>
                    <input type="file" name="pdf_file" accept=".pdf" class="hidden" id="pdfInput" onchange="showFilename(this, 'pdfDropzone')">
                </label>
            </div>
        </div>
    </div>
</form>

<script>
// File preview helpers
function previewImage(input, dropzoneId) {
    const dz = document.getElementById(dropzoneId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            dz.innerHTML = `<img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function showFilename(input, dropzoneId) {
    const dz = document.getElementById(dropzoneId);
    if (input.files && input.files[0]) {
        dz.innerHTML = `<i class="fas fa-check-circle text-green-500 text-xl mb-1"></i><p class="text-sm text-green-700 truncate px-2">${input.files[0].name}</p>`;
    }
}

// Click dropzone => trigger file input
document.getElementById('coverDropzone').addEventListener('click', () => document.getElementById('coverInput').click());
document.getElementById('pdfDropzone').addEventListener('click', () => document.getElementById('pdfInput').click());

// AJAX form submit
document.getElementById('bookForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = this.querySelector('[type=submit]');
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
    btn.disabled = true;
    try {
        const fd  = new FormData(this);
        const res = await fetch(this.action, { method: 'POST', body: fd });
        const d   = await res.json();
        showToast(d.message, d.success ? 'success' : 'error');
        if (d.success && !<?= $book ? 'true' : 'false' ?>) {
            setTimeout(() => window.location.href = '<?= BASE_URL ?>/admin/books', 1200);
        }
    } catch(err) {
        showToast('Request failed.', 'error');
    }
    btn.innerHTML = '<i class="fas fa-save mr-2"></i><?= $book ? 'Update Book' : 'Save Book' ?>';
    btn.disabled = false;
});
</script>
