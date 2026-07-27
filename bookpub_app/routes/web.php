<?php
// ============================================================
// ROUTES
// ============================================================

// --- FRONTEND ---
$router->get('/',              [HomeController::class,       'index']);
$router->get('/about',         [PageController::class,       'about']);
$router->get('/editorial-board', [PageController::class, 'editorialBoard']);
$router->get('/reviewer-board',  [PageController::class, 'reviewerBoard']);
$router->get('/about/compliance-policy',  [PageController::class, 'compliancePolicy']);
$router->get('/about/terms-conditions',   [PageController::class, 'termsConditions']);
$router->get('/about/payment-details',    [PageController::class, 'paymentDetails']);
$router->get('/books',         [BookController::class,       'index']);
$router->get('/book/:slug',    [BookController::class,       'show']);
$router->get('/conference-abstract-book', [BookController::class, 'conferenceAbstractBook']);
$router->get('/journals',      [JournalController::class,    'index']);
$router->get('/membership',    [MembershipController::class, 'index']);
$router->get('/services',      [ServiceController::class,    'index']);
$router->get('/service/:slug', [ServiceController::class,    'show']);
$router->get('/gallery',       [GalleryController::class,    'index']);
$router->get('/contact',       [ContactController::class,    'index']);
$router->post('/contact/send', [ContactController::class,    'send']);
$router->get('/policies',                              [PageController::class, 'policiesIndex']);
$router->get('/policies/privacy-policy',               [PageController::class, 'privacyPolicy']);
$router->get('/policies/cancellation-refund',        [PageController::class, 'cancellationRefund']);
$router->get('/policies/shipping-delivery',          [PageController::class, 'shippingDelivery']);
$router->get('/news',          [NewsController::class,       'index']);
$router->get('/news/:slug',    [NewsController::class,       'show']);

// --- ADMIN AUTH ---
$router->any('/admin',               [AuthController::class, 'login']);
$router->any('/admin/login',         [AuthController::class, 'login']);
$router->get('/admin/logout',        [AuthController::class, 'logout']);

// --- ADMIN DASHBOARD ---
$router->get('/admin/dashboard',     [AdminController::class, 'dashboard']);

// --- ADMIN BOOKS ---
$router->get('/admin/books',                [AdminBookController::class, 'index']);
$router->get('/admin/books/create',         [AdminBookController::class, 'create']);
$router->post('/admin/books/store',         [AdminBookController::class, 'store']);
$router->get('/admin/books/edit/:id',       [AdminBookController::class, 'edit']);
$router->post('/admin/books/update/:id',    [AdminBookController::class, 'update']);
$router->post('/admin/books/delete/:id',    [AdminBookController::class, 'delete']);
$router->post('/admin/books/toggle/:id',    [AdminBookController::class, 'toggle']);

// --- ADMIN JOURNALS ---
$router->get('/admin/journals',             [AdminJournalController::class, 'index']);
$router->post('/admin/journals/store',      [AdminJournalController::class, 'store']);
$router->post('/admin/journals/update/:id', [AdminJournalController::class, 'update']);
$router->post('/admin/journals/delete/:id', [AdminJournalController::class, 'delete']);
$router->post('/admin/journals/reorder',    [AdminJournalController::class, 'reorder']);

// --- ADMIN BOARD ---
$router->get('/admin/board',                      [AdminBoardController::class, 'index']);
$router->post('/admin/board/store',               [AdminBoardController::class, 'store']);
$router->post('/admin/board/update/:id',          [AdminBoardController::class, 'update']);
$router->post('/admin/board/delete/:id',          [AdminBoardController::class, 'delete']);
$router->post('/admin/board/reorder',             [AdminBoardController::class, 'reorder']);

// --- ADMIN MEMBERSHIPS ---
$router->get('/admin/memberships',               [AdminMembershipController::class, 'index']);
$router->post('/admin/memberships/store',        [AdminMembershipController::class, 'store']);
$router->post('/admin/memberships/update/:id',   [AdminMembershipController::class, 'update']);
$router->post('/admin/memberships/delete/:id',   [AdminMembershipController::class, 'delete']);

