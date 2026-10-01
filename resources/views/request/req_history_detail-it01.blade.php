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
   @if ($req->verified_date != null) <li class="list-group-item list-group-item-success"> <?php echo "Verfied by <b>IT</b> ".date('Y-m-d', strtotime($req->verified_date)); ?> </li> @endif
   @if ($req->approval1_date != null) <li class="list-group-item list-group-item-success"> <?php echo "Approved by <b>".$req->approval1."</b> ".date('Y-m-d', strtotime($req->approval1_date)); ?> </li> @endif
   @if ($req->approval2_date != null) <li class="list-group-item list-group-item-success"><?php echo "Approved by <b>".$req->approval2."</b> ".date('Y-m-d', strtotime($req->approval2_date)); ?>  </li> @endif
   @if ($req->approval_final_date != null) <li class="list-group-item list-group-item-success"><?php echo "Approved by <b>".$req->approval_final."</b> ".date('Y-m-d', strtotime($req->approval_final_date)); ?>  </li> @endif
   @if ($req->approval_mr_date != null) <li class="list-group-item list-group-item-success"><?php echo "Approved by MR <b>".$req->approval_mr."</b> ".date('Y-m-d', strtotime($req->approval_mr_date)); ?>  </li> @endif

   @if ($req->status == 'reject') <li class="list-group-item list-group-item-danger"><?php echo "Rejected by  <b>".$req->reject_by."</b> ".date('Y-m-d', strtotime($req->reject_date))." : ".$req->reject_rmk; ?>  </li> @endif
   @if ($req->verified_date == null) <li class="list-group-item list-group-item-warning"> <?php echo "Waiting Verification <b>IT</b> "; ?> </li> @endif
   @if ($req->approval1 != null && $req->approval1_date == null) <li class="list-group-item list-group-item-warning"> <?php echo "Waiting Approval <b>".$req->approval1."</b> "; ?> </li> @endif
   @if ($req->approval2 != null && $req->approval2_date == null) <li class="list-group-item list-group-item-warning"><?php echo "Waiting Approval <b>".$req->approval2."</b> "; ?>  </li> @endif
   @if ($req->approval_final != null && $req->approval_final_date == null) <li class="list-group-item list-group-item-warning"><?php echo "Waiting Approval <b>".$req->approval_final."</b> "; ?>  </li> @endif
   @if ($req->approval_mr != null && $req->approval_mr_date == null) <li class="list-group-item list-group-item-warning"><?php echo "Waiting Approval MR <b>".$req->approval_mr."</b> "; ?>  </li> @endif
  </ul>

  <h4 style="color:blue;">Pengajuan Permintaan Instalasi / Perbaikan / Perubahan Hardware / Software</h4>

@if ($actions=='edit')
<form class="form-horizontal" name="New" enctype="multipart/form-data" method="POST" action="{{ action('RequestController@update_req_frmit01') }}">
{{csrf_field()}}
@elseif ($actions=='verification')
  <form class="form-horizontal" name="New" enctype="multipart/form-data" method="post" action="{{ action('ReqIncomingController@verification_frmit01') }}" >
  {{csrf_field()}}
