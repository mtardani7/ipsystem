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
use App\ApprovalHirarkiOther;
use App\User;
use DB;
use File;

class RequestController extends Controller
{
    //
    public function create()
    {

      return view('request/create_req');
    }

    public function create_form(Request $request)
    {
      $reqby = $request->input('req_by');
      $reqplant = $request->input('req_plant');
      $reqdept = $request->input('req_dept');
      $reqtype = $request->input('req_type');
      if ($reqtype == 'p4-no7')
        {
          $form = 'form_p4-no7';
          $approval = ApprovalHirarki::where('dept','=',$reqdept)->where('plant','=',$reqplant)->first();
          $approval1 = $approval->approval1;
          $approval2 = $approval->approval2;
          $approvalf = $approval->approval_final;
          $mr = ApprovalHirarkiOther::where('approver','MR')->first();
          //dd($mr);
          $approvalmr = $mr['name'];
        //  $dbp4 =  new P4no7();
        }
      elseif ($reqtype == 'p4-no8')
      {
        $form = 'form_p4-no8';
        $approval = ApprovalHirarki::where('dept','=',$reqdept)->where('plant','=',$reqplant)->first();
        $approval1 = $approval->approval1;
        $approval2 = $approval->approval2;
        $approvalf = $approval->approval_final;
        $mr = ApprovalHirarkiOther::where('approver','MR')->first();
        //dd($mr);
        $approvalmr = $mr['name'];
      //  $dbp4 =  new P4no8();
      }
      elseif ($reqtype == 'p4-no9')
      {
        $form = 'form_p4-no9';
        $approval = ApprovalHirarki::where('dept','=',$reqdept)->where('plant','=',$reqplant)->first();
        $approval1 = $approval->approval1;
        $approval2 = $approval->approval2;
        $approvalf = $approval->approval_final;
        $mr = ApprovalHirarkiOther::where('approver','MR')->first();
        //dd($mr);
        $approvalmr = $mr['name'];
      //  $dbp4 =  new P4no8();
      }
      elseif ($reqtype == 'change-folder')
      {
        $form = 'form_change-folder';
        $approval1 = null;
        $approval2 = null;
        //approval untuk request change folder
        $approvalf = 'Doc Controller';
        $approvalmr = null;
      //  $dbp4 =  new P4no8();
      }
      elseif ($reqtype == 'frm-it-01')
      {
        //$approval = ApprovalHirarki::where('dept','=',$reqdept)->where('plant','=',$reqplant)->first();
        $form = 'form_it-01';
        $approval1 = null;
        $it = ApprovalHirarkiOther::where('approver','IT')->first();
        $approval2 = $it['name'];
        //approval untuk request change folder
        $it_final = ApprovalHirarkiOther::where('approver','IT_final')->first();
        $approvalf = $it_final['name'];
        $approvalmr = null;
      //  dd($approvalf);

      }
      $p4 =  new Req();
      $p4->date_request = DB::raw('NOW()');
      $p4->dept = $reqdept;
      $p4->plant = $reqplant;
      $p4->type = $form;
      $p4->reqby = $reqby;
      $p4->form_saved = 'no';
      $p4->status = 'waiting';
      $p4->approval1 = $approval1;
      $p4->approval2 = $approval2;
      $p4->approval_final = $approvalf;
      $p4->approval_mr = $approvalmr;
      $p4->session_id = session()->getId();
      $p4->save();

      $session_id = session()->getId();
      $request = Req::where('session_id','=',$session_id)->orderBy('id', 'desc')->first();
      $request_id = $request->id;
      return view('request/'.$form,compact('reqby','reqplant','reqdept','reqtype','request_id'));
    }

