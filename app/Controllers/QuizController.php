<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\DB;
use App\Models\Quiz;

class QuizController
{
    public function submit(): void
    {
        Auth::requireLogin();
        csrf_verify();

        $lessonId = (int)($_POST['lesson_id'] ?? 0);
        if ($lessonId <= 0) {
            flash('error', 'Invalid lesson.');
            redirect('/levels');
        }

        $lessonSlug = Quiz::lessonSlugById($lessonId);
        if (!$lessonSlug) {
            flash('error', 'Lesson not found.');
            redirect('/levels');
        }

        $questions = Quiz::questionsForLesson($lessonId);
        if (empty($questions)) {
            flash('error', 'No questions for this quiz yet.');
            redirect('/lessons/' . $lessonSlug);
        }

        $answers = $_POST['answers'] ?? [];
        if (!is_array($answers)) {
            $answers = [];
        }

        $score = 0;
        $total = count($questions);

        foreach ($questions as $q) {
            $qid = (int)($q['id'] ?? 0);
            if ($qid <= 0) continue;

            $chosenOptionId = isset($answers[$qid]) ? (int)$answers[$qid] : 0;

            if ($chosenOptionId > 0 && Quiz::isOptionCorrect($chosenOptionId, $qid)) {
                $score++;
            }
        }

        $pdo = DB::pdo();
        $stmt = $pdo->prepare("
            INSERT INTO quiz_attempts (user_id, lesson_id, score, total)
            VALUES (:user_id, :lesson_id, :score, :total)
        ");
        $stmt->execute([
            ':user_id'   => Auth::id(),
            ':lesson_id' => $lessonId,
            ':score'     => $score,
            ':total'     => $total,
        ]);

        // Use a dedicated key so you can display it cleanly
        flash('quiz_result', "Score: {$score}/{$total}");
        redirect('/lessons/' . $lessonSlug);
    }
}
