<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SenderGuideItem extends Model
{
    protected $fillable = ['sender_guide_id',
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

    public function senderGuide()
    {
        return $this->belongsTo('App\SenderGuide');
    }

    public function details()
    {
        return $this->hasMany('App\GoodDetail', 'good_id');
    }

}
