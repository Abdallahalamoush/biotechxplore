<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, array $handler, bool $auth = false): void
    {
        $this->add('GET', $path, $handler, $auth);
    }

    public function post(string $path, array $handler, bool $auth = false): void
    {
        $this->add('POST', $path, $handler, $auth);
    }

    private function normalizePath(string $path): string
    {
        // Enlève le trailing slash (sauf si c'est juste "/")
        $p = parse_url($path, PHP_URL_PATH) ?: '/';
        $p = rtrim($p, '/');
        return $p === '' ? '/' : $p;
    }

    private function add(string $method, string $path, array $handler, bool $auth): void
    {
        $normalized = $this->normalizePath($path);

        // {slug} -> capture
        $regex = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '([^/]+)', $normalized);

        // ✅ IMPORTANT: le "/" doit matcher "/"
        if ($normalized === '/') {
            $regex = '#^/$#';
        } else {
            $regex = '#^' . $regex . '$#';
        }

        $this->routes[] = [
            'method'  => $method,
            'path'    => $normalized,
            'regex'   => $regex,
            'handler' => $handler,
            'auth'    => $auth,
        ];
    }

    public function dispatch(): void
    {
        $method = request_method();

        // On normalise aussi le chemin demandé
        $path = $this->normalizePath(request_path());

        foreach ($this->routes as $r) {
            if ($r['method'] !== $method) {
                continue;
            }

            if (!preg_match($r['regex'], $path, $matches)) {
                continue;
            }

            array_shift($matches);

            if ($r['auth']) {
                Auth::requireLogin();
            }

            [$class, $action] = $r['handler'];
            $controller = new $class();
            $controller->$action(...$matches);
            return;
        }

        http_response_code(404);
        view('errors/404', ['title' => '404']);
    }
}
