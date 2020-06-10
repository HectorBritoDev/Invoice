<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditNoteItem extends Model
{
    protected $fillable = ['credit_note_id',
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

    public function creditNote()
    {
        return $this->belongsTo('App\CreditNote');
    }

    public function details()
    {
        return $this->hasMany('App\GoodDetail', 'good_id');
    }

}
