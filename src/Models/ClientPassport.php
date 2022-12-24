<?php

namespace App\Models;

use PDO;

class ClientPassport extends \App\Core\Model
{

    protected function getTableName(): string
    {
        return 'individual_clients_passports';
    }

    public function getByClientId(int $clientId): ?array
    {
        $sth = $this->db->prepare("SELECT * FROM {$this->getTableName()} WHERE `id` = ?");
        $sth->execute([$clientId]);
        return $sth->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getBySeriesNumber(string $series, string $number)
    {
        $sth = $this->db->prepare("SELECT * FROM {$this->getTableName()} WHERE `series` = ? AND `number` = ?");
        $sth->execute([$series, $number]);
        return $sth->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public static function getRules(): array
    {
        return [
            'series' => [
                'pattern' => '#^\d{4}$#u',
                'message' => 'Некорректная серия'
            ],
            'number' => [
                'pattern' => '#^\d{6}$#u',
                'message' => 'Некорректный номер'
            ],
            'date_issue' => [
                'pattern' => '#^\d{4}-\d{2}-\d{2}$#',
                'message' => 'Некорректная дата'
            ]
        ];
    }
}