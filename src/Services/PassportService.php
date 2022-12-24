<?php

namespace App\Services;

use App\Models\ClientPassport;

class PassportService
{
    public function store(array $data, string $clientId): array|null
    {
        $passport = new ClientPassport();

        $exPassport = $passport->getByClientId($clientId);
        if ($exPassport && ($exPassport['series'] !== $data['series'] || ($exPassport['number'] !== $data['number']))) {
            return ['errors' => ['passport_series' => 'У вас уже указан другой паспорт']];
        } elseif (!$exPassport) {
            $exPassport = $passport->getBySeriesNumber($data['series'], $data['number']);
        }

        if ($exPassport && $exPassport['client_id'] !== (int)$clientId) {
            return ['errors' => ['passport_series' => 'Данный паспорт указан у другого человека']];
        } elseif (!$exPassport) {
            $passport->insert($data + ['client_id' => $clientId]);
        }

        return null;
    }
}