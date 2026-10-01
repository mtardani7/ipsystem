<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Req;
use App\P4no7;
use App\P4no8;
use App\P4no9;
use App\ChangeFolder;
use App\FormIT01;
use App\ApprovalHirarki;
use App\User;
use DB;
use File;

class ReqIncomingController extends Controller
{
    //
    public function index()
    {

      $reqs = Req::where('verified','no')->orderBy('date_request')->paginate(20);
      return view('request/req_incoming',compact('reqs'));
    }

    public function verification_form7(Request $request)
    {
      $id = $request->input('request_id');

      $req = Req::find($id);
      $req->verified = 'yes';
      $req->verified_date = DB::raw('NOW()');
      $req->status = 'waiting';

      if ($req->approval1 != null)
      $approval_name = $req->approval1;
      elseif ($req->approval2 != null)
      $approval_name = $req->approval2;
      elseif ($req->approval_final != null)
      $approval_name = $req->approval_final;
      elseif ($req->approval_mr != null)
      $approval_name = $req->approval_mr;
      $req->save();

      $newreq_nod = "^".$request->input('new_nod1')."^" . $request->input('new_nod2')."^" . $request->input('new_nod3');
      $newreq_nr = "^".$request->input('new_nr1')."^" . $request->input('new_nr2')."^" . $request->input('new_nr3');
      $newreq_dn = "^".$request->input('new_dn1')."^" . $request->input('new_dn2')."^" . $request->input('new_dn3');
      $newreq_sp = "^".$request->input('new_sp1')."^" . $request->input('new_sp2')."^" . $request->input('new_sp3');
      $newreq_sm = "^".$request->input('new_sm1')."^" . $request->input('new_sm2')."^" . $request->input('new_sm3');
      $newreq_em = "^".$request->input('new_em1')."^" . $request->input('new_em2')."^" . $request->input('new_em3');

      $chreq_nod = "^".$request->input('ch_nod1')."^" . $request->input('ch_nod2')."^" . $request->input('ch_nod3');
      $chreq_nr = "^".$request->input('ch_nr1')."^" . $request->input('ch_nr2')."^" . $request->input('ch_nr3');
      $chreq_nd = "^".$request->input('ch_nd1')."^" . $request->input('ch_nd2')."^" . $request->input('ch_nd3');
      $chreq_sp = "^".$request->input('ch_sp1')."^" . $request->input('ch_sp2')."^" . $request->input('ch_sp3');
      $chreq_sm = "^".$request->input('ch_sm1')."^" . $request->input('ch_sm2')."^" . $request->input('ch_sm3');
      $chreq_em = "^".$request->input('ch_em1')."^" . $request->input('ch_em2')."^" . $request->input('ch_em3');

      $cancel_nod = "^".$request->input('c_nod1')."^" . $request->input('c_nod2')."^" . $request->input('c_nod3');
      $cancel_nr = "^".$request->input('c_nr1')."^" . $request->input('c_nr2')."^" . $request->input('c_nr3');
      $cancel_nd = "^".$request->input('c_nd1')."^" . $request->input('c_nd2')."^" . $request->input('c_nd3');


      $form = P4no7::find($id);
      /*
      $form->newreq_nodoc  = $newreq_nod;
      $form->newreq_norev = $newreq_nr;
      $form->newreq_docname = $newreq_dn;
      $form->newreq_saveperiode = $newreq_sp;
      $form->newreq_sort = $newreq_sm;
      $form->newreq_eliminate = $newreq_em;
      $form->chreq_nodoc = $chreq_nod;
      $form->chreq_norev = $chreq_nr;
      $form->chreq_docname = $chreq_nd;
      $form->chreq_saveperiode = $chreq_sp;
      $form->chreq_sort = $chreq_sm;
      $form->chreq_eliminate = $chreq_em;
      $form->cancel_nodoc = $cancel_nod;
      $form->cancel_norev = $cancel_nr;
      $form->cancel_docname = $cancel_nd;
      */
      $file_doc = $request->file('file_doc');
      if ($file_doc!='')
      {
        //jika file yg di ubah oleh QMS namanya sama
        $file_doc_read = $file_doc->getClientOriginalName();
        if($file_doc_read ==  $form->file_dokumen)
        {
          //delete file
          unlink(public_path('uploads/file/p4no7/'.$form->file_dokumen));
          $name_doc = 'verified_'.$file_doc_read;
        }
        else
        {
          if($form->file_dokumen!='')
          {unlink(public_path('uploads/file/p4no7/'.$form->file_dokumen));}
          $name_doc = $id."_doc_".$file_doc->getClientOriginalName();
        }
      //$name_doc = $file_doc->getClientOriginalName();
      $file_doc->move('public/uploads/file/p4no7',$name_doc);
      }
      else $name_doc = $request->input('file_doc_ori');

      $form->file_dokumen = $name_doc;
      $form->save();

      return redirect()->action(
      'MailController@send_request_verified', ['name' => $approval_name]
    );


    }

