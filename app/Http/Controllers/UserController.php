<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserLevel;
use App\Division;
use App\Plant;
use Session;
use Auth;

class UserController extends Controller
{
    //

    public function index()
      {

  		//$list = \App\Masterlist::orderBy('DOCID')->paginate(3);
  		//select all with paginate
  	   $users = \App\User::orderBy('username')->paginate(10);
       $divs = \App\Division::orderBy('DIVID')->get();
       $plants = \App\Plant::orderBy('PLANTID')->get();
  	   return view('master/input_user', compact('users','divs','plants'));
      }

      public function add(Request $request)
        {

          $this->validate($request, [
              'username' => 'required|min:2|max:50',
              'email' => 'email',
              'password' => 'required|confirmed|min:3',
          ]);


        	$user = new User();
          $userlevel = new UserLevel();
        try {
        $input_username = $request->input('username');
    		$user->username =  $input_username;
    		$user->name =  $request->input('realname');
        $user->email =  $request->input('email');
        $user->password =  bcrypt($request->input('password'));
        $user->save();
        $users = \App\User::where('username',$input_username)->first();
        $userlevel->userid = $users['id'];
        $userlevel->role = $request->input('role');
        $userlevel->level = $request->input('level');
        $userlevel->dept = $request->input('dept');
        $userlevel->plant = $request->input('plant');
        $userlevel->save();
    		//Alert::success('Success add plant');
    		Session::put('success', 'Your Record <b>'.$user->username. '</b> addedd successfully.');
        	return redirect('/input_user');
    		 }
    		catch(\Exception $e)
    		 {return redirect()->back()->with('data',$e->getMessage()); }
       }

      public function edit($id)
       {

         $user = User::find($id);
         $divs = \App\Division::orderBy('DIVID')->get();
         $plants = \App\Plant::orderBy('PLANTID')->get();
         return view('master/edit_user', compact('user','id','divs','plants'));

       }

       public function update(Request $request, $id)
         {

             $user = User::find($id);
             $userlevel = UserLevel::find($id);
     		try {
            $input_username = $request->input('username');
            $user->username =  $input_username;
            $user->name =  $request->input('realname');
            $user->email =  $request->input('email');
            $user->save();
            $userlevel->role = $request->input('role');
            $userlevel->level = $request->input('level');
            $userlevel->dept = $request->input('dept');
            $userlevel->plant = $request->input('plant');
            $userlevel->save();
            return redirect('/input_user');
     		 }
     		catch(\Exception $e)
     		 {return redirect()->back()->with('data',$e->getMessage()); }
         }

      public function resetpwd($id)
      {

        $user = User::find($id);
        return view('master/resetpwd', compact('user','id'));

      }

      public function updatepwd(Request $request, $id)
      {
        $user = User::find($id);
        try {
            $user->password =  bcrypt($request->input('password'));
            $user->save();
            Session::put('success', 'Password for user <b>'.$user->username. '</b> changed successfully.');
            return redirect('/input_user');
         }
        catch(\Exception $e)
         {return redirect()->back()->with('data',$e->getMessage()); }

      }

      public function changepwd()
      {
        $current_user = Auth::user()->name;
        $user = User::where('name',$current_user)->first();
        return view('master/changepwd', compact('user'));

      }

      public function updatechpwd(Request $request)
      {
        $user = User::find($request->input('userid'));
        try {
            $user->password =  bcrypt($request->input('password'));
            $user->save();
            Session::put('success', 'Password for user <b>'.$user->username. '</b> changed successfully.');
            return redirect('/home');
         }
        catch(\Exception $e)
         {return redirect()->back()->with('data',$e->getMessage()); }

      }

      public function destroy($id)
        {
    		$User = User::find($id);
        $userlevel = UserLevel::find($id);
        	$User->delete();
          $userlevel->delete();
        	Session::put('success', 'Your Record <b>'.$User->username. '</b> Deleted Successfully.');
        	//notify()->flash('Berhasil menghapus data !', 'success');
    		//Alert::success('Berhasil menghapus data !')->persistent('Confirm');
    		return redirect('/input_user');

        }

}
