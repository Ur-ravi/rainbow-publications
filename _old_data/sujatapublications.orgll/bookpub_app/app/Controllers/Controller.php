<?php
abstract class Controller {

    protected function view(string $view, array $data = [], string $layout = 'main'): void {
        extract($data);
        ob_start();
        require APP_PATH . '/Views/' . $view . '.php';
        $content = ob_get_clean();
        require APP_PATH . '/Views/layouts/' . $layout . '.php';
    }

    protected function adminView(string $view, array $data = []): void {
        requireAdmin();
        $adminUser = $_SESSION['admin'] ?? [];
        extract($data);
        ob_start();
        require APP_PATH . '/Views/' . $view . '.php';
        $content = ob_get_clean();
        require APP_PATH . '/Views/layouts/admin.php';
    }

    // PHP 7.4 compatible — use void return type, call exit inside
    protected function json(array $data, int $status = 200): void {
        jsonResponse($data, $status);
    }

    protected function redirect(string $url): void {
        redirect($url);
    }

    protected function csrfCheck(): void {
        $token = $_POST['csrf_token'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');
        if (!Security::validateCsrf($token)) {
            // Diagnostic logging — safe because we never echo the actual token value
            $reason = 'unknown';
            if (empty($token)) {
                $reason = 'token_missing_from_post';
            } elseif (empty($_SESSION['csrf_token'])) {
                $reason = 'session_token_missing (session was reset between page load and submit — likely cookie dropped)';
            } elseif (time() - ($_SESSION['csrf_token_time'] ?? 0) > CSRF_TOKEN_EXPIRE) {
                $reason = 'session_token_expired';
            } else {
                $reason = 'session_token_mismatch';
            }
            error_log(sprintf(
                '[CSRF FAIL] %s %s | reason=%s | session_id=%s | cookie_sent=%s | origin=%s | referer=%s',
                $_SERVER['REQUEST_METHOD'] ?? '?',
                $_SERVER['REQUEST_URI']    ?? '?',
                $reason,
                session_id() ?: 'none',
                (isset($_COOKIE[session_name()]) ? 'yes' : 'no'),
                $_SERVER['HTTP_ORIGIN']    ?? 'none',
                $_SERVER['HTTP_REFERER']   ?? 'none'
            ));
            $this->json(['success' => false, 'message' => 'Invalid security token. Please refresh and try again.'], 403);
        }
    }

    protected function paginate(int $total, int $perPage, int $currentPage): array {
        $totalPages  = max(1, (int)ceil($total / $perPage));
        $currentPage = min(max(1, $currentPage), $totalPages);
        return [
            'total'        => $total,
            'per_page'     => $perPage,
            'current_page' => $currentPage,
            'total_pages'  => $totalPages,
            'offset'       => ($currentPage - 1) * $perPage,
            'has_prev'     => $currentPage > 1,
            'has_next'     => $currentPage < $totalPages,
        ];
    }
}
