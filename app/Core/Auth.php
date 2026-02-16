<?php

namespace App\Core;

class Auth
{
    public static function id(): int
    {
        return (int)($_SESSION['user_id'] ?? 0);
    }

    public static function check(): bool
    {
        return !empty($_SESSION['user_id']);
    }

    public static function requireLogin(): void
    {
        if (!self::check()) {
            flash('error', 'Please login to continue.');
            redirect('/login');
        }
    }

    public static function login(int $userId): void
    {
        $_SESSION['user_id'] = $userId;
    }

    public static function logout(): void
    {
        unset($_SESSION['user_id']);
    }
}
