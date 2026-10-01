@extends('layouts.app')

@section('content')
<div class="container">
  <label style="font-size:24px;"> Request Detail</label>
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
 @if ($req->verified == 'yes') <li class="list-group-item list-group-item-success"> <?php echo "Verfied by <b>Doc. Controller</b> ".date('Y-m-d', strtotime($req->verified_date)); ?> </li> @endif
 @if ($req->approval1_date != null) <li class="list-group-item list-group-item-success"> <?php echo "Approved by <b>".$req->approval1."</b> ".date('Y-m-d', strtotime($req->approval1_date)); ?> </li> @endif
 @if ($req->approval2_date != null) <li class="list-group-item list-group-item-success"><?php echo "Approved by <b>".$req->approval2."</b> ".date('Y-m-d', strtotime($req->approval2_date)); ?>  </li> @endif
 @if ($req->approval_final_date != null) <li class="list-group-item list-group-item-success"><?php echo "Approved by <b>".$req->approval_final."</b> ".date('Y-m-d', strtotime($req->approval_final_date)); ?>  </li> @endif
 @if ($req->approval_mr_date != null) <li class="list-group-item list-group-item-success"><?php echo "Approved by MR <b>".$req->approval_mr."</b> ".date('Y-m-d', strtotime($req->approval_mr_date)); ?>  </li> @endif

 @if ($req->status == 'reject') <li class="list-group-item list-group-item-danger"><?php echo "Rejected by  <b>".$req->reject_by."</b> ".date('Y-m-d', strtotime($req->reject_date))." : ".$req->reject_rmk; ?>  </li> @endif
 @if ($req->verified != 'yes') <li class="list-group-item list-group-item-warning"> <?php echo "Waiting Verification <b>Doc. Controller</b> "; ?> </li> @endif
 @if ($req->approval1 != null && $req->approval1_date == null) <li class="list-group-item list-group-item-warning"> <?php echo "Waiting Approval <b>".$req->approval1."</b> "; ?> </li> @endif
 @if ($req->approval2 != null && $req->approval2_date == null) <li class="list-group-item list-group-item-warning"><?php echo "Waiting Approval <b>".$req->approval2."</b> "; ?>  </li> @endif
 @if ($req->approval_final != null && $req->approval_final_date == null) <li class="list-group-item list-group-item-warning"><?php echo "Waiting Approval <b>".$req->approval_final."</b> "; ?>  </li> @endif
 @if ($req->approval_mr != null && $req->approval_mr_date == null) <li class="list-group-item list-group-item-warning"><?php echo "Waiting Approval MR <b>".$req->approval_mr."</b> "; ?>  </li> @endif

</ul>

  <h4 style="color:blue;">Pengajuan Permintaan / Perubahan / Pembatalan Dokumen / Catatan Mutu - Keamanan Pangan - SHE</h4>

@if ($actions=='edit')
  <form class="form-horizontal" name="New" enctype="multipart/form-data" method='post' action='{{ route("update_req_form7") }}' >
  {{csrf_field()}}
@elseif ($actions=='verification')
  <form class="form-horizontal" name="New" enctype="multipart/form-data" method='post' action='{{ route("verification_form7") }}' >
  {{csrf_field()}}
