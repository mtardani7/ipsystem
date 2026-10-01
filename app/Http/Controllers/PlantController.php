<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Plant;
use App\Exception\Handler;
use Illuminate\Database\QueryException;
use Session;
use Alert;

class PlantController extends Controller
{
    //
	public function index()
    {
        $plants = \App\Plant::orderBy('PLANTID')->paginate(10);
        return view('master/input_plant', compact('plants'));
    }

	public function add(Request $request)
    {
    	$plant = new Plant();
    	try {
		$plant->PLANTID = $request->plant_id;
		$plant->PLANTDESC = $request->desc;
    	$plant->save();
		//Alert::success('Success add plant');
		Session::put('success', 'Your Record <b>'.$plant->PLANTID. '</b> addedd successfully.');
    	return redirect('/input_plant');
		 }
		catch(\Exception $e)
		 {return redirect()->back()->with('data',$e->getMessage())->withInput(); }
    }

	public function edit($id)
    {

		$plant = Plant::find($id);

	// query builder gunakan first() mengambil hasil jika hanya 1 atau get() mengambil semua hasil
       // $plant = Plant::where('plantid', '=', $plantid )->first();
        return view('master/edit_plant', compact('plant','id'));

    }

	public function update(Request $request, $id)
    {

        $plant = Plant::find($id);
		try {
        $plant->PLANTID = $request->input('plant_id');
        $plant->PLANTDESC = $request->input('desc');
        $plant->save();
        return redirect('/input_plant');
		 }
		catch(\Exception $e)
		 {return redirect()->back()->with('data',$e->getMessage()); }
    }

	public function destroy($id)
    {
		$plant = Plant::find($id);
    	$plant->delete();
    	Session::put('success', 'Your Record <b>'.$plant->PLANTID. '</b> Deleted Successfully.');
    	//notify()->flash('Berhasil menghapus data !', 'success');
		//Alert::success('Berhasil menghapus data !')->persistent('Confirm');
		return redirect('/input_plant');

    }
}
