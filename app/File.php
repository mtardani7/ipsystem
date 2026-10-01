<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    //
    protected $connection = 'mysql3';
    protected $table = 'file';
    public $timestamps = false;
}
