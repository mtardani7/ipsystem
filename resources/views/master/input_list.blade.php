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
							<input type="text" class="form-control" id="thumbnail_view" name="view" placeholder="" readonly required>
						</div>
						<div class="col-sm-2">
							<a id="lfm1" data-input="thumbnail_view" data-preview="holder1" class="btn btn-sm btn-warning">
								<i class="fa fa-picture-o"></i> Choose
							</a>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Document ID *</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id='doc_id' name='doc_id' placeholder="" value="{{ old('doc_id') }}" required>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Div / Dept ID *</label>
						<div class="col-sm-4">
							<select id='dept_id' name='dept_id' class='form-control' required>
								<option value=''>- select -&nbsp;</option>
								@foreach($divs as $div)
								<option value='{{$div['DIVID']}}'>{{$div['DIVID']}} &nbsp;</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-3 control-label">Description</label>
						<div class="col-sm-6">
							<textarea name="desc" id="desc" class="form-control" rows="3">{{ old('desc') }}</textarea>
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
							<input type="text" class="form-control" id='save' name='save' placeholder="" value="{{ old('save') }}">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Eliminate Method</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id='elm' name='elm' placeholder="" value="{{ old('elm') }}">
						</div>
					</div>

				</div>

				<div class="col-sm-6">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">File to Print *</label>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="thumbnail1" name="print" placeholder="" readonly required>
						</div>
						<div class="col-sm-2">
							<a id="lfm2" data-input="thumbnail1" data-preview="holder2" class="btn btn-sm btn-warning">
								<i class="fa fa-picture-o"></i> Choose
							</a>
							<!-- <label class="radio-inline"><input type="radio" name="optradio" value="same" checked="checked">Same as view</label>
        <label class="radio-inline"><input type="radio" name="optradio" value="print">Print</label> -->
						</div>

					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Revision *</label>
						<div class="col-sm-2">
							<input type="text" class="form-control" id='rev1' name='rev1' placeholder="" value="00">
						</div>
						<div class="col-sm-4">
							<input type="text" class="form-control" id='rev' name='rev' placeholder="dd-mm-yyyy" required>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Category ID *</label>
						<div class="col-sm-4">
							<select id='cat_id' name='cat_id' class='form-control' required>
								<option value=''>- select -&nbsp;</option>
								@foreach($cats as $cat)
								<option value='{{$cat['CATID']}}'>{{$cat['CATID']}} &nbsp;</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-3 control-label">Remark</label>
						<div class="col-sm-6">
							<textarea class="form-control" rows="3" name="rmk" id="rmk">{{ old('rmk') }}</textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="inputPassword3" class="col-sm-3 control-label">Status *</label>
						<div class="col-sm-4">
							<select id='status' name='status' class='form-control'>
								<option value='Active'>Active&nbsp;</option>
								<option value='Obsolete'>Obsolete&nbsp;</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Sort Method</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id='sort' name='sort' placeholder="" value="{{ old('sort') }}">
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
							<input type="hidden" id='user' name='user' value='{{ Auth::user()->name }}'>
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

	<div class="well well-sm">
		{!! Form::open(['method'=>'GET','url'=>'search_list','class'=>'form-inline','role'=>'search']) !!}
		<div class="form-group">
			<label for="email">Department : </label>
			<div class="input-group">
				<select id='dept_id' name='dept_id' class='form-control'>
					<option value=''>-- select --&nbsp;</option>
					@foreach($divs as $div)
					<option value='{{$div['DIVID']}}'>{{$div['DIVID']}} &nbsp;</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="form-group">
			<label for="email">Category : </label>
			<div class="input-group">
				<select id='cat_id' name='cat_id' class='form-control'>
					<option value=''>-- select --&nbsp;</option>
					@foreach($cats as $cat)
					<option value='{{$cat['CATID']}}'>{{$cat['CATID']}} &nbsp;</option>
					@endforeach
				</select>
			</div>
		</div>

		<button class="btn btn-sm btn-primary" type="submit">search
		</button>

		{!! Form::close() !!}
	</div>

	@if (\Request::get('dept_id')!== null)
	Search result for Dept <b>'{{$dept_src}}'</b> and Category <b>'{{$cat_src}}'</b>
	<table style="" class="table table-bordered" id='mt' width='100%' height="">
		<thead>
			<tr>
				<th style="color:white;" bgcolor="#666666">Nr.</th>
				<th style="color:white;" bgcolor="#666666">Doc. ID</th>
				<th style="color:white;" bgcolor="#666666">Doc. Rev</th>
				<th style="color:white;" bgcolor="#666666">Description</th>
				<th style="color:white;" bgcolor="#666666" width=''>Status</th>
				<th style="color:white;" bgcolor="#666666" width=''>Dept</th>
				<th style="color:white;" bgcolor="#666666" width=''>Category</th>
				<th style="color:white;" bgcolor="#666666" width=''>Input Date</th>
				<th style="color:white;" bgcolor="#666666" width=''>Input By</th>
				<th style="color:white;" bgcolor="#666666" width='50'>View</th>
				<th style="color:white;" bgcolor="#666666" width='50'>Print</th>
				<th style="color:white;" bgcolor="#666666" width=''>Action</th>
			</tr>
		</thead>
		<tbody id='movies'>
			@php $no = 1; @endphp
			@foreach($lists as $list)
			<tr bgcolor="#fff">
				<td align='center'>{{$no}}</td>
				<td align='center'>{{$list->DOCID}}</td>
				<td align='center'>{{$list->DOCREV}}</td>
				<td align='center'>{{$list->DOCDESC}}</td>
				<td align='center'>{{$list->DOCSTATUS}}</td>
				<td align='center'>{{$list->DIVID}}</td>
				<td align='center'>{{$list->CATID}}</td>
				<td align='center'>{{$list->INPUTDATE}}</td>
				<td align='center'>{{$list->INPUTBY}}</td>
				<td align='center'>{{$list->PDFVIEW}}</td>
				<td align='center'>{{$list->PDFPRINT}}</td>
				<td align='center' width='10%'>

					<span style="float:left;"><a href='{{action('MasterListController@edit', ['docid'=>$list->DOCID,'docrev'=>$list->DOCREV])}} ' class='btn btn-success btn-xs'>edit</a></span> |
					<span style="float:right;">
						<form action="{{ action('MasterListController@destroy') }}" method="POST" class="form-delete">
							{{csrf_field()}}
							<input type="hidden" name="_method" value="delete" />
							<input type="hidden" id='id' name='id' value='{{ $list->DOCID }}'>
							<input type="hidden" id='rev' name='rev' value='{{ $list->DOCREV }}'>
							<button type="submit" class="btn btn-xs btn-danger" onClick="return confirm('Delete This data ?')">Delete</button>
						</form>

					</span>

				</td>
			</tr>

			@php $no++; @endphp
			@endforeach
		</tbody>
	</table>
	@endif


	@else
	<h3>You need to log in. <a href="login">Click here to login</a></h3>
	@endif

</div>

<!-- <script>
document.addEventListener("DOMContentLoaded", function () {

    function lfm(id, type = 'file') {
        const route_prefix = "{{ url(config('lfm.url_prefix', config('lfm.prefix'))) }}";

        const btn = document.getElementById(id);

        btn.addEventListener("click", function () {

            localStorage.setItem("lfm_input", this.dataset.input);
            localStorage.setItem("lfm_preview", this.dataset.preview);

            window.open(
                route_prefix + '?type=' + type,
                "FileManager",
                "width=900,height=600,scrollbars=yes"
            );
        });
    }

    // menerima pesan dari popup
    window.addEventListener("message", function (event) {
        if (!event.data || !event.data.path) return;

        const inputId = localStorage.getItem("lfm_input");
        const previewId = localStorage.getItem("lfm_preview");

        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);

        if (input) {
            input.value = event.data.path;
            input.dispatchEvent(new Event("change"));
        }

        if (preview) {
            preview.src = event.data.url;
            preview.dispatchEvent(new Event("change"));
        }
    });

    lfm('lfm1', 'file');
    lfm('lfm2', 'file');

});
</script> -->

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