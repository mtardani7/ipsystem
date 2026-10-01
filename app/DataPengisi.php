<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataPengisi extends Model
{
    //
    protected $connection = 'mysql5';
    protected $table = 'data_pengisi';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
