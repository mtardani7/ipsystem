<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
	<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" >
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('css/theme.css') }}" rel="stylesheet">
	<link href="{{ asset('css/sticky-footer-navbar.css') }}" rel="stylesheet">
	<script src="{{ asset('js/jquery.min.js') }}"></script>
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>-->
  <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css" rel="stylesheet">-->
  <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>-->
  <link href="{{ asset('css/bootstrap-datepicker.css') }}" rel="stylesheet">
  <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
</head>
<body>
<div class="container">
  <label style="font-size:24px;"> Request Detail</label>
  <table class="table">
    <tbody>
      <tr>
        <td style="text-align: left; width: 15%;font-weight:bold;">No. Form</td>
        <td style="text-align: left; width: 2%;"><b>:</b></td>
        <td style="text-align: left; width: 33%;">{{$req->id}}</td>
        <td style="text-align: left; width: 15%;font-weight:bold;">Type</td>
        <td style="text-align: left; width: 2%;"><b>:</b></td>
        <td style="text-align: left; width: 33%;"><?php if ($req->type = 'form_p4-no7'){echo "FRM/01-PQMS/07";}elseif ($req->type = 'form_p4-no8'){echo "FRM/01-PQMS/08";} ?></td>
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

  <h4 style="color:blue;">Pengajuan Permintaan / Perubahan / Pembatalan Dokumen / Catatan Mutu - Keamanan Pangan - SHE</h4>

@if ($actions=='edit')
  <form class="form-horizontal" name="New" enctype="multipart/form-data" method='post' action='{{ route('update_req_form7') }}' >
  {{csrf_field()}}
@elseif ($actions=='verification')
  <form class="form-horizontal" name="New" enctype="multipart/form-data" method='post' action='{{ route('verification_form7') }}' >
  {{csrf_field()}}
