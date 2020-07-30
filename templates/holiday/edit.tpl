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
     <h1>Edit holiday</h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="/holiday/">Holiday list</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	<form method="post" name="frm" class="form-horizontal">
	<input type="hidden" name="ac" />
		<input type="hidden" name="id" value="{$national_days_one.id}" />
          <div class="box box-info with-border">

            <!-- form start -->
              <div class="box-body">

			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-1 control-label">Date</label>
                  <div class="col-sm-6"><input name="holiday_date" type="text" id="holiday_date" size="30" autocomplete="off" class="form-control"/></div>
                </div>



			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-1 control-label">Comment</label>
                  <div class="col-sm-6"><input name="comment" type="text" id="comment" size="30" autocomplete="off" class="form-control" value="{$national_days_one.comment}"/></div>
                </div>

				
		</form>

		<!-- /.box-body -->
		<div class="box-footer">
		<button type="button" class="btn btn-info2" onClick="edit();">Save</button>
		
		<button type="button" class="btn btn-default" onClick="location.href='/holiday/';">Close</button>
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



$("#holiday_date").datepicker({ dateFormat: "yy/mm/dd"});
$("#holiday_date").datepicker("setDate", "{/literal}{php}echo date("Y/m/d",strtotime($this->_tpl_vars["national_days_one"]["national_day"]));{/php}{literal}");


function edit(){

	var frm=document.frm;
	if (frm.holiday_date.value==""){
		alert("[Date] is not empty");
		return false;
	}	
	
	
	var ex="";
	$.ajax({
		data: {
			'id': frm.id.value,
			'date': frm.holiday_date.value           
		},
		type: 'POST',
		url: "/holiday/checkdate2/",
		async: false,
		cache: false,
	success: function(response){
		ex=response;
	}
	});
		

	if (ex=="1"){
		alert("["+frm.holiday_date.value+"] already exists");
		return false;
	}	
	
		
	frm.ac.value=1;
	frm.submit();
}	

-->
</script>
{/literal}