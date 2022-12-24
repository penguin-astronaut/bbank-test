<?php

namespace App\Models\Clients;

use PDO;

class LegalClients extends Clients
{
    protected function getTableName(): string
    {
        return 'legal_entity_clients';
    }

    public function findExist(string $inn, string $ogrn): array|null
    {
        $sth = $this->db->prepare("SELECT * FROM {$this->getTableName()} WHERE `inn` = ? OR `ogrn` = ?");
        $sth->execute([$inn, $ogrn]);
        return $sth->fetchAll(PDO::FETCH_ASSOC) ?: null;
    }

    public function findByKPP(string $kpp)
    {
        $sth = $this->db->prepare("SELECT * FROM {$this->getTableName()} WHERE `kpp` = ?");
        $sth->execute([$kpp]);
        return $sth->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public static function getRules(): array
    {
        return [
            'name' => [
                'pattern' => '#^[\w\s"]{5,}$#u',
                'message' => 'Минимальная длина наименования 5 символа'
            ],
            'inn' => [
                'pattern' => '#^\d{10}$#',
                'message' => 'ИНН должен быть длиной 10 символов'
            ],
            'address' => [
                'pattern' => '#^.+$#',
                'message' => 'Адрес обязательное поле'
            ],
            'ogrn' => [
                'pattern' => '#^\d{13}$#',
                'message' => 'ОГРН должен быть длиной 13 символов'
            ],
            'kpp' => [
                'pattern' => '#^\d{9}$#',
                'message' => 'КПП должен быть длиной 9 символов'
            ],
        ];
    }
}