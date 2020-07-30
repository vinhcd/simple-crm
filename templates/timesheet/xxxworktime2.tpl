{include file='header.tpl'}
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
{include file='header_content.tpl'}
{include file='menu.tpl'}
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Quản lý giờ làm nhân viên</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

 <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Tìm kiếm</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
		 <form method="get" accept-charset="utf-8" class="form-horizontal" id="searchForm" name="frm">
		 <input type="hidden" name="history" value="{$smarty.get.history}">
		 <input type="hidden" name="print" />
		 
		 <div class="row">
		 <div class="col-md-6">
		 <label>Ngày:</label>
		 <div class="row">
			<div class="col-md-5">
			<input type="text" class="form-control" id="fromdate" name="fromdate">
			</div>
			<div class="col-md-2" style="text-align:center">
			~
			</div>
			 <div class="col-md-5">	
				<input type="text" class="form-control" id="todate" name="todate">
	
			 </div>		 
		 </div>
		 </div>
		 

			<div class="col-md-6">
			<label>Nhân viên:</label>
			<select class="form-control select2" style="width: 100%;" name="staffid" id="staffid">
				<option value="">Toàn bộ</option>
				{foreach from=$store_staff item=store_staff_v}
				<option value="{$store_staff_v.staffid}"{if $smarty.get.staffid eq $store_staff_v.staffid} selected="selected"{/if}>{$store_staff_v.staff_name}</option>
				{/foreach}
			</select>
			</div>
		 </div>

		<div class="row">
			<div class="col-md-6">
				<div><label>Loại lương:</label></div>
				<div>
					<input type="radio" name="loailuong" value="thang"/>Lương tháng&nbsp;&nbsp;&nbsp;<input type="radio" name="loailuong" value="gio" {if  $smarty.get.loailuong eq 'gio'} checked="checked" {/if}/>Lương giờ
				</div>
			</div>
		</div>			
		
		<div class="row" style="margin-top:10px">
		<div class="col-md-12">
		<button class="btn btn-primary pull-right" id="userPics_btn_search" type="button" onClick="printluong();" style="margin-left:10px">In phiếu lương</button>
		<button class="btn btn-primary pull-right" id="userPics_btn_search" type="button" onClick="search()">Tìm kiếm</button>
		</div>
		</div>
		 



		 
		</form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
	  
	  

	  
<div style="margin-bottom:10px">
<input type="button" value="Thêm tiền thưởng cho nhân viên" onClick="location.href='/worktime/bonus/?back={$smarty.server.REQUEST_URI|urlencode}&staffid={$smarty.get.staffid}'">
</div>
  

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
			
			
			
<div class="pad5 scrollView">
<div class="width-1800">			




{if $smarty.get.staffid ne ""}

<div style="margin-bottom:10px;">
<div style=" color:#FF0000">
*) Số giờ làm quy định: {$sogiolam1ca} tiếng<br>
*) Giờ làm thêm được tính >{$config_one.sophutphutroi} phút giờ làm phụ trội<br>
*) Lương =lương cơ bản + ((lương cơ bản/số ngày trong tháng) x giờ làm thêm) x {$config_one.hesoluongthemgio} - (lương cơ bản/số ngày trong tháng)*số ngày nghỉ - (Số gời làm thiếu) x hệ số lương giờ x {$config_one.hesoluongthieugio} + thưởng <br>
</div>



<div class="col-sm-6" style="padding:0px">
<table id="example1" class="table table-bordered table-striped">
<tr><td>Nhân viên:</td>
  <td nowrap="nowrap">{$store_staff_one.staff_name}</td>
  </tr>
<tr>
  <td>(1) Lương giờ:</td>
  <td nowrap="nowrap">{$store_staff_one.luonggio|number_format}đ/1 giờ</td>
  </tr>

	<tr>
	<td>(2) Tổng giờ làm: </td>
	<td nowrap="nowrap">{$tonggiolam} giờ</td>
	</tr>

	<tr>
	<td>(3) Tổng số sản phẩm bán được: </td>
	<td nowrap="nowrap">{$tongsanphambanduoc} chiếc</td>
	</tr>

	<tr>
	<td>(4) Tiền doanh thu (1) x 1000:</td>
	<td nowrap="nowrap">{$tiendoanhthu|number_format} đ</td>
	</tr>



	<tr>
	<td>(5) Tiền thưởng:</td>
	<td nowrap="nowrap">{$tongtienthuong|number_format} đ</td>
	</tr>


	<tr>
	<td>Thực nhận (1) x (2) + (4) + (5): </td>
	<td nowrap="nowrap"><span style="color:#FF0000; font-weight:bold; font-size:18px">{$thucnhanluongio|number_format} đ</span></td>
	
	</tr>
</table>
</div>



