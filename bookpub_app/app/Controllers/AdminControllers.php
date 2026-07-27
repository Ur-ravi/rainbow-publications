<?php
// ============================================================
// ADMIN DASHBOARD CONTROLLER
// ============================================================
class AdminController extends Controller {
    public function __construct() { requireAdmin(); }

    public function dashboard(): void {
        $stats = [
            'books'    => (new BookModel())->count(),
            'journals' => (new JournalModel())->count(),
            'messages' => (new ContactModel())->count(),
            'unread'   => (new ContactModel())->getUnreadCount(),
            'news'     => (new NewsModel())->count(),
            'members'  => (new MembershipModel())->count(),
        ];
        $recentBooks    = (new BookModel())->findAll('', [], 'created_at DESC', 5);
        $recentMessages = (new ContactModel())->findAll('', [], 'created_at DESC', 5);
        $this->adminView('admin/dashboard', compact('stats', 'recentBooks', 'recentMessages'));
    }

    public function uploadImage(): void {
        requireAdmin();
        if (empty($_FILES['file']['name'])) {
            $this->json(['location' => '']);
        }
        $fn = uploadFile($_FILES['file'], 'content', ALLOWED_IMAGE_TYPES);
        if ($fn) {
            $this->json(['location' => BASE_URL . '/uploads/content/' . $fn]);
        }
        $this->json(['location' => '']);
    }
}

// ============================================================
// ADMIN BOOK CONTROLLER
// ============================================================
class AdminBookController extends Controller {
    private BookModel $model;
    public function __construct() { requireAdmin(); $this->model = new BookModel(); }

    public function index(): void {
        $search = Security::clean($_GET['q'] ?? '');
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $where  = $search ? '(title LIKE ? OR authors LIKE ? OR isbn LIKE ?)' : '';
        $params = $search ? ["%$search%", "%$search%", "%$search%"] : [];
        $total  = $this->model->count($where, $params);
        $pag    = $this->paginate($total, ADMIN_PER_PAGE, $page);
        $books  = $this->model->findAll($where, $params, 'created_at DESC', ADMIN_PER_PAGE, $pag['offset']);
        $this->adminView('admin/books/index', compact('books', 'pag', 'search', 'total'));
    }

    public function create(): void {
        $book = null;
        $this->adminView('admin/books/form', compact('book'));
    }

    public function store(): void {
        $this->csrfCheck();
        $title = Security::clean($_POST['title'] ?? '');
        if (!$title) $this->json(['success' => false, 'message' => 'Title is required.']);
        $data = $this->bookData();
        $data['slug'] = $this->model->uniqueSlug($title);
        if (!empty($_FILES['cover_image']['name'])) {
            $fn = uploadFile($_FILES['cover_image'], 'books', ALLOWED_IMAGE_TYPES);
            if ($fn) $data['cover_image'] = $fn;
        }
        if (!empty($_FILES['pdf_file']['name'])) {
            $fn = uploadFile($_FILES['pdf_file'], 'books', ALLOWED_DOC_TYPES, 50 * 1024 * 1024);
            if ($fn) $data['pdf_file'] = $fn;
        }
        $id = $this->model->insert($data);
        $this->json(['success' => true, 'message' => 'Book added successfully!', 'id' => $id, 'redirect' => BASE_URL . '/admin/books']);
    }

    public function edit(string $id): void {
        $book = $this->model->findById((int)$id);
        if (!$book) redirect(BASE_URL . '/admin/books');
        $this->adminView('admin/books/form', compact('book'));
    }

    public function update(string $id): void {
        $this->csrfCheck();
        $book = $this->model->findById((int)$id);
        if (!$book) $this->json(['success' => false, 'message' => 'Book not found.']);
        $data = $this->bookData();
        if ($data['title'] !== $book['title']) {
            $data['slug'] = $this->model->uniqueSlug($data['title'], (int)$id);
        }
        if (!empty($_FILES['cover_image']['name'])) {
            $fn = uploadFile($_FILES['cover_image'], 'books', ALLOWED_IMAGE_TYPES);
            if ($fn) { if ($book['cover_image']) deleteFile('books/' . $book['cover_image']); $data['cover_image'] = $fn; }
        }
        if (!empty($_FILES['pdf_file']['name'])) {
            $fn = uploadFile($_FILES['pdf_file'], 'books', ALLOWED_DOC_TYPES, 50 * 1024 * 1024);
            if ($fn) { if ($book['pdf_file']) deleteFile('books/' . $book['pdf_file']); $data['pdf_file'] = $fn; }
        }
        $this->model->update($data, 'id = ?', [(int)$id]);
        $this->json(['success' => true, 'message' => 'Book updated successfully!', 'redirect' => BASE_URL . '/admin/books']);
    }

    public function delete(string $id): void {
        $this->csrfCheck();
        $book = $this->model->findById((int)$id);
        if ($book) {
            if ($book['cover_image']) deleteFile('books/' . $book['cover_image']);
            if ($book['pdf_file'])    deleteFile('books/' . $book['pdf_file']);
            $this->model->delete('id = ?', [(int)$id]);
        }
        $this->json(['success' => true, 'message' => 'Book deleted.']);
    }

    public function toggle(string $id): void {
        $this->csrfCheck();
        $book = $this->model->findById((int)$id);
        if (!$book) $this->json(['success' => false, 'message' => 'Not found.']);
        $new = $book['is_published'] ? 0 : 1;
        $this->model->update(['is_published' => $new], 'id = ?', [(int)$id]);
        $this->json(['success' => true, 'published' => $new]);
    }

    private function bookData(): array {
        return [
            'title'            => Security::clean($_POST['title'] ?? ''),
            'authors'          => Security::clean($_POST['authors'] ?? ''),
            'isbn'             => Security::clean($_POST['isbn'] ?? ''),
            'description'      => $_POST['description'] ?? '',
            'category'         => Security::clean($_POST['category'] ?? ''),
            'publisher'        => Security::clean($_POST['publisher'] ?? ''),
            'publication_date' => $_POST['publication_date'] ?: null,
            'pages_count'      => (int)($_POST['pages_count'] ?? 0),
            'language'         => Security::clean($_POST['language'] ?? 'English'),
            'price'            => (float)($_POST['price'] ?? 0),
            'edition'          => Security::clean($_POST['edition'] ?? ''),
            'is_featured'      => !empty($_POST['is_featured']) ? 1 : 0,
            'is_published'     => !empty($_POST['is_published']) ? 1 : 0,
            'meta_title'       => Security::clean($_POST['meta_title'] ?? ''),
            'meta_description' => Security::clean($_POST['meta_description'] ?? ''),
            'meta_keywords'    => Security::clean($_POST['meta_keywords'] ?? ''),
            'sort_order'       => (int)($_POST['sort_order'] ?? 0),
        ];
    }
}
// ============================================================
// ADMIN JOURNAL CONTROLLER
// ============================================================
class AdminJournalController extends Controller {
    private JournalModel $model;

    public function __construct() { 
        requireAdmin(); 
        $this->model = new JournalModel(); 
    }

    public function index(): void {
        $search = Security::clean($_GET['search'] ?? '');
        $where  = $search ? '(name LIKE ? OR abbreviation LIKE ? OR issn LIKE ?)' : '';
        $params = $search ? ["%$search%", "%$search%", "%$search%"] : [];

        $journals = $this->model->findAll($where, $params, 'sort_order ASC');
        $this->adminView('admin/journals/index', compact('journals'));
    }

    public function create(): void {
        $journal = null;
        $this->adminView('admin/journals/form', compact('journal'));
    }

    public function edit(string $id): void {
        $journal = $this->model->findById((int)$id);
        if (!$journal) { 
            redirect(BASE_URL . '/admin/journals'); 
            return; 
        }
        $this->adminView('admin/journals/form', compact('journal'));
    }

    public function store(): void {
        $this->csrfCheck();
        $data = $this->journalData();

        if (!empty($_FILES['logo']['name'])) {
            $fn = uploadFile($_FILES['logo'], 'journals', ALLOWED_IMAGE_TYPES);
            if ($fn) $data['logo'] = $fn;
        }

        $id = $this->model->insert($data);
        $item = $this->model->findById($id);
        $this->json(['success' => true, 'message' => 'Journal added successfully!', 'id' => $id, 'item' => $item]);
    }

    public function update(string $id): void {
        $this->csrfCheck();
        $j = $this->model->findById((int)$id);
        if (!$j) {
            $this->json(['success' => false, 'message' => 'Journal not found.']);
            return;
        }

        $data = $this->journalData();

        if (!empty($_FILES['logo']['name'])) {
            $fn = uploadFile($_FILES['logo'], 'journals', ALLOWED_IMAGE_TYPES);
            if ($fn) { 
                if (!empty($j['logo'])) deleteFile('journals/' . $j['logo']); 
                $data['logo'] = $fn; 
            }
        }

        $this->model->update($data, 'id = ?', [(int)$id]);
        $this->json(['success' => true, 'message' => 'Journal updated successfully!']);
    }

    public function delete(string $id): void {
        $this->csrfCheck();
        $j = $this->model->findById((int)$id);
        
        if ($j) {
            if (!empty($j['logo'])) deleteFile('journals/' . $j['logo']);
            $this->model->delete('id = ?', [(int)$id]);
        }

        $this->json(['success' => true, 'message' => 'Journal deleted successfully.']);
    }

    public function toggle(string $id): void {
        $this->csrfCheck();
        $j = $this->model->findById((int)$id);

        if (!$j) {
            $this->json(['success' => false, 'message' => 'Journal not found.']);
            return;
        }

        $newStatus = ($j['is_active'] == 1) ? 0 : 1;
        $this->model->update(['is_active' => $newStatus], 'id = ?', [(int)$id]);

        $this->json(['success' => true, 'message' => 'Status updated successfully!']);
    }

    public function reorder(): void {
        $this->csrfCheck();
        
        // Handle both comma-separated string 'ids' or JSON array 'order'
        $rawIds = $_POST['ids'] ?? $_POST['order'] ?? '';
        $order  = is_array($rawIds) ? $rawIds : array_filter(explode(',', $rawIds));

        foreach ((array)$order as $pos => $jid) {
            $this->model->update(['sort_order' => (int)$pos], 'id = ?', [(int)$jid]);
        }

        $this->json(['success' => true, 'message' => 'Order saved!']);
    }

    private function journalData(): array {
        return [
            'name'         => Security::clean($_POST['name'] ?? ''),
            'abbreviation' => Security::clean($_POST['abbreviation'] ?? ''),
            'description'  => Security::clean($_POST['description'] ?? ''),
            'issn'         => Security::clean($_POST['issn'] ?? ''),
            'e_issn'       => Security::clean($_POST['e_issn'] ?? ''),
            'journal_url'  => Security::clean($_POST['journal_url'] ?? '#'),
            'link_type'    => in_array($_POST['link_type'] ?? '', ['external', 'internal']) ? $_POST['link_type'] : 'external',
            'is_active'    => (!empty($_POST['is_active']) && $_POST['is_active'] == 1) ? 1 : 0,
            'sort_order'   => (int)($_POST['sort_order'] ?? 0),
        ];
    }
}
// ============================================================
// ADMIN BOARD CONTROLLER
// ============================================================
class AdminBoardController extends Controller {
    public function __construct() { requireAdmin(); }

