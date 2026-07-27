<?php
// ============================================================
// HOME CONTROLLER
// ============================================================
class HomeController extends Controller {
    public function index(): void {
        $bookModel   = new BookModel();
        $featuredBooks = $bookModel->getFeatured(6);
        if (count($featuredBooks) < 3) $featuredBooks = $bookModel->getLatest(6);
        $journals     = (new JournalModel())->getActive(6);
        $latestNews   = (new NewsModel())->getPublished(3);
        $memberships  = (new MembershipModel())->getActive();
        $services     = (new ServiceModel())->getActive();
        $conference   = (new ConferenceModel())->getLatestActive();  // featured conference
        $editorialBoard = (new EditorialBoardModel())->getActive();  // editorial board for home page
        $testimonials  = (new TestimonialModel())->getActive(8);     // testimonials for home page
        $seo          = getSeo('home');
        $this->view('pages/home', compact('featuredBooks', 'journals', 'latestNews', 'memberships', 'services', 'conference', 'editorialBoard', 'testimonials', 'seo'));
    }
}

// ============================================================
// BOOK CONTROLLER
// ============================================================
class BookController extends Controller {
    private BookModel $model;
    public function __construct() { $this->model = new BookModel(); }

    public function index(): void {
        $search  = Security::clean($_GET['q'] ?? '');
        $page    = max(1, (int)($_GET['page'] ?? 1));
        $total   = $this->model->count('is_published = 1' . ($search ? ' AND (title LIKE ? OR authors LIKE ?)' : ''), $search ? ["%$search%", "%$search%"] : []);
        $pag     = $this->paginate($total, BOOKS_PER_PAGE, $page);
        $books   = $this->model->getPublished(BOOKS_PER_PAGE, $pag['offset'], $search);
        $seo     = getSeo('books');
        $this->view('pages/books', compact('books', 'pag', 'search', 'seo', 'total'));
    }

    public function show(string $slug): void {
        $book = $this->model->getBySlug($slug);
        // 404 if book missing OR explicitly unpublished
        if (!$book || (isset($book['is_published']) && (int)$book['is_published'] === 0)) {
            http_response_code(404);
            $this->view('pages/404', ['seo' => ['page_title' => '404 Not Found']]);
            return;
        }
        $this->model->update(['views' => ($book['views'] ?? 0) + 1], 'id = ?', [$book['id']]);
        $related = $this->model->findAll('category = ? AND id != ? AND is_published = 1', [$book['category'], $book['id']], 'created_at DESC', 4);
        $seo     = ['page_title' => ($book['meta_title'] ?: $book['title']), 'meta_description' => ($book['meta_description'] ?: truncate($book['description'] ?? '', 160))];
        $this->view('pages/book-detail', compact('book', 'related', 'seo'));
    }

    public function conferenceAbstractBook(): void {
        $seo = [
            'page_title'       => 'Conference Abstract Book',
            'meta_description' => 'International Conference Abstract Book published by Rainbow Publications.',
        ];
        $this->view('pages/conference-abstract-book', compact('seo'));
    }
}

// ============================================================
// JOURNAL CONTROLLER
// ============================================================
class JournalController extends Controller {
    public function index(): void {
        $journals = (new JournalModel())->getActive();
        $seo      = getSeo('journals');
        $this->view('pages/journals', compact('journals', 'seo'));
    }
}

// ============================================================
// MEMBERSHIP CONTROLLER
// ============================================================
class MembershipController extends Controller {
    public function index(): void {
        $memberships = (new MembershipModel())->getActive();
        $payment     = (new PaymentModel())->getActive();
        $seo         = getSeo('membership');
        $this->view('pages/membership', compact('memberships', 'payment', 'seo'));
    }

    /**
     * /membership/types — membership application form (SPER-style)
     */
    public function types(): void {
        $types   = (new MembershipTypeModel())->getActive();
        $payment = (new PaymentModel())->getActive();
        $seo     = [
            'page_title'       => 'Membership Application | ' . APP_NAME,
            'meta_description' => 'Apply for membership — fill the application form online.',
        ];
        $this->view('pages/membership-types', compact('types', 'payment', 'seo'));
    }

    /**
     * /membership/types-details — detailed view of all membership types with
     * card UI and click-to-open modal. No form redirect.
     */
    public function typesDetails(): void {
        $seo = [
            'page_title'       => 'Types of Membership — Detailed View | ' . APP_NAME,
            'meta_description' => 'Explore every membership category offered by Rainbow Publications — Honorary, Patron, Institutional, Life, Senior, International and Student — with full eligibility and benefits.',
        ];
        $this->view('pages/membership-types-details', compact('seo'));
    }

    /**
     * POST /membership/apply — handle multi-variant application form submission
     */
    public function apply(): void {
        $this->csrfCheck();

        // Required regardless of type
        $typeId = (int)($_POST['membership_type_id'] ?? 0);
        if ($typeId <= 0) {
            $this->json(['success' => false, 'message' => 'Please select a membership type.']);
            return;
        }
        if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone'])) {
            $this->json(['success' => false, 'message' => 'Name, email and mobile are required.']);
            return;
        }
        if (empty($_POST['agreement'])) {
            $this->json(['success' => false, 'message' => 'You must accept the terms to proceed.']);
            return;
        }
        $email = Security::clean($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->json(['success' => false, 'message' => 'Please enter a valid email address.']);
            return;
        }

        // Resolve membership type
        $type = (new MembershipTypeModel())->findById($typeId);
        if (!$type) {
            $this->json(['success' => false, 'message' => 'Invalid membership type selected.']);
            return;
        }