    //save data untuk form p4no7
    public function fill_form7(Request $request){
      //upload file
      //$form = new P4no7();
      $txt_ext = $request->input('ext_txt');
      $txt_other = $request->input('other_txt');
      if (!empty($txt_ext)) $ext = $request->input('ext') . "(" .$request->input('ext_txt'). ")";
			else $ext = "";
		  if (!empty($txt_other)) $other = $request->input('other') . "(" .$request->input('other_txt'). ")";
			else $other = "";

      $checkbox_doc = array ($request->input('psqm'),$request->input('oc'),$request->input('jd'),$request->input('sop'),$request->input('wi'),$request->input('prp'),$ext,
					$other,$request->input('form'));
		  $checkbox_type = array ($request->input('baru'),$request->input('ubah'),$request->input('batal'));

      $strcheckbox_doc = ",";
  		foreach ($checkbox_doc as $value) {
  			if ($value!="")
  			$strcheckbox_doc = $strcheckbox_doc."". $value .",";
  		  }

  		$strcheckbox_type = ",";
  		foreach ($checkbox_type as $value) {
  			if ($value!="")
  			$strcheckbox_type = $strcheckbox_type."".$value.",";
  		  }

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


  		$suggest = addslashes($request->input('suggest'));
  		$propose = addslashes($request->input('propose'));

      $id = $request->input('request_id');
    //  $form = P4no7::find($id);
      $form = new P4no7();
      $form->request_id = $id;
      $form->trial_time = $request->input('trial_periode');
      $form->date_effective = $request->input('date_effective');
      $form->cat_doc = $strcheckbox_doc;
      $form->cat_type = $strcheckbox_type;
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
      $form->suggest = $suggest;
      $form->purpose = $propose;
      $form->datesubmit = DB::raw('NOW()');

      //$ext = $file->getClientOriginalExtension();
      //$newName = rand(100000,1001238912).".".$ext;

      //$fullname =  "file_permintaan_baru_".$name;
      $file_baru = $request->file('file_baru');
      if ($file_baru!='')
      {
        $name_baru = $id."_baru_".$file_baru->getClientOriginalName();
        $file_baru->move('public/uploads/file/p4no7',$name_baru);
      }
      else $name_baru ='';

      $file_ubah = $request->file('file_ubah');
      if ($file_ubah!='')
      {
      $name_ubah = $id."_ubah_".$file_ubah->getClientOriginalName();
      $file_ubah->move('public/uploads/file/p4no7',$name_ubah);
      }
      else $name_ubah ='';

      $file_batal = $request->file('file_batal');
      if ($file_batal!='')
      {
      $name_batal = $id."_batal_".$file_batal->getClientOriginalName();
      $file_batal->move('public/uploads/file/p4no7',$name_batal);
      }
      else $name_batal ='';

      $file_doc_exist = $request->file('file_doc_exist');
      if ($file_doc_exist!='')
      {
      $name_doc_exist = $id."_doc-existing_".$file_doc_exist->getClientOriginalName();
      $file_doc_exist->move('public/uploads/file/p4no7',$name_doc_exist);
      }
      else $name_doc_exist ='';

      $file_doc = $request->file('file_doc');
      if ($file_doc!='')
      {
      $name_doc = $id."_doc_".$file_doc->getClientOriginalName();
      $file_doc->move('public/uploads/file/p4no7',$name_doc);
      }
      else $name_doc ='';

      $form->file_permintaan_baru = $name_baru;
      $form->file_perubahan = $name_ubah;
      $form->file_pembatalan = $name_batal;
      $form->file_dokumen = $name_doc;
      $form->file_dokumen_existing = $name_doc_exist;
      $form->save();

      $req = Req::find($id);
      $req->form_saved = 'yes';
      $req->verified = 'no';
      if ($req->approval1 != null)
      $approval_name = $req->approval1;
      elseif ($req->approval2 != null)
      $approval_name = $req->approval2;
      elseif ($req->approval_final != null)
      $approval_name = $req->approval_final;
      $req->save();

      //return redirect()->route('create_req')->with('data','Form P4no7 berhasil disimpan');
      //send email to QMS as verificator
      return redirect()->action(
      'MailController@send_verification');
   }