    public function index(): void {
        $type     = Security::clean($_GET['type'] ?? 'editorial');
        $model    = $type === 'reviewer' ? new ReviewerBoardModel() : new EditorialBoardModel();
        $members  = $model->findAll('', [], 'sort_order ASC');
        $this->adminView('admin/board/index', compact('members', 'type'));
    }

    public function store(): void {
        $this->csrfCheck();
        $type  = Security::clean($_POST['type'] ?? $_POST['board_type'] ?? 'editorial');
        $model = $type === 'reviewer' ? new ReviewerBoardModel() : new EditorialBoardModel();
        $data  = $this->boardData();
        if (!empty($_FILES['photo']['name'])) {
            $fn = uploadFile($_FILES['photo'], 'board', ALLOWED_IMAGE_TYPES);
            if ($fn) $data['photo'] = $fn;
        }
        $id   = $model->insert($data);
        $item = $model->findById($id);
        $this->json(['success' => true, 'message' => 'Member added!', 'id' => $id, 'item' => $item]);
    }

    public function update(string $id): void {
        $this->csrfCheck();
        $type   = Security::clean($_POST['type'] ?? $_POST['board_type'] ?? 'editorial');
        $model  = $type === 'reviewer' ? new ReviewerBoardModel() : new EditorialBoardModel();
        $member = $model->findById((int)$id);
        if (!$member) $this->json(['success' => false, 'message' => 'Not found.']);
        $data = $this->boardData();
        if (!empty($_FILES['photo']['name'])) {
            $fn = uploadFile($_FILES['photo'], 'board', ALLOWED_IMAGE_TYPES);
            if ($fn) { if ($member['photo']) deleteFile('board/' . $member['photo']); $data['photo'] = $fn; }
        }
        $model->update($data, 'id = ?', [(int)$id]);
        $this->json(['success' => true, 'message' => 'Member updated!']);
    }

    public function delete(string $id): void {
        $this->csrfCheck();
        $type  = Security::clean($_POST['type'] ?? $_POST['board_type'] ?? 'editorial');
        $model = $type === 'reviewer' ? new ReviewerBoardModel() : new EditorialBoardModel();
        $m     = $model->findById((int)$id);
        if ($m && $m['photo']) deleteFile('board/' . $m['photo']);
        $model->delete('id = ?', [(int)$id]);
        $this->json(['success' => true, 'message' => 'Member deleted.']);
    }

    public function reorder(): void {
        $this->csrfCheck();
        $type  = Security::clean($_POST['type'] ?? $_POST['board_type'] ?? 'editorial');
        $model = $type === 'reviewer' ? new ReviewerBoardModel() : new EditorialBoardModel();
        $order = json_decode($_POST['order'] ?? '[]', true) ?: [];
        foreach ($order as $pos => $mid) {
            $model->update(['sort_order' => (int)$pos], 'id = ?', [(int)$mid]);
        }
        $this->json(['success' => true]);
    }

    private function boardData(): array {
        $status = strtolower(trim($_POST['status'] ?? 'active'));
        return [
            'name'           => Security::clean($_POST['name'] ?? ''),
            'designation'    => Security::clean($_POST['designation'] ?? ''),
            'qualification'  => Security::clean($_POST['qualification'] ?? ''),
            'institution'    => Security::clean($_POST['institution'] ?? ''),
            'country'        => Security::clean($_POST['country'] ?? ''),
            'email'          => Security::clean($_POST['email'] ?? ''),
            'bio'            => Security::clean($_POST['bio'] ?? ''),
            'specialization' => Security::clean($_POST['specialization'] ?? ''),
            'sort_order'     => (int)($_POST['sort_order'] ?? 0),
            'is_active'      => in_array($status, ['active', '1', 'yes'], true) ? 1 : 0,
        ];
    }
}

// ============================================================
// ADMIN MEMBERSHIP CONTROLLER
// ============================================================
class AdminMembershipController extends Controller {
    private MembershipModel $model;
    public function __construct() { requireAdmin(); $this->model = new MembershipModel(); }

    public function index(): void {
        $memberships = $this->model->findAll('', [], 'sort_order ASC');
        $this->adminView('admin/memberships/index', compact('memberships'));
    }

    public function create(): void {
        $membership = null;
        $this->adminView('admin/memberships/form', compact('membership'));
    }

    public function edit(string $id): void {
        $membership = $this->model->findById((int)$id);
        if (!$membership) { redirect(BASE_URL . '/admin/memberships'); return; }
        $this->adminView('admin/memberships/form', compact('membership'));
    }

    public function reorder(): void {
        $this->csrfCheck();
        $order = json_decode($_POST['order'] ?? '[]', true) ?: ($_POST['order'] ?? []);
        foreach ((array)$order as $pos => $mid) {
            $this->model->update(['sort_order' => (int)$pos], 'id = ?', [(int)$mid]);
        }
        $this->json(['success' => true]);
    }

    public function store(): void {
        $this->csrfCheck();
        $features = array_values(array_filter(array_map('trim', explode("\n", $_POST['features'] ?? ''))));
        $data = [
            'name'            => Security::clean($_POST['name'] ?? ''),
            'price'           => (float)($_POST['price'] ?? 0),
            'duration_months' => (int)($_POST['duration_months'] ?? 12),
            'description'     => Security::clean($_POST['description'] ?? ''),
            'features'        => json_encode($features),
            'badge_color'     => Security::clean($_POST['badge_color'] ?? '#0d3051'),
            'is_featured'     => isset($_POST['is_featured']) ? 1 : 0,
            'is_active'       => isset($_POST['is_active']) ? 1 : 0,
            'sort_order'      => (int)($_POST['sort_order'] ?? 0),
        ];
        $id = $this->model->insert($data);
        $this->json(['success' => true, 'message' => 'Plan added!', 'id' => $id]);
    }

    public function update(string $id): void {
        $this->csrfCheck();
        $features = array_values(array_filter(array_map('trim', explode("\n", $_POST['features'] ?? ''))));
        $data = [
            'name'            => Security::clean($_POST['name'] ?? ''),
            'price'           => (float)($_POST['price'] ?? 0),
            'duration_months' => (int)($_POST['duration_months'] ?? 12),
            'description'     => Security::clean($_POST['description'] ?? ''),
            'features'        => json_encode($features),
            'badge_color'     => Security::clean($_POST['badge_color'] ?? '#0d3051'),
            'is_featured'     => isset($_POST['is_featured']) ? 1 : 0,
            'is_active'       => isset($_POST['is_active']) ? 1 : 0,
            'sort_order'      => (int)($_POST['sort_order'] ?? 0),
        ];
        $this->model->update($data, 'id = ?', [(int)$id]);
        $this->json(['success' => true, 'message' => 'Plan updated!']);
    }

    public function delete(string $id): void {
        $this->csrfCheck();
        $this->model->delete('id = ?', [(int)$id]);
        $this->json(['success' => true, 'message' => 'Plan deleted.']);
    }
}

// ============================================================
// ADMIN SERVICE CONTROLLER
// ============================================================
class AdminServiceController extends Controller {
    private ServiceModel $model;
    public function __construct() { requireAdmin(); $this->model = new ServiceModel(); }

    public function index(): void {
        $services = $this->model->findAll('', [], 'sort_order ASC');
        $this->adminView('admin/services/index', compact('services'));
    }

    public function create(): void {
        $service = null;
        $this->adminView('admin/services/form', compact('service'));
    }

    public function edit(string $id): void {
        $service = $this->model->findById((int)$id);
        if (!$service) redirect(BASE_URL . '/admin/services');
        $this->adminView('admin/services/form', compact('service'));
    }

    public function store(): void {
        $this->csrfCheck();
        $title = Security::clean($_POST['title'] ?? '');
        if (!$title) $this->json(['success' => false, 'message' => 'Title is required.']);
        $data = $this->serviceData($title);
        if (!empty($_FILES['image']['name'])) {
            $fn = uploadFile($_FILES['image'], 'services', ALLOWED_IMAGE_TYPES);
            if ($fn) $data['image'] = $fn;
        }
        $id = $this->model->insert($data);
        $this->json(['success' => true, 'message' => 'Service added!', 'redirect' => BASE_URL . '/admin/services']);
    }

    public function update(string $id): void {
        $this->csrfCheck();
        $title = Security::clean($_POST['title'] ?? '');
        $data  = $this->serviceData($title, (int)$id);
        if (!empty($_FILES['image']['name'])) {
            $s  = $this->model->findById((int)$id);
            $fn = uploadFile($_FILES['image'], 'services', ALLOWED_IMAGE_TYPES);
            if ($fn) { if ($s && $s['image']) deleteFile('services/' . $s['image']); $data['image'] = $fn; }
        }
        $this->model->update($data, 'id = ?', [(int)$id]);
        $this->json(['success' => true, 'message' => 'Service updated!', 'redirect' => BASE_URL . '/admin/services']);
    }

    public function reorder(): void {
        $this->csrfCheck();
        $order = json_decode($_POST['order'] ?? '[]', true) ?: ($_POST['order'] ?? []);
        foreach ((array)$order as $pos => $sid) {
            $this->model->update(['sort_order' => (int)$pos], 'id = ?', [(int)$sid]);
        }
        $this->json(['success' => true]);
    }

    public function delete(string $id): void {
        $this->csrfCheck();
        $s = $this->model->findById((int)$id);
        if ($s && $s['image']) deleteFile('services/' . $s['image']);
        $this->model->delete('id = ?', [(int)$id]);
        $this->json(['success' => true, 'message' => 'Service deleted.']);
    }

    private function serviceData(string $title, int $excludeId = 0): array {
        $rawSlug = trim($_POST['slug'] ?? '');
        $slug    = $rawSlug ? slug($rawSlug) : slug($title);

        $sections = [];
        $headings = $_POST['section_heading'] ?? [];
        $descs    = $_POST['section_description'] ?? [];
        foreach ((array)$headings as $index => $heading) {
            $description = trim($descs[$index] ?? '');
            if ($heading || $description) {
                $sections[] = [
                    'heading'     => Security::cleanHtml($heading),
                    'description' => Security::cleanHtml($description),
                ];
            }
        }

        return [
            'title'              => $title,
            'slug'               => $this->model->uniqueSlug($slug, $excludeId),
            'short_description'  => Security::cleanHtml($_POST['short_description'] ?? ''),
            'content'            => json_encode($sections),
            'icon'               => Security::clean($_POST['icon'] ?? ''),
            'cta_text'           => Security::clean($_POST['cta_text'] ?? 'Learn More'),
            'cta_url'            => Security::clean($_POST['cta_url'] ?? '/contact'),
            'is_active'          => isset($_POST['is_active']) && $_POST['is_active'] === '1' ? 1 : 0,
            'meta_title'         => Security::clean($_POST['meta_title'] ?? ''),
            'meta_description'   => Security::clean($_POST['meta_description'] ?? ''),
            'sort_order'         => (int)($_POST['sort_order'] ?? 0),
        ];
    }
}

