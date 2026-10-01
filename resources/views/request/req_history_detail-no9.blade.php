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

  <h4 style="color:blue;">Pengajuan Permintaan Form Cetakan</h4>


    <table class="table table-bordered">
            <thead>
				<tr>
				<th bgcolor="#bfbfbf" colspan='6'>PERMINTAAN FORM CETAKAN</th>
				</tr>
				<tr>
				<th bgcolor="#bfbfbf" colspan='1'>No. Dokumen</th>
				<th bgcolor="#bfbfbf" colspan='1'>No. Revisi Terakhir</th>
				<th bgcolor="#bfbfbf" width='320'>Nama Document</th>
				<th bgcolor="#bfbfbf" width='60'>Jumlah</th>
				<th bgcolor="#bfbfbf" width='380'>Keterangan</th>
				</tr>
            </thead>
            <tbody>
              <?php
							$f_nod = StrtoArray($data->form_nodoc);
							$f_nr = StrtoArray($data->form_norev);
							$f_nd = StrtoArray($data->form_docname);
							$f_t = StrtoArray($data->form_amount);
							$f_r = StrtoArray($data->form_remark);
							?>
				 <tr >
                    <td style="text-align: left;">
						  <input type="text" id="f_nod1" name="f_nod1" class="form-control" value="<?php echo $f_nod[1]; ?>">
					</td>
					  <td style="text-align: left;">
						  <input type="text" id="f_nr1" name="f_nr1" class="form-control" value="<?php echo $f_nr[1]; ?>">
					</td>
					  <td style="text-align: left;">
						  <input type="text" id="f_nd1" name="f_nd1" class="form-control" value="<?php echo $f_nd[1]; ?>">
					</td>
					  <td style="text-align: left;">
						  <input type="text" id="f_t1" name="f_t1" class="form-control" value="<?php echo $f_t[1]; ?>">
					</td>
					  <td style="text-align: left;">
						  <input type="text" id="f_r1" name="f_r1" class="form-control" value="<?php echo $f_r[1]; ?>">
					</td>
                </tr>
					 <tr >
                    <td style="text-align: left;">
						  <input type="text" id="f_nod2" name="f_nod2" class="form-control" value="<?php echo $f_nod[2]; ?>">
					</td>
					  <td style="text-align: left;">
						  <input type="text" id="f_nr2" name="f_nr2" class="form-control" value="<?php echo $f_nr[2]; ?>">
					</td>
					  <td style="text-align: left;">
						  <input type="text" id="f_nd2" name="f_nd2" class="form-control" value="<?php echo $f_nd[2]; ?>">
					</td>
					  <td style="text-align: left;">
						  <input type="text" id="f_t2" name="f_t2" class="form-control" value="<?php echo $f_t[2]; ?>">
					</td>
					  <td style="text-align: left;">
						  <input type="text" id="f_r2" name="f_r2" class="form-control" value="<?php echo $f_r[2]; ?>">
					</td>
                </tr>
					 <tr >
                    <td style="text-align: left;">
						  <input type="text" id="f_nod3" name="f_nod3" class="form-control" value="<?php echo $f_nod[3]; ?>">
					</td>
					  <td style="text-align: left;">
						  <input type="text" id="f_nr3" name="f_nr3" class="form-control" value="<?php echo $f_nr[3]; ?>">
					</td>
					  <td style="text-align: left;">
						  <input type="text" id="f_nd3" name="f_nd3" class="form-control" value="<?php echo $f_nd[3]; ?>">
					</td>
					  <td style="text-align: left;">
						  <input type="text" id="f_t3" name="f_t3" class="form-control" value="<?php echo $f_t[3]; ?>">
					</td>
					  <td style="text-align: left;">
						  <input type="text" id="f_r3" name="f_r3" class="form-control" value="<?php echo $f_r[3]; ?>">
					</td>
                </tr>
				<tr >
                    <td style="text-align: left;">
						  <input type="text" id="f_nod4" name="f_nod4" class="form-control" value="<?php echo $f_nod[4]; ?>">
					</td>
					  <td style="text-align: left;">
						  <input type="text" id="f_nr4" name="f_nr4" class="form-control" value="<?php echo $f_nr[4]; ?>">
					</td>
					  <td style="text-align: left;">
						  <input type="text" id="f_nd4" name="f_nd4" class="form-control" value="<?php echo $f_nd[4]; ?>">
					</td>
					  <td style="text-align: left;">
						  <input type="text" id="f_t4" name="f_t4" class="form-control" value="<?php echo $f_t[4]; ?>">
					</td>
					  <td style="text-align: left;">
						  <input type="text" id="f_r4" name="f_r4" class="form-control" value="<?php echo $f_r[4]; ?>">
					</td>
                </tr>
				<tr >
                    <td style="text-align: left;">
						  <input type="text" id="f_nod5" name="f_nod5" class="form-control" value="<?php echo $f_nod[5]; ?>">
					</td>
					  <td style="text-align: left;">
						  <input type="text" id="f_nr5" name="f_nr5" class="form-control" value="<?php echo $f_nr[5]; ?>">
					</td>
					  <td style="text-align: left;">
						  <input type="text" id="f_nd5" name="f_nd5" class="form-control" value="<?php echo $f_nd[5]; ?>">
					</td>
					  <td style="text-align: left;">
						  <input type="text" id="f_t5" name="f_t5" class="form-control" value="<?php echo $f_t[5]; ?>">
					</td>
					  <td style="text-align: left;">
						  <input type="text" id="f_r5" name="f_r5" class="form-control" value="<?php echo $f_r[5]; ?>">
					</td>
                </tr>
            </tbody>
        </table>
        <p style="margin-top: 0em; margin-bottom: 0em;">* List permintaan lebih dari 5 document lampirkan file excel sesuai format diatas</p>

      <label for="email">File list permintaan Form Cetakan :</label>
      <a href="{{URL::to('/')}}/public/uploads/file/p4no9/{{$data->file_cetak}}"  download >{{$data->file_cetak}}</a><br>

      <!--<label for="inputPassword3" class="control-label">Tujuan permintaan form cetakan</label>
      <textarea class="form-control" rows="3" name="purpose" id="purpose"></textarea><br>-->

		<label for="inputPassword3" class="control-label">Note : </label>
		 <ol type="1">
		  <li>Untuk pengajuan permintaan cetak form harus disertai dengan contoh form yang akan dicetak (berlaku untuk form baru maupun lama).</li>
		  <li>Jika form lama yang dicetak mengalami perubahan, maka perubahannya harus disampaikan ke Purchasing untuk diteruskan ke Supplier Percetakan agar menggunakan yang baru.</li>
		  <li>Jika form cetakan lama mengalami revisi, maka sisa form cetakan lama harus dilakukan pemusnahan dan dilaporkan ke ISO Document Controller Hardcopy.</li>
		</ol>

    <input type="hidden" name="request_id"  id='request_id' value="{{$req->id}}"><br>

</div>
@endsection
