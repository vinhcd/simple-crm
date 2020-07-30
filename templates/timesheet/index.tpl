{include file='header.tpl'}
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
{include file='header_content.tpl'}
{include file='menu.tpl'}
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Time sheet managment</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
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
		 <form method="get" accept-charset="utf-8" class="form-horizontal" id="searchForm" name="frm">
		 <input type="hidden" name="history" value="{$smarty.get.history}">
		 <input type="hidden" name="ac" />
		 
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
		 
		{if $admin->role eq 2}	
		<div class="col-md-6">
			<label>Staff:</label>
			<select class="form-control select2" style="width: 100%;" name="staff_id" id="staff_id">
				<option value="">All</option>
				{foreach from=$store_staff item=store_staff_v}
				<option value="{$store_staff_v.id}"{if $smarty.get.staff_id eq $store_staff_v.id} selected="selected"{/if}>{$store_staff_v.id}/{$store_staff_v.first_name} {$store_staff_v.last_name}</option>
				{/foreach}
			</select>
			</div>
		 </div>
		 {/if}
		
		
		<div class="row" style="margin-top:10px">
		<div class="col-md-12">
		<button class="btn btn-primary pull-right" id="userPics_btn_search" type="button" onClick="export_exel(3);" style="margin-left:10px">Excel export</button>
		<button class="btn btn-primary pull-right" id="userPics_btn_search" type="button" onClick="search()">Search</button>
		</div>
		</div>
		 



		 
		</form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
	  
	
	
	
	
	
	
	
	
	
	
	
	  {if $admin->role eq 2}	
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Upload time sheet</h3>

        </div>
        <!-- /.box-header -->
        <div class="box-body">

			<form name="frmupload" action="/timesheet/upload/" method="post" enctype="multipart/form-data">
			<div class="col-xs-2">
			Select file：
			</div>
			
			 <div class="col-xs-3">
			  <input type="file" name="upfile" size="30" />&nbsp;
			 </div>
			 
			 <div class="col-xs-3">
			 <input type="button" value="Upload" onClick="uploadstart();" />
			 </div>
			</form>		
		 
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->	
	{/if}
	
	
	
	


      <div class="box box-default">
        <!-- /.box-header -->
        <div class="box-body">
<div>
<input type="hidden" id="staff_id2" value="{$ngayphep_one.staff_id}">
<input type="hidden" id="month_year" value="{$ngayphep_one.month_year}">
<table class="table table-bordered" id="example1" style="max-width:650px">
<tr>
<td nowrap="nowrap" width="200px">Số phép đầu kỳ:</td>
<td style="width:100px">{$ngayphep_one.dauky}</td>
<td nowrap="nowrap" width="150px">Số giờ nghỉ trừ lương:</td>
<td width="331">{$ngayphep_one.sogiotruluong}</td>
</tr>
<tr>
<td nowrap="nowrap">Số phép tăng trong tháng:</td>
<td>{$ngayphep_one.tangtrogthang}</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td>Số phép sử dụng:</td>
<td>{$ngayphep_one.sophepsudung}</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td>Điều chỉnh phép:</td>
<td>
{if $admin->role eq 2}<input type="text" name="dieuchinhphep" id="dieuchinhphep" value="{$ngayphep_one.dieuchinhphep}" style=" width:50px;">{else}{$ngayphep_one.dieuchinhphep}{/if}
</td>
<td>Comment:</td>
<td>{if $admin->role eq 2}<input type="text" name="comment" id="comment" value="{$ngayphep_one.comment}" style=" width:200px;">{else}{$ngayphep_one.comment}{/if}</td>
</tr>
<tr>
<td>Số phép còn:</td>
<td>{$ngayphep_one.sophepconlai}</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</table>		
</div>
{if $admin->role eq 2}
<div><input type="button" value="Update Annual Leave" onClick="updateAnnual()"/></div>		 
{/if}
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




