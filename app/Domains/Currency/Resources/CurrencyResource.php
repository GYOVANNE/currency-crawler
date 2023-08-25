<?php

namespace App\Domains\Currency\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code'=>$this->code,
            'number'=>$this->number,
            'decimal'=>$this->decimal,
            'currency'=>$this->currency,
            'currency_locations'=>json_decode($this->currency_locations),
        ];
    }
}
