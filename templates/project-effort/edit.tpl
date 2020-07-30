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
     <h1>Edit project's member</h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="/project-effort//">Project effort</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	<form method="post" name="frm" class="form-horizontal">
	<input type="hidden" name="ac" />
		
          <div class="box box-info with-border">

            <!-- form start -->
              <div class="box-body">
               		   
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Project name</label>
                  <div class="col-sm-6" style="margin-top:5px">{$project_one.name}</div>
                </div>
				
				
				
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Member</label>
                  <div class="col-sm-6">
				  {$project_detail_one.staff_id}
					<select class="form-control select2" style="width: 100%;" name="staff_id" id="staff_id">
					<option value=""></option>
					{foreach from=$staff item=staff_v}
					<option value="{$staff_v.id}"{if $staff_v.id eq $project_detail_one.staff_id} selected="selected"{/if}>{$staff_v.id}/{$staff_v.first_name} {$staff_v.last_name}</option>
					{/foreach}
					</select>				  
				  </div>
                </div>
			
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Position</label>
                  <div class="col-sm-6">
					<select class="form-control select2" style="width: 100%;" name="position_id" id="position_id">
					<option value=""></option>
					{foreach from=$position item=position_v}
					<option value="{$position_v.id}"{if $position_v.id eq $project_detail_one.position_id} selected="selected"{/if}>{$position_v.name}</option>
					{/foreach}
					</select>				  
				  </div>
                </div>			

			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">From Date</label>
                  <div class="col-sm-6"><input autocomplete="off" name="from_date" type="text" id="from_date" class="form-control" value="{php}echo date("Y/m/d",strtotime($this->_tpl_vars["project_detail_one"]["from_date"])){/php}"></div>
                </div>
				
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">To Date</label>
                  <div class="col-sm-6"><input autocomplete="off" name="to_date" type="text" id="to_date" class="form-control" value="{php}echo date("Y/m/d",strtotime($this->_tpl_vars["project_detail_one"]["to_date"])){/php}"/></div>
				</div>
	
	
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Effort</label>
                  <div class="col-sm-6"><input autocomplete="off" name="effort" type="text" id="effort" class="form-control" value="{$project_detail_one.effort}"/></div>
				<div class="col-sm-1" style="padding:0; margin-top:5px;">%</div>
		
                </div>
				
				
		</form>

		<!-- /.box-body -->
		<div class="box-footer">
		<button type="button" class="btn btn-info2" onClick="add();">Save</button>
		
		<button type="button" class="btn btn-default" onClick="location.href='/project-effort/';">Close</button>
		</div>
		<!-- /.box-footer -->

		
		


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
<script type="text/javascript">
<!--

$(function () {
 //Initialize Select2 Elements
$('.select2').select2();
})


$("#from_date").datepicker({ dateFormat: "yy/mm/dd"});
$("#to_date").datepicker({ dateFormat: "yy/mm/dd"});

function add(){	
	var frm=document.frm;

	if (frm.staff_id.value==""){
		alert("[Member] is not empty");
		return false;
	}

	if (frm.position_id.value==""){
		alert("[Position] is not empty");
		return false;
	}

	if (frm.from_date.value==""){
		alert("[From Date] is not empty");
		return false;
	}

	if (frm.to_date.value==""){
		alert("[To Date] is not empty");
		return false;
	}

	if (frm.effort.value==""){
		alert("[Effort] is not empty");
		return false;
	}
	
	frm.ac.value=1;
	frm.submit();
}	


-->
</script>
{/literal}