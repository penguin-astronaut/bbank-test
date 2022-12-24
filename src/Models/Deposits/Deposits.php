<?php

namespace App\Models\Deposits;

use App\Core\Model;

abstract class Deposits extends Model
{
    const VARIANTS = [
        [
            'term' => 3,
            'rate' => 6,
        ],
        [
            'term' => 6,
            'rate' => 7,
        ],
        [
            'term' => 12,
            'rate' => 8,
        ],
        [
            'term' => 24,
            'rate' => 9,
        ],
        [
            'term' => 36,
            'rate' => 10,
        ]
    ];

    const CAPITALIZATION = ['monthly' => 'Ежемесячно', 'end' => 'В конце срока'];

    public static function getRules(): array
    {
        return [
            'term' => [
                'pattern' => '#^\d+$#u',
                'message' => 'Выберете значение из списка',
                'callback' => function($value) {
                    return in_array((int)$value, array_map(fn($item) => $item['term'], self::VARIANTS));
                }
            ],
            'capitalization' => [
                'pattern' => '#^\w+$#u',
                'message' => 'Выберете значение из списка',
                'callback' => function($value) {
                    return in_array($value, array_keys(self::CAPITALIZATION));
                }
            ]
        ];
    }
}