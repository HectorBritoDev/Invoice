<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class SenderGuide extends Model
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
        'invoice_id',
        'start_point',
        'end_point',
        'reason',
        'transfer_date',
        'licence_plate',
        'car_brand',
        'driver_licence',
        'driver_name',
        'driver_ruc',
        'payer_dni',
        'payer_ruc',
    ];

    public function items()
    {
        return $this->hasMany('App\SenderGuideItem');
    }

    public function getFormattedEmissionDateAttribute()
    {
        return Carbon::parse($this->emission_date)->format('d-m-y');
    }
    public function getFormattedTransferDateAttribute()
    {
        return Carbon::parse($this->transfer_date)->format('d-m-y');
    }

}