// ============================================================
// ADMIN GALLERY CONTROLLER
// ============================================================
class AdminGalleryController extends Controller {
    private GalleryModel $model;
    public function __construct() { requireAdmin(); $this->model = new GalleryModel(); }

    public function create(): void {
        $item = null;
        $cats = (new GalleryCategoryModel())->findAll('', [], 'name ASC');
        $this->adminView('admin/gallery/form', compact('item', 'cats'));
    }

    public function edit(string $id): void {
        $item = $this->model->findById((int)$id);
        if (!$item) { redirect(BASE_URL . '/admin/gallery'); return; }
        $cats = (new GalleryCategoryModel())->findAll('', [], 'name ASC');
        $this->adminView('admin/gallery/form', compact('item', 'cats'));
    }

    public function index(): void {
        $type = Security::clean($_GET['type'] ?? '');
        $where = '1=1';
        $params = [];
        if ($type) {
            $where .= ' AND media_type = ?';
            $params[] = $type;
        }
        $items = $this->model->findAll($where, $params, 'sort_order ASC');
        $cats  = (new GalleryCategoryModel())->getActive();
        $counts = [
            '' => $this->model->count(),
            'image' => $this->model->count('media_type = ?', ['image']),
            'video' => $this->model->count('media_type = ?', ['video'])
        ];
        $this->adminView('admin/gallery/index', compact('items', 'cats', 'counts'));
    }

    public function categories(): void {
        $categories = (new GalleryCategoryModel())->findAll('', [], 'sort_order ASC');
        // Attach item count
        $db = Database::getInstance();
        foreach ($categories as &$cat) {
            $s = $db->prepare("SELECT COUNT(*) FROM gallery WHERE category_id = ?");
            $s->execute([$cat['id']]);
            $cat['item_count'] = (int)$s->fetchColumn();
        }
        $this->adminView('admin/gallery/categories', compact('categories'));
    }

    public function store(): void {
        $this->csrfCheck();
        $data = [
            'category_id' => (int)($_POST['category_id'] ?? 0) ?: null,
            'title'       => Security::clean($_POST['title'] ?? ''),
            'description' => Security::clean($_POST['description'] ?? ''),
            'media_type'  => in_array($_POST['media_type'] ?? '', ['image', 'video']) ? $_POST['media_type'] : 'image',
            'video_url'   => Security::clean($_POST['video_url'] ?? ''),
            'alt_text'    => Security::clean($_POST['alt_text'] ?? ''),
            'is_active'   => isset($_POST['is_active']) && $_POST['is_active'] === '1' ? 1 : 0,
            'sort_order'  => (int)($_POST['sort_order'] ?? 0),
        ];
        if (!empty($_FILES['file_path']['name'])) {
            $fn = uploadFile($_FILES['file_path'], 'gallery', ALLOWED_IMAGE_TYPES);
            if ($fn) $data['file_path'] = $fn;
        }
        $id = $this->model->insert($data);
        $this->json(['success' => true, 'message' => 'Item added!', 'id' => $id]);
    }

    public function update(string $id): void {
        $this->csrfCheck();
        $data = [
            'category_id' => (int)($_POST['category_id'] ?? 0) ?: null,
            'title'       => Security::clean($_POST['title'] ?? ''),
            'description' => Security::clean($_POST['description'] ?? ''),
            'media_type'  => in_array($_POST['media_type'] ?? '', ['image', 'video']) ? $_POST['media_type'] : 'image',
            'video_url'   => Security::clean($_POST['video_url'] ?? ''),
            'alt_text'    => Security::clean($_POST['alt_text'] ?? ''),
            'is_active'   => isset($_POST['is_active']) && $_POST['is_active'] === '1' ? 1 : 0,
            'sort_order'  => (int)($_POST['sort_order'] ?? 0),
        ];
        if (!empty($_FILES['file_path']['name'])) {
            $item = $this->model->findById((int)$id);
            $fn   = uploadFile($_FILES['file_path'], 'gallery', ALLOWED_IMAGE_TYPES);
            if ($fn) { if ($item && $item['file_path']) deleteFile('gallery/' . $item['file_path']); $data['file_path'] = $fn; }
        }
        $this->model->update($data, 'id = ?', [(int)$id]);
        $this->json(['success' => true, 'message' => 'Item updated!']);
    }

    public function delete(string $id): void {
        $this->csrfCheck();
        $item = $this->model->findById((int)$id);
        if ($item && $item['file_path']) deleteFile('gallery/' . $item['file_path']);
        $this->model->delete('id = ?', [(int)$id]);
        $this->json(['success' => true, 'message' => 'Item deleted.']);
    }

    public function storeCategory(): void {
        $this->csrfCheck();
        $m  = new GalleryCategoryModel();
        $nm = Security::clean($_POST['name'] ?? '');
        $data = [
            'name'        => $nm,
            'slug'        => slug($nm),
            'description' => Security::clean($_POST['description'] ?? ''),
            'color'       => Security::clean($_POST['color'] ?? '#0d3051'),
            'sort_order'  => (int)($_POST['sort_order'] ?? 0),
            'is_active'   => 1,
        ];
        $id = $m->insert($data);
        $this->json(['success' => true, 'message' => 'Category added!', 'id' => $id]);
    }

    public function updateCategory(): void {
        $this->csrfCheck();
        $id = (int)($_POST['id'] ?? 0);
        $m  = new GalleryCategoryModel();
        $nm = Security::clean($_POST['name'] ?? '');
        $data = [
            'name'        => $nm,
            'slug'        => slug($nm),
            'description' => Security::clean($_POST['description'] ?? ''),
            'color'       => Security::clean($_POST['color'] ?? '#0d3051'),
            'sort_order'  => (int)($_POST['sort_order'] ?? 0),
        ];
        $m->update($data, 'id = ?', [$id]);
        $this->json(['success' => true, 'message' => 'Category updated!']);
    }

    public function deleteCategory(string $id): void {
        $this->csrfCheck();
        // un-categorize items in this category
        $db = Database::getInstance();
        $db->prepare("UPDATE gallery SET category_id = NULL WHERE category_id = ?")->execute([(int)$id]);
        (new GalleryCategoryModel())->delete('id = ?', [(int)$id]);
        $this->json(['success' => true, 'message' => 'Category deleted.']);
    }
}

// ============================================================
// ADMIN CONTACT CONTROLLER
// ============================================================
class AdminContactController extends Controller {
    private ContactModel $model;
    public function __construct() { requireAdmin(); $this->model = new ContactModel(); }

    public function index(): void {
        $page     = max(1, (int)($_GET['page'] ?? 1));
        $total    = $this->model->count();
        $pag      = $this->paginate($total, ADMIN_PER_PAGE, $page);
        $messages = $this->model->findAll('', [], 'created_at DESC', ADMIN_PER_PAGE, $pag['offset']);
        $this->adminView('admin/contact/index', compact('messages', 'pag', 'total'));
    }

    public function delete(string $id): void {
        $this->csrfCheck();
        $this->model->delete('id = ?', [(int)$id]);
        $this->json(['success' => true, 'message' => 'Message deleted.']);
    }

    public function markRead(string $id): void {
        $this->csrfCheck();
        $this->model->update(['is_read' => 1], 'id = ?', [(int)$id]);
        $this->json(['success' => true]);
    }

    public function bulkDelete(): void {
        $this->csrfCheck();
        $ids = array_filter(array_map('intval', explode(',', $_POST['ids'] ?? '')));
        foreach ($ids as $id) $this->model->delete('id = ?', [$id]);
        $this->json(['success' => true, 'message' => count($ids) . ' messages deleted.']);
    }
}

// ============================================================
// ADMIN PAYMENT CONTROLLER
// ============================================================
class AdminPaymentController extends Controller {
    private PaymentModel $model;
    public function __construct() { requireAdmin(); $this->model = new PaymentModel(); }

    public function index(): void {
        $all     = $this->model->findAll('', [], 'id ASC', 1);
        $payment = $all[0] ?? [];
        $this->adminView('admin/payment/index', compact('payment'));
    }

    private function getOrCreate(): array {
        $existing = $this->model->findAll('', [], 'id ASC', 1);
        if (!$existing) {
            $id = $this->model->insert(['is_active' => 1]);
            return $this->model->findById($id);
        }
        return $existing[0];
    }

    public function saveBank(): void {
        $this->csrfCheck();
        $rec = $this->getOrCreate();
        $data = [
            'bank_name'      => Security::clean($_POST['bank_name'] ?? ''),
            'account_holder' => Security::clean($_POST['account_holder'] ?? ''),
            'account_number' => Security::clean($_POST['account_number'] ?? ''),
            'ifsc_code'      => Security::clean($_POST['ifsc_code'] ?? ''),
            'branch_name'    => Security::clean($_POST['branch_name'] ?? ''),
            'swift_code'     => Security::clean($_POST['swift_code'] ?? ''),
            'bank_notes'     => Security::clean($_POST['bank_notes'] ?? ''),
        ];
        $this->model->update($data, 'id = ?', [$rec['id']]);
        $this->json(['success' => true, 'message' => 'Bank details saved!']);
    }

    public function saveUpi(): void {
        $this->csrfCheck();
        $rec = $this->getOrCreate();
        $data = [
            'upi_id'   => Security::clean($_POST['upi_id'] ?? ''),
            'upi_name' => Security::clean($_POST['upi_name'] ?? ''),
        ];
        $this->model->update($data, 'id = ?', [$rec['id']]);
        $this->json(['success' => true, 'message' => 'UPI details saved!']);
    }

    public function saveQr(): void {
        $this->csrfCheck();
        $rec = $this->getOrCreate();
        if (!empty($_FILES['qr_code']['name'])) {
            $fn = uploadFile($_FILES['qr_code'], 'payment', ALLOWED_IMAGE_TYPES);
            if ($fn) {
                if (!empty($rec['qr_code'])) deleteFile('payment/' . $rec['qr_code']);
                $this->model->update(['qr_code' => $fn], 'id = ?', [$rec['id']]);
                $this->json(['success' => true, 'message' => 'QR code uploaded!']);
            }
        }
        $this->json(['success' => false, 'message' => 'No file uploaded.']);
    }

    public function removeQr(): void {
        // The frontend sends the CSRF token as 'token' instead of 'csrf_token' for this endpoint.
        $token = $_POST['token'] ?? ($_POST['csrf_token'] ?? '');
        if (!Security::validateCsrf($token)) {
            $this->json(['success' => false, 'message' => 'Invalid security token.'], 403);
        }
        $existing = $this->model->findAll('', [], 'id ASC', 1);
        if (empty($existing)) {
            $this->json(['success' => false, 'message' => 'No payment record found.']);
        }
        $rec = $existing[0];
        if (!empty($rec['qr_code'])) {
            deleteFile('payment/' . $rec['qr_code']);
        }
        $this->model->update(['qr_code' => null], 'id = ?', [$rec['id']]);
        $this->json(['success' => true, 'message' => 'QR Code removed.']);
    }
}

