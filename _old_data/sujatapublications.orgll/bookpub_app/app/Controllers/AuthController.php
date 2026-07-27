<?php
class AuthController extends Controller {

    /**
     * Per-IP + per-email login rate limiter backed by storage/login_attempts table.
     * 5 failures / 15 min → temporary lockout. Uses a small DB table so it
     * works across PHP-FPM workers.
     */
    private function loginAttemptThrottle(string $email): ?string {
        try {
            $db    = Database::getInstance();
            $ip    = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
            $cut   = date('Y-m-d H:i:s', time() - 900); // 15 min
            $row   = $db->prepare("SELECT COUNT(*) FROM login_attempts WHERE (ip = ? OR email = ?) AND attempted_at > ?");
            $row->execute([$ip, $email, $cut]);
            $count = (int)$row->fetchColumn();
            if ($count >= 5) {
                return 'Too many failed attempts. Please wait 15 minutes and try again.';
            }
        } catch (\Throwable $e) {
            // If the table doesn't exist yet, fail open. Migration creates it.
            return null;
        }
        return null;
    }

    private function recordLoginAttempt(string $email, bool $success): void {
        try {
            $db = Database::getInstance();
            $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
            $stmt = $db->prepare("INSERT INTO login_attempts (ip, email, success, attempted_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$ip, $email, $success ? 1 : 0]);
        } catch (\Throwable $e) {
            // ignore — best-effort telemetry
        }
    }

    private function clearLoginAttempts(string $email): void {
        try {
            $db = Database::getInstance();
            $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
            $db->prepare("DELETE FROM login_attempts WHERE ip = ? OR email = ?")->execute([$ip, $email]);
        } catch (\Throwable $e) {
            // ignore
        }
    }

    public function login() {
        // Already logged in → go to dashboard
        if (isLoggedIn()) {
            redirect(BASE_URL . '/admin/dashboard');
            return;
        }

        $error = null;

        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {

            // H6: Honeypot — bots fill this hidden field. We do NOT sleep()
            // (that was a DoS amplifier). Just record the attempt and return
            // a generic error so the bot's behavior isn't observable.
            if (!empty($_POST['website'])) {
                $this->recordLoginAttempt('honeypot', false);
                $error = 'Invalid request.';
            } else {
                $token = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';

                if (!Security::validateCsrf($token)) {
                    $error = 'Security token expired. Please refresh the page and try again.';
                } else {
                    $email    = Security::clean(isset($_POST['email'])    ? $_POST['email']    : '');
                    $password = isset($_POST['password']) ? $_POST['password'] : '';

                    if (empty($email) || empty($password)) {
                        $error = 'Please enter your email and password.';
                    } else {
                        // H5: rate-limit BEFORE checking credentials
                        $throttle = $this->loginAttemptThrottle($email);
                        if ($throttle !== null) {
                            $error = $throttle;
                        } else {
                            try {
                                $adminModel = new AdminModel();
                                $admin      = $adminModel->findByEmail($email);

                                // H17: timing oracle fix. Always run password_verify
                                // against a dummy hash if the account doesn't exist
                                // OR password doesn't match, so response time is constant.
                                $dummyHash = '$2y$12$0000000000000000000000.0000000000000000000000000000000000';
                                if ($admin && Security::verifyPassword($password, $admin['password'])) {
                                    if (!(int)$admin['is_active']) {
                                        $this->recordLoginAttempt($email, false);
                                        $error = 'This account has been deactivated.';
                                    } else {
                                        // — LOGIN SUCCESS —
                                        error_log('[LOGIN OK] user_id=' . $admin['id'] . ' redirect=' . BASE_URL . '/admin/dashboard');

                                        // Set session data BEFORE regenerating ID so it gets copied
                                        $_SESSION['admin_id']        = (int)$admin['id'];
                                        $_SESSION['admin']           = array(
                                            'id'    => (int)$admin['id'],
                                            'name'  => $admin['name'],
                                            'email' => $admin['email'],
                                            'role'  => $admin['role'],
                                        );
                                        $_SESSION['login_time']      = time();
                                        $_SESSION['csrf_token']      = Security::generateCsrfToken();
                                        $_SESSION['csrf_token_time'] = time();

                                        // Regenerate ID AFTER setting data — copies current data to new session file
                                        session_regenerate_id(true);

                                        try { $adminModel->updateLastLogin((int)$admin['id']); } catch (Exception $e2) {}

                                        // Clear any prior failed attempts
                                        $this->clearLoginAttempts($email);

                                        $finalRedirect = BASE_URL . '/admin/dashboard';
                                        error_log('[LOGIN REDIRECT] session_id=' . session_id() . ' → ' . $finalRedirect);
                                        redirect($finalRedirect);
                                        return;
                                    }
                                } else {
                                    // Always do the verify to keep timing constant
                                    if (!$admin) Security::verifyPassword($password, $dummyHash);
                                    $this->recordLoginAttempt($email, false);
                                    usleep(300000); // 0.3s minimum delay (safe with rate-limit)
                                    $error = 'Incorrect email or password. Please try again.';

                                }

                            } catch (PDOException $e) {
                                error_log('Login DB error: ' . $e->getMessage());
                                $error = 'Database error — could not verify login.';
                            } catch (Exception $e) {
                                error_log('Login error: ' . $e->getMessage());
                                $error = 'An error occurred. Please try again.';
                            }
                        }
                    }
                }
            }
        }

        $seo = array('page_title' => 'Admin Login | ' . APP_NAME, 'meta_description' => '');
        $this->view('admin/login', compact('error', 'seo'), 'auth');
    }

    public function logout() {
        // Clear session data
        $_SESSION = array();

        // Destroy session cookie
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }

        session_destroy();
        redirect(BASE_URL . '/admin/login');
    }
}
