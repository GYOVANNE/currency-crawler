<?php

namespace App\Domains\Currency\Ports;

interface StrategyInterface {
    public function execute($html, $codes);
}
