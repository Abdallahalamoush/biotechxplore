<?php
// public/index.php (Front controller)

declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require __DIR__ . '/../app/Core/bootstrap.php';

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\LevelController;
use App\Controllers\ModuleController;
use App\Controllers\LessonController;
use App\Controllers\QuizController;

$router = new Router();

// =========================
// Public routes
// =========================
$router->get('/', [HomeController::class, 'index']);
$router->get('/ping', [HomeController::class, 'ping']);

$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

// =========================
// Protected routes (auth required)
// =========================
$router->get('/levels', [LevelController::class, 'index'], auth: true);
$router->get('/levels/{slug}', [LevelController::class, 'show'], auth: true);

$router->get('/modules/{slug}', [ModuleController::class, 'show'], auth: true);
$router->get('/lessons/{slug}', [LessonController::class, 'show'], auth: true);

$router->post('/progress/toggle', [LessonController::class, 'toggleProgress'], auth: true);

// ✅ Quiz submit goes to QuizController
$router->post('/quiz/submit', [QuizController::class, 'submit'], auth: true);

// =========================
// Dispatch
// =========================
$router->dispatch();
