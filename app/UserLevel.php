<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UserLevel extends Model
{
    //
		protected $connection = 'mysql3';
		protected $table = 'user_levels';
		protected $primaryKey = 'userid';
		public $timestamps = false;

		public function user()
		{
		    return $this->belongsTo('App\User');
		}
}
