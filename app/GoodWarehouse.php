<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodWarehouse extends Model
{
    protected $fillable = ['good_id',
        'name',
        'adress'];

    public function good()
    {
        return $this->belongsTo('App\Good');
    }
}