   public function fill_form8(Request $request)
   {
     $txt_other_hc = $request->input('other_hc_txt');
     $txt_ext = $request->input('ext_txt');
     $txt_other = $request->input('other_txt');
     if (!empty($txt_other_hc)) $other_hc = $request->input('other_hc') . "(" .$request->input('other_hc_txt'). ")";
     else $other_hc = "";
     if (!empty($txt_ext)) $ext = $request->input('ext') . "(" .$request->input('ext_txt'). ")";
     else $ext = "";
     if (!empty($txt_other)) $other = $request->input('other') . "(" .$request->input('other_txt'). ")";
     else $other = "";
     $otherh = "asd";

     $checkbox_hc = array ($request->input('soph'),$request->input('wih'),$request->input('mb'),$other_hc,$request->input('formh'));
     $checkbox_hc_type = array ($request->input('hc'),$request->input('sc'));

     $strcheckbox_hc = ",";
     foreach ($checkbox_hc as $value) {
       if ($value!="")
       $strcheckbox_hc = $strcheckbox_hc ."". $value.",";
       }

     $strcheckbox_hc_type = ",";
     foreach ($checkbox_hc_type as $value) {
       if ($value!="")
       $strcheckbox_hc_type = $strcheckbox_hc_type ."". $value.",";
       }

     $checkbox_sc = array ($request->input('psqm'),$request->input('oc'),$request->input('jd'),$request->input('sop'),$request->input('wi'),$request->input('haccp'),
                    $ext,$other,$request->input('form'));
     $checkbox_sc_type = array ($request->input('req_sc'),$request->input('el_sc'));

     $strcheckbox_sc = ",";
     foreach ($checkbox_sc as $value) {
       if ($value!="")
       $strcheckbox_sc = $strcheckbox_sc ."". $value.",";
       }

     $strcheckbox_sc_type = ",";
     foreach ($checkbox_sc_type as $value) {
       if ($value!="")
       $strcheckbox_sc_type = $strcheckbox_sc_type ."". $value.",";
       }

      $hc_nod = "^".$request->input('hc_nod1')."^" . $request->input('hc_nod2')."^" . $request->input('hc_nod3');
  		$hc_nr = "^".$request->input('hc_nr1')."^" . $request->input('hc_nr2')."^" . $request->input('hc_nr3');
  		$hc_nd = "^".$request->input('hc_nd1')."^" . $request->input('hc_nd2')."^" . $request->input('hc_nd3');
  		$hc_tc = "^".$request->input('hc_tc1')."^" . $request->input('hc_tc2')."^" . $request->input('hc_tc3');
  		$hc_p = "^".$request->input('hc_p1')."^" . $request->input('hc_p2')."^" . $request->input('hc_p3');

  		$sc_nod = "^".$request->input('sc_nod1')."^" . $request->input('sc_nod2')."^" . $request->input('sc_nod3');
  		$sc_nr = "^".$request->input('sc_nr1')."^" . $request->input('sc_nr2')."^" . $request->input('sc_nr3');
  		$sc_nd = "^".$request->input('sc_nd1')."^" . $request->input('sc_nd2')."^" . $request->input('sc_nd3');
  		$sc_sp = "^".$request->input('sc_sp1')."^" . $request->input('sc_sp2')."^" . $request->input('sc_sp3');
  		$sc_pp = "^".$request->input('sc_pp1')."^" . $request->input('sc_pp2')."^" . $request->input('sc_pp3');
  		$sc_em = "^".$request->input('sc_em1')."^" . $request->input('sc_em2')."^" . $request->input('sc_em3');

  		$el_nod = "^".$request->input('el_nod1')."^" . $request->input('el_nod2')."^" . $request->input('el_nod3')."^" . $request->input('el_nod4');
  		$el_nr = "^".$request->input('el_nr1')."^" . $request->input('el_nr2')."^" . $request->input('el_nr3')."^" . $request->input('el_nr4');
  		$el_nd = "^".$request->input('el_nd1')."^" . $request->input('el_nd2')."^" . $request->input('el_nd3')."^" . $request->input('el_nd4');
  		$el_sp = "^".$request->input('el_sp1')."^" . $request->input('el_sp2')."^" . $request->input('el_sp3')."^" . $request->input('el_sp4');
  		$el_pp = "^".$request->input('el_pp1')."^" . $request->input('el_pp2')."^" . $request->input('el_pp3')."^" . $request->input('el_pp4');
  		$el_t = "^".$request->input('el_t1')."^" . $request->input('el_t2')."^" . $request->input('el_t3')."^" . $request->input('el_t4');

      $purpose = addslashes($request->input('purpose'));
      $id = $request->input('request_id');

      $form = new P4no8();
      $form->request_id = $id;
      $form->hc_category = $strcheckbox_hc;
      $form->hc_cattype = $strcheckbox_hc_type;
      $form->sc_category = $strcheckbox_sc;
      $form->sc_cattype = $strcheckbox_sc_type;
      $form->hc_nodoc = $hc_nod;
      $form->hc_norev = $hc_nr;
      $form->hc_docname = $hc_nd;
      $form->hc_nocopy = $hc_tc;
      $form->hc_place = $hc_p;
      $form->sc_nodoc =  $sc_nod;
      $form->sc_norev = $sc_nr;
      $form->sc_docname = $sc_nd;
      $form->sc_saveperiode = $sc_sp;
      $form->sc_saveplace = $sc_pp;
      $form->sc_eliminate = $sc_em;
      $form->purpose = $purpose;
      $form->el_nodoc = $el_nod;
      $form->el_norev = $el_nr;
      $form->el_docname = $el_nd;
      $form->el_saveperiode = $el_sp;
      $form->el_eliminate = $el_pp;
      $form->el_amount = $el_t;
      $form->datesubmit = DB::raw('NOW()');

      $file_hc = $request->file('file_hc');
      if ($file_hc!='')
      {
        $name_hc = $id."_hc_".$file_hc->getClientOriginalName();
        $file_hc->move('public/uploads/file/p4no8',$name_hc);
      }
      else $name_hc ='';

      $file_sc = $request->file('file_sc');
      if ($file_sc!='')
      {
        $name_sc = $id."_sc_".$file_sc->getClientOriginalName();
        $file_sc->move('public/uploads/file/p4no8',$name_sc);
      }
      else $name_sc ='';

      $file_el = $request->file('file_el');
      if ($file_el!='')
      {
        $name_el = $id."_el_".$file_el->getClientOriginalName();
        $file_el->move('public/uploads/file/p4no8',$name_el);
      }
      else $name_el ='';

      $form->file_hardcopy = $name_hc;
      $form->file_softcopy = $name_sc;
      $form->file_pemusnahan = $name_el;
      $form->save();

      $req = Req::find($id);
      $req->form_saved = 'yes';
      //form p4no8 tidak perlu verifikasi
      $req->verified = 'yes';
      if ($req->approval1 != null)
      $approval_name = $req->approval1;
      elseif ($req->approval2 != null)
      $approval_name = $req->approval2;
      elseif ($req->approval_final != null)
      $approval_name = $req->approval_final;
      $req->save();
      //return redirect()->route('create_req')->with('data','Form P4no8 berhasil disimpan');
      return redirect()->action(
      'MailController@send_request', ['name' => $approval_name]
    );

   }

   public function fill_form9(Request $request)
   {
     $f_nod = "^".$request->input('f_nod1')."^" . $request->input('f_nod2')."^" . $request->input('f_nod3')."^" . $request->input('f_nod4')."^" . $request->input('f_nod5');
		 $f_nr = "^".$request->input('f_nr1')."^" . $request->input('f_nr2')."^" . $request->input('f_nr3')."^" . $request->input('f_nr4')."^" . $request->input('f_nr5');
		 $f_nd = "^".$request->input('f_nd1')."^" . $request->input('f_nd2')."^" . $request->input('f_nd3')."^" . $request->input('f_nd4')."^" . $request->input('f_nd5');
 		 $f_t = "^".$request->input('f_t1')."^" . $request->input('f_t2')."^" . $request->input('f_t3')."^" . $request->input('f_t4')."^" . $request->input('f_t5');
 		 $f_r = "^".$request->input('f_r1')."^" . $request->input('f_r2')."^" . $request->input('f_r3')."^" . $request->input('f_r4')."^" . $request->input('f_r5');

     $purpose = addslashes($request->input('purpose'));
     $id = $request->input('request_id');

     $form = new P4no9();
     $form->request_id = $id;
     $form->form_nodoc = $f_nod;
     $form->form_norev = $f_nr;
     $form->form_docname = $f_nd;
     $form->form_amount = $f_t;
     $form->form_remark = $f_r;
    // $form->purpose = $purpose;
     $form->datesubmit = DB::raw('NOW()');

     $file_cetak = $request->file('file_cetak');
     if ($file_cetak!='')
     {
       $name_cetak = $id."_cetak_".$file_cetak->getClientOriginalName();
       $file_cetak->move('public/uploads/file/p4no9',$name_cetak);
     }
     else $name_cetak ='';

     $form->file_cetak = $name_cetak;
     $form->save();

     $req = Req::find($id);
     $req->form_saved = 'yes';
     $req->verified = 'no';
     if ($req->approval1 != null)
     $approval_name = $req->approval1;
     elseif ($req->approval2 != null)
     $approval_name = $req->approval2;
     elseif ($req->approval_final != null)
     $approval_name = $req->approval_final;
     $req->save();
     return redirect()->route('create_req')->with('data','Form P4no8 berhasil disimpan');
     /*return redirect()->action(
     'MailController@send_request', ['name' => $approval_name]
   );*/

   }

