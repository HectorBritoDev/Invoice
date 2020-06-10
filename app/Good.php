<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    protected $fillable = ['user_id',
        'category_id',
        'name',
        'code',
        'reference',
        'measure',
        'type'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function category()
    {
        return $this->belongsTo('App\GoodServiceCategory', 'category_id');
    }
    public function names()
    {
        return $this->hasMany('App\GoodName');
    }

    public function details()
    {
        return $this->hasMany('App\GoodDetail');
    }

    public function prices()
    {
        return $this->hasMany('App\GoodPrice');
    }

    public function warehouses()
    {
        return $this->hasMany('App\GoodWarehouse');
    }

    public function getRealTypeAttribute()
    {
        if ($this->type === 'good') {
            return 'Bien';
        }
        if ($this->type === 'service') {
            return 'Servicio';
        }
    }

}
