<?php

namespace App\Core;

use PDO;

abstract class Model
{
    protected \PDO $db;

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    abstract protected function getTableName(): string;

    public function getById(int $id): ?array
    {
        $sth = $this->db->prepare("SELECT * FROM {$this->getTableName()} WHERE `id` = ?");
        $sth->execute([$id]);
        return $sth->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function insert(array $data): string
    {
        $paramsString = '';
        foreach (array_keys($data) as $field) {
            $paramsString .= "`$field` = :$field,";
        }
        $paramsString = rtrim($paramsString, ',');

        $sth = $this->db->prepare("INSERT INTO {$this->getTableName()} SET $paramsString");
        $sth->execute($data);

        return $this->db->lastInsertId();
    }
}