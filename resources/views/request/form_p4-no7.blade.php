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
	<h4 style="color:blue;">Pengajuan Permintaan / Perubahan / Pembatalan Dokumen / Catatan Mutu - Keamanan Pangan - SHE</h4>

	<form class="form-horizontal" name="New" enctype="multipart/form-data" method='post' action='fill_req_form7'>
		{{csrf_field()}}

		<div class="col-md-6">
			<table class="table table-bordered table-striped table-highlight">
				<thead>
				</thead>
				<tbody>
					<tr class='padding: 5px'>
						<td width='200'>Masa percobaan (isi jika perlu)</td>
						<td width=''><input type="text" id="trial_periode" name="trial_periode" class="form-control" /></td>
					</tr></br>
					<tr class='padding: 5px'>
						<td width='200'>Target tgl efektif perubahan</td>
						<td><input type="date" id="date_effective" name="date_effective" class="date form-control" required /></td>
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
				<tr>
					<td style="text-align: left;">
						<input type="checkbox" id="psqm" name="psqm" value="PSQM"> Packaging Safety - Quality manual (PSQM)<br>
						<input type="checkbox" id="oc" name="oc" value="OC"> Organization Chart (OC)<br>
						<input type="checkbox" id="jd" name="jd" value="JD"> Job Description (JD)<br>
						<input type="checkbox" id="sop" name="sop" value="SOP"> Standard Operating Procedure (SOP)<br>
						<input type="checkbox" id="wi" name="wi" value="WI"> Work Instruction (WI)<br>
						<input type="checkbox" id="prp" name="prp" value="HACCP"> PRPs Document / HACCP Study<br>
						<input type="checkbox" id="ext" name="ext" value="ext"> External Document <input type="text" id="ext_txt" name="ext_txt"><br>
						<input type="checkbox" id="other" name="other" value="other"> Other <input type="text" id="other_txt" name="other_txt"><br>
					</td>
					<td style="text-align: left;vertical-align: top;"><input type="checkbox" id="form" name="form" value="form"> Form (Record)</td>
					<td style="text-align: left;vertical-align: top;">
						<input type="checkbox" id="baru" name="baru" value="baru"> Permintaan Baru<br>
						<input type="checkbox" id="ubah" name="ubah" value="perubahan"> Perubahan<br>
						<input type="checkbox" id="batal" name="batal" value="pembatalan"> Pembatalan
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
				<tr>
					<td style="text-align: left; width: 0.5%;"><b>1</b></td>
					<td style="text-align: left;">
						<input type="text" id="new_nod1" name="new_nod1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="new_nr1" name="new_nr1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="new_dn1" name="new_dn1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="new_sp1" name="new_sp1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="new_sm1" name="new_sm1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="new_em1" name="new_em1" class="form-control">
					</td>
				</tr>
				<tr>
					<td style="text-align: left; width: 1%;"><b>2</b></td>
					<td style="text-align: left;">
						<input type="text" id="new_nod2" name="new_nod2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="new_nr2" name="new_nr2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="new_dn2" name="new_dn2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="new_sp2" name="new_sp2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="new_sm2" name="new_sm2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="new_em2" name="new_em2" class="form-control">
					</td>
				</tr>
				<tr>
					<td style="text-align: left; width: 1%;"><b>3</b></td>
					<td style="text-align: left;">
						<input type="text" id="new_nod3" name="new_nod3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="new_nr3" name="new_nr3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="new_dn3" name="new_dn3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="new_sp3" name="new_sp3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="new_sm3" name="new_sm3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="new_em3" name="new_em3" class="form-control">
					</td>
				</tr>
			</tbody>
		</table>
		<!--
        <p style="margin-top: 0em; margin-bottom: 0em;">* List permintaan lebih dari 3 document lampirkan file excel sesuai format diatas</p>

                <label for="email">File list permintaan baru :</label>
                <input id="fileopen" type="file" name="file_baru">
                <button type="button" id="clear">Clear</button><br><br>
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
				<tr>
					<td style="text-align: left; width: 1%;"><b>1</b></td>
					<td style="text-align: left;">
						<input type="text" id="ch_nod1" name="ch_nod1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="ch_nr1" name="ch_nr1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="ch_nd1" name="ch_nd1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="ch_sp1" name="ch_sp1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="ch_sm1" name="ch_sm1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="ch_em1" name="ch_em1" class="form-control">
					</td>
				</tr>
				<tr>
					<td style="text-align: left; width: 1%;"><b>2</b></td>
					<td style="text-align: left;">
						<input type="text" id="ch_nod2" name="ch_nod2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="ch_nr2" name="ch_nr2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="ch_nd2" name="ch_nd2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="ch_sp2" name="ch_sp2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="ch_sm2" name="ch_sm2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="ch_em2" name="ch_em2" class="form-control">
					</td>
				</tr>
				<tr>
					<td style="text-align: left; width: 1%;"><b>3</b></td>
					<td style="text-align: left;">
						<input type="text" id="ch_nod3" name="ch_nod3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="ch_nr3" name="ch_nr3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="ch_nd3" name="ch_nd3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="ch_sp3" name="ch_sp3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="ch_sm3" name="ch_sm3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="ch_em3" name="ch_em3" class="form-control">
					</td>
				</tr>
			</tbody>
		</table>
		<!--
        <p style="margin-top: 0em; margin-bottom: 0em;">* List perubahan lebih dari 3 document lampirkan file excel sesuai format diatas</p>
        <label for="email">File list perubahan :</label>
        <input id="fileopen_ubah" type="file" name="file_ubah">
        <button type="button" id="clear_ubah">Clear</button><br><br>
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
				<tr>
					<td style="text-align: left; width: 1%;"><b>1</b></td>
					<td style="text-align: left;">
						<input type="text" id="c_nod1" name="c_nod1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="c_nr1" name="c_nr1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="c_nd1" name="c_nd1" class="form-control">
					</td>
				</tr>
				<tr>
					<td style="text-align: left; width: 1%;"><b>2</b></td>
					<td style="text-align: left;">
						<input type="text" id="c_nod2" name="c_nod2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="c_nr2" name="c_nr2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="c_nd2" name="c_nd2" class="form-control">
					</td>
				</tr>
				<tr>
					<td style="text-align: left; width: 1%;"><b>3</b></td>
					<td style="text-align: left;">
						<input type="text" id="c_nd3" name="c_nd3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="c_nr3" name="c_nr3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="c_nd3" name="c_nd3" class="form-control">
					</td>
				</tr>
			</tbody>
		</table>
		<!--
        <p style="margin-top: 0em; margin-bottom: 0em;">* List pembatalan lebih dari 3 document lampirkan file excel sesuai format diatas</p>
        <label for="email">File list pembatalan :</label>
        <input id="fileopen_batal" type="file" name="file_batal">
        <button type="button" id="clear_batal">Clear</button><br><br>
        -->

		<label for="inputPassword3" class="control-label">Usulan perubahan / pembatalan</label>
		<textarea class="form-control" rows="3" name="suggest" id="suggest"></textarea>

		<label for="inputPassword3" class="control-label">Tujuan atau penyebab dilakukan perubahan / pembatalan</label>
		<textarea class="form-control" rows="3" name="propose" id="propose"></textarea>


		<br>
		<p style="margin-bottom: 0em;">* jika request perubahan dokumen silahkan Upload dokumen existing yang masih berlaku (gunakan WinRAR jika file lebih dari 1)</p>
		<label for="email">Dokumen existing:</label>
		<input id="fileopen_doc_exist" type="file" name="file_doc_exist">
		<button type="button" id="clear_doc_exist">Clear</button><br><br>


		<br>
		<p style="margin-bottom: 0em;">* Upload dokumen yang diajukan (gunakan WinRAR jika file lebih dari 1)</p>
		<label for="email">Dokumen :</label>
		<input id="fileopen_doc" type="file" name="file_doc">
		<button type="button" id="clear_doc">Clear</button><br><br>

		<input type="hidden" name="request_id" id='request_id' value="{{$request_id}}"><br>
		<br><button type="submit" class="col-sm-offset-8 col-sm-4 btn btn-sm btn-primary"><b>Submit</b></button>

	</form>

</div>
<div> <br> </div>

<script type="text/javascript">
	/*$('.date').datepicker({
       format: 'yyyy-mm-dd'
     });*/

	$("#clear").click(function() {
		$("#fileopen").val("");
	});

	$("#clear_ubah").click(function() {
		$("#fileopen_ubah").val("");
	});

	$("#clear_batal").click(function() {
		$("#fileopen_batal").val("");
	});

	$("#clear_doc_exist").click(function() {
		$("#fileopen_doc_exist").val("");
	});

	$("#clear_doc").click(function() {
		$("#fileopen_doc").val("");
	});
</script>
@endsection