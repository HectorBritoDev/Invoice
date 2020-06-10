<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientContact extends Model
{
    protected $fillable = ['client_id',
        'client_contact_name',
        'client_contact_lastname',
        'client_contact_cellphone',
        'client_contact_phone',
        'client_contact_anexo',
        'client_contact_email',
        'client_contact_birthday',
        'client_contact_charge',
        'client_contact_responsableFor'];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }
}
