<?php

namespace App\Models\Deposits;

class IndividualDeposits extends Deposits
{

    protected function getTableName(): string
    {
        return 'deposit_individual';
    }
}