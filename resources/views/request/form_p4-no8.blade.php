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
	<h4 style="color:blue;">Pengajuan Permintaan / Pemusnahan, Salinan Document Hardcopy / Softcopy</h4>
	<form class="form-horizontal" name="New" enctype="multipart/form-data" method='post' action='fill_req_form8'>
		{{csrf_field()}}
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
				<tr>
					<td style="text-align: left;">
						<input type="checkbox" id="soph" name="soph" value="SOP"> Standard Operating Procedure (SOP)<br>
						<input type="checkbox" id="wih" name="wih" value="WI"> Work Instruction (WI)<br>
						<input type="checkbox" id="mb" name="mb" value="MB"> Manual Book<br>
						<input type="checkbox" id="other_hc" name="other_hc" value="other"> Other <input type="text" id="other_hc_txt" name="other_hc_txt"><br>
					</td>
					<td style="text-align: left;vertical-align: top;"><input type="checkbox" id="formh" name="formh" value="form"> Form (Record)</td>
					<td style="text-align: left;vertical-align: top;">
						<input type="checkbox" id="hc" name="hc" value="Permintaan HC"> Permintaan Salinan (Hard Copy)<br>
						<input type="checkbox" id="sc" name="sc" value="Pemusnahan HC"> Pemusnahan Salinan (Hard Copy)
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
				<tr>
					<td style="text-align: left;">
						<input type="checkbox" id="psqm" name="psqm" value="PSQM"> Packaging Safety - Quality manual (PSQM)<br>
						<input type="checkbox" id="oc" name="oc" value="OC"> Organization Chart (OC)<br>
						<input type="checkbox" id="jd" name="jd" value="JD"> Job Description (JD)<br>
						<input type="checkbox" id="sop" name="sop" value="SOP"> Standard Operating Procedure (SOP)<br>
						<input type="checkbox" id="wi" name="wi" value="WI"> Work Instruction (WI)<br>
						<input type="checkbox" id="haccp" name="haccp" value="HACCP"> PRPs Document / HACCP Study<br>
						<input type="checkbox" id="ext" name="ext" value="ext"> External Document <input type="text" id="ext_txt" name="ext_txt"><br>
						<input type="checkbox" id="other" name="other" value="other"> Other <input type="text" id="other_txt" name="other_txt"><br>
					</td>
					<td style="text-align: left;vertical-align: top;"><input type="checkbox" id="form" name="form" value="form"> Form (Record)</td>
					<td style="text-align: left;vertical-align: top;">
						<input type="checkbox" id="req_sc" name="req_sc" value="Permintaan SC"> Permintaan Softcopy<br>
						<input type="checkbox" id="el_sc" name="el_sc" value="Pemusnahan SC"> Pemusnahan Softcopy
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
				<tr>
					<td style="text-align: left;">
						<input type="text" id="hc_nod1" name="hc_nod1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="hc_nr1" name="hc_nr1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="hc_nd1" name="hc_nd1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="hc_tc1" name="hc_tc1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="hc_p1" name="hc_p1" class="form-control">
					</td>
				</tr>
				<tr>
					<td style="text-align: left;">
						<input type="text" id="hc_nod2" name="hc_nod2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="hc_nr2" name="hc_nr2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="hc_nd2" name="hc_nd2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="hc_tc2" name="hc_tc2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="hc_p2" name="hc_p2" class="form-control">
					</td>
				</tr>
				<tr>
					<td style="text-align: left;">
						<input type="text" id="hc_nod3" name="hc_nod3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="hc_nr3" name="hc_nr3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="hc_nd3" name="hc_nd3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="hc_tc3" name="hc_tc3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="hc_p3" name="hc_p3" class="form-control">
					</td>
				</tr>
			</tbody>
		</table>
		<p style="margin-top: 0em; margin-bottom: 0em;">* List permintaan lebih dari 3 document lampirkan file excel sesuai format diatas</p>

		<label for="email">File list permintaan Hard Copy :</label>
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
				<tr>
					<td style="text-align: left;">
						<input type="text" id="sc_nod1" name="sc_nod1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="sc_nr1" name="sc_nr1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="sc_nd1" name="sc_nd1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="sc_sp1" name="sc_sp1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="sc_pp1" name="sc_pp1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="sc_em1" name="sc_em1" class="form-control">
					</td>
				</tr>
				<tr>
					<td style="text-align: left;">
						<input type="text" id="sc_nod2" name="sc_nod2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="sc_nr2" name="sc_nr2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="sc_nd2" name="sc_nd2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="sc_sp2" name="sc_sp2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="sc_pp2" name="sc_pp2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="sc_em2" name="sc_em2" class="form-control">
					</td>
				</tr>
				<tr>
					<td style="text-align: left;">
						<input type="text" id="sc_nod3" name="sc_nod3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="sc_nr3" name="sc_nr3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="sc_nd3" name="sc_nd3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="sc_sp3" name="sc_sp3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="sc_pp3" name="sc_pp3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="sc_em3" name="sc_em3" class="form-control">
					</td>
				</tr>
			</tbody>
		</table>
		<p style="margin-top: 0em; margin-bottom: 0em;">* List permintaan lebih dari 3 document lampirkan file excel sesuai format diatas</p>
		<label for="email">File list permintaan Soft Copy :</label>
		<input id="fileopen_sc" type="file" name="file_sc">
		<button type="button" id="clear_sc">Clear</button><br><br>
		<label for="inputPassword3" class="control-label">Tujuan permintaan hardcopy / softcopy dokumen atau catatan mutu & keamanan pangan</label>
		<textarea class="form-control" rows="3" name="purpose" id="purpose"></textarea><br>
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
				<tr>
					<td style="text-align: left;">
						<input type="text" id="el_nod1" name="el_nod1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="el_nr1" name="el_nr1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="el_nd1" name="el_nd1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="el_sp1" name="el_sp1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="el_pp1" name="el_pp1" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="el_t1" name="el_t1" class="form-control">
					</td>
				</tr>
				<tr>
					<td style="text-align: left;">
						<input type="text" id="el_nod2" name="el_nod2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="el_nr2" name="el_nr2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="el_nd2" name="el_nd2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="el_sp2" name="el_sp2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="el_pp2" name="el_pp2" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="el_t2" name="el_t2" class="form-control">
					</td>
				</tr>
				<tr>
					<td style="text-align: left;">
						<input type="text" id="el_nod3" name="el_nod3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="el_nr3" name="el_nr3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="el_nd3" name="el_nd3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="el_sp3" name="el_sp3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="el_pp3" name="el_pp3" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="el_t3" name="el_t3" class="form-control">
					</td>
				</tr>
				<tr>
					<td style="text-align: left;">
						<input type="text" id="el_nod4" name="el_nod4" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="el_nr4" name="el_nr4" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="el_nd4" name="el_nd4" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="el_sp4" name="el_sp4" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="el_pp4" name="el_pp4" class="form-control">
					</td>
					<td style="text-align: left;">
						<input type="text" id="el_t4" name="el_t4" class="form-control">
					</td>
				</tr>
			</tbody>
		</table>
		<p style="margin-top: 0em; margin-bottom: 0em;">* List permintaan lebih dari 4 document lampirkan file excel sesuai format diatas</p>

		<label for="email">File list Pemusnahan Dokumen :</label>
		<input id="fileopen_el" type="file" name="file_el">
		<button type="button" id="clear_el">Clear</button><br><br>

		<input type="hidden" name="request_id" id='request_id' value="{{$request_id}}"><br>
		<br><button type="submit" class="col-sm-offset-8 col-sm-4 btn btn-sm btn-primary"><b>Submit</b></button>

	</form>

</div>
<div> <br> </div>

<script type="text/javascript">
	$("#clear_hc").click(function() {
		$("#fileopen_hc").val("");
	});

	$("#clear_sc").click(function() {
		$("#fileopen_sc").val("");
	});

	$("#clear_el").click(function() {
		$("#fileopen_el").val("");
	});
</script>
@endsection