<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Credits\Credits;
use App\Utils\CreditPrint;

class MainController
{
    public function index(): void
    {
        View::render('index');
    }

    public function calculate(): void
    {
        $sum = (float)$_REQUEST['sum'];
        $term = (int)$_REQUEST['term'];

        $creditPrint = new CreditPrint();
        $table = Credits::calculateTable($sum, $term);

        echo $creditPrint->print($table);
    }
}