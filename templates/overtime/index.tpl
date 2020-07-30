{include file='header.tpl'}
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
{include file='header_content.tpl'}
{include file='menu.tpl'}
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
	<h1>Overtime request management</h1>
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
	  
	  


	  
<div style="margin-bottom:10px;"><input type="button" onClick="location.href='/overtime/add/'" value="Overtime Request"></div>	  

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
<th>Registration applicant</th>
<th>OT Members</th>
<th>From Time</th>
<th>To Time</th>
<th>Status</th>
<th width="160px">&nbsp;</th>
</tr>
{foreach from=$overtime item=overtime_v}
<tr{if $overtime_v.valid eq 1} bgcolor="#FF0000"{/if}>
<td>{$overtime_v.staff_id}/{$overtime_v.first_name} {$overtime_v.last_name}</td>
<td>
{foreach from=$overtime_v.ot_list item=overtime2_v}
{$overtime2_v.staff_id}/{$overtime2_v.first_name} {$overtime2_v.last_name}<br>
{/foreach}
</td>
<td>{php}echo date("Y/m/d H:i",strtotime($this->_tpl_vars["overtime_v"]["from_time"]));{/php} </td>
<td>{php}echo date("Y/m/d H:i",strtotime($this->_tpl_vars["overtime_v"]["to_time"]));{/php} </td>
<td>
{if $overtime_v.approved eq ''}<span style="color:#FFCC00; font-weight:bold">Waiting for approval</span>{/if}
{if $overtime_v.approved eq 2}<span style="color:#FF0000; font-weight:bold">Not approved</span>{/if}
{if $overtime_v.approved eq 1}<span style="color:#00FF00; font-weight:bold">Approved</span>{/if}
</td>
<td align="center">
<input type="button" value="Edit" onClick="location.href='/overtime/edit/?id={$overtime_v.id}'" />
{if $admin->role eq 2}
<input type="button" value="Approved" onClick="location.href='/overtime/approved/?id={$overtime_v.id}'" />
{/if}
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

	
	
	
	

{literal}
<script language="javascript">
<!--


$("#fromdate").datepicker({ dateFormat: "dd/mm/yy"});
$("#fromdate").datepicker("setDate", "{/literal}{$smarty.get.fromdate}{literal}");

$("#todate").datepicker({ dateFormat: "dd/mm/yy"});
$("#todate").datepicker("setDate", "{/literal}{$smarty.get.todate}{literal}");





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
