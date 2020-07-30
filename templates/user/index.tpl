{include file='header.tpl'}
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
{include file='header_content.tpl'}
{include file='menu.tpl'}
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
	<h1>User management</h1>
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
		 <form id="frm" method="get" accept-charset="utf-8" class="form-horizontal" id="searchForm">
			<input type="hidden" id="sort_fileds" name="sort_fileds" value="{$smarty.get.sort_fileds}">
		
	
		<div class="row">
			<div class="col-md-4">
				<label>ID/Name:</label>

					<input type="text" class="form-control" autocomplete="off" name="q" value="{$smarty.get.q}">

			</div>
			
			<div class="col-md-4">
				<label>Đã xóa:</label>

					<input type="checkbox" name="del"{if $smarty.get.del eq 'on'} checked="checked"{/if}>

			</div>
						
		</div>		
		
		<div class="row" style="margin-top:10px">
		<div class="col-md-12">
		<button class="btn btn-primary pull-right" id="userPics_btn_search" type="button" onClick="search_data();">Search</button>
		</div>
		</div>
		 



		 
		</form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
	  
	  


	  
<div style="margin-bottom:10px;"><input type="button" onClick="location.href='/user/add/'" value="Add new"></div>	  

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
<th><b>Id</b> <a href="javascript:void(0);" onClick="search_data('id');"><i id="s_id" class="fa fa-fw fa-sort"></i></a></th>
<th><b>Name</b> <a href="javascript:void(0);" onClick="search_data('last_name');"><i id="s_last_name" class="fa fa-fw fa-sort"></i></a></th>
<th><b>Email</b> <a href="javascript:void(0);" onClick="search_data('email');"><i id="s_email" class="fa fa-fw fa-sort"></i></a></th>
<th>Status</th>
<th width="50px">&nbsp;</th>
</tr>
{foreach from=$staff item=staff_v}
<tr>
<td>{$staff_v.id}</td>
<td>{$staff_v.first_name} {$staff_v.last_name}</td>
<td>{$staff_v.email}</td>
<td>
{if $staff_v.valid eq 1}<span style="color:#FF0000">Deleted</span>{/if}
{if $staff_v.valid eq 0}Working{/if}
</td>


<td align="center"><input type="button" value="Edit" onClick="location.href='/user/edit/?id={$staff_v.id}'" /></td>
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


$("#fromdate").datepicker({ dateFormat: "dd/mm/yy"});
$("#fromdate").datepicker("setDate", "{/literal}{$smarty.get.fromdate}{literal}");

$("#todate").datepicker({ dateFormat: "dd/mm/yy"});
$("#todate").datepicker("setDate", "{/literal}{$smarty.get.todate}{literal}");







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





sort_data();

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
