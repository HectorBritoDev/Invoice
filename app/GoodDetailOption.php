<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GoodDetailOption extends Model
{
    protected $fillable = ['good_detail_id', 'name'];

    public function detail()
    {
        return $this->belongsTo('App\GoodDetail', 'good_detail_id');
    }
}