        // Honorary nominations have different validation (no payment; nominee info required)
        $isHonorary = (($type['slug'] ?? '') === 'honorary') || !empty($_POST['is_honorary']);
        if ($isHonorary) {
            if (empty($_POST['fd']['nominee_name']) || empty($_POST['fd']['justification'])) {
                $this->json(['success' => false, 'message' => 'Nominee name and justification are required for nominations.']);
                return;
            }
            if (strlen(trim($_POST['fd']['justification'])) < 100) {
                $this->json(['success' => false, 'message' => 'Justification must be at least 100 characters.']);
                return;
            }
        }

        // Senior-specific eligibility check: age must be >= 60
        if (($type['slug'] ?? '') === 'life-senior' && !empty($_POST['dob'])) {
            $age = (int)((time() - strtotime($_POST['dob'])) / (365.25 * 86400));
            if ($age < 60) {
                $this->json(['success' => false, 'message' => 'Senior Life Membership requires applicant age of 60 years or above.']);
                return;
            }
        }

        // Handle file uploads — variant has its own file fields under files[<key>]
        $uploadedFiles = [];
        $failedFiles   = [];
        $allowedDocs   = array_merge(ALLOWED_IMAGE_TYPES, ['application/pdf']);
        if (!empty($_FILES['files']['name']) && is_array($_FILES['files']['name'])) {
            foreach ($_FILES['files']['name'] as $key => $name) {
                if (empty($name)) continue;
                $fileErr  = isset($_FILES['files']['error'][$key])  ? (int)$_FILES['files']['error'][$key]  : UPLOAD_ERR_NO_FILE;
                $fileSize = isset($_FILES['files']['size'][$key])   ? (int)$_FILES['files']['size'][$key]   : 0;
                $fileData = [
                    'name'     => $name,
                    'type'     => $_FILES['files']['type'][$key]     ?? '',
                    'tmp_name' => $_FILES['files']['tmp_name'][$key]  ?? '',
                    'error'    => $fileErr,
                    'size'     => $fileSize,
                ];
                if ($fileErr === UPLOAD_ERR_NO_FILE || $fileSize === 0) continue;
                if ($fileErr !== UPLOAD_ERR_OK) {
                    $failedFiles[] = $key . ' (upload error ' . $fileErr . ')';
                    continue;
                }
                // Photos go in /photos, everything else in /docs
                $subdir  = ($key === 'photo' || $key === 'logo') ? 'applications/photos' : 'applications/docs';
                $allowed = ($key === 'photo' || $key === 'logo') ? ALLOWED_IMAGE_TYPES : $allowedDocs;
                $fn = uploadFile($fileData, $subdir, $allowed);
                if ($fn) {
                    $uploadedFiles[$key] = $fn;
                } else {
                    $failedFiles[] = $key;
                }
            }
        }

        // form_data collects type-specific fields (fd[...] in POST)
        $formData = [];
        if (!empty($_POST['fd']) && is_array($_POST['fd'])) {
            foreach ($_POST['fd'] as $k => $v) {
                $formData[Security::clean($k)] = is_string($v) ? Security::clean($v) : $v;
            }
        }

        // Compute fees server-side (do not trust client)
        if ($isHonorary) {
            // Honorary is nomination-based — no fees
            $feeNum = 0.0; $gst = 0.0; $txn = 0.0; $total = 0.0;
        } else {
            $feeNum   = (float)preg_replace('/[^0-9.]/', '', $type['fee_label'] ?? '0');
            $currency = stripos($type['fee_label'] ?? '', 'USD') !== false ? 'USD' : 'INR';
            $gst      = $currency === 'USD' ? 0 : round($feeNum * 0.18);
            $txn      = round($feeNum * 0.02);
            $total    = $feeNum + $gst + $txn;
        }

        $data = [
            'membership_type_id'   => $typeId,
            'membership_type_name' => $type['title'],
            'name'                 => Security::clean($_POST['name']),
            'dob'                  => !empty($_POST['dob']) ? $_POST['dob'] : null,
            'blood_group'          => Security::clean($_POST['blood_group'] ?? ''),
            'sex'                  => Security::clean($_POST['sex'] ?? ''),
            'email'                => $email,
            'nationality'          => Security::clean($_POST['nationality'] ?? ''),
            'phone'                => Security::clean($_POST['phone']),
            'address'              => Security::clean($_POST['address'] ?? ''),
            'city'                 => Security::clean($_POST['city'] ?? ''),
            'state'                => Security::clean($_POST['state'] ?? ''),
            'country'              => Security::clean($_POST['country'] ?? ''),
            'zip_code'             => Security::clean($_POST['zip_code'] ?? ''),
            'specialization'       => Security::clean($_POST['specialization'] ?? ''),
            'designation'          => Security::clean($_POST['designation'] ?? ''),
            'college'              => Security::clean($_POST['college'] ?? ''),
            'photo'                => $uploadedFiles['photo'] ?? null,
            'form_data'            => json_encode($formData, JSON_UNESCAPED_UNICODE),
            'uploaded_files'       => json_encode($uploadedFiles, JSON_UNESCAPED_UNICODE),
            'fee_amount'           => $feeNum,
            'gst_amount'           => $gst,
            'transaction_charges'  => $txn,
            'total_amount'         => $total,
            'txn_receipt_file'     => $isHonorary ? null : ($uploadedFiles['transaction_receipt'] ?? null),
            'status'               => 'pending',
            'ip_address'           => $_SERVER['REMOTE_ADDR'] ?? '',
        ];

