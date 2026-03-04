<?php

namespace App\Controllers;

use App\Models\Module;
use App\Core\DB;

class ModuleController
{
    public function show(string $slug): void
    {
        $pdo = DB::pdo();
        
        // We JOIN the levels table so the module knows its parent's name and slug!
        $stmt = $pdo->prepare("
            SELECT m.*, l.slug as level_slug, l.title as level_title 
            FROM modules m 
            JOIN levels l ON m.level_id = l.id 
            WHERE m.slug = ?
        ");
        $stmt->execute([$slug]);
        $module = $stmt->fetch();

        if (!$module) {
            http_response_code(404);
            view('errors/404', ['title' => '404']);
            return;
        }

        $lessons = Module::lessons((int)$module['id']);

        view('modules/show', [
            'title' => $module['title'],
            'module' => $module,
            'lessons' => $lessons
        ]);
    }
}