<?php
// app/Core/helpers.php

declare(strict_types=1);

function app_url(string $path = ''): string
{
    $base = rtrim(env('APP_URL'), '/');
    return $base . ($path ? '/' . ltrim($path, '/') : '');
}

function request_method(): string
{
    return strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
}

function request_path(): string
{
    // Avec .htaccess, on récupère l'URL telle quelle
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    $path = parse_url($uri, PHP_URL_PATH) ?? '/';

    // Si le projet est dans un sous-dossier, tu peux ajouter une déduction ici.
    return rtrim($path, '/') ?: '/';
}

function view(string $template, array $data = []): void
{
    extract($data);
    $templatePath = __DIR__ . '/../../views/' . $template . '.php';
    if (!file_exists($templatePath)) {
        http_response_code(500);
        exit('Vue introuvable : ' . htmlspecialchars($template));
    }

    require __DIR__ . '/../../views/layout.php';
}

function redirect(string $to): void
{
    header('Location: ' . $to);
    exit;
}

function flash(string $key, ?string $value = null): ?string
{
    if ($value !== null) {
        $_SESSION['flash'][$key] = $value;
        return null;
    }

    $val = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $val;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_verify(): void
{
    $token = $_POST['_csrf'] ?? '';
    if (!$token || !hash_equals($_SESSION['csrf'] ?? '', $token)) {
        http_response_code(419);
        exit('CSRF invalide');
    }
}
