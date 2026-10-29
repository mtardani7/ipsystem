<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
//use model
use App\Distribution;
use App\Note;
use App\Masterlist;
// end model
use App\Exception\Handler;
use Illuminate\Database\QueryException;
use Session;
use Alert;
use DB;
use File;
use Excel;
Use Division;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$notes = \App\Note::orderBy('INPUTDATE')->paginate(3);
		$dists = Distribution::orderBy('DIVDESC')->get();
        return view('home/home', compact('dists', 'notes'));
    }

	public function viewlist($divid ,$cat)
    {
      $get_masterlist = '1';
      $divid = $divid;
      $catid = $cat;
      $last_cert_id = Masterlist::where ('DOCID','like','CERT/CERTEKS%')->where('DOCREV','like','00%')->orderBy('INPUTDATE','DESC')->first();
      if ($divid == "ALL_JOB_HO")
      {
        $div = \App\Division::select('DIVID')->where('plant','HO')->get();
        $lists = \App\Masterlist::wherein('DIVID',$div)
        ->where('CATID','JOB')
        ->orderBy('DOCID')
        ->orderBy('DOCREV')
        ->get();

      }
      elseif(in_array($divid, array('ALL JOB Plant 1', 'ALL JOB Plant 2', 'ALL JOB Plant 3', 'ALL JOB Plant 4','ALL JOB Plant 5','ALL JOB Plant 6','ALL JOB Plant 7','ALL JOB Plant 8')))
      {
        $plant = substr($divid,8);
        $div = \App\Division::select('DIVID')->where('plant',$plant)->get();
        $lists = \App\Masterlist::wherein('DIVID',$div)
        ->where('CATID','JOB')
        ->orderBy('DOCID')
        ->orderBy('DOCREV')
        ->get();
      }
      elseif($divid == "RPID")
      {
        $lists = \App\Masterlist::where('CATID','SOP')
        ->orderBy('DOCID')
        ->orderBy('DOCREV')
        ->get();
      }
      else {

        $lists = \App\Masterlist::where('DIVID',$divid)
              ->where('CATID',$catid)
              ->orderBy('DOCID')
              ->orderBy('DOCREV')
              ->get();
      }

      // Added by Michael - 26/07/2023
      $buffer = array(); $flag = false;
      foreach ($lists as $key=>$val) {
        $split = explode('/',$val->DOCID);
        if (count($split) >= 3) {
          $flag = true;
          // $split2 = explode('-',$split[1]);
          // $split[1] = str_pad($split2[0],2,'0',STR_PAD_LEFT).'-'.$split2[1];
          $lists[$key]->DOCIDX = $lists[$key]->DOCID;

          if (is_numeric($split[2])) $digit = 3;
          else $digit = 4;

          $lists[$key]->DOCID = $split[0].'/'.$split[1].'/'.str_pad($split[2],$digit,'0',STR_PAD_LEFT);
          array_push($buffer,$lists[$key]);
        }
      }
      if ($flag) {
        asort($buffer);
        $lists = $buffer;
        foreach ($lists as $key=>$val) {
          $lists[$key]->DOCID = $lists[$key]->DOCIDX;
        }
      }
      // echo '<pre>'; var_dump($buffer); die();
      // EoA by Michael - 26/07/2023

		return view('home/viewlist', compact('lists','divid','catid','get_masterlist','last_cert_id'));
    }


	public function viewdoc(Request $request)
    {
		//session()->flush();
		session()->forget('not found');
    	//$notes = \App\Note::orderBy('created_at')->get();
		//$dist = Masterlist::find($request->get('id'));
    $view_type = $request->input('view_type');
    $dist = \App\Masterlist::where('DOCID',$request->input('id'))
            ->where('DOCREV',$request->input('rev'))
            ->first();
     $document_name = $dist->PDFPRINT;
      $document_pdf = $dist->PDFVIEW;
		 $file =  base_path().'/public/files/1/'.$document_name;
         if (file_exists($file)){
		 return view('home/viewdoc', compact('dist','view_type','document_pdf')); }
		 else
		 {

			  Session::put('not found','File Not found on server');
			  return view('home/viewdoc', compact('dist','document_name','view_type'));
		 }
    }

  public function viewvideo(Request $request)
    {
      return view('home/viewvideo');
    }

  public function xls_masterlist_active(Request $request)
  {


    $div = $request->input('diva');
    $cat = $request->input('cata');
    if ($div == "ALL_JOB_HO")
    {
      $divs = \App\Division::select('DIVID')->where('plant','HO')->get();
      $lists = \App\Masterlist::wherein('DIVID',$divs)
      ->where('CATID','JOB')
      ->orderBy('DOCID')
      ->orderBy('DOCREV')
      ->where('DOCSTATUS','active')
      ->get();

    }
    elseif(in_array($div, array('ALL JOB Plant 1', 'ALL JOB Plant 2', 'ALL JOB Plant 3', 'ALL JOB Plant 4','ALL JOB Plant 5')))
    {
      $plant = substr($div,8);
      $divs = \App\Division::select('DIVID')->where('plant',$plant)->get();
      $lists = \App\Masterlist::wherein('DIVID',$divs)
      ->where('CATID','JOB')
      ->orderBy('DOCID')
      ->orderBy('DOCREV')
      ->where('DOCSTATUS','active')
      ->get();
    }
    elseif($div == "RPID")
    {
      $lists = \App\Masterlist::where('CATID','SOP')
      ->orderBy('DOCID')
      ->orderBy('DOCREV')
      ->where('DOCSTATUS','active')
      ->get();
    }
    else {
    $lists =  \App\Masterlist::where('DIVID',$div)
          ->where('CATID',$cat)
          ->where('DOCSTATUS','active')
          ->get();
    }
    Excel::create('Masterlist', function($excel) use($div,$cat,$lists) {
      $excel->sheet($div.' '.$cat.' active', function($sheet) use($div,$cat,$lists) {
          $sheet->row(1, array(
               'No', 'No. Dokumen','No. Revisi','Nama Dokumen','Status','Masa Penyimpanan','Cara Pengurutan','Cara Pemusnahan','Keterangan'
          ));

          //$sheet->setBorder('A1:I1', 'medium');

          $sheet->cell('A1:I1', function($cells) {

              // manipulate the cell
              $cells->setBackground('#009933');
              $cells->setFontSize(14);
              $cells->setFontWeight('bold');
              $cells->setFontColor('#ffffff');
              $cells->setAlignment('center');

          });
          $no=1;
          foreach ($lists as $list)
          {
            $sheet->row($no+1, array(
                $no, $list->DOCID,$list->DOCREV,$list->DOCDESC,$list->DOCSTATUS,$list->SAVEPERIODE,
                $list->SORTMETHODE,$list->ELIMINATEMETHODE,$list->DOCREM
            ));
            $no++;
          }
        });
      })->export('xls');

  }

  public function xlsmasterlist(Request $request)
  {


    $div = $request->input('div');
    $cat = $request->input('cat');
    if ($div == "ALL_JOB_HO")
    {
      $divs = \App\Division::select('DIVID')->where('plant','HO')->get();
      $lists = \App\Masterlist::wherein('DIVID',$divs)
      ->where('CATID','JOB')
      ->orderBy('DOCID')
      ->orderBy('DOCREV')
      ->get();

    }
    elseif(in_array($div, array('ALL JOB Plant 1', 'ALL JOB Plant 2', 'ALL JOB Plant 3', 'ALL JOB Plant 4','ALL JOB Plant 5')))
    {
      $plant = substr($div,8);
      $divs = \App\Division::select('DIVID')->where('plant',$plant)->get();
      $lists = \App\Masterlist::wherein('DIVID',$divs)
      ->where('CATID','JOB')
      ->orderBy('DOCID')
      ->orderBy('DOCREV')
      ->get();
    }
    elseif($div == "RPID")
    {
      $lists = \App\Masterlist::where('CATID','SOP')
      ->orderBy('DOCID')
      ->orderBy('DOCREV')
      ->get();
    }
    else {
    $lists =  \App\Masterlist::where('DIVID',$div)
          ->where('CATID',$cat)
          ->get();
    }
    Excel::create('Masterlist', function($excel) use($div,$cat,$lists) {
      $excel->sheet($div.' '.$cat, function($sheet) use($div,$cat,$lists) {
          $sheet->row(1, array(
               'No', 'No. Dokumen','No. Revisi','Nama Dokumen','Status','Masa Penyimpanan','Cara Pengurutan','Cara Pemusnahan','Keterangan'
          ));

          //$sheet->setBorder('A1:I1', 'medium');

          $sheet->cell('A1:I1', function($cells) {

              // manipulate the cell
              $cells->setBackground('#009933');
              $cells->setFontSize(14);
              $cells->setFontWeight('bold');
              $cells->setFontColor('#ffffff');
              $cells->setAlignment('center');

          });
          $no=1;
          foreach ($lists as $list)
          {
            $sheet->row($no+1, array(
                $no, $list->DOCID,$list->DOCREV,$list->DOCDESC,$list->DOCSTATUS,$list->SAVEPERIODE,
                $list->SORTMETHODE,$list->ELIMINATEMETHODE,$list->DOCREM
            ));
            $no++;
          }
        });
      })->export('xls');

  }

  public function docsearch(Request $request)
    {

      $divid = 'div';
      $catid = 'cat';
      $doc_desc = $request->input('doc_desc');
      $lists = \App\Masterlist::where('DOCDESC','like','%'.$doc_desc.'%')
            ->get();
    return view('home/viewlist', compact('lists','divid','catid','doc_desc'));
    }
	/*old
	public function viewdoc(Request $request)
    {
		$dist = Masterlist::find($request->get('id'));
       $document_name = $dist->pdfprint;
	   // $document_name = 'test.pdf';
         if($document_name){
                $file =  base_path().'/public/'.$document_name;
                if (file_exists($file)){

					/*
                   $ext =File::extension($file);

                    if($ext=='pdf'){
                        $content_types='application/pdf';
                       }elseif ($ext=='doc') {
                         $content_types='application/msword';
                       }elseif ($ext=='docx') {
                         $content_types='application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                       }elseif ($ext=='xls') {
                         $content_types='application/vnd.ms-excel';
                       }elseif ($ext=='xlsx') {
                         $content_types='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                       }elseif ($ext=='txt') {
                         $content_types='application/octet-stream';
                       }
					*/
					//$pdf = file_get_contents($file);
                    /*return response(file_get_contents($file),200)
                           ->header('Content-Type',$content_types);
					return view('home/viewdoc', compact('file','pdf','dist'));

                }else{
				Session::put('not found','File Not found on server');
				return view('home/viewdoc', compact('file','pdf','dist'));
                // exit('Requested file does not exist on our server!');
                }

           }else{
             exit('Invalid Request');
           }
    }
    */
}
