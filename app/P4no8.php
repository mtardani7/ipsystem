<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class P4no8 extends Model
{
    //
    protected $connection = 'mysql3';
    protected $table = 'tbl_p4no8';
    public $timestamps = false;
    protected $primaryKey = 'request_id';
    public $incrementing = false;
}
