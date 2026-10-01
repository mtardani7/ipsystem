<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QuestionFrmPrc31;
use App\DataPengisi;
use App\AnswerFrmPrc31;
use Auth;

class PurcFormReportController extends Controller
{
    //
    public function index()
      {
          return view('administration/purc_form_report/PurcReport');
      }
    public function report_form_prc_31()
    {
      $pengisi = DataPengisi::orderBy('date')->paginate(10);
      return view('administration/purc_form_report/report_frm_prc_31', compact('pengisi'));
    }
    public function view($id)
    {
      $actions = 'view';
      $user = Auth::user()->name;
      $pengisi = DataPengisi::find($id);
      if ($pengisi->form == 'FRM_PRC-31(Limbah)')
        {
          $form = 'form_prc_31_limbah';
          $q1 = QuestionFrmPrc31::where('category','Limbah_Harga')->where('active',1)->get();
          $qc1 = $q1->count();
          $q2 = QuestionFrmPrc31::where('category','Limbah_Pembayaran')->where('active',1)->get();
          $qc2 = $q2->count();
          $q3 = QuestionFrmPrc31::where('category','Limbah_Tanggapan')->where('active',1)->get();
          $qc3 = $q3->count();
          $q4 = QuestionFrmPrc31::where('category','Limbah_Kinerja')->where('active',1)->get();
          $qc4 = $q4->count();
          $q5 = QuestionFrmPrc31::where('category','Limbah_None')->where('active',1)->get();
          $qc5 = $q5->count();
        //  $data = P4no7::find($id);
        //  $dbp4 =  new P4no7();
        $answers = AnswerFrmPrc31::where('id_pengisi',$id)->get();

        return view('form/'.$form,compact('answers','pengisi','user','actions','q1','qc1','q2','qc2','q3','qc3','q4','qc4','q5','qc5'));
        }
      elseif ($pengisi->form == 'FRM_PRC-31(Catering)')
      {
        $form = 'form_prc_31_catering';
        $q1 = QuestionFrmPrc31::where('category','Catering_None')->where('active',1)->get();
        $qc1 = $q1->count();
      //  $data = P4no8::find($id);
      //  $dbp4 =  new P4no8();
      $answers = AnswerFrmPrc31::where('id_pengisi',$id)->get();

      return view('form/'.$form,compact('answers','pengisi','user','actions','q1','qc1'));
      }
      elseif ($pengisi->form == 'FRM_PRC-31(Pest Control)')
      {
        $form = 'form_prc_31_pest';
        $q1 = QuestionFrmPrc31::where('category','Pest Control_none')->where('active',1)->get();
        $qc1 = $q1->count();
      //  $data = P4no9::find($id);
      //  $dbp4 =  new P4no8();
      $answers = AnswerFrmPrc31::where('id_pengisi',$id)->get();

      return view('form/'.$form,compact('answers','pengisi','user','actions','q1','qc1'));
      }
      elseif ($pengisi->form == 'FRM_PRC-31(Kalibrasi & Laboratorium)')
      {
        $form = 'form_prc_31_lab';
        $q1 = QuestionFrmPrc31::where('category','Kalibrasi & Laboratorium_none')->where('active',1)->get();
        $qc1 = $q1->count();
      //  $data = ChangeFolder::find($id);
      //  $dbp4 =  new P4no8();
      $answers = AnswerFrmPrc31::where('id_pengisi',$id)->get();

      return view('form/'.$form,compact('answers','pengisi','user','actions','q1','qc1'));
      }
      elseif ($pengisi->form == 'FRM_PRC-31(Sewa Forklift)')
      {
        $form = 'form_prc_31_forklift';
        $q1 = QuestionFrmPrc31::where('category','Sewa Forklift_none')->where('active',1)->get();
        $qc1 = $q1->count();
      //  $data = FormIT01::find($id);
      //  $dbp4 =  new P4no8();
      $answers = AnswerFrmPrc31::where('id_pengisi',$id)->get();

      return view('form/'.$form,compact('answers','pengisi','user','actions','q1','qc1'));
      }
      elseif ($pengisi->form == 'FRM_PRC-31(Cleaning Service)')
      {
        $form = 'form_prc_31_cleaning';
        $q1 = QuestionFrmPrc31::where('category','Cleaning Service_Kinerja')->where('active',1)->get();
        $qc1 = $q1->count();
        $q2 = QuestionFrmPrc31::where('category','Cleaning Service_Pelayanan')->where('active',1)->get();
        $qc2 = $q2->count();
      //  $data = FormIT01::find($id);
      //  $dbp4 =  new P4no8();
      $answers = AnswerFrmPrc31::where('id_pengisi',$id)->get();

      return view('form/'.$form,compact('answers','pengisi','user','actions','q1','qc1','q2','qc2'));
      }

    }
}
