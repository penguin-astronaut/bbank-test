<?php

namespace App\Models\Clients;

use App\Core\Model;
use PDO;

abstract class Clients extends Model
{
    public function findByINN(string $inn)
    {
        $sth = $this->db->prepare("SELECT * FROM {$this->getTableName()} WHERE `inn` = ?");
        $sth->execute([$inn]);
        return $sth->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}