// ============================================================
// ADMIN SEO CONTROLLER
// ============================================================
class AdminSeoController extends Controller {
    private SeoModel $model;
    public function __construct() { requireAdmin(); $this->model = new SeoModel(); }

    public function index(): void {
        $rows        = $this->model->findAll();
        $seoSettings = [];
        foreach ($rows as $r) $seoSettings[$r['page_key']] = $r;
        $this->adminView('admin/seo/index', compact('seoSettings'));
    }

    public function save(): void {
        $this->csrfCheck();
        $key  = Security::clean($_POST['page_key'] ?? '');
        if (!$key) $this->json(['success' => false, 'message' => 'Page key missing.']);
        $data = [
            'page_title'       => Security::clean($_POST['meta_title'] ?? ''),
            'meta_description' => Security::clean($_POST['meta_description'] ?? ''),
            'meta_keywords'    => Security::clean($_POST['meta_keywords'] ?? ''),
            'og_title'         => Security::clean($_POST['og_title'] ?? ''),
            'og_description'   => Security::clean($_POST['og_description'] ?? ''),
            'og_image'         => Security::clean($_POST['og_image'] ?? ''),
            'canonical_url'    => Security::clean($_POST['canonical_url'] ?? ''),
        ];
        $existing = $this->model->getByKey($key);
        if ($existing) {
            $this->model->update($data, 'page_key = ?', [$key]);
        } else {
            $data['page_key'] = $key;
            $this->model->insert($data);
        }
        $this->json(['success' => true, 'message' => 'SEO settings saved!']);
    }
}

// ============================================================
// ADMIN SETTINGS CONTROLLER
// ============================================================
class AdminSettingsController extends Controller {
    private SettingsModel $model;
    public function __construct() { requireAdmin(); $this->model = new SettingsModel(); }

    public function index(): void {
        $settings = $this->model->getAll();
        $this->adminView('admin/settings/index', compact('settings'));
    }

    public function save(): void {
        $this->csrfCheck();
        $fields = [
            'site_name', 'site_tagline', 'site_email', 'site_phone', 'site_address',
            'footer_about', 'footer_copyright', 'google_map_embed',
            'facebook_url', 'twitter_url', 'linkedin_url', 'instagram_url', 'youtube_url', 'telegram_url',
            'whatsapp', 'business_hours', 'google_analytics', 'gtm_id',
            'head_scripts', 'body_scripts',
            'primary_color', 'secondary_color',
            'heading_color', 'text_color', 'muted_color', 'btn_bg_color', 'btn_text_color',
            'header_bg_color', 'footer_bg_color', 'modal_bg_color',
            'success_color', 'warning_color', 'danger_color',
            'counter_total_books', 'counter_total_journals', 'counter_total_members', 'counter_years_exp',
        ];
        foreach ($fields as $f) {
            if (isset($_POST[$f])) {
                $this->model->set($f, in_array($f, ['head_scripts', 'body_scripts']) ? ($_POST[$f] ?? '') : Security::clean($_POST[$f] ?? ''));
            }
        }
        $this->model->set('maintenance_mode', !empty($_POST['maintenance_mode']) && $_POST['maintenance_mode'] !== '0' ? '1' : '0');
        if (!empty($_FILES['site_logo']['name'])) {
            $fn = uploadFile($_FILES['site_logo'], 'settings', ALLOWED_IMAGE_TYPES);
            if ($fn) $this->model->set('site_logo', $fn);
        }
        if (!empty($_FILES['site_favicon']['name'])) {
            $fn = uploadFile($_FILES['site_favicon'], 'settings', array_merge(ALLOWED_IMAGE_TYPES, ['image/x-icon', 'image/vnd.microsoft.icon']));
            if ($fn) $this->model->set('site_favicon', $fn);
        }
        $this->json(['success' => true, 'message' => 'Settings saved!']);
    }
}

// ============================================================
// ADMIN NEWS CONTROLLER
// ============================================================
class AdminNewsController extends Controller {
    private NewsModel $model;
    public function __construct() { requireAdmin(); $this->model = new NewsModel(); }

    public function index(): void {
        $search  = Security::clean($_GET['q'] ?? '');
        $status  = Security::clean($_GET['status'] ?? '');
        $page    = max(1, (int)($_GET['page'] ?? 1));
        $where   = '1=1';
        $params  = [];
        if ($search) { $where .= ' AND (title LIKE ? OR excerpt LIKE ?)'; $params = ["%$search%", "%$search%"]; }
        if ($status) { $where .= ' AND status = ?'; $params[] = $status; }
        $total            = $this->model->count($where, $params);
        $pag              = $this->paginate($total, ADMIN_PER_PAGE, $page);
        $news             = $this->model->findAll($where, $params, 'created_at DESC', ADMIN_PER_PAGE, $pag['offset']);
        // Single aggregation query for all 4 counts
        $stats = $this->model->query(
            "SELECT
                COUNT(*) AS total,
                SUM(status = 'published') AS published,
                SUM(status = 'draft')     AS draft,
                SUM(is_featured = 1)      AS featured
             FROM news"
        );
        $row = $stats[0] ?? [];
        $publishedCount = (int)($row['published'] ?? 0);
        $draftCount     = (int)($row['draft']     ?? 0);
        $featuredCount  = (int)($row['featured']  ?? 0);
        $totalNews      = (int)($row['total']     ?? 0);
        $currentPage      = $page;
        $totalPages       = $pag['total_pages'];
        $this->adminView('admin/news/index', compact('news', 'pag', 'search', 'status', 'publishedCount', 'draftCount', 'featuredCount', 'totalNews', 'currentPage', 'totalPages'));
    }

    public function create(): void {
        $article = null;
        $this->adminView('admin/news/form', compact('article'));
    }

    public function edit(string $id): void {
        $article = $this->model->findById((int)$id);
        if (!$article) redirect(BASE_URL . '/admin/news');
        $this->adminView('admin/news/form', compact('article'));
    }

    public function store(): void {
        $this->csrfCheck();
        $title  = Security::clean($_POST['title'] ?? '');
        $status = in_array($_POST['status'] ?? '', ['published', 'draft']) ? $_POST['status'] : 'draft';
        if (!$title) $this->json(['success' => false, 'message' => 'Title is required.']);
        $data = $this->newsData($title, $status);
        $data['slug'] = $this->model->uniqueSlug($title);
        if (!empty($_FILES['featured_image']['name'])) {
            $fn = uploadFile($_FILES['featured_image'], 'news', ALLOWED_IMAGE_TYPES);
            if ($fn) $data['featured_image'] = $fn;
        }
        $id = $this->model->insert($data);
        $this->json(['success' => true, 'message' => 'Article saved!', 'redirect' => BASE_URL . '/admin/news']);
    }

    public function update(): void {
        $this->csrfCheck();
        $id     = (int)($_POST['id'] ?? 0);
        $title  = Security::clean($_POST['title'] ?? '');
        $status = in_array($_POST['status'] ?? '', ['published', 'draft']) ? $_POST['status'] : 'draft';
        $a      = $this->model->findById($id);
        if (!$a) $this->json(['success' => false, 'message' => 'Article not found.']);
        $data = $this->newsData($title, $status);
        if (!empty($_FILES['featured_image']['name'])) {
            $fn = uploadFile($_FILES['featured_image'], 'news', ALLOWED_IMAGE_TYPES);
            if ($fn) { if ($a['featured_image']) deleteFile('news/' . $a['featured_image']); $data['featured_image'] = $fn; }
        }
        $this->model->update($data, 'id = ?', [$id]);
        $this->json(['success' => true, 'message' => 'Article updated!', 'redirect' => BASE_URL . '/admin/news']);
    }

    public function delete(string $id): void {
        $this->csrfCheck();
        $a = $this->model->findById((int)$id);
        if ($a && $a['featured_image']) deleteFile('news/' . $a['featured_image']);
        $this->model->delete('id = ?', [(int)$id]);
        $this->json(['success' => true, 'message' => 'Article deleted.']);
    }

    public function toggleStatus(string $id): void {
        $this->csrfCheck();
        $a = $this->model->findById((int)$id);
        if (!$a) $this->json(['success' => false, 'message' => 'Not found.']);
        $new = ($a['status'] ?? 'draft') === 'published' ? 'draft' : 'published';
        $this->model->update(['status' => $new, 'is_published' => ($new === 'published') ? 1 : 0], 'id = ?', [(int)$id]);
        $this->json(['success' => true, 'status' => $new]);
    }

    public function bulkDelete(): void {
        $this->csrfCheck();
        $ids = array_filter(array_map('intval', explode(',', $_POST['ids'] ?? '')));
        foreach ($ids as $id) {
            $a = $this->model->findById($id);
            if ($a && $a['featured_image']) deleteFile('news/' . $a['featured_image']);
            $this->model->delete('id = ?', [$id]);
        }
        $this->json(['success' => true, 'message' => count($ids) . ' articles deleted.']);
    }

    public function bulkStatus(): void {
        $this->csrfCheck();
        $ids    = array_filter(array_map('intval', explode(',', $_POST['ids'] ?? '')));
        $status = in_array($_POST['status'] ?? '', ['published', 'draft']) ? $_POST['status'] : 'draft';
        foreach ($ids as $id) $this->model->update(['status' => $status], 'id = ?', [$id]);
        $this->json(['success' => true, 'message' => count($ids) . ' articles updated.']);
    }

    private function newsData(string $title, string $status): array {
        return [
            'title'            => $title,
            'excerpt'          => Security::clean($_POST['excerpt'] ?? ''),
            'content'          => $_POST['content'] ?? '',
            'author'           => Security::clean($_POST['author'] ?? 'Admin'),
            'tags'             => Security::clean($_POST['tags'] ?? ''),
            'status'           => $status,
            'is_published'     => ($status === 'published') ? 1 : 0,
            'is_featured'      => !empty($_POST['is_featured']) ? 1 : 0,
            'published_at'     => !empty($_POST['published_at']) ? date('Y-m-d H:i:s', strtotime($_POST['published_at'])) : date('Y-m-d H:i:s'),
            'meta_title'       => Security::clean($_POST['meta_title'] ?? ''),
            'meta_description' => Security::clean($_POST['meta_description'] ?? ''),
            'meta_keywords'    => Security::clean($_POST['meta_keywords'] ?? ''),
        ];
    }
}

// ============================================================
// ADMIN MENU CONTROLLER
// ============================================================
class AdminMenuController extends Controller {
    private MenuModel $model;
    public function __construct() { requireAdmin(); $this->model = new MenuModel(); }

    public function index(): void {
        $parents    = $this->model->findAll('parent_id IS NULL', [], 'sort_order ASC');
        $menuItems  = [];
        foreach ($parents as $p) {
            $p['children'] = $this->model->findAll('parent_id = ?', [$p['id']], 'sort_order ASC');
            $menuItems[]   = $p;
        }
        $pages = (new PageModel())->findAll("status = 'published'", [], 'title ASC');
        $this->adminView('admin/menus/index', compact('menuItems', 'pages'));
    }

