@extends('layouts.app')

@section('content')

<div class="container">
  <label style="font-size:24px;">Request Detail</label>
  <table class="table">
    <tbody>
      <tr>
        <td style="text-align: left; width: 15%;font-weight:bold;">Request ID</td>
        <td style="text-align: left; width: 2%;"><b>:</b></td>
        <td style="text-align: left; width: 33%;">{{$req->id}}</td>
        <td style="text-align: left; width: 15%;font-weight:bold;">Type</td>
        <td style="text-align: left; width: 2%;"><b>:</b></td>
        <td style="text-align: left; width: 33%;">{{$req->type}}</td>
      </tr>
      <tr>
        <td style="text-align: left; width: 15%;font-weight:bold;">Request By</td>
        <td style="text-align: left; width: 2%;"><b>:</b></td>
        <td style="text-align: left; width: 33%;">{{$req->reqby}}</td>
        <td style="text-align: left; width: 15%;font-weight:bold;">Date</td>
        <td style="text-align: left; width: 2%;"><b>:</b></td>
        <td style="text-align: left; width: 33%;">{{ date('d F Y', strtotime($req->date_request)) }}</td>
      </tr>
      <tr>
        <td style="text-align: left; width: 15%;font-weight:bold;">Department</td>
        <td style="text-align: left; width: 2%;"><b>:</b></td>
        <td style="text-align: left; width: 33%;">{{$req->dept}}</td>
        <td style="text-align: left; width: 15%;font-weight:bold;">Plant</td>
        <td style="text-align: left; width: 2%;"><b>:</b></td>
        <td style="text-align: left; width: 33%;">{{$req->plant}}</td>
      </tr>
    </tbody>
  </table>

  <ul class="list-group">
   @if ($req->approval1_date != null) <li class="list-group-item list-group-item-success"> <?php echo "Approved by <b>".$req->approval1."</b> ".date('Y-m-d', strtotime($req->approval1_date)); ?> </li> @endif
   @if ($req->approval2_date != null) <li class="list-group-item list-group-item-success"><?php echo "Approved by <b>".$req->approval2."</b> ".date('Y-m-d', strtotime($req->approval2_date)); ?>  </li> @endif
   @if ($req->approval_final_date != null) <li class="list-group-item list-group-item-success"><?php echo "Approved by <b>".$req->approval_final."</b> ".date('Y-m-d', strtotime($req->approval_final_date)); ?>  </li> @endif
   @if ($req->approval_mr_date != null) <li class="list-group-item list-group-item-success"><?php echo "Approved by MR <b>".$req->approval_mr."</b> ".date('Y-m-d', strtotime($req->approval_mr_date)); ?>  </li> @endif

   @if ($req->status == 'reject') <li class="list-group-item list-group-item-danger"><?php echo "Rejected by  <b>".$req->reject_by."</b> ".date('Y-m-d', strtotime($req->reject_date))." : ".$req->reject_rmk; ?>  </li> @endif
   @if ($req->approval1 != null && $req->approval1_date == null) <li class="list-group-item list-group-item-warning"> <?php echo "Waiting Approval <b>".$req->approval1."</b> "; ?> </li> @endif
   @if ($req->approval2 != null && $req->approval2_date == null) <li class="list-group-item list-group-item-warning"><?php echo "Waiting Approval <b>".$req->approval2."</b> "; ?>  </li> @endif
   @if ($req->approval_final != null && $req->approval_final_date == null) <li class="list-group-item list-group-item-warning"><?php echo "Waiting Approval <b>".$req->approval_final."</b> "; ?>  </li> @endif
   @if ($req->approval_mr != null && $req->approval_mr_date == null) <li class="list-group-item list-group-item-warning"><?php echo "Waiting Approval MR <b>".$req->approval_mr."</b> "; ?>  </li> @endif

  </ul>

  <h4 style="color:blue;">Penambahan / Perubahan / Penghapusan Folder Dokumen</h4>

@if ($actions=='edit')
<form class="form-horizontal" method='post' action='{{ action('RequestController@update_chfolder') }}'>
{{csrf_field()}}
@endif
<table class="table table-bordered">
  <thead>
    <tr>
      <th bgcolor="#bfbfbf" colspan='1'>Jenis Request</th>
    </tr>
  </thead>
  <tbody>
      <td style="text-align: left;vertical-align: top;" >
        <input type="checkbox" id="tambah" name="tambah" value="penambahan" <?php if (strpos($data->change_type, 'penambahan') !== false) echo "checked"; ?> > Penambahan Folder baru<br>
        <input type="checkbox" id="ubah" name="ubah" value="perubahan" <?php if (strpos($data->change_type, 'perubahan') !== false) echo "checked"; ?> > Perubahan Folder<br>
        <input type="checkbox" id="hapus" name="hapus" value="penghapusan" <?php if (strpos($data->change_type, 'penghapusan') !== false) echo "checked"; ?> > Penghapusan Folder
      </td>
    </tr>
  </tbody>
</table>
<label for="inputPassword3" class="control-label">Deskripsi</label>
<textarea class="form-control" rows="3" name="desc" id="desc">{{$data->description}}</textarea>

<br><p style="margin-bottom: 0em;">* Upload lampiran jika perlu</p>
<label for="email">Dokumen :</label>
<a href="{{URL::to('/')}}/public/uploads/file/req_change-folder/{{$data->file}}"  download  >{{$data->file}}</a><br>


@if ($actions=='edit')
    <input type="hidden" name="request_id"  id='request_id' value="{{$req->id}}">
    <label for="email">Edit Action :</label>
    <button type="submit" class="btn btn-xs btn-primary">Update</button>
    <a href='javascript:history.back()' class='btn btn-xs btn-success' >Cancel</a>
</form>
@endif

@if ($req->approval1 == $user || $req->approval2 == $user || $req->approval_final == $user || $req->approval_mr == $user)
@if ($req->status == 'waiting')
<form class="form-horizontal" method='post' action='{{ action('ReqApprovalController@approve') }}'>
{{csrf_field()}}
    <input type="hidden" name="request_id"  id='request_id' value="{{$req->id}}">
    <label for="email">Approval Action :</label>

    <button type="submit" class="btn btn-xs btn-primary">Approve</button>
</form>

    <form class="form-horizontal" method='post' action='{{ action('ReqApprovalController@reject') }}'>
    {{csrf_field()}}
        <input type="hidden" name="request_id"  id='request_id' value="{{$req->id}}">
        <a href='javascript:history.back()' class='btn btn-xs btn-success' >Back</a>
        <button type="submit" class="btn btn-xs btn-primary">Reject</button>
    </form>
    @endif
@endif

</div>
@endsection