   public function fill_req_chfolder(Request $request)
   {
     $checkbox = array ($request->input('tambah'),$request->input('ubah'),$request->input('hapus'));

     $strcheckbox = ",";
     foreach ($checkbox as $value) {
       if ($value!="")
       $strcheckbox = $strcheckbox ."". $value.",";
       }

     $id = $request->input('request_id');
     $form = new ChangeFolder();
     $form->request_id = $id;
     $form->change_type = $strcheckbox;
     $form->description = $request->input('desc');
     $file_lampiran = $request->file('file_lampiran');
     if ($file_lampiran!='')
     {
       $name_lampiran = $id."_lampiran_".$file_lampiran->getClientOriginalName();
       $file_lampiran->move('public/uploads/file/req_change-folder',$name_lampiran);
     }
     else $name_lampiran ='';

     $form->file = $name_lampiran;
     $form->datesubmit = DB::raw('NOW()');
     $form->save();

     $req = Req::find($id);
     $req->form_saved = 'yes';
     $req->verified = 'yes';
     if ($req->approval1 != null)
     $approval_name = $req->approval1;
     elseif ($req->approval2 != null)
     $approval_name = $req->approval2;
     elseif ($req->approval_final != null)
     $approval_name = $req->approval_final;
     $req->save();
     //return redirect()->route('create_req')->with('data','Form request perubahan folder behasil disimpan');
     return redirect()->action(
     'MailController@send_request', ['name' => $approval_name]
     );

   }

   public function fill_req_frmit01(Request $request)
   {
     $checkbox_req = array ($request->input('baru'),$request->input('perbaikan'),$request->input('penggantian'),$request->input('instalasi'));
     $strcheckbox_req = ",";
     foreach ($checkbox_req as $value) {
       if ($value!="")
       $strcheckbox_req = $strcheckbox_req ."". $value.",";
       }

     $checkbox_item = array ($request->input('hardware'),$request->input('software'),$request->input('application'),$request->input('connection'));
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

     $id = $request->input('request_id');
     $form = new FormIT01;
     $form->request_id = $id;
     $form->request_type = $strcheckbox_req;
     $form->item_type = $strcheckbox_item;
     $form->item_name = $request->input('nama_hwsw');
     $form->item_ne = $request->input('ne');
     $form->function = $strcheckbox_function;
     $form->reason = $request->input('desc');
     $file_lampiran = $request->file('file_lampiran');
     if ($file_lampiran!='')
     {
       $name_lampiran = $id."_lampiran_".$file_lampiran->getClientOriginalName();
       $file_lampiran->move('public/uploads/file/req_form-it-01',$name_lampiran);
     }
     else $name_lampiran ='';

     $form->file_lampiran = $name_lampiran;
     $form->datesubmit = DB::raw('NOW()');
     $form->save();

     $req = Req::find($id);
     $req->form_saved = 'yes';
     //otomatis veified by IT
     $req->verified = 'yes';
     $req->verified_date = DB::raw('NOW()');

     if ($req->approval1 != null)
     $approval_name = $req->approval1;
     elseif ($req->approval2 != null)
     $approval_name = $req->approval2;
     elseif ($req->approval_final != null)
     $approval_name = $req->approval_final;

     if (strpos($strcheckbox_item, 'application') !== false) {
       $reqdept = $req->dept;
       $reqplant = $req->plant;
       //query mencari divisi head
       $divhead = ApprovalHirarki::where('dept','=',$reqdept)->where('plant','=',$reqplant)->first();
       $req->approval1 = $divhead->approval_final;
       $it = ApprovalHirarkiOther::where('approver','IT')->first();
       $req->approval2 = $it['name'];
       $it_final = ApprovalHirarkiOther::where('approver','IT_final')->first();
       $req->approval_final = $it_final['name'];
      // $req->approval_final = 'IT';
     }
     elseif (strpos($strcheckbox_item, 'connection') !== false) {
       $req->approval2 = $divhead->approval_final;
       $it = ApprovalHirarkiOther::where('approver','IT')->first();
       $req->approval_final = $it['name'];
     }
     else {
       $req->approval2 = null;
       $it = ApprovalHirarkiOther::where('approver','IT')->first();
       $req->approval_final = $it['name'];
     }
     $req->save();
     //return redirect()->route('create_req')->with('data','Form request perubahan folder behasil disimpan');
     return redirect()->action(
     'MailController@send_verification');
     /*
     return redirect()->action(
     'MailController@send_request', ['name' => $approval_name]
   ); */

   }

