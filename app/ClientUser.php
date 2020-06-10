<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ClientUser extends Pivot
{
    protected $fillable = ['user_id', 'client_id'];

    public function clients()
    {
        return $this->hasMany('App\Client');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

}
