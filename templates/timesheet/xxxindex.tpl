{include file='header.tpl'}
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
{include file='header_content.tpl'}
{include file='menu.tpl'}
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Time sheet managment</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    







 <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Search</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
		 <form method="get" accept-charset="utf-8" class="form-horizontal" id="searchForm" name="frm">
		 <input type="hidden" name="history" value="{$smarty.get.history}">
		 <input type="hidden" name="ac" />
		 
		 <div class="row">
		 <div class="col-md-6">
		 <label>Date:</label>
		 <div class="row">
			<div class="col-md-5">
			<input type="text" autocomplete="off" class="form-control" id="fromdate" name="fromdate">
			</div>
			<div class="col-md-2" style="text-align:center">
			~
			</div>
			 <div class="col-md-5">	
				<input type="text" autocomplete="off" class="form-control" id="todate" name="todate">
	
			 </div>		 
		 </div>
		 </div>
		 
		{if $admin->role eq 2}	
		<div class="col-md-6">
			<label>Staff:</label>
			<select class="form-control select2" style="width: 100%;" name="staff_id" id="staff_id">
				<option value="">All</option>
				{foreach from=$store_staff item=store_staff_v}
				<option value="{$store_staff_v.id}"{if $smarty.get.staff_id eq $store_staff_v.id} selected="selected"{/if}>{$store_staff_v.fist_name} {$store_staff_v.last_name}</option>
				{/foreach}
			</select>
			</div>
		 </div>
		 {/if}
		
		
		<div class="row" style="margin-top:10px">
		<div class="col-md-12">
		<button class="btn btn-primary pull-right" id="userPics_btn_search" type="button" onClick="export_exel(3);" style="margin-left:10px">Excel export</button>
		<button class="btn btn-primary pull-right" id="userPics_btn_search" type="button" onClick="search()">Search</button>
		</div>
		</div>
		 



		 
		</form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
	  
	
	
	
	
	
	
	
	
	
	
	
	  {if $admin->role eq 2}	
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Upload time sheet</h3>

        </div>
        <!-- /.box-header -->
        <div class="box-body">

			<form name="frmupload" action="/timesheet/upload/" method="post" enctype="multipart/form-data">
			<div class="col-xs-2">
			Select file：
			</div>
			
			 <div class="col-xs-3">
			  <input type="file" name="upfile" size="30" />&nbsp;
			 </div>
			 
			 <div class="col-xs-3">
			 <input type="button" value="Upload" onClick="uploadstart();" />
			 </div>
			</form>		
		 
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->	
	{/if}
	
	
	
	
	

	  

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
			
			
			
<div class="pad5 scrollView">
<div class="width-1800">			




<div style="clear:both; font-weight:bold; font-size:14px; padding-bottom:4px;">Working time detail</div>
{if $admin->role eq 2}
<div style="margin:5px 0px"><input type="button" value="Add working time" onClick="location.href='/timesheet/add/?back={$smarty.server.REQUEST_URI|urlencode}'"/></div>
{/if}
<div class="box-body table-responsive no-padding">
<table id="example1" class="table table-bordered table-striped">
<tr>
<th>ID</th>
<th>First Name</th>
<th>Last Name</th>
<th>Date</th>
<th>Check in</th>
<th>Check out</th>
<th>WH</th>


