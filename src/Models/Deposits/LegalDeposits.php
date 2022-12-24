<?php

namespace App\Models\Deposits;

class LegalDeposits extends Deposits
{
    protected function getTableName(): string
    {
        return 'deposit_legal';
    }
}