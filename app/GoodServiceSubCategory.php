<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodServiceSubCategory extends Model
{
    protected $fillable = ['category_id', 'name', 'good', 'status'];

    public function category()
    {
        return $this->belongsTo('App\GoodServiceCategory', 'category_id', 'id');
    }
}
