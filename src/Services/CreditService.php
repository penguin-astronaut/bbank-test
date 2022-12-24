<?php

namespace App\Services;

use App\Models\Credits\Credits;
use App\Models\Credits\IndividualCredits;
use DateTime;

class CreditService
{
    public function store(array $data, string $clientId, Credits $credit): void
    {
        $today = new DateTime(date("Y-m-d"));

        $credit->insert($data + [
            'client_id' => $clientId,
            'start_at' => $today->format('Y-m-d'),
            'end_at' => $today->modify("+{$data['term']} months")->format('Y-m-d'),
        ]);

    }
}