<?php
// ============================================================
// ADMIN MODEL
// ============================================================
class AdminModel extends Model {
    protected $table = 'admins';

    public function findByEmail(string $email): ?array {
        return $this->findOne('email = ?', [$email]);
    }

    public function updateLastLogin(int $id): void {
        $this->update(['last_login' => date('Y-m-d H:i:s')], 'id = ?', [$id]);
    }
}

// ============================================================
// BOOK MODEL
// ============================================================
class BookModel extends Model {
    protected $table = 'books';

    public function getPublished(int $limit = 0, int $offset = 0, string $search = ''): array {
        $where  = 'is_published = 1';
        $params = [];
        if ($search) {
            $where  .= ' AND (title LIKE ? OR authors LIKE ? OR isbn LIKE ?)';
            $params  = ["%$search%", "%$search%", "%$search%"];
        }
        return $this->findAll($where, $params, 'sort_order ASC, created_at DESC', $limit, $offset);
    }

    public function getFeatured(int $limit = 6): array {
        return $this->findAll('is_published = 1 AND is_featured = 1', [], 'created_at DESC', $limit);
    }

    public function getLatest(int $limit = 6): array {
        return $this->findAll('is_published = 1', [], 'created_at DESC', $limit);
    }

    public function getBySlug(string $slug): ?array {
        // Find by slug — controller decides about is_published
        return $this->findOne('slug = ?', [$slug]);
    }

    public function uniqueSlug(string $base, int $excludeId = 0): string {
        $slug = slug($base);
        $orig = $slug;
        for ($i = 1; $i < 1000; $i++) {
            $cond = 'slug = ?';
            $par  = [$slug];
            if ($excludeId) { $cond .= ' AND id != ?'; $par[] = $excludeId; }
            if (!$this->findOne($cond, $par)) return $slug;
            $slug = $orig . '-' . $i;
        }
        // Fallback: append a random suffix so we never loop forever.
        return $orig . '-' . bin2hex(random_bytes(4));
    }
}

// ============================================================
// JOURNAL MODEL
// ============================================================
class JournalModel extends Model {
    protected $table = 'journals';

    public function getActive(int $limit = 0, int $offset = 0): array {
        return $this->findAll('is_active = 1', [], 'sort_order ASC', $limit, $offset);
    }
}

// ============================================================
// MEMBERSHIP MODEL
// ============================================================
class MembershipModel extends Model {
    protected $table = 'memberships';

    public function getActive(): array {
        return $this->findAll('is_active = 1', [], 'sort_order ASC');
    }
}

// ============================================================
// SERVICE MODEL
// ============================================================
class ServiceModel extends Model {
    protected $table = 'services';

    public function getActive(): array {
        return $this->findAll('is_active = 1', [], 'sort_order ASC');
    }

    public function getBySlug(string $slug): ?array {
        return $this->findOne('slug = ? AND is_active = 1', [$slug]);
    }

    public function uniqueSlug(string $base, int $excludeId = 0): string {
        $slug = slug($base);
        $orig = $slug;
        for ($i = 1; $i < 1000; $i++) {
            $cond = 'slug = ?';
            $params = [$slug];
            if ($excludeId) {
                $cond .= ' AND id != ?';
                $params[] = $excludeId;
            }
            if (!$this->findOne($cond, $params)) return $slug;
            $slug = $orig . '-' . $i;
        }
        return $orig . '-' . bin2hex(random_bytes(4));
    }
}

// ============================================================
// TESTIMONIAL MODEL
// ============================================================
class TestimonialModel extends Model {
    protected $table = 'testimonials';

    public function getActive(int $limit = 0): array {
        return $this->findAll('is_active = 1', [], 'sort_order ASC, id DESC', $limit ?: 1000);
    }

    public function getAllOrdered(): array {
        return $this->findAll('1=1', [], 'sort_order ASC, id DESC');
    }
}

// ============================================================
// GALLERY MODEL
// ============================================================
class GalleryModel extends Model {
    protected $table = 'gallery';

    public function getActiveWithCategory(int $catId = 0, int $limit = 0, int $offset = 0): array {
        $where  = 'g.is_active = 1';
        $params = [];
        if ($catId) { $where .= ' AND g.category_id = ?'; $params[] = $catId; }
        $sql = "SELECT g.*, gc.name AS category_name
                FROM gallery g
                LEFT JOIN gallery_categories gc ON g.category_id = gc.id
                WHERE {$where} ORDER BY g.sort_order ASC";
        if ($limit) $sql .= " LIMIT {$limit} OFFSET {$offset}";
        return $this->query($sql, $params);
    }
}

class GalleryCategoryModel extends Model {
    protected $table = 'gallery_categories';

    public function getActive(): array {
        return $this->findAll('is_active = 1', [], 'sort_order ASC');
    }
}

// ============================================================
// EDITORIAL / REVIEWER BOARD
// ============================================================
class EditorialBoardModel extends Model {
    protected $table = 'editorial_board';

    public function getActive(): array {
        return $this->findAll('is_active = 1', [], 'sort_order ASC');
    }
}

class ReviewerBoardModel extends Model {
    protected $table = 'reviewer_board';

    public function getActive(): array {
        return $this->findAll('is_active = 1', [], 'sort_order ASC');
    }
}

// ============================================================
// CONTACT MODEL
// ============================================================
class ContactModel extends Model {
    protected $table = 'contact_messages';

    public function getUnreadCount(): int {
        return $this->count('is_read = 0');
    }
}

// ============================================================
// PAYMENT MODEL
// ============================================================
class PaymentModel extends Model {
    protected $table = 'payment_details';

