<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Masterlist;
use App\Exception\Handler;
use Illuminate\Database\QueryException;
use Session;
use Alert;
use DB;

class MasterListController extends Controller
{
    //
	public function index()
    {

		//$list = \App\Masterlist::orderBy('DOCID')->paginate(3);
		//select all with paginate
	   $list = Masterlist::paginate(3);
	   $divs = \App\Division::orderBy('DIVID')->get();
	   $cats = \App\Category::orderBy('CATID')->get();
	   return view('master/input_list', compact('list','divs','cats'));
    }

	public function add(Request $request)
    {
    	$masterlist = new Masterlist();
    	try {
		$masterlist->DOCID = $request->doc_id;
		$doc_rev = $request->rev1." (". $request->rev.")";
		$masterlist->DOCREV = $doc_rev;
		$masterlist->DOCDESC = $request->desc;
		$remark = addslashes($request->rmk);
		$masterlist->DOCREM = $remark;
		$masterlist->DOCSTATUS = $request->status;
		$masterlist->DIVID = $request->dept_id;
		$masterlist->CATID = $request->cat_id;
		$view = substr("$request->view",9);
		$masterlist->PDFVIEW = $view;
		if (isset($request->optradio))
			{
				if ($request->optradio == 'print')
				$print = str_replace('.pdf','_Print.pdf',$view);
				elseif ($request->optradio == 'same')
				$print = $view;
			}
		else{
		$print = substr("$request->print",9); }
		$masterlist->PDFPRINT = $print;
		$masterlist->SHARESTATUS = $request->share;
		$masterlist->SAVEPERIODE = $request->save;
		$masterlist->SORTMETHODE = $request->sort;
		$masterlist->ELIMINATEMETHODE = $request->elm;
		$masterlist->DISTRIBUTION = $request->dist;
		$masterlist->INPUTBY = $request->user;
		$now = DB::raw('NOW()');
		$masterlist->INPUTDATE = $now;
    	$masterlist->save();
		//Alert::success('Success add plant');
		Session::put('success', 'Your Record <b>'.$masterlist->DOCDESC. '</b> addedd successfully.');
    	return redirect('/input_list');
		 }
		catch(\Exception $e)
		 {return redirect()->back()->with('data',$e->getMessage())->withInput(); }
    }

	public function search( Request $request )
	{
		$divs = \App\Division::orderBy('DIVID')->get();
		$cats = \App\Category::orderBy('CATID')->get();
		$dept_src = $request->get('dept_id');
		$cat_src = $request->get('cat_id');
		//$div = $request->dept_id;
		//$cat = $request->cat_id;
		$lists = \App\Masterlist::where('divid','=', $dept_src)
				->where('catid','=', $cat_src)
				->orderby('DOCID')
				->orderby('DOCREV')
				->get();
		//$name = $request->input( 'name' );
		 return view('master/input_list', compact('lists','divs','cats','dept_src','cat_src'));
	}

	public function edit(Request $request)
	 {
		// $docid = str_replace('-','/',$id);
		$docid = $request->get('docid');
		$docrev = $request->get('docrev');
		 	/*$list = \App\Masterlist::where('DOCID','=', $docid) WIN/1-IT/01
		 					->where('DOCREV','=', $rev)
							->first();*/

			$list = \App\Masterlist::where('DOCID','=',$docid)->where('DOCREV','=', $docrev)->first();

		//$list = DB::connection('mysql3')->table('masterlist')->where('DOCID', $docid)->first();
	//	$pdf = $list->DOCID;

		 $divs = \App\Division::orderBy('DIVID')->get();
	 	$cats = \App\Category::orderBy('CATID')->get();
		 return view('master/edit_list', compact('list','docid','docrev','divs','cats'));

	 }

	 public function update(Request $request)
			{

				$param_docid = $request->input('param_docid');
				$param_docrev = $request->input('param_docrev');
				$docrev = $request->rev1." (". $request->rev.")";
				$list = \App\Masterlist::where('DOCID','=',$param_docid)->where('DOCREV','=', $param_docrev)->first();
				if ($request->print != $list->PDFPRINT)
				{
					$pdf_print = substr("$request->print",9);
				}
				else {
					$pdf_print = $request->print;
				}

				if ($request->view != $list->PDFVIEW)
				{
					$pdf_view = substr("$request->view",9);
				}
				else {
					$pdf_view = $request->view;
				}

			 try {

				$update = [
									'DOCID'    => $request->input('doc_id'),
									'DOCREV'   => $docrev,
									'DOCDESC'   => $request->input('desc'),
									'DOCREM'   => $request->input('rmk'),
									'DOCSTATUS'   => $request->input('status'),
									'DIVID'   => $request->input('dept_id'),
									'CATID'   => $request->input('cat_id'),
									'PDFVIEW'   => $pdf_view,
									'PDFPRINT'   => $pdf_print,
									'SHARESTATUS'   => $request->input('share'),
									'SAVEPERIODE'   => $request->input('save'),
									'SORTMETHODE'   => $request->input('sort'),
									'ELIMINATEMETHODE'   => $request->input('elm'),
									'DISTRIBUTION'   => $request->input('dist'),
									];
			 		DB::connection('mysql3')->table('masterlist')
					 ->where('DOCID', $param_docid)->where('DOCREV', $param_docrev)
					 ->update($update);
					return redirect('/input_list');
			}
		 catch(\Exception $e)
			{return redirect()->back()->with('data',$e->getMessage()); }
			}

  public function destroy(Request $request)
  {
    $param_docid = $request->input('id');
    $param_docrev = $request->input('rev');
    $data = \App\Masterlist::where('DOCID','=',$param_docid)->where('DOCREV','=', $param_docrev)->first();
    $list = \App\Masterlist::where('DOCID','=',$param_docid)->where('DOCREV','=', $param_docrev);
    $list->delete();
    Session::put('success', 'Your Record <b>'.$data->DOCID. '</b> rev <b>'.$data->DOCREV.'</b> Deleted Successfully.');
    //notify()->flash('Berhasil menghapus data !', 'success');
    //Alert::success('Berhasil menghapus data !')->persistent('Confirm');
    return redirect('/input_list');

  }
}
