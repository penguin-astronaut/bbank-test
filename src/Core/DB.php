<?php

namespace App\Core;

class DB
{
    private static ?\PDO $instance = null;

    private function __construct() {}

    public static function getInstance(): \PDO
    {
        if (self::$instance == null) {
            self::$instance = new \PDO(
                'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'],
                $_ENV['DB_USERNAME'],
                $_ENV['DB_PASSWORD']
            );
            self::$instance->exec('SET NAMES UTF8');
        }

        return self::$instance;
    }
}