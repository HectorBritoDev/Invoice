<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleConfiguration extends Model
{
    protected $fillable = ['user_id',
        'emission_date',
        'type',
        'number',
        'client',
        'expiration_date',
        'invoiced',
        'debt',
        'status',
        'seller',
        'unique_code',
    ];
}
