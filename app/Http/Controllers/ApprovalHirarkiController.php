<?php

namespace App\Http\Controllers;

use App\ApprovalHirarki;
use App\Plant;
use App\Division;
use App\User;
use App\ApprovalHirarkiOther;
use Illuminate\Http\Request;
use Session;

class ApprovalHirarkiController extends Controller
{
    //
    public function index()
    {
      $datas = ApprovalHirarki::orderBy('dept')->paginate(15);
      $plants = Plant::all();
      $divs = Division::all();
      $users = User::all();
      return view('administration.approval_hirarki', compact('datas','plants','divs','users'));
    }

    public function add(Request $request)
    {
      $hirarki = new ApprovalHirarki();
      $hirarki->dept          = $request->dept;
      $hirarki->plant         = $request->plant;
      $hirarki->approval1     = $request->approval1;
      $hirarki->approval2     = $request->approval2;
      $hirarki->approval_final = $request->approval_final;
      $hirarki->save();

      return redirect('/approval_hirarki');
    }

    public function edit($id)
    {
      $data = ApprovalHirarki::find($id);
      $datas = ApprovalHirarki::paginate(15);
      $plants = Plant::all();
      $divs = Division::all();
      $users = User::all();
      return view('administration.edit_approval_hirarki',compact('data','datas','plants','divs','users'));
    }

    public function update($id, Request $request)
    {
      $hirarki = ApprovalHirarki::find($id);
      $hirarki->dept          = $request->dept;
      $hirarki->plant         = $request->plant;
      $hirarki->approval1     = $request->approval1;
      $hirarki->approval2     = $request->approval2;
      $hirarki->approval_final = $request->approval_final;
      $hirarki->save();

      return redirect('/approval_hirarki');
    }

    public function destroy($id)
    {
      $hirarki = ApprovalHirarki::find($id);
      $hirarki->delete();
      Session::put('success', 'Your Record <b>'.$hirarki->id. '</b> Deleted Successfully.');
      return redirect('/approval_hirarki');
    }

    public function mrindex()
    {
      $datas = ApprovalHirarkiOther::paginate(10);
      return view('administration.approval_mr',compact('datas'));
    }

    public function mredit($id)
    {
      $data = ApprovalHirarkiOther::find($id);
      $users = User::all();
      return view('administration.edit_approval_mr',compact('users','data'));
    }

    public function mrupdate($id, Request $request)
    {
      $hirarki = ApprovalHirarkiOther::find($id);
      $hirarki->name = $request->approver_name;
      $hirarki->save();

      return redirect('/approval_mr');
    }
}
