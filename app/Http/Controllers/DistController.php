<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Distribution;
use Session;

class DistController extends Controller
{
    //
    public function index()
      {
      $divs = \App\Division::orderBy('DIVID')->get();
      $dists = \App\Distribution::orderBy('DIVID')->paginate(10);
      return view('master/input_dist', compact('divs','dists'));
      }

  	public function add(Request $request)
      {
        $divs = \App\Division::where('DIVID',$request->input('div'))->first();
        if ($request->input('qm')!= null) $qm = 1; else $qm = 0;
    		if ($request->input('jd')!= null) $jd = 1; else $jd = 0;
    		if ($request->input('sop')!= null) $sop = 1; else $sop = 0;
    		if ($request->input('wi')!= null) $wi = 1; else $wi = 0;
    		if ($request->input('form')!= null) $form = 1; else $form = 0;
		if ($request->input('guidelines')!= null) $guidelines = 1; else $guidelines = 0;

      	$dist = new Distribution();
      	try {
  			$dist->NO = $divs->DIVNO;
  			$dist->DIVNO = '0';
  			$dist->DIVDIST = $divs->DIVNO;
        $dist->DIVID = $divs->DIVID;
  			$dist->DIVDESC = $divs->DIVDESC;
        $dist->QM = $qm;
        $dist->JOB = $jd;
        $dist->SOP = $sop;
        $dist->WI = $wi;
        $dist->FORM = $form;
	$dist->GUIDELINES = $guidelines;
      	$dist->save();
  		//Alert::success('Success add plant');

        $divs = \App\Division::orderBy('DIVID')->get();
        $dists = \App\Distribution::orderBy('DIVID')->paginate(10);
  		Session::put('success', 'Your Record <b>'.$dist->DIVID. '</b> addedd successfully.');
      	return redirect('/input_dist');
  		 }
  		catch(\Exception $e)
  		 {return redirect()->back()->with('data',$e->getMessage())->withInput(); }
      }

    public function edit($id)
      {
        $divs = \App\Division::orderBy('DIVID')->get();
        $dist = Distribution::find($id);
        return view('master/edit_dist', compact('dist','divs','id'));
      }

    public function update(Request $request, $id)
    {
      if ($request->input('qm')!= null) $qm = 1; else $qm = 0;
      if ($request->input('jd')!= null) $jd = 1; else $jd = 0;
      if ($request->input('sop')!= null) $sop = 1; else $sop = 0;
      if ($request->input('wi')!= null) $wi = 1; else $wi = 0;
      if ($request->input('form')!= null) $form = 1; else $form = 0;
      if ($request->input('guidelines')!= null) $guidelines = 1; else $guidelines = 0;
      $dist = Distribution::find($id);
      try{
        $dist->QM = $qm;
        $dist->JOB = $jd;
        $dist->SOP = $sop;
        $dist->WI = $wi;
        $dist->FORM = $form;
        $dist->GUIDELINES = $guidelines;
      	$dist->save();
        return redirect('/input_dist');
      }
      catch(\Exception $e)
      {return redirect()->back()->with('data',$e->getMessage()); }
    }

    public function destroy($id)
    {
      $dist = Distribution::find($id);
      $dist->delete();
      session::put('success','Your Record <b>'.$dist->DIVID. '</b> Deleted Successfully.');
      return redirect('input_dist');
    }
}
