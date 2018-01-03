<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class collection extends Model
{
    protected $fillable=[
        'collecName',
        'usuario',
        'canais'
    ];

}
