@extends('layouts.app')

@section('content')

<div class="container">
  @if (Auth::user()->name == 'rapidplast')

  user <b>rapidplast</b> are not allowed to create requests, please login with your personal user to create requests.
  @else
  @if (Session::has('data'))
  <div class="custom-alerts alert alert-success fade in">
    {{ Session::get('data')}}
  </div>
  @endif
  @if (!empty($documentReviewNotice))
  <div class="alert alert-success">{{ $documentReviewNotice }}</div>
  @endif

  <label style="font-size:24px;">Create Request</label>

  <form class="form-horizontal" method='post' action='create_req_form'>
    {{csrf_field()}}

    <table class="table">
      <thead>
      </thead>
      <tbody>
        <tr>
          <td style="text-align: left; width: 15%;font-weight:bold;">Date</td>
          <td style="text-align: left; width: 2%;"><b>:</b></td>
          <td style="text-align: left; width: 33%;"><input type="text" id="req_date" name="req_date" class="form-control" value="{{date("d F Y")}}" readonly /></td>
          <td style="text-align: left; width: 15%;font-weight:bold;">Department</td>
          <td style="text-align: left; width: 2%;"><b>:</b></td>
          <td style="text-align: left; width: 33%;"><input type="text" id="req_dept" name="req_dept" class="form-control" value="{{ Auth::user()->dept }}" readonly /></td>
        </tr>
        <tr>
          <td style="text-align: left; width: 15%;font-weight:bold;">Request By</td>
          <td style="text-align: left; width: 2%;"><b>:</b></td>
          <td style="text-align: left; width: 33%;"><input type="text" id="req_by" name="req_by" class="form-control" value="{{ Auth::user()->username }}" readonly /></td>
          <td style="text-align: left; width: 15%;font-weight:bold;">Plant</td>
          <td style="text-align: left; width: 2%;"><b>:</b></td>
          <td style="text-align: left; width: 33%;"><input type="text" id="req_plant" name="req_plant" class="form-control" value="{{Auth::user()->plant}}" readonly /></td>
        </tr>
      </tbody>
    </table>

    <table class="table">
      <tbody>
        <tr>
          <td style="text-align: left; width: 15%;font-weight:bold;">Request Type</td>
          <td style="text-align: left; width: 2%;"><b>:</b></td>
          <td style="text-align: left; width: 83%;">
            <select id='req_type' name='req_type' class='form-control' required>
              <option value=''>- select -&nbsp;</option>
              <option value='p4-no7'>Pengajuan Permintaan / Perubahan / Pembatalan Dokumen / Catatan Mutu - Keamanan Pangan - SHE (FRM/01-PQMS/07)&nbsp;</option>
              <option value='p4-no8'>Pengajuan Permintaan / Pemusnahan Salinan Dokumen Softcopy / Hardcopy (FRM/01-PQMS/08)&nbsp;</option>
              <!--<option value='p4-no9'>Pengajuan Permintaan Form Cetakan &nbsp;</option>-->
              <option value='change-folder'>Penambahan / Perubahan / Penghapusan Folder Dokumen &nbsp;</option>
              <option value='frm-it-01'>Pengajuan Permintaan Instalasi / Perbaikan / Perubahan Hardware / Software (FRM/05-IT/01)&nbsp;</option>
            </select>
          </td>
        </tr>
        <tr>
          <td style="text-align: left; width: 15%;font-weight:bold;"><button type="submit" class="btn btn-sm btn-primary">Submit</button></td>
        </tr>
      </tbody>
    </table>
  </form>
  @endif
</div>
@endsection