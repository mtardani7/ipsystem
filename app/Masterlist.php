<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Masterlist extends Model
{
    //
    protected $connection = 'mysql3';
    protected $table = 'masterlist';
    public $timestamps = false;
  //  protected $primaryKey = 'DOCID,DOCREV';
  //  protected $primaryKey = ['DOCID', 'DOCREV'];
    public $incrementing = false;

    public function owner()
    {
        return $this->belongsTo(User::class, 'OWNER_ID', 'id');
    }
}