   public function update_chfolder(Request $request)
   {
     $checkbox = array ($request->input('tambah'),$request->input('ubah'),$request->input('hapus'));

     $strcheckbox = ",";
     foreach ($checkbox as $value) {
       if ($value!="")
       $strcheckbox = $strcheckbox ."". $value.",";
       }

     $id = $request->input('request_id');
     $form = ChangeFolder::find($id);
     $form->change_type = $strcheckbox;
     $form->description = $request->input('desc');
     $file_lampiran = $request->file('file_lampiran');
     if ($file_lampiran!='')
     {
       $name_lampiran = $id."_lampiran_".$file_lampiran->getClientOriginalName();
       $file_lampiran->move('public/uploads/file/req_change-folder',$name_lampiran);
     }
     else $name_lampiran ='';

     $form->file = $name_lampiran;
     $form->save();

     $req = Req::find($id);
     $req->status = 'waiting';
     $approval_name = $req->reject_by;
     $req->save();
     return redirect()->route('history_req')->with('data','Form request perubahan folder behasil diupdate');
    /* return redirect()->action(
     'MailController@send_update', ['name' => $approval_name]
   ); */
   }

   public function update_form7(Request $request)
   {
     //upload file
     //$form = new P4no7();
     $txt_ext = $request->input('ext_txt');
     $txt_other = $request->input('other_txt');
     if (!empty($txt_ext)) $ext = $request->input('ext') . "(" .$request->input('ext_txt'). ")";
     else $ext = "";
     if (!empty($txt_other)) $other = $request->input('other') . "(" .$request->input('other_txt'). ")";
     else $other = "";

     $checkbox_doc = array ($request->input('psqm'),$request->input('oc'),$request->input('jd'),$request->input('sop'),$request->input('wi'),$request->input('prp'),$ext,
         $other,$request->input('form'));
     $checkbox_type = array ($request->input('baru'),$request->input('ubah'),$request->input('batal'));

     $strcheckbox_doc = ",";
     foreach ($checkbox_doc as $value) {
       if ($value!="")
       $strcheckbox_doc = $strcheckbox_doc."". $value .",";
       }

     $strcheckbox_type = ",";
     foreach ($checkbox_type as $value) {
       if ($value!="")
       $strcheckbox_type = $strcheckbox_type."".$value.",";
       }

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


     $suggest = addslashes($request->input('suggest'));
     $propose = addslashes($request->input('propose'));

     $id = $request->input('request_id');
   //  $form = P4no7::find($id);
     $form = P4no7::find($id);
     $form->trial_time = $request->input('trial_periode');
     $form->date_effective = $request->input('date_effective');
     $form->cat_doc = $strcheckbox_doc;
     $form->cat_type = $strcheckbox_type;
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
     $form->suggest = $suggest;
     $form->purpose = $propose;
     $form->datesubmit = DB::raw('NOW()');

     //$ext = $file->getClientOriginalExtension();
     //$newName = rand(100000,1001238912).".".$ext;

     //$fullname =  "file_permintaan_baru_".$name;

     /*file list pengajuan baru */
     $file_baru = $request->file('file_baru');
     //$file_baru_read = $file_baru->getClientOriginalName();
     //jika file yg diupload ada dan diserver kosong
     if ($file_baru!='' && $form->file_permintaan_baru == NULL)
     {
       $file_baru_read = $file_baru->getClientOriginalName();
       $name_baru = $id."_baru-n-".$file_baru_read;
       $file_baru->move('public/uploads/file/p4no7',$name_baru);
     }
     //jika file yg diupload ada dan namanya sama dg yg ada diserver
     elseif ($file_baru!='' && $file_baru ==  $form->file_permintaan_baru)
     {
       $file_baru_read = $file_baru->getClientOriginalName();
       $name_baru = $id."_baru-s-".$file_baru_read;
       //delete file
       unlink(public_path('uploads/file/p4no7/'.$form->file_permintaan_baru));
       $file_baru->move('public/uploads/file/p4no7',$name_baru);
     }
     //jika file yg diupload ada dan namanya beda dg yg ada diserver
     elseif ($file_baru!='' && $file_baru !=  $form->file_permintaan_baru)
     {
       $file_baru_read = $file_baru->getClientOriginalName();
        $name_baru = $id."_baru-d-".$file_baru_read;
       //delete file
       unlink(public_path('uploads/file/p4no7/'.$form->file_permintaan_baru));
       $file_baru->move('public/uploads/file/p4no7',$name_baru);

     }
     elseif ($file_baru=='')
     {
       $name_baru = $request->input('file_baru_ori');
     }

     $file_ubah = $request->file('file_ubah');
     if ($file_ubah!='')
     {
       //jika file yg di ubah namanya sama
       $file_doc_read = $file_baru->getClientOriginalName();
       if($file_doc_read ==  $form->file_perubahan)
       {
         //delete file
         unlink(public_path('uploads/file/p4no7/'.$form->file_perubahan));
         $name_ubah = 'update_'.$file_doc_read;
       }
       elseif($form->file_permintaan_baru == null)
       {
         $name_ubah = $id."_doc_".$file_ubah->getClientOriginalName();
       }
       else
       {
         unlink(public_path('uploads/file/p4no7/'.$form->file_perubahan));
         $name_ubah = $id."_doc_".$file_ubah->getClientOriginalName();
       }
     //$name_doc = $file_doc->getClientOriginalName();
      $file_ubah->move('public/uploads/file/p4no7',$name_ubah);
     }
     else $name_ubah = $request->input('file_ubah_ori');

     $file_batal = $request->file('file_batal');
     if ($file_batal!='')
     {
       //jika file yg di ubah namanya sama
       $file_doc_read = $file_baru->getClientOriginalName();
       if($file_doc_read ==  $form->file_pembatalan)
       {
         //delete file
         unlink(public_path('uploads/file/p4no7/'.$form->file_pembatalan));
         $name_batal = 'update_'.$file_doc_read;
       }
       elseif($form->file_permintaan_baru == null)
       {
         $name_batal = $id."_doc_".$file_batal->getClientOriginalName();
       }
       else
       {
         unlink(public_path('uploads/file/p4no7/'.$form->file_pembatalan));
         $name_batal = $id."_doc_".$file_batal->getClientOriginalName();
       }
     //$name_doc = $file_doc->getClientOriginalName();
      $file_batal->move('public/uploads/file/p4no7',$name_batal);
     }
     else $name_batal = $request->input('file_batal_ori');

     /* file dokumen existing */
     $file_doc_exist = $request->file('file_doc_exist');
     //$file_doc_exist_read = $file_doc_exist->getClientOriginalName();
     //jika file yg diupload ada dan diserver kosong
     if ($file_doc_exist!='' && $form->file_dokumen_existing == NULL)
     {
       $file_doc_exist_read = $file_doc_exist->getClientOriginalName();
       $name_doc_exist = $id."_doc-exist-n-".$file_doc_exist_read;
       $file_doc_exist->move('public/uploads/file/p4no7',$name_doc_exist);
     }
     //jika file yg diupload ada dan namanya sama dg yg ada diserver
     elseif ($file_doc_exist!='' && $file_doc_exist ==  $form->file_dokumen_existing)
     {
       $file_doc_exist_read = $file_doc_exist->getClientOriginalName();
       $name_doc_exist = $id."_doc-exist-s-".$file_doc_exist_read;
       //delete file
       unlink(public_path('uploads/file/p4no7/'.$form->file_dokumen_existing));
       $file_doc_exist->move('public/uploads/file/p4no7',$name_doc_exist);
     }
     //jika file yg diupload ada dan namanya beda dg yg ada diserver
     elseif ($file_doc_exist!='' && $file_doc_exist !=  $form->file_dokumen_existing)
     {
       $file_doc_exist_read = $file_doc_exist->getClientOriginalName();
        $name_doc_exist = $id."_doc-exist-d-".$file_doc_exist_read;
       //delete file
       unlink(public_path('uploads/file/p4no7/'.$form->file_dokumen_existing));
       $file_doc_exist->move('public/uploads/file/p4no7',$name_doc_exist);

     }
     elseif ($file_doc_exist=='')
     {
       $name_doc_exist = $request->input('file_doc_exist_ori');
     }

     /*file dokumen yg diajukan */
     $file_doc = $request->file('file_doc');
     //$file_doc_read = $file_doc->getClientOriginalName();
     //jika file yg diupload ada dan diserver kosong
     if ($file_doc!='' && $form->file_dokumen == NULL)
     {
       $file_doc_read = $file_doc->getClientOriginalName();
       $name_doc = $id."_doc-n-".$file_doc_read;
       $file_doc->move('public/uploads/file/p4no7',$name_doc);
     }
     //jika file yg diupload ada dan namanya sama dg yg ada diserver
     elseif ($file_doc!='' && $file_doc ==  $form->file_dokumen)
     {
       $file_doc_read = $file_doc->getClientOriginalName();
       //$name_doc = $file_doc->getClientOriginalName();
       $name_doc = $id."_doc-s-".$file_doc_read;
       //delete file
       unlink(public_path('uploads/file/p4no7/'.$form->file_dokumen));
       $file_doc->move('public/uploads/file/p4no7',$name_doc);
     }
     //jika file yg diupload ada dan namanya beda dg yg ada diserver
     elseif ($file_doc!='' && $file_doc !=  $form->file_dokumen)
     {
       $file_doc_read = $file_doc->getClientOriginalName();
        $name_doc = $id."_doc-d-".$file_doc_read;
       //delete file
       unlink(public_path('uploads/file/p4no7/'.$form->file_dokumen));
       $file_doc->move('public/uploads/file/p4no7',$name_doc);

     }
     elseif ($file_doc=='')
     {
       $name_doc = $request->input('file_doc_ori');
     }

     /*
     $file_doc = $request->file('file_doc');
     if ($file_doc!='')
     {
       //jika file yg di ubah namanya sama
       $file_doc_read = $file_doc->getClientOriginalName();
       if($file_doc_read ==  $form->file_dokumen)
       {
         //delete file
         unlink(public_path('uploads/file/p4no7/'.$form->file_dokumen));
         $name_doc = 'update_'.$file_doc_read;
       }

       else
       {
         if ($form->file_dokumen != '')
         {unlink(public_path('uploads/file/p4no7/'.$form->file_dokumen));}
         $name_doc = $id."_doc_".date("his")."".$file_doc->getClientOriginalName();
       }
     //$name_doc = $file_doc->getClientOriginalName();
     //$file_doc->move('public/uploads/file/p4no7',$name_doc);
     }
     else
     {
       $name_doc = $request->input('file_doc_ori');
       $file_doc->move('public/uploads/file/p4no7',$name_doc);
     }
     */
    // $name_doc = "book1.xls";


     $form->file_permintaan_baru = $name_baru;
     $form->file_perubahan = $name_ubah;
     $form->file_pembatalan = $name_batal;
     $form->file_dokumen_existing = $name_doc_exist;
     $form->file_dokumen = $name_doc;
     $form->save();

     $req = Req::find($id);
     $req->status = 'waiting';
     $req->save();
     //jika request diedit sebelum terverifikasi atau sebelum reject tidak akan kirim email
     if ($req->verified == 'no' || $req->reject_by == null )
     {
       return redirect()->route('history_req')->with('data','Form P4no7 berhasil diupdate');
     }
     else {
     $approval_name = $req->reject_by;
     return redirect()->action(
     'MailController@send_update', ['name' => $approval_name]
     );
     }
   }

