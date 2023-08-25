<?php

namespace App\Domains\Currency\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CurrencyCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array  $currencies;

    public function __construct(array $currencies)
    {
        $this->currencies = $currencies;
    }

}
