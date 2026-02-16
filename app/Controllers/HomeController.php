<?php

namespace App\Controllers;

class HomeController
{
    public function index(): void
    {
        view('home', [
            'title' => 'Accueil',
        ]);
    }

    public function ping(): void
    {
        echo "OK";
    }
}
