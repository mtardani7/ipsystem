@extends('layouts.app')


@section('content')

@if ($message = Session::get('success'))
<div class="custom-alerts alert alert-success fade in">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
  {!! $message !!}
</div>
<?php Session::forget('success'); ?>
@endif

<div class="container">
  <div>
    <label style="font-size:24px;">Form</label>
  </div>
  <ul>
    <li><a href='{{action('FormController@form_prc_31_limbah')}}'>FRM/10-PRC/31 - Kuesioner Kepuasan Vendor Jasa (Limbah)</a></li>
    <li><a href='{{action('FormController@form_prc_31_catering')}}'>FRM/10-PRC/31 - Kuesioner Kepuasan Vendor Jasa (Catering)</a></li>
    <li><a href='{{action('FormController@form_prc_31_pest')}}'>FRM/10-PRC/31 - Kuesioner Kepuasan Vendor Jasa (Pest Control)</a></li>
    <li><a href='{{action('FormController@form_prc_31_lab')}}'>FRM/10-PRC/31 - Kuesioner Kepuasan Vendor Jasa (Kalibrasi dan Laboratorium)</a></li>
    <li><a href='{{action('FormController@form_prc_31_forklift')}}'>FRM/10-PRC/31 - Kuesioner Kepuasan Vendor Jasa (Sewa Forklift)</a></li>
    <li><a href='{{action('FormController@form_prc_31_cleaning')}}'>FRM/10-PRC/31 - Kuesioner Kepuasan Vendor Jasa (Cleaning Service)</a></li>
  </ul>
</div>
@endsection