@extends('layouts.app')

@section('content')
<div class="container">
@if (Auth::check())

<div>
<label style="font-size:24px;">Data Vendor</label>
</div>

@include('administration.data_vendor.sub-menu_datavendor')



<table  class="table table-bordered" id='mt' width='100%' height="" data-toggle="dataTable" data-form="deleteForm">
		<thead>
		<tr >
			<th style="color:white;" bgcolor="#666666" width='40'>No. Vendor</th>
			<th style="color:white;" bgcolor="#666666" width='200'>Nama Perusahaan</th>
			<th style="color:white;" bgcolor="#666666" width=''>Alamat</th>
			<th style="color:white;" bgcolor="#666666" width='150'>Tipe Bisnis</th>
      <th style="color:white;" bgcolor="#666666" width='150'>Nama Pengisi</th>
      <th style="color:white;" bgcolor="#666666" width='100'>Status</th>
      <th style="color:white;" bgcolor="#666666" width='75'>Submit Date</th>
      <th style="color:white;" bgcolor="#666666" width=''>Action</th>
		</tr>
		</thead>
		<tbody >
			@php  $no = ($datas->currentpage()-1)* $datas->perpage() + 1;  @endphp
			@foreach($datas as $data)

			<tr bgcolor="#fff" >
			<td align='center'>{{$data['no_vendor']}}</td>
			<td align='center'>{{$data['nama_perusahaan']}}</td>
			<td align='center'>{{$data['alamat_perusahaan']}}</td>
      <td align='center'>{{$data['tipe_bisnis']}}</td>
			<td align='center'>{{$data['nama_pengisi']}}</td>
      <td align='center'>{{$data['status']}}</td>
      <?php
      $date = new DateTime($data['date_submit']);
      $date = $date->format('d-m-Y');
      ?>
      <td align='center'>{{$date}}</td>
			<td align='center' width='10%'>
				<a href='{{action('DataVendorController@view', $data['id'])}} ' class='btn btn-success btn-xs' >view</a>
				<a href='{{action('DataVendorController@edit', $data['id'])}} ' class='btn btn-primary btn-xs' >edit</a>
			</td>
			</tr>

			@php $no++; @endphp
			@endforeach

			</tbody>
			</table>
		{{ $datas->links() }}
@else
      <h3>You need to log in. <a href="login">Click here to login</a></h3>
@endif
</div>
@endsection
