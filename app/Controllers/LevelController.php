<?php

namespace App\Controllers;

use App\Models\Level;

class LevelController
{
    public function index(): void
    {
        $levels = Level::all();

        view('levels/index', [
            'title' => 'Niveaux',
            'levels' => $levels,
        ]);
    }

    public function show(string $slug): void
    {
        $level = Level::findBySlug($slug);
        if (!$level) {
            http_response_code(404);
            view('errors/404', ['title' => '404']);
            return;
        }

        $modules = Level::modules((int)$level['id']);

        view('levels/show', [
            'title' => $level['title'],
            'level' => $level,
            'modules' => $modules,
        ]);
    }
}
