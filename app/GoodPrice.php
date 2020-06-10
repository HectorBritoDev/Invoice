<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodPrice extends Model
{
    protected $fillable = ['good_id',
        'wholesale_price',
        'unit_price',
        'tax'];

    public function good()
    {
        return $this->belongsTo('App\Good');
    }
}
