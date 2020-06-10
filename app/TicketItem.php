<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketItem extends Model
{
    protected $fillable = ['ticket_id',
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

    public function ticket()
    {
        return $this->belongsTo('App\Ticket');
    }

    public function details()
    {
        return $this->hasMany('App\GoodDetail', 'good_id');
    }

}
