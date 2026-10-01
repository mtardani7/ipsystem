@extends('layouts.app')

@section('content')
<div class="container">
  @if (Session::has('data'))
  <div class="alert alert-success fade in">
    {{ Session::get('data')}}
  </div>
  @endif
  <div>
    <label style="font-size:24px;">View Form Answer</label>
  </div>

  <div class="row">
    <div class="col-md-6"><b><u>PT. Rapid Plast Indonesia</u></b><br>Purchasing Department</div>
    <div class="col-md-6 text-right">No. Dokumen : FRM / 10-PRC/31<br>No. Revisi : 00 (03.05.19)</div>
  </div>
  <br>
  <div style="text-align: center;">
    <label style="font-size:16px;">KUESIONER PENILAIAN UNTUK PENGELOLA WASTE ( B3 DAN NON B3 )</label>
  </div>
  <form id="my-form" class="form-horizontal" name="New" enctype="multipart/form-data" method='post' action='save_form'>
    {{csrf_field()}}
    <table class="table table-highlight">
      <thead>
      </thead>
      <tbody>

        <tr>
          <td width='100' style="text-align: left;">Nama</td>
          @if (isset($actions))
          <td width='600'><input type="text" id="nama" name="nama" class="form-control" value="{{$pengisi->nama}}" readonly /></td>
          @else
          <td width='600'><input type="text" id="nama" name="nama" class="form-control" value="{{Auth::user()->name}}" readonly /></td>
          @endif
        </tr>
        <tr>
          <td width='100' style="text-align: left;">Jabatan</td>
          @if (isset($actions))
          <td width='600'><input type="text" id="jabatan" name="jabatan" class="form-control" value="{{$pengisi->jabatan}}" readonly /></td>
          @else
          <td width='600'><input type="text" id="jabatan" name="jabatan" class="form-control" value="{{Auth::user()->level}}" readonly /></td>
          @endif
        </tr>
        <tr>
          <td width='100' style="text-align: left;">Departmen</td>
          @if (isset($actions))
          <td width='600'><input type="text" id="dept" name="dept" class="form-control" value="{{$pengisi->dept}}" readonly /></td>
          @else
          <td width='600'><input type="text" id="dept" name="dept" class="form-control" value="{{Auth::user()->dept}}" readonly /></td>
          @endif
        </tr>
        <tr>
          <td width='100' style="text-align: left;">Tanggal</td>
          @if (isset($actions))
          <td style="text-align: left;">{{$pengisi->date}}</td>
          @else
          <td style="text-align: left;"><?php echo date("d F Y"); ?></td>
          @endif
        </tr>
      </tbody>
    </table>
    <table class="table table-highlight">
      <thead>
      </thead>
      <tbody>
        <tr>
          <td width='100%'>
            <p style=" text-align: justify;">Kriteria* : </p>
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
        <td class="align-middle text-center" rowspan="<?php echo $qc1 + 1; ?>"><b>Harga</b></td>
        @foreach($q1 as $harga)
        <tr>
          <td style="text-align: left;"><?php echo $harga["question"]; ?></td>
          @if (isset($actions))
          @foreach($answers as $answer)
          <?php
          if ($answer->question_id == $harga->question_id)
            $value = $answer->nilai;
          ?>
          @endforeach
          <td style=""><?php echo $value; ?></td>
          @else
          <td>
            <label class="radio-inline"><input data-d1="1" type="radio" name="<?php echo $harga["question_id"] ?>" value="1">1</label>&nbsp&nbsp
            <label class="radio-inline"><input data-d2="1" type="radio" name="<?php echo $harga["question_id"] ?>" value="2">2</label>&nbsp&nbsp
            <label class="radio-inline"><input data-d3="1" type="radio" name="<?php echo $harga["question_id"] ?>" value="3">3</label>&nbsp&nbsp
            <label class="radio-inline"><input data-d4="1" type="radio" name="<?php echo $harga["question_id"] ?>" value="4">4</label>
          </td>
          @endif
        </tr>
        @endforeach
        <td class="align-middle text-center" rowspan="<?php echo $qc2 + 1; ?>"><b>Pembayaran</b></td>
        @foreach($q2 as $pembayaran)
        <tr>
          <td style="text-align: left;"><?php echo $pembayaran["question"]; ?></td>
          @if (isset($actions))
          @foreach($answers as $answer)
          <?php
          if ($answer->question_id == $pembayaran->question_id)
            $value = $answer->nilai;
          ?>
          @endforeach
          <td style=""><?php echo $value; ?></td>
          @else
          <td>
            <label class="radio-inline"><input data-d1="1" type="radio" name="<?php echo $pembayaran["question_id"] ?>" value="1">1</label>&nbsp&nbsp
            <label class="radio-inline"><input data-d2="1" type="radio" name="<?php echo $pembayaran["question_id"] ?>" value="2">2</label>&nbsp&nbsp
            <label class="radio-inline"><input data-d3="1" type="radio" name="<?php echo $pembayaran["question_id"] ?>" value="3">3</label>&nbsp&nbsp
            <label class="radio-inline"><input data-d4="1" type="radio" name="<?php echo $pembayaran["question_id"] ?>" value="4">4</label>
          </td>
          @endif
        </tr>
        @endforeach
        <td class="align-middle text-center" rowspan="<?php echo $qc3 + 1; ?>"><b>Tanggapan</b></td>
        @foreach($q3 as $tanggapan)
        <tr>
          <td style="text-align: left;"><?php echo $tanggapan["question"]; ?></td>
          @if (isset($actions))
          @foreach($answers as $answer)
          <?php
          if ($answer->question_id == $tanggapan->question_id)
            $value = $answer->nilai;
          ?>
          @endforeach
          <td style=""><?php echo $value; ?></td>
          @else
          <td>
            <label class="radio-inline"><input data-d1="1" type="radio" name="<?php echo $tanggapan["question_id"] ?>" value="1">1</label>&nbsp&nbsp
            <label class="radio-inline"><input data-d2="1" type="radio" name="<?php echo $tanggapan["question_id"] ?>" value="2">2</label>&nbsp&nbsp
            <label class="radio-inline"><input data-d3="1" type="radio" name="<?php echo $tanggapan["question_id"] ?>" value="3">3</label>&nbsp&nbsp
            <label class="radio-inline"><input data-d4="1" type="radio" name="<?php echo $tanggapan["question_id"] ?>" value="4">4</label>
          </td>
          @endif
        </tr>
        @endforeach
        <td class="align-middle text-center" rowspan="<?php echo $qc4 + 1; ?>"><b>Kinerja</b></td>
        @foreach($q4 as $kinerja)
        <tr>
          <td style="text-align: left;"><?php echo $kinerja["question"]; ?></td>
          @if (isset($actions))
          @foreach($answers as $answer)
          <?php
          if ($answer->question_id == $kinerja->question_id)
            $value = $answer->nilai;
          ?>
          @endforeach
          <td style=""><?php echo $value; ?></td>
          @else
          <td>
            <label class="radio-inline"><input data-d1="1" type="radio" name="<?php echo $kinerja["question_id"] ?>" value="1">1</label>&nbsp&nbsp
            <label class="radio-inline"><input data-d2="1" type="radio" name="<?php echo $kinerja["question_id"] ?>" value="2">2</label>&nbsp&nbsp
            <label class="radio-inline"><input data-d3="1" type="radio" name="<?php echo $kinerja["question_id"] ?>" value="3">3</label>&nbsp&nbsp
            <label class="radio-inline"><input data-d4="1" type="radio" name="<?php echo $kinerja["question_id"] ?>" value="4">4</label>
          </td>
          @endif
        </tr>
        @endforeach
        @foreach($q5 as $none)
        <tr>
          <td colspan='2' style="text-align: left;"><?php echo $none["question"]; ?></td>
          @if (isset($actions))
          @foreach($answers as $answer)
          <?php
          if ($answer->question_id == $none->question_id)
            $value = $answer->nilai;
          ?>
          @endforeach
          <td style=""><?php echo $value; ?></td>
          @else
          <td>
            <label class="radio-inline"><input data-d1="1" type="radio" name="<?php echo $none["question_id"] ?>" value="1">1</label>&nbsp&nbsp
            <label class="radio-inline"><input data-d2="1" type="radio" name="<?php echo $none["question_id"] ?>" value="2">2</label>&nbsp&nbsp
            <label class="radio-inline"><input data-d3="1" type="radio" name="<?php echo $none["question_id"] ?>" value="3">3</label>&nbsp&nbsp
            <label class="radio-inline"><input data-d4="1" type="radio" name="<?php echo $none["question_id"] ?>" value="4">4</label>
          </td>
          @endif
        </tr>
        @endforeach
      </tbody>
    </table>
    <table class="table table-highlight">
      <thead>
      </thead>
      <tbody>
        <tr>
          @if (isset($actions))
          @foreach($answers as $answer)
          <?php
          if ($answer->question_id == 'ls1')
            $remark = $answer->remark;
          ?>
          @endforeach
          <td style="text-align: left;vertical-align: top;" width='150'>Saran</td>
          <td><textarea class="form-control" rows="5" id="saran" name="saran">{{$remark}}</textarea></td>
          @else
          <td style="text-align: left;vertical-align: top;" width='150'>Saran</td>
          <td><textarea class="form-control" rows="5" id="saran" name="saran"></textarea></td>
          @endif
        </tr>
      </tbody>
    </table>
    <input type="hidden" id="form_id" name="form_id" value="FRM_PRC-31(Limbah)" />
    <br>
    @if (isset($actions))
    @else
    <button type="submit" class="col-sm-offset-8 col-sm-4 btn btn-sm btn-primary"><b>Submit</b></button>
    @endif
  </form>
</div>
@endsection