@extends('layouts.app')


@section('content')

<div class="container">

  @if (Session::has('data'))
  <div class="alert alert-success fade in">
    {{ Session::get('data')}}
  </div>
  @endif


  <div class="row">
    <div class="col-md-6"><b><u>PT. Rapid Plast Indonesia</u></b><br>Purchasing Department</div>
    <div class="col-md-6 text-right">No. Dokumen : FRM / 10-PRC/31<br>No. Revisi : 00 (03.05.19)</div>
  </div>
  <br>
  <div style="text-align: center;">
  <label style="font-size:16px;">KUESIONER PENILAIAN UNTUK JASA CLEANING SERVICE</label>
  </div>

<form  id="my-form" class="form-horizontal" name="New" enctype="multipart/form-data" method='post' action='save_form' >
{{csrf_field()}}
        <table class="table table-highlight">
            <thead>
            </thead>
            <tbody>

                <tr>
                    <td width='100' style="text-align: left;">Nama</td>
                    <td width='600'><input type="text" id="nama" name="nama" class="form-control" value="{{Auth::user()->name}}" readonly/></td>
                </tr>
                <tr>
                    <td width='100' style="text-align: left;">Jabatan</td>
                    <td width='600'><input type="text" id="jabatan" name="jabatan" class="form-control" value="{{Auth::user()->level}}" readonly/></td>
                </tr>
                <tr>
                    <td width='100' style="text-align: left;">Departmen</td>
                    <td width='600'><input type="text" id="dept" name="dept" class="form-control" value="{{Auth::user()->dept}}" readonly/></td>
                </tr>
                <tr>
                    <td width='100' style="text-align: left;">Tanggal</td>
                    <td style="text-align: left;"><?php echo date("d F Y"); ?></td>
                </tr>
            </tbody>
          </table>

          <table class="table table-highlight">
              <thead>
              </thead>
              <tbody>
                  <tr>
                      <td width='100%'><p style=" text-align: justify;">Kriteria* : </p>
                      <p style="text-align: justify;">1 = Tidak memuaskan ; 2 = Kurang Memuaskan ; 3 = Memuaskan ; 4 = Sangat Memuaskan</p>

                      </td>

                  </tr>
              </tbody>
            </table>


		<table class="table table-bordered">
            <thead>
				<tr class="text-body">
				<th class="align-middle text-center" bgcolor="#666666" width='100'>KATEGORI</th>
				<th class="align-middle text-center" bgcolor="#666666" width='450'>PERTANYAAN</th>
				<th class="align-middle text-center" bgcolor="#666666" width='150'>KRITERIA</th>
				</tr>
            </thead>
            <tbody>
            <td class="align-middle text-center" rowspan="<?php echo $qc1+1; ?>"><b>Kinerja</b></td>
            @foreach($q1 as $kinerja)
            <tr>
              <td style="text-align: left;"><?php echo $kinerja["question"]; ?></td>
              <td>
              <label class="radio-inline"><input data-d1="1" type="radio" name="<?php echo $kinerja["question_id"] ?>" value="1">1</label>&nbsp&nbsp
              <label class="radio-inline"><input data-d2="1" type="radio" name="<?php echo $kinerja["question_id"] ?>" value="2">2</label>&nbsp&nbsp
              <label class="radio-inline"><input data-d3="1" type="radio" name="<?php echo $kinerja["question_id"] ?>" value="3">3</label>&nbsp&nbsp
              <label class="radio-inline"><input data-d4="1" type="radio" name="<?php echo $kinerja["question_id"] ?>" value="4">4</label>
              </td>

            </tr>
            @endforeach

            <!------------------------------------------------------------->
            <td class="align-middle text-center" rowspan="<?php echo $qc2+1; ?>"><b>Pelayanan</b></td>
            @foreach($q2 as $pelayanan)
            <tr>
              <td style="text-align: left;"><?php echo $pelayanan["question"]; ?></td>
              <td>
              <label class="radio-inline"><input data-d1="1" type="radio" name="<?php echo $pelayanan["question_id"] ?>" value="1">1</label>&nbsp&nbsp
              <label class="radio-inline"><input data-d2="1" type="radio" name="<?php echo $pelayanan["question_id"] ?>" value="2">2</label>&nbsp&nbsp
              <label class="radio-inline"><input data-d3="1" type="radio" name="<?php echo $pelayanan["question_id"] ?>" value="3">3</label>&nbsp&nbsp
              <label class="radio-inline"><input data-d4="1" type="radio" name="<?php echo $pelayanan["question_id"] ?>" value="4">4</label>
              </td>

            </tr>
            @endforeach
            <!---------------------------------------->

            </tbody>
        </table>

        <table class="table table-highlight">
            <thead>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: left;vertical-align: top;" width='150'>Saran</td>
                    <td ><textarea class="form-control" rows="5" id="saran" name="saran"></textarea></td>
                </tr>

            </tbody>
        </table>


        <input type="hidden" id="form_id" name="form_id" value="FRM_PRC-31(Cleaning)" />
		<br><button type="submit" class="col-sm-offset-8 col-sm-4 btn btn-sm btn-primary"><b>Submit</b></button>

</form>
</div>
@endsection
