<?php

namespace App\Models\Credits;

use App\Core\Model;

abstract class Credits extends Model
{
    const RATE = 20;

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

    public static function calculateTable(int $sum, int $term)
    {
        $monthlyRate = self::RATE / 12 / 100;
        $monthlyPay = $sum * $monthlyRate * pow(1 + $monthlyRate, $term) / (pow(1 + $monthlyRate, $term) - 1);
        $date = new \DateTime();

        $res = [];

        for ($curMonth = $term; $curMonth > 0; $curMonth--) {
            $monthlyPercent = $sum * $monthlyRate;
            $sum -= $monthlyPay - $monthlyPercent;

            $res[] = [
                'sum' => abs(round($sum,2)),
                'date' => $date->modify('+1 month')->format('Y-m-d'),
                'percent' => round($monthlyPercent, 2),
                'pay' => round($monthlyPay,2)
            ];
        }

        return $res;
    }
}