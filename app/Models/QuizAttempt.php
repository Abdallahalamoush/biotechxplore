<?php
namespace App\Models;

use App\Core\DB;

class QuizAttempt
{
    public static function create(int $userId, int $lessonId, int $score, int $total): void
    {
        $pdo = DB::pdo();
        $stmt = $pdo->prepare("INSERT INTO quiz_attempts (user_id, lesson_id, score, total) VALUES (?, ?, ?, ?)");
        $stmt->execute([$userId, $lessonId, $score, $total]);
    }

    public static function lastForUser(int $userId, int $lessonId): ?array
    {
        $pdo = DB::pdo();
        $stmt = $pdo->prepare("SELECT * FROM quiz_attempts WHERE user_id = ? AND lesson_id = ? ORDER BY id DESC LIMIT 1");
        $stmt->execute([$userId, $lessonId]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
}
