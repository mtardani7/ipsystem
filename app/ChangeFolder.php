<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChangeFolder extends Model
{
    //
    protected $connection = 'mysql3';
    protected $table = 'tbl_req_change-folder';
    public $timestamps = false;
    protected $primaryKey = 'request_id';
    public $incrementing = false;
}
