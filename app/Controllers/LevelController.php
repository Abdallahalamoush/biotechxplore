<?php

namespace App\Controllers;

use App\Models\Level;
use App\Core\DB;

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

        // Fetch all modules for this level
        $modules = Level::modules((int)$level['id']);

        // 1. Fetch all Quizzes directly from the DB, strictly ordered by Chapter/Module order
        $pdo = DB::pdo();
        $stmt = $pdo->prepare("
            SELECT l.*, m.title as module_title 
            FROM lessons l 
            JOIN modules m ON l.module_id = m.id 
            WHERE m.level_id = ? AND (l.title LIKE '%Quiz%' OR l.title LIKE '%Review%')
            ORDER BY m.order_index ASC, l.order_index ASC
        ");
        $stmt->execute([(int)$level['id']]);
        $quizzes = $stmt->fetchAll();

        // 2. Separate into exact categories based on the title
        $generalKnowledge = [];
        $chapters = [];

        foreach ($modules as $m) {
            $moduleTitle = strtolower($m['title'] ?? '');
            
            // If the module title contains the word "chapter", it goes to Core Chapters
            if (str_contains($moduleTitle, 'chapter')) {
                $chapters[] = $m;
            } 
            // If it's the review/quiz module, SKIP IT! (We already show the quizzes at the bottom)
            elseif (str_contains($moduleTitle, 'quiz') || str_contains($moduleTitle, 'review')) {
                continue;
            }
            // Otherwise, it goes to General Knowledge
            else {
                $generalKnowledge[] = $m;
            }
        }

        // 3. Guarantee perfect numerical order (e.g., Chapter 1 -> 2 -> 3 -> 4)
        $sortByIndex = function($a, $b) {
            return ((int)($a['order_index'] ?? 0)) <=> ((int)($b['order_index'] ?? 0));
        };

        usort($generalKnowledge, $sortByIndex);
        usort($chapters, $sortByIndex);

        view('levels/show', [
            'title' => $level['title'],
            'level' => $level,
            'generalKnowledge' => $generalKnowledge,
            'chapters' => $chapters,
            'quizzes' => $quizzes
        ]);
    }
}