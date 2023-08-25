<?php
namespace App\Domains\Currency\Services;

use App\Domains\Currency\Ports\StrategyInterface;

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
