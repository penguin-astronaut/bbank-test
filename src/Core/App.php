<?php

namespace App\Core;

class App {
    public function run(): void
    {
        $router = new Router();

        $router->check();
    }
}