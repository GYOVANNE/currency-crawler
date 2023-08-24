<?php

namespace App\Domains\GetCurrency\Controllers;

use App\Domains\GetCurrency\Requests\GetCurrencyRequest;
use App\Domains\GetCurrency\Services\GetCurrencyService;

class GetCurrencyController {

    private $service;

    public function __construct(GetCurrencyService $service) {
        $this->service = $service;
    }

    public function execute(GetCurrencyRequest $request) {
        return $this->service->execute($request);
    }
}
