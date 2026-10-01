@extends('layouts.app')

@section('content')
<div class="container">

	@if (Session::has('data'))
	<div class="custom-alerts alert alert-success fade in">
		{{ Session::get('data')}}
	</div>
	@endif

<div>
<label style="font-size:24px;">{{$title}}</label>
</div>

<!--sub menu -->
<div style="margin-bottom:10px;">
  <span style="float:left;" >
<!--<a href='# ' class='btn btn-default btn-xs' >New data</a>
<a href='# ' class='btn btn-default btn-xs' >New data</a>
<a href='# ' class='btn btn-default btn-xs' >New data</a>-->
 <a href='{{action('ReqDoneController@index')}}' class='btn btn-xs btn-default'>All Request</a>
 <a href='{{action('ReqDoneController@form_p4no7')}}' class='btn btn-xs btn-default'>Form_p4-no7</a>
</span>
&nbsp
<span style="float:right;margin-bottom:5px;">

</span>
</div>

<table  class="table table-bordered" id='mt' width='100%' height="" data-toggle="dataTable" data-form="deleteForm">
		<thead>
		<tr >
			<th style="color:white;" bgcolor="#666666"  width='70'>Req ID</th>
			<th style="color:white;" bgcolor="#666666" width='200'>Date</th>
			<th style="color:white;" bgcolor="#666666" width='90'>Req By</th>
			<th style="color:white;" bgcolor="#666666" width='200'>Dept</th>
      <th style="color:white;" bgcolor="#666666" width='200'>Plant</th>
      <th style="color:white;" bgcolor="#666666" width='200'>Req Type</th>
      <th style="color:white;" bgcolor="#666666" width='300'>Status</th>
      <th style="color:white;" bgcolor="#666666" width='200'>Action</th>
		</tr>
		</thead>
		<tbody >
			@php  $no = ($reqs->currentpage()-1)* $reqs->perpage() + 1;  @endphp
			@foreach($reqs as $req)

			<tr bgcolor="#fff" >
			<td align='center'>{{$req['id']}}</td>
			<td align='center'>{{$req['date_request']}}</td>
			<td align='center'>{{$req['reqby']}}</td>
      <td align='center'>{{$req['dept']}}</td>
      <td align='center'>{{$req['plant']}}</td>
      <td align='center'>{{$req['type']}}</td>
      <td align='center' <?php 	if (  $req['status']== 'approved') echo "bgcolor='#8bf76b'"; elseif (  $req['status']== 'waiting') echo "bgcolor='#f7c86b'"; elseif (  $req['status']== 'uploaded') echo "bgcolor='#b3d9ff'"; else echo "bgcolor='#cccccc'"?>>
				<?php if ($req['status']== 'uploaded') echo "Uploaded to IPSystem<br>";
							if ($req['approval1_date']!= null) echo "Approved by <b>".$req->approval1."</b> ".date('Y-m-d', strtotime($req->approval1_date))."<br>";
							if ($req['approval2_date']!= null) echo "Approved by <b>".$req->approval2."</b> ".date('Y-m-d', strtotime($req->approval2_date))."<br>";
							if ($req['approval_final_date']!= null) echo "Approved by <b>".$req->approval_final."</b> ".date('Y-m-d', strtotime($req->approval_final_date))."<br>";
							if ($req['approval_mr_date']!= null) echo "Approved by MR <b>".$req->approval_mr."</b> ".date('Y-m-d', strtotime($req->approval_mr_date))."<br>";
							//if ($req['approval1']== null || $req['approval1_date']== null || $req['approval2']== null || $req['approval2_date']== null ||$req['approval_final']== null || $req['approval_final_date']== null)echo "waiting<br>";
							if ($req['status']=='waiting') echo "Waiting<br>";
							if ($req['status']=='waiting' && $req['approval1']!= null && $req['approval1_date']== null) echo "Approval 1 "."<b>$req->approval1</b><br>";
							if ($req['status']=='waiting' && $req['approval2']!= null && $req['approval2_date']== null) echo "Approval 2 "."<b>$req->approval2</b><br>";
							if ($req['status']=='waiting' && $req['approval_final']!== null && $req['approval_final_date']== null) echo "Approval Final "."<b>$req->approval_final</b>";
							if ($req['status']=='waiting' && $req['approval_mr']!== null && $req['approval_mr_date']== null) echo "Approval MR "."<b>$req->approval_mr</b>";
							if ($req['status']=='reject') echo "Rejected<br><b>".$req['reject_by']."</b> on ".$req['reject_date']." reason <b>".$req['reject_rmk']."</b>";

			 ?> </td>
			<td align='center' width='10%'>
			@if($req['type']=='form_p4-no7' && $req['status'] != 'uploaded') <a href='{{action('ReqDoneController@uploaded', $req['id'])}} ' class='btn btn-primary btn-xs' >Upload</a> @endif
			<a href='{{action('ReqHistoryController@prints', $req['id'])}} ' class='btn btn-success btn-xs' target="_blank">Print</a>
			</td>
			</tr>

			@php $no++; @endphp
			@endforeach

			</tbody>
			</table>
		{{ $reqs->links() }}

</div>
@endsection
