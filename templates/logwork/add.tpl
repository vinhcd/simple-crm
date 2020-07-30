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
     <h1>Logwork</h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="/logwork/">User list</a></li>
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
                  <label for="inputEmail3" class="col-sm-1 control-label">Date</label>
                  <div class="col-sm-6"><input name="logwork_date" type="text" id="logwork_date" style="width:100px" autocomplete="off" class="form-control" onChange="load_project()"/></div>
                </div>
				
			
							
				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-1 control-label">Project</label>
                  <div class="col-sm-8">
					<table id="data_table" class="table table-bordered table-striped"></table>
				  </div>
                </div>			



		
		
				
		</form>

		<!-- /.box-body -->
		<div class="box-footer">
		<button type="button" class="btn btn-info2" onClick="add();">Save</button>
		
		<button type="button" class="btn btn-default" onClick="location.href='{if $smarty.get.back ne ""}{$smarty.get.back|urldecode}{else}/logwork/{/if}';">Close</button>
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

$("#logwork_date").datepicker({ dateFormat: "yy/mm/dd"});
$("#logwork_date").datepicker("setDate", "{/literal}{if $smarty.get.date ne ""}{$smarty.get.date}{else}{php}echo date("Y/m/d"){/php}{/if}{literal}");
	
function add(){
	var alphaExp1 = /^[a-z0-9]+$/;
	
	var frm=document.frm;

	if (frm.logwork_date.value==""){
		alert("[Date] is not empty");
		return false;
	}

	frm.ac.value=1;
	frm.submit();
}	


load_project();

function load_project(){
	$("#data_table").empty();
	
	$.ajax({
		data: {
			'logwork_date': document.getElementById("logwork_date").value
		},		
		type: 'POST',
		url: "/logwork/loadproject/",
		cache: false,
		async: false,
		dataType : "json",
		success: function(response){	
			
		
			$('#data_table').append('<tr><th>Name</th><th style="width:100px">Working hours</th><th>Comment</th></tr>');
	
			if (response.product!=undefined)
			for(var i=0;i<response.product.length;i++)
			{
				time='';
				if (response.product[i].time!=null)	 time=response.product[i].time;

				comment='';
				if (response.product[i].comment!=null) comment=response.product[i].comment;
								
				$('#data_table').append('<tr><td>' + response.product[i].id+' '+response.product[i].name+ '</td><td><input class="form-control" autocomplete="off" type="text" name="hour_'+response.product[i].id+ '" value="'+time+'"/></td><td><input class="form-control" type="text" autocomplete="off" name="comment_'+response.product[i].id+ '" value="'+comment+'"/></td></tr>');
			
	
			}
			
		
		
		}
	});	
	
	
}

-->
</script>
{/literal}