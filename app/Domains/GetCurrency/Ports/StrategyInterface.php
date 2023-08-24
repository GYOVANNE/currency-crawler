<?php

namespace App\Domains\GetCurrency\Ports;

interface StrategyInterface {
    public function execute($html, $codes);
}
