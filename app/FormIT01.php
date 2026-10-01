<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormIT01 extends Model
{
    //
    protected $connection = 'mysql3';
    protected $table = 'tbl_frm-it-01';
    public $timestamps = false;
    protected $primaryKey = 'request_id';
    public $incrementing = false;
}
