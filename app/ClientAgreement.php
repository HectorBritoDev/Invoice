<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientAgreement extends Model
{
    protected $fillable = ['client_id', 'conditions',
        'credit_line',
        'pay_method'];

        public function client()
        {
            return $this->belongsTo('App\Client');
        }
}
