<?php

namespace App\Domains\Currency\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $table = 'currencies';

    protected $fillable = [
        'code',
        'number',
        'decimal',
        'currency',
        'currency_locations'
    ];

    public static $rules = [
        'code'=>'nullable|string|size:3',
        'code_list'=>'nullable|array',
        'code_list.*' => 'nullable|string|size:3',
        'number'=>'nullable|numeric',
        'number_lists'=>'nullable|array',
        'number_list.*' => 'nullable|numeric',
    ];
}
