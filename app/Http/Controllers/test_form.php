<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class test_form extends Controller
{
    //
    public function form_it01()
    {
      $reqby = 'tester';
      $reqplant = 'HO';
      $reqdept = 'IT';
      $reqtype = 'Form_it-01';
      $request_id = '99';
      return view('test/form_it-01',compact('reqby','reqplant','reqdept','reqtype','request_id'));
    }
}