        try {
            $id = (new MembershipApplicationModel())->insert($data);
        } catch (\Throwable $e) {
            // Roll back any files we already moved so we don't leave orphans
            foreach ($uploadedFiles as $key => $fn) {
                if (empty($fn)) continue;
                $subdir = ($key === 'photo' || $key === 'logo') ? 'applications/photos' : 'applications/docs';
                deleteFile($subdir . '/' . $fn);
            }
            error_log('Membership application insert failed: ' . $e->getMessage());
            $this->json(['success' => false, 'message' => 'Could not save your application. Please try again or contact support.']);
            return;
        }

        $message = $isHonorary
            ? 'Nomination submitted successfully! The Editorial Board reviews nominations quarterly.'
            : 'Application submitted successfully! Our team will contact you within 3-5 business days.';
        $warning = null;
        if (!empty($failedFiles)) {
            $warning = 'Some files were not uploaded: ' . implode(', ', $failedFiles) . '. Please verify file type/size and re-submit if needed.';
        }

        $this->json([
            'success' => true,
            'message' => $message,
            'warning' => $warning,
            'id'      => $id,
        ]);
    }

    public function thankYou(): void {
        $seo = ['page_title' => 'Thank You | ' . APP_NAME, 'meta_description' => 'Your membership application has been received.'];
        $this->view('pages/membership-thank-you', compact('seo'));
    }
}

// ============================================================
// SERVICE CONTROLLER
// ============================================================
class ServiceController extends Controller {
    private ServiceModel $model;
    public function __construct() { $this->model = new ServiceModel(); }

    public function index(): void {
        $services = $this->model->getActive();
        $seo      = getSeo('services');
        $this->view('pages/services', compact('services', 'seo'));
    }

    public function show(string $slug): void {
        $service = $this->model->getBySlug($slug);
        if (!$service) { http_response_code(404); $this->view('pages/404', ['seo' => ['page_title' => '404 Not Found']]); return; }
        $others = $this->model->findAll('is_active = 1 AND id != ?', [$service['id']], 'sort_order ASC');
        $seo    = ['page_title' => ($service['meta_title'] ?: $service['title']), 'meta_description' => ($service['meta_description'] ?? '')];
        $this->view('pages/service-detail', compact('service', 'others', 'seo'));
    }
}

// ============================================================
// GALLERY CONTROLLER
// ============================================================
class GalleryController extends Controller {
    public function index(): void {
        $catId    = (int)($_GET['cat'] ?? 0);
        $model    = new GalleryModel();
        $catModel = new GalleryCategoryModel();
        $items    = $model->getActiveWithCategory($catId);
        $cats     = $catModel->getActive();
        $seo      = getSeo('gallery');
        $this->view('pages/gallery', compact('items', 'cats', 'catId', 'seo'));
    }
}

// ============================================================
// CONTACT CONTROLLER
// ============================================================
class ContactController extends Controller {
    public function index(): void {
        $seo = getSeo('contact');
        $services = (new ServiceModel())->getActive();
        $this->view('pages/contact', compact('seo', 'services'));
    }

    public function send(): void {
        // Honeypot
        if (!empty($_POST['website'])) {
            jsonResponse(['success' => true, 'message' => 'Thank you!']);
        }
        $token = $_POST['csrf_token'] ?? '';
        if (!Security::validateCsrf($token)) {
            jsonResponse(['success' => false, 'message' => 'Invalid token.'], 403);
        }
        $name    = Security::clean($_POST['name'] ?? '');
        $email   = Security::clean($_POST['email'] ?? '');
        $phone   = Security::clean($_POST['phone'] ?? '');
        $subject = Security::clean($_POST['subject'] ?? '');
        $message = Security::clean($_POST['message'] ?? '');

        if (!$name || !$email || !$message) {
            jsonResponse(['success' => false, 'message' => 'Please fill all required fields.']);
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            jsonResponse(['success' => false, 'message' => 'Invalid email address.']);
        }
        (new ContactModel())->insert([
            'name'       => $name,
            'email'      => $email,
            'phone'      => $phone,
            'subject'    => $subject,
            'message'    => $message,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '',
        ]);
        jsonResponse(['success' => true, 'message' => 'Your message has been sent successfully! We\'ll get back to you soon.']);
    }
}

// ============================================================
// PAGE CONTROLLER
// ============================================================
class PageController extends Controller {
    public function about(): void {
        $editorialBoard = (new EditorialBoardModel())->getActive();
        $reviewerBoard  = (new ReviewerBoardModel())->getActive();
        $payment        = (new PaymentModel())->getActive();
        $seo            = getSeo('about');
        $this->view('pages/about', compact('editorialBoard', 'reviewerBoard', 'payment', 'seo'));
    }

    public function editorialBoard(): void {
        $editorialBoard = (new EditorialBoardModel())->getActive();
        $payment        = (new PaymentModel())->getActive();
        $seo            = ['page_title' => 'Editorial Board | ' . APP_NAME, 'meta_description' => 'Meet our editorial board members.'];
        $this->view('pages/editorial-board', compact('editorialBoard', 'payment', 'seo'));
    }

    public function reviewerBoard(): void {
        $reviewerBoard = (new ReviewerBoardModel())->getActive();
        $payment       = (new PaymentModel())->getActive();
        $seo           = ['page_title' => 'Reviewer Board | ' . APP_NAME, 'meta_description' => 'Meet our reviewer board members.'];
        $this->view('pages/reviewer-board', compact('reviewerBoard', 'payment', 'seo'));
    }

