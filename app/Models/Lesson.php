<?php

namespace App\Models;

use App\Core\DB;

class Lesson
{
    public static function findBySlug(string $slug): ?array
    {
        $stmt = DB::pdo()->prepare('SELECT * FROM lessons WHERE slug = :slug LIMIT 1');
        $stmt->execute(['slug' => $slug]);
        $l = $stmt->fetch();
        return $l ?: null;
    }

    public static function isCompleted(int $userId, int $lessonId): bool
    {
        $stmt = DB::pdo()->prepare('SELECT id FROM progress WHERE user_id = :u AND lesson_id = :l LIMIT 1');
        $stmt->execute(['u'=>$userId,'l'=>$lessonId]);
        return (bool)$stmt->fetch();
    }
}
