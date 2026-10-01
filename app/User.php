<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use App\UserLevel;

class User extends Authenticatable
{
    use Notifiable;
    protected $connection = 'mysql3';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'username','name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	//Accessor untuk menambah user role
	public function getCustomAttribute()
	{
		$id = Auth::user()->id;
		$userlevel = UserLevel::where('userid','=', $id)
				->first();
		return $userlevel->role;
	}

  //contoh accessor utk tambahan variable auth
  public function getPlantAttribute()
	{
    $id = Auth::user()->id;
		$userlevel = UserLevel::where('userid','=', $id)
				->first();
		return $userlevel->plant;
	}

  public function getDeptAttribute()
  {
    $id = Auth::user()->id;
    $userlevel = UserLevel::where('userid','=', $id)
        ->first();
    return $userlevel->dept;
  }

  public function getLevelAttribute()
  {
    $id = Auth::user()->id;
    $userlevel = UserLevel::where('userid','=', $id)
        ->first();
    return $userlevel->level;
  }

  public function userlevel()
	{
		return $this->hasOne('App\UserLevel','userid');
	}
}
