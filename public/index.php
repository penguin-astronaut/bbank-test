<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

try {
    $app = new \App\Core\App();
    $app->run();
} catch (Exception $exception) {
    if ($_ENV['MODE'] === 'development') {
        echo $exception->getMessage();
    } else {
        exit('В работе приложения произошла ошибка');
    }
}


