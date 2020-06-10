<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BudgetItem extends Model
{
    protected $fillable = ['budget_id',
        'good_id',
        'name',
        'measure',
        'reference',
        'quantity',
        'price',
        'discount',
        'sub_total',
        'tax',
        'total',
        'igv_type'];

    public function budget()
    {
        return $this->belongsTo('App\Budget');
    }

    public function details()
    {
        return $this->hasMany('App\GoodDetail', 'good_id');
    }
}
