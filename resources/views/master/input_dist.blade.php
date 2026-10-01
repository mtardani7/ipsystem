@extends('layouts.app')

@section('content')
<div class="container">
	@if (Auth::check())
	@include('sweet::alert')
	<div>
		<label style="font-size:24px;">Input Distribution</label>
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
		<form class="form-horizontal" method='post' action='input_dist'>
			{{csrf_field()}}

			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Division</label>
				<div class="col-sm-4">
					<select id='div' name='div' class='form-control' required>
						<option value=''>- select -&nbsp;</option>
						@foreach($divs as $div)
						<option value='{{$div['DIVID']}}'>{{$div['DIVID']}} &nbsp;</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Distribution</label>
				<div class="col-sm-4">
					<input type="checkbox" id="qm" name="qm" value="QM"> QM<br>
					<input type="checkbox" id="jd" name="jd" value="JOB"> Job Desc<br>
					<input type="checkbox" id="sop" name="sop" value="SOP"> Standard Operating Procedure (SOP)<br>
					<input type="checkbox" id="wi" name="wi" value="WI"> Work Instruction (WI)<br>
					<input type="checkbox" id="form" name="form" value="FORM"> Form<br>
					<input type="checkbox" id="guidelines" name="guidelines" value="GUIDELINES"> Guidelines<br>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-sm btn-primary">Save</button>
				</div>
				<div class="col-sm-offset-2 col-sm-10">
					<p style="font-size:10px;padding-top:10px;">* must be filled</p>
				</div>
			</div>

		</form>
	</div>

	<table class="table table-bordered" id='mt' width='100%' height="" data-toggle="dataTable" data-form="deleteForm">
		<thead>
			<tr>
				<th style="color:white;" bgcolor="#666666" width='40'>Nr.</th>
				<th style="color:white;" bgcolor="#666666" width='100'>Dept. No</th>
				<th style="color:white;" bgcolor="#666666" width='200'>Dept. ID</th>
				<th style="color:white;" bgcolor="#666666">Distribution</th>
				<th style="color:white;" bgcolor="#666666" width='200'>Action</th>
			</tr>
		</thead>
		<tbody>
			@php $no = ($dists->currentpage()-1)* $dists->perpage() + 1; @endphp
			@foreach($dists as $dist)

			<tr bgcolor="#fff">
				<td align='center'>{{$no}}</td>
				<td align='center'>{{$dist['DIVDIST']}}</td>
				<td align='center'>{{$dist['DIVID']}}</td>
				@php
				$doc = "";
				if ($dist['QM']==1)
				$doc = $doc."QM,";
				if ($dist['JOB']==1)
				$doc = $doc."JOB,";
				if ($dist['SOP']==1)
				$doc = $doc."SOP,";
				if ($dist['WI']==1)
				$doc = $doc."WI,";
				if ($dist['FORM']==1)
				$doc = $doc."FORM,";
				if ($dist['GUIDELINES']==1)
				$doc = $doc."GUIDELINES";
				@endphp
				<td align='center'>{{$doc}}</td>
				<td align='center' width='10%'>
					<span style="float:left;"><a href='{{action('DistController@edit', $dist['DIVDIST'])}} ' class='btn btn-success btn-xs'>edit</a></span> |
					<span style="float:right;">
						{!!Form::open(['action' => ['DistController@destroy', $dist['DIVDIST']], 'method' => 'POST', 'class' => 'form-delete' ])!!}
						{!!Form::hidden('_method', 'DELETE')!!}
						{!!Form::hidden('id', $dist['DIVDIST']) !!}
						{!!Form::submit('Delete', ['class' => 'btn btn-danger btn-xs delete' , 'name' => 'delete_modal'])!!}
						{!!Form::close()!!}
					</span>

				</td>
			</tr>

			@php $no++; @endphp
			@endforeach

		</tbody>
	</table>
	{{ $dists->links() }}

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
	$(document).ready(function() {
		$('table[data-form="deleteForm"]').on('click', '.form-delete', function(e) {
			e.preventDefault();
			var $form = $(this);
			$('#confirm').modal({
					backdrop: 'static',
					keyboard: false
				})
				.on('click', '#delete-btn', function() {
					$form.submit();
				});
		});
	});
</script>

@endsection