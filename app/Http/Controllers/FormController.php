<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QuestionFrmPrc31;
use App\AnswerFrmPrc31;
use App\DataPengisi;
use DB;
use Session;

class FormController extends Controller
{
    //
    public function index()
      {
          return view('form/form');
      }
    public function form_prc_31_limbah()
      {
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
        return view('form/form_prc_31_limbah', compact('q1','qc1','q2','qc2','q3','qc3','q4','qc4','q5','qc5'));
      }

    public function form_prc_31_catering()
      {
        $q1 = QuestionFrmPrc31::where('category','Catering_None')->where('active',1)->get();
        $qc1 = $q1->count();
        return view('form/form_prc_31_catering', compact('q1','qc1'));
      }

    public function form_prc_31_pest()
      {
          $q1 = QuestionFrmPrc31::where('category','Pest Control_none')->where('active',1)->get();
          $qc1 = $q1->count();
          return view('form/form_prc_31_pest', compact('q1','qc1'));
      }

    public function form_prc_31_lab()
      {
          $q1 = QuestionFrmPrc31::where('category','Kalibrasi & Laboratorium_none')->where('active',1)->get();
          $qc1 = $q1->count();
          return view('form/form_prc_31_lab', compact('q1','qc1'));
      }

    public function form_prc_31_forklift()
      {
          $q1 = QuestionFrmPrc31::where('category','Sewa Forklift_none')->where('active',1)->get();
          $qc1 = $q1->count();
          return view('form/form_prc_31_forklift', compact('q1','qc1'));
      }

    public function form_prc_31_cleaning()
      {
          $q1 = QuestionFrmPrc31::where('category','Cleaning Service_Kinerja')->where('active',1)->get();
          $qc1 = $q1->count();
          $q2 = QuestionFrmPrc31::where('category','Cleaning Service_Pelayanan')->where('active',1)->get();
          $qc2 = $q2->count();
          return view('form/form_prc_31_cleaning', compact('q1','qc1','q2','qc2'));
      }

    public function save_form(Request $request)
    {
      $pengisi = new DataPengisi();
    	try {
      $pengisi->form = $request->form_id;
      $pengisi->nama = $request->nama;
      $pengisi->jabatan = $request->jabatan;
      $pengisi->dept = $request->dept;
      $now = DB::raw('NOW()');
      $pengisi->date = $now;
      $pengisi->save();

      $data = DataPengisi::where('nama',$request->nama)->orderBy('date','desc')->first();
      $id_pengisi = $data->id;

      $tipe_jasa = get_string_between($request->form_id, '(', ')');
      $question = QuestionFrmPrc31::where('category','like',$tipe_jasa.'%')->where('active',1)->get();

      foreach ($question as $q)
      {
        $question_id = $q->question_id;
        if ($q->question == 'Saran')
        {
          $remark = $request->saran;
          $value = 0;
        }
        else
        {
          $remark = NULL;
          $value = $request->$question_id;
        }
        $answer = new AnswerFrmPrc31();
        $answer->id_pengisi = $id_pengisi;
  			$answer->question_id = $q->question_id;
  			$answer->nilai = $value;
  			$answer->remark = $remark;
        $now = DB::raw('NOW()');
  			$answer->date = $now;
      	$answer->save();

      }


		    //Alert::success('Success add plant');
		  Session::put('success', 'Your Record addedd successfully.');
    	return redirect('/form');
  		 }
  		catch(\Exception $e)
  		 {return redirect()->back()->with('data',$e->getMessage())->withInput(); }
    }
}
