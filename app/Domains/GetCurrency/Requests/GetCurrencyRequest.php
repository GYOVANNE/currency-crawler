<?php

namespace App\Domains\GetCurrency\Requests;

use App\Http\Requests\APIRequest;

class GetCurrencyRequest extends APIRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code'=>'nullable|string|size:3',
            'code_list'=>'nullable|array',
            'code_list.*' => 'nullable|string|size:3',
            'number'=>'nullable|numeric',
            'number_lists'=>'nullable|array',
            'number_list.*' => 'nullable|numeric',
        ];
    }
}
