<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $primaryKey = 'url';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable=[
        'url',
        'nomeCanal',
    ];

}