// --- ADMIN SERVICES ---
$router->get('/admin/services',                  [AdminServiceController::class, 'index']);
$router->get('/admin/services/create',           [AdminServiceController::class, 'create']);
$router->post('/admin/services/store',           [AdminServiceController::class, 'store']);
$router->get('/admin/services/edit/:id',         [AdminServiceController::class, 'edit']);
$router->post('/admin/services/update/:id',      [AdminServiceController::class, 'update']);
$router->post('/admin/services/delete/:id',      [AdminServiceController::class, 'delete']);

// --- ADMIN TESTIMONIALS ---
$router->get('/admin/testimonials',               [AdminTestimonialController::class, 'index']);
$router->get('/admin/testimonials/create',        [AdminTestimonialController::class, 'create']);
$router->post('/admin/testimonials/store',        [AdminTestimonialController::class, 'store']);
$router->get('/admin/testimonials/edit/:id',      [AdminTestimonialController::class, 'edit']);
$router->post('/admin/testimonials/update/:id',   [AdminTestimonialController::class, 'update']);
$router->post('/admin/testimonials/toggle/:id',   [AdminTestimonialController::class, 'toggle']);
$router->post('/admin/testimonials/delete/:id',   [AdminTestimonialController::class, 'delete']);

// --- ADMIN GALLERY ---
$router->get('/admin/gallery',                      [AdminGalleryController::class, 'index']);
$router->get('/admin/gallery/categories',           [AdminGalleryController::class, 'categories']);
$router->post('/admin/gallery/store',               [AdminGalleryController::class, 'store']);
$router->post('/admin/gallery/update/:id',          [AdminGalleryController::class, 'update']);
$router->post('/admin/gallery/delete/:id',          [AdminGalleryController::class, 'delete']);
$router->post('/admin/gallery/categories/store',    [AdminGalleryController::class, 'storeCategory']);
$router->post('/admin/gallery/categories/update',   [AdminGalleryController::class, 'updateCategory']);
$router->post('/admin/gallery/categories/delete/:id',[AdminGalleryController::class,'deleteCategory']);

// --- ADMIN NEWS ---
$router->get('/admin/news',                     [AdminNewsController::class, 'index']);
$router->get('/admin/news/create',              [AdminNewsController::class, 'create']);
$router->post('/admin/news/store',              [AdminNewsController::class, 'store']);
$router->get('/admin/news/edit/:id',            [AdminNewsController::class, 'edit']);
$router->post('/admin/news/update',             [AdminNewsController::class, 'update']);
$router->post('/admin/news/delete/:id',         [AdminNewsController::class, 'delete']);
$router->post('/admin/news/toggle-status/:id',  [AdminNewsController::class, 'toggleStatus']);
$router->post('/admin/news/bulk-delete',        [AdminNewsController::class, 'bulkDelete']);
$router->post('/admin/news/bulk-status',        [AdminNewsController::class, 'bulkStatus']);

// --- ADMIN CONTACT ---
$router->get('/admin/contact',                  [AdminContactController::class, 'index']);
$router->post('/admin/contact/delete/:id',      [AdminContactController::class, 'delete']);
$router->post('/admin/contact/read/:id',        [AdminContactController::class, 'markRead']);
$router->post('/admin/contact/bulk-delete',     [AdminContactController::class, 'bulkDelete']);

// --- ADMIN PAYMENT ---
$router->get('/admin/payment',                  [AdminPaymentController::class, 'index']);
$router->post('/admin/payment/save-bank',       [AdminPaymentController::class, 'saveBank']);
$router->post('/admin/payment/save-upi',        [AdminPaymentController::class, 'saveUpi']);
$router->post('/admin/payment/save-qr',         [AdminPaymentController::class, 'saveQr']);

// --- ADMIN SEO ---
$router->get('/admin/seo',                      [AdminSeoController::class, 'index']);
$router->post('/admin/seo/save',                [AdminSeoController::class, 'save']);

// --- ADMIN SETTINGS ---
$router->get('/admin/settings',                 [AdminSettingsController::class, 'index']);
$router->get('/admin/appearance',               [AdminSettingsController::class, 'appearance']);
$router->post('/admin/settings/save',           [AdminSettingsController::class, 'save']);
$router->post('/admin/appearance/save',         [AdminSettingsController::class, 'saveAppearance']);

// --- ADMIN MENUS ---
$router->get('/admin/menus',                    [AdminMenuController::class, 'index']);
$router->post('/admin/menus/save',              [AdminMenuController::class, 'save']);

// --- ADMIN UPLOAD IMAGE (TinyMCE) ---
$router->post('/admin/upload-image',            [AdminController::class, 'uploadImage']);

