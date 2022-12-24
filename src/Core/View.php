<?php

namespace App\Core;

class View
{
    private const TEMPLATE_DIR = __DIR__ . '/../../templates/';

    public static function render(string $template, array $data = []): void
    {
        $loader = new \Twig\Loader\FilesystemLoader(self::TEMPLATE_DIR);
        $twig = new \Twig\Environment($loader);
        $data['_request'] = $_REQUEST;

        echo $twig->render("{$template}.twig", $data);
    }
}