   public function update_form8(Request $request)
   {
     $txt_other_hc = $request->input('other_hc_txt');
     $txt_ext = $request->input('ext_txt');
     $txt_other = $request->input('other_txt');
     if (!empty($txt_other_hc)) $other_hc = $request->input('other_hc') . "(" .$request->input('other_hc_txt'). ")";
     else $other_hc = "";
     if (!empty($txt_ext)) $ext = $request->input('ext') . "(" .$request->input('ext_txt'). ")";
     else $ext = "";
     if (!empty($txt_other)) $other = $request->input('other') . "(" .$request->input('other_txt'). ")";
     else $other = "";
     $otherh = "asd";

     $checkbox_hc = array ($request->input('soph'),$request->input('wih'),$request->input('mb'),$other_hc,$request->input('formh'));
     $checkbox_hc_type = array ($request->input('hc'),$request->input('sc'));

     $strcheckbox_hc = ",";
     foreach ($checkbox_hc as $value) {
       if ($value!="")
       $strcheckbox_hc = $strcheckbox_hc ."". $value.",";
       }

     $strcheckbox_hc_type = ",";
     foreach ($checkbox_hc_type as $value) {
       if ($value!="")
       $strcheckbox_hc_type = $strcheckbox_hc_type ."". $value.",";
       }

     $checkbox_sc = array ($request->input('psqm'),$request->input('oc'),$request->input('jd'),$request->input('sop'),$request->input('wi'),$request->input('haccp'),
                    $ext,$other,$request->input('form'));
     $checkbox_sc_type = array ($request->input('req_sc'),$request->input('el_sc'));

     $strcheckbox_sc = ",";
     foreach ($checkbox_sc as $value) {
       if ($value!="")
       $strcheckbox_sc = $strcheckbox_sc ."". $value.",";
       }

     $strcheckbox_sc_type = ",";
     foreach ($checkbox_sc_type as $value) {
       if ($value!="")
       $strcheckbox_sc_type = $strcheckbox_sc_type ."". $value.",";
       }

      $hc_nod = "^".$request->input('hc_nod1')."^" . $request->input('hc_nod2')."^" . $request->input('hc_nod3');
  		$hc_nr = "^".$request->input('hc_nr1')."^" . $request->input('hc_nr2')."^" . $request->input('hc_nr3');
  		$hc_nd = "^".$request->input('hc_nd1')."^" . $request->input('hc_nd2')."^" . $request->input('hc_nd3');
  		$hc_tc = "^".$request->input('hc_tc1')."^" . $request->input('hc_tc2')."^" . $request->input('hc_tc3');
  		$hc_p = "^".$request->input('hc_p1')."^" . $request->input('hc_p2')."^" . $request->input('hc_p3');

  		$sc_nod = "^".$request->input('sc_nod1')."^" . $request->input('sc_nod2')."^" . $request->input('sc_nod3');
  		$sc_nr = "^".$request->input('sc_nr1')."^" . $request->input('sc_nr2')."^" . $request->input('sc_nr3');
  		$sc_nd = "^".$request->input('sc_nd1')."^" . $request->input('sc_nd2')."^" . $request->input('sc_nd3');
  		$sc_sp = "^".$request->input('sc_sp1')."^" . $request->input('sc_sp2')."^" . $request->input('sc_sp3');
  		$sc_pp = "^".$request->input('sc_pp1')."^" . $request->input('sc_pp2')."^" . $request->input('sc_pp3');
  		$sc_em = "^".$request->input('sc_em1')."^" . $request->input('sc_em2')."^" . $request->input('sc_em3');

  		$el_nod = "^".$request->input('el_nod1')."^" . $request->input('el_nod2')."^" . $request->input('el_nod3')."^" . $request->input('el_nod4');
  		$el_nr = "^".$request->input('el_nr1')."^" . $request->input('el_nr2')."^" . $request->input('el_nr3')."^" . $request->input('el_nr4');
  		$el_nd = "^".$request->input('el_nd1')."^" . $request->input('el_nd2')."^" . $request->input('el_nd3')."^" . $request->input('el_nd4');
  		$el_sp = "^".$request->input('el_sp1')."^" . $request->input('el_sp2')."^" . $request->input('el_sp3')."^" . $request->input('el_sp4');
  		$el_pp = "^".$request->input('el_pp1')."^" . $request->input('el_pp2')."^" . $request->input('el_pp3')."^" . $request->input('el_pp4');
  		$el_t = "^".$request->input('el_t1')."^" . $request->input('el_t2')."^" . $request->input('el_t3')."^" . $request->input('el_t4');

      $purpose = addslashes($request->input('purpose'));
      $id = $request->input('request_id');

      $form = P4no8::find($id);
      $form->hc_category = $strcheckbox_hc;
      $form->hc_cattype = $strcheckbox_hc_type;
      $form->sc_category = $strcheckbox_sc;
      $form->sc_cattype = $strcheckbox_sc_type;
      $form->hc_nodoc = $hc_nod;
      $form->hc_norev = $hc_nr;
      $form->hc_docname = $hc_nd;
      $form->hc_nocopy = $hc_tc;
      $form->hc_place = $hc_p;
      $form->sc_nodoc =  $sc_nod;
      $form->sc_norev = $sc_nr;
      $form->sc_docname = $sc_nd;
      $form->sc_saveperiode = $sc_sp;
      $form->sc_saveplace = $sc_pp;
      $form->sc_eliminate = $sc_em;
      $form->purpose = $purpose;
      $form->el_nodoc = $el_nod;
      $form->el_norev = $el_nr;
      $form->el_docname = $el_nd;
      $form->el_saveperiode = $el_sp;
      $form->el_eliminate = $el_pp;
      $form->el_amount = $el_t;
      $form->datesubmit = DB::raw('NOW()');

      $file_hc = $request->file('file_hc');
      if ($file_hc!='')
      {
        //jika file yg di ubah namanya sama
        $file_doc_read = $file_hc->getClientOriginalName();
        if($file_doc_read ==  $form->file_hardcopy)
        {
          //delete file
          unlink(public_path('uploads/file/p4no8/'.$form->file_hardcopy));
          $name_hc = 'update_'.$file_doc_read;
        }
        //jika file null tidak melakukan delete
        elseif($form->file_hardcopy == null)
        {
          $name_hc = $id."_hc_".$file_hc->getClientOriginalName();
        }
        else {
            unlink(public_path('uploads/file/p4no8/'.$form->file_hardcopy));
            $name_hc = $id."_hc_".$file_hc->getClientOriginalName();
          }
      $file_hc->move('public/uploads/file/p4no8',$name_hc);
      }
      else $name_hc = $request->input('file_hc_ori');

      $file_sc = $request->file('file_sc');
      if ($file_sc!='')
      {
        //jika file yg di ubah namanya sama
        $file_doc_read = $file_sc->getClientOriginalName();
        if($file_doc_read ==  $form->file_softcopy)
        {
          //delete file
          unlink(public_path('uploads/file/p4no8/'.$form->file_softcopy));
          $name_sc = 'update_'.$file_doc_read;
        }
        //jika file null tidak melakukan delete
        elseif($form->file_softcopy == null)
        {
          $name_sc = $id."_sc_".$file_sc->getClientOriginalName();
        }
        else {
            unlink(public_path('uploads/file/p4no8/'.$form->file_softcopy));
            $name_sc = $id."_sc_".$file_sc->getClientOriginalName();
          }
      $file_sc->move('public/uploads/file/p4no8',$name_sc);
      }
      else $name_sc = $request->input('file_sc_ori');

      $file_el = $request->file('file_el');
      if ($file_el!='')
      {
        //jika file yg di ubah namanya sama
        $file_doc_read = $file_hc->getClientOriginalName();
        if($file_doc_read ==  $form->file_pemusnahan)
        {
          //delete file
          unlink(public_path('uploads/file/p4no8/'.$form->file_pemusnahan));
          $name_el = 'update_'.$file_doc_read;
        }
        //jika file null tidak melakukan delete
        elseif($form->file_pemusnahan == null)
        {
          $name_el = $id."_el_".$file_el->getClientOriginalName();
        }
        else {
            unlink(public_path('uploads/file/p4no8/'.$form->file_pemusnahan));
            $name_el = $id."_el_".$file_el->getClientOriginalName();
          }
      $file_el->move('public/uploads/file/p4no8',$name_el);
      }
      else $name_el = $request->input('file_el_ori');

      $form->file_hardcopy = $name_hc;
      $form->file_softcopy = $name_sc;
      $form->file_pemusnahan = $name_el;
      $form->save();

      $req = Req::find($id);
      $req->status = 'waiting';
      $approval_name = $req->reject_by;
      $req->save();
      //jika request diedit sebelum terverifikasi atau sebelum reject tidak akan kirim email
      if ($req->verified == 'no' || $req->reject_by == null )
      {
        return redirect()->route('history_req')->with('data','Form P4no8 berhasil diupdate');
      }
      else {
      $approval_name = $req->reject_by;
      return redirect()->action(
      'MailController@send_update', ['name' => $approval_name]
      );
      }
   }

