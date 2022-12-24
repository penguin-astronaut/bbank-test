<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

try {
    $app = new \App\Core\App();
    $app->run();
} catch (Exception $exception) {
    echo $exception->getMessage();
    exit('В работе приложения произошла ошибка');
}


