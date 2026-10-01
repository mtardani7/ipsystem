@extends('layouts.app')

@section('content')
<div class="container">

	@if (Auth::check())
	<div>
		<label style="font-size:24px;">Edit Distribution</label>
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
		<?php Session::forget('success'); ?>
		@endif
		<form class="form-horizontal" method='post' action='{{ action('DistController@update', $id) }}'>
			{{csrf_field()}}

			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Division</label>
				<div class="col-sm-4">
					<input type="input" value="{{$dist->DIVID}}" id="div" name="div" disabled>
					<input type="hidden" value="{{$dist->DIVDIST}}" id="divid" name="divid">
				</div>
			</div>

			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Distribution</label>
				<div class="col-sm-4">
					<input type="checkbox" id="qm" name="qm" value="QM" {{ ($dist->QM==1) ? 'checked' : '' }}> QM<br>
					<input type="checkbox" id="jd" name="jd" value="JOB" {{ ($dist->JOB==1) ? 'checked' : '' }}> Job Desc<br>
					<input type="checkbox" id="sop" name="sop" value="SOP" {{ ($dist->SOP==1) ? 'checked' : '' }}> Standard Operating Procedure (SOP)<br>
					<input type="checkbox" id="wi" name="wi" value="WI" {{ ($dist->WI==1) ? 'checked' : '' }}> Work Instruction (WI)<br>
					<input type="checkbox" id="form" name="form" value="FORM" {{ ($dist->FORM==1) ? 'checked' : '' }}> Form<br>
					<input type="checkbox" id="guidelines" name="guidelines" value="GUIDELINES" {{ ($dist->GUIDELINES==1) ? 'checked' : '' }}> Guidelines<br>
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
	@else
	<h3>You need to log in. <a href="login">Click here to login</a></h3>
	@endif

</div>


@endsection