@extends('layouts.app')

@section('content')
<div class="container">
  <div>
  <label style="font-size:24px;">Manage Approval MR</label>
  </div>

<a href='{{action('ApprovalHirarkiController@index')}}' class='btn btn-xs btn-default'>Approval Hirarki</a>

  <table  class="table table-bordered" id='mt' width='100%' height="" data-toggle="dataTable" data-form="deleteForm">
  		<thead>
  		<tr >
  			<th style="color:white;" bgcolor="#666666" width='40'>ID.</th>
  			<th style="color:white;" bgcolor="#666666" width='150'>Approver</th>
  			<th style="color:white;" bgcolor="#666666" width='150'>Name</th>
        <th style="color:white;" bgcolor="#666666" width='100'>Action</th>
  		</tr>
  		</thead>
  		<tbody >
  			@php  $no = ($datas->currentpage()-1)* $datas->perpage() + 1;  @endphp
  			@foreach($datas as $data)

  			<tr bgcolor="#fff" >
  			<td align='center'>{{$data->id}}</td>
  			<td align='center'>{{$data->approver}}</td>
  			<td align='center'>{{$data->name}}</td>
  			<td align='center' width='10%'>
  			<span style="float:left;"><a href='{{action('ApprovalHirarkiController@mredit', $data->id)}} ' class='btn btn-success btn-xs' >edit</a>
        </span> |
        <span style="float:right;">
        <form class="form-delete" method='post' action='#'>
  			<input type="hidden" name="_method" value="delete" />
  	    <input type="hidden" name="_token" value="{{ csrf_token() }}">
  			<button type="submit" class="btn btn-danger btn-xs" name="delete_modal" >Delete</button>
  			</form>

        </span>
  			</td>
  			</tr>

  			@php $no++; @endphp
  			@endforeach

  			</tbody>
  	</table>
  	{{ $datas->links() }}

</div>
@endsection
