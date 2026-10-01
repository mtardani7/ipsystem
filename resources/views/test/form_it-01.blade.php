@extends('layouts.app')

@section('content')
<div class="container">

  <label style="font-size:24px;">Create Request</label>
  <table class="table">
    <tbody>
      <tr>
        <td style="text-align: left; width: 15%;font-weight:bold;">Request ID</td>
        <td style="text-align: left; width: 2%;"><b>:</b></td>
        <td style="text-align: left; width: 33%;">{{$request_id}}</td>
        <td style="text-align: left; width: 15%;font-weight:bold;">Type</td>
        <td style="text-align: left; width: 2%;"><b>:</b></td>
        <td style="text-align: left; width: 33%;">{{$reqtype}}</td>
      </tr>
      <tr>
        <td style="text-align: left; width: 15%;font-weight:bold;">Request By</td>
        <td style="text-align: left; width: 2%;"><b>:</b></td>
        <td style="text-align: left; width: 33%;">{{$reqby}}</td>
        <td style="text-align: left; width: 15%;font-weight:bold;">Date</td>
        <td style="text-align: left; width: 2%;"><b>:</b></td>
        <td style="text-align: left; width: 33%;">{{date("d F Y")}}</td>
      </tr>
      <tr>
        <td style="text-align: left; width: 15%;font-weight:bold;">Department</td>
        <td style="text-align: left; width: 2%;"><b>:</b></td>
        <td style="text-align: left; width: 33%;">{{$reqdept}}</td>
        <td style="text-align: left; width: 15%;font-weight:bold;">Plant</td>
        <td style="text-align: left; width: 2%;"><b>:</b></td>
        <td style="text-align: left; width: 33%;">{{$reqplant}}</td>
      </tr>
    </tbody>
  </table>
  <h4 style="color:blue;">Pengajuan Permintaan Instalasi / Perbaikan / Perubahan Hardware / Software</h4>

<form class="form-horizontal" name="New" enctype="multipart/form-data" method="POST" action="fill_req_frmit01">
{{csrf_field()}}

<table class="table table-bordered">
  <thead>
    <tr>

    </tr>
  </thead>
  <tbody>
    <tr>
      <td bgcolor="#bfbfbf" style="text-align: left;vertical-align: top;" >Jenis Request</td>
      <td><input type="checkbox" id="baru" name="baru" value="baru"> Baru</td>
      <td><input type="checkbox" id="perbaikan" name="perbaikan" value="perbaikan"> Perbaikan/perubahan</td>
      <td><input type="checkbox" id="penggantian" name="penggantian" value="penggantian"> Penggantian karena rusak</td>
      <td><input type="checkbox" id="instalasi" name="instalasi" value="instalasi"> Instalasi</td>
    </tr>
    <tr>
      <td bgcolor="#bfbfbf" style="text-align: left;vertical-align: top;" >Type</td>
      <td><input type="checkbox" id="hardware" name="hardware" value="hardware"> Hardware</td>
      <td><input type="checkbox" id="software" name="software" value="software"> Software</td>
      <td> Nama Hardware/Software</td>
      <td><input type="text" id="nama_hwsw" name="nama_hwsw" class="form-control" ></td>
    </tr>
    <tr>
      <td bgcolor="#bfbfbf" style="text-align: left;vertical-align: top;" >Function</td>
      <td><input type="checkbox" id="drawing" name="drawing" value="drawing"> Drawing</td>
      <td><input type="checkbox" id="officeadm" name="officeadm" value="officeadm"> Office Admin</td>
    </tr>
  </tbody>
</table>
<label for="inputPassword3" class="control-label">Alasan Permohonan</label>
<textarea class="form-control" rows="3" name="desc" id="desc"></textarea>

<br><p style="margin-bottom: 0em;">* Upload lampiran jika perlu</p>
<label for="email">Dokumen :</label>
<input type="file" name="file_lampiran"><br>

<table class="table table-bordered">
  <thead>
    <tr>
      <th bgcolor="#bfbfbf" colspan='5'>Untuk Diisi oleh Departemen Information Technology</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td bgcolor="#bfbfbf" style="text-align: left;vertical-align: top;" >Availability Check</td>
      <td><input type="checkbox" id="yes" name="yes" value="yes"> Yes</td>
      <td><input type="checkbox" id="no" name="no" value="no"> No</td>
    </tr>
    <tr>
      <td bgcolor="#f2f2f2" style="text-align: center;vertical-align: top;" >Office</td>
      <td bgcolor="#f2f2f2" style="text-align: center;vertical-align: top;" >Mobile</td>
      <td bgcolor="#f2f2f2" style="text-align: center;vertical-align: top;" >Director</td>
    </tr>
    <tr>
      <td><input type="text" id="office" name="office" class="form-control" ></td>
      <td><input type="text" id="mobile" name="mobile" class="form-control" ></td>
      <td><input type="text" id="director" name="director" class="form-control" ></td>
    </tr>
    <tr>
      <td bgcolor="#bfbfbf" style="text-align: left;vertical-align: top;" >No. Asset</td>
      <td><input type="text" id="noasset" name="noasset" class="form-control" ></td>
    </tr>
    <tr>
      <td bgcolor="#bfbfbf" style="text-align: left;vertical-align: top;" >No. Serial</td>
      <td><input type="text" id="noserial" name="noserial" class="form-control" ></td>
    </tr>
    <tr>
      <td bgcolor="#bfbfbf" style="text-align: left;vertical-align: top;" >Tanggal</td>
      <td><input type="text" id="date" name="date" class="form-control" ></td>
    </tr>
  </tbody>
</table>

<input type="hidden" name="request_id"  id='request_id' value="{{$request_id}}"><br>
<br><button type="submit" class="col-sm-offset-8 col-sm-4 btn btn-sm btn-primary"><b>Submit</b></button>

</form>

</div>
@endsection
