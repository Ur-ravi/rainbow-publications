-- ============================================================
-- MIGRATION SCRIPT for existing installations
-- Run this to apply changes without losing data
-- Compatible with MySQL 5.x and 8.x (no "IF NOT EXISTS" on ADD COLUMN)
-- ============================================================

-- Add testimonials table for existing installations
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

-- Insert sample testimonials (only if table is empty, to allow safe re-runs)

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

-- Add service_interest column to contact_messages if missing
-- (MySQL 5.x doesn't support ADD COLUMN IF NOT EXISTS — use a stored procedure.)
DROP PROCEDURE IF EXISTS migrate_add_column;
DELIMITER //
CREATE PROCEDURE migrate_add_column()
BEGIN
  IF NOT EXISTS (SELECT * FROM information_schema.COLUMNS
                 WHERE TABLE_SCHEMA = DATABASE()
                   AND TABLE_NAME = 'contact_messages'
                   AND COLUMN_NAME = 'service_interest') THEN
    ALTER TABLE contact_messages ADD COLUMN service_interest VARCHAR(150) AFTER subject;
  END IF;
END //
DELIMITER ;
CALL migrate_add_column();
DROP PROCEDURE migrate_add_column;

-- ============================================================
-- MEMBERSHIP APPLICATIONS: extend for multi-form-variant
-- ============================================================
DROP PROCEDURE IF EXISTS migrate_membership_applications_columns;
DELIMITER //
CREATE PROCEDURE migrate_membership_applications_columns()
BEGIN
  IF NOT EXISTS (SELECT * FROM information_schema.COLUMNS
                 WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'membership_applications' AND COLUMN_NAME = 'form_data') THEN
    ALTER TABLE membership_applications ADD COLUMN form_data JSON AFTER notes;
  END IF;
  IF NOT EXISTS (SELECT * FROM information_schema.COLUMNS
                 WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'membership_applications' AND COLUMN_NAME = 'uploaded_files') THEN
    ALTER TABLE membership_applications ADD COLUMN uploaded_files JSON AFTER form_data;
  END IF;
  IF NOT EXISTS (SELECT * FROM information_schema.COLUMNS
                 WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'membership_applications' AND COLUMN_NAME = 'membership_id') THEN
    ALTER TABLE membership_applications ADD COLUMN membership_id VARCHAR(50) AFTER uploaded_files;
  END IF;
  IF NOT EXISTS (SELECT * FROM information_schema.COLUMNS
                 WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'membership_applications' AND COLUMN_NAME = 'updated_at') THEN
    ALTER TABLE membership_applications ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at;
  END IF;
  -- Applicant uploaded payment receipt (added 2026-06-18)
  IF NOT EXISTS (SELECT * FROM information_schema.COLUMNS
                 WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'membership_applications' AND COLUMN_NAME = 'txn_receipt_file') THEN
    ALTER TABLE membership_applications ADD COLUMN txn_receipt_file VARCHAR(255) AFTER total_amount;
  END IF;
  IF NOT EXISTS (SELECT * FROM information_schema.COLUMNS
                 WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'membership_applications' AND COLUMN_NAME = 'txn_verified') THEN
    ALTER TABLE membership_applications ADD COLUMN txn_verified TINYINT(1) DEFAULT 0 AFTER txn_receipt_file;
  END IF;
END //
DELIMITER ;
CALL migrate_membership_applications_columns();
DROP PROCEDURE migrate_membership_applications_columns;

-- ============================================================
-- ARTICLE SUBMISSIONS: extend with contact person fields
-- ============================================================
DROP PROCEDURE IF EXISTS migrate_article_submissions_columns;
DELIMITER //
CREATE PROCEDURE migrate_article_submissions_columns()
BEGIN
  IF NOT EXISTS (SELECT * FROM information_schema.COLUMNS
                 WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'article_submissions' AND COLUMN_NAME = 'submitter_affiliation') THEN
    ALTER TABLE article_submissions ADD COLUMN submitter_affiliation VARCHAR(255) AFTER submitter_name;
  END IF;
  IF NOT EXISTS (SELECT * FROM information_schema.COLUMNS
                 WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'article_submissions' AND COLUMN_NAME = 'submitter_mobile') THEN
    ALTER TABLE article_submissions ADD COLUMN submitter_mobile VARCHAR(30) AFTER submitter_affiliation;
  END IF;
  IF NOT EXISTS (SELECT * FROM information_schema.COLUMNS
                 WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'article_submissions' AND COLUMN_NAME = 'updated_at') THEN
    ALTER TABLE article_submissions ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at;
  END IF;
  IF NOT EXISTS (SELECT * FROM information_schema.COLUMNS
                 WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'article_submissions' AND COLUMN_NAME = 'notes') THEN
    ALTER TABLE article_submissions ADD COLUMN notes TEXT AFTER review_status;
  END IF;
END //
DELIMITER ;
CALL migrate_article_submissions_columns();
DROP PROCEDURE migrate_article_submissions_columns;

-- Add Editorial Board / Reviewer Board to navbar (as children of About Us)
-- Only inserts if the About Us menu exists and the children don't already exist
INSERT INTO menus (parent_id, label, url, sort_order, is_active)
SELECT m.id, 'Editorial Board', '/editorial-board', 2, 1
FROM menus m
WHERE m.url = '/about' AND m.parent_id IS NULL
AND NOT EXISTS (SELECT 1 FROM menus WHERE url = '/editorial-board');

INSERT INTO menus (parent_id, label, url, sort_order, is_active)
SELECT m.id, 'Reviewer Board', '/reviewer-board', 3, 1
FROM menus m
WHERE m.url = '/about' AND m.parent_id IS NULL
AND NOT EXISTS (SELECT 1 FROM menus WHERE url = '/reviewer-board');

-- Add the "About Us" child link (under About Us parent)
INSERT INTO menus (parent_id, label, url, sort_order, is_active)
SELECT m.id, 'About Us', '/about', 1, 1
FROM menus m
WHERE m.url = '/about' AND m.parent_id IS NULL
AND NOT EXISTS (SELECT 1 FROM menus c WHERE c.parent_id = m.id AND c.url = '/about');

-- ============================================================
-- CONFERENCES: add conference_brochure column to existing installations
-- ============================================================
DROP PROCEDURE IF EXISTS migrate_conference_brochure;
DELIMITER //
CREATE PROCEDURE migrate_conference_brochure()
BEGIN
  IF NOT EXISTS (SELECT * FROM information_schema.COLUMNS
                 WHERE TABLE_SCHEMA = DATABASE()
                   AND TABLE_NAME = 'conferences'
                   AND COLUMN_NAME = 'conference_brochure') THEN
    ALTER TABLE conferences ADD COLUMN conference_brochure VARCHAR(255) AFTER poster_image;
  END IF;
END //
DELIMITER ;
CALL migrate_conference_brochure();
DROP PROCEDURE migrate_conference_brochure;

-- ============================================================
-- CONFERENCES (Migration: add new table + nav menu)
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
  is_featured       TINYINT(1) DEFAULT 0,
  sort_order        INT DEFAULT 0,
  meta_title        VARCHAR(255),
  meta_description  TEXT,
  created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_active_date (is_active, conference_date),
  INDEX idx_featured (is_featured)
);

