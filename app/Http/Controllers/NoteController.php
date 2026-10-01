<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Note;
use Session;
use DB;

class NoteController extends Controller
{
    //
    public function index()
      {
          $notes = \App\Note::orderBy('INPUTDATE')->paginate(10);
          return view('master/input_note', compact('notes'));
      }
    public function add(Request $request)
        {
        	$note = new Note();
        	try {
        $now = DB::raw('NOW()');
    		$note->SUBJECT = $request->subject;
    		$note->DESCRIPTION = $request->desc;
        $note->PIC = $request->pic;
        $note->INPUTDATE = $now;
        $note->SHARESTATUS = $request->show;
        $note->INPUTBY = $request->user;
        $note->save();
    		//Alert::success('Success add plant');
    		Session::put('success', 'Your Record <b>'.$note->SUBJECT. '</b> addedd successfully.');
        	return redirect('/notes');
    		 }
    		catch(\Exception $e)
    		 {return redirect()->back()->with('data',$e->getMessage()); }
        }

    	public function edit($id)
        {

    		$note = Note::find($id);

    	// query builder gunakan first() mengambil hasil jika hanya 1 atau get() mengambil semua hasil
           // $plant = Plant::where('plantid', '=', $plantid )->first();
            return view('master/edit_note', compact('note','id'));

        }

    	public function update(Request $request, $id)
        {

            $note = Note::find($id);
    		try {
            $note->SUBJECT = $request->subject;
            $note->DESCRIPTION = $request->desc;
            $note->PIC = $request->pic;
            $note->SHARESTATUS = $request->show;
            $note->INPUTBY = $request->user;
            $note->save();
            return redirect('/notes');
    		 }
    		catch(\Exception $e)
    		 {return redirect()->back()->with('data',$e->getMessage()); }
        }

    	public function destroy($id)
        {
    		$note = Note::find($id);
        	$note->delete();
        	Session::put('success', 'Your Record <b>'.$note->SUBJECT. '</b> Deleted Successfully.');
        	//notify()->flash('Berhasil menghapus data !', 'success');
    		//Alert::success('Berhasil menghapus data !')->persistent('Confirm');
    		return redirect('/notes');

        }


}
