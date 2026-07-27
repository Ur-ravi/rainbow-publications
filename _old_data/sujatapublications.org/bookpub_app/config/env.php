<?php
/**
 * Lightweight .env loader
 * Reads KEY=VALUE pairs from a .env file at the project root.
 * Existing putenv/getenv values are not overridden.
 */

if (!function_exists('loadEnvFile')) {
    function loadEnvFile(?string $path = null): void {
        static $loaded = false;
        if ($loaded) return;
        $loaded = true;

        $candidates = array_filter([
            $path,
            $path === null ? __DIR__ . '/../../.env' : null,
            __DIR__ . '/../.env',
        ]);
        foreach ($candidates as $file) {
            if (!is_readable($file)) continue;
            $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '' || $line[0] === '#') continue;
                if (!str_contains($line, '=')) continue;
                [$k, $v] = explode('=', $line, 2);
                $k = trim($k); $v = trim($v);
                $v = trim($v, "\"' \t\n\r\0\x0B");
                if (getenv($k) === false) {
                    putenv("$k=$v");
                    $_ENV[$k] = $v;
                }
            }
            return;
        }
    }
}

if (!function_exists('env')) {
    function env(string $key, $default = null) {
        $v = getenv($key);
        if ($v === false) {
            $v = $_ENV[$key] ?? $default;
        }
        if ($v === null) return null;
        $low = strtolower((string)$v);
        if ($low === 'true')  return true;
        if ($low === 'false') return false;
        if ($low === 'null')  return null;
        return $v;
    }
}

loadEnvFile();