-- ============================================================
-- CONFERENCES: add is_featured column to existing installations
-- ============================================================
DROP PROCEDURE IF EXISTS migrate_conferences_is_featured;
DELIMITER //
CREATE PROCEDURE migrate_conferences_is_featured()
BEGIN
  IF NOT EXISTS (SELECT * FROM information_schema.COLUMNS
                 WHERE TABLE_SCHEMA = DATABASE()
                   AND TABLE_NAME = 'conferences'
                   AND COLUMN_NAME = 'is_featured') THEN
    ALTER TABLE conferences ADD COLUMN is_featured TINYINT(1) DEFAULT 0 AFTER is_active;
    ALTER TABLE conferences ADD INDEX idx_featured (is_featured);
  END IF;
END //
DELIMITER ;
CALL migrate_conferences_is_featured();
DROP PROCEDURE migrate_conferences_is_featured;

-- Add Conferences menu (only if not present)
INSERT INTO menus (parent_id, label, url, sort_order, is_active)
SELECT NULL, 'Conferences', '/conferences', 7, 1
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM menus WHERE url = '/conferences');

-- ============================================================
-- MEMBERSHIP: Replace "/membership" with "/membership-types"
-- ============================================================
-- Update existing Membership menu to point to /membership-types
UPDATE menus
SET url = '/membership-types', label = 'Membership Types'
WHERE url = '/membership';

