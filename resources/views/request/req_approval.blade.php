@extends('layouts.app')

@section('content')
<div class="container">
  <div>
  <label style="font-size:24px;">Need Approval</label>
  </div>

  <table  class="table table-bordered" id='mt' width='100%' height="" data-toggle="dataTable" data-form="deleteForm">
  		<thead>
  		<tr >
  			<th style="color:white;" bgcolor="#666666" width='5%'>Req ID</th>
  			<th style="color:white;" bgcolor="#666666" width='10%'>Date</th>
  			<th style="color:white;" bgcolor="#666666" width='10%'>Req By</th>
  			<th style="color:white;" bgcolor="#666666" width='10%'>Dept</th>
        <th style="color:white;" bgcolor="#666666" width='10%'>Plant</th>
        <th style="color:white;" bgcolor="#666666" width='10%'>Req Type</th>
        <th style="color:white;" bgcolor="#666666" width='20%'>Status</th>
        <th style="color:white;" bgcolor="#666666" width='13%'>Action</th>
  		</tr>
  		</thead>
      <tbody >
        <?php // $no = ($reqs->currentpage()-1)* $reqs->perpage() + 1;  ?>
  			@foreach($reqs as $req)
        <!-- note ($req['approva1_date'] || $req['approva2_date'] || $req['approval_final_date'] == null) -->
        @if ($req['approval1'] == $user && $req['approval1_date'] == null  && $req['status'] == 'waiting')

  			<tr bgcolor="#fff" >
  			<td align='center'>{{$req['id']}}</td>
  			<td align='center'>{{$req['date_request']}}</td>
  			<td align='center'>{{$req['reqby']}}</td>
        <td align='center'>{{$req['dept']}}</td>
        <td align='center'>{{$req['plant']}}</td>
        <td align='center'>{{$req['type']}}</td>
        <td align='center' <?php 	if ( $req['approval1_date']!= null && $req['approval2_date']!= null && $req['approval_final_date']!= null) echo "bgcolor='#8bf76b'"; else echo "bgcolor='#f7c86b'"; ?>>
  				<?php if ($req['approval1_date']!= null) echo "Approved by <b>".$req->approval1."</b> ".date('Y-m-d', strtotime($req->approval1_date))."<br>";
  							if ($req['approval2_date']!= null) echo "Approved by <b>".$req->approval2."</b> ".date('Y-m-d', strtotime($req->approval2_date))."<br>";
  							if ($req['approval_final_date']!= null) echo "Approved by <b>".$req->approval_final."</b> ".date('Y-m-d', strtotime($req->approval_final_date))."<br>";
  							//if ($req['approval1']== null || $req['approval1_date']== null || $req['approval2']== null || $req['approval2_date']== null ||$req['approval_final']== null || $req['approval_final_date']== null)echo "waiting<br>";
                //if ($req['approval_final_date']== null) {if ($req['approval_mr']== 'Jim Handoko' && $req['approval_mr_date']== null)  echo "waiting<br>"; else echo "waiting<br>"; } else echo "waiting<br>";
                if ($req['status']!='approved') echo "waiting<br>";
                if ($req['approval1']!= null && $req['approval1_date']== null) echo "Approval 1 "."<b>$req->approval1</b><br>";
  							if ($req['approval2']!= null && $req['approval2_date']== null) echo "Approval 2 "."<b>$req->approval2</b><br>";
  							if ($req['approval_final']!== null && $req['approval_final_date']== null) echo "Approval Final "."<b>$req->approval_final</b><br>";
                if ($req['approval_mr']!== 'no' && $req['approval_mr_date']== null) echo "Approval MR "."<b>$req->approval_mr</b>";
  			 ?> </td>
  			<td align='center' width='10%'>
  			<a href='{{action('ReqHistoryController@view', $req['id'])}} ' class='btn btn-success btn-xs' >view</a>
        <a href='{{action('ReqHistoryController@view', $req['id'])}} ' class='btn btn-success btn-xs' >approve</a>
        <a href='{{action('ReqHistoryController@view', $req['id'])}} ' class='btn btn-success btn-xs' >reject</a>
  			</td>
  			</tr>

        @elseif ($req['approval2'] == $user && $req['approval2_date'] == null  && $req['status'] == 'waiting')

        <tr bgcolor="#fff" >
        <td align='center'>{{$req['id']}}</td>
        <td align='center'>{{$req['date_request']}}</td>
        <td align='center'>{{$req['reqby']}}</td>
        <td align='center'>{{$req['dept']}}</td>
        <td align='center'>{{$req['plant']}}</td>
        <td align='center'>{{$req['type']}}</td>
        <td align='center' <?php 	if ( $req['approval1_date']!= null && $req['approval2_date']!= null && $req['approval_final_date']!= null) echo "bgcolor='#8bf76b'"; else echo "bgcolor='#f7c86b'"; ?>>
          <?php if ($req['approval1_date']!= null) echo "Approved by <b>".$req->approval1."</b> ".date('Y-m-d', strtotime($req->approval1_date))."<br>";
                if ($req['approval2_date']!= null) echo "Approved by <b>".$req->approval2."</b> ".date('Y-m-d', strtotime($req->approval2_date))."<br>";
                if ($req['approval_final_date']!= null) echo "Approved by <b>".$req->approval_final."</b> ".date('Y-m-d', strtotime($req->approval_final_date))."<br>";
                //if ($req['approval1']== null || $req['approval1_date']== null || $req['approval2']== null || $req['approval2_date']== null ||$req['approval_final']== null || $req['approval_final_date']== null)echo "waiting<br>";
                //if ($req['approval_final_date']== null) {if ($req['approval_mr']== 'Jim Handoko' && $req['approval_mr_date']== null)  echo "waiting<br>"; else echo "waiting<br>"; } else echo "waiting<br>";
                if ($req['status']!='approved') echo "waiting<br>";
                if ($req['approval1']!= null && $req['approval1_date']== null) echo "Approval 1 "."<b>$req->approval1</b><br>";
                if ($req['approval2']!= null && $req['approval2_date']== null) echo "Approval 2 "."<b>$req->approval2</b><br>";
                if ($req['approval_final']!== null && $req['approval_final_date']== null) echo "Approval Final "."<b>$req->approval_final</b><br>";
                if ($req['approval_mr']!== 'no' && $req['approval_mr_date']== null) echo "Approval MR "."<b>$req->approval_mr</b>";
         ?> </td>
        <td align='center' width='10%'>
        <a href='{{action('ReqHistoryController@view', $req['id'])}} ' class='btn btn-success btn-xs' >view</a>
        <a href='{{action('ReqHistoryController@view', $req['id'])}} ' class='btn btn-success btn-xs' >approve</a>
        <a href='{{action('ReqHistoryController@view', $req['id'])}} ' class='btn btn-success btn-xs' >reject</a>
        </td>
        </tr>

        @elseif ($req['approval_final'] == $user && $req['approval_final_date'] == null && $req['status'] == 'waiting')

        <tr bgcolor="#fff" >
        <td align='center'>{{$req['id']}}</td>
        <td align='center'>{{$req['date_request']}}</td>
        <td align='center'>{{$req['reqby']}}</td>
        <td align='center'>{{$req['dept']}}</td>
        <td align='center'>{{$req['plant']}}</td>
        <td align='center'>{{$req['type']}}</td>
        <td align='center' <?php 	if ( $req['approval1_date']!= null && $req['approval2_date']!= null && $req['approval_final_date']!= null) echo "bgcolor='#8bf76b'"; else echo "bgcolor='#f7c86b'"; ?>>
          <?php if ($req['approval1_date']!= null) echo "Approved by <b>".$req->approval1."</b> ".date('Y-m-d', strtotime($req->approval1_date))."<br>";
                if ($req['approval2_date']!= null) echo "Approved by <b>".$req->approval2."</b> ".date('Y-m-d', strtotime($req->approval2_date))."<br>";
                if ($req['approval_final_date']!= null) echo "Approved by <b>".$req->approval_final."</b> ".date('Y-m-d', strtotime($req->approval_final_date))."<br>";
                //if ($req['approval1']== null || $req['approval1_date']== null || $req['approval2']== null || $req['approval2_date']== null ||$req['approval_final']== null || $req['approval_final_date']== null)echo "waiting<br>";
              //  if ($req['approval_final_date']== null) {if ($req['approval_mr']== 'Jim Handoko' && $req['approval_mr_date']== null)  echo "waiting<br>"; else echo "waiting<br>"; } else echo "waiting<br>";
                if ($req['status']!='approved') echo "waiting<br>";
                if ($req['approval1']!= null && $req['approval1_date']== null) echo "Approval 1 "."<b>$req->approval1</b><br>";
                if ($req['approval2']!= null && $req['approval2_date']== null) echo "Approval 2 "."<b>$req->approval2</b><br>";
                if ($req['approval_final']!== null && $req['approval_final_date']== null) echo "Approval Final "."<b>$req->approval_final</b><br>";
                if ($req['approval_mr']!== null && $req['approval_mr_date']== null) echo "Approval MR "."<b>$req->approval_mr</b>";
         ?> </td>
        <td align='center' width='10%'>
          <span style="float:left;">
          <form class="form-horizontal" method='post' action='{{ action('ReqApprovalController@approve') }}'>
            {{csrf_field()}}
                <input type="hidden" name="request_id"  id='request_id' value="{{$req->id}}">
          <a href='{{action('ReqHistoryController@view', $req['id'])}} ' class='btn btn-success btn-xs' >view</a>
          @if ($req->type != 'form_it-01')
          <button type="submit" class="btn btn-xs btn-primary"  onclick="return confirm('are you sure want to approve?')">Approve</button>
          @endif
          </form>
          </span>
          <span style="float:right;">
          <form class="form-horizontal" method='post' action='{{ action('ReqApprovalController@reject') }}'>
          {{csrf_field()}}
              <input type="hidden" name="request_id"  id='request_id' value="{{$req->id}}">

              <button type="submit" class="btn btn-xs btn-primary">Reject</button>
          </form>
          </span>
        </td>
        </tr>

        @elseif (($req['approval_mr'] == $user && $req['approval_mr_date'] == null && $req['approval_final_date']!== null  && $req['status'] == 'waiting') || ($req['approval_mr'] == $user && $req['approval_mr_date'] == null && $req['approval_final']== null  && $req['status'] == 'waiting'))

        <tr bgcolor="#fff" >
        <td align='center'>{{$req['id']}}</td>
        <td align='center'>{{$req['date_request']}}</td>
        <td align='center'>{{$req['reqby']}}</td>
        <td align='center'>{{$req['dept']}}</td>
        <td align='center'>{{$req['plant']}}</td>
        <td align='center'>{{$req['type']}}</td>
        <td align='center' <?php 	if ( $req['approval1_date']!= null && $req['approval2_date']!= null && $req['approval_final_date']!= null && $req['approval_mr_date']!= null) echo "bgcolor='#8bf76b'"; else echo "bgcolor='#f7c86b'"; ?>>
          <?php if ($req['approval1_date']!= null) echo "Approved by <b>".$req->approval1."</b> ".date('Y-m-d', strtotime($req->approval1_date))."<br>";
                if ($req['approval2_date']!= null) echo "Approved by <b>".$req->approval2."</b> ".date('Y-m-d', strtotime($req->approval2_date))."<br>";
                if ($req['approval_final_date']!= null) echo "Approved by <b>".$req->approval_final."</b> ".date('Y-m-d', strtotime($req->approval_final_date))."<br>";
                //if ($req['approval1']== null || $req['approval1_date']== null || $req['approval2']== null || $req['approval2_date']== null ||$req['approval_final']== null || $req['approval_final_date']== null)echo "waiting<br>";
              //  if ($req['approval_final_date']== null) {if ($req['approval_mr']== 'Jim Handoko' && $req['approval_mr_date']== null)  echo "waiting<br>"; else echo "waiting<br>"; } else echo "waiting<br>";
                if ($req['status']!='approved') echo "waiting<br>";
                if ($req['approval1']!= null && $req['approval1_date']== null) echo "Approval 1 "."<b>$req->approval1</b><br>";
                if ($req['approval2']!= null && $req['approval2_date']== null) echo "Approval 2 "."<b>$req->approval2</b><br>";
                if ($req['approval_final']!== null && $req['approval_final_date']== null) echo "Approval Final "."<b>$req->approval_final</b><br>";
                if ($req['approval_mr']!== 'no' && $req['approval_mr_date']== null) echo "Approval MR "."<b>$req->approval_mr</b>";
         ?> </td>
        <td align='center' width='10%'>
        <span style="float:left;">
        <form class="form-horizontal" method='post' action='{{ action('ReqApprovalController@approve') }}'>
          {{csrf_field()}}
              <input type="hidden" name="request_id"  id='request_id' value="{{$req->id}}">
        <a href='{{action('ReqHistoryController@view', $req['id'])}} ' class='btn btn-success btn-xs' >view</a>
        <button type="submit" class="btn btn-xs btn-primary" onclick="return confirm('are you sure want to approve?')">Approve</button>
        </form>
        </span>
        <span style="float:right;">
        <form class="form-horizontal" method='post' action='{{ action('ReqApprovalController@reject') }}'>
        {{csrf_field()}}
            <input type="hidden" name="request_id"  id='request_id' value="{{$req->id}}">

            <button type="submit" class="btn btn-xs btn-primary">Reject</button>
        </form>
        </span>
        </td>
        </tr>
        @endif

  			<?php // $no++; ?>
  			@endforeach

  			</tbody>
  </table>

  <!-- menambahkan if utk menampilkan data sesui user login -->
  <div>
  <label style="font-size:24px;">Approved</label>
  </div>

  <table  class="table table-bordered" id='mt' width='100%' height="" data-toggle="dataTable" data-form="deleteForm">
  		<thead>
  		<tr >
  			<th style="color:white;" bgcolor="#666666" width='5%'>Req ID</th>
  			<th style="color:white;" bgcolor="#666666" width='10%'>Date</th>
  			<th style="color:white;" bgcolor="#666666" width='10%'>Req By</th>
  			<th style="color:white;" bgcolor="#666666" width='10%'>Dept</th>
        <th style="color:white;" bgcolor="#666666" width='10%'>Plant</th>
        <th style="color:white;" bgcolor="#666666" width='10%'>Req Type</th>
        <th style="color:white;" bgcolor="#666666" width='20%'>Status</th>
        <th style="color:white;" bgcolor="#666666" width='13%'>Action</th>
  		</tr>
  		</thead>
      <tbody >
  			<?php // $no = ($reqs->currentpage()-1)* $reqs->perpage() + 1;  ?>
  			@foreach($reqs as $req)

        @if ($req['approval1'] == $user && $req['approval1_date'] != null && $req['approval_mr'] != $user)

  			<tr bgcolor="#fff" >
  			<td align='center'>{{$req['id']}}</td>
  			<td align='center'>{{$req['date_request']}}</td>
  			<td align='center'>{{$req['reqby']}}</td>
        <td align='center'>{{$req['dept']}}</td>
        <td align='center'>{{$req['plant']}}</td>
        <td align='center'>{{$req['type']}}</td>
        <td align='center' bgcolor='#8bf76b'>
  				<?php if ($req['approval1_date']!= null) echo "Approved by <b>".$req->approval1."</b> ".date('Y-m-d', strtotime($req->approval1_date))."<br>";
  							if ($req['approval2_date']!= null) echo "Approved by <b>".$req->approval2."</b> ".date('Y-m-d', strtotime($req->approval2_date))."<br>";
  							if ($req['approval_final_date']!= null) echo "Approved by <b>".$req->approval_final."</b> ".date('Y-m-d', strtotime($req->approval_final_date))."<br>";
  							//if ($req['approval1']== null || $req['approval1_date']== null || $req['approval2']== null || $req['approval2_date']== null ||$req['approval_final']== null || $req['approval_final_date']== null)echo "waiting<br>";
                //if ($req['approval_final_date']== null) echo "waiting<br>";
                //if ($req['approval_final_date']== null) {if ($req['approval_mr']== 'Jim Handoko' && $req['approval_mr_date']== null)  echo "waiting<br>"; else echo "waiting<br>"; } else echo "waiting<br>";
                if ($req['status']!='approved') echo "waiting<br>";
                if ($req['approval1']!= null && $req['approval1_date']== null) echo "Approval 1 "."<b>$req->approval1</b><br>";
  							if ($req['approval2']!= null && $req['approval2_date']== null) echo "Approval 2 "."<b>$req->approval2</b><br>";
  							if ($req['approval_final']!== null && $req['approval_final_date']== null) echo "Approval Final "."<b>$req->approval_final</b><br>";
                if ($req['approval_mr']!== 'no' && $req['approval_mr_date']== null) echo "Approval MR "."<b>$req->approval_mr</b>";
  			 ?> </td>
  			<td align='center' width='10%'>
  			<a href='{{action('ReqHistoryController@view', $req['id'])}} ' class='btn btn-success btn-xs' >view</a>
  			</td>
  			</tr>

        @elseif ($req['approval2'] == $user && $req['approval2_date'] != null && $req['approval_mr'] != $user )

        <tr bgcolor="#fff" >
        <td align='center'>{{$req['id']}}</td>
        <td align='center'>{{$req['date_request']}}</td>
        <td align='center'>{{$req['reqby']}}</td>
        <td align='center'>{{$req['dept']}}</td>
        <td align='center'>{{$req['plant']}}</td>
        <td align='center'>{{$req['type']}}</td>
        <td align='center'bgcolor='#8bf76b'>
          <?php if ($req['approval1_date']!= null) echo "Approved by <b>".$req->approval1."</b> ".date('Y-m-d', strtotime($req->approval1_date))."<br>";
                if ($req['approval2_date']!= null) echo "Approved by <b>".$req->approval2."</b> ".date('Y-m-d', strtotime($req->approval2_date))."<br>";
                if ($req['approval_final_date']!= null) echo "Approved by <b>".$req->approval_final."</b> ".date('Y-m-d', strtotime($req->approval_final_date))."<br>";
                //if ($req['approval1']== null || $req['approval1_date']== null || $req['approval2']== null || $req['approval2_date']== null ||$req['approval_final']== null || $req['approval_final_date']== null)echo "waiting<br>";
              //  if ($req['approval_final_date']== null) echo "waiting<br>";
              //  if ($req['approval_final_date']== null) {if ($req['approval_mr']== 'Jim Handoko' && $req['approval_mr_date']== null)  echo "waiting<br>"; else echo "waiting<br>"; } else echo "waiting<br>";
                if ($req['status']!='approved') echo "waiting<br>";
                if ($req['approval1']!= null && $req['approval1_date']== null) echo "Approval 1 "."<b>$req->approval1</b><br>";
                if ($req['approval2']!= null && $req['approval2_date']== null) echo "Approval 2 "."<b>$req->approval2</b><br>";
                if ($req['approval_final']!== null && $req['approval_final_date']== null) echo "Approval Final "."<b>$req->approval_final</b><br>";
                if ($req['approval_mr']!== 'no' && $req['approval_mr_date']== null) echo "Approval MR "."<b>$req->approval_mr</b>";
         ?> </td>
        <td align='center' width='10%'>
        <a href='{{action('ReqHistoryController@view', $req['id'])}} ' class='btn btn-success btn-xs' >view</a>
        </td>
        </tr>

        @elseif ($req['approval_final'] == $user && $req['approval_final_date'] != null && $req['approval_mr'] != $user )

        <tr bgcolor="#fff" >
        <td align='center'>{{$req['id']}}</td>
        <td align='center'>{{$req['date_request']}}</td>
        <td align='center'>{{$req['reqby']}}</td>
        <td align='center'>{{$req['dept']}}</td>
        <td align='center'>{{$req['plant']}}</td>
        <td align='center'>{{$req['type']}}</td>
        <td align='center' bgcolor='#8bf76b'>
          <?php if ($req['approval1_date']!= null) echo "Approved by <b>".$req->approval1."</b> ".date('Y-m-d', strtotime($req->approval1_date))."<br>";
                if ($req['approval2_date']!= null) echo "Approved by <b>".$req->approval2."</b> ".date('Y-m-d', strtotime($req->approval2_date))."<br>";
                if ($req['approval_final_date']!= null) echo "Approved by <b>".$req->approval_final."</b> ".date('Y-m-d', strtotime($req->approval_final_date))."<br>";
                if ($req['approval_mr']!= 'no' && $req['approval_mr_date']!= null) echo "Approved by MR "."<b>$req->approval_mr</b> ".date('Y-m-d', strtotime($req->approval_final_date))."<br>";
                //if ($req['approval1']== null || $req['approval1_date']== null || $req['approval2']== null || $req['approval2_date']== null ||$req['approval_final']== null || $req['approval_final_date']== null)echo "waiting<br>";
              //  if ($req['approval_final_date']== null) echo "waiting<br>";
                //if ($req['approval_final_date']== null) {if ($req['approval_mr']== 'Jim Handoko' && $req['approval_mr_date']== null)  echo "waiting<br>"; else echo "waiting<br>"; } else echo "waiting<br>";
                if ($req['status']!='approved') echo "waiting<br>";
                if ($req['approval1']!= null && $req['approval1_date']== null) echo "Approval 1 "."<b>$req->approval1</b><br>";
                if ($req['approval2']!= null && $req['approval2_date']== null) echo "Approval 2 "."<b>$req->approval2</b><br>";
                if ($req['approval_final']!== null && $req['approval_final_date']== null) echo "Approval Final "."<b>$req->approval_final</b><br>";
                if ($req['approval_mr']!== null && $req['approval_mr_date']== null) echo "Approval MR "."<b>$req->approval_mr</b>";
         ?> </td>
        <td align='center' width='10%'>
        <a href='{{action('ReqHistoryController@view', $req['id'])}} ' class='btn btn-success btn-xs' >view</a>
        </td>
        </tr>

        @elseif ($req['approval_mr'] == $user && $req['approval_mr_date'] != null)
        <tr bgcolor="#fff" >
        <td align='center'>{{$req['id']}}</td>
        <td align='center'>{{$req['date_request']}}</td>
        <td align='center'>{{$req['reqby']}}</td>
        <td align='center'>{{$req['dept']}}</td>
        <td align='center'>{{$req['plant']}}</td>
        <td align='center'>{{$req['type']}}</td>
        <td align='center' bgcolor='#8bf76b'>
          <?php if ($req['approval1_date']!= null) echo "Approved by <b>".$req->approval1."</b> ".date('Y-m-d', strtotime($req->approval1_date))."<br>";
                if ($req['approval2_date']!= null) echo "Approved by <b>".$req->approval2."</b> ".date('Y-m-d', strtotime($req->approval2_date))."<br>";
                if ($req['approval_final_date']!= null) echo "Approved by <b>".$req->approval_final."</b> ".date('Y-m-d', strtotime($req->approval_final_date))."<br>";
                if ($req['approval_mr']!== 'no' && $req['approval_mr_date']!= null) echo "Approved by MR "."<b>$req->approval_mr</b> ".date('Y-m-d', strtotime($req->approval_mr_date))."<br>";
                //if ($req['approval1']== null || $req['approval1_date']== null || $req['approval2']== null || $req['approval2_date']== null ||$req['approval_final']== null || $req['approval_final_date']== null)echo "waiting<br>";
              //  if ($req['approval_final_date']== null) echo "waiting<br>";

         ?> </td>
        <td align='center' width='10%'>
        <a href='{{action('ReqHistoryController@view', $req['id'])}} ' class='btn btn-success btn-xs' >view</a>
        </td>
        </tr>
        @endif

  			<?php // $no++; ?>
  			@endforeach

  			</tbody>
  </table>

  <div>
  <label style="font-size:24px;">Rejected</label>
  </div>

  <table  class="table table-bordered" id='mt' width='100%' height="" data-toggle="dataTable" data-form="deleteForm">
  		<thead>
  		<tr >
  			<th style="color:white;" bgcolor="#666666" width='5%'>Req ID</th>
  			<th style="color:white;" bgcolor="#666666" width='10%'>Date</th>
  			<th style="color:white;" bgcolor="#666666" width='10%'>Req By</th>
  			<th style="color:white;" bgcolor="#666666" width='10%'>Dept</th>
        <th style="color:white;" bgcolor="#666666" width='10%'>Plant</th>
        <th style="color:white;" bgcolor="#666666" width='10%'>Req Type</th>
        <th style="color:white;" bgcolor="#666666" width='20%'>Status</th>
        <th style="color:white;" bgcolor="#666666" width='13%'>Action</th>
  		</tr>
  		</thead>
      <tbody >
  			<?php // $no = ($reqs->currentpage()-1)* $reqs->perpage() + 1;  ?>
  			@foreach($reqs as $req)

        @if ($req['status'] == 'reject' && $req['reject_by'] == $user)

  			<tr bgcolor="#fff" >
  			<td align='center'>{{$req['id']}}</td>
  			<td align='center'>{{$req['date_request']}}</td>
  			<td align='center'>{{$req['reqby']}}</td>
        <td align='center'>{{$req['dept']}}</td>
        <td align='center'>{{$req['plant']}}</td>
        <td align='center'>{{$req['type']}}</td>
        <td align='center' bgcolor='#cccccc'>Rejected by <b>{{ $req['reject_by'] }}</b> on {{$req['reject_date']}} reason <b>{{$req['reject_rmk']}} </b></td>
  			<td align='center' width='10%'>
  			<a href='{{action('ReqHistoryController@view', $req['id'])}} ' class='btn btn-success btn-xs' >view</a>
  			</td>
  			</tr>

        @endif

  			<?php // $no++; ?>
  			@endforeach

  			</tbody>
  </table>

</div>
@endsection
