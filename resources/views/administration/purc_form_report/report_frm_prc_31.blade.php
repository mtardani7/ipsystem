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
  <label style="font-size:24px;">FRM/10-PRC/31 - Kuesioner Kepuasan Vendor Jasa</label>
  </div>

	<table  class="table table-bordered" id='mt' width='100%' height="" data-toggle="dataTable" data-form="deleteForm">
			<thead>
			<tr >
				<th style="color:white;" bgcolor="#666666" width='40'>id</th>
				<th style="color:white;" bgcolor="#666666" width='300'>Form</th>
				<th style="color:white;" bgcolor="#666666" width='200'>Nama Pengisi</th>
				<th style="color:white;" bgcolor="#666666" width='150'>jabatan</th>
				<th style="color:white;" bgcolor="#666666" width='150'>Dept</th>
	      <th style="color:white;" bgcolor="#666666" width='75'>Submit Date</th>
	      <th style="color:white;" bgcolor="#666666" width=''>Action</th>
			</tr>
			</thead>
			<tbody >
				@php  $no = ($pengisi->currentpage()-1)* $pengisi->perpage() + 1;  @endphp
				@foreach($pengisi as $data)

				<tr bgcolor="#fff" >
				<td align='center'>{{$data->id}}</td>
				<td align='center'>{{$data->form}}</td>
				<td align='center'>{{$data->nama}}</td>
	      <td align='center'>{{$data->jabatan}}</td>
	      <td align='center'>{{$data->dept}}</td>
				<td align='center'>{{date("d-M-Y ", strtotime($data->date))}}</td>
				<td align='center' width='10%'>
					<a href='{{action('PurcFormReportController@view', $data->id)}}' class='btn btn-success btn-xs' >view</a>
					<a href=' ' class='btn btn-primary btn-xs' >edit</a>
				</td>
				</tr>

				@php $no++; @endphp
				@endforeach

				</tbody>
				</table>

</div>
@endsection
