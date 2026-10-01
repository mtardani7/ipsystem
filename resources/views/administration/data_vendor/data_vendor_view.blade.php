@extends('layouts.app')

@section('content')
<div class="container">
@if (Auth::check())

@if (Session::has('data'))
<div class="alert alert-danger">
  {{ Session::get('data')}}
</div>
@endif

<form id="my-form" class="form-horizontal" name="New" enctype="multipart/form-data" method='post' action='{{ action('DataVendorController@update_form', $data->id)}}' >
{{csrf_field()}}
<label for="inputEmail3" class="col-sm-8 col-form-label" style="font-weight: normal;"><b><u>PT. RAPIDPLAST INDONESIA</u></b><br>Purchasing Department</label>
<label for="inputEmail3" class="col-sm-4 col-form-label" style="font-weight: normal;margin-bottom:20px;">No. Dokumen &nbsp: FRM/10-PRC/09<br>No. Revisi &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: 01 (27.05.16)</label>

          <table class="table">
              <thead>
              </thead>
              <tbody>
								<tr> <td style="text-align: center;"><strong style="font-size: 24px;">DATA VENDOR</strong></td></tr>
								<tr>
									<td>
										<div class="form-inline" style="margin-bottom:5px;">
	                    <label class="form-check-label" for="gridRadios3">
	                      No. Vendor &nbsp
	                    </label>
	                    <input size="20" class="form-control m-1" type="text" name="no_vendor" id="no_vendor" value="{{$data->no_vendor}}">
                      <label class="form-check-label" for="gridRadios3">
                       Status &nbsp
                     </label>
                     <select id='status_vendor' name='status_vendor' class='form-control'>
                     <option value='{{$data->status}}'>{{$data->status}}</option>
                     <option value='vendor baru'>vendor baru</option>
                     <option value='one time vendor'>one time vendor</option>
                     <option value='pre approved'>pre approved</option>
                     <option value='approved vendor'>approved vendor</option>
                     </select>
	                  </div>
								</td>
								</tr>
                  <tr>
                      <td style="text-align: left;"><p style=" text-align: justify;">Dalam  rangka  peningkatan  mutu  dalam  pemilihan  dan  penilaian  vendor,  maka dalam hal ini kami mensyaratkan perlu adanya data mengenai vendor kami.</p>
                      <p style="text-align: justify;">Data  ini  menjadi  pedoman  kami  dalam  bertransaksi,  termasuk  dalam  rangka penilaian kinerja vendor. Kerahasiaan informasi dalam kuesioner ini sangat kami hargai dan kami jaga.</p>
                      <p style="text-align: justify;">Oleh  karena  itu,  mohon  kesediaan  dari  Bapak/Ibu  selaku  vendor  untuk  mengisi data-data di bawah ini :</p>

                      </td>

                  </tr>
              </tbody>
            </table>