    public function save(): void {
        $this->csrfCheck();
        $items = json_decode($_POST['items'] ?? '[]', true);
        if (!is_array($items)) $this->json(['success' => false, 'message' => 'Invalid data.']);

        // Clear all existing menu items and rebuild
        $db = Database::getInstance();
        $db->exec("DELETE FROM menus");

        foreach ($items as $i => $item) {
            $pid = $this->model->insert([
                'parent_id'  => null,
                'label'      => Security::clean($item['label'] ?? ''),
                'url'        => Security::clean($item['url'] ?? '/'),
                'target'     => ($item['target_blank'] ?? 0) ? '_blank' : '_self',
                'is_active'  => 1,
                'sort_order' => (int)$i,
            ]);
            foreach ($item['children'] ?? [] as $j => $child) {
                $this->model->insert([
                    'parent_id'  => $pid,
                    'label'      => Security::clean($child['label'] ?? ''),
                    'url'        => Security::clean($child['url'] ?? '/'),
                    'target'     => ($child['target_blank'] ?? 0) ? '_blank' : '_self',
                    'is_active'  => 1,
                    'sort_order' => (int)$j,
                ]);
            }
        }
        $this->json(['success' => true, 'message' => 'Menu saved successfully!']);
    }
}

// ============================================================
// BOARD CONTROLLER NAMED METHODS (for legacy URL routes)
// ============================================================
// These are appended to the class via a trait-like extension pattern.
// Since PHP doesn't allow re-opening classes, we add a new class:

class AdminBoardLegacyController extends AdminBoardController {
    public function editorial(): void {
        $_GET['type'] = 'editorial';
        $members   = (new EditorialBoardModel())->findAll('', [], 'sort_order ASC');
        $type      = 'editorial';
        $boardType = 'editorial';
        $this->adminView('admin/board/index', compact('members', 'type', 'boardType'));
    }
    public function reviewer(): void {
        $_GET['type'] = 'reviewer';
        $members   = (new ReviewerBoardModel())->findAll('', [], 'sort_order ASC');
        $type      = 'reviewer';
        $boardType = 'reviewer';
        $this->adminView('admin/board/index', compact('members', 'type', 'boardType'));
    }

    public function addEditorial(): void {
        $member    = [];
        $type      = 'editorial';
        $boardType = 'editorial';
        $this->adminView('admin/board/form', compact('member', 'type', 'boardType'));
    }

    public function addReviewer(): void {
        $member    = [];
        $type      = 'reviewer';
        $boardType = 'reviewer';
        $this->adminView('admin/board/form', compact('member', 'type', 'boardType'));
    }

    public function editEditorial(string $id): void {
        $type      = 'editorial';
        $boardType = 'editorial';
        $member = (new EditorialBoardModel())->findById((int)$id);
        if (!$member) { redirect(BASE_URL . '/admin/board/editorial'); return; }
        $this->adminView('admin/board/form', compact('member', 'type', 'boardType'));
    }

    public function editReviewer(string $id): void {
        $type      = 'reviewer';
        $boardType = 'reviewer';
        $member = (new ReviewerBoardModel())->findById((int)$id);
        if (!$member) { redirect(BASE_URL . '/admin/board/reviewer'); return; }
        $this->adminView('admin/board/form', compact('member', 'type', 'boardType'));
    }

    public function storeEditorial(): void   { $_POST['type'] = 'editorial';  parent::store(); }
    public function storeReviewer(): void    { $_POST['type'] = 'reviewer';   parent::store(); }
    public function updateEditorial(string $id): void { $_POST['type'] = 'editorial'; parent::update($id); }
    public function updateReviewer(string $id): void  { $_POST['type'] = 'reviewer';  parent::update($id); }
    public function deleteEditorial(string $id): void { $_POST['type'] = 'editorial'; parent::delete($id); }
    public function deleteReviewer(string $id): void  { $_POST['type'] = 'reviewer';  parent::delete($id); }
    public function reorderEditorial(): void { $_POST['type'] = 'editorial';  parent::reorder(); }
    public function reorderReviewer(): void  { $_POST['type'] = 'reviewer';   parent::reorder(); }
    public function toggleEditorial(string $id): void {
        $this->csrfCheck();
        $m = (new EditorialBoardModel())->findById((int)$id);
        if (!$m) $this->json(['success'=>false,'message'=>'Not found.']);
        $new = $m['is_active'] ? 0 : 1;
        (new EditorialBoardModel())->update(['is_active'=>$new], 'id=?', [(int)$id]);
        $this->json(['success'=>true,'active'=>$new]);
    }
    public function toggleReviewer(string $id): void {
        $this->csrfCheck();
        $m = (new ReviewerBoardModel())->findById((int)$id);
        if (!$m) $this->json(['success'=>false,'message'=>'Not found.']);
        $new = $m['is_active'] ? 0 : 1;
        (new ReviewerBoardModel())->update(['is_active'=>$new], 'id=?', [(int)$id]);
        $this->json(['success'=>true,'active'=>$new]);
    }
}


// ============================================================
// ADMIN CONFERENCE CONTROLLER
// ============================================================
class AdminConferenceController extends Controller {
    private ConferenceModel $model;
    public function __construct() { requireAdmin(); $this->model = new ConferenceModel(); }

    public function index(): void {
        $conferences = $this->model->findAll('', [], 'COALESCE(conference_date, "9999-12-31") DESC, sort_order ASC, id DESC');
        $this->adminView('admin/conferences/index', compact('conferences'));
    }

    public function create(): void {
        $conference = null;
        $this->adminView('admin/conferences/form', compact('conference'));
    }

    public function edit(string $id): void {
        $conference = $this->model->findById((int)$id);
        if (!$conference) { redirect(BASE_URL . '/admin/conferences'); return; }
        $this->adminView('admin/conferences/form', compact('conference'));
    }

    public function store(): void {
        $this->csrfCheck();
        $title = Security::clean($_POST['title'] ?? '');
        if (!$title) $this->json(['success' => false, 'message' => 'Title is required.']);

        $slugBase = Security::clean($_POST['slug'] ?? '') ?: $title;
        $data = $this->conferenceData($title);
        $data['slug'] = $this->uniqueSlug(slug($slugBase));

        // Optional poster upload
        if (!empty($_FILES['poster_image']['name'])) {
            $fn = uploadFile($_FILES['poster_image'], 'conferences', ALLOWED_IMAGE_TYPES);
            if ($fn) $data['poster_image'] = $fn;
        }

        // Optional brochure PDF upload
        if (!empty($_FILES['conference_brochure']['name'])) {
            $fn = uploadFile($_FILES['conference_brochure'], 'conferences/pdfs', ALLOWED_DOC_TYPES);
            if ($fn) $data['conference_brochure'] = $fn;
        }

        $id = $this->model->insert($data);
        $this->json([
            'success'  => true,
            'message'  => 'Conference added successfully.',
            'redirect' => BASE_URL . '/admin/conferences',
            'id'       => $id,
        ]);
    }

    public function update(string $id): void {
        $this->csrfCheck();
        $existing = $this->model->findById((int)$id);
        if (!$existing) $this->json(['success' => false, 'message' => 'Conference not found.']);

        $title = Security::clean($_POST['title'] ?? '');
        if (!$title) $this->json(['success' => false, 'message' => 'Title is required.']);

        $data = $this->conferenceData($title);

        // Slug — keep existing unless explicitly changed
        $slugBase = Security::clean($_POST['slug'] ?? '');
        if ($slugBase) {
            $newSlug = slug($slugBase);
            if ($newSlug !== $existing['slug']) {
                $data['slug'] = $this->uniqueSlug($newSlug, (int)$id);
            }
        }

        if (!empty($_FILES['poster_image']['name'])) {
            $fn = uploadFile($_FILES['poster_image'], 'conferences', ALLOWED_IMAGE_TYPES);
            if ($fn) {
                if (!empty($existing['poster_image'])) deleteFile('conferences/' . $existing['poster_image']);
                $data['poster_image'] = $fn;
            }
        }

        // Handle brochure PDF update
        if (!empty($_FILES['conference_brochure']['name'])) {
            $fn = uploadFile($_FILES['conference_brochure'], 'conferences/pdfs', ALLOWED_DOC_TYPES);
            if ($fn) {
                if (!empty($existing['conference_brochure'])) deleteFile('conferences/pdfs/' . $existing['conference_brochure']);
                $data['conference_brochure'] = $fn;
            }
        } elseif (!empty($_POST['remove_brochure']) && $_POST['remove_brochure'] === '1') {
            if (!empty($existing['conference_brochure'])) deleteFile('conferences/pdfs/' . $existing['conference_brochure']);
            $data['conference_brochure'] = null;
        }

        $this->model->update($data, 'id = ?', [(int)$id]);
        $this->json([
            'success'  => true,
            'message'  => 'Conference updated successfully.',
            'redirect' => BASE_URL . '/admin/conferences',
        ]);
    }

    public function delete(string $id): void {
        $this->csrfCheck();
        $c = $this->model->findById((int)$id);
        if ($c) {
            if (!empty($c['poster_image'])) deleteFile('conferences/' . $c['poster_image']);
            if (!empty($c['conference_brochure'])) deleteFile('conferences/pdfs/' . $c['conference_brochure']);
        }
        $this->model->delete('id = ?', [(int)$id]);
        $this->json(['success' => true, 'message' => 'Conference deleted.']);
    }

    public function toggle(string $id): void {
        $this->csrfCheck();
        $c = $this->model->findById((int)$id);
        if (!$c) $this->json(['success' => false, 'message' => 'Not found.']);
        $new = $c['is_active'] ? 0 : 1;
        $this->model->update(['is_active' => $new], 'id = ?', [(int)$id]);
        $this->json(['success' => true, 'active' => $new, 'message' => 'Status updated.']);
    }

    /**
     * Toggle the "show on home page" flag for a conference.
     * Only one conference should be featured at a time; turning this on
     * for one conference automatically unmarks any other.
     */
    public function toggleFeatured(string $id): void {
        $this->csrfCheck();
        $c = $this->model->findById((int)$id);
        if (!$c) $this->json(['success' => false, 'message' => 'Not found.']);
        $new = $c['is_featured'] ? 0 : 1;
        // If turning ON, clear the flag on every other conference first
        if ($new === 1) {
            $this->model->update(['is_featured' => 0], 'id <> ?', [(int)$id]);
        }
        $this->model->update(['is_featured' => $new], 'id = ?', [(int)$id]);
        $this->json([
            'success'  => true,
            'featured' => $new,
            'message'  => $new ? 'Now showing on home page.' : 'Removed from home page.',
        ]);
    }

