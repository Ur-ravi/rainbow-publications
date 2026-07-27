<?php
// ============================================================
// DATABASE — PDO Singleton (PHP 7.4 compatible)
// ============================================================
class Database {
    private static $instance = null;

    public static function getInstance(): PDO {
        if (self::$instance === null) {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
            self::$instance = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
            PDO::ATTR_TIMEOUT            => 10,
            ]);
        }
        return self::$instance;
    }

    private function __clone() {}
}

// ============================================================
// BASE MODEL CLASS (PHP 7.4 compatible)
// ============================================================
abstract class Model {
    protected $db;
    protected $table;
    protected $primaryKey = 'id';

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function findAll(string $conditions = '', array $params = [], string $orderBy = 'id DESC', int $limit = 0, int $offset = 0): array {
        // Defense-in-depth: cast limit/offset to int even if the caller passes a string.
        $limit  = (int)$limit;
        $offset = max(0, (int)$offset);
        // Whitelist orderBy against a strict identifier pattern. Any string that
        // does not match (column names + optional ASC/DESC, comma-separated)
        // is replaced with the default "id DESC". This prevents SQLi via ORDER BY.
        if ($orderBy !== '' && !preg_match('/^[A-Za-z0-9_`.,\s()]+(?:\s+(?:ASC|DESC))?(?:\s*,\s*[A-Za-z0-9_`.,\s()]+(?:\s+(?:ASC|DESC))?)*$/', $orderBy)) {
            $orderBy = 'id DESC';
        }
        $sql = "SELECT * FROM `{$this->table}`";
        if ($conditions) $sql .= " WHERE {$conditions}";
        if ($orderBy)    $sql .= " ORDER BY {$orderBy}";
        if ($limit > 0)  $sql .= " LIMIT {$limit} OFFSET {$offset}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findOne(string $conditions, array $params = []): ?array {
        $sql  = "SELECT * FROM `{$this->table}` WHERE {$conditions} LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function findById(int $id): ?array {
        return $this->findOne("{$this->primaryKey} = ?", [$id]);
    }

    public function insert(array $data): int {
        $cols   = implode(', ', array_map(function($k) { return "`{$k}`"; }, array_keys($data)));
        $places = implode(', ', array_fill(0, count($data), '?'));
        $sql    = "INSERT INTO `{$this->table}` ({$cols}) VALUES ({$places})";
        $stmt   = $this->db->prepare($sql);
        $stmt->execute(array_values($data));
        return (int)$this->db->lastInsertId();
    }

    public function update(array $data, string $conditions, array $condParams = []): bool {
        $sets = implode(', ', array_map(function($k) { return "`{$k}` = ?"; }, array_keys($data)));
        $sql  = "UPDATE `{$this->table}` SET {$sets} WHERE {$conditions}";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(array_merge(array_values($data), $condParams));
    }

    public function delete(string $conditions, array $params = []): bool {
        $sql  = "DELETE FROM `{$this->table}` WHERE {$conditions}";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function count(string $conditions = '', array $params = []): int {
        $sql = "SELECT COUNT(*) FROM `{$this->table}`";
        if ($conditions) $sql .= " WHERE {$conditions}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn();
    }

    public function query(string $sql, array $params = []): array {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function queryOne(string $sql, array $params = []): ?array {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function scalar(string $sql, array $params = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }
}
