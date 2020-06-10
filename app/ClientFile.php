<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientFile extends Model
{
 protected $fillable= ['client_id','name','title'];

 public function client()
 {
     return $this->belongsTo('App\Client');
 }
}
