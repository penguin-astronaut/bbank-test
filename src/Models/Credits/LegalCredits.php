<?php

namespace App\Models\Credits;

class LegalCredits extends Credits
{

    protected function getTableName(): string
    {
        return 'credits_legal';
    }
}