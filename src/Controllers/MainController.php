<?php

namespace App\Controllers;

use App\Core\View;

class MainController
{
    public function index(): void
    {
        View::render('index');
    }
}