<?php

namespace App\Domains\Currency\Repositories;

use App\Domains\Currency\Model\Currency;
use App\Shared\Repository\RepositoryAbstract;

class GetCurrencyRepository extends RepositoryAbstract {

    public function getCurrenciesByCode(array $codes){
        return Currency::query()->whereIn('code', $codes)
        ->orWhere(function ($query) use ($codes) {
            $query->whereIn('number',$codes);
        })->get();
    }

    protected function entity(): string
    {
        return Currency::class;
    }
}
