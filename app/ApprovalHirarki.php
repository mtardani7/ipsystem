<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApprovalHirarki extends Model
{
    //
    protected $connection = 'mysql3';
    protected $table = 'approval_hirarki';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public $incrementing = false;
}