    public function verification_frmit01(Request $request)
    {
      $id = $request->input('request_id');
      $req = Req::find($id);
      $req->verified = 'yes';
      $req->status = 'waiting';
      $req->verified_date = DB::raw('NOW()');
      if ($req->approval1 != null)
      $approval_name = $req->approval1;
      elseif ($req->approval2 != null)
      $approval_name = $req->approval2;
      elseif ($req->approval_final != null)
      $approval_name = $req->approval_final;
      $req->save();

      $checkbox_req = array ($request->input('baru'),$request->input('perbaikan'),$request->input('penggantian'),$request->input('instalasi'));
      $strcheckbox_req = ",";
      foreach ($checkbox_req as $value) {
        if ($value!="")
        $strcheckbox_req = $strcheckbox_req ."". $value.",";
        }

      $checkbox_item = array ($request->input('hardware'),$request->input('software'),$request->input('application'));
      $strcheckbox_item = ",";
      foreach ($checkbox_item as $value) {
        if ($value!="")
        $strcheckbox_item = $strcheckbox_item ."". $value.",";
        }

      $checkbox_function = array ($request->input('drawing'),$request->input('officeadm'));
      $strcheckbox_function = ",";
      foreach ($checkbox_function as $value) {
        if ($value!="")
        $strcheckbox_function = $strcheckbox_function ."". $value.",";
        }

      $form = FormIT01::find($id);
      $form->request_type = $strcheckbox_req;
      $form->item_type = $strcheckbox_item;
      $form->item_name = $request->input('nama_hwsw');
      $form->item_ne = $request->input('ne');
      $form->function = $strcheckbox_function;
      $form->reason = $request->input('desc');
      $form->Availability_check = $request->input('avail-yes')."".$request->input('avail-no');
      $form->office_pc  = $request->input('office');
      $form->mobile_laptop = $request->input('mobile');
      $form->director_laptop = $request->input('director');
      $form->no_asset = $request->input('noasset');
      $form->no_pr = $request->input('nopr');
      $form->date = $request->input('date');
      $file_lampiran = $request->file('file_lampiran');
      if ($file_lampiran!='')
      {
        $name_lampiran = $id."_lampiran_".$file_lampiran->getClientOriginalName();
        $file_lampiran->move('public/uploads/file/req_form-it-01',$name_lampiran);
      }
      else $name_lampiran ='';

      //$form->file_lampiran = $name_lampiran;
      $form->save();

      /*
      $req = Req::find($id);
      $req->status = 'waiting';
      $approval_name = $req->reject_by;
      $req->save();
      */
      return redirect()->route('incoming_req')->with('data','Form request perubahan folder behasil diverifikasi');
     // return redirect()->action('MailController@send_request_verified', ['name' => $approval_name] );

    }

    // public function reject(Request $request)
    //   {
    //   $req_id = $request->input('request_id');
  	// 	$reqs = Req::find($req_id);
    //   return view('request/fill-reject', compact('reqs','req_id'));
    //   }

    // public function fill_reject(Request $request)
    //   {
    //     $req_id = $request->input('request_id');
    // 		$reqs = Req::find($req_id);
    //     $requestor_name =  $reqs->reqby;
    //     $reqs->status = 'reject';
    //     $reqs->reject_by = $request->input('by');
    //     $reqs->reject_date = DB::raw('NOW()');
    //     $reqs->reject_rmk = $request->input('rmk');
    //     $reqs->save();
    //     return redirect()->action(
    //     'MailController@send_reject', ['name' => $req_id]
    //     );
    //   }
}
