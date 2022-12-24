<?php

namespace App\Core;

use App\Controllers\{MainController, LegalController, IndividualController};

class Router {

    private array $routes = [
        'get' => [
            '/' => [MainController::class, 'index'],

            '/individual/credit' => [IndividualController::class, 'credit'],
            '/individual/deposit' => [IndividualController::class, 'deposit'],

            '/legal/credit' => [LegalController::class, 'credit'],
            '/legal/deposit' => [LegalController::class, 'deposit'],
        ],
        'post' => [
            '/calculate_table' => [MainController::class, 'calculate'],

            '/individual/credit' => [IndividualController::class, 'storeCredit'],
            '/individual/deposit' => [IndividualController::class, 'storeDeposit'],

            '/legal/credit' => [LegalController::class, 'storeCredit'],
            '/legal/deposit' => [LegalController::class, 'storeDeposit'],
        ],
    ];

    public function check(): void
    {
        $method = mb_strtolower($_SERVER['REQUEST_METHOD']);
        $route = $this->routes[$method][$_SERVER['REQUEST_URI']] ?? null;

        if (!$route) {
            exit('Не найдено');
        }

        $controller = new $route[0];
        $controller->{$route[1]}();
    }
}