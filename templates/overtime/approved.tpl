{include file='header.tpl'}
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
{include file='header_content.tpl'}
<script src="/js/function.js"></script>
{include file='menu.tpl'}

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1>Approved overtime request</h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="/overtime/">Overtime list</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	<form method="post" name="frm" class="form-horizontal">
	<input type="hidden" name="ac" />
	<input type="hidden" name="overtime_id" value="{$overtime_one.id}" />
		
          <div class="box box-info with-border">

            <!-- form start -->
              <div class="box-body">
  
 
  
  			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Registration applicant</label>
                  <div class="col-sm-6" style="padding-top:5px;">{$overtime_one.staff_id}/{$overtime_one.first_name} {$overtime_one.last_name}</div>
                </div>  
  
  
  			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">From time</label>
                  <div class="col-sm-6"><input name="from_time" type="text" id="from_time" size="30" autocomplete="off" class="form-control" disabled="disabled"/></div>
                </div>


			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">To time</label>
                  <div class="col-sm-6"><input name="to_time" type="text" id="to_time" size="30" autocomplete="off" class="form-control" disabled="disabled"/></div>
                </div>
				
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">OT reason</label>
                  <div class="col-sm-6"><textarea name="reason" id="reason" style="height:100px;" class="form-control" disabled="disabled">{$overtime_one.reason}</textarea></div>
                </div>
		
		
				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">OT Members</label>
                  <div class="col-sm-8">
				  <div class="col-sm-9" style="padding:0">
					<table id="example1" class="table table-bordered table-striped">
					<tr>
					<th style="width:50px">ID</th>
					<th>Name</th>
					</tr>
					{foreach from=$staff item=staff_v}
					<tr>
					<td>{$staff_v.id}</td>
					<td>{$staff_v.first_name} {$staff_v.last_name}</td>
					</tr>
					{/foreach}
					</table>	
				  </div> 	
				  </div>
                </div>
						
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Comment</label>
                  <div class="col-sm-6"><textarea name="reason2" id="reason2" style="height:100px;" class="form-control" >{$overtime_one.reason2}</textarea></div>
                </div>
		
				
		</form>

		<!-- /.box-body -->
		<div class="box-footer">
		<button type="button" class="btn btn-info2" onClick="update();">Approved</button>
		<button type="button" class="btn btn-info2" onClick="update2();">Not approved</button>
		
		<button type="button" class="btn btn-default" onClick="location.href='/overtime/';">Close</button>
		</div>
		<!-- /.box-footer -->

		
		


    </section>
    <!-- /.content -->
  </div>

{include file='footer.tpl'}
</body>
</html>


{literal}
<script type="text/javascript">
<!--

$.datetimepicker.setLocale('en');
$('#from_time').datetimepicker({
value:'{/literal}{php}echo date("Y/m/d H:i",strtotime($this->_tpl_vars["overtime_one"]["from_time"])){/php}{literal}',
step:10,
format:'Y/m/d H:i'
});

$('#to_time').datetimepicker({
value:'{/literal}{php}echo date("Y/m/d H:i",strtotime($this->_tpl_vars["overtime_one"]["to_time"])){/php}{literal}',
step:10,
format:'Y/m/d H:i'
});



function update(){
	var frm=document.frm;
	frm.ac.value=1;
	frm.submit();
}	

function update2(){
	var frm=document.frm;
	frm.ac.value=2;
	frm.submit();
}	

-->
</script>
{/literal}