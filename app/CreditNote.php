<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class CreditNote extends Model
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
        'date',
        'reason'];

    public function items()
    {
        return $this->hasMany('App\CreditNoteItem');
    }

    public function getFormattedEmissionDateAttribute()
    {
        if ($this->emission_date != null) {
            # code...
            return Carbon::parse($this->emission_date)->format('d-m-y');
        }
    }
    public function getFormattedExpirationDateAttribute()
    {
        if ($this->emission_date != null) {
            return Carbon::parse($this->expiration_date)->format('d-m-y');
        }
    }
    public function getFormattedDateAttribute()
    {
        if ($this->emission_date != null) {
            return Carbon::parse($this->date)->format('d-m-y');
        }
    }

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }

}
