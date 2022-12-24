<?php

namespace App\Controllers;

use App\Core\Validator;
use App\Core\View;
use App\Models\ClientPassport;
use App\Models\Clients\Director;
use App\Models\Clients\LegalClients;
use App\Models\Credits\Credits;
use App\Models\Credits\LegalCredits;
use App\Models\Deposits\Deposits;
use App\Models\Deposits\LegalDeposits;
use App\Services\CreditService;
use App\Services\DepositService;
use App\Services\DirectorService;
use App\Services\LegalService;

class LegalController
{
    public function credit(): void
    {
        View::render('legal/credit');
    }

    public function storeCredit(): void
    {
        ['success' => $clientValidated, 'errors' => $clientErrors] = Validator::validate(LegalClients::getRules());
        ['success' => $directorValidated, 'errors' => $directorErrors] =
            Validator::validate(Director::getRules(), 'director_');
        ['success' => $creditValidated, 'errors' => $creditErrors] = Validator::validate(Credits::getRules());

        $errors = $clientErrors + $creditErrors + $directorErrors;

        if ($errors) {
            View::render('legal/credit', ['errors' => $errors]);
            return;
        }

        $clientService = new LegalService();
        $directorService = new DirectorService();
        $creditService = new CreditService();

        $directorId = $directorService->store($directorValidated);
        $clientResult = $clientService->store($clientValidated, $directorId);
        if (is_array($clientResult)) {
            View::render('legal/credit', $clientResult);
            return;
        }

        $creditService->store($creditValidated, $clientResult, new LegalCredits());

        View::render('legal/credit', ['success' => 'Ваша заявка на кредит оформлена, с вами скоро свяжутся']);
    }

    public function deposit(): void
    {
        View::render(
            'legal/deposit',
            ['variants' => Deposits::VARIANTS, 'capitalization' => Deposits::CAPITALIZATION]
        );
    }

    public function storeDeposit(): void
    {
        $baseResponse = ['variants' => Deposits::VARIANTS, 'capitalization' => Deposits::CAPITALIZATION];

        ['success' => $clientValidated, 'errors' => $clientErrors] = Validator::validate(LegalClients::getRules());
        ['success' => $directorValidated, 'errors' => $directorErrors] =
            Validator::validate(Director::getRules(), 'director_');
        ['success' => $depositValidated, 'errors' => $depositErrors] = Validator::validate(Deposits::getRules());

        $errors = $clientErrors + $depositErrors + $directorErrors;

        if ($errors) {
            View::render('legal/deposit', $baseResponse + ['errors' => $errors]);
            return;
        }

        $clientService = new LegalService();
        $directorService = new DirectorService();
        $depositService = new DepositService();

        $directorId = $directorService->store($directorValidated);
        $clientResult = $clientService->store($clientValidated, $directorId);
        if (is_array($clientResult)) {
            View::render('legal/deposit', $baseResponse + $clientResult);
            return;
        }

        $depositService->store($depositValidated, $clientResult, new LegalDeposits());

        View::render('legal/credit', $baseResponse + ['success' => 'Ваша заявка на вклад оформлена, с вами скоро свяжутся']);
    }
}