<?php

namespace App\Domains\Currency\Controllers;

use App\Domains\Currency\Requests\GetCurrencyRequest;
use App\Domains\Currency\Services\GetCurrencyService;

class GetCurrencyController {

    private $service;

    public function __construct(GetCurrencyService $service) {
        $this->service = $service;
    }

    public function execute(GetCurrencyRequest $request) {
        $currencies = $this->service->execute($request->all());
        return response()->json($currencies);
    }
}
