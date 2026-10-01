<?php

namespace App\Http\Middleware;

use Closure;
use App\UserLevel;
use Auth;

class Marketing
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if (Auth::check())
      {
      $id = Auth::user()->id;
      $userlevel = UserLevel::where('userid','=', $id)
          ->first();
      //$level ='aa';
      if($userlevel->dept == 'SALES' || $userlevel->role == 'superuser'){
        return $next($request);
        }
       else
       {return redirect('home')->with('error','You do not have access');}
      }
      else{return redirect('home');}
    }
}
