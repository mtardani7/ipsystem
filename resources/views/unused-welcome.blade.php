@extends('layouts.app')



@section('content')

	<div class="container">
		 @if (Auth::check())
			 
				
				<div class="row" style="padding: 0px 15px 0;">
	  <div class="col-sm-4" style="background-color:WhiteSmoke ;">
			<div class="" style="overflow:auto; height:500px; width:105%;">
				<div style="padding:10px 0 10px 0;">
					<ul class="nav nav-list">
					
					
						<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="images/folder2.png" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;Manual Standard System</a> 
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=home&sub=viewlist&div=ALL&cat=MSS">PSQM</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=home&sub=viewlist&div=ALL&cat=GMPC">GMP Cosmetic</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=home&sub=viewlist&div=ALL&cat=HACCP">HACCP</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=home&sub=viewlist&div=ALL&cat=TACCP">TACCP</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=home&sub=viewlist&div=ALL&cat=VACCP">VACCP</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=home&sub=viewlist&div=GMP&cat=PRP">PRP</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=home&sub=viewlist&div=ALL&cat=RISK">Risk Assessment</a></li>
							</ul>
						  </li>
						  
						  <li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="images/folder2.png" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Company Profile"; ?></a> 
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL&cat=CMP">Company Profile</a></li>
							</ul>
						  </li>
						  
						  <li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="images/folder2.png" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Organization Chart"; ?></a> 
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL&cat=CHT">Organization Chart</a></li>
							</ul>
						  </li>
						  
						  <li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="images/folder2.png" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Standard Operating Procedure"; ?></a> 
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL SOP&cat=SOP">SOP</a></li>
							</ul>
						  </li>
						  
						  <li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="images/folder2.png" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Job Description"; ?></a> 
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL_JOB_HO&cat=JOB">HO</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL JOB Plant 1&cat=JOB">Plant 1</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL JOB Plant 2&cat=JOB">Plant 2</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL JOB Plant 3&cat=JOB">Plant 3</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL JOB Plant 4&cat=JOB">Plant 4</a></li>
							</ul>
						  </li>
						  
						  <li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="images/folder2.png" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "External Standard System"; ?></a> 
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL&cat=DOCISO">Document ISO</a></li>
							</ul>
						  </li>
						  
						  <li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="images/folder2.png" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "ISO Program"; ?></a> 
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL&cat=PROGISO">Program ISO</a></li>
							</ul>
						  </li>
						  
						  <li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="images/folder2.png" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Audit Report"; ?></a> 
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL&cat=AUDIN">Audit Internal</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL&cat=AUDEKS">Audit External</a></li>
							</ul>
						  </li>
						  
						  <li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="images/folder2.png" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Certificate"; ?></a> 
							<ul class="nav nav-list tree">
								<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;"><img src="images/folder2.png" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Plant 1"; ?></a>
								<ul class="nav nav-list tree">
								<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL&cat=CERTP1PS">Packaging Safety</a></li>
								<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL&cat=CERTP1SHE">SHE</a></li>
								</ul>
								</li>
								<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;"><img src="images/folder2.png" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Plant 2"; ?></a>
								<ul class="nav nav-list tree">
								<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL&cat=CERTP2PS">Packaging Safety</a></li>
								<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL&cat=CERTP2SHE">SHE</a></li>
								</ul>
								</li>
								<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;"><img src="images/folder2.png" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Plant 3"; ?></a>
								<ul class="nav nav-list tree">
								<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL&cat=CERTP3PS">Packaging Safety</a></li>
								<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL&cat=CERTP3SHE">SHE</a></li>
								</ul>
								</li>
								<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;"><img src="images/folder2.png" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Plant 4"; ?></a>
								<ul class="nav nav-list tree">
								<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL&cat=CERTP4PS">Packaging Safety</a></li>
								<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL&cat=CERTP4SHE">SHE</a></li>
								</ul>
								</li>
								<li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;padding-left:35px;"><img src="images/folder2.png" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Plant 5"; ?></a>
								<ul class="nav nav-list tree">
								<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL&cat=CERTP5PS">Packaging Safety</a></li>
								<li><a style='padding-left:60px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL&cat=CERTP5SHE">SHE</a></li>
								</ul>
								</li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL&cat=CERTSYS">Certificate System</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL&cat=CERTIN">Certificate Internal</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL&cat=CERTEKS">Certificate External</a></li>
							</ul>
						  </li>
						  
						  <li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="images/folder2.png" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "SHE"; ?></a> 
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=SHE&cat=POLICY">Policy</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=SHE&cat=JOB">Job Description</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=SHE&cat=SOP">Standard Operating Procedure</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=SHE&cat=WI">Work Instruction</a></li>
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=SHE&cat=FORM">Form</a></li>
							</ul>
						  </li>
						  
						  <li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="images/folder2.png" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Statutory & Regulatory"; ?></a> 
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=STATREG&cat=DOCSR">Article</a></li>
							</ul>
						  </li>
						  
						  <li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="images/folder2.png" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Layout Rapid Plast"; ?></a> 
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL&cat=LAYOUT">Layout</a></li>
							</ul>
						  </li>
						  
						  <li><a href="#" class="tree-toggle nav-header" style="font-weight:normal;"><img src="images/folder2.png" alt="" height="5%" width="5%" style="display:inline;">&nbsp;&nbsp;<?php echo "Layout CCTV"; ?></a> 
							<ul class="nav nav-list tree">
								<li><a style='padding-left:40px;list-style-type: none;color:blue;border-bottom: 1px dotted #ccc;height:5px;line-height:2px;' href="?p=ips&mm=files&sub=viewlist&div=ALL&cat=LAYOUTCCTV">Layout</a></li>
							</ul>
						  </li>
					
					</ul>
				</div>
			</div>
	  
	  </div>
	  
	</div>
                        
                @else
                    <h3>You need to log in. <a href="login">Click here to login</a></h3>
                @endif

</div>
@endsection