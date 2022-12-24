<?php

namespace App\Controllers;

use App\Core\Validator;
use App\Core\View;
use App\Models\ClientPassport;
use App\Models\Clients\IndividualClients;
use App\Models\Credits\Credits;
use App\Models\Credits\IndividualCredits;
use App\Models\Deposits\Deposits;
use App\Models\Deposits\IndividualDeposits;
use App\Services\CreditService;
use App\Services\DepositService;
use App\Services\IndividualService;
use App\Services\PassportService;

class IndividualController
{
    public function credit(): void
    {
        View::render('individual/credit');
    }

    public function storeCredit(): void
    {
        ['success' => $clientValidated, 'errors' => $clientErrors] = Validator::validate(IndividualClients::getRules());
        ['success' => $passportValidated, 'errors' => $passportErrors] =
            Validator::validate(ClientPassport::getRules(), 'passport_');
        ['success' => $creditValidated, 'errors' => $creditErrors] = Validator::validate(Credits::getRules());

        $errors = $clientErrors + $creditErrors + $passportErrors;

        if ($errors) {
            View::render('individual/credit', ['errors' => $errors]);
            return;
        }

        $clientService = new IndividualService();
        $passportService = new PassportService();
        $creditService = new CreditService();

        $clientId = $clientService->store($clientValidated);
        if ($errors = $passportService->store($passportValidated, $clientId)) {
            View::render('individual/credit', ['errors' => $errors]);
            return;
        }

        $creditService->store($creditValidated, $clientId, new IndividualCredits());

        View::render('individual/credit', ['success' => 'Ваша заявка на кредит оформлена, с вами скоро свяжутся']);
    }

    public function deposit(): void
    {
        View::render(
            'individual/deposit',
            ['variants' => Deposits::VARIANTS, 'capitalization' => Deposits::CAPITALIZATION]
        );
    }

    public function depositStore(): void
    {
        $baseRequest = ['variants' => Deposits::VARIANTS, 'capitalization' => Deposits::CAPITALIZATION];

        ['success' => $clientValidated, 'errors' => $clientErrors] = Validator::validate(IndividualClients::getRules());
        ['success' => $passportValidated, 'errors' => $passportErrors] =
            Validator::validate(ClientPassport::getRules(), 'passport_');
        ['success' => $depositValidated, 'errors' => $depositErrors] = Validator::validate(Deposits::getRules());

        $errors = $clientErrors + $depositErrors + $passportErrors;

        if ($errors) {
            View::render('individual/deposit', $baseRequest + ['errors' => $errors]);
            return;
        }

        $clientService = new IndividualService();
        $passportService = new PassportService();
        $depositService = new DepositService();

        $clientId = $clientService->store($clientValidated);
        if ($errors = $passportService->store($passportValidated, $clientId)) {
            View::render('individual/deposit', $baseRequest + ['errors' => $errors]);
            return;
        }

        $depositService->store($depositValidated, $clientId, new IndividualDeposits());

        View::render('individual/deposit', $baseRequest + ['success' => 'Ваша заявка на вклад оформлена, с вами скоро свяжутся']);
    }
}