<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataVendor extends Model
{
    //
    protected $connection = 'mysql4';
    protected $table = 'data_vendor';
    protected $primaryKey = 'id';
}
