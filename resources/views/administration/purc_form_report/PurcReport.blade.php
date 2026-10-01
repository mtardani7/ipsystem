@extends('layouts.app')


@section('content')

@if ($message = Session::get('success'))
<div class="custom-alerts alert alert-success fade in">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
	{!! $message !!}
</div>
<?php Session::forget('success');?>
@endif

<div class="container">
  <div>
  <label style="font-size:24px;">Purchasing Form Report</label>
  </div>
	<ul>
	<li><a href='{{action('PurcFormReportController@report_form_prc_31')}}'>FRM/10-PRC/31 - Kuesioner Kepuasan Vendor Jasa</a></li>
	</ul>

</div>
@endsection
