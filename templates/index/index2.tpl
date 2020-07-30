{include file='header.tpl'}
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
{include file='header_content.tpl'}
{include file='menu.tpl'}
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Dashboard</h1>
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
		 <input type="hidden" name="ac">
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
		</div> 
		
		
		
		<div class="row" style="margin-top:10px">
		<div class="col-md-12">
		<button class="btn btn-primary pull-right" id="userPics_btn_search" type="button" onClick="search()">Search</button>
		</div>
		</div>
		 



		 
		</form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
	  
	
	
	
	
	
	
	
	
	
	
	
	  

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
			<div class="col-xs-5">
			
			
			
			
			
<div class="pad5 scrollView">
<div class="width-1800">			
<div style="clear:both; font-weight:bold; font-size:14px; padding-bottom:4px;">Members go late</div>
<div class="box-body table-responsive no-padding">
<table id="example1" class="table table-bordered table-striped" style="max-width:400px;">
<tr>
<th style="text-align:center">ID</th>
<th style="text-align:center">Name</th>
<th style="text-align:center">Times</th>
</tr>
{foreach from=$golate item=golate_v}
<tr>
<td style="max-width:10px;">{$golate_v.staff_id}</td>
<td>{$golate_v.first_name} {$golate_v.last_name}</td>
<td style="max-width:50px;">{$golate_v.times}</td>
</tr>
{/foreach}
</table>
</div>
</div>
</div>

			
			
			
			
			
			
			
			
			</div>
			<div class="col-xs-5">
			
				<div style="clear:both; font-weight:bold; font-size:14px; padding-bottom:4px; color:#FF0000">Chúc mừng sinh nhật tháng <span style="font-size:18px; font-weight:bold">{php}echo date("Y/m"){/php}</span></div>
				<div>
<table id="example1" class="table table-bordered table-striped" style="max-width:400px;">
<tr>
<th style="text-align:center">ID</th>
<th style="text-align:center">Name</th>
<th style="text-align:center">Times</th>
</tr>
{foreach from=$birthday item=birthday_v}
<tr>
<td style="max-width:10px;">{$birthday_v.id}</td>
<td>{$birthday_v.first_name} {$birthday_v.last_name}</td>
<td style="max-width:50px;">{$birthday_v.birthday}</td>
</tr>
{/foreach}
</table>
				
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
<script type="text/javascript" src="/js/jquery.blockUI.js"></script>
</body>
</html>

	
	
	
	


{literal}
<script language="javascript">



$("#fromdate").datepicker({ dateFormat: "yy/mm/dd"});
$("#fromdate").datepicker("setDate", "{/literal}{if $smarty.get.fromdate ne ""}{$smarty.get.fromdate}{else}{php}echo date("Y/m/01",strtotime("-1 month")){/php}{/if}{literal}");

$("#todate").datepicker({ dateFormat: "yy/mm/dd"});
$("#todate").datepicker("setDate", "{/literal}{if $smarty.get.todate ne ""}{$smarty.get.todate}{else}{php}echo date("Y/m/t",strtotime("-1 month")){/php}{/if}{literal}");



function search()
{
	var frm=document.frm
	frm.ac.value=1;
	frm.submit();
}


</script>
{/literal}