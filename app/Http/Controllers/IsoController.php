<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Task;

class IsoController extends Controller
{
    //
	public function index()
    {
    	$user = Auth::user();
    	return view('welcome',compact('user'));
    }
}