@endif
<table class="table table-bordered">
  <thead>
    <tr>

    </tr>
  </thead>
  <tbody>
    <tr>
      <td bgcolor="#bfbfbf" style="text-align: left;vertical-align: top;" >Jenis Request</td>
      <td><input type="checkbox" id="baru" name="baru" value="baru" <?php if (strpos($data->request_type, 'baru') !== false) echo "checked"; ?> > Baru</td>
      <td><input type="checkbox" id="perbaikan" name="perbaikan" value="perbaikan" <?php if (strpos($data->request_type, 'perbaikan') !== false) echo "checked"; ?> > Perbaikan/perubahan</td>
      <td><input type="checkbox" id="penggantian" name="penggantian" value="penggantian" <?php if (strpos($data->request_type, 'penggantian') !== false) echo "checked"; ?> > Penggantian karena rusak</td>
      <td><input type="checkbox" id="instalasi" name="instalasi" value="instalasi" <?php if (strpos($data->request_type, 'instalasi') !== false) echo "checked"; ?> > Instalasi</td>
    </tr>
    <tr>
      <td bgcolor="#bfbfbf" style="text-align: left;vertical-align: top;" >Type</td>
      <td><input type="checkbox" id="hardware" name="hardware" value="hardware" <?php if (strpos($data->item_type, 'hardware') !== false) echo "checked"; ?> > Hardware</td>
      <td><input type="checkbox" id="software" name="software" value="software" <?php if (strpos($data->item_type, 'software') !== false) echo "checked"; ?> > Software</td>
      <td><input type="checkbox" id="application" name="application" value="application" <?php if (strpos($data->item_type, 'application') !== false) echo "checked"; ?>> Application (COA/IPSystem/HRIS)</td>
      <td><input type="checkbox" id="connection" name="connection" value="connection" <?php if (strpos($data->item_type, 'connection') !== false) echo "checked"; ?>> Internet Connection</td>
    </tr>
    <tr>
      <td bgcolor="#bfbfbf" style="text-align: left;vertical-align: top;" ></td>
      <td> Nama Hardware/Software</td>
      <td><input type="text" id="nama_hwsw" name="nama_hwsw" class="form-control" value="{{$data->item_name}}" ></td>
      <td> Nomor Equipment (NE)</td>
      <td><input type="text" id="ne" name="ne" class="form-control" value="{{$data->item_ne}}"></td>
    </tr>
    <tr>
      <td bgcolor="#bfbfbf" style="text-align: left;vertical-align: top;" >Function</td>
      <td><input type="checkbox" id="drawing" name="drawing" value="drawing" <?php if (strpos($data->function , 'drawing') !== false) echo "checked"; ?> > Drawing</td>
      <td><input type="checkbox" id="officeadm" name="officeadm" value="officeadm" <?php if (strpos($data->function , 'officeadm') !== false) echo "checked"; ?> > Office Admin</td>
    </tr>
  </tbody>
</table>
<label for="inputPassword3" class="control-label">Alasan Permohonan</label>
<textarea class="form-control" rows="3" name="desc" id="desc">{{$data->reason}}</textarea>

<br><p style="margin-bottom: 0em;">* Upload lampiran jika perlu</p>
<label for="email">Dokumen :</label>
<a href="{{URL::to('/')}}/public/uploads/file/req_form-it-01/{{$data->file_lampiran}}"  download  >{{$data->file_lampiran}}</a><br>

@if ($actions=='edit')
<label for="email">Change file :</label>
<input id="fileopen" type="file" name="file_lampiran_ch">
<button type="button" id="clear">Clear</button><br><br>

@endif




@if ($actions=='edit')
    <input type="hidden" name="request_id"  id='request_id' value="{{$req->id}}">
    <label for="email">Edit Action :</label>
    <input type="hidden" name="file_lampiran_ori"  id='file_lampiran_ori' value="{{$data->file_lampiran}}">
    <button type="submit" class="btn btn-xs btn-primary">Update</button>
    <a href='javascript:history.back()' class='btn btn-xs btn-success' >Cancel</a>
</form>
@elseif ($actions=='verification')
    <input type="hidden" name="request_id"  id='request_id' value="{{$req->id}}">
    <label for="email">Verification Action :</label>
    <button type="submit" class="btn btn-xs btn-primary">Verify</button>
    <a href='javascript:history.back()' class='btn btn-xs btn-success' >Cancel</a>
</form>
@endif

