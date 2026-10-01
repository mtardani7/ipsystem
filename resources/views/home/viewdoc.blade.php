<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Iso Paperless System</title>
<link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">


<!-- Menu -->
<style>
	.drop_menu { /* Background menu */
	background: #555;
	padding:100;
	margin:1;
	list-style-type: none;
	height:40px;
	}

	.drop_menu li { float:left; }
	.drop_menu li a {
	padding: 10px 10px;     /* Space Menu */
	display: block;
	color:  #DDD;
	text-decoration: none;
	font:  14px arial, verdana, sans-serif;
	font-size: 16px;
	}

	/* Submenu */
	.drop_menu ul {
		position: absolute;
		left:-9999px;
		top:-9999px;
		list-style-type: none;
	}

	.drop_menu ul a {
    	padding: 10px;
		height: auto;
		display: block;
		white-space: nowrap;
		float: none;
		text-transform: none;
	}
	.drop_menu li:hover { position:relative; background: #B00 ; cursor: pointer; } /* Highlight Default #888*/
	.drop_menu li:hover ul {     /* Posisi Sub menu */
		left:0px;
		top:30px;
		background: #888;
		padding:0px;
		cursor: pointer;
	}

	.drop_menu li:hover ul li a {   /* Posisi Sub menu */
		padding:5px;
		display:block;
		width: 250px;
		text-indent:15px;
		background-color:#888;
		cursor: pointer;
	}
	.drop_menu li:hover ul li a:hover { background: #B00; cursor: pointer;}  /* default Color Highlight #005555 */
	.Font_Memo article {
		font-size: 14px;
	}
	.Font_Memo article {
		font-size: 10px;
	}
	.Font_Memo article {
		font-size: 12px;
	}
    </style>
  <!-- Batas dropdown2 -->


<!-- Menu Format -->
<style>
#header {
    background-color:black;
    color:white;
    text-align:center;
    padding:5px;
}
#nav {
	 width:300px;
/*    line-height:30px; */
    background-color:#eeeeee;
/*    height:300px; */
/*    width:100px; */
    float:left;
/*    padding:5px;	       */
}

#navright {
/*    line-height:30px; */
    background-color:#eeeeee;
/*    height:300px; */
/*    width:100px; */
    float: right;
/*    padding:5px;	       */
}

#section {
    width:500px;
    float:left;
    padding:10px;
}

#section1 {
    width:200px;
    float:left;
    padding:10px;
	text-align:left;
}

#footer {
    background-color:#555;
    color:white;
    clear:both;

    text-align:center;
   padding:8px;
}
.Font_Header {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 18px;
	font-style: italic;
	color: #888;
}
.a {
	font-size: 24px;
}
.a {
	color: #222;
	font-size: 20px;
}
</style>


<script>
function layar() {
var width=screen.availWidth;

var height=screen.height;var cek=alert('Your Screen Resolution '+width+'px x '+height+'px');

if(cek) {
document.write("Your Screen Resolution "+width+"px x "+height+"px");
}
}
</script>


<script>
function goBack() {
    window.history.back()
}
</script>


</head>
<body>

	<body>
		<asp:panel id="pnlPdfHrBook" runat="server" backcolor="White" xmlns:asp="#unknown">
<p>
<div align="left">


<table width="1000" border="0">
  <tr>
    <td>

    <div id = "nav"; style="padding:0px; overflow:auto; width:250px; height:620px; border:0px solid white; font-size: 12px; font-family: Verdana, Geneva, sans-serif;" align="left" >

  <div class="drop">
   <ul class="drop_menu">
	  <li></li>
	  <li></li>
		  <li><a onclick="window.history.back()">Back</a></li>
<!--      <li><a href="../IPSystem/ViewMasterlist.php">Back</a></li> -->
    </ul>
  </div>

  <table width="250" border="0">
        <tr>
          <td width="76"><font color="BLACK" face="Arial" size="2">Doc ID</font></td>
          <td width="10">:</td>
          <td width="324"><font color="BLACK" face="Geneva, Arial" size="2">{{ $dist->DOCID }}</font></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Revision</td>
          <td>:</td>
          <td><font color="BLACK" face="Geneva, Arial" size="2">{{ $dist->DOCREV }}</font></td>
        </tr>
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td>Doc Name </td>
          <td>:</td>
          <td><font color="BLACK" face="Geneva, Arial" size="2">{{ $dist->DOCDESC }}</font></td>
        </tr>

		<tr>
          <td>Download PDF </td>
          <td>:</td>
          <td><a href="{{URL::to('/')}}/public/files/1/{{ $dist->PDFPRINT }}" download><button>Download PDF </button></a></td>
        </tr>

  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>



<img src="images/gb-company-logo2.png" alt="" width="69" height="40" /><span class="Font_Header"> <span class="a">View Documents</span></span></div>

&nbsp;</td>
    <td>

<table width="1090" border="0">
  <tr>
    <td height="38">
	@if (Session()->has('not found'))
	Document not found on server ->
	{{$document_name}}
	@endif

		@if ($view_type == 'uncontrolled')
    <embed src="{{URL::to('/')}}/public/files/1/{{ $dist->PDFPRINT }}"   width='1070'  height='600'type='application/pdf' >
		@elseif ($view_type == 'original')
		<embed src="{{URL::to('/')}}/public/files/1/{{ $dist->PDFVIEW }}"   width='1070'  height='600'type='application/pdf' >
		@endif

</td>
  </tr>
</table>

  </td>
  </tr>
</table>



<table width="1348" border="0">
  <tr>
    <td>
    <div id="footer"> Copyright &copy; <?php echo date("Y"); ?> PT. Rapid Plast Indonesia </div>
    </td>
  </tr>
</table>




</body>
</html>
