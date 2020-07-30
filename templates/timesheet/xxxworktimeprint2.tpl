<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Phiếu lương</title>
<link rel="stylesheet" href="/css/my.css" type="text/css" />
</head>

<body>


<div style="margin-top:10px; margin-bottom:10px; width:1000px;">
<div style="text-align:center; font-size:24px; font-weight:bold">PHIẾU LƯƠNG NHÂN VIÊN</div>
<div style="margin-bottom:10px;">




<div style="margin-top:10px;">
<div style="float:left; width:500px;">

<table border="0" width="619">
<tr><td width="235">Nhân viên:</td>
  <td width="374">{$store_staff_one.staff_name}</td>
  </tr>
<tr>
  <td>(1) Lương giờ:</td>
  <td>{$store_staff_one.luonggio|number_format}đ/1 giờ</td>
  </tr>
  
  
	<tr>
	<td>(2) Tổng giờ làm: </td>
	<td>{$tonggiolam} giờ</td>
	</tr>

	<tr>
	<td>(3) Tổng số sản phẩm bán được: </td>
	<td>{$tongsanphambanduoc} chiếc</td>
	</tr>




	<tr>
	<td>(4) Tiền doanh thu (1) x 1000:</td>
	<td>{$tiendoanhthu|number_format} đ</td>
	</tr>



	<tr>
	<td>(5) Tiền thưởng:</td>
	<td>{$tongtienthuong|number_format} đ</td>
	</tr>


	<tr>
	<td>Thực nhận (1) x (2) + (4) + (5): </td>
	<td><span style="color:#FF0000; font-weight:bold; font-size:18px">{$thucnhanluongio|number_format} đ</span></td>
	
	</tr>
  

</table>
</div>

<div style="clear:both"></div>


{if $bonus_reason ne NULL}
<br><span style="font-size:17px; font-weight:bold">Chi tiết thưởng</span><br>

<div>
<table id="table-01">
<tr>
<th>Tổng tiền</th>
<th>Lý do</th>
<th>Ghi chú</th>
</tr>
{foreach from=$bonus_reason item=bonus_reason_v}
<tr>
<td>{$bonus_reason_v.amount|number_format}</td>
<td>{$bonus_reason_v.bonus_reason_name}</td>
<td>{$bonus_reason_v.note}</td>
</tr>
{/foreach}
</table>

</div>
{/if}


<br><span style="font-size:17px; font-weight:bold">Chi tiết giờ làm</span><br>
<table id="table-01">
<tr>
<th>Nhân viên</th>
<th>Giờ bắt đầu </th>
<th>Giờ kết thúc </th>
<th>Tổng giờ</th>

</tr>
{foreach from=$woking_time item=woking_time_v}
<tr>
<td>{$woking_time_v.staffid} {$woking_time_v.staff_name}</td>
<td>{php}if ($this->_tpl_vars["woking_time_v"]["start_time"] !="0000-00-00 00:00:00"): echo date("d/m H:i",strtotime($this->_tpl_vars["woking_time_v"]["start_time"]));endif;{/php}</td>
<td>{php}if ($this->_tpl_vars["woking_time_v"]["finish_time"] !="0000-00-00 00:00:00"): echo date("d/m H:i",strtotime($this->_tpl_vars["woking_time_v"]["finish_time"]));endif;{/php}</td>

<td>{$woking_time_v.tonggiolam}</td>


</tr>
{/foreach}
</table>
</div>
{*
<div style="color:#FF0000; margin-top:10px"><strong>*) Chú ý quan trọng: Ngày quên không chấm công khi về, được chủ cửa hàng cho về sớm, hoặc ngày nghỉ được hưởng lương nhân viên nhớ báo với chủ cửa hàng để được chấm công "Nếu quên bạn sẽ chịu thiệt"</strong>
</div>
*}

</div>




</body>
</html>