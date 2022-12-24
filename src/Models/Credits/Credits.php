<?php

namespace App\Models\Credits;

use App\Core\Model;

abstract class Credits extends Model
{
    public static function getRules(): array
    {
        return [
            'sum' => [
                'pattern' => '#^\d+$#u',
                'message' => 'Сумма должна быть в диапазоне от 1000 до 5000000',
                'callback' => function($value) {
                    return (int)$value >= 1000 && (int)$value <= 5000000;
                }
            ],
            'term' => [
                'pattern' => '#^\d+$#u',
                'message' => 'Кредит можно взять от 3 до 60 месяцев',
                'callback' => function($value) {
                    return (int)$value >= 3 && (int)$value <= 60;
                }
            ],
        ];
    }
}