{if $bonus_reason ne NULL}
<div style="clear:both">Chi tiết thưởng</div>

<div>
<table id="example1" class="table table-bordered table-striped">
<tr>
<th>Tổng tiền</th>
<th>Lý do</th>
<th>Ghi chú</th>
<th width="50px"></th>
</tr>
{foreach from=$bonus_reason item=bonus_reason_v}
<tr>
<td>{$bonus_reason_v.amount|number_format}</td>
<td>{$bonus_reason_v.bonus_reason_name}</td>
<td>{$bonus_reason_v.note}</td>
<td><input type="button" value="Xóa" onClick="xoa({$bonus_reason_v.id});" /></td>
</tr>
{/foreach}
</table>

</div>
{/if}


<div style="clear:both">Chi tiết giờ làm</div>
<div><input type="button" value="Thêm mới" onClick="location.href='/worktime/worktimeadd/?back={$smarty.server.REQUEST_URI|urlencode}&staffid={$smarty.get.staffid}'"/></div>
<div class="box-body table-responsive no-padding">
<table id="example1" class="table table-bordered table-striped">
<tr>
<th>Nhân viên</th>
<th>Giờ bắt đầu </th>
<th>Giờ kết thúc </th>
<th>Tổng số giờ làm </th>
<th width="100px">&nbsp; </th>

</tr>
{foreach from=$woking_time item=woking_time_v}
<tr>
<td>{$woking_time_v.staffid} {$woking_time_v.staff_name}</td>
<td>{php}if ($this->_tpl_vars["woking_time_v"]["start_time"] !="0000-00-00 00:00:00"): echo date("d/m H:i",strtotime($this->_tpl_vars["woking_time_v"]["start_time"]));endif;{/php}</td>
<td>{php}if ($this->_tpl_vars["woking_time_v"]["finish_time"] !="0000-00-00 00:00:00"): echo date("d/m H:i",strtotime($this->_tpl_vars["woking_time_v"]["finish_time"]));endif;{/php}</td>

<td>{$woking_time_v.tonggiolam}</td>
<td><input type="button" value="Sửa" onClick="location.href='/worktime/worktimeedit/?id={$woking_time_v.serial}&back={$smarty.server.REQUEST_URI|urlencode}'"/><input type="button" value="Xóa" onClick="location.href='/worktime/worktimedelete/?id={$woking_time_v.serial}&ac=1&back={$smarty.server.REQUEST_URI|urlencode}'"/></td>

</tr>
{/foreach}
</table>
</div>
</div>
{/if}






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

	
	
	
	

{php}
$lastmonth=date("m");
if ((int)$lastmonth==1) 
	$lastmonth=12;
else
	$lastmonth=(int)$lastmonth-1;

$lastyear=date("Y");
if ((string)date("m")=="01") 
	$lastyear=(int)$lastyear-1;
	

{/php}


{literal}
<script language="javascript">


$("#fromdate").datepicker({ dateFormat: "dd/mm/yy"});
$("#fromdate").datepicker("setDate", "{/literal}{if $smarty.get.fromdate ne ""}{$smarty.get.fromdate}{else}{if $config_one.luongthang_tungay_denngay_option eq 1}{php}echo date($this->_tpl_vars["config_one"]["luongthang_tungay"]."/".$lastmonth."/".$lastyear);{/php}{else}{php}echo date("01/m/Y",strtotime("-1 month")){/php}{/if}{/if}{literal}");

$("#todate").datepicker({ dateFormat: "dd/mm/yy"});
$("#todate").datepicker("setDate", "{/literal}{if $smarty.get.todate eq ""}{if $config_one.luongthang_tungay_denngay_option eq 1}{php}echo date($this->_tpl_vars["config_one"]["luongthang_denngay"]."/n/Y");{/php}{else}{php}echo date("t/m/Y",strtotime("-1 month")){/php}{/if}{else}{$smarty.get.todate}{/if}{literal}");



function search()
{
	var frm=document.frm
	if (frm.staffid.value==""){
		alert("Chưa chọn nhân viên");
		return false;
	}
	frm.print.value="";
	frm.target="_self";
	frm.submit();
}


function xoa(id){
myRet = confirm("Có chắc chắn xóa không?");
if ( myRet == true ){
	location.href="/worktime/bonusdel/?id="+id;  
}
}


function printluong(){

	//window.open(
	 // '{/literal}{$smarty.server.REQUEST_URI}{literal}&print=1',
	  //'_blank' // <- This is what makes it open in a new window.
	//);
	
	
	var frm=document.frm
	if (frm.staffid.value==""){
		alert("Chưa chọn nhân viên");
		return false;
	}
	//frm.action="/worktime/worktime/?print=1";
	frm.target="_blank";
	frm.print.value=1;
	frm.submit();



}


</script>
{/literal}