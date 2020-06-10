<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodDetail extends Model
{
    protected $fillable = ['good_id',
        'name',
        // 'measure',
        // 'brand',
        // 'model',
        // 'serie',
        // 'badge',
        // 'color',
        // 'size'
    ];

    public function good()
    {
        return $this->belongsTo('App\Good');
    }

    public function options()
    {
        return $this->hasMany('App\GoodDetailOption');
    }
}
