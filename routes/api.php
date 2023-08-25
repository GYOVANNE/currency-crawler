<?php

use App\Domains\Currency\Controllers\GetCurrencyController;
use Illuminate\Support\Facades\Route;

Route::post('currency',[GetCurrencyController::class,'execute']);