    // ============== helpers ==============
    private function conferenceData(string $title): array {
        return [
            'title'                 => $title,
            'subtitle'              => Security::clean($_POST['subtitle'] ?? ''),
            'theme_organization'    => $_POST['theme_organization'] ?? '',
            'intro_paragraph'       => $_POST['intro_paragraph'] ?? '',
            'registration_link'     => Security::clean($_POST['registration_link'] ?? ''),
            'registration_fee'      => Security::clean($_POST['registration_fee'] ?? ''),
            'registration_includes' => $_POST['registration_includes'] ?? '',
            'seats_info'            => Security::clean($_POST['seats_info'] ?? ''),
            'abstract_email'        => Security::clean($_POST['abstract_email'] ?? ''),
            'abstract_info'         => $_POST['abstract_info'] ?? '',
            'prize_first'           => Security::clean($_POST['prize_first'] ?? ''),
            'prize_second'          => Security::clean($_POST['prize_second'] ?? ''),
            'prize_third'           => Security::clean($_POST['prize_third'] ?? ''),
            'award_categories'      => $_POST['award_categories'] ?? '',
            'contact_phone'         => Security::clean($_POST['contact_phone'] ?? ''),
            'contact_email'         => Security::clean($_POST['contact_email'] ?? ''),
            'conference_date'       => !empty($_POST['conference_date']) ? $_POST['conference_date'] : null,
            'is_active'             => !empty($_POST['is_active']) ? 1 : 0,
            'is_featured'           => !empty($_POST['is_featured']) ? 1 : 0,
            'sort_order'            => (int)($_POST['sort_order'] ?? 0),
            'meta_title'            => Security::clean($_POST['meta_title'] ?? ''),
            'meta_description'      => Security::clean($_POST['meta_description'] ?? ''),
        ];
    }

    private function uniqueSlug(string $slug, int $excludeId = 0): string {
        $base = $slug ?: 'conference';
        $candidate = $base;
        $i = 2;
        while (true) {
            $where  = 'slug = ?';
            $params = [$candidate];
            if ($excludeId > 0) { $where .= ' AND id != ?'; $params[] = $excludeId; }
            if (!$this->model->findOne($where, $params)) return $candidate;
            $candidate = $base . '-' . $i;
            $i++;
            if ($i > 200) return $base . '-' . time();
        }
    }
}


// ============================================================
// ADMIN MEMBERSHIP TYPE CONTROLLER (detailed cards page)
// ============================================================
class AdminMembershipTypeController extends Controller {
    private MembershipTypeModel $model;
    public function __construct() { requireAdmin(); $this->model = new MembershipTypeModel(); }

    public function index(): void {
        $types = $this->model->findAll('', [], 'sort_order ASC, id ASC');
        $this->adminView('admin/membership-types/index', compact('types'));
    }

    public function create(): void {
        $type = null;
        $this->adminView('admin/membership-types/form', compact('type'));
    }

    public function edit(string $id): void {
        $type = $this->model->findById((int)$id);
        if (!$type) { redirect(BASE_URL . '/admin/membership-types'); return; }
        $this->adminView('admin/membership-types/form', compact('type'));
    }

    public function store(): void {
        $this->csrfCheck();
        $title = Security::clean($_POST['title'] ?? '');
        if (!$title) $this->json(['success' => false, 'message' => 'Title is required.']);
        $data = $this->typeData($title);
        $data['slug'] = $this->uniqueSlug(slug($_POST['slug'] ?? $title));
        $this->model->insert($data);
        $this->json(['success' => true, 'message' => 'Membership type added.', 'redirect' => BASE_URL . '/admin/membership-types']);
    }

    public function update(string $id): void {
        $this->csrfCheck();
        $existing = $this->model->findById((int)$id);
        if (!$existing) $this->json(['success' => false, 'message' => 'Not found.']);

        $title = Security::clean($_POST['title'] ?? '');
        if (!$title) $this->json(['success' => false, 'message' => 'Title is required.']);

        $data = $this->typeData($title);
        $slugIn = Security::clean($_POST['slug'] ?? '');
        if ($slugIn && $slugIn !== $existing['slug']) {
            $data['slug'] = $this->uniqueSlug(slug($slugIn), (int)$id);
        }
        $this->model->update($data, 'id = ?', [(int)$id]);
        $this->json(['success' => true, 'message' => 'Membership type updated.', 'redirect' => BASE_URL . '/admin/membership-types']);
    }

    public function delete(string $id): void {
        $this->csrfCheck();
        $this->model->delete('id = ?', [(int)$id]);
        $this->json(['success' => true, 'message' => 'Membership type deleted.']);
    }

    public function toggle(string $id): void {
        $this->csrfCheck();
        $t = $this->model->findById((int)$id);
        if (!$t) $this->json(['success' => false, 'message' => 'Not found.']);
        $new = $t['is_active'] ? 0 : 1;
        $this->model->update(['is_active' => $new], 'id = ?', [(int)$id]);
        $this->json(['success' => true, 'active' => $new, 'message' => 'Status updated.']);
    }

    private function typeData(string $title): array {
        return [
            'badge_number'           => (int)($_POST['badge_number'] ?? 1),
            'title'                  => $title,
            'fee_label'              => Security::clean($_POST['fee_label'] ?? ''),
            'fee_short'              => Security::clean($_POST['fee_short'] ?? ''),
            'card_color'             => Security::clean($_POST['card_color'] ?? 'purple'),
            'is_full_width'          => !empty($_POST['is_full_width']) ? 1 : 0,
            'eligibility_title'      => Security::clean($_POST['eligibility_title'] ?? ''),
            'eligibility'            => $_POST['eligibility'] ?? '',
            'details'                => $_POST['details'] ?? '',
            'footer_note'            => $_POST['footer_note'] ?? '',
            'nomination_emails'      => Security::clean($_POST['nomination_emails'] ?? ''),
            'duration_label'         => Security::clean($_POST['duration_label'] ?? ''),
            'comparison_eligibility' => Security::clean($_POST['comparison_eligibility'] ?? ''),
            'is_active'              => !empty($_POST['is_active']) ? 1 : 0,
            'sort_order'             => (int)($_POST['sort_order'] ?? 0),
        ];
    }

    private function uniqueSlug(string $slug, int $excludeId = 0): string {
        $base = $slug ?: 'membership-type';
        $candidate = $base;
        $i = 2;
        while (true) {
            $where = 'slug = ?';
            $params = [$candidate];
            if ($excludeId > 0) { $where .= ' AND id != ?'; $params[] = $excludeId; }
            if (!$this->model->findOne($where, $params)) return $candidate;
            $candidate = $base . '-' . $i;
            $i++;
            if ($i > 200) return $base . '-' . time();
        }
    }
}


// ============================================================
// ADMIN MEMBERSHIP APPLICATION CONTROLLER
// ============================================================
class AdminMembershipApplicationController extends Controller {
    private MembershipApplicationModel $model;
    public function __construct() { requireAdmin(); $this->model = new MembershipApplicationModel(); }

    public function index(): void {
        $status = $_GET['status'] ?? '';
        $page   = max(1, (int)($_GET['page'] ?? 1));
        $where  = ''; $params = [];
        if (in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $where = 'status = ?'; $params = [$status];
        }
        $total = $this->model->count($where, $params);
        $pag   = $this->paginate($total, ADMIN_PER_PAGE, $page);
        $applications = $this->model->findAll($where, $params, 'created_at DESC', ADMIN_PER_PAGE, $pag['offset']);

        $counts = [
            'all'      => $this->model->count(),
            'pending'  => $this->model->count('status = ?', ['pending']),
            'approved' => $this->model->count('status = ?', ['approved']),
            'rejected' => $this->model->count('status = ?', ['rejected']),
        ];
        $this->adminView('admin/applications/index', compact('applications', 'pag', 'total', 'status', 'counts'));
    }

    public function show(string $id): void {
        $app = $this->model->findById((int)$id);
        if (!$app) {
            // Application not found — show error and stay in admin context
            $error = 'Application not found. It may have been deleted.';
            $this->adminView('admin/applications/index', ['error' => $error]);
            return;
        }
        $this->adminView('admin/applications/show', compact('app'));
    }

    public function updateStatus(string $id): void {
        $this->csrfCheck();
        $app = $this->model->findById((int)$id);
        if (!$app) $this->json(['success' => false, 'message' => 'Not found.']);
        $newStatus = $_POST['status'] ?? 'pending';
        if (!in_array($newStatus, ['pending', 'approved', 'rejected'], true)) {
            $this->json(['success' => false, 'message' => 'Invalid status.']);
        }

        $update = [
            'status' => $newStatus,
            'notes'  => Security::clean($_POST['notes'] ?? ''),
        ];

        // Optional membership_id (assigned when approving).
        // Only include it if the column exists in the table — guards against missing-migration scenarios.
        if (array_key_exists('membership_id', $_POST)) {
            if ($this->columnExists('membership_applications', 'membership_id')) {
                $update['membership_id'] = Security::clean($_POST['membership_id']);
            }
        }

        try {
            $this->model->update($update, 'id = ?', [(int)$id]);
            $this->json(['success' => true, 'message' => 'Status updated successfully.']);
        } catch (\Throwable $e) {
            // Log full error server-side, return clean message to UI
            error_log('updateStatus failed: ' . $e->getMessage());
            $this->json([
                'success' => false,
                'message' => 'Failed to save: ' . $e->getMessage()
                    . '. If you see "Unknown column", please run /install.php → Run Migrations.',
            ]);
        }
    }

    /**
     * Check if a column exists in a table (caches result per request).
     */
    private function columnExists(string $table, string $column): bool {
        static $cache = [];
        $key = $table . '.' . $column;
        if (isset($cache[$key])) return $cache[$key];
        try {
            $db   = Database::getInstance();
            $stmt = $db->prepare('SHOW COLUMNS FROM `' . $table . '` LIKE ?');
            $stmt->execute([$column]);
            $cache[$key] = (bool)$stmt->fetch();
        } catch (\Throwable $e) {
            $cache[$key] = false;
        }
        return $cache[$key];
    }