    public function getActive(): ?array {
        return $this->findOne('is_active = 1');
    }
}

// ============================================================
// NEWS MODEL
// ============================================================
class NewsModel extends Model {
    protected $table = 'news';

    public function getPublished(int $limit = 0, int $offset = 0, string $search = ''): array {
        $where  = "status = 'published'";
        $params = [];
        if ($search) {
            $where  .= ' AND (title LIKE ? OR excerpt LIKE ?)';
            $params  = ["%$search%", "%$search%"];
        }
        return $this->findAll($where, $params, 'published_at DESC', $limit, $offset);
    }

    public function getBySlug(string $slug): ?array {
        return $this->findOne("slug = ? AND status = 'published'", [$slug]);
    }

    public function uniqueSlug(string $base, int $excludeId = 0): string {
        $slug = slug($base);
        $orig = $slug;
        $i    = 1;
        while (true) {
            $cond = 'slug = ?';
            $par  = [$slug];
            if ($excludeId) { $cond .= ' AND id != ?'; $par[] = $excludeId; }
            if (!$this->findOne($cond, $par)) break;
            $slug = $orig . '-' . $i++;
        }
        return $slug;
    }
}

// ============================================================
// PAGE MODEL
// ============================================================
class PageModel extends Model {
    protected $table = 'pages';

    public function getBySlug(string $slug): ?array {
        return $this->findOne("slug = ? AND status = 'published'", [$slug]);
    }
}

// ============================================================
// MENU MODEL
// ============================================================
class MenuModel extends Model {
    protected $table = 'menus';
}

// ============================================================
// SEO MODEL
// ============================================================
class SeoModel extends Model {
    protected $table = 'seo_settings';

    public function getByKey(string $key): ?array {
        return $this->findOne('page_key = ?', [$key]);
    }
}

// ============================================================
// SETTINGS MODEL
// ============================================================
class SettingsModel extends Model {
    protected $table = 'settings';

    public function getAll(): array {
        $rows = $this->findAll();
        $out  = [];
        foreach ($rows as $r) $out[$r['setting_key']] = $r['setting_value'];
        return $out;
    }

    public function set(string $key, string $value): void {
        $exists = $this->findOne('setting_key = ?', [$key]);
        if ($exists) {
            $this->update(['setting_value' => $value], 'setting_key = ?', [$key]);
        } else {
            $this->insert(['setting_key' => $key, 'setting_value' => $value]);
        }
    }
}

// ============================================================
// CONFERENCE MODEL
// ============================================================
class ConferenceModel extends Model {
    protected $table = 'conferences';

    public function getActive(int $limit = 0, int $offset = 0): array {
        return $this->findAll('is_active = 1', [], 'COALESCE(conference_date, "9999-12-31") DESC, sort_order ASC, id DESC', $limit, $offset);
    }

    /**
     * Latest active conference (the one to show on homepage).
     * Priority: admin-marked "featured" conference first, then the most recent
     * upcoming active conference, then the latest active one.
     */
    public function getLatestActive(): ?array {
        // 1. Prefer the admin-marked featured conference (only one should be marked)
        $featured = $this->findOne(
            'is_active = 1 AND is_featured = 1',
            []
        );
        if ($featured) return $featured;
        // 2. Otherwise prefer the next upcoming conference
        $upcoming = $this->findOne(
            'is_active = 1 AND conference_date >= CURDATE()',
            []
        );
        if ($upcoming) return $upcoming;
        // 3. Fallback: most recent active conference regardless of date
        return $this->findOne('is_active = 1', []);
    }

    public function getBySlug(string $slug): ?array {
        return $this->findOne('slug = ? AND is_active = 1', [$slug]);
    }

    /**
     * Past conferences (used by "View More"): excludes the one we already
     * featured on the homepage so they appear elsewhere.
     */
    public function getPastConferences(int $excludeId = 0, int $limit = 0, int $offset = 0): array {
        if ($excludeId > 0) {
            return $this->findAll('is_active = 1 AND id != ?', [$excludeId], 'COALESCE(conference_date, "9999-12-31") DESC, id DESC', $limit, $offset);
        }
        return $this->getActive($limit, $offset);
    }
}


// ============================================================
// MEMBERSHIP TYPE MODEL (detailed application page)
// ============================================================
class MembershipTypeModel extends Model {
    protected $table = 'membership_types';

    public function getActive(): array {
        return $this->findAll('is_active = 1', [], 'sort_order ASC, id ASC');
    }

    public function getBySlug(string $slug): ?array {
        return $this->findOne('slug = ?', [$slug]);
    }
}


// ============================================================
// MEMBERSHIP APPLICATION MODEL
// ============================================================
class MembershipApplicationModel extends Model {
    protected $table = 'membership_applications';

    public function getRecent(int $limit = 20, int $offset = 0): array {
        return $this->findAll('', [], 'created_at DESC', $limit, $offset);
    }

    public function getByStatus(string $status, int $limit = 50, int $offset = 0): array {
        return $this->findAll('status = ?', [$status], 'created_at DESC', $limit, $offset);
    }

    public function countUnread(): int {
        return $this->count('status = ?', ['pending']);
    }
}


// ============================================================
// ARTICLE SUBMISSION MODEL
// ============================================================
class ArticleSubmissionModel extends Model {
    protected $table = 'article_submissions';

    public function getByJournal(int $journalId, int $limit = 20, int $offset = 0): array {
        return $this->findAll('journal_id = ?', [$journalId], 'created_at DESC', $limit, $offset);
    }

    public function countByReviewStatus(string $status): int {
        return $this->count('review_status = ?', [$status]);
    }
}
