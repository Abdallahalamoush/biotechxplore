<?php
/**
 * Bootstrap de l'application
 * - Charge env.php
 * - Helpers (env, request_path, url, view, redirect, flash, csrf)
 * - Autoloader simple (namespace App\...)
 * - Démarre la session
 * - Configure PDO + init App\Core\DB
 */

// =========================
// 1) Charger la config ENV
// =========================
$GLOBALS['APP_ENV'] = require __DIR__ . '/env.php';

if (!function_exists('env')) {
    function env(string $key, $default = null) {
        return $GLOBALS['APP_ENV'][$key] ?? $default;
    }
}

// =========================
// 2) Helpers Request & Path Detection
// =========================
if (!function_exists('get_base_url')) {
    function get_base_url(): string {
        // Automatically detects your MAMP folder (e.g., /BioTechXplore/public)
        $scriptDir = dirname($_SERVER['SCRIPT_NAME']);
        return ($scriptDir === '/' || $scriptDir === '\\') ? '' : $scriptDir;
    }
}

if (!function_exists('request_path')) {
    function request_path(): string {
        // 100% Foolproof: reads the exact route from the ?r= parameter
        if (isset($_GET['r'])) {
            $p = trim((string)$_GET['r']);
            if ($p === '') return '/';
            return $p[0] === '/' ? $p : '/' . $p;
        }
        return '/';
    }
}

if (!function_exists('request_method')) {
    function request_method(): string {
        return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    }
}

if (!function_exists('is_post')) {
    function is_post(): bool {
        return request_method() === 'POST';
    }
}
// =========================
// 3) Debug (optionnel)
// =========================
if (env('APP_DEBUG', false)) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
}

// =========================
// 4) Autoload (App\...)
// =========================
spl_autoload_register(function ($class) {
    $prefix  = 'App\\';
    $baseDir = dirname(__DIR__) . '/'; // .../app/

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// =========================
// 5) Session
// =========================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// =========================
// 6) Dynamic URL helper (Foolproof URLs)
// =========================
if (!function_exists('url')) {
    function url(string $path): string {
        $p = trim($path);
        if ($p === '') $p = '/';
        if ($p[0] !== '/') $p = '/' . $p;
        
        // Builds a guaranteed working URL: /your_folder/public/?r=/path
        return get_base_url() . '/?r=' . $p;
    }
}

// =========================
// 7) View / Redirect
// =========================
if (!function_exists('view')) {
    function view(string $name, array $data = []): void
    {
        extract($data, EXTR_SKIP);

        $viewFile = dirname(__DIR__, 2) . '/views/' . $name . '.php';

        if (!file_exists($viewFile)) {
            http_response_code(500);
            echo "Vue introuvable : " . htmlspecialchars($name);
            return;
        }

        require $viewFile;
    }
}

if (!function_exists('redirect')) {
    function redirect(string $path): void
    {
        header('Location: ' . url($path));
        exit;
    }
}

// =========================
// 8) Flash messages
// =========================
if (!function_exists('flash')) {
    function flash(string $key, ?string $message = null): ?string
    {
        // SET
        if ($message !== null) {
            $_SESSION['_flash'][$key] = $message;
            return null;
        }

        // GET (and delete)
        if (!isset($_SESSION['_flash'][$key])) {
            return null;
        }

        $value = $_SESSION['_flash'][$key];
        unset($_SESSION['_flash'][$key]);
        return $value;
    }
}

// =========================
// 9) CSRF minimal
// =========================
if (!function_exists('csrf_token')) {
    function csrf_token(): string
    {
        if (empty($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf'];
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field(): string
    {
        $t = htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8');
        return '<input type="hidden" name="_csrf" value="' . $t . '">';
    }
}

if (!function_exists('csrf_verify')) {
    function csrf_verify(): void
    {
        // Vérif uniquement sur POST
        if (request_method() !== 'POST') {
            return;
        }

        $sent = $_POST['_csrf'] ?? '';
        $real = $_SESSION['_csrf'] ?? '';

        if (!$sent || !$real || !hash_equals($real, $sent)) {
            http_response_code(403);
            die("CSRF invalide.");
        }
    }
}

// =========================
// 10) Connexion DB (PDO)
// =========================
$host = env('DB_HOST', '127.0.0.1');
$port = env('DB_PORT', '8889');
$db   = env('DB_NAME', 'biotechxplore');
$user = env('DB_USER', 'root');
$pass = env('DB_PASS', 'root');

$dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    $GLOBALS['DB'] = $pdo;

    // Init wrapper App\Core\DB si présent
    if (class_exists(\App\Core\DB::class) && method_exists(\App\Core\DB::class, 'init')) {
        \App\Core\DB::init($pdo);
    }

} catch (PDOException $e) {
    die("Erreur DB : " . $e->getMessage());
}