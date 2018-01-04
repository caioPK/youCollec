<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $primaryKey = 'idCat';
    protected $fillable=[
        'idUser',
        'nomeCat',
        'canaisId'
    ];

}
