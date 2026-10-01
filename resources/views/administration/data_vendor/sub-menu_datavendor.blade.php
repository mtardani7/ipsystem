<div style="margin-bottom:10px;">
  <span style="float:left;" >
<!--<a href='# ' class='btn btn-default btn-xs' >New data</a>
<a href='# ' class='btn btn-default btn-xs' >New data</a>
<a href='# ' class='btn btn-default btn-xs' >New data</a>-->
<form method='post' action='{{ route('get_xls_datavendor')}}' style='float:left;margin-right:10px;'>
	 {{csrf_field()}}
	<input type='submit' class='btn btn-xs btn-primary' id='go' name='submit' value='Get XLS'/>
</form>
</span>
&nbsp
<span style="float:right;margin-bottom:5px;">
<table width='350'>
    <tr>
    <form action='{{route('vendor_search')}}' method='post'>
    {{csrf_field()}}
    <td class='tableContent'><input type='text' id='nama_perusahaan' name='nama_perusahaan' style='width:97%;'/></td>
    <td colspan='2' class='tableField' align='right'><input class="btn btn-sm btn-primary" type='submit' id='go' name='submit' value='Search' style='width:97%;'/></td>
    </form>
  </tr>
</table>
</span>
</div>
