<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Changelog;
use Session;
use Auth;

class ChangelogController extends Controller
{
    //
    public function index()
      {
          
          $changelogs = \App\Changelog::where('PROGRAM','ipsystem')
                        ->orderBy('UPDATEDATE', 'desc')
                        ->paginate(10);
          return view('changelog/changelog', compact('changelogs'));
      }

    public function add(Request $request)
     {
          $changelog = new Changelog();
          try {
      		$changelog->PROGRAM = 'ipsystem';
      		$changelog->UPDATEDATE = $request->input('date');
          $changelog->TITLE = $request->input('title');
          $changelog->DESCRIPTION = $request->input('desc');
          $changelog->save();
      		//Alert::success('Success add plant');
      		Session::put('success', 'Your Record <b>'.$request->input('title'). '</b> addedd successfully.');
          	return redirect('changelog');
      		 }
      		catch(\Exception $e)
      		 {return redirect()->back()->with('data',$e->getMessage()); }
      }

     public function edit($id)
      {

      		$changelog = Changelog::find($id);

      	   // query builder gunakan first() mengambil hasil jika hanya 1 atau get() mengambil semua hasil
           // $plant = Plant::where('plantid', '=', $plantid )->first();
            return view('changelog/edit_changelog', compact('changelog','id'));

      }

      public function update(Request $request, $id)
        {

            $changelog = Changelog::find($id);
    		try {
            $changelog->UPDATEDATE = $request->input('date');
            $changelog->TITLE = $request->input('title');
            $changelog->DESCRIPTION = $request->input('desc');
            $changelog->save();
            return redirect('/changelog');
    		 }
    		catch(\Exception $e)
    		 {return redirect()->back()->with('data',$e->getMessage()); }
        }

        public function destroy($id)
          {
      		$changelog = Changelog::find($id);
          	$changelog->delete();
          	Session::put('success', 'Your Record <b>'.$changelog->TITLE. '</b> Deleted Successfully.');
          	//notify()->flash('Berhasil menghapus data !', 'success');
      		//Alert::success('Berhasil menghapus data !')->persistent('Confirm');
      		return redirect('/changelog');

          }


}
