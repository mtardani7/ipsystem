@extends('layouts.app')
@section('content')
<div class="container">
	@if (Auth::check())
	<div class="row" style="padding: 0px 15px 0;">
		<div class="col-sm-4" style="background-color:WhiteSmoke ;">
			<div class="" style="overflow:auto; height:660px; width:105%;">
				<div style="padding:10px 0 10px 0;">
					<ul class="nav nav-list">
						@foreach($dists as $dist)
						<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;{{$dist['DIVDESC']}}</a>
							<ul class="nav nav-list tree">
								@if ($dist->WI==1)
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href='{{action('HomeController@viewlist', [$dist['DIVID'],'WI'])}}'>Work Instruction</a></li>
								@endif
								@if ($dist->FORM==1)
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href='{{action('HomeController@viewlist', [$dist['DIVID'],'FORM'])}}'>Form</a></li>
								@endif
								@if ($dist->SOP==1)
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href='{{action('HomeController@viewlist', [$dist['DIVID'],'SOP'])}}'>SOP</a></li>
								@endif
							</ul>
						</li>
						@endforeach
						<hr>
					</ul>
					<ul id="ordered-list" class="nav nav-list">
						<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Jewel Dyna Oralcare"; ?></a>
							<ul class="nav nav-list tree">
								<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Certificate"; ?></a>
									<ul class="nav nav-list tree">
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['TB','CERTSYS'])}}">Certificate System</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['TB','CERTJDOMIKRO'])}}">Mikrobiologi</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['TB','CERTJDOUTILITY'])}}">Utility</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTJDOAIR'])}}">Kwalitas Air</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTJDOSHE'])}}">SHE</a></li>
									</ul>
								</li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['TB','WI'])}}">Work Instruction</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['TB','FORM'])}}">Form</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['TB','SOPJDO'])}}">SOP</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['TB','RISK'])}}">Risk Assessment</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['TB','MSS'])}}">PSQM</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['TB','HACCP'])}}">HACCP</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['TB','TACCP'])}}">TACCP</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['TB','VACCP'])}}">VACCP</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['TB','CERTMSDS'])}}">MSDS</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['TB','JOB'])}}">Job Description</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['TB','DOCSR'])}}">Statutory Regulatory</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['TB','CHT'])}}">Organization Chart</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['TB','RECALL'])}}">Recall</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['TB','TRAINJDO'])}}">Training</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['TB','HALALDOC'])}}">Halal Document</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['TB','TRACE'])}}">Traceability</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['TB','MR'])}}">Managemen Review</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['TB','ALLERGEN'])}}">Allergen</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['TB','LOPLANT'])}}">Layout</a></li>
							</ul>
						</li>
						<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Kim Pai Dyna Tube"; ?></a>
							<ul class="nav nav-list tree">
								<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Certificate"; ?></a>
									<ul class="nav nav-list tree">
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['KPDT','CERTSYS'])}}">Certificate System</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['KPDT','CERTKPDMIKRO'])}}">Mikrobiologi</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['KPDT','CERTKPDUTILITY'])}}">Utility</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['KPDT','CERTKPDAIR'])}}">Kwalitas Air</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['KPDT','CERTKPDSHE'])}}">SHE</a></li>
									</ul>
								</li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['KPDT','WI'])}}">Work Instruction</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['KPDT','FORM'])}}">Form</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['KPDT','SOPKPDT'])}}">SOP</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['KPDT','RISK'])}}">Risk Assessment</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['KPDT','MSS'])}}">PSQM</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['KPDT','HACCP'])}}">HACCP</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['KPDT','VACCP'])}}">VACCP</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['KPDT','TACCP'])}}">TACCP</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['KPDT','CERTMSDS'])}}">MSDS</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['KPDT','JOB'])}}">Job Description</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['KPDT','DOCSR'])}}">Statutory Regulatory</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['KPDT','CHT'])}}">Organization Chart</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['KPDT','RECALL'])}}">Recall</a></li>
							</ul>
						</li>
						<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "ABC System"; ?></a>
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ABC','WI'])}}">Work Instruction</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ABC','FORM'])}}">Form</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ABC','TRENABC'])}}">Tren ABC System</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','ABC'])}}">Panduan Penerapan ABC</a></li>
							</ul>
						</li>
						<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;Manual Standard System</a>
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','MSS'])}}">PSQM</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','GMPC'])}}">GMP Cosmetic</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','HACCP'])}}">HACCP</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','TACCP'])}}">TACCP</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','VACCP'])}}">VACCP</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['GMP','PRP'])}}">PRP</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','RISK'])}}">Risk Assessment</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CAL'])}}">Risk Assessment Calibration</a></li>
								<!-- <li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','ABC'])}}">ABC System</a></li> -->
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','FMEA'])}}">FMEA</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','MR'])}}">Manajemen Review</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','RECALL'])}}">RECALL</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','ALLERGEN'])}}">Allergen</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','TRACE'])}}">Traceability</a></li>
							</ul>
						</li>
						<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Sistem Jaminan Halal"; ?></a>
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','SJHWI'])}}">Work Instruction</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','SJHFORM'])}}">Form</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','SJHSOP'])}}">SOP</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','HALALDOC'])}}">Halal Document</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','HALALDEC'])}}">Declaration</a></li>
							</ul>
						</li>
						<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Company Profile"; ?></a>
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CMP'])}}">Company Profile</a></li>
							</ul>
						</li>
						<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Organization Chart"; ?></a>
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CHT'])}}">Organization Chart</a></li>
							</ul>
						</li>
						<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Standard Operating Procedure"; ?></a>
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['RPID','SOP'])}}">SOP</a></li>
							</ul>
						</li>
						<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Job Description"; ?></a>
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL_JOB_HO','JOB'])}}">HO</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL JOB Plant 1','JOB'])}}">Plant 1</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL JOB Plant 2','JOB'])}}">Plant 2</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL JOB Plant 3','JOB'])}}">Plant 3</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL JOB Plant 4','JOB'])}}">Plant 4</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL JOB Plant 5','JOB'])}}">Plant 5</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL JOB Plant 6','JOB'])}}">Plant 6</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL JOB Plant 7','JOB'])}}">Plant 7</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL JOB Plant 8','JOB'])}}">Plant 8</a></li>
							</ul>
						</li>
						<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "External Standard System"; ?></a>
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','DOCISO'])}}">Document ISO</a></li>
							</ul>
						</li>
						<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "ISO Program"; ?></a>
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','PROGISO'])}}">Program ISO</a></li>
							</ul>
						</li>
						<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Audit Report"; ?></a>
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','AUDIN'])}}">Audit Internal</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','AUDEKS'])}}">Audit External</a></li>
								<ul class="nav nav-list tree">
									<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Self Assessment"; ?></a>
										<ul class="nav nav-list tree">
											<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','AssessmentP1'])}}">Plant 1</a></li>
											<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','AssessmentP2'])}}">Plant 2</a></li>
											<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','AssessmentP3'])}}">Plant 3</a></li>
											<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','AssessmentP4'])}}">Plant 4</a></li>
											<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','AssessmentP5'])}}">Plant 5</a></li>
										</ul>
									</li>
								</ul>
							</ul>
						</li>
						<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Certificate"; ?></a>
							<ul class="nav nav-list tree">
								<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Plant 1"; ?></a>
									<ul class="nav nav-list tree">
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP1PS'])}}">Packaging Safety</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP1MIKRO'])}}">Mikrobiologi</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP1MIGRASI'])}}">Migrasi</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP1UTILITY'])}}">Utility</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP1AIR'])}}">Kwalitas Air</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP1SHE'])}}">SHE</a></li>
									</ul>
								</li>
								<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Plant 2"; ?></a>
									<ul class="nav nav-list tree">
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP2PS'])}}">Packaging Safety</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP2MIKRO'])}}">Mikrobiologi</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP2MIGRASI'])}}">Migrasi</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP2UTILITY'])}}">Utility</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP2AIR'])}}">Kwalitas Air</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP2SHE'])}}">SHE</a></li>
									</ul>
								</li>
								<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Plant 3"; ?></a>
									<ul class="nav nav-list tree">
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP3PS'])}}">Packaging Safety</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP3MIKRO'])}}">Mikrobiologi</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP3MIGRASI'])}}">Migrasi</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP3UTILITY'])}}">Utility</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP3AIR'])}}">Kwalitas Air</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP3SHE'])}}">SHE</a></li>
									</ul>
								</li>
								<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Plant 4"; ?></a>
									<ul class="nav nav-list tree">
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP4PS'])}}">Packaging Safety</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP4MIKRO'])}}">Mikrobiologi</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP4MIGRASI'])}}">Migrasi</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP4UTILITY'])}}">Utility</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP4AIR'])}}">Kwalitas Air</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP4SHE'])}}">SHE</a></li>
									</ul>
								</li>
								<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Plant 5"; ?></a>
									<ul class="nav nav-list tree">
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP5PS'])}}">Packaging Safety</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP5MIKRO'])}}">Mikrobiologi</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP5MIGRASI'])}}">Migrasi</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP5UTILITY'])}}">Utility</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP5AIR'])}}">Kwalitas Air</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP5SHE'])}}">SHE</a></li>
									</ul>
								</li>
								<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Plant 7"; ?></a>
									<ul class="nav nav-list tree">
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP7PS'])}}">Packaging Safety</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP7MIKRO'])}}">Mikrobiologi</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP7MIGRASI'])}}">Migrasi</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP7UTILITY'])}}">Utility</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP7AIR'])}}">Kwalitas Air</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP7SHE'])}}">SHE</a></li>
									</ul>
								</li>
								<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Plant 8"; ?></a>
									<ul class="nav nav-list tree">
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP8PS'])}}">Packaging Safety</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP8MIKRO'])}}">Mikrobiologi</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP8MIGRASI'])}}">Migrasi</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP8UTILITY'])}}">Utility</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP8AIR'])}}">Kwalitas Air</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTP8SHE'])}}">SHE</a></li>
									</ul>
								</li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTSYS'])}}">Certificate System</a></li>
								<!-- <li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTIN'])}}">Certificate Internal</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTEKS'])}}">Certificate External</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','CERTMSDS'])}}">MSDS</a></li> -->
							</ul>
						</li>
						<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "SHE"; ?></a>
							<ul class="nav nav-list tree">
								<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Risk Assasement"; ?></a>
									<ul class="nav nav-list tree">
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['SHE','RISKP1'])}}">RPID 1</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['SHE','RISKP2'])}}">RPID 2</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['SHE','RISKP3'])}}">RPID 3</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['SHE','RISKP4'])}}">RPID 4</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['SHE','RISKP5'])}}">RPID 5</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['SHE','RISKJDO'])}}">JDO</a></li>
										<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{route('viewvideo')}}" target="_blank">Safety Induction P2&P4</a></li>
									</ul>
								</li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['SHE','POLICY'])}}">Policy</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['SHE','JOB'])}}">Job Description</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['SHE','SOP'])}}">Standard Operating Procedure</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['SHE','WI'])}}">Work Instruction</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['SHE','FORM'])}}">Form</a></li>
							</ul>
						</li>
						<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Statutory & Regulatory"; ?></a>
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['STATREG','DOCSR'])}}">Article</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['STATREG','DEC'])}}">Declaration</a></li>
							</ul>
						</li>
						<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Layout Rapid Plast"; ?></a>
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','LOPLANT'])}}">Layout Plant</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','LOCCTV'])}}">Layout CCTV</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','LOSHE'])}}">Layout SHE</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','LOPEST'])}}">Layout Pest Control</a></li>
							</ul>
						</li>
						<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Training"; ?></a>
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','MATRIX'])}}">Matrix Training</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','GAPCOMP'])}}">Gap Competency</a></li>
								<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Training Inhouse"; ?></a>
									<ul class="nav nav-list tree">
										<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:45px;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Materi"; ?></a>
											<ul class="nav nav-list tree">
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','TRAININR1'])}}">Plant 1</a></li>
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','TRAININR2'])}}">Plant 2</a></li>
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','TRAININR3'])}}">Plant 3</a></li>
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','TRAININR4'])}}">Plant 4</a></li>
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','TRAININR5'])}}">Plant 5</a></li>
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','TRAININJDO'])}}">JDO</a></li>
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','TRAININKPD'])}}">KPD</a></li>
											</ul>
										</li>
										<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:45px;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Evaluasi"; ?></a>
											<ul class="nav nav-list tree">
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','EVALTRAININR1'])}}">Plant 1</a></li>
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','EVALTRAININR2'])}}">Plant 2</a></li>
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','EVALTRAININR3'])}}">Plant 3</a></li>
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','EVALTRAININR4'])}}">Plant 4</a></li>
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','EVALTRAININR5'])}}">Plant 5</a></li>
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','EVALTRAININJDO'])}}">JDO</a></li>
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','EVALTRAININKPD'])}}">KPD</a></li>
											</ul>
										</li>
									</ul>
								</li>
								<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Training Outhouse"; ?></a>
									<ul class="nav nav-list tree">
										<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:45px;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Materi"; ?></a>
											<ul class="nav nav-list tree">
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','TRAINOUTR1'])}}">Plant 1</a></li>
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','TRAINOUTR2'])}}">Plant 2</a></li>
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','TRAINOUTR3'])}}">Plant 3</a></li>
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','TRAINOUTR4'])}}">Plant 4</a></li>
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','TRAINOUTR5'])}}">Plant 5</a></li>
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','TRAINOUTJDO'])}}">JDO</a></li>
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','TRAINOUTKPD'])}}">KPD</a></li>
											</ul>
										</li>
										<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:45px;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Evaluasi"; ?></a>
											<ul class="nav nav-list tree">
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','EVALTRAINOUTR1'])}}">Plant 1</a></li>
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','EVALTRAINOUTR2'])}}">Plant 2</a></li>
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','EVALTRAINOUTR3'])}}">Plant 3</a></li>
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','EVALTRAINOUTR4'])}}">Plant 4</a></li>
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','EVALTRAINOUTR5'])}}">Plant 5</a></li>
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','EVALTRAINOUTJDO'])}}">JDO</a></li>
												<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','EVALTRAINOUTKPD'])}}">KPD</a></li>
											</ul>
										</li>
									</ul>
								</li>
							</ul>
						</li>
						<li>
							<a href="#" class="tree-toggle nav-header" style="font-weight:normal;">
								<img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">
								&nbsp;&nbsp;<?php echo "SAP Procedure"; ?>
							</a>

							<ul class="nav nav-list tree">
								<li>
									<a href="{{action('HomeController@viewlist',['ALL','SPBOM'])}}"
										style="font-weight:normal;padding-left:35px;">
										<img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">
										&nbsp;&nbsp;<?php echo "Bill of Material (BoM)"; ?>
									</a>
								</li>

								<li>
									<a href="{{action('HomeController@viewlist',['ALL','SPGI'])}}"
										style="font-weight:normal;padding-left:35px;">
										<img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">
										&nbsp;&nbsp;<?php echo "Goods Issue"; ?>
									</a>
								</li>

								<li>
									<a href="{{action('HomeController@viewlist',['ALL','SPGR'])}}"
										style="font-weight:normal;padding-left:35px;">
										<img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">
										&nbsp;&nbsp;<?php echo "Goods Receipt"; ?>
									</a>
								</li>

								<li>
									<a href="{{action('HomeController@viewlist',['ALL','SPPI'])}}"
										style="font-weight:normal;padding-left:35px;">
										<img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">
										&nbsp;&nbsp;<?php echo "Physical Inventory"; ?>
									</a>
								</li>
								<li>
									<a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;">
										<img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">
										&nbsp;&nbsp;<?php echo "Plant Maintenance"; ?>
									</a>
									<ul class="nav nav-list tree">
										<li><a style="padding-left:60px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','SPPMDPCRT'])}}">Dynaplast Custom Report & Transaction</a></li>
										<li><a style="padding-left:60px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','SPPMENV'])}}">Environment</a></li>
										<li><a style="padding-left:60px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','SPPMEQ'])}}">Equipment</a></li>
										<li><a style="padding-left:60px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','SPPMFL'])}}">Functional Location</a></li>
										<li><a style="padding-left:60px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','SPPMIS'])}}">Information System</a></li>
										<li><a style="padding-left:60px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','SPPMMP'])}}">Maintenance Processing</a></li>
										<li><a style="padding-left:60px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','SPPMBM'])}}">Business Process</a></li>
										<li><a style="padding-left:60px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','SPPMBS'])}}">Business Scenario</a></li>
										<li><a style="padding-left:60px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','SPPMPM'])}}">Preventive Maintenance</a></li>
									</ul>
								</li>
								<li>
									<a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;">
										<img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">
										&nbsp;&nbsp;<?php echo "Production Planning"; ?>
									</a>
									<ul class="nav nav-list tree">
										<li><a style="padding-left:60px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','SPPPBP'])}}">Business Process</a></li>
										<li><a style="padding-left:60px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','SPPPPSS'])}}">PSS</a></li>
									</ul>
								</li>
								<li>
									<a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;">
										<img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">
										&nbsp;&nbsp;<?php echo "Sales and Distribution"; ?>
									</a>
									<ul class="nav nav-list tree">
										<li><a style="padding-left:60px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','SPSDDLV'])}}">Delivery</a></li>
										<li><a style="padding-left:60px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','SPSDPRE'])}}">Presales</a></li>
										<li><a style="padding-left:60px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','SPSDRPT'])}}">Report</a></li>
										<li><a style="padding-left:60px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','SPSDSOP'])}}">Sales Order Processing</a></li>
										<li><a style="padding-left:60px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','SPSDBP'])}}">Business Process</a></li>
										<li><a style="padding-left:60px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','SPSDPSSCH'])}}">PSS Complain Handling</a></li>
										<li><a style="padding-left:60px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','SPSDSOTC'])}}">Scenario Order To Cash</a></li>
									</ul>
								</li>
								<li><a href="{{action('HomeController@viewlist',['ALL','SPPSS2018'])}}" style="padding-left:35px;"><img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">&nbsp;&nbsp;<?php echo "PSS 2018"; ?></a></li>
								<li><a href="{{action('HomeController@viewlist',['ALL','SPROUTING'])}}" style="padding-left:35px;"><img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">&nbsp;&nbsp;<?php echo "Routing"; ?></a></li>
								<li><a href="{{action('HomeController@viewlist',['ALL','SPSTO'])}}" style="padding-left:35px;"><img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">&nbsp;&nbsp;<?php echo "STO"; ?></a></li>
								<li><a href="{{action('HomeController@viewlist',['ALL','SPSTOCK'])}}" style="padding-left:35px;"><img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">&nbsp;&nbsp;<?php echo "Stock"; ?></a></li>
								<li><a href="{{action('HomeController@viewlist',['ALL','SPSTOCKOPN'])}}" style="padding-left:35px;"><img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">&nbsp;&nbsp;<?php echo "Stock Opname"; ?></a></li>
								<li><a href="{{action('HomeController@viewlist',['ALL','SPSTOCKTRF'])}}" style="padding-left:35px;"><img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">&nbsp;&nbsp;<?php echo "Stock Transfer"; ?></a></li>
								<li><a href="{{action('HomeController@viewlist',['ALL','SPWORKCENTER'])}}" style="padding-left:35px;"><img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">&nbsp;&nbsp;<?php echo "WorkCenter"; ?></a></li>
							</ul>
						</li>
						<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Kaizen"; ?></a>
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','KAIZENP1'])}}">Plant 1</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','KAIZENP1'])}}">Plant 2</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','KAIZENP1'])}}">Plant 3</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','KAIZENP1'])}}">Plant 4</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','KAIZENP1'])}}">Plant 5</a></li>
							</ul>
						</li>

						<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "COVID-19"; ?></a>
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','FORM'])}}">FORM</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','GUIDELINES'])}}">GUIDELINES</a></li>
							</ul>
						</li>
						<li>
							<!--EDIT 07/08/2024-->
							<!-- <li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "OPL"; ?></a>
								<ul class="nav nav-list tree">
									<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','OPLP1'])}}">Plant 1</a></li>
									<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','OPLP2'])}}">Plant 2</a></li>
									<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','OPLP3'])}}">Plant 3</a></li>
									<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','OPLP4'])}}">Plant 4</a></li>
									<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','OPLP5'])}}">Plant 5</a></li>	
									<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','OPJDO'])}}">JDO</a></li>
									<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','OPLKPDT'])}}">KPDT</a></li>
								</ul>
							</li> -->

						<li>
							<a href="#" class="tree-toggle nav-header" style="font-weight:normal;">
								<img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">
								&nbsp;&nbsp;OPL
							</a>

							<ul class="nav nav-list tree">
								<li>
									<a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;">
										<img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">
										&nbsp;&nbsp;Plant 1
									</a>
									<ul class="nav nav-list tree">
										<li>
											<a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;"
												href="{{action('HomeController@viewlist',['MAN1','OPLP1'])}}">
												Produksi
											</a>
										</li>
										<li>
											<a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;"
												href="{{action('HomeController@viewlist',['QA','OPLP1'])}}">
												Quality Assurance
											</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;">
										<img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">
										&nbsp;&nbsp;Plant 2
									</a>
									<ul class="nav nav-list tree">
										<li>
											<a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;"
												href="{{action('HomeController@viewlist',['MAN2','OPLP2'])}}">
												Produksi
											</a>
										</li>
										<li>
											<a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;"
												href="{{action('HomeController@viewlist',['QA','OPLP2'])}}">
												Quality Assurance
											</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;">
										<img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">
										&nbsp;&nbsp;Plant 3
									</a>
									<ul class="nav nav-list tree">
										<li>
											<a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;"
												href="{{action('HomeController@viewlist',['MAN3','OPLP3'])}}">
												Produksi
											</a>
										</li>
										<li>
											<a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;"
												href="{{action('HomeController@viewlist',['QA','OPLP3'])}}">
												Quality Assurance
											</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;">
										<img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">
										&nbsp;&nbsp;Plant 4
									</a>
									<ul class="nav nav-list tree">
										<li>
											<a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;"
												href="{{action('HomeController@viewlist',['MAN4','OPLP4'])}}">
												Produksi
											</a>
										</li>
										<li>
											<a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;"
												href="{{action('HomeController@viewlist',['QA','OPLP4'])}}">
												Quality Assurance
											</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;">
										<img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">
										&nbsp;&nbsp;Plant 5
									</a>
									<ul class="nav nav-list tree">
										<li>
											<a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;"
												href="{{action('HomeController@viewlist',['MAN5','OPLP5'])}}">
												Produksi
											</a>
										</li>
										<li>
											<a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;"
												href="{{action('HomeController@viewlist',['QA','OPLP5'])}}">
												Quality Assurance
											</a>
										</li>
									</ul>
								</li>


								<li>
									<a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;">
										<img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">
										&nbsp;&nbsp;Plant 8
									</a>
									<ul class="nav nav-list tree">
										<li>
											<a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;"
												href="{{action('HomeController@viewlist',['MAN8','OPLP8'])}}">
												Produksi
											</a>
										</li>
										<li>
											<a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;"
												href="{{action('HomeController@viewlist',['QA','OPLP8'])}}">
												Quality Assurance
											</a>
										</li>
									</ul>
								</li>

								<li>
									<a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;">
										<img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">
										&nbsp;&nbsp;JDO
									</a>
									<ul class="nav nav-list tree">
										<li>
											<a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;"
												href="{{action('HomeController@viewlist',['ALL','OPJDO'])}}">
												Produksi
											</a>
										</li>
										<li>
											<a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;"
												href="{{action('HomeController@viewlist',['QA','OPJDO'])}}">
												Quality Assurance
											</a>
										</li>
									</ul>
								</li>
								<li>
									<a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;">
										<img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">
										&nbsp;&nbsp;KPDT
									</a>
									<ul class="nav nav-list tree">
										<li>
											<a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;"
												href="{{action('HomeController@viewlist',['KPDT','OPLKPDT'])}}">
												Produksi
											</a>
										</li>
										<li>
											<a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;"
												href="{{action('HomeController@viewlist',['QA','OPLKPDT'])}}">
												Quality Assurance
											</a>
										</li>
									</ul>
								</li>

							</ul>
						</li>

						<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Dokumen Bahan"; ?></a>
							<ul class="nav nav-list tree">
								<li>
									<a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;">
										<img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">
										&nbsp;&nbsp;<?php echo "Plant 1"; ?>
									</a>
									<ul class="nav nav-list tree">
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','ALLERGENP1'])}}">Allergen Statement</a></li>
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','FCP1'])}}">Food Contact</a></li>
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','MSDSP1'])}}">MSDS</a></li>
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','TDSP1'])}}">TDS</a></li>
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','MATRIXP1'])}}">Matrix</a></li>
									</ul>
								</li>
								<li>
									<a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;">
										<img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">
										&nbsp;&nbsp;<?php echo "Plant 2"; ?>
									</a>
									<ul class="nav nav-list tree">
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','ALLERGENP2'])}}">Allergen Statement</a></li>
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','FCP2'])}}">Food Contact</a></li>
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','MSDSP2'])}}">MSDS</a></li>
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','TDSP2'])}}">TDS</a></li>
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','MATRIXP2'])}}">Matrix</a></li>
									</ul>
								</li>
								<li>
									<a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;">
										<img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">
										&nbsp;&nbsp;<?php echo "Plant 3"; ?>
									</a>
									<ul class="nav nav-list tree">
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','ALLERGENP3'])}}">Allergen Statement</a></li>
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','FCP3'])}}">Food Contact</a></li>
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','MSDSP3'])}}">MSDS</a></li>
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','TDSP3'])}}">TDS</a></li>
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','MATRIXP3'])}}">Matrix</a></li>
									</ul>
								</li>
								<li>
									<a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;">
										<img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">
										&nbsp;&nbsp;<?php echo "Plant 4"; ?>
									</a>
									<ul class="nav nav-list tree">
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','ALLERGENP4'])}}">Allergen Statement</a></li>
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','FCP4'])}}">Food Contact</a></li>
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','MSDSP4'])}}">MSDS</a></li>
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','TDSP4'])}}">TDS</a></li>
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','MATRIXP4'])}}">Matrix</a></li>
									</ul>
								</li>
								<li>
									<a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;">
										<img src="{{ asset('img/folder2.png') }}" height="5%" width="5%">
										&nbsp;&nbsp;<?php echo "Plant 5"; ?>
									</a>
									<ul class="nav nav-list tree">
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','ALLERGENP5'])}}">Allergen Statement</a></li>
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','FCP5'])}}">Food Contact</a></li>
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','MSDSP5'])}}">MSDS</a></li>
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','TDSP5'])}}">TDS</a></li>
										<li><a style="padding-left:40px;color:blue;border-bottom:1px dotted #ccc;" href="{{action('HomeController@viewlist',['ALL','MATRIXP5'])}}">Matrix</a></li>
									</ul>
								</li>
								<!-- <li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "JDO"; ?></a>
								<ul class="nav nav-list tree">
								<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['ALL','OPJDO'])}}">Produksi</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['QA','OPJDO'])}}">Quality Assurance</a></li>
								</ul>
								</ul>
								</li>
								<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;"><img src="{{ asset('img/folder2.png') }}" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "KPDT"; ?></a>
								<ul class="nav nav-list tree">
								<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['KPDT','OPLKPDT'])}}">Produksi</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="{{action('HomeController@viewlist', ['QA','OPLKPDT'])}}">Quality Assurance</a></li>
								</ul>
								</ul>
								</li> -->
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="col-sm-8" style="background-color:white;">
			<table style="border: 2px solid white;" width="102%">
				<tr>
					<td style="border: 2px solid white;" width="100%" style="padding: 0px 10px 0px 0px;" align="left"><img src="{{ asset('img/ISO_LOGO.jpg') }}" alt="" height="60%" width="40%" style="display:inline;"></td>
					<td width="100%" style="padding: 0px 10px 0px 0px;" align="right">
						<table width='350'>
							<tr>
								<table>
									<tr>
										<td class="tableContent">
											<input
												type="text"
												id="doc_desc"
												style="width:97%;"
												onkeydown="checkEnter(event)">
										</td>

										<td colspan="2" class="tableField" align="right">
											<a href="#" class="btn btn-sm btn-primary" onclick="searchDoc()">Search</a>
										</td>
									</tr>
								</table>
								<script>
									function searchDoc() {
										var value = document.getElementById('doc_desc').value;
										window.location.href = "{{ route('doc_search') }}?doc_desc=" + encodeURIComponent(value);
									}

									function checkEnter(e) {
										e = e || window.event;
										if (e.key === "Enter" || e.keyCode === 13) {
											e.preventDefault();
											searchDoc();
										}
									}
								</script>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<div id="acontent" class="defaults">
				<table class="table table-bordered" id='mt' width='100%' height="">
					<thead>
						<tr>
							<th style="color:white;" bgcolor="#666666" width='40'>Nr.</th>
							<th style="color:white;" bgcolor="#666666" width='100'>Subject</th>
							<th style="color:white;" bgcolor="#666666">Description</th>
							<th style="color:white;" bgcolor="#666666" width='100'>PIC</th>
							<th style="color:white;" bgcolor="#666666" width='50'>Date</th>
						</tr>
					</thead>
					<tbody id="movies">
						@php $no = ($notes->currentpage()-1) * $notes->perpage() + 1; @endphp
						@foreach($notes as $note)
							@if($note['SHARESTATUS'] == 'Y')
							<tr bgcolor="#fff">
								<td align="center">{{ $no }}</td>
								<td align="center">{{ $note['SUBJECT'] }}</td>
								<td align="center">{{ $note['DESCRIPTION'] }}</td>
								<td align="center">{{ $note['PIC'] }}</td>
								<td align="center">{{ $note['INPUTDATE'] }}</td>
							</tr>
							@php $no++; @endphp
							@endif
						@endforeach
					</tbody>
					{{ $notes->links() }}
				</table>
			</div>
			<style>
				.home-footer__content { display: block !important; padding: 0 !important; }
				.home-footer__notice { height: auto !important; margin: 0 !important; }
				.home-footer__logos { display: grid !important; grid-template-columns: repeat(6, minmax(0, 1fr)); gap: 10px; width: 100%; }
				.home-footer__logos { margin: 8px 0 0 !important; }
				.home-footer__logo { display: flex !important; align-items: center; justify-content: center; height: 92px; min-width: 0; padding: 6px; box-sizing: border-box; overflow: hidden; border: none !important; }
				.home-footer__logo img { display: block; width: 100% !important; height: 100% !important; max-width: 100%; object-fit: contain; }
				@media (max-width: 767px) { .home-footer__logos { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
				@media (max-width: 480px) { .home-footer__logos { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
			</style>
			<div class="home-footer">
				<hr>
				<div class="home-footer__content">
					<div class="home-footer__notice">
						<p>
							This software is a property that be used to control quality documents of ISO 9001:2015
							that enable you to view or print the documents as your required as long as you have access to do.
							Due to electronical controller, hard copy of documents is not available again. If you require the hard copy,
							the system allow you to print them, but the documents you printed becomes UNCONTROLLED DOCUMENT status.
						</p>
					</div>
					<div class="home-footer__logos" aria-label="Company certifications">
						<div class="home-footer__logo"><img src="{{ asset('logo/ISO_9001-2015.svg.webp') }}" alt="ISO 9001"></div>
						<div class="home-footer__logo"><img src="{{ asset('logo/GMP-black-Logo-Vector.svg--300x300.png') }}" alt="GMP"></div>
						<div class="home-footer__logo"><img src="{{ asset('logo/training-fssc-22000.png') }}" alt="FSSC 22000"></div>
						<div class="home-footer__logo"><img src="{{ asset('logo/pngtree-iso-22000-label-vector-png-image_15406633.png') }}" alt="ISO 22000"></div>
						<div class="home-footer__logo"><img src="{{ asset('logo/brcgs-packaging-materials-certificated9872.logowik.com.webp') }}" alt="BRC Packaging Material"></div>
						<div class="home-footer__logo"><img src="{{ asset('logo/Halal_Indonesia.svg') }}" alt="Halal"></div>
					</div>
				</div>
			</div>

		</div class="clearfix">
	</div>

	@else
	<h3>You need to log in. <a href="login">Click here to login</a></h3>
	@endif

</div>
<div> <br> </div>
<!-- <script>
$('.tree-toggle').click(function () {
	$(this).parent().children('ul.tree').toggle(200);
});

$(document).ready(function() {
    const $list = $("#ordered-list").first(); // ambil ul yang ingin diurutkan
    const $items = $list.children("li").get();

    $items.sort(function(a, b) {
        const textA = $(a).text().trim().toUpperCase();
        const textB = $(b).text().trim().toUpperCase();
        return textA.localeCompare(textB); // urutkan ASC
    });

    // Kosongkan dan masukkan lagi elemen yang sudah diurut
    $list.empty();
    $.each($items, function(idx, itm) {
        $list.append(itm);
    });
});
</script> -->
@endsection