    /**
     * GET /admin/applications/download/:id?key=photo|id_proof|...
     * Force-download an uploaded file with its original (or pretty) filename.
     * C8 / H3 / H19: subdir and filename are whitelisted to prevent arbitrary
     * file reads from disk.
     */
    public function download(string $id): void {
        $app = $this->model->findById((int)$id);
        if (!$app) { http_response_code(404); echo 'Not found'; return; }

        $key = (string)($_GET['key'] ?? '');
        if (!preg_match('/^[a-zA-Z0-9_-]{1,40}$/', $key)) {
            http_response_code(400); echo 'Invalid key'; return;
        }

        $filename = null;
        $subdir   = null;

        // Try legacy photo column first
        if ($key === 'photo' && !empty($app['photo'])) {
            $filename = (string)$app['photo'];
            $subdir   = 'applications/photos';
        } else {
            $uploaded = !empty($app['uploaded_files']) ? (json_decode($app['uploaded_files'], true) ?: []) : [];
            if (empty($uploaded[$key])) { http_response_code(404); echo 'File not found'; return; }
            $filename = (string)$uploaded[$key];
            $subdir   = ($key === 'photo' || $key === 'logo') ? 'applications/photos' : 'applications/docs';
        }

        // Whitelist subdir and filename
        $allowedSubdirs = ['applications/photos', 'applications/docs'];
        if (!in_array($subdir, $allowedSubdirs, true)) { http_response_code(400); echo 'Invalid path'; return; }
        // Filename must match the uploadFile() output pattern (hex_random_time.ext)
        if (!preg_match('/^[a-f0-9_]+\.[a-z0-9]{1,8}$/i', $filename)) {
            http_response_code(400); echo 'Invalid filename'; return;
        }

        $diskPath = rtrim(UPLOAD_PATH, '/') . '/' . $subdir . '/' . $filename;
        // Final realpath check — prevent symlink-based traversal
        $real = realpath($diskPath);
        $base = realpath(rtrim(UPLOAD_PATH, '/') . '/' . $subdir);
        if ($real === false || $base === false || strpos($real, $base . DIRECTORY_SEPARATOR) !== 0) {
            http_response_code(404); echo 'File missing on disk'; return;
        }

        // Safe download filename — strip ALL non-ASCII, strip CR/LF/quote
        $safeName = preg_replace('/[^a-zA-Z0-9._-]/', '-', $app['name'] ?? 'file');
        $safeName = trim($safeName, '-');
        if ($safeName === '') $safeName = 'file';
        $downloadName = $key . '-' . $safeName . '.' . pathinfo($filename, PATHINFO_EXTENSION);
        // Belt-and-suspenders: strip CR/LF in case the regex above missed anything
        $downloadName = str_replace(["\r", "\n", '"', '\\'], '', $downloadName);

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        // Use RFC 5987 for non-ASCII filenames (defensive)
        header('Content-Disposition: attachment; filename="' . $downloadName . '"; filename*=UTF-8\'\'' . rawurlencode($downloadName));
        header('X-Content-Type-Options: nosniff');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($real));
        readfile($real);
        exit;
    }

    public function delete(string $id): void {
        $this->csrfCheck();
        $app = $this->model->findById((int)$id);
        if ($app) {
            // Clean up legacy photo column
            if (!empty($app['photo'])) deleteFile('applications/photos/' . $app['photo']);
            // Clean up legacy qualifications JSON certs (for old applications)
            $quals = json_decode($app['qualifications'] ?? '[]', true) ?: [];
            foreach ($quals as $q) {
                if (!empty($q['cert_file'])) deleteFile('applications/certs/' . $q['cert_file']);
            }
            // Clean up new multi-variant uploaded_files
            $files = json_decode($app['uploaded_files'] ?? '[]', true) ?: [];
            foreach ($files as $key => $fn) {
                if (empty($fn)) continue;
                $subdir = ($key === 'photo' || $key === 'logo') ? 'applications/photos' : 'applications/docs';
                deleteFile($subdir . '/' . $fn);
            }
        }
        $this->model->delete('id = ?', [(int)$id]);
        $this->json(['success' => true, 'message' => 'Application deleted.']);
    }
}


// ============================================================
// ADMIN ARTICLE SUBMISSION CONTROLLER
// ============================================================
class AdminArticleController extends Controller {
    private ArticleSubmissionModel $model;

    public function __construct() {
        requireAdmin();
        $this->model = new ArticleSubmissionModel();
    }

    public function index(): void {
        $page          = max(1, (int)($_GET['page'] ?? 1));
        $q             = trim($_GET['q'] ?? '');
        $journalFilter = (int)($_GET['journal_id'] ?? 0);
        $status        = $_GET['status'] ?? '';
        $sort          = in_array($_GET['sort'] ?? '', ['title', 'journal_name', 'created_at', 'review_status'], true) ? $_GET['sort'] : 'created_at';
        $dir           = ($_GET['dir'] ?? 'desc') === 'asc' ? 'ASC' : 'DESC';

        // Build WHERE
        $where = []; $params = [];
        if ($journalFilter > 0) { $where[] = 'journal_id = ?'; $params[] = $journalFilter; }
        if (in_array($status, ['draft','submitted','under_review','accepted','rejected','published'], true)) {
            $where[] = 'review_status = ?'; $params[] = $status;
        }
        if ($q !== '') {
            $where[] = '(title LIKE ? OR submitter_name LIKE ? OR submitter_email LIKE ? OR contributors LIKE ?)';
            $like = '%' . $q . '%';
            array_push($params, $like, $like, $like, $like);
        }
        $whereSql = $where ? implode(' AND ', $where) : '';

        $total    = $this->model->count($whereSql, $params);
        $pag      = $this->paginate($total, ADMIN_PER_PAGE, $page);
        $articles = $this->model->findAll($whereSql, $params, $sort . ' ' . $dir, ADMIN_PER_PAGE, $pag['offset']);
        $journals = (new JournalModel())->getActive();

        $this->adminView('admin/articles/index', compact('articles', 'pag', 'total', 'journals', 'q', 'journalFilter', 'status', 'sort', 'dir'));
    }

    public function show(string $id): void {
        $article = $this->model->findById((int)$id);
        if (!$article) {
            $error = 'Article submission not found. It may have been deleted.';
            $this->adminView('admin/articles/index', ['error' => $error]);
            return;
        }
        $this->adminView('admin/articles/show', compact('article'));
    }

    public function edit(string $id): void {
        $article = $this->model->findById((int)$id);
        if (!$article) {
            $error = 'Article submission not found. It may have been deleted.';
            $this->adminView('admin/articles/index', ['error' => $error]);
            return;
        }
        $journals = (new JournalModel())->getActive();
        $this->adminView('admin/articles/edit', compact('article', 'journals'));
    }

    public function save(string $id): void {
        $this->csrfCheck();
        $article = $this->model->findById((int)$id);
        if (!$article) $this->json(['success' => false, 'message' => 'Not found.']);

        // Parse contributors
        $contribs = json_decode($_POST['contributors'] ?? '[]', true) ?: [];
        $cleanContribs = [];
        foreach ($contribs as $c) {
            if (empty($c['name']) || empty($c['email'])) continue;
            $cleanContribs[] = [
                'name'        => Security::clean($c['name']),
                'affiliation' => Security::clean($c['affiliation'] ?? ''),
                'email'       => Security::clean($c['email']),
                'phone'       => Security::clean($c['phone'] ?? ''),
                'role'        => in_array($c['role'] ?? 'Author', ['Author','Co-Author','Corresponding Author','Editor'], true) ? $c['role'] : 'Author',
            ];
        }

        // Parse keywords (comma-separated)
        $kwRaw = trim($_POST['keywords'] ?? '');
        $keywords = $kwRaw === '' ? [] : array_values(array_filter(array_map('trim', explode(',', $kwRaw))));

        // Resolve journal name
        $journalId = (int)($_POST['journal_id'] ?? $article['journal_id']);
        $journal   = (new JournalModel())->findById($journalId);

        $data = [
            'journal_id'   => $journalId,
            'journal_name' => $journal ? $journal['name'] : $article['journal_name'],
            'section'      => Security::clean($_POST['section'] ?? $article['section']),
            'prefix'       => Security::clean($_POST['prefix'] ?? ''),
            'title'        => Security::clean($_POST['title'] ?? $article['title']),
            'subtitle'     => Security::clean($_POST['subtitle'] ?? ''),
            'abstract'     => $_POST['abstract'] ?? $article['abstract'],
            'keywords'     => json_encode($keywords, JSON_UNESCAPED_UNICODE),
            'contributors' => json_encode($cleanContribs, JSON_UNESCAPED_UNICODE),
        ];

        try {
            $this->model->update($data, 'id = ?', [(int)$id]);
            $this->json(['success' => true, 'message' => 'Article saved.']);
        } catch (\Throwable $e) {
            $this->json(['success' => false, 'message' => 'Save failed: ' . $e->getMessage()]);
        }
    }

    public function updateStatus(string $id): void {
        $this->csrfCheck();
        $article = $this->model->findById((int)$id);
        if (!$article) $this->json(['success' => false, 'message' => 'Not found.']);

        $reviewStatus = $_POST['review_status'] ?? 'submitted';
        if (!in_array($reviewStatus, ['draft','submitted','under_review','accepted','rejected','published'], true)) {
            $this->json(['success' => false, 'message' => 'Invalid review status.']);
        }
        $pubStatus = ($_POST['publication_status'] ?? 'unpublished') === 'published' ? 'published' : 'unpublished';

        try {
            $this->model->update([
                'review_status'      => $reviewStatus,
                'publication_status' => $pubStatus,
                'notes'              => Security::clean($_POST['notes'] ?? ''),
            ], 'id = ?', [(int)$id]);
            $this->json(['success' => true, 'message' => 'Status updated.']);
        } catch (\Throwable $e) {
            $this->json(['success' => false, 'message' => 'Save failed: ' . $e->getMessage()]);
        }
    }

    public function delete(string $id): void {
        $this->csrfCheck();
        $article = $this->model->findById((int)$id);
        if ($article) {
            if (!empty($article['cover_image'])) deleteFile('articles/covers/' . $article['cover_image']);
            $files = json_decode($article['article_files'] ?? '[]', true) ?: [];
            foreach ($files as $f) {
                if (!empty($f['filename'])) deleteFile('articles/files/' . $f['filename']);
            }
        }
        $this->model->delete('id = ?', [(int)$id]);
        $this->json(['success' => true, 'message' => 'Article deleted.']);
    }

