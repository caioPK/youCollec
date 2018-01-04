<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed_Video extends Model
{

    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable=[
        'idVideo',
        'idUser',
        'idCat',
        'assistido',
        'idCanal',
    ];


}
