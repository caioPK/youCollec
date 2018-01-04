<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable=[
        'collecName',
        'usuario',
        'canais'
    ];
    protected $table = 'collections';
}
