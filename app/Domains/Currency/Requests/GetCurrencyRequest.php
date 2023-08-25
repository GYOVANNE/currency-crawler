<?php

namespace App\Domains\Currency\Requests;

use App\Domains\Currency\Model\Currency;
use App\Http\Requests\APIRequest;

class GetCurrencyRequest extends APIRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return Currency::$rules;
    }
}
