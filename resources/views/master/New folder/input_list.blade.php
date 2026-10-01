@extends('layouts.app')

@section('content')
<div class="container">

	@if (Auth::check())
	@include('sweet::alert')
	<div>
		<label style="font-size:24px;">Input Document List</label>
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
		<form class="form-horizontal" method='post' action='input_list'>
			{{csrf_field()}}
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">File to View *</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="thumbnail1" name="view" placeholder="" readonly required>
						</div>
						<div class="col-sm-2">
							<a id="lfm1" data-input="thumbnail1" data-preview="holder1" class="btn btn-sm btn-warning">
								<i class="fa fa-picture-o"></i> Choose
							</a>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Document ID *</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id='doc_id' name='doc_id' placeholder="" required>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Div / Dept ID *</label>
						<div class="col-sm-4">
							<select id='dept_id' name='dept_id' class='form-control' required>
								<option value=''>- select -&nbsp;</option>

							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-3 control-label">Description</label>
						<div class="col-sm-6">
							<textarea name="desc" id="desc" class="form-control" rows="3"></textarea>
						</div>
					</div>

					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Distribution for</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id='dist' name='dist' placeholder="">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Save Periode</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id='save' name='save' placeholder="">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Eliminate Method</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id='elm' name='elm' placeholder="">
						</div>
					</div>

				</div>

				<div class="col-sm-6">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">File to Print *</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="thumbnail2" name="print" placeholder="" readonly required>
						</div>
						<div class="col-sm-2">
							<a id="lfm2" data-input="thumbnail2" data-preview="holder2" class="btn btn-sm btn-warning">
								<i class="fa fa-picture-o"></i> Choose
							</a>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Revision *</label>
						<div class="col-sm-2">
							<input type="text" class="form-control" id='rev1' name='rev1' placeholder="" value="00">
						</div>
						<div class="col-sm-4">
							<input type="text" class="form-control" id='rev' name='rev' placeholder="dd-mm-yyyy">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Category ID *</label>
						<div class="col-sm-4">
							<select id='cat_id' name='cat_id' class='form-control'>
								<option value=''>- select -&nbsp;</option>

							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-3 control-label">Remark</label>
						<div class="col-sm-6">
							<textarea class="form-control" rows="3" name="rmk" id="rmk"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-3 control-label">Status *</label>
						<div class="col-sm-4">
							<select id='status' name='status' class='form-control'>
								<option value=''>- select -&nbsp;</option>
								<option value='Active'>Active&nbsp;</option>
								<option value='Obsolete'>Obsolete&nbsp;</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Sort Method</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id='sort' name='sort' placeholder="">
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-3 control-label">Share *</label>
						<div class="col-sm-4">
							<select id='share' name='share' class='form-control'>
								<option value='N'>- select -&nbsp;</option>
								<option value='Y'>Y</option>
								<option value='N'>N</option>
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





	@else
	<h3>You need to log in. <a href="login">Click here to login</a></h3>
	@endif

</div>


<script src="{{ asset('vendor/laravel-filemanager/js/lfm.js') }}"></script>
<!--<script>
    {!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/lfm.js')) !!}
  </script>-->
<script>
	var route_prefix = "{{ url(config('lfm.url_prefix', config('lfm.prefix'))) }}";
	$('#lfm1').filemanager('file', {
		prefix: route_prefix
	});
	$('#lfm2').filemanager('file', {
		prefix: route_prefix
	});
</script>

@endsection