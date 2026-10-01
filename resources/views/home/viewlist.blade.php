@extends('layouts.app')

@section('content')
<div class="container">

<!-- class="table table-bordered" -->
<table id="myTable" class="table table-bordered" width='100%' border='0' cellspacing='0' cellpadding='0'>
			<thead>
			<tr >
				<th width='' style="background-color:#666666;color:white;">Nr.</th>
				<th width='' style="background-color:#666666;color:white;;">Doc ID</th>
				<th width='' style="background-color:#666666;color:white;">Doc Revision</th>
				<th width='' style="background-color:#666666;color:white;">Description</th>
				<th width='' style="background-color:#666666;color:white;">Dept</th>
				<th width='' style="background-color:#666666;color:white;">Category</th>
				<th style="background-color:#666666;color:white;">Save Periode *)</th>
				<th style="background-color:#666666;color:white;">Sort Methode</th>
				<th style="background-color:#666666;color:white;">Eliminate Methode</th>
				<th style="background-color:#666666;color:white;">Remark</th>
				<th th width='' style="background-color:#666666;color:white;">Status</th>
				<th th width='' style="background-color:#666666;color:white;">Action</th>

			</tr>
			</thead>
			<tbody>
			@php  $no = 1;  @endphp
			@foreach($lists as $list)
			<tr bgcolor="{{ ($list['DOCSTATUS'] == 'Active') ? '#87CEFA':'#e5e5e5' }}" >
			<td >{{$no}}</td>
			<td >{{$list['DOCID']}}</td>
			<td >{{$list->DOCREV}}</td>
			<td >{{$list->DOCDESC}}</td>
			<td >{{$list->DIVID}}</td>
			<td >{{$list->CATID}}</td>
			<td >{{$list->SAVEPERIODE }}</td>
			<td >{{$list->SORTMETHODE }}</td>
			<td >{{$list->ELIMINATEMETHODE}}</td>
			<td >{{$list->DOCREM }}</td>
			<td >{{$list->DOCSTATUS }}</td>
			<td >
			<form  method="post" action="{{route('viewdoc')}}">
			 {{csrf_field()}}
			<input type="hidden" name="view_type" value="uncontrolled" />
			<input type="hidden" name="id" value="{{$list->DOCID}}" />
			<input type="hidden" name="rev" value="{{$list->DOCREV}}" />
			<input {{ ($list->DOCSTATUS == 'Active') ? '':'disabled' }}  type='submit' name='button' id='button' class='btn btn-primary btn-xs' value='View' style='none' >

			</form>
			@if (Auth::user()->custom=='admin' || Auth::user()->custom=='superuser')
			<form  method="post" action="{{route('viewdoc')}}">
			 {{csrf_field()}}
			<input type="hidden" name="view_type" value="original" />
			<input type="hidden" name="id" value="{{$list->DOCID}}" />
			<input type="hidden" name="rev" value="{{$list->DOCREV}}" />
			<input {{ ($list->DOCSTATUS == 'Active') ? '':'disabled' }}  type='submit' name='button' id='button' class='btn btn-primary btn-xs' value='View Ori' style='none' >

			</form>
			@endif
			<!--<a href='{{$list->catid}}/{{$list->id}} ' class='btn btn-success btn-xs' >edit</a>-->
			</td>
			</tr>
			@php $no++; @endphp
			@endforeach
			</tbody>
</table>

<style>
	body {
		margin: 0;
		padding: 2rem;
	}

	table {
		text-align: left;
		position: relative;
		border-collapse: collapse; 
	}
	th, td {
		padding: 0.25rem;
	}
	tr.red th {
		background: red;
		color: white;
	}
	tr.green th {
		background: green;
		color: white;
	}
	tr.purple th {
		background: purple;
		color: white;
	}
	th {
		background: white;
		position: sticky;
		top: 0; /* Don't forget this, required for the stickiness */
		box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
	}
	.form-container {
	display: flex;
	justify-content: flex-start; /* Adjust as needed */
	}

	/* .float-left {
	float: left;
	}

	.float-right {
	float: right;
	} */
</style>

<label>Note : *) atau mengacu persyaratan pelanggan</label><br>

@isset($get_masterlist)
<!-- <form method='post' action='{{ route('xls_masterlist')}}' style='float:left;margin-right:10px;'>
	 {{csrf_field()}}
	<input type="hidden" id="div" name="div" value="{{$divid}}" />
	<input type="hidden" id="cat" name="cat"  value="{{$catid}}" />
	<input type='submit' class='btn btn-xs btn-primary' id='go' name='submit' value='Get master list XLS'/>

</form>

<form method='post' action='{{ route('xls_masterlist_active')}}' style=''>
	 {{csrf_field()}}
	<input type="hidden" id="diva" name="diva" value="{{$divid}}" />
	<input type="hidden" id="cata" name="cata"  value="{{$catid}}" />
	<input type='submit' class='btn btn-xs btn-primary' id='go' name='submit' value='Get master list ACTIVE ONLY XLS'/>
</form> -->
<div class="form-container">
  <form method='post' action='{{ route('xls_masterlist')}}' class="form-inline" style="margin: 10px">
    {{ csrf_field() }}
    <input type="hidden" name="div" value="{{ $divid }}">
    <input type="hidden" name="cat" value="{{ $catid }}">
    <input type='submit' class='btn btn-xs btn-primary' value='Get master list XLS'>
  </form>
  <form method='post' action='{{ route('xls_masterlist_active')}}' class="form-inline" style="margin: 10px">
    {{ csrf_field() }}
    <input type="hidden" name="diva" value="{{ $divid }}">
    <input type="hidden" name="cata" value="{{ $catid }}">
    <input type='submit' class='btn btn-xs btn-primary' value='Get master list ACTIVE ONLY XLS'>
  </form>
</div>
@endisset
<br>
<br>
<br>
@if (strpos($catid, 'CERT') !== false)
Last cert external ID
<table>
	<tr >
	<td align='left'>DOCID</td>
	<td align='left'> &nbsp:&nbsp </td>
	<th  width='' style="background-color:#87CEFA;">{{$last_cert_id->DOCID}}</th>
	</tr>
	<tr >
	<td align='left'>REV</td>
	<td align='left'> &nbsp:&nbsp </td>
	<th  width='' style="background-color:#87CEFA;">{{$last_cert_id->DOCREV}}</th>
	</tr>
</table>
<br>
@endif

</div>
@endsection
