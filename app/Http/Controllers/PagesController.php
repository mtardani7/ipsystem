<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class PagesController extends Controller
{
    //
	 public function index()
    {
    	$user = Auth::user();
    	return view('welcome',compact('user'));
    }
	
	public function notes()
    {
    	$user = Auth::user();
    	return view('notes',compact('user'));
    }
	
	public function input_div()
    {
    	$user = Auth::user();
    	return view('input_div',compact('user'));
    }
	
	public function user()
    {
    	$user = Auth::user();
    	return view('user',compact('user'));
    }
	
	public function form()
    {
    	$user = Auth::user();
    	return view('form',compact('user'));
    }
	
	public function report()
    {
    	$user = Auth::user();
    	return view('report',compact('user'));
    }
	
	public function changelog()
    {
    	$user = Auth::user();
    	return view('changelog',compact('user'));
    }
	
}