<div style="clear:both; font-weight:bold; font-size:14px; padding-bottom:4px;">Working time detail</div>
{if $admin->role eq 2}
<div style="margin:5px 0px"><input type="button" value="Add working time" onClick="location.href='/timesheet/add/?back={$smarty.server.REQUEST_URI|urlencode}'"/></div>
{/if}
<div class="box-body table-responsive no-padding">
<table id="example1" class="table table-bordered table-striped">
<tr>
<th>ID</th>
<th>First Name</th>
<th>Last Name</th>
<th>Date</th>
<th>Check in</th>
<th>Check out</th>
<th>WH</th>
<th>MH</th>
<th>OT1</th>
<th>OT2</th>
<th>OT3</th>
<th>OT4</th>
<th>Comment</th>
<th width="180px" align="center">&nbsp; </th>
</tr>
{foreach from=$woking_time item=woking_time_v}
<tr{if $woking_time_v.color eq 'red'} style="background-color:#FFFF99"{elseif $woking_time_v.color eq 'holiday'} style="background-color:red"{else} style="background-color:#FFFFFF"{/if}>
<td>{$woking_time_v.staff_id}</td>
<td>{$woking_time_v.first_name}</td>
<td>{$woking_time_v.last_name}</td>
<td>{$woking_time_v.date}</td>
<td>{$woking_time_v.check_in}</td>
<td>{$woking_time_v.check_out}</td>
<td style="text-align:right">{if $woking_time_v.work_hours>0}{$woking_time_v.work_hours}{/if}</td>
<td style="text-align:right">{if $woking_time_v.mh>0}{$woking_time_v.mh}{/if}</td>
<td style="text-align:right">{if $woking_time_v.ot1>0}{$woking_time_v.ot1}{/if}</td>
<td style="text-align:right">{if $woking_time_v.ot2>0}{$woking_time_v.ot2}{/if}</td>
<td style="text-align:right">{if $woking_time_v.ot3>0}{$woking_time_v.ot3}{/if}</td>
<td style="text-align:right">{if $woking_time_v.ot4>0}{$woking_time_v.ot4}{/if}</td>
<td><span id="comment_value_{$woking_time_v.date}">{$woking_time_v.comment|nl2br}</span></td>


<td align="center">
{if $admin->staff_id eq $woking_time_v.staff_id or $admin->role eq 2}
<input type="button" data-id="{$woking_time_v.date}==={$woking_time_v.check_in}==={$woking_time_v.check_out}==={$woking_time_v.id}==={$woking_time_v.staff_id}" value="Comment" data-toggle="modal" data-target="#modal-comment" class="data_comment"/>
{/if}
{if $admin->role eq 2 && $woking_time_v.time_sheet_id ne ""}
<input type="button" value="Edit" onClick="location.href='/timesheet/edit/?id={$woking_time_v.time_sheet_id}&back={$smarty.server.REQUEST_URI|urlencode}'"/><input type="button" value="Del" onClick="del_wt('{$woking_time_v.time_sheet_id}');"/>
{/if}
</td>
</tr>
{/foreach}
<tr style="background:#99CC00; font-weight:bold; color:#FFFFFF;">
<td colspan="6" align="center">Total hours worked</td>
<td style="text-align:right">{$total_wh}</td>
<td style="text-align:right">{$total_mh}</td>
<td style="text-align:right">{$ot1}</td>
<td style="text-align:right">{$ot2}</td>
<td style="text-align:right">{$ot3}</td>
<td style="text-align:right">{$ot4}</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</table>
</div>
</div>


<div class="row" style="margin-top:-10px">
{*
    <div class="col-lg-6">
        <ul class="pagination ">
            <li>1 / {$allpagenum} Trang</li>
        </ul>
    </div>
*}
    <div class="col-lg-12">
        <div class="paginator" value="1">
            <ul class="pagination pull-right">
			
                <li class="prev{if $p eq 1} disabled{/if}"><a href="?p={$p-1}{$url}"><</a></li>
				
				{section name=foo start=$start loop=$finish+1 step=1}	

				{if $smarty.section.foo.index eq $p}
				<li class="active"><a href="#">{$smarty.section.foo.index}</a></li>
				{else}
				<li><a title="{$smarty.section.foo.index}" href="?p={$smarty.section.foo.index}{$url}">{$smarty.section.foo.index}</a></li>
				{/if}

				{/section}
				<li class="next{if $p eq $allpagenum} disabled{/if}"><a rel="next" href="?p={$p+1}{$url}">></a></li>
				
            </ul>
        </div>

    </div>
</div>



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
<script type="text/javascript" src="/js/jquery.blockUI.js"></script>



<div class="modal fade" id="modal-comment">
  <div class="modal-dialog" >
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">Comment</h4>
	  </div>
	  <div class="modal-body">
	   <div class="col-xs-12">
				 <div class="row">
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Date</label>
                  <div class="col-sm-6">
				  
				  <div><span id="comment_date"></span></div>
				  
				  </div>
                </div>
				</div>
				
				 <div class="row" style="margin-top:5px;">
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Check In</label>
                  <div class="col-sm-6"><span id="comment_checkin"></span></div>
                </div>
				</div>


				 <div class="row" style="margin-top:5px;">
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Check Out</label>
                  <div class="col-sm-6"><span id="comment_checkout"></span></div>
                </div>
				</div>


				 <div class="row" style="margin-top:5px;">
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Comment</label>
                  <div class="col-sm-6"><textarea id="comment_content" rows="2" class="form-control"></textarea></div>
                </div>
				</div>
				
	   </div>

		<div class="clearfix"></div>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary" onClick="save_comment();">Save</button>
	  </div>
	</div>
	<!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal --> 


