<?php

namespace App\Models;

use App\Core\DB;

class Quiz
{
    public static function questionsForLesson(int $lessonId): array
    {
        $pdo = DB::pdo();

        $qStmt = $pdo->prepare("
            SELECT id, question_text, explanation, order_index
            FROM quiz_questions
            WHERE lesson_id = :lesson_id
            ORDER BY order_index ASC, id ASC
        ");
        $qStmt->execute([':lesson_id' => $lessonId]);
        $questions = $qStmt->fetchAll();

        if (!$questions) return [];

        $ids = array_map(fn($q) => (int)$q['id'], $questions);
        $in = implode(',', array_fill(0, count($ids), '?'));

        $oStmt = $pdo->prepare("
            SELECT id, question_id, option_text, is_correct, order_index
            FROM quiz_options
            WHERE question_id IN ($in)
            ORDER BY question_id ASC, order_index ASC, id ASC
        ");
        $oStmt->execute($ids);
        $options = $oStmt->fetchAll();

        $byQ = [];
        foreach ($options as $opt) {
            $qid = (int)$opt['question_id'];
            $byQ[$qid][] = $opt;
        }

        foreach ($questions as &$q) {
            $qid = (int)$q['id'];
            $q['options'] = $byQ[$qid] ?? [];
        }

        return $questions;
    }

    public static function isOptionCorrect(int $optionId, int $questionId): bool
    {
        $pdo = DB::pdo();
        $stmt = $pdo->prepare("
            SELECT is_correct
            FROM quiz_options
            WHERE id = :id AND question_id = :qid
            LIMIT 1
        ");
        $stmt->execute([
            ':id' => $optionId,
            ':qid' => $questionId
        ]);

        $row = $stmt->fetch();
        return !empty($row) && (int)$row['is_correct'] === 1;
    }

    public static function latestAttempt(int $userId, int $lessonId): ?array
    {
        $pdo = DB::pdo();
        $stmt = $pdo->prepare("
            SELECT id, score, total, created_at
            FROM quiz_attempts
            WHERE user_id = :user_id AND lesson_id = :lesson_id
            ORDER BY created_at DESC, id DESC
            LIMIT 1
        ");
        $stmt->execute([
            ':user_id' => $userId,
            ':lesson_id' => $lessonId
        ]);

        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function lessonSlugById(int $lessonId): string
    {
        $pdo = DB::pdo();
        $stmt = $pdo->prepare("SELECT slug FROM lessons WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $lessonId]);
        $row = $stmt->fetch();
        return $row['slug'] ?? '';
    }
}
