<?php

namespace App\Services;

use App\Models\Clients\LegalClients;

class LegalService
{
    public function store(array $data, string $directorId): array|string
    {
        $client = new LegalClients();

        $clientByKPP = $client->findByKPP($data['kpp']);
        if ($clientByKPP && ($clientByKPP['inn'] !== $data['inn'] || $clientByKPP['ogrn'] !== $data['ogrn'])) {
            return [
                'errors' => ['kpp' => 'Данный КПП зарегестрирован на другую компанию']
            ];
        }

        $exClient = $client->findExist($data['inn'], $data['ogrn']);
        if ($exClient && count($exClient) >= 2) {
            return [
              'errors' => ['main' => 'Такая пара ИНН и ОГРН указаны у разных компаний']
            ];
        }

        if ($exClient && ($exClient[0]['inn'] !== $data['inn'] || $exClient[0]['ogrn'] !==  $data['ogrn'])){
            return [
                'errors' => ['main' => 'Неверно указан ИНН или ОГРН']
            ];
        }

        if ($exClient && $exClient[0]['director_id'] !== (int)$directorId) {
            return [
                'errors' => ['main' => 'Компания с таким ИНН уже записана на другого директора']
            ];
        }

        if ($exClient) {
            $clientId = $exClient[0]['id'];
        } else {
            $clientId = $client->insert($data + ['director_id' => $directorId]);
        }

        return $clientId;
    }
}