<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetConfiguration extends Model
{
    protected $fillable = ['user_id',
        'phone',
        'email',
        'web',
        'user_description',
        'seller',
        'reference',
        'price',
        'client_message',
        'internal_message',
        'detraction_account',
        'bank_account'];
}
