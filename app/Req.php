<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Req extends Model
{
    //
    protected $connection = 'mysql3';
    protected $table = 'tbl_request';
    public $timestamps = false;
}
