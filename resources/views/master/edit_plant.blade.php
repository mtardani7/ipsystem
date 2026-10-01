@extends('layouts.app')
@section('content')

<div class="container">

	<div>
		<label style="font-size:24px;">Edit Plant</label>
	</div>

	<div class="well well-sm">

		@if (Session::has('data'))
		<div class="alert alert-danger">
			{{ Session::get('data')}}
		</div>
		@endif

		<form class="form-horizontal" method='post' action='{{ action('PlantController@update', $id) }}'>
			{{csrf_field()}}
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Plant ID *</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id='plant_id' name='plant_id' value="{{$plant->PLANTID}}" required>
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">Description</label>
				<div class="col-sm-4">
					<textarea class="form-control" rows="3" name="desc" id="desc">{{ $plant->PLANTDESC }}</textarea>
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
@endsection