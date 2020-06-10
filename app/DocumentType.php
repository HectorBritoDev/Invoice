<?php

namespace App;

use App\DocumentType;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $fillable = ['code', 'name'];
}
