<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Models\User;

class AuthController
{
    public function showLogin(): void
    {
        view('auth/login', [
            'title' => 'Login'
        ]);
    }

    public function login(): void
    {
        csrf_verify();

        $email = trim((string)($_POST['email'] ?? ''));
        $pass  = (string)($_POST['password'] ?? '');

        if ($email === '' || $pass === '') {
            flash('error', 'Email and password are required.');
            redirect('/login');
        }

        $user = User::findByEmail($email);

        if (!$user) {
            flash('error', 'Invalid credentials.');
            redirect('/login');
        }

        // If you already store hashed passwords in DB:
        // password_verify($pass, $user['password_hash'])
        // If your column is different, adjust it here.
        $hash = $user['password_hash'] ?? ($user['password'] ?? null);

        if (!$hash || !password_verify($pass, $hash)) {
            flash('error', 'Invalid credentials.');
            redirect('/login');
        }

        Auth::login((int)$user['id']);

        redirect('/levels');
    }

    public function logout(): void
    {
        Auth::logout();
        redirect('/');
    }
}
