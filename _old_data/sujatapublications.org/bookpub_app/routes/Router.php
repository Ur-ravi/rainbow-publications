<?php
class Router {
    private $routes = [];

    public function get(string $path, array $handler): void  { $this->add('GET',  $path, $handler); }
    public function post(string $path, array $handler): void { $this->add('POST', $path, $handler); }
    public function any(string $path, array $handler): void  { $this->add('ANY',  $path, $handler); }

    private function add(string $method, string $path, array $handler): void {
        $pattern = preg_replace('#/:([a-zA-Z_]+)#', '/(?P<$1>[^/]+)', $path);
        $this->routes[] = [
            'method'  => $method,
            'pattern' => '#^' . $pattern . '$#',
            'handler' => $handler,
        ];
    }

    public function dispatch(string $method, string $uri): void {
        // Strip query string
        if (strpos($uri, '?') !== false) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }
        $uri = '/' . ltrim($uri, '/');
        if ($uri !== '/' && substr($uri, -1) === '/') {
            $uri = rtrim($uri, '/');
        }

        error_log("[ROUTER] method=$method uri=$uri routes_loaded=" . count($this->routes));

        // Maintenance mode — block frontend but allow /admin, /install, and assets
        if (function_exists('getSetting') && getSetting('maintenance_mode') === '1') {
            $allowedPrefixes = ['/admin', '/install', '/uploads', '/css', '/img', '/assets'];
            $allowed = false;
            foreach ($allowedPrefixes as $p) {
                if (strpos($uri, $p) === 0) { $allowed = true; break; }
            }
            if (!$allowed) {
                http_response_code(503);
                $siteName = function_exists('getSetting') ? getSetting('site_name', 'Our Website') : 'Our Website';
                echo '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Maintenance — ' . htmlspecialchars($siteName) . '</title>'
                    . '<style>body{font-family:system-ui,-apple-system,sans-serif;background:linear-gradient(135deg,#0F172A,#1E293B);color:#fff;min-height:100vh;display:flex;align-items:center;justify-content:center;margin:0;padding:20px;text-align:center}'
                    . '.box{max-width:520px}h1{font-size:2.2rem;margin:0 0 10px;font-weight:800}p{color:#cbd5e1;font-size:1.05rem;line-height:1.6}.icon{font-size:4rem;margin-bottom:20px}</style></head>'
                    . '<body><div class="box"><div class="icon">🛠️</div><h1>We\'ll be back soon</h1>'
                    . '<p>' . htmlspecialchars($siteName) . ' is undergoing scheduled maintenance.<br>Please check back in a few minutes.</p></div></body></html>';
                return;
            }
        }

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method && $route['method'] !== 'ANY') continue;
            if (!preg_match($route['pattern'], $uri, $m)) continue;

            $params = array_filter($m, 'is_string', ARRAY_FILTER_USE_KEY);
            list($class, $action) = $route['handler'];
            error_log("[ROUTER] MATCHED uri=$uri → " . $class . '::' . $action);
            $controller = new $class();
            call_user_func_array([$controller, $action], array_values($params));
            return;
        }

        // 404 handler
        error_log("[ROUTER] NO MATCH uri=$uri method=$method — returning 404");
        http_response_code(404);
        $seo = ['page_title' => '404 — Page Not Found | ' . APP_NAME, 'meta_description' => ''];
        ob_start();
        require APP_PATH . '/Views/pages/404.php';
        $content = ob_get_clean();
        require APP_PATH . '/Views/layouts/main.php';
    }
}