    public function policiesIndex(): void {
        $seo = getSeo('policies');
        if (empty($seo['page_title'])) {
            $seo = [
                'page_title'       => 'Policies | ' . APP_NAME,
                'meta_description' => 'Privacy, cancellation & refund, and shipping policies for ' . APP_NAME . '.',
            ];
        }
        $this->view('pages/policies/index', compact('seo'));
    }

    public function privacyPolicy(): void {
        $pageTitle   = 'Privacy Policy';
        $lastUpdated = 'June 5, 2026';
        $intro       = 'Your privacy is important to us. This policy explains how Rainbow Publications collects and uses your information.';
        $seo         = [
            'page_title'       => $pageTitle . ' | ' . APP_NAME,
            'meta_description' => 'Read our privacy policy to understand how we handle your personal data and protect your information.',
        ];
        $sections = [
            [
                'title' => 'Privacy Policy',
                'paragraphs' => [
                    'At Rainbow Publications, protecting your privacy and securing your personal information is our top priority. We collect personal details such as your name, email address, and payment information solely to process orders, communicate important updates about our publications and events, and enhance our services. We do not share, sell, or trade your information with third parties without your explicit permission, except when required to fulfill orders or when working with trusted partners bound by strict confidentiality agreements. We implement industry-standard security measures to protect your data and provide you the right to access, update, or delete your personal information at any time. By using our services, you agree to our privacy practices, and we welcome you to reach out to us with any questions or concerns about your data.

',
                ],
            ],
        ];
        $this->view('pages/policy-page', compact('pageTitle', 'lastUpdated', 'intro', 'seo', 'sections'));
    }

    public function cancellationRefund(): void {
        $pageTitle   = 'Cancellation and Refund Policy';
        $lastUpdated = 'July 25, 2026';
        $intro       = 'Please read this policy carefully before purchasing publications, memberships, or paid academic services.';
        $seo         = [
            'page_title'       => $pageTitle . ' | ' . APP_NAME,
            'meta_description' => 'Cancellation and refund terms for publications, memberships, and paid services at ' . APP_NAME . '.',
        ];
        $sections = [
            [
                'title' => 'Cancellation and Refund Policy',
                'paragraphs' => [
                    'At Rainbow Publications, we strive to ensure complete customer satisfaction with every purchase. Orders can be canceled within 24 hours of placement, provided they have not yet been processed or shipped. Once an order has been shipped, cancellation may no longer be possible. If you receive a damaged, defective, or incorrect item, please contact us within 7 days of delivery to request a full refund or replacement. For digital products (e.g., e-books), refunds are not available once the purchase is completed and the product has been downloaded. To request a cancellation or refund, please contact our customer support team with your order information. Approved refunds will be issued to the original payment method, which may take 7–10 business days to reflect. Please note that shipping costs are non-refundable, and customers are responsible for return shipping fees unless the return is due to an error on our part.

',
                ],
            ],
            
        ];
        $this->view('pages/policy-page', compact('pageTitle', 'lastUpdated', 'intro', 'seo', 'sections'));
    }

    public function shippingDelivery(): void {
        $pageTitle   = 'Shipping and Delivery';
        $lastUpdated = 'July 25 , 2026';
        $intro       = 'Details on how we deliver books, certificates, and digital publication materials.';
        $seo         = [
            'page_title'       => $pageTitle . ' | ' . APP_NAME,
            'meta_description' => 'Shipping and delivery information for books, certificates, and digital materials from ' . APP_NAME . '.',
        ];
        $sections = [
            [
                'title' => 'Shipping and Delivery',
                'paragraphs' => [
                    'At Rainbow Publications, we strive to ensure that your orders are processed and delivered efficiently. We offer both domestic and international shipping, with delivery times varying based on location. Orders are typically processed within 1-3 business days after payment confirmation, and you will receive an order confirmation email with an estimated delivery time. Domestic shipping generally takes 5-7 business days, while international orders may take 10-15 business days, depending on the destination and customs procedures.

Shipping costs are calculated based on the weight of the order and the delivery address, and these charges will be displayed at checkout. Once your order is shipped, you will receive a tracking number to monitor its progress. If there are any issues with delivery or if you do not receive your order within the expected timeframe, please contact us, and we will work to resolve the issue promptly. Please ensure your shipping details are accurate, as we are not responsible for delays or delivery failures due to incorrect address information.',
                ],
            ],
           
        ];
        $this->view('pages/policy-page', compact('pageTitle', 'lastUpdated', 'intro', 'seo', 'sections'));
    }

