
@extends('layouts.app')




@section('content')
<div class="container">

@if (Auth::check())
@include('sweet::alert')
<div>
<label style="font-size:24px;">Approval Hirarki</label>
</div>

<a href='{{action('ApprovalHirarkiController@mrindex')}}' class='btn btn-xs btn-default'>Manage MR Approval</a>

<div class="well well-sm">
@if (Session::has('data'))
<div class="alert alert-danger">
  {{ Session::get('data')}}
</div>
@endif


@if ($message = Session::get('success'))
<div class="custom-alerts alert alert-success fade in">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
	{!! $message !!}
</div>
<?php Session::forget('success');?>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form class="form-horizontal" method='post' action='input_user'>
	 {{csrf_field()}}
   <div class="row">
  <div class="col-sm-5">
	 <div class="form-group">
		<label for="inputEmail3" class="col-sm-4 control-label">Username *</label>
		<div class="col-sm-5">
		  <input type="text" class="form-control" id='username' name='username' placeholder="" value="{{ old('username') }}" required>
		</div>
	 </div>
   <div class="form-group">
   <label for="inputEmail3" class="col-sm-4 control-label">User Real Name *</label>
   <div class="col-sm-5">
     <input type="text" class="form-control" id='realname' name='realname' placeholder="" value="{{ old('realname') }}" required>
   </div>
  </div>
  <div class="form-group">
  <label for="inputEmail3" class="col-sm-4 control-label">Email *</label>
  <div class="col-sm-5">
    <input type="email" class="form-control" id='email' name='email' placeholder=""  value="{{ old('email') }}" required>
  </div>
   </div>
   <div class="form-group">
   <label for="inputEmail3" class="col-sm-4 control-label">Password *</label>
   <div class="col-sm-5">
     <input type="password" class="form-control" id='password' name='password' placeholder="" required>
   </div>
  </div>
  <div class="form-group">
  <label for="inputEmail3" class="col-sm-4 control-label">confirm Password *</label>
  <div class="col-sm-5">
    <input type="password" class="form-control" id='password_confirmation' name='password_confirmation' placeholder="" required>
  </div>
  </div>

  </div>

  	<div class="col-sm-5">
      <div class="form-group">
       <label for="inputPassword3" class="col-sm-3 control-label">Role *</label>
       <div class="col-sm-5">
         <select id='role' name='role' class='form-control' required>
         <option value=''>- select -&nbsp;</option>
         <option value='admin'>admin</option>
         <option value='user'>user</option>
         </select>
       </div>
      </div>
      <div class="form-group">
       <label for="inputPassword3" class="col-sm-3 control-label">Level *</label>
       <div class="col-sm-5">
         <select id='level' name='level' class='form-control' required>
         <option value=''>- select -&nbsp;</option>
         <option value='manager'>manager</option>
         <option value='assman'>assman</option>
         <option value='sh'>sh</option>
         <option value='staff'>staff</option>
         </select>
       </div>
      </div>
      <div class="form-group">
       <label for="inputPassword3" class="col-sm-3 control-label">Dept *</label>
       <div class="col-sm-5">
         <select id='dept' name='dept' class='form-control' required>
         <option value=''>- select -&nbsp;</option>
           @foreach($divs as $div)
   				<option value='{{$div['DIVID']}}'>{{$div['DIVID']}} &nbsp;</option>
   				@endforeach
         </select>
       </div>
      </div>
      <div class="form-group">
       <label for="inputPassword3" class="col-sm-3 control-label">Plant *</label>
       <div class="col-sm-5">
         <select id='plant' name='plant' class='form-control' required>
         <option value=''>- select -&nbsp;</option>
           @foreach($plants as $plant)
          <option value='{{$plant['PLANTID']}}'>{{$plant['PLANTID']}} &nbsp;</option>
          @endforeach
         </select>
       </div>
      </div>
    <div class="form-group">
		<div class="col-sm-offset-9 col-sm-10">
		  <button type="submit" class="btn btn-sm btn-primary">Save</button>
		</div>
		<div class="col-sm-offset-9 col-sm-10">
		  <p style="font-size:10px;padding-top:10px;">* must be filled</p>
		</div>
	  </div>
    </div>
</div>
</form>
</div>

<table  class="table table-bordered" id='mt' width='100%' height="" data-toggle="dataTable" data-form="deleteForm">
		<thead>
		<tr >
			<th style="color:white;" bgcolor="#666666" width='40'>Nr.</th>
			<th style="color:white;" bgcolor="#666666" width='150'>Username</th>
			<th style="color:white;" bgcolor="#666666" width='200'>User Real Name</th>
			<th style="color:white;" bgcolor="#666666" width='300'>Email</th>
      <th style="color:white;" bgcolor="#666666" width='150'>Role</th>
      <th style="color:white;" bgcolor="#666666" width='150'>Level</th>
      <th style="color:white;" bgcolor="#666666" width='150'>Dept</th>
      <th style="color:white;" bgcolor="#666666" width='150'>Plant</th>
      <th style="color:white;" bgcolor="#666666" width='350'>Action</th>
		</tr>
		</thead>
		<tbody >


		</tbody>
		</table>


	@else
        <h3>You need to log in. <a href="login">Click here to login</a></h3>
	@endif

</div>

<div class="modal" id="confirm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you, want to delete ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary" id="delete-btn">Delete</button>
                <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>

 $(document).ready(function () {
       $('table[data-form="deleteForm"]').on('click', '.form-delete', function(e){
           e.preventDefault();
           var $form=$(this);
           $('#confirm').modal({ backdrop: 'static', keyboard: false })
                   .on('click', '#delete-btn', function(){
                       $form.submit();
                   });
       });
   });

</script>

@endsection
