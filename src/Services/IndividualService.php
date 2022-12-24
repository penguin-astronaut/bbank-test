<?php

namespace App\Services;

use App\Models\Clients\IndividualClients;

class IndividualService
{
    public function store(array $data): string
    {
        $client = new IndividualClients();

        if (!$exClient = $client->findByINN($data['inn'])) {
            $clientId = $client->insert($data);
        } else {
            $clientId = $exClient['id'];
        }

        return $clientId;
    }
}