    public function compliancePolicy(): void {
        $pageTitle   = 'Compliance Policy';
        $lastUpdated = 'July 25 , 2026';
        $intro       = 'Our commitment to ethical publishing, academic integrity, and regulatory compliance.';
        $parentCrumb = ['label' => 'About Us', 'url' => BASE_URL . '/about'];
        $seo         = [
            'page_title'       => $pageTitle . ' | ' . APP_NAME,
            'meta_description' => 'Compliance and ethical publishing standards followed by ' . APP_NAME . '.',
        ];
        $sections = [
    [
        'title' => 'Mission and Values',
        'paragraphs' => [
            'Rainbow Publications is dedicated to supporting academic and scholarly endeavors by providing high-quality editorial services, publishing platforms, and intellectual property protection. We uphold the values of integrity, excellence, and innovation in everything we do.',
        ],
    ],
    [
        'title' => 'Services Offered',
        'paragraphs' => [
            'Rainbow Publications offers a range of services to authors, researchers, and institutions, including:',
        ],
        'list' => [
            'Thesis and Dissertation Writing Services: We provide guidance, editing, and writing support for students completing thesis and dissertation projects.',
            'Journal Selection and Publication Support: We assist researchers in selecting appropriate journals for their work and guide them through the submission process.',
            'Book Publication and Writing Services: We offer comprehensive editorial, design, and marketing services for book authors.',
            'Intellectual Property Services: We assist with patent applications, copyright registration, and design protection.',
            'Writing Services (e.g., Reviews, Research Proposals): We provide editing, proofreading, and writing support for various academic and professional documents.',
            'Plagiarism Checking Service: We offer plagiarism detection using industry-leading software.',
            'Conference Proceedings Publication: We publish conference proceedings in our esteemed peer-reviewed journals.',
        ],
    ],
    [
        'title' => 'Client Confidentiality',
        'paragraphs' => [
            'Rainbow Publications maintains strict confidentiality regarding all client information, research materials, and manuscripts entrusted to us. We will not share this information with any third party without explicit written consent from the client.',
        ],
    ],
    [
        'title' => 'Editorial Standards',
        'paragraphs' => [
            'Rainbow Publications adheres to the highest ethical and academic standards. We employ experienced editors with expertise in various disciplines to ensure the integrity, clarity, and accuracy of all our publications. We follow established style guides and best practices in editing and proofreading.',
        ],
    ],
    [
        'title' => 'Author Rights and Permissions',
        'paragraphs' => [
            'Authors retain full copyright ownership of their work published through Rainbow Publications. We require authors to obtain and disclose any necessary permissions for copyrighted materials used within their work.',
        ],
    ],
    [
        'title' => 'Plagiarism Policy',
        'paragraphs' => [
            'Rainbow Publications has a zero-tolerance policy for plagiarism. Submitted manuscripts will be screened for plagiarism using industry-standard software. Authors are responsible for ensuring the originality of their work. We reserve the right to reject manuscripts with evidence of plagiarism.',
        ],
    ],
    [
        'title' => 'Pricing and Payment',
        'paragraphs' => [
            'Rainbow Publications offers transparent pricing structures for all our services. We provide detailed quotes outlining the scope of work and associated fees before any service commences. We accept various payment methods to ensure convenience for our clients.',
        ],
    ],
    [
        'title' => 'Refund and Cancellation Policy',
        'paragraphs' => [
            'Rainbow Publications offers a refund policy for specific services under certain conditions. We encourage clients to review our detailed refund and cancellation policy before engaging our services.',
        ],
    ],
    [
        'title' => 'Disclaimer',
        'paragraphs' => [
            'Rainbow Publications strives to provide accurate and up-to-date information and services. However, we cannot guarantee the accuracy or completeness of any information provided. Authors are responsible for ensuring the accuracy and validity of their work. Rainbow Publications is not liable for any damages arising from the use of our services or information.',
        ],
    ],
    [
        'title' => 'Dispute Resolution',
        'paragraphs' => [
            'Any disputes arising from this policy or related to services provided by Rainbow Publications will be resolved through mediation or arbitration in accordance with the laws of India.',
        ],
    ],
    [
        'title' => 'Updates and Revisions',
        'paragraphs' => [
            'Rainbow Publications reserves the right to update and revise this policy at any time. We will notify our clients of any significant changes made to this policy.',
        ],
    ],
    [
        'title' => 'Contact Information',
        'paragraphs' => [
            'For questions or concerns regarding this policy or our services, please contact Rainbow Publications.',
        ],
        'list' => [
            'Email: contact@rainbowpublications.com',
            'Phone: +91 7093319332',
        ],
    ],
];
        $this->view('pages/policy-page', compact('pageTitle', 'lastUpdated', 'intro', 'seo', 'sections', 'parentCrumb'));
    }

