<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Link;

class PlantAjaxController extends Controller
{
    //
    public function index()
    {
      $links = Link::all();
      return view('ajax/input_plant',compact('links'));
    }

    public function add()
    {
      $link = Link::create($request->all());
      return Response::json($link);
    }
}
