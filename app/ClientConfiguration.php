<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientConfiguration extends Model
{
    protected $fillable = [
        'user_id',
        'client',
        'phone',
        'invoiced',
        'debt',
    ];
}
