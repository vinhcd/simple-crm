<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
{literal}
<style type="text/css" media="print">
@page { size: auto; margin: 0mm; }

@media screen {
	.page-break	{ height:10px; background:url(page-break.gif) 0 center repeat-x; border-top:1px dotted #999; margin-bottom:13px; }
}

@media print {
	.page-break { height:0; page-break-before:always; margin:0; border-top:none; }
}

html
{
	margin: 0px;  /* this affects the margin on the html before sending to printer */
}

body
{
	margin: 0; /* margin you want for the content */
	font-family: "Trebuchet MS", "Helvetica", "Arial",  "Verdana", "sans-serif";
	font-size: 75%;	
}


.sample_01{
width: 100%;
border-collapse: collapse;
}
.sample_01 th{
padding: 2px;
text-align: center;
vertical-align: top;
border: 1px solid #b9b9b9;
}
.sample_01 td{
padding: 2px;
border: 1px solid #b9b9b9;
}
</style>
{/literal}
</head>
<body>
{*A4*}
<div style="width:210mm; padding-left:10mm; padding-right:10mm; padding-top:10mm">
  
  
  {foreach from=$salary item=salary_v}
  <div style="font-size:30px; font-weight:bold;">Bảng  lương chi tiết (T12.2018)</div>
  <div>
  	  <div style="margin-top:10px;"> 
		  <strong>Họ và tên: {$salary_v.first_name} {$salary_v.last_name}</strong> <br>
		  <strong>MSNV: {$salary_v.staff_id}</strong> <br>
		  <strong>Bộ phận: {$salary_v.department_name}</strong> <br>
		  <strong>Chức danh: {$salary_v.posion_name}</strong> <br>
		  <strong>Ngày công tiêu chuẩn: {$salary_setting_one.luong_songaylamviec}</strong>
	  </div>
	  
	  <div style=" margin-top:10px">
	   <table border="1" cellspacing="0" cellpadding="3px" style="width:100%">
          <tr>
            <td style="width:200px">Lương</td>
            <td>Lương tháng (3) </td>
            <td style="text-align:right">{if $salary_v.luong_luongcoban>0}{$salary_v.luong_luongcoban|number_format}{/if} </td>
          </tr>
          <tr>
            <td rowspan="4">Ngày phép</td>
            <td>Ngày phép còn lại đầu kỳ(h)</td>
            <td style="text-align:right">{if $salary_v.ngayphepconlaidauky>0}{$salary_v.ngayphepconlaidauky}{/if}</td>
          </tr>
          <tr>
            <td>Ngày phép tăng trong kỳ(h)</td>
            <td style="text-align:right">{if $salary_v.ngaypheptangtrongky>0}{$salary_v.ngaypheptangtrongky}{/if}</td>
          </tr>
          <tr>
            <td>Ngày phép đã dùng trong kỳ(h)</td>
            <td style="text-align:right">{if $salary_v.ngayphepdadungtrongky>0}{$salary_v.ngayphepdadungtrongky}{/if}</td>
          </tr>
          <tr>
            <td>Ngày phép còn lại cuối kỳ(h)</td>
           <td style="text-align:right">{if $salary_v.ngayphepconlaicuoiky>0}{$salary_v.ngayphepconlaicuoiky}{/if}</td>
          </tr>
          <tr>
            <td rowspan="7" valign="top">Ngày công</td>
            <td>Ngày công thực tế </td>
            <td style="text-align:right">{$salary_v.work_hours}</td>
          </tr>
          <tr>
            <td>Công phép </td>
            <td style="text-align:right">{if $salary_v.ngayphepdadungtrongky>0}{$salary_v.ngayphepdadungtrongky}{/if}</td>
          </tr>
          <tr>
            <td>Nghỉ trừ lương (h) (23)</td>
            <td style="text-align:right"><p align="right">{if $salary_setting_one.luong_luongcoso>0}{$salary_setting_one.luong_luongcoso|number_format}{/if}</td>
          </tr>
          <tr>
            <td>Thêm giờ ngày lễ (h)(300%) (10) </td>
            <td style="text-align:right">{if $salary_v.ot4>0}{$salary_v.ot4}{/if} </td>
          </tr>
          <tr>
            <td>Thêm giờ cuối tuần  (h)(200%) (8) </td>
            <td style="text-align:right">{if $salary_v.ot3>0}{$salary_v.ot3}{/if} </td>
          </tr>
          <tr>
            <td>Thêm giờ ban đêm  (h)(200%) (6) </td>
            <td style="text-align:right">{if $salary_v.ot2>0}{$salary_v.ot2}{/if} </td>
          </tr>
          <tr>
            <td>Thêm giờ (h)(150%) (4) </td>
            <td style="text-align:right">{if $salary_v.ot1>0}{$salary_v.ot1}{/if} </td>
          </tr>
          <tr>
            <td rowspan="7" valign="top">Lương    OT và thu nhập khác</td>
            <td>Lương ngoài giờ ngày lễ (OT): 300% (11) </td>
            <td style="text-align:right">{if $salary_v.ot4_value>0}{$salary_v.ot4_value|number_format}{/if} </td>
          </tr>
          <tr>
            <td>Lương ngoài giờ cuối tuần (OT): 200% (9) </td>
            <td style="text-align:right">{if $salary_v.ot3_value>0}{$salary_v.ot3_value|number_format}{/if} </td>
          </tr>
          <tr>
            <td>Lương ngoài giờ ban đêm (OT): 200% (7) </td>
            <td style="text-align:right">{if $salary_v.ot2_value>0}{$salary_v.ot2_value|number_format}{/if} </td>
          </tr>
          <tr>
            <td>Lương ngoài giờ (OT): 150% (5) </td>
            <td style="text-align:right">{if $salary_v.ot1_value>0}{$salary_v.ot1_value|number_format}{/if} </td>
          </tr>
          <tr>
            <td>KPI/Incentive (28)</td>
            <td style="text-align:right">{if $salary_v.luong_thunhapkhac>0}{$salary_v.luong_thunhapkhac|number_format}{/if}</td>
          </tr>
          <tr>
            <td>Quyết toán ngày phép còn lại (20)</td>
            <td style="text-align:right">{if $salary_v.luong_quyettoanconlaitrongnam_value>0}{$salary_v.luong_quyettoanconlaitrongnam_value|number_format}{/if}</td>
          </tr>
          <tr>
            <td>Khoản bổ sung khác trong tháng (45) </td>
            <td style="text-align:right">{if $salary_v.luong_trocapbaohiem_trathuenopthua>0}{$salary_v.luong_trocapbaohiem_trathuenopthua|number_format}{/if} </td>
          </tr>
          <tr>
            <td rowspan="3" valign="top">Phụ cấp</td>
            <td>Ăn trưa (17) </td>
            <td style="text-align:right">{if $salary_v.luong_trocapantrua>0}{$salary_v.luong_trocapantrua|number_format}{/if} </td>
          </tr>
          <tr>
            <td>Đi lại (12) </td>
            <td style="text-align:right">{if $salary_v.luong_trocapdilai>0}{$salary_v.luong_trocapdilai|number_format}{/if} </td>
          </tr>
          <tr>
            <td>Trách nhiệm (16) </td>
            <td style="text-align:right">{if $salary_v.luong_trocaptrachnhiem>0}{$salary_v.luong_trocaptrachnhiem|number_format}{/if} </td>
          </tr>
		  {*
          <tr>
            <td>Khác </td>
            <td style="text-align:right">xxxxxxxxxxxxxxxx </td>
          </tr>
          *}
		  <tr>
            <td rowspan="4" valign="top">Tính&nbsp;Thuế TNCN</td>
            <td>Giảm trừ bản thân </td>
            <td style="text-align:right">{$salary_setting_one.luong_giamtrubanthan|number_format} </td>
          </tr>
          <tr>
            <td>Số người phụ&nbsp;thuộc (31) </td>
            <td style="text-align:right">{if $salary_v.luong_songuoiphuthuoc>0}{$salary_v.luong_songuoiphuthuoc}{/if} </td>
          </tr>
          <tr>
            <td>Thu nhập chịu thuế (32)</td>
            <td style="text-align:right">{if $salary_v.thunhapchithuetruocgiamtru>0}{$salary_v.thunhapchithuetruocgiamtru|number_format}{/if}</td>
          </tr>
          <tr>
            <td>Thu&nbsp;nhập tính&nbsp;thuế (33) </td>
            <td style="text-align:right">{if $salary_v.thunhaptinhthuesaugiamtru>0}{$salary_v.thunhaptinhthuesaugiamtru|number_format}{/if} </td>
          </tr>
          <tr>
            <td rowspan="3" valign="top">Giảm trừ</td>
            <td>BHXH+BHYT+BHTN (10.5%) (43) </td>
            <td style="text-align:right">{if $salary_v.canhanchiubaohiem_total>0}{$salary_v.canhanchiubaohiem_total|number_format}{/if} </td>
          </tr>
          <tr>
            <td>Trừ nghỉ không lương (24) </td>
            <td style="text-align:right">{if $salary_v.luong_giolamthieutrongthang_value>0}{$salary_v.luong_giolamthieutrongthang_value|number_format}{/if} </td>
          </tr>
          <tr>
            <td>Thuế TNCN giảm trừ trong tháng (34) </td>
            <td style="text-align:right">{if $salary_v.sothuephainopthangnay>0}{$salary_v.sothuephainopthangnay|number_format}{/if} </td>
          </tr>
          <tr>
            <td rowspan="2" valign="top">Điều    chỉnh tháng trước</td>
            <td>Tăng (46a nếu 46a&gt;0))</td>
            <td style="text-align:right"><strong>{if $salary_v.luong_thangtruocchuyenqua>0}{$salary_v.luong_thangtruocchuyenqua|number_format}{/if}</strong></td>
          </tr>
          <tr>
            <td>Giảm (46a nếu 46a&lt;0))</td>
            <td style="text-align:right"><strong>{if $salary_v.luong_thangtruocchuyenqua<0}{$salary_v.luong_thangtruocchuyenqua|number_format}{/if}</strong></td>
          </tr>
          <tr>
            <td rowspan="2" valign="top">Chuyển    khoản</td>
            <td><strong>Thực nhận (47)</strong> </td>
            <td style="text-align:right"><strong>{if $salary_v.tongluongdanhanchuyenkhoan>0}{$salary_v.tongluongdanhanchuyenkhoan|number_format}{/if}</strong> </td>
          </tr>
          <tr>
            <td>Số Tài khoản (48) </td>
            <td>{if $salary_v.bank_number ne ""}{$salary_v.bank_number}{/if}</td>
          </tr>
        </table>
		
		
		<div>
	</div>
	<div style="clear:both;"></div>
	{/foreach}
	
</div>
<div class="page-break"></div>
{*
{literal}
	<script type="text/javascript">
	window.onload = function() { window.print(); }
	window.onafterprint = function(){
	{/literal}
	{if $smarty.get.b ne ""}
	{literal}
		window.location = "{/literal}{$smarty.get.b|urldecode}{literal}";
	{/literal}
	{else}
	{literal}
		window.location = "/general-import/new/";
	{/literal}
	{/if}
	{literal}	
	  
	}			
	</script>
{/literal}
*}  
</body>
</html>