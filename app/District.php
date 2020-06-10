<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public function province()
    {
        return $this->belongsTo('App\Province');
    }

        //ACCESSORS
    public function getDistrictNameAttribute()
    {
        return $this->name;
    }

}