@if ($req->reqby == Auth::user()->username)
<br>
<table class="table table-bordered">
  <thead>
    <tr>
      <th bgcolor="#bfbfbf" colspan='5'>Untuk Diisi oleh Departemen Information Technology</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td bgcolor="#bfbfbf" style="text-align: left;vertical-align: top;" >Availability Check</td>
      <td><input type="checkbox" id="avail-yes" name="avail-yes" value="yes" <?php if ($data->availability_check=='yes') echo "checked"; ?> > Yes</td>
      <td><input type="checkbox" id="avail-no" name="avail-no" value="no" <?php if ($data->availability_check=='no') echo "checked"; ?> > No</td>
    </tr>
    <tr>
      <td bgcolor="#f2f2f2" style="text-align: center;vertical-align: top;" >Office</td>
      <td bgcolor="#f2f2f2" style="text-align: center;vertical-align: top;" >Mobile</td>
      <td bgcolor="#f2f2f2" style="text-align: center;vertical-align: top;" >Director</td>
    </tr>
    <tr>
      <td><input type="text" id="office" name="office" class="form-control" value="{{$data->office_pc }}" ></td>
      <td><input type="text" id="mobile" name="mobile" class="form-control" value="{{$data->mobile_laptop }}" ></td>
      <td><input type="text" id="director" name="director" class="form-control" value="{{$data->director_laptop }}" ></td>
    </tr>
    <tr>
      <td bgcolor="#bfbfbf" style="text-align: left;vertical-align: top;" >No. Asset</td>
      <td><input type="text" id="noasset" name="noasset" class="form-control" value="{{$data->no_asset }}" ></td>
    </tr>
    <tr>
      <td bgcolor="#bfbfbf" style="text-align: left;vertical-align: top;" >No. PR</td>
      <td><input type="text" id="nopr" name="nopr" class="form-control" value="{{$data->no_pr }}" ></td>
    </tr>
    <tr>
      <td bgcolor="#bfbfbf" style="text-align: left;vertical-align: top;" >Tanggal</td>
      <td><input type="text" id="date" name="date" class="form-control" value="{{$data->date }}"></td>
    </tr>
  </tbody>
</table>
@endif

@if ($req->approval1 == $user || $req->approval2 == $user || $req->approval_final == $user)

<form class="form-horizontal" method='post' action='{{ action('ReqApprovalController@approve') }}'>
{{csrf_field()}}

    <table class="table table-bordered">
      <thead>
        <tr>
          <th bgcolor="#bfbfbf" colspan='5'>Untuk Diisi oleh Departemen Information Technology</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td bgcolor="#bfbfbf" style="text-align: left;vertical-align: top;" >Availability Check</td>
          <td><input type="checkbox" id="avail-yes" name="avail-yes" value="yes" <?php if ($data->availability_check=='yes') echo "checked"; ?> > Yes</td>
          <td><input type="checkbox" id="avail-no" name="avail-no" value="no" <?php if ($data->availability_check=='no') echo "checked"; ?> > No</td>
        </tr>
        <tr>
          <td bgcolor="#f2f2f2" style="text-align: center;vertical-align: top;" >Office</td>
          <td bgcolor="#f2f2f2" style="text-align: center;vertical-align: top;" >Mobile</td>
          <td bgcolor="#f2f2f2" style="text-align: center;vertical-align: top;" >Director</td>
        </tr>
        <tr>
          <td><input type="text" id="office" name="office" class="form-control" value="{{$data->office_pc }}" ></td>
          <td><input type="text" id="mobile" name="mobile" class="form-control" value="{{$data->mobile_laptop }}" ></td>
          <td><input type="text" id="director" name="director" class="form-control" value="{{$data->director_laptop }}" ></td>
        </tr>
        <tr>
          <td bgcolor="#bfbfbf" style="text-align: left;vertical-align: top;" >No. Asset</td>
          <td><input type="text" id="noasset" name="noasset" class="form-control" value="{{$data->no_asset }}" ></td>
        </tr>
        <tr>
          <td bgcolor="#bfbfbf" style="text-align: left;vertical-align: top;" >No. PR</td>
          <td><input type="text" id="nopr" name="nopr" class="form-control" value="{{$data->no_pr }}" required></td>
        </tr>
        <tr>
          <td bgcolor="#bfbfbf" style="text-align: left;vertical-align: top;" >Tanggal</td>
          <td><input type="text" id="date" name="date" class="form-control" value="{{$data->date }}"></td>
        </tr>
      </tbody>
    </table>

    <input type="hidden" name="request_id"  id='request_id' value="{{$req->id}}">
   @if ($req->status == 'waiting')
    <label for="email">Action :</label>
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

<script type="text/javascript">
    $('.date').datepicker({
       format: 'yyyy-mm-dd'
     });

     $("#clear").click(function () {
     $("#fileopen").val("");
      });

</script>
@endsection
