<?php

namespace App\Controllers;

use App\Models\Module;

class ModuleController
{
    public function show(string $slug): void
    {
        $module = Module::findBySlug($slug);
        if (!$module) {
            http_response_code(404);
            view('errors/404', ['title' => '404']);
            return;
        }

        $lessons = Module::lessons((int)$module['id']);

        view('modules/show', [
            'title' => $module['title'],
            'module' => $module,
            'lessons' => $lessons,
        ]);
    }
}