    public function termsConditions(): void {
        $pageTitle   = 'Terms & Conditions';
        $lastUpdated = 'June 5, 2026';
        $intro       = 'Please read these terms carefully before using our website and services.';
        $parentCrumb = ['label' => 'About Us', 'url' => BASE_URL . '/about'];
        $seo         = [
            'page_title'       => $pageTitle . ' | ' . APP_NAME,
            'meta_description' => 'Terms and conditions for using ' . APP_NAME . ' website and academic publishing services.',
        ];
        $sections = [
    [
        'title' => 'Introduction',
        'paragraphs' => [
            'These Terms and Conditions (“Terms”) govern the use of the Rainbow Publications website (contact@rainbowpublications.com) and the services offered by Rainbow Publications (“Rainbow Publications,” “we,” or “us”). By accessing or using the Website or any of our services, you (“you” or “Client”) agree to be bound by these Terms.',
        ],
    ],
    [
        'title' => 'Services',
        'paragraphs' => [
            'Rainbow Publications offers a range of services for authors, researchers, and institutions, including:',
        ],
        'list' => [
            'Thesis and Dissertation Writing Services',
            'Journal Selection and Publication Support',
            'Book Publication and Writing Services',
            'Intellectual Property Services (patent applications, copyright registration, design protection)',
            'Writing Services (reviews, research proposals, etc.)',
            'Plagiarism Checking Service',
            'Conference Proceedings Publication',
        ],
    ],
    [
        'title' => 'Client Representations and Warranties',
        'paragraphs' => [
            'You represent and warrant that:',
        ],
        'list' => [
            'You are of legal age to enter into a binding contract.',
            'You have the full right, power, and authority to enter into these Terms and use the services.',
            'All information you provide to Rainbow Publications is accurate, complete, and up-to-date.',
            'You possess all necessary rights and permissions for any materials (e.g., research data, copyrighted content) included in your work submitted to Rainbow Publications.',
        ],
    ],
    [
        'title' => 'Client Responsibilities',
        'paragraphs' => [
            'You are responsible for:',
        ],
        'list' => [
            'Providing clear and detailed instructions for your desired services.',
            'Supplying Rainbow Publications with all necessary research materials, data, and references.',
            'Offering timely feedback on drafts and revisions.',
            'Approving the final product before publication or submission.',
        ],
    ],
    [
        'title' => 'Intellectual Property',
        'paragraphs' => [
            'Clients retain copyright ownership of their creative work (e.g., thesis, book manuscript) produced through Rainbow Publications’s services. Rainbow Publications reserves ownership of all intellectual property rights associated with its services and methodologies.',
        ],
    ],
    [
        'title' => 'Confidentiality',
        'paragraphs' => [
            'Both parties agree to maintain the confidentiality of all information received from the other party in connection with these Terms and the services. This includes, but is not limited to, research data, manuscripts, and client information.',
        ],
    ],
    [
        'title' => 'Disclaimer',
        'paragraphs' => [
            'Rainbow Publications provides services with the utmost care and professionalism. However, we do not guarantee the originality or accuracy of the content within client work. Authors are ultimately responsible for ensuring the accuracy and validity of their research and writing. Rainbow Publications makes no warranties, express or implied, regarding the outcome or success of any service, including publication acceptance.',
        ],
    ],
    [
        'title' => 'Limitation of Liability',
        'paragraphs' => [
            'Rainbow Publications is not liable for any indirect, incidental, consequential, or special damages arising from the use of our services or information on the Website. Our liability is limited to the total amount paid by the Client for the specific service in question.',
        ],
    ],
    [
        'title' => 'Termination',
        'paragraphs' => [
            'These Terms may be terminated by either party upon written notice to the other in the event of a material breach that is not cured within 7 days of written notice.',
        ],
    ],
    [
        'title' => 'Dispute Resolution',
        'paragraphs' => [
            'Any dispute arising out of or relating to these Terms shall be settled by binding arbitration in accordance with the laws of India.',
        ],
    ],
    [
        'title' => 'Entire Agreement',
        'paragraphs' => [
            'These Terms constitute the entire agreement between the parties with respect to the subject matter hereof and supersede all prior or contemporaneous communications, representations, or agreements, whether oral or written.',
        ],
    ],
    [
        'title' => 'Governing Law',
        'paragraphs' => [
            'These Terms shall be governed by and construed in accordance with the laws of India.',
        ],
    ],
    [
        'title' => 'Updates to Terms and Conditions',
        'paragraphs' => [
            'Rainbow Publications reserves the right to update and revise these Terms at any time. We will notify users of any significant changes by posting the updated Terms on the Website. Your continued use of the Website or our services following the posting of revised Terms constitutes your acceptance of the changes.',
        ],
    ],
    [
        'title' => 'Contact Information',
        'paragraphs' => [
            'For questions or concerns regarding these Terms, please contact Rainbow Publications.',
        ],
        'list' => [
            'Email: contact@rainbowpublications.com',
            'Phone: +91 7093319332',
        ],
    ],
];
        $this->view('pages/policy-page', compact('pageTitle', 'lastUpdated', 'intro', 'seo', 'sections', 'parentCrumb'));
    }

    public function paymentDetails(): void {
        $payment = (new PaymentModel())->getActive();
        $seo     = [
    [
        'title' => 'Payment Details',
        'paragraphs' => [
            'Below are the official bank account details for Rainbow Publications payments.',
        ],
        'list' => [
            'Account Holder Name: Global Rainbow Publications Ventures LLP',
            'Account Number: xxxxxxxxxxxxxxxx',
            'IFSC Code: xxxxxxxxxxxxxxxx',
        ],
    ],
];
        $this->view('pages/payment-details', compact('payment', 'seo'));
    }

    /**
     * /membership/benefits — Benefit of Membership page (CMS-driven)
     */
    public function membershipBenefits(): void {
        $page  = (new PageModel())->getBySlug('benefit-of-membership');
        $seo   = [
            'page_title'       => 'Benefit of Membership | ' . APP_NAME,
            'meta_description' => 'Discover the exclusive benefits of Rainbow Publications membership for researchers and institutions.',
        ];
        $this->view('pages/cms-page', compact('page', 'seo'));
    }

    /**
     * /membership/types-info — Types of Membership (informational CMS page)
     */
    public function membershipTypesInfo(): void {
        $page  = (new PageModel())->getBySlug('types-of-membership');
        $seo   = [
            'page_title'       => 'Types of Membership | ' . APP_NAME,
            'meta_description' => 'Explore the different membership categories offered by Rainbow Publications.',
        ];
        $this->view('pages/cms-page', compact('page', 'seo'));
    }
}

// ============================================================
// NEWS CONTROLLER
// ============================================================
class NewsController extends Controller {
    private NewsModel $model;
    public function __construct() { $this->model = new NewsModel(); }

    public function index(): void {
        $search = Security::clean($_GET['q'] ?? '');
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $where  = "status = 'published'";
        $params = [];
        if ($search !== '') {
            $where   .= ' AND (title LIKE ? OR excerpt LIKE ?)';
            $params  = ["%$search%", "%$search%"];
        }
        $total  = $this->model->count($where, $params);
        $pag    = $this->paginate($total, NEWS_PER_PAGE, $page);
        $news   = $this->model->getPublished(NEWS_PER_PAGE, $pag['offset'], $search);
        $seo    = getSeo('news');
        $this->view('pages/news', compact('news', 'pag', 'search', 'seo', 'total'));
    }

