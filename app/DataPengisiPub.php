<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataPengisiPub extends Model
{
    //
    protected $connection = 'mysql4';
    protected $table = 'data_isian_cust';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