<table class="table" data-toggle="dataTable" data-form="deleteForm">
  <tbody>
    <tr >
      <td style="text-align: left;">
				<div class="form-group row">

        </div>
        <div class="form-group row">
          <label for="inputEmail3" class="col-sm-2 col-form-label" >Nama Perusahaan</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" value="{{$data->nama_perusahaan}}" >
          </div>
        </div>
        <div class="form-group row">
          <label for="inputEmail3" class="col-sm-2 col-form-label">Alamat</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="alamat_perusahaan" name="alamat_perusahaan" value="{{$data->alamat_perusahaan}}" >
          </div>
        </div>
        <div class="form-group row">
          <label for="inputEmail3" class="col-sm-2 col-form-label">Telepon</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="telp_perusahaan" name="telp_perusahaan" value="{{$data->telp_perusahaan}}">
          </div>
        </div>
        <div class="form-group row">
          <label for="inputEmail3" class="col-sm-2 col-form-label">Fax</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="fax_perusahaan" name="fax_perusahaan" value="{{$data->fax_perusahaan}}">
          </div>
        </div>
        <div class="form-group row">
          <label for="inputEmail3" class="col-sm-2 col-form-label">E-mail Address</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="email_perusahaan" name="email_perusahaan" value="{{$data->email_perusahaan}}">
          </div>
        </div>
        <div class="form-group row">
          <label for="inputEmail3" class="col-sm-2 col-form-label">Contact Person / No. HP</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="cp_perusahaan" name="cp_perusahaan" value="{{$data->cp_perusahaan}}">
          </div>
        </div>
        <div class="form-group row">
          <label for="inputEmail3" class="col-sm-2 col-form-label">Posisi</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="posisi" name="posisi" value="{{$data->posisi}}">
          </div>
        </div>
      </td>
    </tr>
      <tr>
        <td style="text-align: left;">
            <div class="form-group row">
							  <label for="inputEmail3" class="col-sm-2 col-form-label">Tipe Bisnis<br>(<i>pilih salah satu</i>)</label>
							<div class="col-sm-10">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="tipe_bisnis" id="gridRadios1" value="Manufaktur/OEM" <?php if ($data->tipe_bisnis == 'Manufaktur / OEM') echo "checked"; ?>>
                  <label class="form-check-label" for="gridRadios1">
                    Manufaktur / OEM
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="tipe_bisnis" id="gridRadios2" value="Distributor" <?php if ($data->tipe_bisnis == 'Distributor') echo "checked"; ?>>
                  <label class="form-check-label" for="gridRadios2">
                    Distributor
                  </label>
                </div>
                <div class="form-inline" style="margin-bottom:5px;">
                  <input class="form-check-input" type="radio" name="tipe_bisnis" id="gridRadios3" value="Service" <?php if (strpos($data->tipe_bisnis, 'Service') !== false) echo "checked"; ?>>
                  <label class="form-check-label" for="gridRadios3">
                    Service &nbsp
                  </label>
                  <input size="35" class="form-control m-1" type="text" name="txt_service" id="txt_service"  value="<?php if (strpos($data->tipe_bisnis, 'Service') !== false) echo substr($data->tipe_bisnis,8); ?>">
                </div>
                <div class="form-inline">
                  <input class="form-check-input" type="radio" name="tipe_bisnis" id="gridRadios4" value="Lain-lain" <?php if (strpos($data->tipe_bisnis, 'Lain-lain') !== false) echo "checked"; ?> >
                  <label class="form-check-label" for="gridRadios4">
                    Lain - lain &nbsp
                  </label>
                  <input size="35" class="form-control m-1" type="text" name="txt_bisnislain"  id="txt_bisnislain" value="<?php if (strpos($data->tipe_bisnis, 'Lain-lain') !== false) substr($data->tipe_bisnis,10); ?>">
                </div>
              </div>
            </div>
        </td>
        </tr>
        <tr>
          <td style="text-align: left;">
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-4 col-form-label"><b>Legal Format</b> (Isikan Nomor dan Upload Lampiran)</label>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">SIUP</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="siup" name="siup" value="{{$data->SIUP}}">
              </div>
              <div class="col-sm-4">
                <input type="file" class="form-control-file" id="file_siup" name="file_siup">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">TDP</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="tdp" name="tdp" value="{{$data->TDP}}">
              </div>
              <div class="col-sm-4">
                <input type="file" class="form-control-file" id="file_tdp" name="file_tdp">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">No. NPWP</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="npwp" name="npwp" value="{{$data->NPWP}}">
              </div>
              <div class="col-sm-4">
                <input type="file" class="form-control-file" id="file_npwp" name="file_npwp">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Perijinan Lainnya</label>
              <div class="col-sm-3">
                <input type="file" class="form-control-file" id="file_legal1" name="file_legal1">
              </div>
              <div class="col-sm-3">
                <input type="file" class="form-control-file" id="file_legal2" name="file_legal2">
              </div>
              <div class="col-sm-3">
                <input type="file" class="form-control-file" id="file_legal3" name="file_legal3">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Term of Payment</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="term_of_pay" name="term_of_pay" value="{{$data->term_payment}}">
              </div>
              <div class="col-sm-4">
                <input type="file" class="form-control-file" id="file_term-pay" name="file_term-pay">
              </div>
            </div>

          </td>
        </tr>
        <tr>
          <td style="text-align: left;">
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-10 col-form-label"><b>Informasi Bank</b> (untuk pembayaran)</label>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Account</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="nama_account" name="nama_account" value="{{$data->nama_acc_bank}}">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Bank</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="nama_bank" name="nama_bank" value="{{$data->nama_bank}}">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Nomor Rekening</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="no_rek" name="no_rek" value="{{$data->no_rekening}}">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-10 col-form-label">jika nama account tidak sama dengan nama perusahaan, mohon melampirkan surat pernyataan rekening bermaterai</label>
              <div class="col-sm-10">
                <input type="file" class="form-control-file" id="file_rekening" name="file_rekening">
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td style="text-align: left;">
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-6 col-form-label">Customer / Perusahaan yang telah dilayani</label>
              <div class="col-sm-10">
                <textarea class="form-control" id="cust_vendor" name="cust_vendor" rows="3">{{$data->customer }}</textarea>
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-10 col-form-label">Brand yang disupply (untuk ditributor atau toko) & fasilitas produksi yang dimiliki (untuk perusahaan manufaktur / bengkel)</label>
              <div class="col-sm-10">
                <textarea class="form-control" id="brand_fasilitas_vendor" name="brand_fasilitas_vendor" rows="3">{{$data->brand_fasilitas }}</textarea>
              </div>
            </div>
            <div class="form-group row" >
              <label for="inputEmail3" class="col-sm-10 col-form-label">jika ada Company Profile, mohon dilampirkan</label>
              <div class="col-sm-10">
                <input type="file" class="form-control-file" id="file_comp_profile" name="file_comp_profile">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-10 col-form-label">Catatan / Komentar</label>
              <div class="col-sm-10">
                <textarea class="form-control" id="remark" name="remark" rows="3">{{$data->remark}}</textarea>
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td style="text-align: left;">
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-10 col-form-label">Telah mengisi kuesioner ini dengan data dan komitmen yang sebenarnya</label>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Nama</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="nama_pengisi" name="nama_pengisi" value="{{$data->nama_pengisi}}">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Posisi</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="posisi_pengisi" name="posisi_pengisi" value="{{$data->posisi_pengisi}}">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">No. HP</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="hp_pengisi" name="hp_pengisi" value="{{$data->hp_pengisi}}">
              </div>
            </div><div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="email_pengisi" name="email_pengisi" value="{{$data->email_pengisi}}">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">KTP (lampirkan)</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="ktp" name="ktp" placeholder="No. KTP" value="{{$data->no_ktp}}">
              </div>
              <div class="col-sm-4">
                <input type="file" class="form-control-file" id="file_ktp" name="file_ktp">
              </div>
            </div>
          </td>
        </tr>

        <tr>
          <td style="text-align: left;">

          <div class="form-group row">
            <div class="col-sm-10">
							@if ($act=='view')
							<a href='{{action('DataVendorController@prints', $data->id)}} ' class='btn btn-primary' target="_blank">Print</a>
              <a href='javascript:history.back()' class='btn btn-success' >Back</a>
							@endif
							@if ($act=='edit')
							<button type="submit" class="btn btn-primary">Update</button>
							<a href='javascript:history.back()' class='btn btn-success' >Cancel</a>
              <a href='{{action('DataVendorController@delete_vendor', $data->id)}}' onclick="return confirm('Are you sure delete this data?')" class='btn btn-danger form-delete'>Delete Vendor</a>
              <!--
              {!!Form::open(['action' => ['DataVendorController@delete_vendor', $data['id']],  'method' => 'POST', 'class' => 'form-delete' ])!!}
              {!!Form::hidden('id', $data['id']) !!}
              {!!Form::hidden('username', Auth::user()->username) !!}
              {!!Form::submit('Delete Vendor', ['class' => 'btn btn-danger delete' , 'name' => 'delete_modal'])!!}
              {!!Form::close()!!} -->
							@endif
            </div>
          </div>
       </td>
      </tr>
  </tbody>
</table>
</form>
@else
      <h3>You need to log in. <a href="login">Click here to login</a></h3>
@endif
</div>



@endsection