@endif

    <div class="col-md-6">
          <table class="table table-bordered table-striped table-highlight">
              <thead>
              </thead>
              <tbody>
  				          <tr>
                      <td width='200'>Masa percobaan (isi jika perlu)</td>
                      <td width=''>{{$data->trial_time}}</td>
                    </tr>
  				             <tr>
                      <td width='200'>Target tgl efektif perubahan</td>
                      <td>{{$data->date_effective}}</td>
                    </tr>
              </tbody>
          </table>
        </div>

  		<table class="table table-bordered">
              <thead>
  				<tr>
  				<th bgcolor="#bfbfbf" colspan='3'>KATEGORI</th>
  				</tr>
  				<tr>
  				<th bgcolor="#bfbfbf" colspan='1'>DOCUMENT MUTU - KEAMANAN KEMASAN - SHE</th>
  				<th bgcolor="#bfbfbf" colspan='1'>CATATAN MUTU - KEAMANAN KEMASAN - SHE</th>
  				<th bgcolor="#bfbfbf" width='350'>PENGAJUAN</th>
  				</tr>
              </thead>
              <tbody>
  				 <tr >
                      <td style="text-align: left;">
  						 <input onclick="return false;" type="checkbox" id="psqm" name="psqm" value="PSQM" <?php if (strpos($data->cat_doc, 'PSQM') !== false) echo "checked"; ?> > Packaging Safety - Quality manual (PSQM)<br>
  						 <input onclick="return false;" type="checkbox" id="oc" name="oc" value="OC" <?php if (strpos($data->cat_doc, 'OC') !== false) echo "checked"; ?> > Organization Chart (OC)<br>
  						 <input onclick="return false;" type="checkbox" id="jd" name="jd" value="JD" <?php if (strpos($data->cat_doc, 'JD') !== false) echo "checked"; ?> > Job Description (JD)<br>
  						 <input onclick="return false;" type="checkbox" id="sop" name="sop" value="SOP" <?php if (strpos($data->cat_doc, 'SOP') !== false) echo "checked"; ?> > Standard Operating Procedure (SOP)<br>
  						 <input onclick="return false;" type="checkbox" id="wi" name="wi" value="WI" <?php if (strpos($data->cat_doc, 'WI') !== false) echo "checked"; ?> > Work Instruction (WI)<br>
  						 <input onclick="return false;" type="checkbox" id="prp" name="prp" value="HACCP" <?php if (strpos($data->cat_doc, 'HACCP') !== false) echo "checked"; ?> > PRPs Document / HACCP Study<br>
  						 <input onclick="return false;" type="checkbox" id="ext" name="ext" value="ext" <?php if (strpos($data->cat_doc, 'ext') !== false) echo "checked"; ?> > External Document <?php $parsed_ext = get_string_between($data->cat_doc, 'ext(', '),'); ?> <input readonly type="text" id="ext_txt" name="ext_txt" value="{{$parsed_ext}}" ><br>
  						 <input onclick="return false;" type="checkbox" id="other" name="other" value="other" <?php if (strpos($data->cat_doc, 'other') !== false) echo "checked"; ?> > Other <?php $parsed_o = get_string_between($data->cat_doc, 'other(', '),'); ?> <input readonly type="text" id="other_txt" name="other_txt" value="{{$parsed_o}}" ><br>
  					</td>
                      <td style="text-align: left;vertical-align: top;" ><input onclick="return false;" type="checkbox" id="form" name="form" value="form" <?php if (strpos($data->cat_doc, 'form') !== false) echo "checked"; ?>> Form (Record)</td>
  					 <td style="text-align: left;vertical-align: top;" >
  						<input onclick="return false;" type="checkbox" id="baru" name="baru" value="baru" <?php if (strpos($data->cat_type, 'baru') !== false) echo "checked"; ?> > Permintaan Baru<br>
  						<input onclick="return false;" type="checkbox" id="ubah" name="ubah" value="perubahan" <?php if (strpos($data->cat_type, 'perubahan') !== false) echo "checked"; ?> > Perubahan<br>
  						<input onclick="return false;" type="checkbox" id="batal" name="batal" value="pembatalan" <?php if (strpos($data->cat_type, 'pembatalan') !== false) echo "checked"; ?> > Pembatalan
  					 </td>
                  </tr>
              </tbody>
          </table>

  		<table class="table table-bordered">
              <thead>
  				<tr>
  				<th bgcolor="#bfbfbf" colspan='7'>PERMINTAAN BARU</th>
  				</tr>
  				<tr>
          <th bgcolor="#bfbfbf">No.</th>
  				<th bgcolor="#bfbfbf" colspan='1'>No. Dokumen</th>
  				<th bgcolor="#bfbfbf" colspan='1'>No. Revisi</th>
  				<th bgcolor="#bfbfbf" width='230'>Nama Dokumen</th>
  				<th bgcolor="#bfbfbf" width='220'>Masa Penyimpanan</th>
  				<th bgcolor="#bfbfbf" width='220'>Cara Pengurutan</th>
  				<th bgcolor="#bfbfbf" width='220'>Cara Pemusnahan</th>
  				</tr>
              </thead>
              <tbody>
                <?php
							$new_nod = StrtoArray($data->newreq_nodoc);
							$new_nr = StrtoArray($data->newreq_norev);
							$new_dn = StrtoArray($data->newreq_docname);
							$new_sp = StrtoArray($data->newreq_saveperiode);
							$new_sm = StrtoArray($data->newreq_sort);
							$new_em = StrtoArray($data->newreq_eliminate);
							?>

  				 <tr >
             <td style="text-align: left; width: 0.5%;"><b>1</b></td>
  					 <td style="text-align: left;">
               {{$new_nod[1]}}
  					</td>
                      <td style="text-align: left;">
                        {{$new_nr[1]}}
  					</td>
  					  <td style="text-align: left;">
                {{$new_dn[1]}}
  					</td>
  					  <td style="text-align: left;">
                {{$new_sp[1]}}
  					</td>
  					  <td style="text-align: left;">
                {{$new_sm[1]}}
  					</td>
  					  <td style="text-align: left;">
                {{$new_em[1]}}
  					</td>
                  </tr>
  				<tr >
            <td style="text-align: left; width: 1%;"><b>2</b></td>
  					 <td style="text-align: left;">
               {{$new_nod[2]}}
  					</td>
                      <td style="text-align: left;">
                        {{$new_nr[2]}}
  					</td>
  					  <td style="text-align: left;">
                {{$new_dn[2]}}
  					</td>
  					  <td style="text-align: left;">
                {{$new_sp[2]}}
  					</td>
  					  <td style="text-align: left;">
                {{$new_sm[2]}}
  					</td>
  					  <td style="text-align: left;">
                {{$new_em[2]}}
  					</td>
                  </tr>
  				<tr >
            <td style="text-align: left; width: 1%;"><b>3</b></td>
  					 <td style="text-align: left;">
               {{$new_nod[3]}}
  					</td>
                      <td style="text-align: left;">
                        {{$new_nr[3]}}
  					</td>
  					  <td style="text-align: left;">
                {{$new_dn[3]}}
  					</td>
  					  <td style="text-align: left;">
                {{$new_sp[3]}}
  					</td>
  					  <td style="text-align: left;">
                {{$new_sm[3]}}
  					</td>
  					  <td style="text-align: left;">
                {{$new_em[3]}}
  					</td>
                  </tr>
              </tbody>
          </table>
          <p style="margin-top: 0em; margin-bottom: 0em;">* List permintaan lebih dari 3 document lampirkan file excel sesuai format diatas</p>

                  <label for="email">File list permintaan baru :</label>
                  <a href="{{URL::to('/')}}/public/uploads/file/p4no7/{{$data->file_permintaan_baru}}"  download  >{{$data->file_permintaan_baru}}</a><br>


  		<table class="table table-bordered">
              <thead>
  				<tr>
  				<th bgcolor="#bfbfbf" colspan='7'>PERUBAHAN</th>
  				</tr>
  				<tr>
          <th bgcolor="#bfbfbf">No.</th>
  				<th bgcolor="#bfbfbf" colspan='1'>No. Document</th>
  				<th bgcolor="#bfbfbf" colspan='1'>No. Revisi / Baru</th>
  				<th bgcolor="#bfbfbf" width='230'>Nama Dokumen</th>
  				<th bgcolor="#bfbfbf" width='220'>Masa Penyimpanan</th>
  				<th bgcolor="#bfbfbf" width='220'>Cara Pengurutan</th>
  				<th bgcolor="#bfbfbf" width='220'>Cara Pemusnahan</th>
  				</tr>
              </thead>
              <tbody>
                <?php
							$ch_nod = StrtoArray($data->chreq_nodoc);
							$ch_nr = StrtoArray($data->chreq_norev);
							$ch_nd = StrtoArray($data->chreq_docname);
							$ch_sp = StrtoArray($data->chreq_saveperiode);
							$ch_sm = StrtoArray($data->chreq_sort);
							$ch_em = StrtoArray($data->chreq_eliminate);
							?>
  				 <tr >
             <td style="text-align: left; width: 1%;"><b>1</b></td>
  					<td style="text-align: left;">
              {{$ch_nod[1]}}
  					</td>
            <td style="text-align: left;">
              {{$ch_nr[1]}}
  					</td>
  					  <td style="text-align: left;">
                {{$ch_nd[1]}}
  					</td>
  					  <td style="text-align: left;">
                {{$ch_sp[1]}}
  					</td>
  					  <td style="text-align: left;">
                {{$ch_sm[1]}}
  					</td>
  					  <td style="text-align: left;">
                {{$ch_em[1]}}
  					</td>
                  </tr>
  					 <tr >
               <td style="text-align: left; width: 1%;"><b>2</b></td>
                <td style="text-align: left;">
                {{$ch_nod[2]}}
  					</td>
  					 <td style="text-align: left;">
               {{$ch_nr[2]}}
  					</td>
  					  <td style="text-align: left;">
                {{$ch_nd[2]}}
  					</td>
  					  <td style="text-align: left;">
                {{$ch_sp[2]}}
  					</td>
  					  <td style="text-align: left;">
                {{$ch_sm[2]}}
  					</td>
  					  <td style="text-align: left;">
                {{$ch_em[2]}}
  					</td>
                  </tr>
  					 <tr >
               <td style="text-align: left; width: 1%;"><b>3</b></td>
                      <td style="text-align: left;">
                        {{$ch_nod[3]}}
  					</td>
  					 <td style="text-align: left;">
               {{$ch_nr[3]}}
  					</td>
  					  <td style="text-align: left;">
                {{$ch_nd[3]}}
  					</td>
  					  <td style="text-align: left;">
                {{$ch_sp[3]}}
  					</td>
  					  <td style="text-align: left;">
                {{$ch_sm[3]}}
  					</td>
  					  <td style="text-align: left;">
                {{$ch_em[3]}}
  					</td>
                  </tr>
              </tbody>
          </table>
          <p style="margin-top: 0em; margin-bottom: 0em;">* List perubahan lebih dari 3 document lampirkan file excel sesuai format diatas</p>
          <label for="email">File list perubahan :</label>
          <a href="{{URL::to('/')}}/public/uploads/file/p4no7/{{$data->file_perubahan}}"  download >{{$data->file_perubahan}}</a><br>

  		<table class="table table-bordered">
              <thead>
  				<tr>
  				<th bgcolor="#bfbfbf" colspan='4'>PEMBATALAN</th>
  				</tr>
  				<tr>
            <th bgcolor="#bfbfbf">No.</th>
  				<th bgcolor="#bfbfbf" colspan='1'>No. Document</th>
  				<th bgcolor="#bfbfbf" colspan='1'>No. Revisi Terakhir</th>
  				<th bgcolor="#bfbfbf" width=''>Nama Document</th>
  				</tr>
              </thead>
              <tbody>
                <?php
							$c_nod = StrtoArray($data->cancel_nodoc);
							$c_nr = StrtoArray($data->cancel_norev);
							$c_nd = StrtoArray($data->cancel_docname);
							?>
  				 <tr >
             <td style="text-align: left; width: 1%;"><b>1</b></td>
                      <td style="text-align: left;">
                        {{$c_nod[1]}}
  					</td>
  					  <td style="text-align: left;">
                {{$c_nr[1]}}
  					</td>
  					  <td style="text-align: left;">
                {{$c_nd[1]}}
  					</td>
                  </tr>
  					 <tr >
               <td style="text-align: left; width: 1%;"><b>2</b></td>
                      <td style="text-align: left;">
                        {{$c_nod[2]}}
  					</td>
  					  <td style="text-align: left;">
                {{$c_nr[2]}}
  					</td>
  					  <td style="text-align: left;">
                {{$c_nd[2]}}
  					</td>
                  </tr>
  				<tr >
              <td style="text-align: left; width: 1%;"><b>3</b></td>
                      <td style="text-align: left;">
                        {{$c_nod[3]}}
  					</td>
  					  <td style="text-align: left;">
                {{$c_nr[3]}}
  					</td>
  					  <td style="text-align: left;">
                {{$c_nd[3]}}
  					</td>
                  </tr>
              </tbody>
          </table>
          <p style="margin-top: 0em; margin-bottom: 0em;">* List pembatalan lebih dari 3 document lampirkan file excel sesuai format diatas</p>
          <label for="email">File list pembatalan :</label>
          <a href="{{URL::to('/')}}/public/uploads/file/p4no7/{{$data->file_pembatalan}}"  download  >{{$data->file_pembatalan}}</a><br>

  		<label for="inputPassword3" class="control-label">Usulan perubahan / pembatalan</label>
  		<textarea class="form-control" rows="3" name="suggest" id="suggest" readonly>{{$data->suggest}}</textarea>

  		<label for="inputPassword3" class="control-label">Tujuan atau penyebab dilakukan perubahan / pembatalan</label>
  		<textarea class="form-control" rows="3" name="propose" id="propose" readonly>{{$data->purpose}}</textarea>

      <br><p style="margin-bottom: 0em;">* Dokumen yang diajukan (Extract dahulu jika dalam bentuk RAR / ZIP)</p>
      <label for="email">Dokumen :</label>
      <a href="{{URL::to('/')}}/public/uploads/file/p4no7/{{$data->file_dokumen}}"  download>{{$data->file_dokumen}}</a><br>



  @if ($actions=='edit')
      <label for="email">Change file :</label>
      <input type="file" name="file_doc"><br>

      <input type="hidden" name="file_doc_ori"  id='file_doc_ori' value="{{$data->file_dokumen}}">
      <input type="hidden" name="request_id"  id='request_id' value="{{$req->id}}">
      <label for="email">Edit Action :</label>
      <button type="submit" class="btn btn-xs btn-primary">Update</button>
      <a href='javascript:history.back()' class='btn btn-xs btn-success' >Cancel</a>
  </form>
  @elseif ($actions=='verification')
      <label for="email">Change file :</label>
      <input type="file" name="file_doc"><br>

      <input type="hidden" name="file_doc_ori"  id='file_doc_ori' value="{{$data->file_dokumen}}">
      <input type="hidden" name="request_id"  id='request_id' value="{{$req->id}}">
      <label for="email">Edit Action :</label>
      <button type="submit" class="btn btn-xs btn-primary">Verificate</button>
      <a href='javascript:history.back()' class='btn btn-xs btn-success' >Cancel</a>
      </form>
  @endif

  @if ($req->approval1 == $user || $req->approval2 == $user || $req->approval_final == $user )
  <form class="form-horizontal" method='post' action='{{ action('ReqApprovalController@approve') }}'>
  {{csrf_field()}}
      <input type="hidden" name="request_id"  id='request_id' value="{{$req->id}}">
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
<br>
</div>
</body>

</html>