    public function show(string $slug): void {
        $article = $this->model->getBySlug($slug);
        if (!$article) { http_response_code(404); $this->view('pages/404', ['seo' => ['page_title' => '404 Not Found']]); return; }
        $this->model->update(['views' => $article['views'] + 1], 'id = ?', [$article['id']]);
        $recent = $this->model->getPublished(5);
        $seo    = ['page_title' => ($article['meta_title'] ?: $article['title']), 'meta_description' => ($article['meta_description'] ?? '')];
        $this->view('pages/news-detail', compact('article', 'recent', 'seo'));
    }
}


// ============================================================
// CONFERENCE CONTROLLER (frontend)
// ============================================================
class ConferenceController extends Controller {
    private ConferenceModel $model;
    public function __construct() { $this->model = new ConferenceModel(); }

    /**
     * /conferences  →  full list (past + current)
     */
    public function index(): void {
        $conferences = $this->model->getActive();
        $latest      = $this->model->getLatestActive();
        $seo = [
            'page_title'       => 'Conferences | ' . APP_NAME,
            'meta_description' => 'Browse upcoming and past conferences hosted by ' . APP_NAME,
        ];
        $this->view('pages/conferences', compact('conferences', 'latest', 'seo'));
    }

    /**
     * /conference/:slug  →  single conference detail
     */
    public function show(string $slug): void {
        $conference = $this->model->getBySlug($slug);
        if (!$conference) {
            http_response_code(404);
            $this->view('pages/404', ['seo' => ['page_title' => 'Conference Not Found']]);
            return;
        }
        $seo = [
            'page_title'       => ($conference['meta_title'] ?: $conference['title']) . ' | ' . APP_NAME,
            'meta_description' => $conference['meta_description'] ?? '',
        ];
        $this->view('pages/conference-detail', compact('conference', 'seo'));
    }
}


// ============================================================
// ARTICLE SUBMISSION CONTROLLER (public)
// ============================================================
class ArticleController extends Controller {

    /**
     * GET /journals/submit/:id  (or /articles/submit?journal=ID)
     * Show the submit-article form for a journal.
     */
    public function submit(?string $id = null): void {
        $journalModel = new JournalModel();
        $journals     = $journalModel->getActive();
        $preselected  = null;
        if ($id) {
            $preselected = $journalModel->findById((int)$id);
        }
        $seo = [
            'page_title'       => 'Submit Article | ' . APP_NAME,
            'meta_description' => 'Submit your research article to one of our peer-reviewed journals.',
        ];
        $this->view('pages/article-submit', compact('journals', 'preselected', 'seo'));
    }

