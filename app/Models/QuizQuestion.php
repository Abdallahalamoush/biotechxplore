<?php
namespace App\Models;

use App\Core\DB;

class QuizQuestion
{
    public static function forLesson(int $lessonId): array
    {
        $pdo = DB::pdo();

        $stmt = $pdo->prepare("SELECT * FROM quiz_questions WHERE lesson_id = ? ORDER BY order_index ASC, id ASC");
        $stmt->execute([$lessonId]);
        $questions = $stmt->fetchAll();

        // attach options
        $optStmt = $pdo->prepare("SELECT * FROM quiz_options WHERE question_id = ? ORDER BY order_index ASC, id ASC");

        foreach ($questions as &$q) {
            $optStmt->execute([(int)$q['id']]);
            $q['options'] = $optStmt->fetchAll();
        }

        return $questions;
    }
}
