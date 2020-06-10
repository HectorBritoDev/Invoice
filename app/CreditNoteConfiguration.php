<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditNoteConfiguration extends Model
{
    protected $fillable = ['user_id',
        'phone',
        'email',
        'web',
        'user_description',
        'seller',
        'price',
        'reference',
        'client_message',
        'internal_message',
        'detraction_account',
        'bank_account'];
}
