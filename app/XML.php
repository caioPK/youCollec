<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class XML extends Model
{
    protected $primaryKey = 'idUser';
    protected $table = 'xmls';

    protected $fillable=[
        'idXml',
        'idUser',
        'filePath',
    ];

}