@endif

    <div class="col-md-6">
          <table class="table table-bordered table-striped table-highlight">
              <thead>
              </thead>
              <tbody>
  				          <tr>
                      <td width='200'>Masa percobaan (isi jika perlu)</td>
                      <td width=''><input type="text" id="trial_periode" name="trial_periode" class="form-control" value="{{$data->trial_time}}" /></td>
                    </tr>
  				             <tr>
                      <td width='200'>Target tgl efektif perubahan</td>
                      <td><input type="date" id="date_effective" name="date_effective" class="date form-control" value="{{$data->date_effective}}" /></td>
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
  						 <input type="checkbox" id="psqm" name="psqm" value="PSQM" <?php if (strpos($data->cat_doc, 'PSQM') !== false) echo "checked"; ?> > Packaging Safety - Quality manual (PSQM)<br>
  						 <input type="checkbox" id="oc" name="oc" value="OC" <?php if (strpos($data->cat_doc, 'OC') !== false) echo "checked"; ?> > Organization Chart (OC)<br>
  						 <input type="checkbox" id="jd" name="jd" value="JD" <?php if (strpos($data->cat_doc, 'JD') !== false) echo "checked"; ?> > Job Description (JD)<br>
  						 <input type="checkbox" id="sop" name="sop" value="SOP" <?php if (strpos($data->cat_doc, 'SOP') !== false) echo "checked"; ?> > Standard Operating Procedure (SOP)<br>
  						 <input type="checkbox" id="wi" name="wi" value="WI" <?php if (strpos($data->cat_doc, 'WI') !== false) echo "checked"; ?> > Work Instruction (WI)<br>
  						 <input type="checkbox" id="prp" name="prp" value="HACCP" <?php if (strpos($data->cat_doc, 'HACCP') !== false) echo "checked"; ?> > PRPs Document / HACCP Study<br>
  						 <input type="checkbox" id="ext" name="ext" value="ext" <?php if (strpos($data->cat_doc, 'ext') !== false) echo "checked"; ?> > External Document <?php $parsed_ext = get_string_between($data->cat_doc, 'ext(', '),'); ?> <input type="text" id="ext_txt" name="ext_txt" value="{{$parsed_ext}}" ><br>
  						 <input type="checkbox" id="other" name="other" value="other" <?php if (strpos($data->cat_doc, 'other') !== false) echo "checked"; ?> > Other <?php $parsed_o = get_string_between($data->cat_doc, 'other(', '),'); ?> <input type="text" id="other_txt" name="other_txt" value="{{$parsed_o}}" ><br>
  					</td>
                      <td style="text-align: left;vertical-align: top;" ><input type="checkbox" id="form" name="form" value="form" <?php if (strpos($data->cat_doc, 'form') !== false) echo "checked"; ?>> Form (Record)</td>
  					 <td style="text-align: left;vertical-align: top;" >
  						<input type="checkbox" id="baru" name="baru" value="baru" <?php if (strpos($data->cat_type, 'baru') !== false) echo "checked"; ?> > Permintaan Baru<br>
  						<input type="checkbox" id="ubah" name="ubah" value="perubahan" <?php if (strpos($data->cat_type, 'perubahan') !== false) echo "checked"; ?> > Perubahan<br>
  						<input type="checkbox" id="batal" name="batal" value="pembatalan" <?php if (strpos($data->cat_type, 'pembatalan') !== false) echo "checked"; ?> > Pembatalan
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
          @if ($actions=='edit')
  				 <tr >
             <td style="text-align: left; width: 0.5%;"><b>1</b></td>
  					 <td style="text-align: left;">
  						  <input type="text" id="new_nod1" name="new_nod1" class="form-control" value="{{$new_nod[1]}}">
  					</td>
                      <td style="text-align: left;">
  						  <input type="text" id="new_nr1" name="new_nr1" class="form-control" value="{{$new_nr[1]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="new_dn1" name="new_dn1" class="form-control" value="{{$new_dn[1]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="new_sp1" name="new_sp1" class="form-control" value="{{$new_sp[1]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="new_sm1" name="new_sm1" class="form-control" value="{{$new_sm[1]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="new_em1" name="new_em1" class="form-control" value="{{$new_em[1]}}">
  					</td>
                  </tr>
  				<tr >
            <td style="text-align: left; width: 1%;"><b>2</b></td>
  					 <td style="text-align: left;">
  						  <input type="text" id="new_nod2" name="new_nod2" class="form-control" value="{{$new_nod[2]}}">
  					</td>
                      <td style="text-align: left;">
  						  <input type="text" id="new_nr2" name="new_nr2" class="form-control" value="{{$new_nr[2]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="new_dn2" name="new_dn2" class="form-control" value="{{$new_dn[2]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="new_sp2" name="new_sp2" class="form-control" value="{{$new_sp[2]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="new_sm2" name="new_sm2" class="form-control" value="{{$new_sm[2]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="new_em2" name="new_em2" class="form-control" value="{{$new_em[2]}}">
  					</td>
                  </tr>
  				<tr >
            <td style="text-align: left; width: 1%;"><b>3</b></td>
  					 <td style="text-align: left;">
  						  <input type="text" id="new_nod3" name="new_nod3" class="form-control" value="{{$new_nod[3]}}">
  					</td>
                      <td style="text-align: left;">
  						  <input type="text" id="new_nr3" name="new_nr3" class="form-control" value="{{$new_nr[3]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="new_dn3" name="new_dn3" class="form-control" value="{{$new_dn[3]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="new_sp3" name="new_sp3" class="form-control" value="{{$new_sp[3]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="new_sm3" name="new_sm3" class="form-control" value="{{$new_sm[3]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="new_em3" name="new_em3" class="form-control" value="{{$new_em[3]}}">
  					</td>
                  </tr>
              @else
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
              @endif
              </tbody>
          </table>
          <!--
          <p style="margin-top: 0em; margin-bottom: 0em;">* List permintaan lebih dari 3 document lampirkan file excel sesuai format diatas</p>

                  <label for="email">File list permintaan baru :</label>
                  <a href="{{URL::to('/')}}/public/uploads/file/p4no7/{{$data->file_permintaan_baru}}"  download  >{{$data->file_permintaan_baru}}</a><br>

                  @if ($actions=='edit')
                  <label for="email">Change file :</label>
                  <input id="fileopen" type="file" name="file_baru">
                  <button type="button" id="clear">Clear</button><br><br>
                  @endif
                -->
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
          @if ($actions=='edit')
  				 <tr >
             <td style="text-align: left; width: 1%;"><b>1</b></td>
  					<td style="text-align: left;">
  						  <input type="text" id="ch_nod1" name="ch_nod1" class="form-control" value="{{$ch_nod[1]}}">
  					</td>
                      <td style="text-align: left;">
  						  <input type="text" id="ch_nr1" name="ch_nr1" class="form-control" value="{{$ch_nr[1]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="ch_nd1" name="ch_nd1" class="form-control" value="{{$ch_nd[1]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="ch_sp1" name="ch_sp1" class="form-control" value="{{$ch_sp[1]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="ch_sm1" name="ch_sm1" class="form-control" value="{{$ch_sm[1]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="ch_em1" name="ch_em1" class="form-control" value="{{$ch_em[1]}}">
  					</td>
                  </tr>
  					 <tr >
               <td style="text-align: left; width: 1%;"><b>2</b></td>
                      <td style="text-align: left;">
  						  <input type="text" id="ch_nod2" name="ch_nod2" class="form-control" value="{{$ch_nod[2]}}">
  					</td>
  					 <td style="text-align: left;">
  						  <input type="text" id="ch_nr2" name="ch_nr2" class="form-control" value="{{$ch_nr[2]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="ch_nd2" name="ch_nd2" class="form-control" value="{{$ch_nd[2]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="ch_sp2" name="ch_sp2" class="form-control" value="{{$ch_sp[2]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="ch_sm2" name="ch_sm2" class="form-control" value="{{$ch_sm[2]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="ch_em2" name="ch_em2" class="form-control" value="{{$ch_em[2]}}">
  					</td>
                  </tr>
  					 <tr >
               <td style="text-align: left; width: 1%;"><b>3</b></td>
                      <td style="text-align: left;">
  						  <input type="text" id="ch_nod3" name="ch_nod3" class="form-control" value="{{$ch_nod[3]}}">
  					</td>
  					 <td style="text-align: left;">
  						  <input type="text" id="ch_nr3" name="ch_nr3" class="form-control" value="{{$ch_nr[3]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="ch_nd3" name="ch_nd3" class="form-control" value="{{$ch_nd[3]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="ch_sp3" name="ch_sp3" class="form-control" value="{{$ch_sp[3]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="ch_sm3" name="ch_sm3" class="form-control" value="{{$ch_sm[3]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="ch_em3" name="ch_em3" class="form-control" value="{{$ch_em[3]}}">
  					</td>
                  </tr>
              @else
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
              @endif
              </tbody>
          </table>
          <!--
          <p style="margin-top: 0em; margin-bottom: 0em;">* List perubahan lebih dari 3 document lampirkan file excel sesuai format diatas</p>
          <label for="email">File list perubahan :</label>
          <a href="{{URL::to('/')}}/public/uploads/file/p4no7/{{$data->file_perubahan}}"  download >{{$data->file_perubahan}}</a><br>

          @if ($actions=='edit')
          <label for="email">Change file :</label>
          <input id="fileopen_ubah" type="file" name="file_ubah">
          <button type="button" id="clear_ubah">Clear</button><br><br>
          @endif
        -->
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
              @if ($actions=='edit')
  				 <tr >
             <td style="text-align: left; width: 1%;"><b>1</b></td>
                      <td style="text-align: left;">
  						  <input type="text" id="c_nod1" name="c_nod1" class="form-control" value="{{$c_nod[1]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="c_nr1" name="c_nr1"class="form-control" value="{{$c_nr[1]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="c_nd1" name="c_nd1" class="form-control" value="{{$c_nd[1]}}">
  					</td>
                  </tr>
  					 <tr >
               <td style="text-align: left; width: 1%;"><b>2</b></td>
                      <td style="text-align: left;">
  						  <input type="text" id="c_nod2" name="c_nod2" class="form-control" value="{{$c_nod[2]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="c_nr2" name="c_nr2" class="form-control" value="{{$c_nr[2]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="c_nd2" name="c_nd2" class="form-control" value="{{$c_nd[2]}}">
  					</td>
                  </tr>
  				<tr >
              <td style="text-align: left; width: 1%;"><b>3</b></td>
                      <td style="text-align: left;">
  						  <input type="text" id="c_nod3" name="c_nod3" class="form-control" value="{{$c_nod[3]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="c_nr3" name="c_nr3" class="form-control" value="{{$c_nr[3]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="c_nd3" name="c_nd3" class="form-control" value="{{$c_nd[3]}}">
  					</td>
                  </tr>
              @else
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
              @endif
              </tbody>
          </table>
          <!--
          <p style="margin-top: 0em; margin-bottom: 0em;">* List pembatalan lebih dari 3 document lampirkan file excel sesuai format diatas</p>
          <label for="email">File list pembatalan :</label>
          <a href="{{URL::to('/')}}/public/uploads/file/p4no7/{{$data->file_pembatalan}}"  download  >{{$data->file_pembatalan}}</a><br>

          @if ($actions=='edit')
          <label for="email">Change file :</label>
          <input id="fileopen_batal" type="file" name="file_batal">
          <button type="button" id="clear_batal">Clear</button><br><br>
          @endif
        -->
  		<label for="inputPassword3" class="control-label">Usulan perubahan / pembatalan</label>
  		<textarea class="form-control" rows="3" name="suggest" id="suggest">{{$data->suggest}}</textarea>

  		<label for="inputPassword3" class="control-label">Tujuan atau penyebab dilakukan perubahan / pembatalan</label>
  		<textarea class="form-control" rows="3" name="propose" id="propose">{{$data->purpose}}</textarea>

      <br><p style="margin-bottom: 0em;">* Dokumen existing yang masih berlaku (Extract dahulu jika dalam bentuk RAR / ZIP)</p>
      <label for="email">Dokumen existing:</label>
      <a href="{{URL::to('/')}}/public/uploads/file/p4no7/{{$data->file_dokumen_existing}}"  download>{{$data->file_dokumen_existing}}</a><br>

      @if ($actions=='edit')
      <label for="email">Change file :</label>
      <input id="fileopen_doc_exist" type="file" name="file_doc_exist">
      <button type="button" id="clear_doc_exist">Clear</button><br><br>
      @endif

      <br><p style="margin-bottom: 0em;">* Dokumen yang diajukan (Extract dahulu jika dalam bentuk RAR / ZIP)</p>
      <label for="email">Dokumen :</label>
      <a href="{{URL::to('/')}}/public/uploads/file/p4no7/{{$data->file_dokumen}}"  download>{{$data->file_dokumen}}</a><br>




  @if ($actions=='edit')
      <label for="email">Change file :</label>
      <input id="fileopen_doc" type="file" name="file_doc">
      <button type="button" id="clear_doc">Clear</button><br><br>

      <input type="hidden" name="file_baru_ori"  id='file_baru_ori' value="{{$data->file_permintaan_baru}}">
      <input type="hidden" name="file_ubah_ori"  id='file_ubah_ori' value="{{$data->file_perubahan}}">
      <input type="hidden" name="file_batal_ori"  id='file_batal_ori' value="{{$data->file_pembatalan}}">
      <input type="hidden" name="file_doc_exist_ori"  id='file_doc_exist_ori' value="{{$data->file_dokumen_existing}}">
      <input type="hidden" name="file_doc_ori"  id='file_doc_ori' value="{{$data->file_dokumen}}">
      <input type="hidden" name="request_id"  id='request_id' value="{{$req->id}}">
      <label for="email">Edit Action :</label>
      <button type="submit" class="btn btn-xs btn-primary">Update</button>
      <a href='javascript:history.back()' class='btn btn-xs btn-success' >Cancel</a>

  @elseif ($actions=='verification')
<label>Change file :</label>
<input type="file" name="file_doc"><br>

<input type="hidden" name="file_doc_ori" id="file_doc_ori" value="{{$data->file_dokumen}}">
<input type="hidden" name="request_id" id="request_id" value="{{$req->id}}">

<div style="display:flex; align-items:center; gap:8px; margin-top:10px;">

    <label style="margin:0;">Verification Action :</label>

    <button type="submit" class="btn btn-xs btn-primary">
        Verify
    </button>

</form>

<form class="form-horizontal"
      method="post"
      action="{{ action('ReqApprovalController@reject') }}"
      style="margin:0; display:flex; align-items:center;">

    {{csrf_field()}}

    <input type="hidden"
           name="request_id"
           id="request_id"
           value="{{$req->id}}">

    <button type="submit" class="btn btn-xs btn-danger">
        Reject
    </button>
</form>

<a href="javascript:history.back()"
   class="btn btn-xs btn-success">
    Cancel
</a>

</div>
  @endif

  @if ($req->approval1 == $user || $req->approval2 == $user || $req->approval_final == $user)
    @if ($req->status == 'waiting')
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
  @endif
<br>
</div>

<script type="text/javascript">
    $('.date').datepicker({
       format: 'yyyy-mm-dd'
		}).on('change', function(){
        $('.datepicker').hide();
    });

     $("#clear").click(function () {
     $("#fileopen").val("");
      });

      $("#clear_ubah").click(function () {
      $("#fileopen_ubah").val("");
       });

       $("#clear_batal").click(function () {
       $("#fileopen_batal").val("");
        });

        $("#clear_doc_exist").click(function () {
        $("#fileopen_doc_exist").val("");
         });

        $("#clear_doc").click(function () {
        $("#fileopen_doc").val("");
         });
</script>
@endsection
