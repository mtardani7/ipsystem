@extends('layouts.app')

@section('content')
<div class="container">

	@if (Session::has('data'))
	<div class="custom-alerts alert alert-success fade in">
		{{ Session::get('data')}}
	</div>
	@endif

<div>
<label style="font-size:24px;">Request Search Result FRM_P4-no8</label>
</div>

<div style="margin-bottom:10px;">
  <span style="float:left;" >
<!--<a href='# ' class='btn btn-default btn-xs' >New data</a>
<a href='# ' class='btn btn-default btn-xs' >New data</a>
<a href='# ' class='btn btn-default btn-xs' >New data</a>-->

</span>
&nbsp
<span style="float:right;margin-bottom:5px;">
<table width='650'>
    <tr>
    <form action='{{route('history_search')}}' method='post'>
    {{csrf_field()}}
    <td class='tableContent'>Select type :</td>
    <td class='tableContent'>
    <select id='type' name='type' class='form-control' style='width:97%;' required >
    <option value='form_p4-no7'>form_p4-no7&nbsp;</option>
    <option value='form_p4-no8'>form_p4-no8&nbsp;</option>
    </select>
    </td>
    <td class='tableContent'>Select field :</td>
    <td class='tableContent'>
    <select id='field' name='field' class='form-control' style='width:97%;' required >
    <option value='docid'>Doc. ID&nbsp;</option>
    <option value='desc'>Doc. Desc&nbsp;</option>
    </select>
    </td>
    <td class='tableContent'><input type='text' id='keyword' name='keyword' style='width:97%;'/></td>
    <td colspan='2' class='tableField' align='right'><input class="btn btn-sm btn-primary" type='submit' id='go' name='submit' value='Search' style='width:97%;'/></td>
    </form>
  </tr>
</table>
</span>
</div>

<?php //dd($datas); ?>

<table  class="table table-bordered" id='mt' width='100%' height="" data-toggle="dataTable" data-form="deleteForm">
		<thead>
		<tr >
			<th style="color:white;" bgcolor="#666666"  width='50'>Req ID</th>
			<th style="color:white;" bgcolor="#666666" width='150'>Date</th>
			<th style="color:white;" bgcolor="#666666" width='90'>Req By</th>
			<th style="color:white;" bgcolor="#666666" width='50'>Dept</th>
      <th style="color:white;" bgcolor="#666666" width='300'>No. Document</th>
      <th style="color:white;" bgcolor="#666666" width='300'>Description</th>
      <th style="color:white;" bgcolor="#666666" width='300'>Status</th>
      <th style="color:white;" bgcolor="#666666" width='200'>Action</th>
		</tr>
		</thead>
		<tbody >

			@foreach($datas as $req)

			<tr bgcolor="#fff" >
				<td align='center'>{{$req->id}}</td>
				<td align='center'>{{$req->date_request}}</td>
				<td align='center'>{{$req->reqby}}</td>
				<td align='center'>{{$req->dept}}</td>
				<td align='center'>Hard Copy : {{$req->hc_nodoc}}<br>Soft Copy : {{$req->sc_nodoc}}<br>Pemusnahan : {{$req->el_nodoc}}</td>
				<td align='center'>Hard Copy : {{$req->hc_docname }}<br>Soft Copy : {{$req->sc_docname}}<br>Pemusnahan : {{$req->el_nodoc}}</td>
				<td align='center' <?php 	if (  $req->status == 'approved') echo "bgcolor='#8bf76b'"; elseif (  $req->status == 'waiting') echo "bgcolor='#f7c86b'"; elseif (  $req->status == 'uploaded') echo "bgcolor='#b3d9ff'"; else echo "bgcolor='#cccccc'"?>>
					<?php
								if ($req->status== 'uploaded') echo "Uploaded to IPSystem<br>";
								if ($req->verified == 'no') { if ($req->type =='form_it-01') echo "Waiting verification from IT<br>"; else echo "Waiting verification from Doc. Controller<br>"; }
								if ($req->approval1_date != null) echo "Approved by <b>".$req->approval1."</b> ".date('Y-m-d', strtotime($req->approval1_date))."<br>";
								if ($req->approval2_date != null) echo "Approved by <b>".$req->approval2."</b> ".date('Y-m-d', strtotime($req->approval2_date))."<br>";
								if ($req->approval_final_date != null) echo "Approved by <b>".$req->approval_final."</b> ".date('Y-m-d', strtotime($req->approval_final_date))."<br>";
								if ($req->approval_mr_date != null) echo "Approved by MR <b>".$req->approval_mr."</b> ".date('Y-m-d', strtotime($req->approval_mr_date))."<br>";
								//if ($req->approval1 == null || $req->approval1_date == null || $req->approval2 == null || $req->approval2_date == null ||$req->approval_final == null || $req->approval_final_date == null)echo "waiting<br>";
								if ($req->status =='waiting') echo "Waiting<br>";
								if ($req->status =='waiting' && $req->approval1 != null && $req->approval1_date == null) echo "Approval 1 "."<b>$req->approval1</b><br>";
								if ($req->status =='waiting' && $req->approval2 != null && $req->approval2_date == null) echo "Approval 2 "."<b>$req->approval2</b><br>";
								if ($req->status =='waiting' && $req->approval_final !== null && $req->approval_final_date == null) echo "Approval Final "."<b>$req->approval_final</b><br>";
								if ($req->status =='waiting' && $req->approval_mr !== null && $req->approval_mr_date == null) echo "Approval MR "."<b>$req->approval_mr</b><br>";
								if ($req->status =='reject') echo "Rejected<br><b>".$req->reject_by ."</b> on ".$req->reject_date ." reason <b>".$req->reject_rmk."</b><br>";

				 ?> </td>
			<td align='center' width='10%'>
	 			<a href='{{action('ReqHistoryController@view', $req->id)}} ' class='btn btn-success btn-xs' >view</a>
	 		</td>
			</tr>


			@endforeach

			</tbody>
			</table>


</div>
@endsection
