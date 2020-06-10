<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Invoice extends Model
{
    protected $fillable = ['user_id',
        'ruc',
        'dni',
        'code',
        'serie',
        'sunat_resolution',
        'client_name',
        'client_main_adress',
        'client_phone',
        'client_email',
        'emission_date',
        'condition',
        'expiration_date',
        'coin',
        'guide',
        'note',
        'detraction_account',
        'internal_message',
        'bank_account',
        'file',
        'status',
        'pdf',
    'budget_id'];

    public function items()
    {
        return $this->hasMany('App\InvoiceItem');
    }

    public function getFormattedEmissionDateAttribute()
    {
        return Carbon::parse($this->emission_date)->format('d-m-y');
    }
    public function getFormattedExpirationDateAttribute()
    {
        return Carbon::parse($this->expiration_date)->format('d-m-y');
    }
}
