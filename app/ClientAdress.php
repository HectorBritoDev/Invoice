<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientAdress extends Model
{
    protected $fillable = ['client_id', 'client_adress', 'client_department_id', 'client_province_id', 'client_district_id'];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function department()
    {
        return $this->belongsTo('App\Department','client_department_id','id');
    }
    public function province()
    {
        return $this->belongsTo('App\Province','client_province_id','id');
    }
    public function district()
    {
        return $this->belongsTo('App\District','client_district_id','id');
    }

}
