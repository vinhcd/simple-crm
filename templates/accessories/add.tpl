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
     <h1>Add new accessories</h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="/accessories/">accessories list</a></li>
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
                  <label for="inputEmail3" class="col-sm-2 control-label">Name <span style="color:#FF0000">(*)</span></label>
                  <div class="col-sm-6"><input name="name" type="text" id="name" size="30" autocomplete="off" class="form-control"/></div>
                </div>

			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Description</label>
                  <div class="col-sm-6"><textarea name="description" id="description" rows="5" class="form-control"></textarea></div>
                </div>
				
				
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Staff <span style="color:#FF0000">(*)</span></label>
                  <div class="col-sm-6">
					<select class="form-control select2" style="width: 100%;" name="staff_id" id="staff_id">
						<option value=""></option>
						{foreach from=$staff item=store_staff_v}
						<option value="{$store_staff_v.id}">{$store_staff_v.id}/{$store_staff_v.first_name} {$store_staff_v.last_name}</option>
						{/foreach}
					</select>				  
				  </div>
                </div>
				
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Buy date</label>
                  <div class="col-sm-6"><input name="buy_date" type="text" id="buy_date" size="30" autocomplete="off" class="form-control"/></div>
                </div>				
			
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Service tag</label>
                  <div class="col-sm-6"><input name="service_tag" type="text" id="service_tag" size="30" autocomplete="off" class="form-control"/></div>
                </div>	
				
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">MFG YR</label>
                  <div class="col-sm-6"><input name="mfg_yr" type="text" id="mfg_yr" size="30" autocomplete="off" class="form-control"/></div>
                </div>	

			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Express Service Code</label>
                  <div class="col-sm-6"><input name="express_service_code" type="text" id="express_service_code" size="30" autocomplete="off" class="form-control"/></div>
                </div>	
				
				
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Invoice</label>
                  <div class="col-sm-6"><input name="invoice" type="text" id="invoice" size="30" autocomplete="off" class="form-control"/></div>
                </div>	
				
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Provider</label>
                  <div class="col-sm-6"><input name="provider" type="text" id="provider" size="30" autocomplete="off" class="form-control"/></div>
                </div>																		

			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Ram</label>
                  <div class="col-sm-6"><input name="ram" type="text" id="ram" size="30" autocomplete="off" class="form-control"/></div>
                </div>																		

			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Win license</label>
                  <div class="col-sm-6"><input name="win_license" type="text" id="win_license" size="30" autocomplete="off" class="form-control"/></div>
                </div>	

			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Anti virus</label>
                  <div class="col-sm-6"><input name="anti_virus" type="text" id="anti_virus" size="30" autocomplete="off" class="form-control"/></div>
                </div>	

			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Office</label>
                  <div class="col-sm-6"><input name="office" type="text" id="office" size="30" autocomplete="off" class="form-control"/></div>
                </div>	
				
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">OS</label>
                  <div class="col-sm-6">
				  <select name="os" id="os" class="form-control">
				  	<option value=""></option>
					<option value="win">Windows</option>
					<option value="linux">Linux</option>
				  </select>
				  </div>
                </div>								
			</div>
			</div>
		</form>

		<!-- /.box-body -->
		<div class="box-footer">
		<button type="button" class="btn btn-info2" onClick="add();">Save</button>
		
		<button type="button" class="btn btn-default" onClick="location.href='/accessories/';">Close</button>
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


$('#buy_date').datetimepicker({
	lang:'en',
	timepicker:false,
	format:'Y/m/d',
	formatDate:'Y/m/d',
	value:''
});


function add(){	
	var frm=document.frm;

	if (frm.name.value==""){
		alert("[accessories Name] is not empty");
		return false;
	}


	if (frm.staff_id.value==""){
		alert("[Start date] is not empty");
		return false;
	}
	

	frm.ac.value=1;
	frm.submit();
}	


-->
</script>
{/literal}