<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Req;
use Auth;
use App\P4no7;
use App\P4no8;
use App\P4no9;
use App\ChangeFolder;
use App\FormIT01;
use DB;
use Session;

class ReqHistoryController extends Controller
{
    //
    public function index()
    {
      $user = Auth::user()->username;
      if (Auth::user()->custom=='superuser')
      {
        $reqs = Req::where('form_saved','yes')->orderBy('date_request','DESC')->paginate(20);
      }
      else {
        $reqs = Req::where('reqby',$user)->where('form_saved','yes')->orderBy('date_request','DESC')->paginate(20);
      }
      return view('request/req_history',compact('reqs'));
    }

    public function search(Request $request)
      {
        $keyword = $request->input('keyword');
        if ($request->input('type') == 'form_p4-no7')
        {
          $frm_result = 'req_search_result_p4no7';
          //$datas = \App\P4no7::where('newreq_nodoc','like','%'.$keyword.'%')->where('chreq_nodoc','like','%'.$keyword.'%')->get();
          if($request->input('field') == 'docid')
          $datas = DB::table('tbl_request')->join('tbl_p4no7','tbl_request.id','=','tbl_p4no7.request_id')
                    ->where('tbl_p4no7.newreq_nodoc','like','%'.$keyword.'%')
                    ->orwhere('tbl_p4no7.chreq_nodoc','like','%'.$keyword.'%')
                    ->where('form_saved','yes')
                    ->get();
          elseif($request->input('field') == 'desc')
          $datas = DB::table('tbl_request')->join('tbl_p4no7','tbl_request.id','=','tbl_p4no7.request_id')
                    ->where('tbl_p4no7.newreq_docname','like','%'.$keyword.'%')
                    ->orwhere('tbl_p4no7.chreq_docname','like','%'.$keyword.'%')
                    ->where('form_saved','yes')
                    ->get();
        }
        elseif ($request->input('type') == 'form_p4-no8')
        {
          $frm_result = 'req_search_result_p4no8';
          if($request->input('field') == 'docid')
          $datas = DB::table('tbl_request')->join('tbl_p4no8','tbl_request.id','=','tbl_p4no8.request_id')
                    ->where('tbl_p4no8.hc_nodoc','like','%'.$keyword.'%')
                    ->orwhere('tbl_p4no8.sc_nodoc','like','%'.$keyword.'%')
                    ->orwhere('tbl_p4no8.el_nodoc','like','%'.$keyword.'%')
                    ->where('form_saved','yes')
                    ->get();
          elseif($request->input('field') == 'desc')
          $datas = DB::table('tbl_request')->join('tbl_p4no8','tbl_request.id','=','tbl_p4no8.request_id')
                    ->where('tbl_p4no8.hc_docname','like','%'.$keyword.'%')
                    ->orwhere('tbl_p4no8.sc_docname','like','%'.$keyword.'%')
                    ->orwhere('tbl_p4no8.el_docname','like','%'.$keyword.'%')
                    ->where('form_saved','yes')
                    ->get();
        }

        return view('request/'.$frm_result, compact('datas'));
      }

    public function view($id)
    {
      $actions = 'view';
      $user = Auth::user()->name;
      $req = Req::find($id);
      if ($req->type == 'form_p4-no7')
        {
          $form = 'req_history_detail-no7';
          $data = P4no7::find($id);
        //  $dbp4 =  new P4no7();
        }
      elseif ($req->type == 'form_p4-no8')
      {
        $form = 'req_history_detail-no8';
        $data = P4no8::find($id);
      //  $dbp4 =  new P4no8();
      }
      elseif ($req->type == 'form_p4-no9')
      {
        $form = 'req_history_detail-no9';
        $data = P4no9::find($id);
      //  $dbp4 =  new P4no8();
      }
      elseif ($req->type == 'form_change-folder')
      {
        $form = 'req_history_detail-folder';
        $data = ChangeFolder::find($id);
      //  $dbp4 =  new P4no8();
      }
      elseif ($req->type == 'form_it-01')
      {
        $form = 'req_history_detail-it01';
        $data = FormIT01::find($id);
      //  $dbp4 =  new P4no8();
      }

      return view('request/'.$form,compact('req','data','user','actions'));
    }