    /**
     * POST /articles/submit  — handle submission
     */
    public function store(): void {
        $this->csrfCheck();

        // Validate required fields
        $journalId = (int)($_POST['journal_id'] ?? 0);
        if ($journalId <= 0) {
            $this->json(['success' => false, 'message' => 'Please select a journal.']);
            return;
        }
        if (empty($_POST['section'])) {
            $this->json(['success' => false, 'message' => 'Section is required.']);
            return;
        }
        if (empty($_POST['title'])) {
            $this->json(['success' => false, 'message' => 'Title is required.']);
            return;
        }
        if (empty($_POST['abstract'])) {
            $this->json(['success' => false, 'message' => 'Abstract is required.']);
            return;
        }
        if (empty($_POST['submitter_name']) || empty($_POST['submitter_email'])
            || empty($_POST['submitter_affiliation']) || empty($_POST['submitter_mobile'])) {
            $this->json(['success' => false, 'message' => 'Contact Person: name, email, affiliation and mobile are required.']);
            return;
        }
        $submitterEmail = Security::clean($_POST['submitter_email']);
        if (!filter_var($submitterEmail, FILTER_VALIDATE_EMAIL)) {
            $this->json(['success' => false, 'message' => 'Please enter a valid submitter email.']);
            return;
        }

        // Resolve journal
        $journal = (new JournalModel())->findById($journalId);
        if (!$journal) {
            $this->json(['success' => false, 'message' => 'Invalid journal selected.']);
            return;
        }

        // Parse contributors JSON
        $contributors = json_decode($_POST['contributors'] ?? '[]', true) ?: [];
        if (empty($contributors)) {
            $this->json(['success' => false, 'message' => 'Add at least one contributor.']);
            return;
        }
        // Sanitize each contributor
        $cleanContribs = [];
        foreach ($contributors as $c) {
            if (empty($c['name']) || empty($c['affiliation']) || empty($c['email']) || empty($c['phone'])) {
                $this->json(['success' => false, 'message' => 'All contributor fields are required.']);
                return;
            }
            if (!filter_var($c['email'], FILTER_VALIDATE_EMAIL)) {
                $this->json(['success' => false, 'message' => 'Invalid email for contributor: ' . htmlspecialchars($c['name'])]);
                return;
            }
            $cleanContribs[] = [
                'name'        => Security::clean($c['name']),
                'affiliation' => Security::clean($c['affiliation']),
                'email'       => Security::clean($c['email']),
                'phone'       => Security::clean($c['phone']),
                'role'        => in_array($c['role'] ?? 'Author', ['Author','Co-Author','Corresponding Author','Editor'], true) ? $c['role'] : 'Author',
            ];
        }

        // Parse keywords JSON
        $keywords = json_decode($_POST['keywords'] ?? '[]', true) ?: [];
        $keywords = array_map(function($k) { return Security::clean((string)$k); }, $keywords);

        // Sanitize abstract — strip dangerous tags/attributes from user HTML
        $abstract = Security::cleanHtml($_POST['abstract'] ?? '');

        // Cover image (optional)
        $coverImage = null;
        $coverError = null;
        if (!empty($_FILES['cover_image']['name'])) {
            if (!empty($_FILES['cover_image']['error']) && $_FILES['cover_image']['error'] !== UPLOAD_ERR_OK) {
                $coverError = 'Cover image upload error (code ' . (int)$_FILES['cover_image']['error'] . ').';
            } else {
                $coverImage = uploadFile($_FILES['cover_image'], 'articles/covers', ALLOWED_IMAGE_TYPES);
                if (!$coverImage) {
                    $coverError = 'Cover image could not be saved (invalid type or too large). Allowed: JPG, PNG, GIF, WEBP, SVG.';
                }
            }
        }

        // Article files (multiple) — collect both successes and failures
        $articleFiles  = [];
        $failedFiles   = [];
        $allowedDocs   = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        if (!empty($_FILES['article_files']['name']) && is_array($_FILES['article_files']['name'])) {
            foreach ($_FILES['article_files']['name'] as $i => $name) {
                if (empty($name)) continue;
                $fileErr = isset($_FILES['article_files']['error'][$i]) ? (int)$_FILES['article_files']['error'][$i] : UPLOAD_ERR_NO_FILE;
                $fileSize = isset($_FILES['article_files']['size'][$i]) ? (int)$_FILES['article_files']['size'][$i] : 0;
                $fileData = [
                    'name'     => $name,
                    'type'     => $_FILES['article_files']['type'][$i] ?? '',
                    'tmp_name' => $_FILES['article_files']['tmp_name'][$i] ?? '',
                    'error'    => $fileErr,
                    'size'     => $fileSize,
                ];
                // Skip silently when no real upload was made
                if ($fileErr === UPLOAD_ERR_NO_FILE || $fileSize === 0) continue;
                if ($fileErr !== UPLOAD_ERR_OK) {
                    $failedFiles[] = $name . ' (upload error ' . $fileErr . ')';
                    continue;
                }
                $fn = uploadFile($fileData, 'articles/files', $allowedDocs);
                if ($fn) {
                    $articleFiles[] = ['filename' => $fn, 'original' => $fileData['name'], 'size' => $fileData['size']];
                } else {
                    $failedFiles[] = $name . ' (invalid type or too large)';
                }
            }
        }

        // For non-draft submissions, at least one article file is required.
        $reviewStatus = in_array($_POST['review_status'] ?? 'submitted', ['draft','submitted'], true) ? $_POST['review_status'] : 'submitted';
        if ($reviewStatus === 'submitted' && empty($articleFiles)) {
            $this->json(['success' => false, 'message' => 'Please upload at least one article file (PDF, DOC, or DOCX).']);
            return;
        }

        // Always default to unpublished (admin sets publication status later in admin panel)
        $pubStatus = 'unpublished';

        $data = [
            'journal_id'         => $journalId,
            'journal_name'       => $journal['name'],
            'section'            => Security::clean($_POST['section']),
            'prefix'             => Security::clean($_POST['prefix'] ?? ''),
            'title'              => Security::clean($_POST['title']),
            'subtitle'           => Security::clean($_POST['subtitle'] ?? ''),
            'abstract'           => $abstract,
            'keywords'           => json_encode($keywords, JSON_UNESCAPED_UNICODE),
            'cover_image'        => $coverImage,
            'contributors'       => json_encode($cleanContribs, JSON_UNESCAPED_UNICODE),
            'article_files'      => json_encode($articleFiles, JSON_UNESCAPED_UNICODE),
            'publication_status' => $pubStatus,
            'review_status'      => $reviewStatus,
            'submitter_name'        => Security::clean($_POST['submitter_name']),
            'submitter_email'       => $submitterEmail,
            'submitter_affiliation' => Security::clean($_POST['submitter_affiliation']),
            'submitter_mobile'      => Security::clean($_POST['submitter_mobile']),
            'ip_address'            => $_SERVER['REMOTE_ADDR'] ?? '',
        ];

        try {
            $id = (new ArticleSubmissionModel())->insert($data);
        } catch (\Throwable $e) {
            // Roll back any files we already moved so we don't leave orphans
            if ($coverImage) deleteFile('articles/covers/' . $coverImage);
            foreach ($articleFiles as $af) {
                if (!empty($af['filename'])) deleteFile('articles/files/' . $af['filename']);
            }
            error_log('Article submission insert failed: ' . $e->getMessage());
            $this->json(['success' => false, 'message' => 'Could not save submission. Please try again or contact support.']);
            return;
        }

        // Build response — include warnings for files that failed
        $message = $reviewStatus === 'draft'
            ? 'Draft saved successfully!'
            : 'Article submitted successfully! Our team will review it within 1-2 weeks.';
        $warning = null;
        if (!empty($failedFiles)) {
            $warning = 'Some files were not saved: ' . implode(', ', $failedFiles) . '. Allowed: PDF, DOC, DOCX up to ' . round(MAX_UPLOAD_SIZE / 1048576, 1) . ' MB.';
        } elseif ($coverError) {
            $warning = $coverError;
        }

        $this->json([
            'success' => true,
            'message' => $message,
            'warning' => $warning,
            'id'      => $id,
        ]);
    }

    /**
     * GET /articles/thank-you
     */
    public function thankYou(): void {
        $seo = ['page_title' => 'Thank You | ' . APP_NAME];
        $this->view('pages/article-thank-you', compact('seo'));
    }
}
