@extends('layouts.app')

@section('content')
<div class="container">

	@if (Auth::check())
	@include('sweet::alert')
	<div>
		<label style="font-size:24px;">Edit Category</label>
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
		<form class="form-horizontal" method='post' action='{{ action('CatController@update', $id) }}'>
			{{csrf_field()}}
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Category ID *</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id='cat_id' name='cat_id' value='{{$cat->CATID}}' required>
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">Description</label>
				<div class="col-sm-4">
					<textarea class="form-control" rows="3" name="desc" id="desc" required>{{$cat->CATDESC}}</textarea>
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