-- Insert Membership Types menu if it doesn't exist
INSERT INTO menus (parent_id, label, url, sort_order, is_active)
SELECT NULL, 'Membership Types', '/membership-types', 5, 1
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM menus WHERE url = '/membership-types');

-- ============================================================
-- BOOKS SUB-MENU (Migration: add "All Books" + "Conference Abstract Book" under Books)
-- ============================================================
-- Add "All Books" sub-menu under Books (only if parent Books exists and child doesn't)
INSERT INTO menus (parent_id, label, url, sort_order, is_active)
SELECT m.id, 'All Books', '/books', 1, 1
FROM menus m
WHERE m.label = 'Books' AND m.parent_id IS NULL
  AND NOT EXISTS (SELECT 1 FROM menus c WHERE c.parent_id = m.id AND c.url = '/books');

-- Add "Conference Abstract Book" sub-menu under Books
INSERT INTO menus (parent_id, label, url, sort_order, is_active)
SELECT m.id, 'Conference Abstract Book', '/conference-abstract-book', 2, 1
FROM menus m
WHERE m.label = 'Books' AND m.parent_id IS NULL
  AND NOT EXISTS (SELECT 1 FROM menus WHERE url = '/conference-abstract-book');

-- ============================================================
-- MEMBERSHIP DROPDOWN (Migration: convert "Membership Types" to "Membership" parent + 4 children)
-- ============================================================
-- Step 1: Rename the existing top-level "Membership Types" entry to "Membership" and point to /membership
UPDATE menus
SET label = 'Membership', url = '/membership'
WHERE label = 'Membership Types' AND parent_id IS NULL
  AND url = '/membership-types';

-- Step 2: Add the four children under the "Membership" parent
INSERT INTO menus (parent_id, label, url, sort_order, is_active)
SELECT m.id, 'Benefit of Membership', '/membership/benefits', 1, 1
FROM menus m
WHERE m.label = 'Membership' AND m.parent_id IS NULL
  AND NOT EXISTS (SELECT 1 FROM menus WHERE url = '/membership/benefits');

INSERT INTO menus (parent_id, label, url, sort_order, is_active)
SELECT m.id, 'Types of Membership', '/membership-types', 2, 1
FROM menus m
WHERE m.label = 'Membership' AND m.parent_id IS NULL
  AND NOT EXISTS (
      SELECT 1 FROM menus c
      WHERE c.parent_id = m.id AND c.url = '/membership-types'
  );

INSERT INTO menus (parent_id, label, url, sort_order, is_active)
SELECT m.id, 'Apply for Membership', '/membership-types#apply', 3, 1
FROM menus m
WHERE m.label = 'Membership' AND m.parent_id IS NULL
  AND NOT EXISTS (SELECT 1 FROM menus WHERE url = '/membership-types#apply');

INSERT INTO menus (parent_id, label, url, sort_order, is_active)
SELECT m.id, 'Membership List', '/membership', 4, 1
FROM menus m
WHERE m.label = 'Membership' AND m.parent_id IS NULL
  AND NOT EXISTS (
      SELECT 1 FROM menus c
      WHERE c.parent_id = m.id AND c.url = '/membership'
  );

-- ============================================================
-- CMS PAGES: Benefit of Membership + Types of Membership
-- ============================================================
-- Seed "Benefit of Membership" page
INSERT INTO pages (title, slug, content, status, meta_title, meta_description)
SELECT 'Benefit of Membership',
       'benefit-of-membership',
       '<h2>Why Become a Member?</h2><p>Discover the exclusive benefits available to Sujata Publications members.</p><h3>Research &amp; Publication</h3><ul><li>Discounted article processing charges in member journals</li><li>Priority review and faster publication turnaround</li><li>Free certificate of membership</li></ul><h3>Networking &amp; Community</h3><ul><li>Access to the Sujata Publications academic community</li><li>Invitations to conferences, seminars and workshops</li><li>Eligibility to serve on editorial and review boards</li></ul><p><em>You can edit this content from the admin CMS.</em></p>',
       'published',
       'Benefit of Membership | Sujata Publications',
       'Discover the exclusive benefits of Sujata Publications membership for researchers and institutions.'
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE slug = 'benefit-of-membership');

