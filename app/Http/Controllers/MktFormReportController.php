<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QuestionFrmSales9a;
use App\QuestionFrmSales9b;
use App\DataPengisiPub;
use App\AnswerFrmSales9a;
use Auth;
use Excel;
use DB;

class MktFormReportController extends Controller
{
    //
    public function index()
      {
          return view('administration/mkt_form_report/MktReport');
      }
    public function report_form_sales_9a()
      {
        $pengisi = DataPengisiPub::where('form','FRM_MKT-9a')->orderBy('date')->paginate(15);
        return view('administration/mkt_form_report/report_frm_sales_9a', compact('pengisi'));
      }
    public function report_form_sales_9b()
      {
        $pengisi = DataPengisiPub::where('form','FRM_MKT-9b')->orderBy('date')->paginate(15);
        return view('administration/mkt_form_report/report_frm_sales_9b', compact('pengisi'));
      }
    public function get_xls_FormMkt_9a(Request $request)
      {
          $q =  QuestionFrmSales9a::where('active',1)->get();

          Excel::create('Form Sales 9a', function($excel) use($q,$request) {
            $excel->sheet('Form Sales 9a', function($sheet) use($q,$request) {
              $sheet->mergeCells('A1:G1');
              $sheet->row(1, array('Questionnaire Customer Satisfaction'));
              $sheet->cell('A1:Z1', function($cells) {

                // manipulate the cell
                $cells->setFontSize(14);
                $cells->setFontWeight('bold');
                $cells->setAlignment('center');

              });

              $sheet->mergeCells('A3:A4');
              $sheet->mergeCells('B3:B4');
              $sheet->mergeCells('C3:C4');
              $sheet->mergeCells('D3:D4');

              $sheet->row(3, array('Category','Question','value','Remarks'));

              $sheet->cell('A3:G4', function($cells) {

                // manipulate the cell
                $cells->setFontSize(12);
                $cells->setFontWeight('bold');
                $cells->setAlignment('center');
                $cells->setValignment('center');

              });
              $form_id = $request->input('form_id');
              //query master question
              $cat = DB::connection('mysql4')->table('master_question_eng')->select('category')->distinct()->orderBy('id')->get();
              //query master answer
              $val = AnswerFrmSales9a::where('form_id',$form_id)->get();
              $row = 5;
              foreach ($cat as $data)
              {
                //query untuk menghitung total question dalam sebuah category untuk merge cell
                $q1 = DB::connection('mysql4')->table('master_question_eng')->where('category',$data->category)->get();
                $qc1 = $q1->count();
              $merge_bot = $row+$qc1-1;
              $sheet->mergeCells('A'.$row.':A'.$merge_bot);
              //jika category describe dan feedback tidak di export
              if ($data->category != 'describe' && $data->category != 'feedback' && $data->category != 'question')
              {
              //export category question ke excel
              $sheet->row($row, array($data->category));

              $row_q = $row;
                foreach ($q1 as $question)
                {
                  //export question ke excel
                  $sheet->cell('B'.$row_q, function($cell) use($question) {
                      $cell->setValue($question->question);
                  });
                  //export nilai question ke excel dengan mencari nilai hasil query $val dgn cara menyamakan dengan question_id
                  $sheet->cell('C'.$row_q, function($cell) use($question,$form_id,$val) {

                      foreach ($val as $nilai)
                      {
                        if ($nilai->question_id==$question->question_id)
                        $hasil = $nilai->nilai;
                      }
                      //dd($hasil);
                     $cell->setValue($hasil);
                  });
                  //export remark ke excel
                  $sheet->cell('D'.$row_q, function($cell) use($question,$form_id,$val) {

                      foreach ($val as $nilai)
                      {
                        if ($nilai->question_id==$question->question_id)
                        $hasil = $nilai->remark;
                      }
                      //dd($hasil) utk melihal hasil query;
                     $cell->setValue($hasil);
                  });
                  $row_q++;
                }
              $row = $merge_bot+1;
              }
              else {

              $rowd = $row+2;

                foreach ($q1 as $question)
                {
                  $sheet->cell('A'.$rowd, function($cell) use($question) {
                    $cell->setValue($question->question);
                });
                $sheet->cell('B'.$rowd, function($cell) use($question,$form_id,$val) {

                    foreach ($val as $nilai)
                    {
                      if ($nilai->question_id==$question->question_id)
                      $hasil = $nilai->remark;
                    }
                    //dd($hasil);
                   $cell->setValue($hasil);
                });
                }

              $row = $merge_bot+1;
              }
              }

              $pengisi = DataPengisiPub::where('form_id',$form_id)->first();

              $sheet->cell('A'.($row+3), function($cell) use($pengisi) {
                  $cell->setValue('Name :');
              });

              $sheet->cell('B'.($row+3), function($cell) use($pengisi) {
                  $cell->setValue($pengisi->name);
              });

              $sheet->cell('A'.($row+4), function($cell) use($pengisi) {
                  $cell->setValue('Department :');
              });

              $sheet->cell('B'.($row+4), function($cell) use($pengisi) {
                  $cell->setValue($pengisi->dept);
              });

              $sheet->cell('A'.($row+5), function($cell) use($pengisi) {
                  $cell->setValue('Company :');
              });

              $sheet->cell('B'.($row+5), function($cell) use($pengisi) {
                  $cell->setValue($pengisi->customer);
              });

              $sheet->cell('A5:G80', function($cells) {

                // manipulate the cell
                $cells->setFontSize(11);
                $cells->setValignment('center');

              });

              $sheet->setWidth(array(
                  'A'     =>  30,
                  'B'     =>  50
              ));



            });
          })->export('xls');
      }
    public function get_xls_FormMkt_9b(Request $request)
        {
            $q =  QuestionFrmSales9b::where('active',1)->get();

            Excel::create('Form Sales 9b', function($excel) use($q,$request) {
              $excel->sheet('Form Sales 9b', function($sheet) use($q,$request) {
                $sheet->mergeCells('A1:G1');
                $sheet->row(1, array('Kuesioner Kepuasan Pelanggan'));
                $sheet->cell('A1:Z1', function($cells) {

                  // manipulate the cell
                  $cells->setFontSize(14);
                  $cells->setFontWeight('bold');
                  $cells->setAlignment('center');

                });

                $sheet->mergeCells('A3:A4');
                $sheet->mergeCells('B3:B4');
                $sheet->mergeCells('C3:C4');
                $sheet->mergeCells('D3:D4');

                $sheet->row(3, array('Category','Question','value','Remarks'));

                $sheet->cell('A3:G4', function($cells) {

                  // manipulate the cell
                  $cells->setFontSize(12);
                  $cells->setFontWeight('bold');
                  $cells->setAlignment('center');
                  $cells->setValignment('center');

                });
                $form_id = $request->input('form_id');
                //query master question
                $cat = DB::connection('mysql4')->table('master_question_bhs')->select('category')->distinct()->orderBy('id')->get();
                //query master answer
                $val = AnswerFrmSales9a::where('form_id',$form_id)->get();
                $row = 5;
                foreach ($cat as $data)
                {
                  //query untuk menghitung total question dalam sebuah category untuk merge cell
                  $q1 = DB::connection('mysql4')->table('master_question_bhs')->where('category',$data->category)->get();
                  $qc1 = $q1->count();
                $merge_bot = $row+$qc1-1;
                $sheet->mergeCells('A'.$row.':A'.$merge_bot);
                //jika category describe dan feedback tidak di export
                if ($data->category != 'jelaskan' && $data->category != 'saran' && $data->category != 'pertanyaan')
                {
                //export category question ke excel
                $sheet->row($row, array($data->category));

                $row_q = $row;
                  foreach ($q1 as $question)
                  {
                    //export question ke excel
                    $sheet->cell('B'.$row_q, function($cell) use($question) {
                        $cell->setValue($question->question);
                    });
                    //export nilai question ke excel dengan mencari nilai hasil query $val dgn cara menyamakan dengan question_id
                    $sheet->cell('C'.$row_q, function($cell) use($question,$form_id,$val) {

                        foreach ($val as $nilai)
                        {
                          if ($nilai->question_id==$question->question_id)
                          $hasil = $nilai->nilai;
                        }
                        //dd($hasil);
                       $cell->setValue($hasil);
                    });
                    //export remark ke excel
                    $sheet->cell('D'.$row_q, function($cell) use($question,$form_id,$val) {

                        foreach ($val as $nilai)
                        {
                          if ($nilai->question_id==$question->question_id)
                          $hasil = $nilai->remark;
                        }
                        //dd($hasil) utk melihal hasil query;
                       $cell->setValue($hasil);
                    });
                    $row_q++;
                  }
                $row = $merge_bot+1;
                }
                else {

                $rowd = $row+2;

                  foreach ($q1 as $question)
                  {
                    $sheet->cell('A'.$rowd, function($cell) use($question) {
                      $cell->setValue($question->question);
                  });
                  $sheet->cell('B'.$rowd, function($cell) use($question,$form_id,$val) {

                      foreach ($val as $nilai)
                      {
                        if ($nilai->question_id==$question->question_id)
                        $hasil = $nilai->remark;
                      }
                      //dd($hasil);
                     $cell->setValue($hasil);
                  });
                  }

                $row = $merge_bot+1;
                }
                }

                $pengisi = DataPengisiPub::where('form_id',$form_id)->first();

                $sheet->cell('A'.($row+3), function($cell) use($pengisi) {
                    $cell->setValue('Nama :');
                });
                $sheet->cell('B'.($row+3), function($cell) use($pengisi) {
                    $cell->setValue($pengisi->name);
                });
                $sheet->cell('A'.($row+4), function($cell) use($pengisi) {
                    $cell->setValue('Departmen :');
                });
                $sheet->cell('B'.($row+4), function($cell) use($pengisi) {
                    $cell->setValue($pengisi->dept);
                });

                $sheet->cell('A'.($row+5), function($cell) use($pengisi) {
                    $cell->setValue('Perusahaan :');
                });

                $sheet->cell('B'.($row+5), function($cell) use($pengisi) {
                    $cell->setValue($pengisi->customer);
                });

                $sheet->cell('A5:G80', function($cells) {

                  // manipulate the cell
                  $cells->setFontSize(11);
                  $cells->setValignment('center');

                });

                $sheet->setWidth(array(
                    'A'     =>  30,
                    'B'     =>  50
                ));



              });
            })->export('xls');
         }
}
