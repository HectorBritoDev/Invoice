<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodServiceCategory extends Model
{
    protected $fillable = ['user_id', 'name', 'good', 'service', 'status'];

    public function subCategories()
    {
        return $this->hasMany('App\GoodServiceSubCategory', 'category_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
