<?php

namespace App\Models\Clients;

class Director extends Clients
{

    protected function getTableName(): string
    {
        return 'legal_entity_clients_directors';
    }

    public static function getRules(): array
    {
        return [
            'name' => [
                'pattern' => '#^^[\w ]{5,}$#u',
                'message' => 'Минимальная длина имени 5 символа'
            ],
            'inn' => [
                'pattern' => '#^\d{12}$#',
                'message' => 'ИНН должен быть длиной 12 символов'
            ],
        ];
    }
}