-- Seed "Types of Membership" page
INSERT INTO pages (title, slug, content, status, meta_title, meta_description)
SELECT 'Types of Membership',
       'types-of-membership',
       '<h2>Types of Membership</h2><p>Sujata Publications offers a range of membership categories to suit every researcher, professional and institution.</p><h3>Individual Membership</h3><ul><li>Honorary Membership</li><li>Life Membership</li><li>Life Membership (Senior Category)</li><li>Student Membership</li><li>International Membership</li></ul><h3>Institutional Membership</h3><ul><li>Patron Membership</li><li>Institutional Membership</li></ul><p><em>You can edit this content from the admin CMS.</em></p>',
       'published',
       'Types of Membership | Sujata Publications',
       'Explore the different membership categories offered by Sujata Publications.'
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM pages WHERE slug = 'types-of-membership');

-- ============================================================
-- MEMBERSHIP TYPES (Migration: detailed application page)
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

-- Seed defaults only if table is empty
INSERT INTO membership_types
  (badge_number, title, slug, fee_label, fee_short, card_color, is_full_width, eligibility_title, eligibility, details, footer_note, nomination_emails, duration_label, comparison_eligibility, sort_order)
SELECT * FROM (
  SELECT 1 AS badge_number, 'Honorary Membership' AS title, 'honorary' AS slug, 'Free (Nomination Based)' AS fee_label, 'Free' AS fee_short, 'purple' AS card_color, 1 AS is_full_width, NULL AS eligibility_title, NULL AS eligibility,
  'Awarded to distinguished scientists, academicians, or professionals for exceptional contributions to pharmaceutical and biomedical research.\nConferred by the Editorial or Advisory Board.\nNo application required — nomination-based only.' AS details,
  NULL AS footer_note, 'info@sujatapublications.org, sujatapublications@gmail.com' AS nomination_emails, 'Lifetime' AS duration_label, 'By nomination only — distinguished scientists & academicians' AS comparison_eligibility, 1 AS sort_order
) AS t
WHERE NOT EXISTS (SELECT 1 FROM membership_types WHERE slug = 'honorary');

INSERT INTO membership_types (badge_number, title, slug, fee_label, fee_short, card_color, is_full_width, details, footer_note, duration_label, comparison_eligibility, sort_order)
SELECT 2, 'Patron Membership', 'patron', '₹49,999/-', '₹49,999', 'blue', 0,
'For individuals or organizations contributing significantly to research promotion.\nAll membership privileges with special recognition status.\nIdeal for senior professionals, industry leaders & sponsors.',
'Financial or strategic contributors to the organization', 'Lifetime', 'Senior professionals, industry leaders & sponsors', 2
WHERE NOT EXISTS (SELECT 1 FROM membership_types WHERE slug = 'patron');

