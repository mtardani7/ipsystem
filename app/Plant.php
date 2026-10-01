<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    //
    protected $connection = 'mysql3';
    protected $table = 'plant';
    public $timestamps = false;
    protected $primaryKey = 'PLANTID';
    public $incrementing = false;
}
