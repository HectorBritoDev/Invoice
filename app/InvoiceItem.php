<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = ['invoice_id',
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
        'discount',
        'igv_type'];

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }

    public function details()
    {
        return $this->hasMany('App\GoodDetail', 'good_id');
    }
}