   public function update_req_frmit01(Request $request)
   {
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

     $id = $request->input('request_id');
     $form = FormIT01::find($id);
     $form->request_type = $strcheckbox_req;
     $form->item_type = $strcheckbox_item;
     $form->item_name = $request->input('nama_hwsw');
     $form->item_ne = $request->input('ne');
     $form->function = $strcheckbox_function;
     $form->reason = $request->input('desc');

     $file_doc = $request->file('file_lampiran_ch');
     if ($file_doc!='')
     {
       //jika file yg di ubah namanya sama
       $file_doc_read = $file_doc->getClientOriginalName();
       if($file_doc_read ==  $form->file_lampiran)
       {
         //delete file
         unlink(public_path('uploads/file/req_form-it-01/'.$form->file_lampiran));
         $name_doc = 'update_'.$file_doc_read;
       }
       else
       {
         if ($form->file_lampiran != '')
         {unlink(public_path('uploads/file/req_form-it-01/'.$form->file_lampiran));}
         $name_doc = $id."_lampiran_".$file_doc->getClientOriginalName();
       }
     $file_doc->move('public/uploads/file/req_form-it-01',$name_doc);
     }
     else $name_doc = $request->input('file_lampiran_ori');

     /*
     $file_lampiran = $request->file('file_lampiran');
     if ($file_lampiran!='')
     {
       $name_lampiran = $id."_lampiran_".$file_lampiran->getClientOriginalName();
       $file_lampiran->move('public/uploads/file/req_form-it-01',$name_lampiran);
     }
     else $name_lampiran ='';
     */
     $form->file_lampiran = $name_doc;
     $form->save();

     $req = Req::find($id);
     $req->status = 'waiting';
     //$approval_name = $req->reject_by;
     $req->save();
     return redirect()->route('history_req')->with('data','Form request perubahan folder behasil diupdate');
     /*
     return redirect()->action(
     'MailController@send_request', ['name' => $approval_name]
   ); */

   }

}
