<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    //
    protected $connection = 'mysql3';
    protected $table = 'distribution';
    public $timestamps = false;
    protected $primaryKey = 'DIVDIST';
    public $incrementing = false;
}
