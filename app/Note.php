<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    //
    protected $connection = 'mysql3';
    protected $table = 'notification';
    public $timestamps = false;
    protected $primaryKey = 'LOGID';
    //public $incrementing = false;
}
