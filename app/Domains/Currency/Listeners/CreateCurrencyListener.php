<?php

namespace App\Domains\Currency\Listeners;

use App\Domains\Currency\Events\CurrencyCreated;
use App\Domains\Currency\Model\Currency;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CreateCurrencyListener
{
    /**
     * Handle the event.
     */
    public function handle(CurrencyCreated $event): void
    {
        array_map(function ($currency) {
            $currency['currency_locations'] = json_encode($currency['currency_locations']);
            Currency::query()
            ->updateOrCreate([
                'code'=>$currency['code'],
                'number'=>$currency['number']
            ], $currency);
        },  $event->currencies);
    }
}
