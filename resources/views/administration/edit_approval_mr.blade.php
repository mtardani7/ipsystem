@extends('layouts.app')

@section('content')
<div class="container">
  <div>
  <label style="font-size:24px;">Edit MR</label>
  </div>

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
  <form class="form-horizontal" method='post' action='{{action('ApprovalHirarkiController@mrupdate',$data->id)}}'>
  	 {{csrf_field()}}
  	 <div class="form-group">
  		<label for="inputEmail3" class="col-sm-2 control-label">Approver</label>
  		<div class="col-sm-4">
        <input type="text" id="approver" name="approver" value="{{$data->approver}}" disabled>
  		</div>
  	 </div>

     <div class="form-group">
     <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
     <div class="col-sm-4">
       <select id='approver_name' name='approver_name' class='form-control' required>
       <option value='{{$data->name}}'>{{$data->name}}&nbsp;</option>
       @foreach ($users as $user)
       <option value='{{$user->name}}'>{{$user->name}}&nbsp;</option>
       @endforeach
       </select>
     </div>
     </div>

  	  <div class="form-group">
  		<div class="col-sm-offset-2 col-sm-10">
  		  <button type="submit" class="btn btn-sm btn-primary">Save</button>
  		</div>
  		<div class="col-sm-offset-2 col-sm-10">
  		  <p style="font-size:10px;padding-top:10px;">* approval final must filled</p>
  		</div>
  	  </div>

  </form>
  </div>

</div>
@endsection
