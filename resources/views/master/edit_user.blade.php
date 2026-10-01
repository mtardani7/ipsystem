
@extends('layouts.app')

@section('content')
<div class="container">

@if (Auth::check())
<div>
<label style="font-size:24px;">Edit User</label>
</div>

<div class="well well-sm">
@if (Session::has('data'))
<div class="alert alert-danger">
  {{ Session::get('data')}}
</div>
@endif

<form class="form-horizontal" method='post' action='{{ action('UserController@update', $id) }}'>
	 {{csrf_field()}}
   <div class="row">
  <div class="col-sm-6">
	 <div class="form-group">
		<label for="inputEmail3" class="col-sm-4 control-label">Username *</label>
		<div class="col-sm-6">
		  <input type="text" class="form-control" id='username' name='username' value="{{$user->username}}" required>
		</div>
	 </div>
   <div class="form-group">
   <label for="inputEmail3" class="col-sm-4 control-label">User Real Name *</label>
   <div class="col-sm-6">
     <input type="text" class="form-control" id='realname' name='realname' value="{{$user->name}}" required>
   </div>
  </div>
  <div class="form-group">
  <label for="inputEmail3" class="col-sm-4 control-label">Email *</label>
  <div class="col-sm-6">
    <input type="email" class="form-control" id='email' name='email' value="{{$user->email}}" required>
  </div>
   </div>

  </div>

  	<div class="col-sm-6">
      <div class="form-group">
       <label for="inputPassword3" class="col-sm-3 control-label">Role *</label>
       <div class="col-sm-4">
         <select id='role' name='role' class='form-control'>
         <option value='{{$user->userlevel['role']}}'>{{$user->userlevel['role']}}</option>
         <option value='admin'>admin</option>
         <option value='user'>user</option>
         </select>
       </div>
      </div>
      <div class="form-group">
       <label for="inputPassword3" class="col-sm-3 control-label">Level *</label>
       <div class="col-sm-4">
         <select id='level' name='level' class='form-control'>
         <option value='{{$user->userlevel['level']}}'>{{$user->userlevel['level']}}</option>
         <option value='manager'>manager</option>
         <option value='assman'>assman</option>
         <option value='sh'>sh</option>
         <option value='staff'>staff</option>
         </select>
       </div>
      </div>
      <div class="form-group">
       <label for="inputPassword3" class="col-sm-3 control-label">Dept *</label>
       <div class="col-sm-4">
         <select id='dept' name='dept' class='form-control'>
         <option value='{{$user->userlevel['dept']}}'>{{$user->userlevel['dept']}}</option>
           @foreach($divs as $div)
   				<option value='{{$div['DIVID']}}'>{{$div['DIVID']}} &nbsp;</option>
   				@endforeach
         </select>
       </div>
      </div>
      <div class="form-group">
       <label for="inputPassword3" class="col-sm-3 control-label">Plant *</label>
       <div class="col-sm-4">
         <select id='plant' name='plant' class='form-control'>
         <option value='{{$user->userlevel['plant']}}'>{{$user->userlevel['plant']}}</option>
           @foreach($plants as $plant)
          <option value='{{$plant['PLANTID']}}'>{{$plant['PLANTID']}} &nbsp;</option>
          @endforeach
         </select>
       </div>
      </div>
    <div class="form-group">
		<div class="col-sm-offset-9 col-sm-10">
		  <button type="submit" class="btn btn-sm btn-primary">Save</button>
      <a href='javascript:history.back()' class='btn btn-sm btn-primary' >Cancel</a>
		</div>
		<div class="col-sm-offset-9 col-sm-10">
		  <p style="font-size:10px;padding-top:10px;">* must be filled</p>
		</div>
	  </div>
    </div>
</div>
</form>
</div>



	@else
        <h3>You need to log in. <a href="login">Click here to login</a></h3>
	@endif

</div>

@endsection
