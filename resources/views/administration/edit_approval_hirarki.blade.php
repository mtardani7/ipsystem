@extends('layouts.app')

@section('content')
<div class="container">
  <div>
  <label style="font-size:24px;">Approval Hirarki</label>
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
  <form class="form-horizontal" method='post' action='{{action('ApprovalHirarkiController@update',$data->id)}}'>
  	 {{csrf_field()}}
  	 <div class="form-group">
  		<label for="inputEmail3" class="col-sm-2 control-label">Dept</label>
  		<div class="col-sm-4">
        <select id='dept' name='dept' class='form-control' required>
        <option value='{{$data->dept}}'>{{$data->dept}}&nbsp;</option>
        @foreach ($divs as $div)
        <option value='{{$div->DIVID}}'>{{$div->DIVID}}&nbsp;</option>
        @endforeach
        </select>
  		</div>
  	 </div>

     <div class="form-group">
     <label for="inputEmail3" class="col-sm-2 control-label">Plant</label>
     <div class="col-sm-4">
     <select id='plant' name='plant' class='form-control' required>
     <option value='{{$data->plant}}'>{{$data->plant}}&nbsp;</option>
     @foreach ($plants as $plant)
     <option value='{{$plant->PLANTID}}'>{{$plant->PLANTID}}&nbsp;</option>
     @endforeach
     </select>
     </div>
     </div>

     <div class="form-group">
     <label for="inputEmail3" class="col-sm-2 control-label">Approval 1</label>
     <div class="col-sm-4">
       <select id='approval1' name='approval1' class='form-control'>
       <option value='{{$data->approval1}}'>{{$data->approval1}}&nbsp;</option>
       <option value=''>NULL&nbsp;</option>
       @foreach ($users as $user)
       <option value='{{$user->name}}'>{{$user->name}}&nbsp;</option>
       @endforeach
       </select>
     </div>
     </div>

     <div class="form-group">
     <label for="inputEmail3" class="col-sm-2 control-label">Approval 2</label>
     <div class="col-sm-4">
       <select id='approval2' name='approval2' class='form-control'>
       <option value='{{$data->approval2}}'>{{$data->approval2}}&nbsp;</option>
       <option value=''>NULL&nbsp;</option>
       @foreach ($users as $user)
       <option value='{{$user->name}}'>{{$user->name}}&nbsp;</option>
       @endforeach
       </select>
     </div>
     </div>

     <div class="form-group">
     <label for="inputEmail3" class="col-sm-2 control-label">Approval Final</label>
     <div class="col-sm-4">
       <select id='approval_final' name='approval_final' class='form-control' required>
       <option value='{{$data->approval_final}}'>{{$data->approval_final}}&nbsp;</option>
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
