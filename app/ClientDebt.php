<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientDebt extends Model
{
    protected $fillable = ['client_id', 'document_type',
        'document_number',
        'document_emission',
        'document_expiration',
        'debt',
        'file',
        'file_title'];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function total_debt()
    {
        return $this->sum('debt');

    }

}
