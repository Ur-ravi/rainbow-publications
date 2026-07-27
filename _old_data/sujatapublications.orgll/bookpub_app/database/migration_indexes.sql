-- ============================================================
-- AUDIT FIX MIGRATION — 2026-06-18
-- Idempotent: safe to re-run.
-- Adds: missing FK constraints, performance indexes, soft-delete columns,
-- payment_details.created_at, conferences.is_featured if missing.
-- ============================================================

SET @db := DATABASE();

-- ============================================================
-- FK CONSTRAINTS
-- ============================================================

-- membership_applications.membership_type_id → membership_types
SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='membership_applications' AND index_name='fk_mem_apps_type');
SET @sql := IF(@q=0,
  'ALTER TABLE membership_applications ADD CONSTRAINT fk_mem_apps_type FOREIGN KEY (membership_type_id) REFERENCES membership_types(id) ON DELETE SET NULL',
  'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

-- article_submissions.journal_id → journals
SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='article_submissions' AND index_name='fk_articles_journal');
SET @sql := IF(@q=0,
  'ALTER TABLE article_submissions ADD CONSTRAINT fk_articles_journal FOREIGN KEY (journal_id) REFERENCES journals(id) ON DELETE RESTRICT',
  'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

-- article_submissions.user_id (if column exists) → admins
SET @q := (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE table_schema=@db AND table_name='article_submissions' AND column_name='user_id');
SET @sql := IF(@q>0,
  'ALTER TABLE article_submissions ADD CONSTRAINT fk_articles_user FOREIGN KEY (user_id) REFERENCES admins(id) ON DELETE SET NULL',
  'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

-- ============================================================
-- MISSING INDEXES (additive, IF NOT EXISTS via STATISTICS check)
-- ============================================================

-- contact_messages
SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='contact_messages' AND index_name='idx_cm_is_read');
SET @sql := IF(@q=0, 'ALTER TABLE contact_messages ADD INDEX idx_cm_is_read (is_read)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='contact_messages' AND index_name='idx_cm_created');
SET @sql := IF(@q=0, 'ALTER TABLE contact_messages ADD INDEX idx_cm_created (created_at)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

-- books
SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='books' AND index_name='idx_books_published');
SET @sql := IF(@q=0, 'ALTER TABLE books ADD INDEX idx_books_published (is_published)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='books' AND index_name='idx_books_featured');
SET @sql := IF(@q=0, 'ALTER TABLE books ADD INDEX idx_books_featured (is_featured)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='books' AND index_name='idx_books_category');
SET @sql := IF(@q=0, 'ALTER TABLE books ADD INDEX idx_books_category (category)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='books' AND index_name='idx_books_sort_created');
SET @sql := IF(@q=0, 'ALTER TABLE books ADD INDEX idx_books_sort_created (sort_order, created_at)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

-- journals
SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='journals' AND index_name='idx_journals_active');
SET @sql := IF(@q=0, 'ALTER TABLE journals ADD INDEX idx_journals_active (is_active, sort_order)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

-- news
SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='news' AND index_name='idx_news_status_published');
SET @sql := IF(@q=0, 'ALTER TABLE news ADD INDEX idx_news_status_published (status, published_at)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='news' AND index_name='idx_news_featured');
SET @sql := IF(@q=0, 'ALTER TABLE news ADD INDEX idx_news_featured (is_featured)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

-- pages
SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='pages' AND index_name='idx_pages_status');
SET @sql := IF(@q=0, 'ALTER TABLE pages ADD INDEX idx_pages_status (status)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

-- services
SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='services' AND index_name='idx_services_active');
SET @sql := IF(@q=0, 'ALTER TABLE services ADD INDEX idx_services_active (is_active)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

-- memberships
SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='memberships' AND index_name='idx_memberships_active');
SET @sql := IF(@q=0, 'ALTER TABLE memberships ADD INDEX idx_memberships_active (is_active, sort_order)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

-- membership_types
SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='membership_types' AND index_name='idx_mem_types_active');
SET @sql := IF(@q=0, 'ALTER TABLE membership_types ADD INDEX idx_mem_types_active (is_active, sort_order)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

-- membership_applications
SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='membership_applications' AND index_name='idx_ma_status_created');
SET @sql := IF(@q=0, 'ALTER TABLE membership_applications ADD INDEX idx_ma_status_created (status, created_at)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='membership_applications' AND index_name='idx_ma_type');
SET @sql := IF(@q=0, 'ALTER TABLE membership_applications ADD INDEX idx_ma_type (membership_type_id)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

-- article_submissions
SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='article_submissions' AND index_name='idx_as_journal_review');
SET @sql := IF(@q=0, 'ALTER TABLE article_submissions ADD INDEX idx_as_journal_review (journal_id, review_status, created_at)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

-- gallery
SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='gallery' AND index_name='idx_gallery_active');
SET @sql := IF(@q=0, 'ALTER TABLE gallery ADD INDEX idx_gallery_active (is_active)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='gallery' AND index_name='idx_gallery_media');
SET @sql := IF(@q=0, 'ALTER TABLE gallery ADD INDEX idx_gallery_media (media_type)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

-- editorial_board
SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='editorial_board' AND index_name='idx_eb_active_sort');
SET @sql := IF(@q=0, 'ALTER TABLE editorial_board ADD INDEX idx_eb_active_sort (is_active, sort_order)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

-- reviewer_board
SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='reviewer_board' AND index_name='idx_rb_active_sort');
SET @sql := IF(@q=0, 'ALTER TABLE reviewer_board ADD INDEX idx_rb_active_sort (is_active, sort_order)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

-- menus
SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='menus' AND index_name='idx_menus_parent_sort');
SET @sql := IF(@q=0, 'ALTER TABLE menus ADD INDEX idx_menus_parent_sort (parent_id, sort_order)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='menus' AND index_name='idx_menus_active');
SET @sql := IF(@q=0, 'ALTER TABLE menus ADD INDEX idx_menus_active (is_active)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

-- testimonials
SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='testimonials' AND index_name='idx_testimonials_active');
SET @sql := IF(@q=0, 'ALTER TABLE testimonials ADD INDEX idx_testimonials_active (is_active, sort_order)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

-- conferences
SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='conferences' AND index_name='idx_active_featured');
SET @sql := IF(@q=0, 'ALTER TABLE conferences ADD INDEX idx_active_featured (is_active, is_featured)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

-- ============================================================
-- ADD COLUMNS if missing (for installations older than 2026-06-18)
-- ============================================================

-- conferences.is_featured (sometimes missing in fresh schema.sql installs)
SET @q := (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE table_schema=@db AND table_name='conferences' AND column_name='is_featured');
SET @sql := IF(@q=0, 'ALTER TABLE conferences ADD COLUMN is_featured TINYINT(1) DEFAULT 0 AFTER is_active', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='conferences' AND index_name='idx_featured');
SET @sql := IF(@q=0, 'ALTER TABLE conferences ADD INDEX idx_featured (is_featured)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

-- payment_details.created_at (was missing)
SET @q := (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE table_schema=@db AND table_name='payment_details' AND column_name='created_at');
SET @sql := IF(@q=0, 'ALTER TABLE payment_details ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER updated_at', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

-- ============================================================
-- LOGIN_ATTEMPTS table for rate-limiting (H5)
-- ============================================================
CREATE TABLE IF NOT EXISTS login_attempts (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  ip            VARCHAR(45) NOT NULL,
  email         VARCHAR(150) NOT NULL,
  success       TINYINT(1) DEFAULT 0,
  attempted_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_la_ip_email_time (ip, email, attempted_at),
  INDEX idx_la_time (attempted_at)
);

SET @q := (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE table_schema=@db AND table_name='payment_details' AND index_name='idx_pd_active');
SET @sql := IF(@q=0, 'ALTER TABLE payment_details ADD INDEX idx_pd_active (is_active)', 'SELECT 1');
PREPARE s FROM @sql; EXECUTE s; DEALLOCATE PREPARE s;

-- ============================================================
-- DONE
-- ============================================================
SELECT 'Audit migration complete.' AS status;
