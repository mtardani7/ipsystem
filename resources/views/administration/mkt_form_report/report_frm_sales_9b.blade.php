@extends('layouts.app')


@section('content')

@if ($message = Session::get('success'))
<div class="custom-alerts alert alert-success fade in">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
	{!! $message !!}
</div>
<?php Session::forget('success');?>
@endif

<div class="container">
  <div>
  <label style="font-size:24px;">FRM/07-SALES/09b - Kuesioner Kepuasan Pelanggan</label>
  </div>

	<table  class="table table-bordered" id='mt' width='100%' height="" data-toggle="dataTable" data-form="deleteForm">
			<thead>
			<tr >
				<th style="color:white;" bgcolor="#666666" width='40'>id</th>
				<th style="color:white;" bgcolor="#666666" width='100'>Form id</th>
				<th style="color:white;" bgcolor="#666666" width='200'>Customer</th>
				<th style="color:white;" bgcolor="#666666" width='150'>Nama Pengisi</th>
				<th style="color:white;" bgcolor="#666666" width='150'>Dept</th>
	      <th style="color:white;" bgcolor="#666666" width='100'>Submit Date</th>
	      <th style="color:white;" bgcolor="#666666" width=''>Action</th>
			</tr>
			</thead>
			<tbody >
				@php  $no = ($pengisi->currentpage()-1)* $pengisi->perpage() + 1;  @endphp
				@foreach($pengisi as $data)

				<tr bgcolor="#fff" >
				<td align='center'>{{$data->id}}</td>
				<td align='center'>{{$data->form_id}}</td>
				<td align='center'>{{$data->customer}}</td>
	      <td align='center'>{{$data->name}}</td>
	      <td align='center'>{{$data->dept}}</td>
				<td align='center'>{{date("d-M-Y ", strtotime($data->date))}}</td>
				<td align='center' width='10%'>
					<span style="float:left;"></span>
					<span style="float:right;">
					<form method='post' action='{{ route('get_xls_FormMkt_9b')}}' style='float:left;margin-right:10px;'>
						 {{csrf_field()}}
						<input type='hidden' id='type' name='type' value='9b' />
						<input type='hidden' id='form_id' name='form_id' value='{{$data->form_id}}' />
						<input type='submit' class='btn btn-xs btn-primary' id='go' name='submit' value='XLS'/>
					</form>
					</span>
				</td>
				</tr>

				@php $no++; @endphp
				@endforeach

				</tbody>
				</table>
				{{ $pengisi->links() }}

</div>
@endsection
