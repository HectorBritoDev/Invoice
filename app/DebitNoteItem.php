<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DebitNoteItem extends Model
{
    protected $fillable = ['debit_note_id',
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

    public function debitNote()
    {
        return $this->belongsTo('App\DebitNote');
    }

    public function details()
    {
        return $this->hasMany('App\GoodDetail', 'good_id');
    }

}
