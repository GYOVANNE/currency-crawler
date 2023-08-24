<?php

use App\Domains\GetCurrency\Controllers\GetCurrencyController;
use Illuminate\Support\Facades\Route;

Route::post('currency',[GetCurrencyController::class,'execute']);