INSERT INTO membership_types (badge_number, title, slug, fee_label, fee_short, card_color, is_full_width, details, footer_note, duration_label, comparison_eligibility, sort_order)
SELECT 3, 'Institutional Membership', 'institutional', '₹29,999/-', '₹29,999', 'amber', 0,
'Open to universities, colleges, research institutes, hospitals & pharmaceutical industries.\nMultiple representatives from the institution can participate.\nPromotes institutional collaboration in research, publications & conferences.',
'Eligible for institutions engaged in teaching, research or pharmaceutical activities', 'Lifetime', 'Universities, colleges, research institutes & hospitals', 3
WHERE NOT EXISTS (SELECT 1 FROM membership_types WHERE slug = 'institutional');

INSERT INTO membership_types (badge_number, title, slug, fee_label, fee_short, card_color, is_full_width, eligibility_title, eligibility, details, footer_note, duration_label, comparison_eligibility, sort_order)
SELECT 4, 'Life Membership', 'life', '₹999/-', '₹999', 'green', 0, 'Eligibility (age 21+):',
'Degree in pharmacy or graduation from a recognized University in India or abroad.\nDiploma from a recognized University in India or abroad.\nBachelor''s or higher degree in Basic, Life Sciences and/or Applied Sciences from a recognized University.',
'One-time registration with lifetime benefits & privileges.\nAvailable to professionals, academicians & researchers.\nIdeal for long-term association and academic growth.',
'SBC has discretion to reject any application without ascribing reasons', 'Lifetime', 'Graduates in pharmacy / life sciences (age 21+)', 4
WHERE NOT EXISTS (SELECT 1 FROM membership_types WHERE slug = 'life');

INSERT INTO membership_types (badge_number, title, slug, fee_label, fee_short, card_color, is_full_width, details, footer_note, duration_label, comparison_eligibility, sort_order)
SELECT 5, 'Life Membership (Senior Category)', 'life-senior', '₹799/-', '₹799', 'pink', 0,
'Special category for experienced professionals above 60–65 years.\nLifetime benefits with special concessions or recognition.\nHonors senior contributors to the scientific community.',
'Specially designed for senior members of the profession', 'Lifetime', 'Experienced professionals above 60–65 years', 5
WHERE NOT EXISTS (SELECT 1 FROM membership_types WHERE slug = 'life-senior');

INSERT INTO membership_types (badge_number, title, slug, fee_label, fee_short, card_color, is_full_width, eligibility_title, eligibility, details, footer_note, duration_label, comparison_eligibility, sort_order)
SELECT 6, 'International Membership', 'international', '$50 USD (No GST)', '$50 USD', 'teal', 0, 'Eligibility:',
'Degree in pharmacy or graduation from a recognized University.\nDiploma from a recognized University in India or abroad.\nBachelor''s or higher degree in Basic, Life Sciences and/or Applied Sciences.',
'For persons residing outside India.\nLifetime privileges bound by SBC rules & regulations.\nAccess to global collaboration, international publications & events.\nStrengthens international academic networking.',
'SBC has discretion to reject any application without ascribing reasons', 'Lifetime', 'Persons residing outside India', 6
WHERE NOT EXISTS (SELECT 1 FROM membership_types WHERE slug = 'international');

INSERT INTO membership_types (badge_number, title, slug, fee_label, fee_short, card_color, is_full_width, details, duration_label, comparison_eligibility, sort_order)
SELECT 7, 'Student Membership', 'student', '₹299/- (1 Year Only)', '₹299', 'coral', 0,
'Open to undergraduate, postgraduate & doctoral students in relevant fields.\nValid for 1 year only — renewable or upgradable to Life Membership.\nReduced fees and exclusive academic support for early-career researchers and future scientists.',
'1 Year', 'Undergraduate, postgraduate & doctoral students', 7
WHERE NOT EXISTS (SELECT 1 FROM membership_types WHERE slug = 'student');

