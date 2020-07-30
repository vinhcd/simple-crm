{include file='header.tpl'}
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
{include file='header_content.tpl'}
{include file='menu.tpl'}
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
	<h1>Project management</h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
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
		 <form method="get" accept-charset="utf-8" class="form-horizontal" id="searchForm">

		 
		
	
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
		 
		 		
			<div class="col-md-6">
				<label>Project:</label>

					<input type="text" class="form-control" name="q" value="{$smarty.get.q}">

			</div>
		</div>		
		
		<div class="row" style="margin-top:10px">
		<div class="col-md-12">
		<button class="btn btn-primary pull-right" id="userPics_btn_search" type="submit">Search</button>
		</div>
		</div>
		 



		 
		</form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
	  
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Summary(<span id="fd"></span>)</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
		 
		 
	<table id="example1" class="table table-bordered table-striped" style=" max-width:300px">
	<tr>
	<th style="text-align:center">Member</th>
	<th style="text-align:center">Using Effort</th>
	<th style="text-align:center">Free Effort</th>
	</tr>
	{foreach from=$project_sumary item=project_sumary_v}
	<tr>
	<td>{$project_sumary_v.staff_id}/{$project_sumary_v.first_name} {$project_sumary_v.last_name}</td>
	<td style="text-align:right;">{$project_sumary_v.use}%</td>
	<td style="text-align:right;">{$project_sumary_v.free}%</td>
	</tr>
	{/foreach}
	
	</table>	


		 
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
	
	
	
	
	
	
	
	
	
	
	
	
	  



      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
			
			
			
<div class="pad5 scrollView">
<div class="width-1800">	

{foreach from=$project item=project_v}
	<div style="float:left">
		<div style="font-weight:bold;">Project: {$project_v.name}({php}echo date("Y/m",$this->_tpl_vars["project_v"]["start_date"]);{/php} ～　{php}echo date("Y/m",$this->_tpl_vars["project_v"]["finish_date"]);{/php})</div>
	</div>

	<div style="float:right">
		<input class="btn btn-primary" type="button" onClick="location.href='/project-effort/add/?id={$project_v.id}'" value="Add new member">
	</div>
	<div style="clear:both"></div>	
	
	
	<div style=" margin-bottom:15px;">
	<div class="box-body table-responsive no-padding">
	{if $project_v.detail ne ""}
		<table id="example1" class="table table-bordered table-striped">
		<tr>
		<th>Member</th>
		<th>Postion</th>
		<th>From Date</th>
		<th>To Date</th>
		<th>Effort</th>
		<th></th>
		</tr>
		{foreach from=$project_v.detail item=project_v2}
		<tr>
		<td>{$project_v2.staff_id}/{$project_v2.first_name} {$project_v2.last_name}</td>
		<td>{$project_v2.position_name}</td>
		<td>{php}echo date("Y/m/d",strtotime($this->_tpl_vars["project_v2"]["from_date"]));{/php} </td>
		<td>{php}echo date("Y/m/d",strtotime($this->_tpl_vars["project_v2"]["to_date"]));{/php} </td>
		<td>{$project_v2.effort}%</td>
		<td width="130px" align="center"><input type="button" value="Edit" onClick="location.href='/project-effort/edit/?id={$project_v2.id}'">&nbsp;<input type="button" value="Delete" onClick="delete_effort({$project_v2.id})"></td>
		</tr>
		{/foreach}
		
		</table>	
	{else}
		<div style="text-align:center; color:#FF0000">No data</div>
	{/if}

		
		
		
	
	</div>
	</div>
{/foreach}






			
			
			
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

</body>
</html>

	
	
	
	

{literal}
<script language="javascript">
<!--

$("#fromdate").datepicker({ dateFormat: "yy/mm/dd"});
$("#fromdate").datepicker("setDate", "{/literal}{if $smarty.get.fromdate ne ""}{$smarty.get.fromdate}{else}{php}echo date("Y/m/01"){/php}{/if}{literal}");

$("#todate").datepicker({ dateFormat: "yy/mm/dd"});
$("#todate").datepicker("setDate", "{/literal}{if $smarty.get.todate ne ""}{$smarty.get.todate}{else}{php}echo date("Y/m/t"){/php}{/if}{literal}");

document.getElementById("fd").innerHTML = document.getElementById("fromdate").value+" ~ "+document.getElementById("todate").value;

function delete_effort(id){
	myRet = confirm("Are you sure?");
	if ( myRet == true ){
		location.href="/project-effort/delete/?id="+id;
	}
}


-->
</script>
{/literal}
