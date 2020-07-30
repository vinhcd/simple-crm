{include file='header.tpl'}
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
{include file='header_content.tpl'}
{include file='menu.tpl'}
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
	<h1>Leave request</h1>
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
				<label>ID/Name:</label>

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
	  
	  


	  
<div style="margin-bottom:10px;"><input type="button" onClick="location.href='/holiday-request/add/'" value="Request"></div>	  

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
			
			
			
<div class="pad5 scrollView">
<div class="width-1800">			


<div style=" margin-bottom:15px;">
<div class="box-body table-responsive no-padding">
<table id="example1" class="table table-bordered table-striped">
<tr>
<th>Staff</th>
<th>From Time</th>
<th>To Time</th>
<th>Reason</th>
<th width="100px">&nbsp;</th>
</tr>
{foreach from=$overtime item=overtime_v}
<tr{if $overtime_v.valid eq 1} bgcolor="#FF0000"{/if}>
<td>{$overtime_v.staff_id}/{$overtime_v.first_name} {$overtime_v.last_name}</td>
<td>{php}echo date("Y/m/d H:i",strtotime($this->_tpl_vars["overtime_v"]["from_time"]));{/php} </td>
<td>{php}echo date("Y/m/d H:i",strtotime($this->_tpl_vars["overtime_v"]["to_time"]));{/php} </td>
<td>
{$overtime_v.reason}
</td>
<td align="center">
<input type="button" value="Edit" onClick="location.href='/holiday-request/edit/?id={$overtime_v.id}'" />
<input type="button" value="Del" onClick="location.href='/holiday-request/delete/?id={$overtime_v.id}'" />
</td>
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

</body>
</html>

	
	
	
