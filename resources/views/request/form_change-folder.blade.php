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
  <h4 style="color:blue;">Penambahan / Perubahan / Penghapusan Folder Dokumen</h4>
  <form class="form-horizontal" name="New" enctype="multipart/form-data" method="POST" action="fill_req_chfolder">
    {{csrf_field()}}
    <table class="table table-bordered">
      <thead>
        <tr>
          <th bgcolor="#bfbfbf" colspan='1'>Jenis Request</th>
        </tr>
      </thead>
      <tbody>
        <td style="text-align: left;vertical-align: top;">
          <input type="checkbox" id="tambah" name="tambah" value="penambahan"> Penambahan Folder baru<br>
          <input type="checkbox" id="ubah" name="ubah" value="perubahan"> Perubahan Folder<br>
          <input type="checkbox" id="hapus" name="hapus" value="penghapusan"> Penghapusan Folder
        </td>
        </tr>
      </tbody>
    </table>
    <label for="inputPassword3" class="control-label">Deskripsi</label>
    <textarea class="form-control" rows="3" name="desc" id="desc"></textarea>
    <br>
    <p style="margin-bottom: 0em;">* Upload lampiran jika perlu</p>
    <label for="email">Dokumen :</label>
    <input type="file" name="file_lampiran"><br>

    <input type="hidden" name="request_id" id='request_id' value="{{$request_id}}"><br>
    <br><button type="submit" class="col-sm-offset-8 col-sm-4 btn btn-sm btn-primary"><b>Submit</b></button>
  </form>
</div>
@endsection