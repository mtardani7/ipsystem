<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Division;
use App\Plant;
use App\Distribution;
use App\Exception\Handler;
use Illuminate\Database\QueryException;
use Session;
use Alert;

class DivController extends Controller
{
    //
	public function index()
    {
    $divs = \App\Division::orderBy('DIVID')->paginate(10);
		$plants = \App\Plant::orderBy('PLANTID')->get();
        return view('master/input_div', compact('divs','plants'));
    }

	public function add(Request $request)
    {
			$divs = \App\Division::orderBy('DIVID')->paginate(10);
			$plants = \App\Plant::orderBy('PLANTID')->get();
    	$div = new Division();
    	try {
			$div->NUMBER = $request->div_no;
			$div->DIVNO = $request->div_no;
			$div->DIVID = $request->div_id;
			$div->DIVDESC = $request->desc;
			$div->PLANT = $request->plant;
    	$div->save();
		//Alert::success('Success add plant');
		Session::put('success', 'Your Record <b>'.$div->DIVID. '</b> addedd successfully.');
    	return redirect('/input_div')->with('plants','divs');
		 }
		catch(\Exception $e)
		 {return redirect()->back()->with('data',$e->getMessage())->withInput(); }
    }

	public function edit($id)
    {

		$div = Division::find($id);
		$plants = \App\Plant::orderBy('PLANTID')->get();
	// query builder gunakan first() mengambil hasil jika hanya 1 atau get() mengambil semua hasil
       // $plant = Plant::where('plantid', '=', $plantid )->first();
        return view('master/edit_div', compact('div','plants','id'));

    }

	public function update(Request $request, $id)
    {
				$divs = \App\Division::orderBy('DIVID')->paginate(10);
				$plants = \App\Plant::orderBy('PLANTID')->get();

        $div = Division::find($id);
				$div->NUMBER = $request->get('div_no');
				$div->DIVNO = $request->get('div_no');
				$div->DIVID = $request->get('div_id');
				$div->DIVDESC = $request->get('desc');
				$div->PLANT = $request->get('plant');
		    $div->save();

				/*
				$dist = Distribution::find($id);
				$dist->NO = $request->get('div_no');
				$dist->DIVDIST = $request->get('div_no');
				$dist->DIVID = $request->get('div_id');
				$dist->DIVDESC = $request->get('desc');
				$dist->save();
				*/
        return redirect('/input_div')->with('plants','divs');
		 }


	public function destroy($id)
    {
		$div = Division::find($id);
		$dist = Distribution::find($id);
    	$div->delete();
			$dist->delete();
    	Session::put('success', 'Your Record <b>'.$div->DIVID. '</b> Deleted Successfully.');
    	//notify()->flash('Berhasil menghapus data !', 'success');
		//Alert::success('Berhasil menghapus data !')->persistent('Confirm');
		return redirect('/input_div');

    }
}
