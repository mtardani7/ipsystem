<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class division extends Model
{
    //
    protected $connection = 'mysql3';
    protected $table = 'division';
    public $timestamps = false;
    protected $primaryKey = 'DIVNO';
    public $incrementing = false;
}
