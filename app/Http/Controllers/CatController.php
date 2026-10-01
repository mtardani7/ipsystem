<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Category;
use App\Exception\Handler;
use Illuminate\Database\QueryException;
use Session;
use Alert;

class CatController extends Controller
{
    //
	public function index()
    {
        $cats = \App\Category::orderBy('CATID')->paginate(10);
        return view('master/input_cat', compact('cats'));
    }

	public function add(Request $request)
    {
    	$cat = new Category();
    	try {
		$cat->CATID = $request->cat_id;
		$cat->CATDESC = $request->desc;
    	$cat->save();
		//Alert::success('Success add plant');
		Session::put('success', 'Your Record <b>'.$cat->CATID. '</b> addedd successfully.');
    	return redirect('/input_cat');
		 }
		catch(\Exception $e)
		 {return redirect()->back()->with('data',$e->getMessage())->withInput(); }
    }

	public function edit($id)
    {

		$cat = Category::find($id);
	// query builder gunakan first() mengambil hasil jika hanya 1 atau get() mengambil semua hasil
       // $plant = Plant::where('plantid', '=', $plantid )->first();
        return view('master/edit_cat', compact('cat','id'));

    }

	public function update(Request $request, $id)
    {

        $cat = Category::find($id);
		try {
				$cat->CATID = $request->get('cat_id');
				$cat->CATDESC = $request->get('desc');
        $cat->save();
        return redirect('/input_cat');
		 }
		catch(\Exception $e)
		 {return redirect()->back()->with('data',$e->getMessage()); }
    }

	public function destroy($id)
    {
		$cat = Category::find($id);
    	$cat->delete();
    	Session::put('success', 'Your Record <b>'.$cat->CATID. '</b> Deleted Successfully.');
    	//notify()->flash('Berhasil menghapus data !', 'success');
		//Alert::success('Berhasil menghapus data !')->persistent('Confirm');
		return redirect('/input_cat');

    }
}
