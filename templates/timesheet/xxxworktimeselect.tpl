<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Quản lý giờ làm nhân viên</title>
<link rel="stylesheet" href="/css/screen.css" type="text/css" media="screen" title="default" />
<!--[if IE]>
<link rel="stylesheet" media="all" type="text/css" href="/css/pro_dropline_ie.css" />
<![endif]-->

<!--  jquery core -->
<script type="text/javascript" src="/js/jquery/jquery.js"></script>

<!-- Custom jquery scripts -->
<script src="/js/jquery/custom_jquery.js" type="text/javascript"></script>
{literal}
<!-- Tooltips -->
<script src="/js/jquery/jquery.tooltip.js" type="text/javascript"></script>
<script src="/js/c/jquery.dimensions.js" type="text/javascript"></script>

{/literal}

<link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.css"/>
<script type="text/javascript" src="/js/jquery/jquery.datetimepicker.js"></script>
</head>
<body> 
{include file='header.tpl'}

<!-- start content-outer ........................................................................................................................START -->
<div id="content-outer">
<!-- start content -->
<div id="content">

	<!--  start page-heading -->
	<div id="page-heading">
		<h1>Quản lý giờ làm nhân viên</h1>
	</div>
	<!-- end page-heading -->

	<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
	<tr>
		<th rowspan="3" class="sized"><img src="/images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
		<th class="topleft"></th>
		<td id="tbl-border-top">&nbsp;</td>
		<th class="topright"></th>
		<th rowspan="3" class="sized"><img src="/images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
	</tr>
	<tr>
		<td id="tbl-border-left"></td>
		<td>
		<!--  start content-table-inner ...................................................................... START -->
		<div id="content-table-inner">
		
			<!--  start table-content  -->
			<div id="table-content">
			
			
			
			







<div style="margin-top:10px; margin-bottom:10px; width:1000px;">
<form name="frm" method="get">
<input type="hidden" name="print" />
<table width="827" border="1" id="table-01">
    <tr>
      <td width="138">Chi nhánh </td>
      <td width="204">
	  
<select name="branchid" id="branchid">
{foreach from=$config item=config_v}				  
<option value="{$config_v.branchid}"{if $config_v.branchid eq $smarty.get.branchid} selected="selected"{/if}>{$config_v.shop_name}</option>	

{/foreach}
					
				  
				  </select>	  </td>
      <td width="463"><input type="button" value="Chọn" onClick="search()" name="btnSearch"></td>
      </tr>
  </table>


<div>
</form>
















				
				
				
				
				
				
				<!--  end product-table................................... --> 
			</div>
			<!--  end content-table  -->		
		
		</div>
		<!--  end content-table-inner ............................................END  -->
		</td>
		<td id="tbl-border-right"></td>
	</tr>
	<tr>
		<th class="sized bottomleft"></th>
		<td id="tbl-border-bottom">&nbsp;</td>
		<th class="sized bottomright"></th>
	</tr>
	</table>
	<div class="clear">&nbsp;</div>

</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>
<!--  end content-outer........................................................END -->

    
{include file='footer.tpl'} 
</body>
</html>




{literal}
<script language="javascript">

function search()
{
	var frm=document.frm
	frm.action="/report/worktime/";
	frm.submit();
}



</script>
{/literal}