</body>
</html>

	
	
	
	


{literal}
<script language="javascript">

$(document).on("click", ".data_comment", function () {
	var my_id_value = $(this).data('id');
	var res = my_id_value.split("===");
	document.getElementById("comment_date").innerHTML = res[0];
	document.getElementById("comment_checkin").innerHTML = res[1];
	document.getElementById("comment_checkout").innerHTML = res[2];
	document.getElementById("staff_id2").value = res[4];
	//console.log("111="+document.getElementById("staff_id2").innerHTML);
	
	//get comment
	$.ajax({
		data: {
			'date': document.getElementById("comment_date").innerHTML
		},		
		type: 'POST',
		url: "/timesheet/get-comment/",
		async: false,
		cache: false,
		dataType : "json",
		success: function(response){	
			if (response.comment!=undefined) document.getElementById("comment_content").value=response.comment;
		}
	});	
	
});



$(function () {
 //Initialize Select2 Elements
$('.select2').select2();
})
	
function uploadstart(){

	$.blockUI({
      message: '<h1>Đang thực hiện...</h1>',
      css: {
        border: 'none',
        padding: '10px',
        backgroundColor: '#FFFFFF',
        color: '#FF0000'
      },
      overlayCSS: {
        backgroundColor: '#000',
        opacity: 0.6
      }
    });
	
	
	var frm=document.frmupload;
	frm.submit();
}



$("#fromdate").datepicker({ dateFormat: "yy/mm/dd"});
$("#fromdate").datepicker("setDate", "{/literal}{if $smarty.get.fromdate ne ""}{$smarty.get.fromdate}{else}{php}echo date("Y/m/01",strtotime("-1 month")){/php}{/if}{literal}");

$("#todate").datepicker({ dateFormat: "yy/mm/dd"});
$("#todate").datepicker("setDate", "{/literal}{if $smarty.get.todate ne ""}{$smarty.get.todate}{else}{php}echo date("Y/m/t",strtotime("-1 month")){/php}{/if}{literal}");




function del_wt(id){
	myRet = confirm("Are you sure?");
	if ( myRet == true ){
		location.href="/timesheet/delete/?id="+id+"&back={/literal}{$smarty.server.REQUEST_URI|urlencode}{literal}";  
	}
}


function search()
{
	var frm=document.frm
	frm.ac.value=1;
	frm.submit();
}


function export_exel(ac){
	var frm=document.frm;
	if (frm.fromdate.value=="" || frm.todate.value==""){
		alert("[Date] is not empty");
		return false;
	}
	frm.ac.value=ac;
	frm.submit();
}



function save_comment(){

	//if (document.getElementById("comment_content").value==""){
	///	alert("[Comment] is not empty");
	//	return false;
	//}	


	if (document.getElementById("comment_content").value.length>300){
		alert("Comment no more than 300 characters");
		return false;
	}	
	
	$.ajax({
		data: {
			'staff_id': document.getElementById("staff_id2").value,
			'date': document.getElementById("comment_date").innerHTML,
			'comment': document.getElementById("comment_content").value,
			'fromdate': document.getElementById("fromdate").value,
			'todate': document.getElementById("todate").value
		},		
		type: 'POST',
		url: "/timesheet/comment/",
		async: false,
		cache: false,
		success: function(response){	
			
			if (response=='ok'){
				alert("Thank you!");
				document.getElementById("comment_value_"+document.getElementById("comment_date").innerHTML).innerHTML = document.getElementById("comment_content").value.replace("\n", '<br />');
				$('#modal-comment').modal('hide');
			}else{
				alert("Error");
				return false;
			}

		}
	});	
}
{/literal}
{if $admin->role eq 2}
{literal}
function updateAnnual(){

	$.blockUI({
      message: '<h1>Đang thực hiện...</h1>',
      css: {
        border: 'none',
        padding: '10px',
        backgroundColor: '#FFFFFF',
        color: '#FF0000'
      },
      overlayCSS: {
        backgroundColor: '#000',
        opacity: 0.6
      }
    });


	$.ajax({
		data: {
			'staff_id': document.getElementById("staff_id2").value,
			'month_year': document.getElementById("month_year").value,
			'dieuchinhphep': document.getElementById("dieuchinhphep").value,
			'comment': document.getElementById("comment").value                 
		},
		type: 'POST',
		url: "/timesheet/update-annual/",
		cache: false,
		success: function(response){
			$.unblockUI();
			//alert("Update successfully!");
			if (response=="ok")
				location.href="{/literal}{$smarty.server.REQUEST_URI}{literal}";			
			else
				alert("Error");
		}
		
	});	
	
}
{/literal}
{/if}
{literal}

</script>
{/literal}