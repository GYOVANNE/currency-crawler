<?php
namespace App\Domains\GetCurrency\Services;

use App\Domains\GetCurrency\Ports\StrategyInterface;

class DataFilterContext {

    private StrategyInterface $strategy;

    public function setStrategy (StrategyInterface $strategy) {
        $this->strategy = $strategy;
        return $this;
    }

    public function filterData($html, $codes) {
        return $this->strategy->execute($html, $codes);
    }
}
