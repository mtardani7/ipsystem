@extends('layouts.app')

@section('content')

<script>
	function find_list() {
		var dept_id = $("#dept_id_src").val();
		var cat_id = $("#cat_src").val();

		$.ajax({
			type: "GET",
			url: "/search_list",
			success: function(data) {
				$("#result_search_list").html(data);
			},
			error: function(msg) {
				alert(msg);
			}
		});
	}
</script>

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
		<form class="form-horizontal" method='post' action='{{ action('MasterListController@update') }}'>
			{{csrf_field()}}
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">File to View *</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="thumbnail1" name="view" placeholder="" readonly value="{{$list->PDFVIEW}}">
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
							<input type="text" class="form-control" id='doc_id' name='doc_id' placeholder="" value="{{$list->DOCID}}" required>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Div / Dept ID *</label>
						<div class="col-sm-4">
							<select id='dept_id' name='dept_id' class='form-control' required>
								<option value='{{$list->DIVID}}'>{{$list->DIVID}}</option>
								@foreach($divs as $div)
								<option value='{{$div['DIVID']}}'>{{$div['DIVID']}} &nbsp;</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-3 control-label">Description</label>
						<div class="col-sm-6">
							<textarea name="desc" id="desc" class="form-control" rows="3">{{$list->DOCDESC}}</textarea>
						</div>
					</div>

					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Distribution for</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id='dist' name='dist' placeholder="" value="{{$list->DISTRIBUTION}}">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Save Periode</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id='save' name='save' placeholder="" value="{{$list->SAVEPERIODE}}">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Eliminate Method</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id='elm' name='elm' placeholder="" value="{{$list->ELIMINATEMETHODE}}">
						</div>
					</div>

				</div>

				<div class="col-sm-6">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">File to Print *</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="thumbnail2" name="print" placeholder="" readonly value="{{$list->PDFPRINT}}" required>
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
							<input type="text" class="form-control" id='rev1' name='rev1' placeholder="" value="{{substr("$list->DOCREV",0,2)}}">
						</div>
						<div class="col-sm-4">
							<input type="text" class="form-control" id='rev' name='rev' placeholder="dd-mm-yyyy" required value="{{substr("$list->DOCREV",4,10)}}">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Category ID *</label>
						<div class="col-sm-4">
							<select id='cat_id' name='cat_id' class='form-control'>
								<option value='{{$list->CATID}}'>{{$list->CATID}}</option>
								@foreach($cats as $cat)
								<option value='{{$cat['CATID']}}'>{{$cat['CATID']}} &nbsp;</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-3 control-label">Remark</label>
						<div class="col-sm-6">
							<textarea class="form-control" rows="3" name="rmk" id="rmk">{{ $list->DOCREM }}</textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-3 control-label">Status *</label>
						<div class="col-sm-4">
							<select id='status' name='status' class='form-control'>
								<option value='{{$list->DOCSTATUS}}'>{{$list->DOCSTATUS}}</option>
								<option value='Active'>Active&nbsp;</option>
								<option value='Obsolete'>Obsolete&nbsp;</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Sort Method</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id='sort' name='sort' placeholder="" value="{{ $list->SORTMETHODE }}">
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-3 control-label">Share *</label>
						<div class="col-sm-4">
							<select id='share' name='share' class='form-control'>
								<option value='{{$list->SHARESTATUS}}'>{{$list->SHARESTATUS}}</option>
								<option value='Y'>Y</option>
								<option value='N'>N</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-9 col-sm-10">
							<input type="hidden" id='user' name='user' value='{{ Auth::user()->name }}'>
							<input type="hidden" id='param_docid' name='param_docid' value='{{ $list->DOCID }}'>
							<input type="hidden" id='param_docrev' name='param_docrev' value='{{ $list->DOCREV }}'>
							<button type="submit" class="btn btn-sm btn-primary">Save</button>
							<a href='javascript:history.back()' class='btn btn-sm btn-primary'>Cancel</a>
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