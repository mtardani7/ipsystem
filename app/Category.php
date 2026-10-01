<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $connection = 'mysql3';
    protected $table = 'category';
    public $timestamps = false;
    protected $primaryKey = 'CATID';
    public $incrementing = false;
}
