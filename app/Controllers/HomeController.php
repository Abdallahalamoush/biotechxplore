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

    public function about(): void
    {
        view('about', ['title' => 'About Us - BioTechXplore']);
    }

    public function contact(): void
    {
        view('contact', ['title' => 'Contact Us']);
    }
}
