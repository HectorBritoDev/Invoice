<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'user_id',
        'client_name',
        'client_lastname',
        'client_email',
        'client_main_adress',
        'photo',
        'ruc',
        'dni',
        'passport',
        'sunat_situation',
        'client_cellphone',
        'client_note',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function adresses()
    {
        return $this->hasMany('App\ClientAdress');
    }

    public function contacts()
    {
        return $this->hasMany('App\ClientContact');
    }
    public function debts()
    {
        return $this->hasMany('App\ClientDebt');
    }
    public function agreements()
    {
        return $this->hasMany('App\ClientAgreement');
    }

    public function clientDebt()
    {
        return $this->debts()->sum('debt');
    }

    // public function users()
    // {
    //     return $this->belongsToMany('App\User', 'client_user')->withTimestamps();
    // }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function files()
    {
        return $this->hasMany('App\ClientFile');
    }

}
