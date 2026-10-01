<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    //
    protected $fillable = ['url', 'description'];
    protected $table = 'links';
    public $timestamps = false;
}
