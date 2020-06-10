<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodName extends Model
{
    protected $fillable = ['good_id',
        'other_name',
        'other_code',
        'other_reference'];

    public function good()
    {
        return $this->belongsTo('App\Good');
    }
}
