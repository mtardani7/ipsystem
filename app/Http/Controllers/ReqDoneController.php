<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Req;

class ReqDoneController extends Controller
{
    //
    public function index()
    {
      $title = "Done Request All";
      $reqs = Req::where('status','approved')->orWhere('status','uploaded')->orderBy('status','ASC')->paginate(20);
      return view('request/req_done',compact('reqs','title'));
    }

    public function form_p4no7()
    {
      $title = "Done Request Form P4 No.7";
      $reqs = Req::where('type','form_p4-no7')->where('status','approved')->orWhere('status','uploaded')->orderBy('status','ASC')->paginate(20);
      return view('request/req_done',compact('reqs','title'));
    }

    public function uploaded($id)
    {
      $req = Req::find($id);
      $req->status = 'uploaded';
      $req->save();
      return redirect()->route('done_req');
    }
}
