@extends('layouts.app')

@section('content')
<div class="container">

  @if (Auth::check())
  <div>
    <label style="font-size:24px;">Reset Password for user '{{$user->username}}'</label>
  </div>


  <div class="well well-sm">

    <form class="form-horizontal" method='post' action='{{ action('UserController@updatepwd', $id) }}'>
      {{csrf_field()}}


      <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">New Password *</label>
        <div class="col-sm-4">
          <input type="password" class="form-control" id='password' name='password' placeholder="" required>
        </div>
      </div>
      <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">confirm Password *</label>
        <div class="col-sm-4">
          <input type="password" class="form-control" id='password_confirmation' name='password_confirmation' placeholder="" required>
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-sm btn-primary">Save</button>
          <a href='javascript:history.back()' class='btn btn-sm btn-primary'>Cancel</a>
        </div>
        <div class="col-sm-offset-2 col-sm-10">
          <p style="font-size:10px;padding-top:10px;">* must be filled</p>
        </div>
      </div>
    </form>
  </div>
</div>

@else
<h3>You need to log in. <a href="login">Click here to login</a></h3>
@endif

</div>

@endsection