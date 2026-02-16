<?php

namespace App\Models;

use App\Core\DB;

class Progress
{
    public static function isCompleted(int $userId, int $lessonId): bool
    {
        $pdo = DB::pdo();
        $stmt = $pdo->prepare("SELECT 1 FROM progress WHERE user_id = ? AND lesson_id = ? LIMIT 1");
        $stmt->execute([$userId, $lessonId]);
        return (bool)$stmt->fetchColumn();
    }

    public static function markDone(int $userId, int $lessonId): void
    {
        $pdo = DB::pdo();
        $stmt = $pdo->prepare("INSERT IGNORE INTO progress (user_id, lesson_id, completed_at) VALUES (?, ?, NOW())");
        $stmt->execute([$userId, $lessonId]);
    }

    public static function markUndone(int $userId, int $lessonId): void
    {
        $pdo = DB::pdo();
        $stmt = $pdo->prepare("DELETE FROM progress WHERE user_id = ? AND lesson_id = ?");
        $stmt->execute([$userId, $lessonId]);
    }
}
