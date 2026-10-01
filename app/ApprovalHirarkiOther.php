<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApprovalHirarkiOther extends Model
{
    //
    protected $connection = 'mysql3';
    protected $table = 'approval_hirarki_other';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public $incrementing = false;
}
