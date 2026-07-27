
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS admins, settings, seo_settings, menus, pages, books, journals,
  editorial_board, reviewer_board, memberships, services, gallery_categories, gallery,
  contact_messages, payment_details, news, csrf_tokens;
SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- ADMINS
-- ============================================================
CREATE TABLE admins (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  name       VARCHAR(100) NOT NULL,
  email      VARCHAR(150) UNIQUE NOT NULL,
  password   VARCHAR(255) NOT NULL,
  role       ENUM('super_admin','admin') DEFAULT 'admin',
  avatar     VARCHAR(255) DEFAULT NULL,
  last_login DATETIME DEFAULT NULL,
  is_active  TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Password: Admin@123
-- Admin password is set via install.php Step 4 (generates proper bcrypt hash)
-- Placeholder hash below = 'Admin@123' - USE install.php to set your own password!
INSERT INTO admins (name, email, password, role, is_active) VALUES
('Super Admin', 'admin@bookpublication.com',
 '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'super_admin', 1);
-- ↑ The hash above is for the string 'password' (temporary placeholder)
-- IMMEDIATELY go to /install.php → Step 4 to set your real password!

-- ============================================================
-- SETTINGS
-- ============================================================
CREATE TABLE settings (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  setting_key   VARCHAR(100) UNIQUE NOT NULL,
  setting_value LONGTEXT,
  created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO settings (setting_key, setting_value) VALUES
('site_name',            'Sujata Publications'),
('site_tagline',         'Advancing Knowledge Through Quality Publications'),
('site_email',           'info@bookpublication.com'),
('site_phone',           '+91 000-000-0000'),
('site_address',         '123 Academic Street, Knowledge City, India'),
('site_logo',            ''),
('site_favicon',         ''),
('footer_about',         'We are dedicated to publishing high-quality academic books and journals that advance knowledge across all disciplines.'),
('footer_copyright',     '© 2025 Sujata Publications. All Rights Reserved.'),
('google_map_embed',     ''),
('facebook_url',         ''),
('twitter_url',          ''),
('linkedin_url',         ''),
('instagram_url',        ''),
('youtube_url',          ''),
('telegram_url',         ''),
('whatsapp',             ''),
('business_hours',       'Mon–Fri: 9:00 AM – 6:00 PM'),
('google_analytics',     ''),
('gtm_id',              ''),
('head_scripts',         ''),
('body_scripts',         ''),
('primary_color',        '#0d3051'),
('secondary_color',      '#cc1824'),
('maintenance_mode',     '0'),
('counter_total_books',  '500'),
('counter_total_journals','50'),
('counter_total_members','10000'),
('counter_years_exp',    '15');

-- ============================================================
-- SEO SETTINGS
-- ============================================================
CREATE TABLE seo_settings (
  id               INT AUTO_INCREMENT PRIMARY KEY,
  page_key         VARCHAR(100) UNIQUE NOT NULL,
  page_title       VARCHAR(255),
  meta_description TEXT,
  meta_keywords    TEXT,
  og_title         VARCHAR(255),
  og_description   TEXT,
  og_image         VARCHAR(255),
  canonical_url    VARCHAR(255),
  created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO seo_settings (page_key, page_title, meta_description) VALUES
('home',       'Home | Sujata Publications',       'Leading academic book publication and journal management platform.'),
('about',      'About Us | International Book Publication',   'Learn about our mission, editorial board, and publishing standards.'),
('books',      'All Books | International Book Publication',  'Browse our complete collection of academic and research books.'),
('journals',   'Our Journals | International Book Publication','Explore our peer-reviewed academic journals.'),
('membership', 'Membership | International Book Publication', 'Join our academic community with exclusive membership benefits.'),
('services',   'Our Services | International Book Publication','Comprehensive publishing and research services.'),
('gallery',    'Gallery | International Book Publication',    'Photos and videos from our events and conferences.'),
('contact',    'Contact Us | International Book Publication', 'Get in touch with our team for any queries.'),
('news',       'News & Updates | International Book Publication','Latest news, announcements and academic updates.');

-- ============================================================
-- MENUS
-- ============================================================
CREATE TABLE menus (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  parent_id  INT DEFAULT NULL,
  label      VARCHAR(100) NOT NULL,
  url        VARCHAR(255) NOT NULL,
  target     ENUM('_self','_blank') DEFAULT '_self',
  icon       VARCHAR(100) DEFAULT NULL,
  sort_order INT DEFAULT 0,
  is_active  TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (parent_id) REFERENCES menus(id) ON DELETE SET NULL
);

INSERT INTO menus (id, parent_id, label, url, sort_order) VALUES
(1, NULL, 'Home',           '/',                 1),
(2, NULL, 'About Us',       '/about',            2),
(3, NULL, 'Books',          '/books',            3),
(4, NULL, 'Journals',       '/journals',         4),
(5, NULL, 'Membership',     '/membership',       5),
(6, NULL, 'Services',       '/services',         6),
(7, NULL, 'Gallery',        '/gallery',          7),
(8, NULL, 'News',           '/news',             8),
(9, NULL, 'Contact',        '/contact',          9),
(10, 2,   'About Us',       '/about',            1),
(11, 2,   'Editorial Board','/editorial-board',  2),
(12, 2,   'Reviewer Board', '/reviewer-board',   3),
(13, 3,   'All Books',      '/books',            1),
(14, 3,   'Conference Abstract Book', '/conference-abstract-book', 2),
(15, 5,   'Benefit of Membership',  '/membership/benefits',  1),
(16, 5,   'Types of Membership',    '/membership-types',    2),
(17, 5,   'Apply for Membership',   '/membership-types#apply', 3),
(18, 5,   'Membership List',        '/membership',         4);

-- ============================================================
-- PAGES (CMS)
-- ============================================================
CREATE TABLE pages (
  id               INT AUTO_INCREMENT PRIMARY KEY,
  title            VARCHAR(255) NOT NULL,
  slug             VARCHAR(255) UNIQUE NOT NULL,
  content          LONGTEXT,
  excerpt          TEXT,
  status           ENUM('published','draft') DEFAULT 'published',
  layout           VARCHAR(50) DEFAULT 'default',
  show_in_menu     TINYINT(1) DEFAULT 0,
  show_breadcrumb  TINYINT(1) DEFAULT 1,
  meta_title       VARCHAR(255),
  meta_description TEXT,
  meta_keywords    TEXT,
  is_published     TINYINT(1) DEFAULT 1,
  created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO pages (title, slug, content, status) VALUES
('Privacy Policy',  'privacy-policy',  '<h2>Privacy Policy</h2><p>This privacy policy sets out how we collect and use personal information...</p>', 'published'),
('Terms of Service','terms-of-service','<h2>Terms of Service</h2><p>By using our website, you agree to these terms and conditions...</p>', 'published'),
('Aims & Objectives','aims-objectives', '<h2>Aims & Objectives</h2><p>Our primary aim is to publish and disseminate high-quality academic research...</p>', 'published'),
('Benefit of Membership', 'benefit-of-membership', '<h2>Why Become a Member?</h2><p>Discover the exclusive benefits available to Sujata Publications members.</p><h3>Research &amp; Publication</h3><ul><li>Discounted article processing charges in member journals</li><li>Priority review and faster publication turnaround</li><li>Free certificate of membership</li></ul><h3>Networking &amp; Community</h3><ul><li>Access to the Sujata Publications academic community</li><li>Invitations to conferences, seminars and workshops</li><li>Eligibility to serve on editorial and review boards</li></ul><p><em>You can edit this content from the admin CMS.</em></p>', 'published'),
('Types of Membership', 'types-of-membership', '<h2>Types of Membership</h2><p>Sujata Publications offers a range of membership categories to suit every researcher, professional and institution.</p><h3>Individual Membership</h3><ul><li>Honorary Membership</li><li>Life Membership</li><li>Life Membership (Senior Category)</li><li>Student Membership</li><li>International Membership</li></ul><h3>Institutional Membership</h3><ul><li>Patron Membership</li><li>Institutional Membership</li></ul><p><em>You can edit this content from the admin CMS.</em></p>', 'published');

-- ============================================================
-- BOOKS
-- ============================================================
CREATE TABLE books (
  id               INT AUTO_INCREMENT PRIMARY KEY,
  title            VARCHAR(255) NOT NULL,
  slug             VARCHAR(255) UNIQUE NOT NULL,
  authors          VARCHAR(500) NOT NULL,
  isbn             VARCHAR(50),
  description      LONGTEXT,
  cover_image      VARCHAR(255),
  pdf_file         VARCHAR(255),
  category         VARCHAR(100),
  publisher        VARCHAR(200),
  publication_date DATE,
  edition          VARCHAR(50),
  pages_count      INT DEFAULT 0,
  language         VARCHAR(50) DEFAULT 'English',
  price            DECIMAL(10,2) DEFAULT 0.00,
  is_featured      TINYINT(1) DEFAULT 0,
  is_published     TINYINT(1) DEFAULT 1,
  meta_title       VARCHAR(255),
  meta_description TEXT,
  meta_keywords    TEXT,
  views            INT DEFAULT 0,
  sort_order       INT DEFAULT 0,
  created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO books (title, slug, authors, isbn, description, category, publisher, publication_date, pages_count, price, is_featured, is_published) VALUES
('Advanced Research Methodology', 'advanced-research-methodology', 'Dr. Rajesh Kumar, Prof. Anita Singh', '978-0-123456-47-2', '<p>A comprehensive guide to modern research methodology for graduate students and researchers.</p>', 'Research', 'IBP Press', '2024-01-15', 450, 999.00, 1, 1),
('Quantum Physics Fundamentals', 'quantum-physics-fundamentals', 'Dr. Priya Sharma', '978-0-123456-48-9', '<p>An introductory textbook covering the fundamentals of quantum physics.</p>', 'Physics', 'IBP Press', '2024-03-20', 380, 1299.00, 1, 1),
('Environmental Science Today', 'environmental-science-today', 'Dr. Amit Verma, Dr. Neha Gupta', '978-0-123456-49-6', '<p>Explores current environmental challenges and sustainable solutions.</p>', 'Science', 'IBP Press', '2023-11-10', 520, 899.00, 0, 1),
('History of Modern India', 'history-of-modern-india', 'Prof. Sunita Patel', '978-0-123456-50-2', '<p>A detailed account of India from independence to the present day.</p>', 'History', 'IBP Press', '2023-08-05', 610, 799.00, 1, 1);

-- ============================================================
-- JOURNALS
-- ============================================================
CREATE TABLE journals (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  name        VARCHAR(255) NOT NULL,
  abbreviation VARCHAR(50),
  description TEXT,
  logo        VARCHAR(255),
  issn        VARCHAR(50),
  e_issn      VARCHAR(50),
  journal_url VARCHAR(500) NOT NULL,
  link_type   ENUM('external','internal') DEFAULT 'external',
  is_active   TINYINT(1) DEFAULT 1,
  sort_order  INT DEFAULT 0,
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO journals (name, abbreviation, description, issn, e_issn, journal_url, sort_order) VALUES
('International Journal of Advanced Research', 'IJAR', 'Peer-reviewed multidisciplinary journal covering science, technology, and humanities.', '2320-5407', '2320-5415', 'https://www.ijarjournal.com', 1),
('Journal of Academic Sciences', 'JAS', 'Monthly journal publishing original research in pure and applied sciences.', '2348-0386', '2348-0394', 'https://www.jasjournal.com', 2),
('International Research Journal of Education', 'IRJE', 'Dedicated to educational research and pedagogy innovations.', '2456-1917', '2456-1925', 'https://www.irjedu.com', 3),
('Global Journal of Medical Sciences', 'GJMS', 'Publishes breakthrough medical and clinical research worldwide.', '2456-9348', '2456-9356', 'https://www.gjmsjournal.com', 4);

-- ============================================================
-- EDITORIAL BOARD
-- ============================================================
CREATE TABLE editorial_board (
  id             INT AUTO_INCREMENT PRIMARY KEY,
  name           VARCHAR(150) NOT NULL,
  designation    VARCHAR(200),
  qualification  VARCHAR(300),
  institution    VARCHAR(300),
  country        VARCHAR(100),
  email          VARCHAR(150),
  photo          VARCHAR(255),
  bio            TEXT,
  specialization VARCHAR(300),
  sort_order     INT DEFAULT 0,
  is_active      TINYINT(1) DEFAULT 1,
  created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO editorial_board (name, designation, qualification, institution, country, specialization, sort_order) VALUES
('Prof. David Chen',      'Editor-in-Chief',     'Ph.D. in Computer Science', 'MIT, USA',              'United States', 'Artificial Intelligence, Machine Learning', 1),
('Dr. Sarah Mitchell',    'Associate Editor',    'Ph.D. in Biology',          'Oxford University, UK', 'United Kingdom','Molecular Biology, Genetics',              2),
('Prof. Hiroshi Tanaka',  'Regional Editor',     'Ph.D. in Physics',          'Tokyo University, Japan','Japan',         'Quantum Physics, Nanotechnology',          3),
('Dr. Priya Krishnaswamy','Managing Editor',     'Ph.D. in Chemistry',        'IIT Delhi, India',      'India',         'Organic Chemistry, Pharmaceutical Sciences',4);

-- ============================================================
-- REVIEWER BOARD
-- ============================================================
CREATE TABLE reviewer_board (
  id             INT AUTO_INCREMENT PRIMARY KEY,
  name           VARCHAR(150) NOT NULL,
  designation    VARCHAR(200),
  qualification  VARCHAR(300),
  institution    VARCHAR(300),
  country        VARCHAR(100),
  email          VARCHAR(150),
  photo          VARCHAR(255),
  bio            TEXT,
  specialization VARCHAR(300),
  sort_order     INT DEFAULT 0,
  is_active      TINYINT(1) DEFAULT 1,
  created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO reviewer_board (name, designation, qualification, institution, country, specialization, sort_order) VALUES
('Dr. Michael Brown',   'Senior Reviewer',  'Ph.D. in Economics',      'Harvard University, USA','United States','Macroeconomics, Development Economics', 1),
('Dr. Fatima Al-Hassan','Reviewer',         'Ph.D. in Mathematics',    'University of Cairo',   'Egypt',        'Applied Mathematics, Statistics',      2),
('Prof. Li Wei',        'Expert Reviewer',  'Ph.D. in Engineering',    'Tsinghua University',   'China',        'Civil Engineering, Structural Analysis',3);

-- ============================================================
-- MEMBERSHIPS
-- ============================================================
CREATE TABLE memberships (
  id               INT AUTO_INCREMENT PRIMARY KEY,
  name             VARCHAR(100) NOT NULL,
  price            DECIMAL(10,2) DEFAULT 0.00,
  duration_months  INT DEFAULT 12,
  description      TEXT,
  features         JSON,
  badge_color      VARCHAR(20) DEFAULT '#0d3051',
  is_featured      TINYINT(1) DEFAULT 0,
  is_active        TINYINT(1) DEFAULT 1,
  sort_order       INT DEFAULT 0,
  created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO memberships (name, price, duration_months, description, features, badge_color, is_featured, sort_order) VALUES
('Basic',    499.00,  12, 'Perfect for individual researchers', JSON_ARRAY('Access to 100+ journals','5 paper downloads/month','Email support','Digital certificate'), '#6b7280', 0, 1),
('Standard', 999.00,  12, 'Ideal for academics and educators',  JSON_ARRAY('Access to 500+ journals','20 paper downloads/month','Priority support','Digital certificate','Research newsletter'), '#0d3051', 1, 2),
('Premium',  1999.00, 12, 'For institutions and research labs', JSON_ARRAY('Unlimited journal access','Unlimited downloads','Dedicated account manager','Publication discounts','Quarterly reports','API access'), '#cc1824', 0, 3);

-- ============================================================
-- SERVICES
-- ============================================================
CREATE TABLE services (
  id                INT AUTO_INCREMENT PRIMARY KEY,
  title             VARCHAR(255) NOT NULL,
  slug              VARCHAR(255) UNIQUE NOT NULL,
  short_description VARCHAR(500),
  content           LONGTEXT,
  icon              VARCHAR(100),
  image             VARCHAR(255),
  cta_text          VARCHAR(100) DEFAULT 'Learn More',
  cta_url           VARCHAR(255) DEFAULT '/contact',
  is_active         TINYINT(1) DEFAULT 1,
  meta_title        VARCHAR(255),
  meta_description  TEXT,
  sort_order        INT DEFAULT 0,
  created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO services (title, slug, short_description, icon, cta_text, cta_url, sort_order) VALUES
('Book Publishing',       'book-publishing',       'Complete end-to-end book publishing services from manuscript to distribution.', 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'Get Started', '/contact', 1),
('Journal Management',    'journal-management',    'Comprehensive journal management including peer review and indexing support.', 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'Learn More', '/contact', 2),
('Research Assistance',   'research-assistance',   'Expert guidance for literature reviews, data analysis, and report writing.', 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z', 'Enquire Now', '/contact', 3),
('Plagiarism Check',      'plagiarism-check',      'Advanced plagiarism detection using industry-leading software tools.', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4', 'Check Now', '/contact', 4),
('Conference Support',    'conference-support',    'End-to-end conference and seminar organization and proceedings publication.', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'Plan Event', '/contact', 5),
('Certificate Issuance',  'certificate-issuance',  'Official certificates of publication, participation, and peer review.', 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z', 'Request Certificate', '/contact', 6);

-- ============================================================
-- GALLERY CATEGORIES
-- ============================================================
CREATE TABLE gallery_categories (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  name       VARCHAR(100) NOT NULL,
  slug       VARCHAR(100) UNIQUE NOT NULL,
  description TEXT,
  color      VARCHAR(20) DEFAULT '#0d3051',
  sort_order INT DEFAULT 0,
  is_active  TINYINT(1) DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO gallery_categories (name, slug, description, color, sort_order) VALUES
('Events',        'events',        'Conferences, seminars and academic events',    '#0d3051', 1),
('Campus',        'campus',        'Campus and office photographs',                '#10b981', 2),
('Publications',  'publications',  'Book launches and publication ceremonies',      '#cc1824', 3),
('Workshops',     'workshops',     'Training sessions and workshops',               '#f59e0b', 4);

-- ============================================================
-- GALLERY
-- ============================================================
CREATE TABLE gallery (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT DEFAULT NULL,
  title       VARCHAR(255),
  description TEXT,
  file_path   VARCHAR(255),
  media_type  ENUM('image','video') DEFAULT 'image',
  video_url   VARCHAR(500),
  alt_text    VARCHAR(255),
  is_active   TINYINT(1) DEFAULT 1,
  sort_order  INT DEFAULT 0,
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES gallery_categories(id) ON DELETE SET NULL
);

-- ============================================================
-- CONTACT MESSAGES
-- ============================================================
CREATE TABLE contact_messages (
  id               INT AUTO_INCREMENT PRIMARY KEY,
  name             VARCHAR(100) NOT NULL,
  email            VARCHAR(150) NOT NULL,
  phone            VARCHAR(20),
  subject          VARCHAR(255),
  service_interest VARCHAR(150),
  message          TEXT NOT NULL,
  is_read          TINYINT(1) DEFAULT 0,
  ip_address       VARCHAR(45),
  created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
-- PAYMENT DETAILS
-- ============================================================
CREATE TABLE payment_details (
  id             INT AUTO_INCREMENT PRIMARY KEY,
  bank_name      VARCHAR(150),
  account_holder VARCHAR(150),
  account_number VARCHAR(50),
  ifsc_code      VARCHAR(20),
  branch_name    VARCHAR(150),
  swift_code     VARCHAR(20),
  bank_notes     TEXT,
  upi_id         VARCHAR(100),
  upi_name       VARCHAR(100),
  qr_code        VARCHAR(255),
  is_active      TINYINT(1) DEFAULT 1,
  updated_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO payment_details (bank_name, account_holder, account_number, ifsc_code, upi_id) VALUES
('State Bank of India', 'International Book Publication', '1234567890123', 'SBIN0001234', 'ibpublication@upi');

-- ============================================================
-- NEWS / BLOG
-- ============================================================
CREATE TABLE news (
  id               INT AUTO_INCREMENT PRIMARY KEY,
  title            VARCHAR(255) NOT NULL,
  slug             VARCHAR(255) UNIQUE NOT NULL,
  excerpt          TEXT,
  content          LONGTEXT,
  featured_image   VARCHAR(255),
  author           VARCHAR(100) DEFAULT 'Admin',
  tags             VARCHAR(300),
  status           ENUM('published','draft') DEFAULT 'draft',
  is_featured      TINYINT(1) DEFAULT 0,
  is_published     TINYINT(1) DEFAULT 0,
  meta_title       VARCHAR(255),
  meta_description TEXT,
  meta_keywords    TEXT,
  views            INT DEFAULT 0,
  published_at     DATETIME DEFAULT CURRENT_TIMESTAMP,
  created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO news (title, slug, excerpt, content, author, status, is_featured, is_published, published_at) VALUES
('New Research Publication Guidelines 2025', 'research-publication-guidelines-2025',
 'We have updated our research publication guidelines to align with international standards.',
 '<p>We are pleased to announce updated publication guidelines for 2025, incorporating feedback from our global author community...</p>',
 'Editorial Team', 'published', 1, 1, '2025-01-15 09:00:00'),
('Annual Conference Registration Now Open', 'annual-conference-registration-2025',
 'Registration for the Annual International Academic Conference 2025 is now officially open.',
 '<p>Join thousands of researchers and academics at our flagship annual conference...</p>',
 'Events Team', 'published', 0, 1, '2025-02-10 10:00:00'),
('New Indexing Partnership with Scopus', 'new-indexing-partnership-scopus',
 'We are proud to announce a new indexing partnership that will benefit all our journal authors.',
 '<p>Our journals are now indexed in Scopus, one of the world''s leading abstract and citation databases...</p>',
 'Admin', 'published', 1, 1, '2025-03-05 11:00:00');

-- ============================================================
-- CSRF TOKENS (optional server-side store)
-- ============================================================
CREATE TABLE csrf_tokens (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  token      VARCHAR(64) NOT NULL,
  session_id VARCHAR(64),
  expires_at DATETIME NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_token (token),
  INDEX idx_session (session_id)
);

-- ============================================================
-- CONFERENCES
-- ============================================================
CREATE TABLE IF NOT EXISTS conferences (
  id                INT AUTO_INCREMENT PRIMARY KEY,
  title             VARCHAR(255) NOT NULL,
  slug              VARCHAR(255) UNIQUE NOT NULL,
  subtitle          VARCHAR(500),
  theme_organization TEXT,
  intro_paragraph   TEXT,
  poster_image      VARCHAR(255),
  conference_brochure VARCHAR(255),
  registration_link VARCHAR(500),
  registration_fee  VARCHAR(100),
  registration_includes TEXT,
  seats_info        VARCHAR(255),
  abstract_email    VARCHAR(150),
  abstract_info     TEXT,
  prize_first       VARCHAR(100),
  prize_second      VARCHAR(100),
  prize_third       VARCHAR(100),
  award_categories  TEXT,
  contact_phone     VARCHAR(150),
  contact_email     VARCHAR(150),
  conference_date   DATE,
  is_active         TINYINT(1) DEFAULT 1,
  sort_order        INT DEFAULT 0,
  meta_title        VARCHAR(255),
  meta_description  TEXT,
  created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_active_date (is_active, conference_date)
);

-- ============================================================
-- ADD CONFERENCES MENU ITEM (top-level)
-- ============================================================
INSERT IGNORE INTO menus (parent_id, label, url, sort_order, is_active)
VALUES (NULL, 'Conferences', '/conferences', 7, 1);

-- ============================================================
-- MEMBERSHIP TYPES (detailed application page)
-- ============================================================
CREATE TABLE IF NOT EXISTS membership_types (
  id                INT AUTO_INCREMENT PRIMARY KEY,
  badge_number      INT NOT NULL DEFAULT 1,
  title             VARCHAR(150) NOT NULL,
  slug              VARCHAR(150) NOT NULL UNIQUE,
  fee_label         VARCHAR(100),
  fee_short         VARCHAR(60),
  card_color        VARCHAR(30) DEFAULT 'purple',
  is_full_width     TINYINT(1) DEFAULT 0,
  eligibility_title VARCHAR(150),
  eligibility       TEXT,
  details           TEXT,
  footer_note       TEXT,
  nomination_emails TEXT,
  duration_label    VARCHAR(60),
  comparison_eligibility VARCHAR(255),
  is_active         TINYINT(1) DEFAULT 1,
  sort_order        INT DEFAULT 0,
  created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO membership_types
  (badge_number, title, slug, fee_label, fee_short, card_color, is_full_width, eligibility_title, eligibility, details, footer_note, nomination_emails, duration_label, comparison_eligibility, sort_order)
VALUES
(1, 'Honorary Membership', 'honorary', 'Free (Nomination Based)', 'Free', 'purple', 1, NULL, NULL,
 'Awarded to distinguished scientists, academicians, or professionals for exceptional contributions to pharmaceutical and biomedical research.\nConferred by the Editorial or Advisory Board.\nNo application required — nomination-based only.',
 NULL,
 'info@sujatapublications.org, sujatapublications@gmail.com',
 'Lifetime',
 'By nomination only — distinguished scientists & academicians', 1),

(2, 'Patron Membership', 'patron', '₹49,999/-', '₹49,999', 'blue', 0, NULL, NULL,
 'For individuals or organizations contributing significantly to research promotion.\nAll membership privileges with special recognition status.\nIdeal for senior professionals, industry leaders & sponsors.',
 'Financial or strategic contributors to the organization', NULL,
 'Lifetime',
 'Senior professionals, industry leaders & sponsors', 2),

(3, 'Institutional Membership', 'institutional', '₹29,999/-', '₹29,999', 'amber', 0, NULL, NULL,
 'Open to universities, colleges, research institutes, hospitals & pharmaceutical industries.\nMultiple representatives from the institution can participate.\nPromotes institutional collaboration in research, publications & conferences.',
 'Eligible for institutions engaged in teaching, research or pharmaceutical activities', NULL,
 'Lifetime',
 'Universities, colleges, research institutes & hospitals', 3),

(4, 'Life Membership', 'life', '₹999/-', '₹999', 'green', 0, 'Eligibility (age 21+):',
 'Degree in pharmacy or graduation from a recognized University in India or abroad.\nDiploma from a recognized University in India or abroad.\nBachelor''s or higher degree in Basic, Life Sciences and/or Applied Sciences from a recognized University.',
 'One-time registration with lifetime benefits & privileges.\nAvailable to professionals, academicians & researchers.\nIdeal for long-term association and academic growth.',
 'SBC has discretion to reject any application without ascribing reasons', NULL,
 'Lifetime',
 'Graduates in pharmacy / life sciences (age 21+)', 4),

(5, 'Life Membership (Senior Category)', 'life-senior', '₹799/-', '₹799', 'pink', 0, NULL, NULL,
 'Special category for experienced professionals above 60–65 years.\nLifetime benefits with special concessions or recognition.\nHonors senior contributors to the scientific community.',
 'Specially designed for senior members of the profession', NULL,
 'Lifetime',
 'Experienced professionals above 60–65 years', 5),

(6, 'International Membership', 'international', '$50 USD (No GST)', '$50 USD', 'teal', 0, 'Eligibility:',
 'Degree in pharmacy or graduation from a recognized University.\nDiploma from a recognized University in India or abroad.\nBachelor''s or higher degree in Basic, Life Sciences and/or Applied Sciences.',
 'For persons residing outside India.\nLifetime privileges bound by SBC rules & regulations.\nAccess to global collaboration, international publications & events.\nStrengthens international academic networking.',
 'SBC has discretion to reject any application without ascribing reasons', NULL,
 'Lifetime',
 'Persons residing outside India', 6),

(7, 'Student Membership', 'student', '₹299/- (1 Year Only)', '₹299', 'coral', 0, NULL, NULL,
 'Open to undergraduate, postgraduate & doctoral students in relevant fields.\nValid for 1 year only — renewable or upgradable to Life Membership.\nReduced fees and exclusive academic support for early-career researchers and future scientists.',
 NULL, NULL,
 '1 Year',
 'Undergraduate, postgraduate & doctoral students', 7);

-- ============================================================
-- MEMBERSHIP APPLICATIONS (form submissions)
-- ============================================================
CREATE TABLE IF NOT EXISTS membership_applications (
  id                   INT AUTO_INCREMENT PRIMARY KEY,
  membership_type_id   INT,
  membership_type_name VARCHAR(150),
  salutation           VARCHAR(10),
  photo                VARCHAR(255),
  name                 VARCHAR(150) NOT NULL,
  dob                  DATE NULL,
  blood_group          VARCHAR(5),
  sex                  VARCHAR(10),
  email                VARCHAR(150) NOT NULL,
  nationality          VARCHAR(100),
  phone                VARCHAR(30),
  address              TEXT,
  city                 VARCHAR(100),
  state                VARCHAR(100),
  country              VARCHAR(100),
  zip_code             VARCHAR(20),
  specialization       VARCHAR(150),
  designation          VARCHAR(150),
  college              VARCHAR(255),
  college_state        VARCHAR(100),
  qualifications       JSON,
  ref_college          VARCHAR(255),
  ref_email            VARCHAR(150),
  ref_phone            VARCHAR(30),
  ref_address          TEXT,
  ref_city             VARCHAR(100),
  ref_state            VARCHAR(100),
  ref_country          VARCHAR(100),
  ref_zip              VARCHAR(20),
  fee_amount           DECIMAL(10,2) DEFAULT 0,
  gst_amount           DECIMAL(10,2) DEFAULT 0,
  transaction_charges  DECIMAL(10,2) DEFAULT 0,
  total_amount         DECIMAL(10,2) DEFAULT 0,
  -- Applicant's uploaded payment receipt (UTR details tracked in form_data if needed)
  txn_receipt_file     VARCHAR(255),
  txn_verified         TINYINT(1) DEFAULT 0,
  status               ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
  notes                TEXT,
  form_data            JSON,
  uploaded_files       JSON,
  membership_id        VARCHAR(50),
  ip_address           VARCHAR(45),
  created_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_status (status),
  INDEX idx_email (email),
  INDEX idx_created (created_at)
);

-- ============================================================
-- ARTICLE SUBMISSIONS (Submit Article feature per journal)
-- ============================================================
CREATE TABLE IF NOT EXISTS article_submissions (
  id                   INT AUTO_INCREMENT PRIMARY KEY,
  journal_id           INT NOT NULL,
  journal_name         VARCHAR(255) NOT NULL,
  section              VARCHAR(100) NOT NULL,
  prefix               VARCHAR(50),
  title                VARCHAR(500) NOT NULL,
  subtitle             VARCHAR(500),
  abstract             TEXT NOT NULL,
  keywords             JSON,
  cover_image          VARCHAR(255),
  contributors         JSON,
  article_files        JSON,
  publication_status   ENUM('unpublished', 'published') DEFAULT 'unpublished',
  review_status        ENUM('draft', 'submitted', 'under_review', 'accepted', 'rejected', 'published') DEFAULT 'submitted',
  notes                TEXT,
  ip_address           VARCHAR(45),
  submitter_email        VARCHAR(150),
  submitter_name         VARCHAR(150),
  submitter_affiliation  VARCHAR(255),
  submitter_mobile       VARCHAR(30),
  created_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_journal (journal_id),
  INDEX idx_review_status (review_status),
  INDEX idx_publication_status (publication_status),
  INDEX idx_created (created_at)
);

-- ============================================================
-- TESTIMONIALS
-- ============================================================
CREATE TABLE IF NOT EXISTS testimonials (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  reviewer_name VARCHAR(150) NOT NULL,
  designation   VARCHAR(150),
  organization  VARCHAR(200),
  avatar_color  VARCHAR(7) DEFAULT '#1e73be',
  avatar_letter VARCHAR(5) DEFAULT '',
  rating        TINYINT DEFAULT 5,
  content       TEXT NOT NULL,
  review_count  VARCHAR(20) DEFAULT '1 review',
  source        VARCHAR(50) DEFAULT 'Google',
  review_date   VARCHAR(60),
  sort_order    INT DEFAULT 0,
  is_active     TINYINT(1) DEFAULT 1,
  created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO testimonials (reviewer_name, designation, organization, avatar_color, avatar_letter, rating, content, review_count, source, review_date, sort_order)
SELECT * FROM (SELECT
'Dr. Lavanya Yaidikar' AS reviewer_name, 'Associate Professor' AS designation, 'Delhi University' AS organization, '#1e73be' AS avatar_color, 'D' AS avatar_letter, 5 AS rating, 'Excellent support system. The team was responsive and the publication process was smooth from submission to final print.' AS content, '3 reviews' AS review_count, 'Google' AS source, '2 months ago' AS review_date, 1 AS sort_order) t
WHERE NOT EXISTS (SELECT 1 FROM testimonials WHERE reviewer_name = 'Dr. Lavanya Yaidikar' LIMIT 1);

INSERT INTO testimonials (reviewer_name, designation, organization, avatar_color, avatar_letter, rating, content, review_count, source, review_date, sort_order)
SELECT * FROM (SELECT
'Prof. Ramesh Iyer' AS reviewer_name, 'Head of Department' AS designation, 'IIT Bombay' AS organization, '#0f766e' AS avatar_color, 'R' AS avatar_letter, 5 AS rating, 'Sujata Publications made our conference proceedings publication effortless. Strong editorial standards and timely delivery.' AS content, '7 reviews' AS review_count, 'Google' AS source, '1 month ago' AS review_date, 2 AS sort_order) t
WHERE NOT EXISTS (SELECT 1 FROM testimonials WHERE reviewer_name = 'Prof. Ramesh Iyer' LIMIT 1);

INSERT INTO testimonials (reviewer_name, designation, organization, avatar_color, avatar_letter, rating, content, review_count, source, review_date, sort_order)
SELECT * FROM (SELECT
'Dr. Anita Sharma' AS reviewer_name, 'Research Scholar' AS designation, 'BHU Varanasi' AS organization, '#9333ea' AS avatar_color, 'A' AS avatar_letter, 5 AS rating, 'The peer review was rigorous and the feedback helped me improve my manuscript significantly. Highly recommended.' AS content, '2 reviews' AS review_count, 'Google' AS source, '3 weeks ago' AS review_date, 3 AS sort_order) t
WHERE NOT EXISTS (SELECT 1 FROM testimonials WHERE reviewer_name = 'Dr. Anita Sharma' LIMIT 1);

INSERT INTO testimonials (reviewer_name, designation, organization, avatar_color, avatar_letter, rating, content, review_count, source, review_date, sort_order)
SELECT * FROM (SELECT
'Mr. Kunal Verma' AS reviewer_name, 'Author' AS designation, 'Independent' AS organization, '#dc2626' AS avatar_color, 'K' AS avatar_letter, 5 AS rating, 'My first book was published within 90 days. Cover design, ISBN, and distribution — everything was handled professionally.' AS content, '5 reviews' AS review_count, 'Google' AS source, '1 month ago' AS review_date, 4 AS sort_order) t
WHERE NOT EXISTS (SELECT 1 FROM testimonials WHERE reviewer_name = 'Mr. Kunal Verma' LIMIT 1);
