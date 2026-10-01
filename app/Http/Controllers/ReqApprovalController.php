<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Req;
use App\FormIT01;
use Auth;
use DB;

class ReqApprovalController extends Controller
{
    //
    public function index()
    {
      $user = Auth::user()->name;
      $matchThese = ['approval1' => $user, 'approval2' => $user, 'approval_final' => $user, 'approval_mr' => $user];
      $matchAnd = ['form_saved' => 'yes', 'verified' => 'yes'];
      $reqs =  Req::orwhere($matchThese)->where($matchAnd)->orderBy('date_request','desc')->get();
      return view('request/req_approval',compact('reqs','user'));
    }

    public function approve(Request $request)
    {
      $user = Auth::user()->name;
      $req_id = $request->input('request_id');
    //  $reqs =  Req::where;
      $reqs = Req::find($req_id);

      //jika approval form IT menambahkan no.PR

      if ($reqs->type == 'form_it-01') {
      $form = FormIT01::find($req_id);
      $form->no_asset = $request->input('noasset');
      $form->no_pr = $request->input('nopr');
      //dd($request->input('nopr'));
      $form->save();
      }

      if($reqs->approval1 == $user && $reqs->approval1_date == null)
      {
        if($reqs->approval1_date == null)
        {
          $reqs->status = 'waiting';
          $approval_name = $reqs->approval2;
        }
        $reqs->approval1_date = DB::raw('NOW()');
      }
      elseif($reqs->approval2 == $user && $reqs->approval2_date == null)
      {
        if($reqs->approval2_date == null)
        {
          $reqs->status = 'waiting';
          $approval_name = $reqs->approval_final;
        }
        $reqs->approval2_date = DB::raw('NOW()');
      }
      elseif($reqs->approval_final == $user && $reqs->approval_final_date == null)
      {
        if($reqs->approval_final_date == null && $reqs->approval_mr != null)
        {$reqs->status = 'waiting';
          $approval_name = $reqs->approval_mr;
        }
        else {
          $reqs->status = 'approved';
          $approval_name = 'no';
        }
        $reqs->approval_final_date = DB::raw('NOW()');
      }
      elseif($reqs->approval_mr == $user && $reqs->approval_mr_date == null)
      {
        if($reqs->approval_mr_date == null && $reqs->approval_final_date != null)
        $reqs->status = 'approved';
        $reqs->approval_mr_date = DB::raw('NOW()');
        $approval_name = 'mr';
      }
      $reqs->save();
      if ($approval_name != 'no')
      {
        if ($approval_name == 'mr')
        {
          return redirect()->action('MailController@send_approval_done');
        }
        else {
          return redirect()->action(
          'MailController@send', ['name' => $approval_name]
          );
        }

     }
     else {
      return redirect('/approval_req');
     }

    }

    public function reject(Request $request)
      {
      $req_id = $request->input('request_id');
  		$reqs = Req::find($req_id);
      return view('request/fill-reject', compact('reqs','req_id'));

      }

    public function fill_reject(Request $request)
        {
        $req_id = $request->input('request_id');
    		$reqs = Req::find($req_id);
        $requestor_name =  $reqs->reqby;
        $reqs->status = 'reject';
        $reqs->reject_by = $request->input('by');
        $reqs->reject_date = DB::raw('NOW()');
        $reqs->reject_rmk = $request->input('rmk');
        $reqs->save();
        return redirect()->action(
        'MailController@send_reject', ['name' => $req_id]
        );

        }
}