<th>OT1</th>
<th>OT2</th>
<th>OT3</th>
<th>OT4</th>
{if $admin->role eq 2}
<th width="100px" align="center">&nbsp; </th>
{/if}
</tr>
{foreach from=$woking_time item=woking_time_v}
<tr>
<td>{$woking_time_v.staff_id}</td>
<td>{$woking_time_v.first_name}</td>
<td>{$woking_time_v.last_name}</td>
<td>{php} echo date("d/m/Y",strtotime($this->_tpl_vars["woking_time_v"]["check_in"]));{/php}</td>
<td>{php} echo date("H:i",strtotime($this->_tpl_vars["woking_time_v"]["check_in"]));{/php}</td>
<td>{php} echo date("H:i",strtotime($this->_tpl_vars["woking_time_v"]["check_out"]));{/php}</td>
<td>{if $woking_time_v.work_hours>0}{$woking_time_v.work_hours}{/if}</td>
<td>{if $woking_time_v.ot1>0}{$woking_time_v.ot1}{/if}</td>
<td>{if $woking_time_v.ot2>0}{$woking_time_v.ot2}{/if}</td>
<td>{if $woking_time_v.ot3>0}{$woking_time_v.ot3}{/if}</td>
<td>{if $woking_time_v.ot4>0}{$woking_time_v.ot4}{/if}</td>
{if $admin->role eq 2}
<td align="center"><input type="button" value="Edit" onClick="location.href='/timesheet/edit/?id={$woking_time_v.id}&back={$smarty.server.REQUEST_URI|urlencode}'"/><input type="button" value="Del" onClick="del_wt('{$woking_time_v.id}');"/></td>
{/if}
</tr>
{/foreach}
</table>
</div>
</div>


<div class="row" style="margin-top:-10px">
{*
    <div class="col-lg-6">
        <ul class="pagination ">
            <li>1 / {$allpagenum} Trang</li>
        </ul>
    </div>
*}
    <div class="col-lg-12">
        <div class="paginator" value="1">
            <ul class="pagination pull-right">
			
                <li class="prev{if $p eq 1} disabled{/if}"><a href="?p={$p-1}{$url}"><</a></li>
				
				{section name=foo start=$start loop=$finish+1 step=1}	

				{if $smarty.section.foo.index eq $p}
				<li class="active"><a href="#">{$smarty.section.foo.index}</a></li>
				{else}
				<li><a title="{$smarty.section.foo.index}" href="?p={$smarty.section.foo.index}{$url}">{$smarty.section.foo.index}</a></li>
				{/if}

				{/section}
				<li class="next{if $p eq $allpagenum} disabled{/if}"><a rel="next" href="?p={$p+1}{$url}">></a></li>
				
            </ul>
        </div>

    </div>
</div>



</div>
</div>










			
			
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->	 



    </section>
    <!-- /.content -->
  </div>

{include file='footer.tpl'}
<!-- Select2 -->
<script src="/AdminLTE-2.4.0-rc/bower_components/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript" src="http://giabao.smartpos.com.vn/js/jquery.blockUI.js"></script>
</body>
</html>

	
	
	
	


{literal}
<script language="javascript">

$(function () {
 //Initialize Select2 Elements
$('.select2').select2();
})
	
function uploadstart(){

	$.blockUI({
      message: '<h1>Đang thực hiện...</h1>',
      css: {
        border: 'none',
        padding: '10px',
        backgroundColor: '#FFFFFF',
        color: '#FF0000'
      },
      overlayCSS: {
        backgroundColor: '#000',
        opacity: 0.6
      }
    });
	
	
	var frm=document.frmupload;
	frm.submit();
}



$("#fromdate").datepicker({ dateFormat: "yy/mm/dd"});
$("#fromdate").datepicker("setDate", "{/literal}{if $smarty.get.fromdate ne ""}{$smarty.get.fromdate}{else}{php}echo date("Y/m/01",strtotime("-1 month")){/php}{/if}{literal}");

$("#todate").datepicker({ dateFormat: "yy/mm/dd"});
$("#todate").datepicker("setDate", "{/literal}{if $smarty.get.todate ne ""}{$smarty.get.todate}{else}{php}echo date("Y/m/t",strtotime("-1 month")){/php}{/if}{literal}");




function del_wt(id){
	myRet = confirm("Are you sure?");
	if ( myRet == true ){
		location.href="/timesheet/delete/?id="+id+"&back={/literal}{$smarty.server.REQUEST_URI|urlencode}{literal}";  
	}
}


function search()
{
	var frm=document.frm
	frm.ac.value=1;
	frm.submit();
}


function export_exel(ac){
	var frm=document.frm;
	if (frm.fromdate.value=="" || frm.todate.value==""){
		alert("[Date] is not empty");
		return false;
	}
	frm.ac.value=ac;
	frm.submit();
}



</script>
{/literal}