    /**
     * GET /admin/articles/download/:id?file=cover|article&idx=N
     * Force-download cover image or any article file with original filename.
     * C8: subdir and filename whitelisted; download filename sanitized.
     */
    public function download(string $id): void {
        $article = $this->model->findById((int)$id);
        if (!$article) { http_response_code(404); echo 'Not found'; return; }

        $type = (string)($_GET['file'] ?? 'article');
        if (!in_array($type, ['cover', 'article'], true)) { http_response_code(400); echo 'Invalid file type'; return; }
        $diskPath = null;
        $downloadName = null;
        $subdir = null;

        if ($type === 'cover') {
            if (empty($article['cover_image'])) { http_response_code(404); echo 'No cover image'; return; }
            $cover = (string)$article['cover_image'];
            if (!preg_match('/^[a-f0-9_]+\.[a-z0-9]{1,8}$/i', $cover)) { http_response_code(400); echo 'Invalid filename'; return; }
            $subdir       = 'articles/covers';
            $diskPath     = rtrim(UPLOAD_PATH, '/') . '/' . $subdir . '/' . $cover;
            $safeTitle    = preg_replace('/[^a-zA-Z0-9._-]/', '-', $article['title'] ?? 'cover');
            $safeTitle    = trim($safeTitle, '-');
            if ($safeTitle === '') $safeTitle = 'cover';
            $downloadName = 'cover-' . $safeTitle . '.' . pathinfo($cover, PATHINFO_EXTENSION);
        } else {
            $idx   = (int)($_GET['idx'] ?? 0);
            $files = !empty($article['article_files']) ? (json_decode($article['article_files'], true) ?: []) : [];
            if ($idx < 0 || !isset($files[$idx])) { http_response_code(404); echo 'File not found'; return; }
            $f = $files[$idx];
            $filename = (string)($f['filename'] ?? '');
            if (!preg_match('/^[a-f0-9_]+\.[a-z0-9]{1,8}$/i', $filename)) {
                http_response_code(400); echo 'Invalid filename'; return;
            }
            $subdir       = 'articles/files';
            $diskPath     = rtrim(UPLOAD_PATH, '/') . '/' . $subdir . '/' . $filename;
            $downloadName = (string)($f['original'] ?? $filename);
        }

        // Realpath check — prevent symlink/path traversal
        $real = $diskPath ? realpath($diskPath) : false;
        $base = $subdir ? realpath(rtrim(UPLOAD_PATH, '/') . '/' . $subdir) : false;
        if ($real === false || $base === false || strpos($real, $base . DIRECTORY_SEPARATOR) !== 0) {
            http_response_code(404); echo 'File missing on disk'; return;
        }

        // Sanitize download filename for Content-Disposition
        $downloadName = preg_replace('/[^A-Za-z0-9._-]/', '-', $downloadName);
        $downloadName = trim($downloadName, '-');
        if ($downloadName === '' || $downloadName === '.' || $downloadName === '..') $downloadName = 'download.bin';
        $downloadName = str_replace(["\r", "\n", '"', '\\'], '', $downloadName);

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $downloadName . '"; filename*=UTF-8\'\'' . rawurlencode($downloadName));
        header('X-Content-Type-Options: nosniff');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($real));
        readfile($real);
        exit;
    }

    /**
     * GET /admin/articles/export?format=csv|xlsx|pdf
     */
    public function export(): void {
        $format = strtolower($_GET['format'] ?? 'csv');
        $q             = trim($_GET['q'] ?? '');
        $journalFilter = (int)($_GET['journal_id'] ?? 0);
        $status        = $_GET['status'] ?? '';

        $where = []; $params = [];
        if ($journalFilter > 0) { $where[] = 'journal_id = ?'; $params[] = $journalFilter; }
        if (in_array($status, ['draft','submitted','under_review','accepted','rejected','published'], true)) {
            $where[] = 'review_status = ?'; $params[] = $status;
        }
        if ($q !== '') {
            $where[] = '(title LIKE ? OR submitter_name LIKE ? OR submitter_email LIKE ? OR contributors LIKE ?)';
            $like = '%' . $q . '%';
            array_push($params, $like, $like, $like, $like);
        }
        $whereSql = $where ? implode(' AND ', $where) : '';
        $articles = $this->model->findAll($whereSql, $params, 'created_at DESC', 10000, 0);

        // Build rows
        $headers = ['ID', 'Journal', 'Section', 'Title', 'Subtitle', 'Authors', 'Submitter', 'Email', 'Review Status', 'Publication', 'Submitted'];
        $rows = [];
        foreach ($articles as $a) {
            $contribs = !empty($a['contributors']) ? (json_decode($a['contributors'], true) ?: []) : [];
            $authors  = implode('; ', array_map(fn($c) => ($c['name'] ?? '') . ' (' . ($c['role'] ?? 'Author') . ')', $contribs));
            $rows[] = [
                $a['id'],
                $a['journal_name'],
                $a['section'],
                $a['title'],
                $a['subtitle'] ?? '',
                $authors,
                $a['submitter_name'] ?? '',
                $a['submitter_email'] ?? '',
                str_replace('_', ' ', $a['review_status']),
                $a['publication_status'],
                date('Y-m-d H:i', strtotime($a['created_at'])),
            ];
        }

        $filename = 'articles-' . date('Y-m-d-His');

        if ($format === 'csv') {
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
            $fp = fopen('php://output', 'w');
            // BOM for Excel UTF-8
            fputs($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($fp, $headers);
            foreach ($rows as $r) fputcsv($fp, $r);
            fclose($fp);
            exit;
        }

        if ($format === 'xlsx') {
            // Use HTML-flavored Excel (works in Excel + LibreOffice without libraries)
            header('Content-Type: application/vnd.ms-excel; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
            echo "<html><head><meta charset='utf-8'></head><body>";
            echo "<table border='1'><thead><tr>";
            foreach ($headers as $h) echo "<th>" . htmlspecialchars($h) . "</th>";
            echo "</tr></thead><tbody>";
            foreach ($rows as $r) {
                echo "<tr>";
                foreach ($r as $cell) echo "<td>" . htmlspecialchars((string)$cell) . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table></body></html>";
            exit;
        }

        if ($format === 'pdf') {
            // Render an HTML page that auto-opens print dialog (Save as PDF)
            header('Content-Type: text/html; charset=utf-8');
            echo "<!DOCTYPE html><html><head><meta charset='utf-8'><title>Articles Export</title>";
            echo "<style>
                body { font-family: Arial, sans-serif; padding: 20px; color: #1f2937; }
                h1 { color: #0F4C75; font-size: 18px; margin-bottom: 4px; }
                .meta { font-size: 11px; color: #6b7280; margin-bottom: 16px; }
                table { width: 100%; border-collapse: collapse; font-size: 10px; }
                th { background: #0F4C75; color: white; padding: 6px 4px; text-align: left; font-weight: 600; }
                td { padding: 6px 4px; border-bottom: 1px solid #e5e7eb; vertical-align: top; }
                tr:nth-child(even) td { background: #f9fafb; }
                .no-print { margin: 20px 0; text-align: right; }
                .no-print button { padding: 8px 16px; font-weight: 600; cursor: pointer; }
                @media print { .no-print { display: none; } }
            </style></head><body>";
            echo "<h1>Article Submissions Export</h1>";
            echo "<p class='meta'>Generated " . date('Y-m-d H:i') . " · Total: " . count($rows) . " articles</p>";
            echo "<div class='no-print'><button onclick='window.print()'>🖨️ Print / Save as PDF</button></div>";
            echo "<table><thead><tr>";
            foreach ($headers as $h) echo "<th>" . htmlspecialchars($h) . "</th>";
            echo "</tr></thead><tbody>";
            foreach ($rows as $r) {
                echo "<tr>";
                foreach ($r as $cell) echo "<td>" . htmlspecialchars((string)$cell) . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
            echo "<script>setTimeout(()=>window.print(),500);</script>";
            echo "</body></html>";
            exit;
        }

        $this->json(['success' => false, 'message' => 'Invalid export format.']);
    }
}

// ============================================================
// ADMIN TESTIMONIAL CONTROLLER
// ============================================================
class AdminTestimonialController extends Controller {
    private TestimonialModel $model;
    public function __construct() { requireAdmin(); $this->model = new TestimonialModel(); }

    public function index(): void {
        $testimonials = $this->model->getAllOrdered();
        $this->adminView('admin/testimonials/index', compact('testimonials'));
    }

    public function create(): void {
        $testimonial = null;
        $this->adminView('admin/testimonials/form', compact('testimonial'));
    }

    public function edit(string $id): void {
        $testimonial = $this->model->findById((int)$id);
        if (!$testimonial) redirect(BASE_URL . '/admin/testimonials');
        $this->adminView('admin/testimonials/form', compact('testimonial'));
    }

    public function store(): void {
        $this->csrfCheck();
        $name = Security::clean($_POST['reviewer_name'] ?? '');
        $content = Security::clean($_POST['content'] ?? '');
        if (!$name)    $this->json(['success' => false, 'message' => 'Reviewer name is required.']);
        if (!$content) $this->json(['success' => false, 'message' => 'Review content is required.']);

        $data = $this->testimonialData();
        $id = $this->model->insert($data);
        $this->json([
            'success'  => true,
            'message'  => 'Testimonial added successfully!',
            'redirect' => BASE_URL . '/admin/testimonials',
            'id'       => $id,
        ]);
    }

    public function update(string $id): void {
        $this->csrfCheck();
        $existing = $this->model->findById((int)$id);
        if (!$existing) $this->json(['success' => false, 'message' => 'Testimonial not found.']);

        $data = $this->testimonialData();
        $this->model->update($data, 'id = ?', [(int)$id]);
        $this->json([
            'success'  => true,
            'message'  => 'Testimonial updated successfully!',
            'redirect' => BASE_URL . '/admin/testimonials',
        ]);
    }

    public function toggle(string $id): void {
        $this->csrfCheck();
        $t = $this->model->findById((int)$id);
        if (!$t) $this->json(['success' => false, 'message' => 'Not found.']);
        $new = $t['is_active'] ? 0 : 1;
        $this->model->update(['is_active' => $new], 'id = ?', [(int)$id]);
        $this->json(['success' => true, 'active' => $new, 'message' => 'Status updated.']);
    }

    public function delete(string $id): void {
        $this->csrfCheck();
        $this->model->delete('id = ?', [(int)$id]);
        $this->json(['success' => true, 'message' => 'Testimonial deleted.']);
    }

    // ---- helper ----
    private function testimonialData(): array {
        $name = Security::clean($_POST['reviewer_name'] ?? '');
        $letter = strtoupper(substr($_POST['avatar_letter'] ?? ($name ?: 'U'), 0, 1));

        return [
            'reviewer_name' => $name,
            'designation'   => Security::clean($_POST['designation'] ?? ''),
            'organization'  => Security::clean($_POST['organization'] ?? ''),
            'avatar_color'  => Security::clean($_POST['avatar_color'] ?? '#1e73be'),
            'avatar_letter' => Security::clean($letter),
            'rating'        => max(1, min(5, (int)($_POST['rating'] ?? 5))),
            'content'       => Security::clean($_POST['content'] ?? ''),
            'review_count'  => Security::clean($_POST['review_count'] ?? '1 review'),
            'source'        => Security::clean($_POST['source'] ?? 'Google'),
            'review_date'   => Security::clean($_POST['review_date'] ?? ''),
            'sort_order'    => (int)($_POST['sort_order'] ?? 0),
            'is_active'     => !empty($_POST['is_active']) ? 1 : 0,
        ];
    }
}

// ============================================================
// ADMIN PAGE (CMS) CONTROLLER
// ============================================================
class AdminPageController extends Controller {
    private PageModel $model;
    public function __construct() { requireAdmin(); $this->model = new PageModel(); }

    public function index(): void {
        $pages = $this->model->findAll('', [], 'title ASC');
        $this->adminView('admin/pages/index', compact('pages'));
    }

    public function edit(string $id): void {
        $page = $this->model->findById((int)$id);
        if (!$page) { redirect(BASE_URL . '/admin/pages'); return; }
        $this->adminView('admin/pages/edit', compact('page'));
    }

    public function update(string $id): void {
        $this->csrfCheck();

        // Verify the page exists before attempting an update
        $existing = $this->model->findById((int)$id);
        if (!$existing) {
            $this->json(['success' => false, 'message' => 'Page not found.'], 404);
        }

        $data = [
            'title'            => Security::clean($_POST['title'] ?? ''),
            'content'          => $_POST['content'] ?? '', // HTML — do not strip
            'excerpt'          => Security::clean($_POST['excerpt'] ?? ''),
            'status'           => ($_POST['status'] ?? 'draft') === 'published' ? 'published' : 'draft',
            'meta_title'       => Security::clean($_POST['meta_title'] ?? ''),
            'meta_description' => Security::clean($_POST['meta_description'] ?? ''),
        ];
        if (empty($data['title'])) {
            $this->json(['success' => false, 'message' => 'Title is required.']);
        }

        $this->model->update($data, 'id = ?', [(int)$id]);
        $this->json(['success' => true, 'message' => 'Page updated successfully!']);
    }
}