// --- BOARD LEGACY ROUTES (support both /admin/board/editorial and /admin/board?type=editorial) ---
$router->get('/admin/board/editorial',         [AdminBoardLegacyController::class, 'editorial']);
$router->get('/admin/board/reviewer',          [AdminBoardLegacyController::class, 'reviewer']);
$router->get('/admin/board/editorial/add',     [AdminBoardLegacyController::class, 'addEditorial']);
$router->get('/admin/board/reviewer/add',      [AdminBoardLegacyController::class, 'addReviewer']);
$router->get('/admin/board/editorial/edit/:id', [AdminBoardLegacyController::class, 'editEditorial']);
$router->get('/admin/board/reviewer/edit/:id',  [AdminBoardLegacyController::class, 'editReviewer']);
$router->post('/admin/board/editorial/add',    [AdminBoardLegacyController::class, 'storeEditorial']);
$router->post('/admin/board/reviewer/add',     [AdminBoardLegacyController::class, 'storeReviewer']);
$router->post('/admin/board/editorial/edit/:id',  [AdminBoardLegacyController::class, 'updateEditorial']);
$router->post('/admin/board/reviewer/edit/:id',   [AdminBoardLegacyController::class, 'updateReviewer']);
$router->post('/admin/board/editorial/delete/:id',[AdminBoardLegacyController::class, 'deleteEditorial']);
$router->post('/admin/board/reviewer/delete/:id', [AdminBoardLegacyController::class, 'deleteReviewer']);
$router->post('/admin/board/editorial/reorder',   [AdminBoardLegacyController::class, 'reorderEditorial']);
$router->post('/admin/board/reviewer/reorder',    [AdminBoardLegacyController::class, 'reorderReviewer']);
$router->post('/admin/board/editorial/toggle/:id',[AdminBoardLegacyController::class, 'toggleEditorial']);
$router->post('/admin/board/reviewer/toggle/:id', [AdminBoardLegacyController::class, 'toggleReviewer']);

// --- ADMIN ALIAS ROUTES (compatibility with view URLs that use /add and /edit/:id) ---
// These map the URLs used by the views to existing controller actions.

// Journals
$router->get('/admin/journals/add',          [AdminJournalController::class, 'create']);
$router->post('/admin/journals/add',         [AdminJournalController::class, 'store']);
$router->get('/admin/journals/edit/:id',     [AdminJournalController::class, 'edit']);
$router->post('/admin/journals/edit/:id',    [AdminJournalController::class, 'update']);

// Memberships
$router->get('/admin/memberships/add',       [AdminMembershipController::class, 'create']);
$router->post('/admin/memberships/add',      [AdminMembershipController::class, 'store']);
$router->get('/admin/memberships/edit/:id',  [AdminMembershipController::class, 'edit']);
$router->post('/admin/memberships/edit/:id', [AdminMembershipController::class, 'update']);
$router->post('/admin/memberships/reorder',  [AdminMembershipController::class, 'reorder']);

// Services
$router->get('/admin/services/add',          [AdminServiceController::class, 'create']);
$router->post('/admin/services/add',         [AdminServiceController::class, 'store']);
$router->post('/admin/services/edit/:id',    [AdminServiceController::class, 'update']);
$router->post('/admin/services/reorder',     [AdminServiceController::class, 'reorder']);

// Gallery
$router->get('/admin/gallery/add',           [AdminGalleryController::class, 'create']);
$router->post('/admin/gallery/add',          [AdminGalleryController::class, 'store']);
$router->get('/admin/gallery/edit/:id',      [AdminGalleryController::class, 'edit']);
$router->post('/admin/gallery/edit/:id',     [AdminGalleryController::class, 'update']);

// News (bulk/toggle URL fix)
$router->post('/admin/news/bulk',            [AdminNewsController::class, 'bulkStatus']);
$router->post('/admin/news/toggle/:id',      [AdminNewsController::class, 'toggleStatus']);


// --- PAYMENT REMOVE QR ---
$router->post("/admin/payment/remove-qr", [AdminPaymentController::class, "removeQr"]);


// --- CONFERENCES (frontend) ---
$router->get('/conferences',        [ConferenceController::class, 'index']);
$router->get('/conference/:slug',   [ConferenceController::class, 'show']);

