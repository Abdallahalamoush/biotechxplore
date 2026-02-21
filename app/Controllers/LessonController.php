<?php

namespace App\Controllers;

use App\Models\Lesson;
use App\Models\Progress;
use App\Models\Quiz;

class LessonController
{
    public function show(string $slug): void
    {
        $userId = (int)($_SESSION['user_id'] ?? 0); // Fixed from $_SESSION['user']['id'] to match your Auth.php

        $lesson = Lesson::findBySlug($slug);
        if (!$lesson) {
            http_response_code(404);
            echo "Lesson not found";
            return;
        }

        $lessonId = (int)$lesson['id'];
        $isCompleted = ($userId > 0) ? Progress::isCompleted($userId, $lessonId) : false;

        // Detection: if there are quiz questions for this lesson => treat as quiz
        $questions = Quiz::questionsForLesson($lessonId);
        $isQuiz = !empty($questions);

        if ($isQuiz) {
            $latest = ($userId > 0) ? Quiz::latestAttempt($userId, $lessonId) : null;

            // If user just submitted, store feedback in flash
            $feedback = flash('quiz_feedback'); // array or null

            view('lessons/quiz', [
                'title' => $lesson['title'] ?? 'Quiz',
                'lesson' => $lesson,
                'isCompleted' => $isCompleted,
                'questions' => $questions,
                'latestAttempt' => $latest,
                'feedback' => $feedback,
            ]);
            return;
        }

        // Normal lesson
        view('lessons/show', [
            'title' => $lesson['title'] ?? 'Lesson',
            'lesson' => $lesson,
            'isCompleted' => $isCompleted,
        ]);
    }

    public function toggleProgress(): void
    {
        csrf_verify();

        $userId = (int)($_SESSION['user_id'] ?? 0); // Fixed to match your Auth.php
        $lessonSlug = (string)($_POST['lesson_slug'] ?? '');
        $action = (string)($_POST['action'] ?? '');

        $lesson = Lesson::findBySlug($lessonSlug);
        if (!$lesson) {
            http_response_code(404);
            echo "Lesson not found";
            return;
        }

        $lessonId = (int)$lesson['id'];

        if ($action === 'done') {
            Progress::markDone($userId, $lessonId);
        } else {
            Progress::markUndone($userId, $lessonId);
        }

        redirect('/lessons/' . $lessonSlug);
    }
}