@extends('layouts.app')

@section('content')
<div class="container">
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
				<td align='center'>{{$list->docid}}</td>
				<td align='center'>{{$list->docrev}}</td>
				<td align='center'>{{$list->docdesc}}</td>

			</tr>

			@php $no++; @endphp
			@endforeach
		</tbody>
	</table>
</div>
@endsection