// --- CONFERENCES (admin) ---
$router->get('/admin/conferences',                    [AdminConferenceController::class, 'index']);
$router->get('/admin/conferences/add',                [AdminConferenceController::class, 'create']);
$router->post('/admin/conferences/add',               [AdminConferenceController::class, 'store']);
$router->get('/admin/conferences/edit/:id',           [AdminConferenceController::class, 'edit']);
$router->post('/admin/conferences/edit/:id',          [AdminConferenceController::class, 'update']);
$router->post('/admin/conferences/delete/:id',        [AdminConferenceController::class, 'delete']);
$router->post('/admin/conferences/toggle/:id',        [AdminConferenceController::class, 'toggle']);
$router->post('/admin/conferences/toggle-featured/:id',[AdminConferenceController::class, 'toggleFeatured']);

// --- MEMBERSHIP TYPES (frontend detailed application page) ---
$router->get('/membership/types',  [MembershipController::class, 'types']);
$router->get('/membership-types',  [MembershipController::class, 'types']);  // friendly alias

// --- MEMBERSHIP TYPES DETAILS (view-only, click cards to open modal) ---
$router->get('/membership/types-details', [MembershipController::class, 'typesDetails']);

// --- MEMBERSHIP INFO PAGES (CMS-driven) ---
$router->get('/membership/benefits', [PageController::class, 'membershipBenefits']);
$router->get('/membership/types-info', [PageController::class, 'membershipTypesInfo']);

// --- CMS PAGES (admin) ---
$router->get('/admin/pages',                 [AdminPageController::class, 'index']);
$router->get('/admin/pages/edit/:id',        [AdminPageController::class, 'edit']);
$router->post('/admin/pages/edit/:id',       [AdminPageController::class, 'update']);

// --- MEMBERSHIP TYPES (admin) ---
$router->get('/admin/membership-types',                 [AdminMembershipTypeController::class, 'index']);
$router->get('/admin/membership-types/add',             [AdminMembershipTypeController::class, 'create']);
$router->post('/admin/membership-types/add',            [AdminMembershipTypeController::class, 'store']);
$router->get('/admin/membership-types/edit/:id',        [AdminMembershipTypeController::class, 'edit']);
$router->post('/admin/membership-types/edit/:id',       [AdminMembershipTypeController::class, 'update']);
$router->post('/admin/membership-types/delete/:id',     [AdminMembershipTypeController::class, 'delete']);
$router->post('/admin/membership-types/toggle/:id',     [AdminMembershipTypeController::class, 'toggle']);

// --- MEMBERSHIP APPLICATION FORM (frontend) ---
$router->post('/membership/apply',      [MembershipController::class, 'apply']);
$router->get('/membership/thank-you',   [MembershipController::class, 'thankYou']);

// --- MEMBERSHIP APPLICATIONS (admin) ---
$router->get('/admin/applications',                  [AdminMembershipApplicationController::class, 'index']);
$router->get('/admin/applications/show/:id',         [AdminMembershipApplicationController::class, 'show']);
$router->post('/admin/applications/status/:id',      [AdminMembershipApplicationController::class, 'updateStatus']);
$router->get('/admin/applications/download/:id',     [AdminMembershipApplicationController::class, 'download']);
$router->post('/admin/applications/delete/:id',      [AdminMembershipApplicationController::class, 'delete']);

// --- ARTICLE SUBMISSIONS (public) ---
$router->get('/journals/submit/:id',        [ArticleController::class, 'submit']);
$router->get('/articles/submit',            [ArticleController::class, 'submit']);
$router->post('/articles/submit',           [ArticleController::class, 'store']);
$router->get('/articles/thank-you',         [ArticleController::class, 'thankYou']);

// --- ARTICLE SUBMISSIONS (admin) ---
$router->get('/admin/articles',                  [AdminArticleController::class, 'index']);
$router->get('/admin/articles/export',           [AdminArticleController::class, 'export']);
$router->get('/admin/articles/download/:id',     [AdminArticleController::class, 'download']);
$router->get('/admin/articles/show/:id',         [AdminArticleController::class, 'show']);
$router->get('/admin/articles/edit/:id',         [AdminArticleController::class, 'edit']);
$router->post('/admin/articles/save/:id',        [AdminArticleController::class, 'save']);
$router->post('/admin/articles/status/:id',      [AdminArticleController::class, 'updateStatus']);
$router->post('/admin/articles/delete/:id',      [AdminArticleController::class, 'delete']);
