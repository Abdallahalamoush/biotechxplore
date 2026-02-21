<?php

namespace App\Models;

use App\Core\DB;

class Module
{
    public static function findBySlug(string $slug): ?array
    {
        $stmt = DB::pdo()->prepare('SELECT * FROM modules WHERE slug = :slug LIMIT 1');
        $stmt->execute(['slug' => $slug]);
        $m = $stmt->fetch();
        return $m ?: null;
    }

    public static function lessons(int $moduleId): array
    {
        $stmt = DB::pdo()->prepare('SELECT * FROM lessons WHERE module_id = :id ORDER BY order_index ASC, id ASC');
        $stmt->execute(['id' => $moduleId]);
        return $stmt->fetchAll();
    }

    /**
     * Calculates the completion percentage of a module for a specific user.
     */
    public static function getProgress(int $userId, int $moduleId): int 
    {
        $pdo = DB::pdo();
        
        // Count total lessons in module
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM lessons WHERE module_id = ?");
        $stmt->execute([$moduleId]);
        $total = (int)$stmt->fetchColumn();

        if ($total === 0) return 0;

        // Count completed lessons by this user in this module
        $stmt = $pdo->prepare("
            SELECT COUNT(*) FROM progress p 
            JOIN lessons l ON p.lesson_id = l.id 
            WHERE p.user_id = ? AND l.module_id = ?
        ");
        $stmt->execute([$userId, $moduleId]);
        $completed = (int)$stmt->fetchColumn();

        return (int)round(($completed / $total) * 100);
    }
}