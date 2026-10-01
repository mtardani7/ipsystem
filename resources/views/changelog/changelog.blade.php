@extends('layouts.app')


@section('content')
<div class="container">

	@if (Auth::check())

	@if (Auth::user()->custom=='admin' || Auth::user()->custom=='superuser')
	@include('sweet::alert')
	<div>
		<label style="font-size:24px;">Input ChangeLog</label>
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
		<form class="form-horizontal" method='post' action='changelog'>
			{{csrf_field()}}
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Date *</label>
				<div class="col-sm-4">
					<input type="date" class="form-control" name="date" required>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Title *</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="title" name="title" placeholder="" required>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Update Description</label>
				<div class="col-sm-4">
					<textarea class="form-control" rows="3" name="desc" id="desc"></textarea>
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
	@endif
	<table class="table table-bordered" id='mt' width='100%' height="" data-toggle="dataTable" data-form="deleteForm">
		<thead>
			<tr>
				<th style="color:white;" bgcolor="#666666" width='40'>Nr.</th>
				<th style="color:white;" bgcolor="#666666" width='80'>Date</th>
				<th style="color:white;" bgcolor="#666666" width='130'>Title</th>
				<th style="color:white;" bgcolor="#666666" width='350'>Description</th>
				<th style="color:white;" bgcolor="#666666" width='200'>Action</th>
			</tr>
		</thead>
		<tbody>
			@php $no = ($changelogs->currentpage()-1)* $changelogs->perpage() + 1; @endphp
			@foreach($changelogs as $changelog)

			<tr bgcolor="#fff">
				<td align='center'>{{$no}}</td>
				<td align='center'>{{$changelog->UPDATEDATE}}</td>
				<td align='center'>{{$changelog->TITLE}}</td>
				<td align='center'>{{$changelog->DESCRIPTION}}</td>
				<td align='center' width='10%'>
					<span style="float:left;"><a href='{{action('ChangelogController@edit', $changelog->ID)}} ' class='btn btn-success btn-xs'>edit</a></span> |
					<span style="float:right;">
						{!!Form::open(['action' => ['ChangelogController@destroy', $changelog->ID], 'method' => 'POST', 'class' => 'form-delete' ])!!}
						{!!Form::hidden('_method', 'DELETE')!!}

						{!!Form::submit('Delete', ['class' => 'btn btn-danger btn-xs delete' , 'name' => 'delete_modal'])!!}
						{!!Form::close()!!}
					</span>

				</td>
			</tr>

			@php $no++; @endphp
			@endforeach

		</tbody>
	</table>
	{{ $changelogs->links() }}


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