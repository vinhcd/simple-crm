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

<table border="0" width="500">
<tr><td width="350">Nhân viên:</td>
  <td width="120">{$store_staff_one.staff_name}</td>
  </tr>
<tr>
  <td>(1) Lương cơ bản:</td>
  <td>{$store_staff_one.luongcoban|number_format} đ</td>
  </tr>
<tr>
  <td>(2) Hệ số lương ngày:</td>
  <td>{php}echo number_format($this->_tpl_vars["hesoluongngay"]);{/php} đ</td>
  </tr>
<tr>
  <td>(3) Hệ số lương giờ:</td>
  <td>{$hesoluonggio|number_format} đ</td>
  </tr>
<tr>
  <td>(4) Số ngày làm quy định trong tháng này:</td>
  <td>{$songaylamviecquydinhtrongthang} ngày</td>
<tr>
  <td>(5) Số ngày đi làm thực:</td>
  <td>{$songaylamthuc} ngày</td>
  </tr>
<tr>
  <td>(6) Số ngày nghỉ hưởng lương:</td>
  <td>{$store_staff_one.songaynghiquydinh} ngày</td>
  </tr>
<tr>
  <td>(7) Số ngày làm bị thiếu trong tháng (4)-(5)-(6):</td>
  <td>{$sogaylambithieu} ngày </td>
  </tr>
<tr>
  <td>(8) Số giờ làm thêm:</td>
  <td>{$tonggiolamthem} giờ</td>
  </tr>
<tr>
  <td>(9) Giờ làm bị thiếu</td>
  <td>{$tonggiolamthieu} giờ</td>
  </tr>
{if $store_staff_one.luongdoanhthu eq 1}  
<tr>
  <td>(15) Tổng số sản phẩm bán được: </td>
  <td>{$tongsanphambanduoc} chiếc</td>
  </tr>
{/if}
</table>
</div>
<div style="float:left; width:500px;"></div>

<table border="0" width="500">
<tr><td>(10) Số ngày làm bị thiếu (7) x (2) </td>
  <td>{php}echo number_format($this->_tpl_vars["tongtiensongaylambithieu"]);{/php} đ</td>
</tr>
<tr>
  <td>(11) Tiền làm thêm giờ (8) x (3) x 1.2 </td>
  <td>{php}echo number_format($this->_tpl_vars["tongtienlamthemgio"]);{/php} đ</td>
</tr>
<tr>
  <td>(12) Tiền giờ làm bị thiếu (9) x (3) x 1.2:</td>
  <td>{$tongtiengiolambithieu|number_format} đ</td>
  </tr>
  
  
{if $store_staff_one.luongdoanhthu eq 1}
<tr>
	<td>(13) Tiền doanh thu (15) x 1000:</td>
	<td>{$tiendoanhthu|number_format} đ</td>
</tr>
{/if}


<tr>
<td>(14) Tiền thưởng:</td>
<td>{$tongtienthuong|number_format} đ</td>
</tr>




{if empty($store_staff_one.luongdoanhthu)}
<tr>
	<td>Thực nhận (1) - (10) + (11) - (12) + (14): </td>
	<td><span style="color:#FF0000; font-weight:bold; font-size:18px">{$thucnhan|number_format} đ</span></td>
<tr>
{/if}



{if $store_staff_one.luongdoanhthu eq 1}
<TR>
	<td>Thực nhận (1) - (10) + (11) - (12) + (13) + (14): </td>
	<td><span style="color:#FF0000; font-weight:bold; font-size:18px">{$thucnhan2|number_format} đ</span></td>
</tr>
{/if}
  
  
  
  
  
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
{if $store_staff_one.luongdoanhthu eq 1}  
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
{/if}
</table>
</div>
<div style="clear:both"></div>
{*
<div style="color:#FF0000"><strong>*) Chú ý quan trọng: Ngày quên không chấm công khi về, được chủ cho về sớm, hoặc ngày nghỉ được hưởng lương nhân viên nhớ báo với chủ cửa hàng để được chấm công "Nếu quên bạn sẽ chịu thiệt"</strong>
</div>
*}
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
<th nowrap="nowrap">Nhân viên</th>
<th nowrap="nowrap">Bắt đầu </th>
<th nowrap="nowrap">Kết thúc </th>
<th nowrap="nowrap">Tổng giờ làm </th>
<th nowrap="nowrap">Làm thêm </th>
<th nowrap="nowrap">Làm thiếu </th>
{*<th width="150">Tình trạng</th>*}
</tr>
{foreach from=$woking_time item=woking_time_v}
<tr>
<td>{$woking_time_v.staff_name}</td>
<td>{php}if ($this->_tpl_vars["woking_time_v"]["start_time"] !="0000-00-00 00:00:00"): echo date("d/m H:i",strtotime($this->_tpl_vars["woking_time_v"]["start_time"]));endif;{/php}</td>
<td>{php}if ($this->_tpl_vars["woking_time_v"]["finish_time"] !="0000-00-00 00:00:00"): echo date("d/m H:i",strtotime($this->_tpl_vars["woking_time_v"]["finish_time"]));endif;{/php}</td>
<td>
{$woking_time_v.sotienglamtrongngay}
</td>
<td>
{$woking_time_v.themgio}
</td>
<td>
{$woking_time_v.giolamthieu}
</td>
{*
<td align="center">
{php}
if (date("A",strtotime($this->_tpl_vars["woking_time_v"]["start_time"]))=="AM" && strtotime($this->_tpl_vars["woking_time_v"]["start_time"])>strtotime(date("Y-m-d 08:35:00",strtotime($this->_tpl_vars["woking_time_v"]["start_time"])))) echo "<span style=\"color:#FF0000\">Đi muộn</span>";

if (date("A",strtotime($this->_tpl_vars["woking_time_v"]["start_time"]))=="PM" && strtotime($this->_tpl_vars["woking_time_v"]["start_time"])>strtotime(date("Y-m-d 15:05:00",strtotime($this->_tpl_vars["woking_time_v"]["start_time"]))))echo "<span style=\"color:#FF0000\">Đi muộn</span>";

{/php}

</td>
*}
</tr>
{/foreach}
</table>
</div>

<div style=" color:#FF0000">
*) Số giờ làm quy định: {$sogiolam1ca} tiếng<br>
*) Giờ làm thêm được tính >{$config_one.sophutphutroi} phút giờ làm phụ trội<br>
*) Lương =lương cơ bản + ((lương cơ bản/số ngày trong tháng) x giờ làm thêm) x {$config_one.hesoluongthemgio} - (lương cơ bản/số ngày trong tháng)*số ngày nghỉ - (Số gời làm thiếu) x hệ số lương giờ x {$config_one.hesoluongthieugio} + thưởng <br>
</div>


</div>




</body>
</html>