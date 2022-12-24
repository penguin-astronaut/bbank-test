<?php

namespace App\Services;

use App\Models\Deposits\Deposits;
use DateTime;

class DepositService
{
    public function store(array $data, string $clientId, Deposits $deposit): void
    {
        $today = new DateTime(date("Y-m-d"));

        $variant = array_search((int)$data['term'], array_column(Deposits::VARIANTS, 'term'));
        $data['rate'] = Deposits::VARIANTS[$variant]['rate'];

        $deposit->insert($data + [
                'client_id' => $clientId,
                'start_at' => $today->format('Y-m-d'),
                'end_at' => $today->modify("+{$data['term']} months")->format('Y-m-d'),
            ]);

    }
}