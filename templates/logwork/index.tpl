{include file='header.tpl'}
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
{include file='header_content.tpl'}
{include file='menu.tpl'}
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
	<h1>Log work management</h1>
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
				<label>Staff:</label>
				<select class="form-control select2" style="width: 100%;" name="staff_id" id="staff_id">
					<option value="">All</option>
					{foreach from=$store_staff item=store_staff_v}
					<option value="{$store_staff_v.id}"{if $smarty.get.staff_id eq $store_staff_v.id} selected="selected"{/if}>{$store_staff_v.id}/{$store_staff_v.fist_name} {$store_staff_v.last_name}</option>
					{/foreach}
				</select>
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
	  
	  


	  
<div style="margin-bottom:10px;"><input type="button" onClick="location.href='/logwork/add/?back={$smarty.server.REQUEST_URI|urlencode}'" value="Today Logwork"></div>	  

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
			
			
			
<div class="pad5 scrollView">
<div class="width-1800">			


<div style=" margin-bottom:15px;">
<div class="box-body table-responsive no-padding">
<table class="table table-bordered table-striped">
<tr>
<th>Id</th>
<th>Name</th>
<th>Date</th>
<th>Status</th>
<th width="50px">&nbsp;</th>
</tr>
{foreach from=$logwork item=logwork_v}
<tr{if $logwork_v.color eq 'red'} style="background-color:#FFFF99"{else} style="background-color:#FFFFFF"{/if}>
<td>{$logwork_v.staff_id}</td>
<td>{$logwork_v.first_name} {$logwork_v.last_name}</td>
<td>{$logwork_v.date}</td>
<td>
{if $logwork_v.logwork eq 1}<span style="color:#33CC00">Logged</span>{/if}
{if $logwork_v.logwork eq 0}Unlogged{/if}
</td>


<td align="center">
{if $admin->staff_id eq $logwork_v.staff_id or $admin->role eq 2}
<input type="button" value="Logwork" onClick="location.href='/logwork/add/?date={$logwork_v.date}&back={$smarty.server.REQUEST_URI|urlencode}'" />{/if}</td>
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

	
	
	
	

{literal}
<script language="javascript">
<!--


$("#fromdate").datepicker({ dateFormat: "yy/mm/dd"});
$("#fromdate").datepicker("setDate", "{/literal}{if $smarty.get.fromdate ne ""}{$smarty.get.fromdate}{else}{php}echo date("Y/m/01"){/php}{/if}{literal}");

$("#todate").datepicker({ dateFormat: "yy/mm/dd"});
$("#todate").datepicker("setDate", "{/literal}{if $smarty.get.todate ne ""}{$smarty.get.todate}{else}{php}echo date("Y/m/t"){/php}{/if}{literal}");





function importdel(id,model){
myRet = confirm("Có chắc chắn xóa không?");
if ( myRet == true ){
	location.href="/xn/importdel/?id="+id+"&model="+model;  
}
}


function levchange(obj){
	
	document.getElementById('level2').innerHTML="";	
	document.getElementById('level3').innerHTML="";
	document.getElementById('genrelist').innerHTML="";	
	document.getElementById('sizelist').innerHTML="";	
	var value = obj.options[obj.selectedIndex].value;
	if (value=="") return false;
	$.ajax({
		type: "POST",
		url: "/common/loadlev22/",
		dataType: "json",
		data: "level1="+value,
		success: function(data){		
		
			
			if (data.genre_total>0){
				$('#level2').append('<option value="">Chọn danh mục</option>');
				for (var i =0; i<data.genre.length; i++) 
				{
					$('#level2').append('<option value="' + data.genre[i].genreid + '">'+data.genre[i].genrename+'</option>');
					
					$('#genrelist').append('<input type="checkbox" name="genreid[]" value="' + data.genre[i].genreid + '" />&nbsp;' +data.genre[i].genrename + '&nbsp;&nbsp;');
				}
			}
			
	
			
			
			if (data.size_total>0){
			
				var sizelist="";
				for (var i =0; i<data.size.length; i++) 
				{
					 sizelist +='<input type="checkbox" name="size[]" value="'+data.size[i].sizeid+'"/>';
					 sizelist += data.size[i].sizename+' ';
					 

				}
				
				document.getElementById('sizelist').innerHTML=sizelist;	
				
				//$('#data_table').append('<tr><th>Tổng</th><td align="right"><span id="sumofqty">0</span></td><td align="right"><span id="sumofimoportmoney">0</span></td><td>&nbsp;</td></tr>');
					
		
		
			}
			
			
			
			
			
			
			
			
		}
	});
}
	
	
function levchange2(obj){
	document.getElementById('level3').innerHTML="";	
	document.getElementById('genrelist').innerHTML="";	
		
	var value = obj.options[obj.selectedIndex].value;
	var level1=document.getElementById('level1').value;
	
	if (value!=""){
		$.ajax({
			type: "POST",
			url: "/common/loadlev3/",
			dataType: "json",
			data: "level2="+value,
			success: function(data){
				if(data == null) return false;
				$('#level3').append('<option value="">Chọn danh mục</option>');
				for (var i =0; i<data.length; i++) 
				{
					$('#level3').append('<option value="' + data[i].genreid + '">'+data[i].genrename+'</option>');
					$('#genrelist').append('<input type="checkbox" name="genreid[]" value="' + data[i].genreid + '" />&nbsp;' + data[i].genrename + '&nbsp;&nbsp;');
					
				}
			}
		});
	}else if(level1!=""){
		
		$.ajax({
			type: "POST",
			url: "/common/loadlev2/",
			dataType: "json",
			data: "level1="+level1,
			success: function(data){			
				if(data == null) return false;
				$('#level2').append('<option value="">Chọn danh mục</option>');
				for (var i =0; i<data.length; i++) 
				{
					$('#level2').append('<option value="' + data[i].genreid + '">'+data[i].genrename+'</option>');
					
					$('#genrelist').append('<input type="checkbox" name="genreid[]" value="' + data[i].genreid + '" />&nbsp;' + data[i].genrename + '&nbsp;&nbsp;');
				}
				
			}
		});
		
	
	}

}



function levchange3(obj){
	document.getElementById('genrelist').innerHTML="";	
	var value = obj.options[obj.selectedIndex].value;
	var level2=document.getElementById('level2').value;
	if (value=="" && level2!=""){
		$.ajax({
			type: "POST",
			url: "/common/loadlev3/",
			dataType: "json",
			data: "level2="+level2,
			success: function(data){
				if(data == null) return false;
				$('#level3').append('<option value="">Chọn danh mục</option>');
				for (var i =0; i<data.length; i++) 
				{
					$('#level3').append('<option value="' + data[i].genreid + '">'+data[i].genrename+'</option>');
					$('#genrelist').append('<input type="checkbox" name="genreid[]" value="' + data[i].genreid + '" />&nbsp;' + data[i].genrename + '&nbsp;&nbsp;');
					
				}
			}
		});
	
	
	}
}

-->
</script>
{/literal}
{php}
function money_round($input_data) {
	if (strpos((string)$input_data,".")){
	$tmp=explode(".",$input_data);
	$input_data=(int)$tmp[0];
	}
	return (int)$input_data;
}

{/php}