-- ============================================================
-- MEMBERSHIP APPLICATIONS (Migration: form submissions)
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
  txn_receipt_file     VARCHAR(255),
  txn_verified         TINYINT(1) DEFAULT 0,
  status               ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
  notes                TEXT,
  ip_address           VARCHAR(45),
  created_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_status (status),
  INDEX idx_email (email),
  INDEX idx_created (created_at)
);

-- NOTE: The form_data, uploaded_files, and membership_id columns are added
-- conditionally by the stored procedures at the top of this file, so this
-- migration is safe to re-run on MySQL 5.x servers.

-- ============================================================
-- ARTICLE SUBMISSIONS (Migration)
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
  submitter_email      VARCHAR(150),
  submitter_name       VARCHAR(150),
  created_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_journal (journal_id),
  INDEX idx_review_status (review_status),
  INDEX idx_publication_status (publication_status),
  INDEX idx_created (created_at)
);

-- NOTE: submitter_affiliation, submitter_mobile, and notes columns are added
-- conditionally by the stored procedures at the top of this file.

-- ============================================================
-- MEMBERSHIP DROPDOWN: rebuild "Membership" navbar as a parent with two children
-- ============================================================
-- Goal:
--   - Top-level item:  "Membership" -> /membership   (dropdown trigger only)
--   - Child 1:         "Apply Now"     -> /membership/types
--   - Child 2:         "View Details"  -> /membership/types-details
--   - Remove any standalone "Membership Types" top-level entry.

-- 1. Restore parent label & URL on the "Membership Types" item
UPDATE menus
SET label = 'Membership', url = '/membership'
WHERE label = 'Membership Types'
  AND parent_id IS NULL
  AND url = '/membership-types';

-- 2. Ensure "Membership" -> /membership exists at top level
INSERT INTO menus (parent_id, label, url, sort_order, is_active)
SELECT NULL, 'Membership', '/membership', 5, 1
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM menus WHERE url = '/membership' AND parent_id IS NULL);

-- 3. Remove duplicate standalone "Membership Types" entry (only if it has no children)
DELETE FROM menus
WHERE label = 'Membership Types'
  AND url   = '/membership-types'
  AND parent_id IS NULL
  AND id NOT IN (SELECT DISTINCT parent_id FROM menus WHERE parent_id IS NOT NULL);

-- 4. Add "Apply Now" child under "Membership"
INSERT INTO menus (parent_id, label, url, sort_order, is_active)
SELECT m.id, 'Apply Now', '/membership/types', 1, 1
FROM menus m
WHERE m.url = '/membership' AND m.parent_id IS NULL
AND NOT EXISTS (
    SELECT 1 FROM menus c WHERE c.parent_id = m.id AND c.url = '/membership/types'
);

-- 5. Add "View Details" child under "Membership"
INSERT INTO menus (parent_id, label, url, sort_order, is_active)
SELECT m.id, 'View Details', '/membership/types-details', 2, 1
FROM menus m
WHERE m.url = '/membership' AND m.parent_id IS NULL
AND NOT EXISTS (
    SELECT 1 FROM menus c WHERE c.parent_id = m.id AND c.url = '/membership/types-details'
);

-- 6. Move any orphaned "Apply Now"/"View Details" from a "Membership Types"
--    parent to the real "Membership" parent
UPDATE menus child
JOIN menus oldParent ON child.parent_id = oldParent.id
JOIN menus newParent ON newParent.url = '/membership' AND newParent.parent_id IS NULL
SET child.parent_id = newParent.id
WHERE oldParent.label = 'Membership Types'
  AND oldParent.url   = '/membership-types'
  AND oldParent.parent_id IS NULL
  AND child.label IN ('Apply Now', 'View Details');

-- 7. Clean up the now-empty "Membership Types" parent if it has no children
DELETE FROM menus
WHERE label = 'Membership Types'
  AND url   = '/membership-types'
  AND parent_id IS NULL
  AND id NOT IN (SELECT DISTINCT parent_id FROM menus WHERE parent_id IS NOT NULL);