    public function prints($id)
    {
      $actions = 'view';
      $user = Auth::user()->name;
      $req = Req::find($id);
      if ($req->type == 'form_p4-no7')
        {
          $form = 'print-form-no7';
          $data = P4no7::find($id);
        //  $dbp4 =  new P4no7();
        }
      elseif ($req->type == 'form_p4-no8')
      {
        $form = 'req_history_detail-no8';
        $data = P4no8::find($id);
      //  $dbp4 =  new P4no8();
      }
      elseif ($req->type == 'form_p4-no9')
      {
        $form = 'req_history_detail-no9';
        $data = P4no9::find($id);
      //  $dbp4 =  new P4no8();
      }
      elseif ($req->type == 'form_change-folder')
      {
        $form = 'req_history_detail-folder';
        $data = ChangeFolder::find($id);
      //  $dbp4 =  new P4no8();
      }
      elseif ($req->type == 'form_it-01')
      {
        $form = 'req_history_detail-it01';
        $data = FormIT01::find($id);
      //  $dbp4 =  new P4no8();
      }

      return view('request/'.$form,compact('req','data','user','actions'));
    }

    public function edit($id)
    {
      $actions = 'edit';
      $user = Auth::user()->name;
      $req = Req::find($id);
      if ($req->type == 'form_p4-no7')
        {
          $form = 'req_history_detail-no7';
          $data = P4no7::find($id);
        //  $dbp4 =  new P4no7();
        }
      elseif ($req->type == 'form_p4-no8')
      {
        $form = 'req_history_detail-no8';
        $data = P4no8::find($id);
      //  $dbp4 =  new P4no8();
      }
      elseif ($req->type == 'form_p4-no9')
      {
        $form = 'req_history_detail-no9';
        $data = P4no9::find($id);
      //  $dbp4 =  new P4no8();
      }
      elseif ($req->type == 'form_change-folder')
      {
        $form = 'req_history_detail-folder';
        $data = ChangeFolder::find($id);
      //  $dbp4 =  new P4no8();
      }
      elseif ($req->type == 'form_it-01')
      {
        $form = 'req_history_detail-it01';
        $data = FormIT01::find($id);
      //  $dbp4 =  new P4no8();
      }

      return view('request/'.$form,compact('req','data','user','actions'));
    }

    public function destroy($id)
    {
      $req = Req::find($id);
      $req->delete();
      
      if ($req->type == 'form_p4-no7'){
      $data = P4no7::find($id);
      $data->delete();
      }
      elseif ($req->type == 'form_p4-no8'){
      $data = P4no8::find($id);
      $data->delete();
      }
      elseif ($req->type == 'form_it-01'){
      $data = FormIT01::find($id);
      $data->delete();
      }
      elseif ($req->type == 'form_change-folder'){
      $data = ChangeFolder::find($id);
      $data->delete();
      }
      Session::put('success', 'Your Record <b>'.$req->id. '</b> Deleted Successfully.');
      return redirect('/history_req');
    }
    public function verification($id)
    {
      $actions = 'verification';
      $user = Auth::user()->name;
      $req = Req::find($id);
      if ($req->type == 'form_p4-no7')
        {
          $form = 'req_history_detail-no7';
          $data = P4no7::find($id);
        //  $dbp4 =  new P4no7();
        }
      elseif ($req->type == 'form_p4-no8')
      {
        $form = 'req_history_detail-no8';
        $data = P4no8::find($id);
      //  $dbp4 =  new P4no8();
      }
      elseif ($req->type == 'form_p4-no9')
      {
        $form = 'req_history_detail-no9';
        $data = P4no9::find($id);
      //  $dbp4 =  new P4no8();
      }
      elseif ($req->type == 'form_change-folder')
      {
        $form = 'req_history_detail-folder';
        $data = ChangeFolder::find($id);
      //  $dbp4 =  new P4no8();
      }
      elseif ($req->type == 'form_it-01')
      {
        $form = 'req_history_detail-it01';
        $data = FormIT01::find($id);
      //  $dbp4 =  new P4no8();
      }

      return view('request/'.$form,compact('req','data','user','actions'));
    }


}
