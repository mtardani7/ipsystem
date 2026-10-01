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

  <h4 style="color:blue;">Pengajuan Permintaan / Pemusnahan, Salinan Document Hardcopy / Softcopy</h4>

@if ($actions=='edit')
  <form class="form-horizontal" name="New" enctype="multipart/form-data" method='post' action='{{ action('RequestController@update_form8') }}'>
  {{csrf_field()}}
@endif
  		<b>Hardcopy</b>
  		<table class="table table-bordered">
              <thead>
  				<tr>
  				<th bgcolor="#bfbfbf" colspan='3'>KATEGORI</th>
  				</tr>
  				<tr>
  				<th bgcolor="#bfbfbf" colspan='1'>DOCUMENT MUTU & KEAMANAN PANGAN</th>
  				<th bgcolor="#bfbfbf" colspan='1'>CATATAN MUTU & KEAMANAN PANGAN</th>
  				<th bgcolor="#bfbfbf" width='350'>PENGAJUAN</th>
  				</tr>
              </thead>
              <tbody>
  				 <tr >
                      <td style="text-align: left;">
  						 <input type="checkbox" id="soph" name="soph" value="SOP" <?php if (strpos($data->hc_category, 'SOP') !== false) echo "checked"; ?> > Standard Operating Procedure (SOP)<br>
  						 <input type="checkbox" id="wih" name="wih" value="WI" <?php if (strpos($data->hc_category, 'WI') !== false) echo "checked"; ?> > Work Instruction (WI)<br>
  						 <input type="checkbox" id="mb" name="mb" value="MB" <?php if (strpos($data->hc_category, 'MB') !== false) echo "checked"; ?> > Manual Book<br>
  						 <input type="checkbox" id="other_hc" name="other_hc" value="other" <?php if (strpos($data->hc_category, 'other') !== false) echo "checked"; ?> > Other <?php $parsed_o = get_string_between($data->hc_category, 'other(', '),'); ?> <input type="text" id="other_hc_txt" name="other_hc_txt" value="{{$parsed_o}}"><br>
  					</td>
                      <td style="text-align: left;vertical-align: top;" ><input type="checkbox" id="formh" name="formh" value="form" <?php if (strpos($data->hc_category, 'form') !== false) echo "checked"; ?> > Form (Record)</td>
  					 <td style="text-align: left;vertical-align: top;" >
  						<input type="checkbox" id="hc" name="hc" value="Permintaan HC" <?php if (strpos($data->hc_cattype, 'Permintaan HC') !== false) echo "checked"; ?> > Permintaan Salinan (Hard Copy)<br>
  						<input type="checkbox" id="sc" name="sc" value="Pemusnahan HC" <?php if (strpos($data->hc_cattype, 'Pemusnahan HC') !== false) echo "checked"; ?> > Pemusnahan Salinan (Hard Copy)
  					 </td>
                  </tr>
              </tbody>
          </table>

  		<b>Softcopy</b>
  		<table class="table table-bordered">
              <thead>
  				<tr>
  				<th bgcolor="#bfbfbf" colspan='3'>KATEGORI</th>
  				</tr>
  				<tr>
  				<th bgcolor="#bfbfbf" colspan='1'>DOCUMENT MUTU & KEAMANAN PANGAN</th>
  				<th bgcolor="#bfbfbf" colspan='1'>CATATAN MUTU & KEAMANAN PANGAN</th>
  				<th bgcolor="#bfbfbf" width='350'>PENGAJUAN</th>
  				</tr>
              </thead>
              <tbody>
  				 <tr >
                      <td style="text-align: left;">
  						 <input type="checkbox" id="psqm" name="psqm" value="PSQM" <?php if (strpos($data->sc_category, 'PSQM') !== false) echo "checked"; ?> > Packaging Safety - Quality manual (PSQM)<br>
  						 <input type="checkbox" id="oc" name="oc" value="OC" <?php if (strpos($data->sc_category, 'OC') !== false) echo "checked"; ?> > Organization Chart (OC)<br>
  						 <input type="checkbox" id="jd" name="jd" value="JD" <?php if (strpos($data->sc_category, 'JD') !== false) echo "checked"; ?> > Job Description (JD)<br>
  						 <input type="checkbox" id="sop" name="sop" value="SOP" <?php if (strpos($data->sc_category, 'SOP') !== false) echo "checked"; ?> > Standard Operating Procedure (SOP)<br>
  						 <input type="checkbox" id="wi" name="wi" value="WI" <?php if (strpos($data->sc_category, 'WI') !== false) echo "checked"; ?> > Work Instruction (WI)<br>
  						 <input type="checkbox" id="haccp" name="haccp" value="HACCP" <?php if (strpos($data->sc_category, 'HACCP') !== false) echo "checked"; ?> > PRPs Document / HACCP Study<br>
  						 <input type="checkbox" id="ext" name="ext" value="ext" <?php if (strpos($data->sc_category, 'ext') !== false) echo "checked"; ?> > External Document <?php $parsed_ext = get_string_between($data->sc_category, 'ext(', '),'); ?><input type="text" id="ext_txt" name="ext_txt" value="{{$parsed_ext}}"><br>
  						 <input type="checkbox" id="other" name="other" value="other" <?php if (strpos($data->sc_category, 'other') !== false) echo "checked"; ?> > Other <?php $parsed_oth = get_string_between($data->sc_category, 'other(', '),'); ?><input type="text" id="other_txt" name="other_txt" value="{{$parsed_oth}}"><br>
  					</td>
                      <td style="text-align: left;vertical-align: top;" ><input type="checkbox" id="form" name="form" value="form" <?php if (strpos($data->sc_category, 'form') !== false) echo "checked"; ?> > Form (Record)</td>
  					 <td style="text-align: left;vertical-align: top;" >
  						<input type="checkbox" id="req_sc" name="req_sc" value="Permintaan SC" <?php if (strpos($data->sc_cattype, 'Permintaan SC') !== false) echo "checked"; ?> > Permintaan Softcopy<br>
  						<input type="checkbox" id="el_sc" name="el_sc" value="Pemusnahan SC" <?php if (strpos($data->sc_cattype, 'Pemusnahan SC') !== false) echo "checked"; ?> > Pemusnahan Softcopy
  					 </td>
                  </tr>
              </tbody>
          </table>

  		<table class="table table-bordered">
              <thead>
  				<tr>
  				<th bgcolor="#bfbfbf" colspan='6'>PERMINTAAN SALINAN (HARD COPY) DOCUMENT</th>
  				</tr>
  				<tr>
  				<th bgcolor="#bfbfbf" colspan='1'>No. Dokumen</th>
  				<th bgcolor="#bfbfbf" colspan='1'>No. Revisi</th>
  				<th bgcolor="#bfbfbf" width='420'>Nama Dokumen</th>
  				<th bgcolor="#bfbfbf" width=''>Jumlah Copy</th>
  				<th bgcolor="#bfbfbf" width=''>Ditempatkan di</th>
  				</tr>
              </thead>
              <tbody>
                <?php
							$new_nr = StrtoArray($data->hc_nodoc);
							$new_dn = StrtoArray($data->hc_norev);
							$new_sp = StrtoArray($data->hc_docname);
							$new_sm = StrtoArray($data->hc_nocopy);
							$new_em = StrtoArray($data->hc_place);
							?>
          @if ($actions=='edit')
  				 <tr >
                      <td style="text-align: left;">
  						  <input type="text" id="hc_nod1" name="hc_nod1" class="form-control" value="{{$new_nr[1]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="hc_nr1" name="hc_nr1" class="form-control" value="{{$new_dn[1]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="hc_nd1" name="hc_nd1" class="form-control" value="{{$new_sp[1]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="hc_tc1" name="hc_tc1" class="form-control" value="{{$new_sm[1]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="hc_p1" name="hc_p1" class="form-control" value="{{$new_em[1]}}">
  					</td>
                  </tr>
  					 <tr >
                      <td style="text-align: left;">
  						  <input type="text" id="hc_nod2" name="hc_nod2" class="form-control" value="{{$new_nr[2]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="hc_nr2" name="hc_nr2" class="form-control" value="{{$new_dn[2]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="hc_nd2" name="hc_nd2" class="form-control" value="{{$new_sp[2]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="hc_tc2" name="hc_tc2" class="form-control" value="{{$new_sm[2]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="hc_p2" name="hc_p2" class="form-control" value="{{$new_em[2]}}">
  					</td>
                  </tr>
  					 <tr >
                      <td style="text-align: left;">
  						  <input type="text" id="hc_nod3" name="hc_nod3" class="form-control" value="{{$new_nr[3]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="hc_nr3" name="hc_nr3" class="form-control" value="{{$new_dn[3]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="hc_nd3" name="hc_nd3" class="form-control" value="{{$new_sp[3]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="hc_tc3" name="hc_tc3" class="form-control" value="{{$new_sm[3]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="hc_p3" name="hc_p3" class="form-control" value="{{$new_em[3]}}">
  					</td>
                  </tr>
            @else
            <tr >
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
          <p style="margin-top: 0em; margin-bottom: 0em;">* List permintaan lebih dari 3 document lampirkan file excel sesuai format diatas</p>

                  <label for="email">File list permintaan Hard Copy :</label>
                  <a href="{{URL::to('/')}}/public/uploads/file/p4no8/{{$data->file_hardcopy}}"  download >{{$data->file_hardcopy}}</a><br>
                  <label for="email">Change file :</label>
                  <input id="fileopen_hc" type="file" name="file_hc">
                  <button type="button" id="clear_hc">Clear</button><br><br>

  		<table class="table table-bordered">
              <thead>
  				<tr>
  				<th bgcolor="#bfbfbf" colspan='6'>PERMINTAAN SOFT COPY DOKUMEN / CATATAN</th>
  				</tr>
  				<tr>
  				<th bgcolor="#bfbfbf" colspan='1'>No. Dokumen</th>
  				<th bgcolor="#bfbfbf" colspan='1'>No. Revisi</th>
  				<th bgcolor="#bfbfbf" width='350'>Nama Dokumen</th>
  				<th bgcolor="#bfbfbf" width=''>Masa Penyimpanan</th>
  				<th bgcolor="#bfbfbf" width=''>Tempat Penyimpanan</th>
  				<th bgcolor="#bfbfbf" width=''>Cara Pemusnahan</th>
  				</tr>
              </thead>
              <tbody>
                <?php
  							$sc_nod = StrtoArray($data->sc_nodoc);
  							$sc_nr = StrtoArray($data->sc_norev);
  							$sc_dn = StrtoArray($data->sc_docname);
  							$sc_sp = StrtoArray($data->sc_saveperiode);
  							$sc_pl = StrtoArray($data->sc_saveplace);
  							$sc_em = StrtoArray($data->sc_eliminate);
  							?>
          @if ($actions=='edit')
  				 <tr >
                      <td style="text-align: left;">
  						  <input type="text" id="sc_nod1" name="sc_nod1" class="form-control" value="{{$sc_nod[1]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="sc_nr1" name="sc_nr1" class="form-control" value="{{$sc_nr[1]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="sc_nd1" name="sc_nd1" class="form-control" value="{{$sc_dn[1]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="sc_sp1" name="sc_sp1" class="form-control" value="{{$sc_sp[1]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="sc_pp1" name="sc_pp1" class="form-control" value="{{$sc_pl[1]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="sc_em1" name="sc_em1" class="form-control" value="{{$sc_em[1]}}">
  					</td>
                  </tr>
  					 <tr >
                      <td style="text-align: left;">
  						  <input type="text" id="sc_nod2" name="sc_nod2" class="form-control" value="{{$sc_nod[2]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="sc_nr2" name="sc_nr2" class="form-control" value="{{$sc_nr[2]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="sc_nd2" name="sc_nd2" class="form-control" value="{{$sc_dn[2]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="sc_sp2" name="sc_sp2" class="form-control" value="{{$sc_sp[2]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="sc_pp2" name="sc_pp2" class="form-control" value="{{$sc_pl[2]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="sc_em2" name="sc_em2" class="form-control" value="{{$sc_em[2]}}">
  					</td>
                  </tr>
  					 <tr >
                      <td style="text-align: left;">
  						  <input type="text" id="sc_nod3" name="sc_nod3" class="form-control" value="{{$sc_nod[3]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="sc_nr3" name="sc_nr3" class="form-control" value="{{$sc_nr[3]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="sc_nd3" name="sc_nd3" class="form-control" value="{{$sc_dn[3]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="sc_sp3" name="sc_sp3" class="form-control" value="{{$sc_sp[3]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="sc_pp3" name="sc_pp3" class="form-control" value="{{$sc_pl[3]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="sc_em3" name="sc_em3" class="form-control" value="{{$sc_em[3]}}">
  					</td>
                  </tr>
            @else
            <tr >
                       <td style="text-align: left;">
   						  {{$sc_nod[1]}}
   					</td>
   					  <td style="text-align: left;">
   						  {{$sc_nr[1]}}
   					</td>
   					  <td style="text-align: left;">
   						  {{$sc_dn[1]}}
   					</td>
   					  <td style="text-align: left;">
   						  {{$sc_sp[1]}}
   					</td>
   					  <td style="text-align: left;">
   						  {{$sc_pl[1]}}
   					</td>
   					  <td style="text-align: left;">
   						  {{$sc_em[1]}}
   					</td>
                   </tr>
   					 <tr >
                       <td style="text-align: left;">
   						  {{$sc_nod[2]}}
   					</td>
   					  <td style="text-align: left;">
   						  {{$sc_nr[2]}}
   					</td>
   					  <td style="text-align: left;">
   						  {{$sc_dn[2]}}
   					</td>
   					  <td style="text-align: left;">
   						  {{$sc_sp[2]}}
   					</td>
   					  <td style="text-align: left;">
   						  {{$sc_pl[2]}}
   					</td>
   					  <td style="text-align: left;">
   						  {{$sc_em[2]}}
   					</td>
                   </tr>
   					 <tr >
                       <td style="text-align: left;">
   						  {{$sc_nod[3]}}
   					</td>
   					  <td style="text-align: left;">
   						  {{$sc_nr[3]}}
   					</td>
   					  <td style="text-align: left;">
   						  {{$sc_dn[3]}}
   					</td>
   					  <td style="text-align: left;">
   						  {{$sc_sp[3]}}
   					</td>
   					  <td style="text-align: left;">
   						  {{$sc_pl[3]}}
   					</td>
   					  <td style="text-align: left;">
   						  {{$sc_em[3]}}
   					</td>
                   </tr>
            @endif
              </tbody>
          </table>
          <p style="margin-top: 0em; margin-bottom: 0em;">* List permintaan lebih dari 3 document lampirkan file excel sesuai format diatas</p>

                  <label for="email">File list permintaan Soft Copy :</label>
                  <a href="{{URL::to('/')}}/public/uploads/file/p4no8/{{$data->file_softcopy}}"  download >{{$data->file_softcopy}}</a><br>
                  <label for="email">Change file :</label>
                  <input id="fileopen_sc" type="file" name="file_sc">
                  <button type="button" id="clear_sc">Clear</button><br><br>

  		<label for="inputPassword3" class="control-label">Tujuan permintaan hardcopy / softcopy dokumen atau catatan mutu & keamanan pangan</label>
  		<textarea class="form-control" rows="3" name="purpose" id="purpose">{{$data->purpose}}</textarea><br>

  		<table class="table table-bordered">
              <thead>
  				<tr>
  				<th bgcolor="#bfbfbf" colspan='6'>PEMUSNAHAN DOKUMEN / SALINAN (COPY) DOKUMEN</th>
  				</tr>
  				<tr>
  				<th bgcolor="#bfbfbf" colspan='1'>No. Dokumen</th>
  				<th bgcolor="#bfbfbf" colspan='1'>No. Revisi</th>
  				<th bgcolor="#bfbfbf" width='350'>Nama Dokumen</th>
  				<th bgcolor="#bfbfbf" width=''>Masa Penyimpanan</th>
  				<th bgcolor="#bfbfbf" width=''>Cara Pemusnahan</th>
  				<th bgcolor="#bfbfbf" width=''>Banyaknya</th>
  				</tr>
              </thead>
              <tbody>
                <?php
  							$el_nod = StrtoArray($data->el_nodoc);
  							$el_nr = StrtoArray($data->el_norev);
  							$el_dn = StrtoArray($data->el_docname);
  							$el_sp = StrtoArray($data->el_saveperiode);
  							$el_em = StrtoArray($data->el_eliminate);
  							$el_am = StrtoArray($data->el_amount);
  							?>
          @if ($actions=='edit')
  				 <tr >
                      <td style="text-align: left;">
  						  <input type="text" id="el_nod1" name="el_nod1" class="form-control" value="{{$el_nod[1]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="el_nr1" name="el_nr1" class="form-control" value="{{$el_nr[1]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="el_nd1" name="el_nd1" class="form-control" value="{{$el_dn[1]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="el_sp1" name="el_sp1" class="form-control" value="{{$el_sp[1]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="el_pp1" name="el_pp1" class="form-control" value="{{$el_em[1]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="el_t1" name="el_t1" class="form-control" value="{{$el_am[1]}}">
  					</td>
                  </tr>
  					 <tr >
                      <td style="text-align: left;">
  						  <input type="text" id="el_nod2" name="el_nod2" class="form-control" value="{{$el_nod[2]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="el_nr2" name="el_nr2" class="form-control" value="{{$el_nr[2]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="el_nd2" name="el_nd2" class="form-control" value="{{$el_dn[2]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="el_sp2" name="el_sp2" class="form-control" value="{{$el_sp[2]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="el_pp2" name="el_pp2" class="form-control" value="{{$el_em[2]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="el_t2" name="el_t2" class="form-control" value="{{$el_am[2]}}">
  					</td>
                  </tr>
  					 <tr >
                      <td style="text-align: left;">
  						  <input type="text" id="el_nod3" name="el_nod3" class="form-control" value="{{$el_nod[3]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="el_nr3" name="el_nr3" class="form-control" value="{{$el_nr[3]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="el_nd3" name="el_nd3" class="form-control" value="{{$el_dn[3]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="el_sp3" name="el_sp3" class="form-control" value="{{$el_sp[3]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="el_pp3" name="el_pp3" class="form-control" value="{{$el_em[3]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="el_t3" name="el_t3" class="form-control" value="{{$el_am[3]}}">
  					</td>
                  </tr>
  				 <tr >
                      <td style="text-align: left;">
  						  <input type="text" id="el_nod4" name="el_nod4" class="form-control" value="{{$el_nod[4]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="el_nr4" name="el_nr4" class="form-control" value="{{$el_nr[4]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="el_nd4" name="el_nd4" class="form-control" value="{{$el_dn[4]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="el_sp4" name="el_sp4" class="form-control" value="{{$el_sp[4]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="el_pp4" name="el_pp4" class="form-control" value="{{$el_em[4]}}">
  					</td>
  					  <td style="text-align: left;">
  						  <input type="text" id="el_t4" name="el_t4" class="form-control" value="{{$el_am[4]}}">
  					</td>
                  </tr>
          @else
          <tr >
                     <td style="text-align: left; " >
               {{$el_nod[1]}}
           </td>
             <td style="text-align: left;">
               {{$el_nr[1]}}
           </td>
             <td style="text-align: left;">
               {{$el_dn[1]}}
           </td>
             <td style="text-align: left;">
               {{$el_sp[1]}}
           </td>
             <td style="text-align: left;">
               {{$el_em[1]}}
           </td>
             <td style="text-align: left;">
               {{$el_am[1]}}
           </td>
                 </tr>
            <tr >
                     <td style="text-align: left;">
               {{$el_nod[2]}}
           </td>
             <td style="text-align: left;">
               {{$el_nr[2]}}
           </td>
             <td style="text-align: left;">
               {{$el_dn[2]}}
           </td>
             <td style="text-align: left;">
               {{$el_sp[2]}}
           </td>
             <td style="text-align: left;">
               {{$el_em[2]}}
           </td>
             <td style="text-align: left;">
               {{$el_am[2]}}
           </td>
                 </tr>
            <tr >
                     <td style="text-align: left;">
               {{$el_nod[3]}}
           </td>
             <td style="text-align: left;">
               {{$el_nr[3]}}
           </td>
             <td style="text-align: left;">
               {{$el_dn[3]}}
           </td>
             <td style="text-align: left;">
               {{$el_sp[3]}}
           </td>
             <td style="text-align: left;">
               {{$el_em[3]}}
           </td>
             <td style="text-align: left;">
               {{$el_am[3]}}
           </td>
                 </tr>
          <tr >
                     <td style="text-align: left;">
               {{$el_nod[4]}}
           </td>
             <td style="text-align: left;">
               {{$el_nr[4]}}
           </td>
             <td style="text-align: left;">
               {{$el_dn[4]}}
           </td>
             <td style="text-align: left;">
               {{$el_sp[4]}}
           </td>
             <td style="text-align: left;">
               {{$el_em[4]}}
           </td>
             <td style="text-align: left;">
               {{$el_am[4]}}
           </td>
                 </tr>
          @endif
              </tbody>
          </table>
          <p style="margin-top: 0em; margin-bottom: 0em;">* List permintaan lebih dari 3 document lampirkan file excel sesuai format diatas</p>

                  <label for="email">File list Pemusnahan Dokumen :</label>
                  <a href="{{URL::to('/')}}/public/uploads/file/p4no8/{{$data->file_pemusnahan}}"  download >{{$data->file_pemusnahan}}</a><br>
                  <label for="email">Change file :</label>
                  <input id="fileopen_el" type="file" name="file_el">
                  <button type="button" id="clear_el">Clear</button><br><br>

    @if ($actions=='edit')
        <input type="hidden" name="request_id"  id='request_id' value="{{$req->id}}">
        <input type="hidden" name="file_hc_ori"  id='file_hc_ori' value="{{$data->file_hardcopy}}">
        <input type="hidden" name="file_sc_ori"  id='file_sc_ori' value="{{$data->file_softcopy}}">
        <input type="hidden" name="file_el_ori"  id='file_el_ori' value="{{$data->file_pemusnahan}}">
        <label for="email">Edit Action :</label>
        <button type="submit" class="btn btn-xs btn-primary">Update</button>
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

<script type="text/javascript">

     $("#clear_hc").click(function () {
     $("#fileopen_hc").val("");
      });

      $("#clear_sc").click(function () {
      $("#fileopen_sc").val("");
       });

       $("#clear_el").click(function () {
       $("#fileopen_el").val("");
        });
</script>
@endsection
