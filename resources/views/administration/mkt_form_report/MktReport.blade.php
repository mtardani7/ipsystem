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
  <label style="font-size:24px;">Marketing Form Report</label>
  </div>
	<ul>
	<li><a href='{{action('MktFormReportController@report_form_sales_9a')}}'>FRM/07-SALES/09a - Questionnaire Customer Satisfaction</a></li>
	<li><a href='{{action('MktFormReportController@report_form_sales_9b')}}'>FRM/07-SALES/09b - Kuesioner Kepuasan Pelanggan</a></li>
	</ul>

</div>
@endsection
