<?php

namespace App\Models\Credits;

class IndividualCredits extends Credits
{

    protected function getTableName(): string
    {
        return 'credits_individual';
    }
}