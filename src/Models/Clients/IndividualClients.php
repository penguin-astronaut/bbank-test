<?php

namespace App\Models\Clients;

use JetBrains\PhpStorm\ArrayShape;

class IndividualClients extends Clients
{
    protected function getTableName(): string
    {
        return 'individual_clients';
    }

    public static function getRules(): array
    {
        return [
            'full_name' => [
                'pattern' => '#^[\w ]{5,}$#u',
                'message' => 'Минимальная длина имени 5 символа'
            ],
            'inn' => [
                'pattern' => '#^\d{12}$#',
                'message' => 'ИНН должен быть длиной 12 символов'
            ],
            'birthday' => [
                'pattern' => '#^\d{4}-\d{2}-\d{2}$#',
                'message' => 'Некорректная дата'
            ]
        ];
    }
}