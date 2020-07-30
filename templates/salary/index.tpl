{include file='header.tpl'}
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
{literal}
<style>
table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th{
  text-align: left;
  padding: 2px;
  border: 1px solid #ddd;
  white-space:nowrap;
}

td {
  text-align: left;
  padding: 2px;
  border: 1px solid #ddd;
  white-space:nowrap;
}
</style>
{/literal}
{include file='header_content.tpl'}
{include file='menu.tpl'}
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1>Salary managment</h1>
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
		 <label>Year/Month:</label>
		 <div class="row">
			<div class="col-md-5">
				<select name="year" id="year" onChange="xxx()"><br>
					{php}
					for ($i=2018;$i<date("Y")+2;$i++){
					{/php}
					<option value="{php}echo $i;{/php}"{php}echo ($i==$this->_tpl_vars["current_year"])?' selected="selected"':''{/php}>{php}echo $i;{/php}</option>>
					{php}
					}
					{/php} 
				</select>


				  <select name="month" id="month" onChange="xxx()">
					{php}
					for ($i=1;$i<13;$i++){
					{/php}
					<option value="{php}echo sprintf("%02d", $i);{/php}"{php}echo (sprintf("%02d", $i)==$this->_tpl_vars["current_month"])?' selected="selected"':''{/php}>{php}echo sprintf("%02d", $i);{/php}</option>>
					{php}
					}
					{/php} 	
				  </select>

	
			 </div>		 
		 </div>
		 </div>
		 
		{if $admin->role eq 2}	
		<div class="col-md-6">
			<label>Staff:</label>
			<select class="form-control select2" style="width: 100%;" name="staff_id" id="staff_id">
				<option value="">All</option>
				{foreach from=$store_staff item=store_staff_v}
				<option value="{$store_staff_v.id}"{if $smarty.get.staff_id eq $store_staff_v.id} selected="selected"{/if}>{$store_staff_v.fist_name} {$store_staff_v.last_name}</option>
				{/foreach}
			</select>
			</div>
		 </div>
		 {/if}

		
		
		
		
		
		
		
		<div class="row" style="margin-top:10px">
		<div class="col-md-12">
		<button class="btn btn-primary pull-right" id="userPics_btn_search" type="button" onClick="payslip_print();" style="margin-left:10px">Payslip print</button>
		<button class="btn btn-primary pull-right" id="userPics_btn_search" type="button" onClick="export_exel();" style="margin-left:10px">Excel export</button>
		<button class="btn btn-primary pull-right" id="userPics_btn_search" type="button" onClick="search()">Search</button>
		</div>
		</div>
		 



		 
		</form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
	  
	  
	  




<!-- SELECT2 EXAMPLE -->
<div class="box box-default">
<div class="box-header with-border">

	 <div class="row" style="margin-top:10px">
		 <div class="col-md-6">
			<label>Số ngày làm việc trong tháng(C4): {$salary_setting_one.luong_songaylamviec}</label>
		 </div>
	</div>

</div>
<!-- /.box-body -->
</div>
<!-- /.box -->
	  


	  
	  
	  
	  
          <div class="box">
            <div class="box-body" style="overflow-x:auto;">
			
			
<table>
<tr>
<th rowspan="2" style="vertical-align:middle; text-align:center">Mã nhân viên<br>社員番号</th>
<th rowspan="2" style="vertical-align:middle; text-align:center">Họ và tên<br>氏名</th>
<th rowspan="2" style="vertical-align:middle; text-align:center">Lương cơ bản<br>基本給</th>
<th rowspan="2" style="vertical-align:middle; text-align:center">Lương cơ sở<br>基準賃金</th>
<th colspan="2" style="text-align:center">
Làm thêm<br>
(Ngày thường 150%)<br>
平日残業(150%)
</th>
<th colspan="2" style="text-align:center">
Làm thêm<br>
(Đêm ngày thường 200%)<br>
平日夜中残業(200%)
</th>
<th colspan="2" style="text-align:center">
Làm thêm<br>
(Cuối tuần 200%)<br>
週末残業(200%)
</th>
<th colspan="2" style="text-align:center">
Làm thêm (Ngày lễ 300%)<br>
祝日残業(300%)
</th>
<th colspan="7" style="text-align:center">
Trợ cấp<br>手当
</th>
<th colspan="2" style="text-align:center">Quyết toán ngày phép còn lại trong năm<br>有給残日数支払</th>
<th rowspan="2" style="vertical-align:middle; text-align:center">Tiền chúc mừng / chia buồn<br>慶弔・見舞金</th>
<th rowspan="2" style="vertical-align:middle; text-align:center">Điều chỉnh (Trước tổng lương)<br>その他調整（実際給与に関係する）</th>
<th colspan="2" style="text-align:center">Số giờ nghỉ trừ lương<br>無給休暇</th>
<th colspan="2" style="text-align:center; color:#FF0000">Số giờ nghỉ phép, nghỉ bù (đặc biệt)<br>その他休み</th>
<th rowspan="2" style="vertical-align:middle; text-align:center; color:#FF0000">Tổng lương<br>実際給与</th>
<th rowspan="2" style="vertical-align:middle; text-align:center;">Thu nhập khác<br>その他収入</th>
<th rowspan="2" style="vertical-align:middle; text-align:center;">Tháng lương thứ 13 (thưởng)<br>ボーナス</th>
<th rowspan="2" style="vertical-align:middle; text-align:center;">Trợ cấp không chịu thuế<br>非課税手当</th>
<th rowspan="2" style="vertical-align:middle; text-align:center;">Tổng làm thêm giờ không chịu thuế<br>非課税残業</th>
<th colspan="4" style="text-align:center">Thuế thu nhập cá nhân<br>源泉個人所得税</th>
<th colspan="5" style="text-align:center">Bảo hiểm và chi phí công đoàn công ty chịu<br>会社が負担する社会保険・健康保険・失業保険・労働組合費</th>
<th colspan="4" style="text-align:center">Bảo hiểm và chi phí công đoàn người lao động chịu<br>社員が負担する社会保険・健康保険・失業保険</th>
<th rowspan="2" style="text-align:center">Tổng lương còn lại chưa trả<br>未払給与</th>
<th rowspan="2" style="text-align:center">Trợ cấp bảo hiểm từ Bảo hiểm xã hội/Trả thuế năm 2018 nộp thừa<br> 社会保険手当・2017年過剰に納税した所得税の返金</th>
<th rowspan="2" style="text-align:center; color:#FF0000">Tổng lương thực nhận chưa trả<br>支払合計</th>
<th rowspan="2" style="text-align:center; color:#FF0000">Tháng trước chuyển sang</th>
<th rowspan="2" style="text-align:center; color:#FF0000">Tổng lương thực nhận đã chuyển khoản<br>振替金額</th>
<th rowspan="2" style="text-align:center;">Tài khoản ngân hàng của nhân viên<br>銀行口座情報</th>
<th rowspan="2" style="text-align:center;">賞与</th>
</tr>
<tr>
<th style="text-align:center">Số giờ<br>時間</th>
<th style="text-align:center">Số tiền<br>金額</th>
<th style="text-align:center">Số giờ<br>時間</th>
<th style="text-align:center">Số tiền<br>金額</th>
<th style="text-align:center">Số giờ<br>時間</th>
<th style="text-align:center">Số tiền<br>金額</th>
<th style="text-align:center">Số giờ<br>時間</th>
<th style="text-align:center">Số tiền<br>金額</th>

<th style="text-align:center">Trợ cấp đi lại<br>通勤手当</th>
<th style="text-align:center">Trợ cấp tiếng Nhật<br>日本語手当</th>
<th style="text-align:center">Trợ cấp liên lạc<br>携帯電話手当</th>
<th style="text-align:center">Trợ cấp gửi xe<br>駐車場手当</th>
<th style="text-align:center">Phụ cấp trách nhiệm<br>管理職手当</th>
<th style="text-align:center">Trợ cấp ăn trưa<br>昼食手当</th>
<th style="text-align:center">Tổng các khoản trợ cấp hàng tháng<br>毎月手当合計</th>

<th style="text-align:center">Số giờ<br>時間</th>
<th style="text-align:center">Số tiền<br>金額</th>

<th style="text-align:center">Số giờ<br>時間</th>
<th style="text-align:center">Số tiền<br>金額</th>

<th style="text-align:center">Số giờ<br>時間</th>
<th style="text-align:center">Số tiền<br>金額</th>

<th style="text-align:center">Số người phụ thuộc<br>扶養義務人数</th>
<th style="text-align:center">Thu nhập chịu thuế<br>(Trước giảm trừ)<br>課税所得<br>(扶養義務の控除前）</th>
<th style="text-align:center">Thu nhập tính thuế<br>(Sau giảm trừ)<br>課税所得<br>(扶養義務の控除後）</th>
<th style="text-align:center">Số thuế phải nộp tháng này<br>実際給与から控除した税金</th>

<th style="text-align:center">Bảo hiểm xã hội (17.5%)<br>社会保険 (17.5%)</th>
<th style="text-align:center">Bảo hiểm y tế (3%)<br>健康保険 (3%)</th>
<th style="text-align:center">Bảo hiểm thất nghiệp (1%)<br>失業保険　(1%)</th>
<th style="text-align:center">Kinh phí công đoàn(2%)<br>労働組合費(2%)</th>
<th style="text-align:center">Tổng (24%)<br>合計(24%)</th>

<th style="text-align:center">Bảo hiểm xã hội (8%)<br>社会保険 (8%)</th>
<th style="text-align:center">Bảo hiểm y tế (1.5%)<br>健康保険 (1.5%)</th>
<th style="text-align:center">Bảo hiểm thất nghiệp (1%)<br>失業保険　(1%)</th>
<th style="text-align:center">Tổng (10.5%)<br>合計(10.5%)</th>


</tr>

<tr>
<td style="text-align:center">(1)</td>
<td style="text-align:center">(2)</td>
<td style="text-align:center">(3)</td>
<td style="text-align:center">(3a)</td>
<td style="text-align:center">(4)</td>
<td style="text-align:center">(5)=(3)/C4/8*(4)*150%</td>
<td style="text-align:center">(6)</td>
<td style="text-align:center">(7)=(3)/C4/8*(6)*200%</td>
<td style="text-align:center">(8)</td>
<td style="text-align:center">(9)=(3)/C4/8*(8)*200%</td>
<td style="text-align:center">(10)</td>
<td style="text-align:center">(11)=(3)/C4/8*(10)*300%</td>
<td style="text-align:center">(12)</td>
<td style="text-align:center">(13)</td>
<td style="text-align:center">(14)</td>
<td style="text-align:center">(15)</td>
<td style="text-align:center">(16)</td>
<td style="text-align:center">(17)</td>
<td style="text-align:center">(18)=(12)+(13)+(14)+(15)+(16)+(17)</td>
<td style="text-align:center">(19)</td>
<td style="text-align:center">(20)</td>
<td style="text-align:center">(21)</td>
<td style="text-align:center">(22)</td>
<td style="text-align:center">(23)</td>
<td style="text-align:center">(24)=((3)+(18))/C4/8*(23)</td>
<td style="text-align:center">(25)</td>
<td style="text-align:center">(26)</td>
<td style="text-align:center;color:#FF0000;">(27)=(3)+(5)+(7)+
(9)+(11)+(18)+(20)+(21)+(22)-(24)-(26)</td>
<td style="text-align:center">(28)</td>
<td style="text-align:center">(29)</td>
<td style="text-align:center">(29a)=(17)*(C4-(23)/8)/C4</td>
<td style="text-align:center">(30)</td>
<td style="text-align:center">(31)</td>
<td style="text-align:center">(32)</td>
<td style="text-align:center">(33)</td>
<td style="text-align:center">(34)</td>
<td style="text-align:center">(35)=(3)x17.5% or (3a)x20x17.5%</td>
<td style="text-align:center">(36)=(3)x3% or (3a)x20x3%</td>
<td style="text-align:center">(37)=(3)x1%</td>
<td style="text-align:center">(38)=(3)x2% or (3a)x20x2%</td>
<td style="text-align:center">(39)=(35)+(36)+(37)+(38)</td>
<td style="text-align:center">(40)=(3)x8% or (3a)x20x8%</td>
<td style="text-align:center">(41)=(3)x1.5% or (3a)x20x1.5%</td>
<td style="text-align:center">(42)=(3)x1% </td>
<td style="text-align:center">(43)=(40)+(41)+(42)</td>
<td style="text-align:center">(44)=(27)+(28)+(29)-(34)-(43)</td>
<td style="text-align:center">(45)</td>
<td style="text-align:center">(46)=(44)+(45)</td>
<td style="text-align:center">(46a)</td>
<td style="text-align:center">(47)</td>
<td style="text-align:center">(48)</td>
<td style="text-align:center">(49)</td>
</tr>


{foreach from=$salary item=salary_v}
<tr>
<td>{$salary_v.staff_id}</td>
<td>{$salary_v.first_name} {$salary_v.last_name}</td>
<td>{if $salary_v.luong_luongcoban>0}{$salary_v.luong_luongcoban|number_format}{/if}</td>
<td>{if $salary_setting_one.luong_luongcoso>0}{$salary_setting_one.luong_luongcoso|number_format}{/if}</td>
<td>{if $salary_v.ot1>0}{$salary_v.ot1}{/if}</td>
<td>{if $salary_v.ot1_value>0}{$salary_v.ot1_value|number_format}{/if}</td>
<td>{if $salary_v.ot2>0}{$salary_v.ot2}{/if}</td>
<td>{if $salary_v.ot2_value>0}{$salary_v.ot2_value|number_format}{/if}</td>
<td>{if $salary_v.ot3>0}{$salary_v.ot3}{/if}</td>
<td>{if $salary_v.ot3_value>0}{$salary_v.ot3_value|number_format}{/if}</td>
<td>{if $salary_v.ot4>0}{$salary_v.ot4}{/if}</td>
<td>{if $salary_v.ot4_value>0}{$salary_v.ot4_value|number_format}{/if}</td>

<td>{if $salary_v.luong_trocapdilai>0}{$salary_v.luong_trocapdilai|number_format}{/if}</td>
<td>{if $salary_v.luong_trocaptiengnhat>0}{$salary_v.luong_trocaptiengnhat|number_format}{/if}</td>
<td>{if $salary_v.luong_trocaplienlac>0}{$salary_v.luong_trocaplienlac|number_format}{/if}</td>
<td>{if $salary_v.luong_trocapguixe>0}{$salary_v.luong_trocapguixe|number_format}{/if}</td>
<td>{if $salary_v.luong_trocaptrachnhiem>0}{$salary_v.luong_trocaptrachnhiem|number_format}{/if}</td>
<td>{if $salary_v.luong_trocapantrua>0}{$salary_v.luong_trocapantrua|number_format}{/if}</td>
<td>{if $salary_v.trocap_total>0}{$salary_v.trocap_total|number_format}{/if}</td>
<td>{if $salary_v.luong_quyettoanconlaitrongnam>0}{$salary_v.luong_quyettoanconlaitrongnam}{/if}</td>

<td>{if $salary_v.luong_quyettoanconlaitrongnam_value>0}{$salary_v.luong_quyettoanconlaitrongnam_value|number_format}{/if}</td>
<td>{if $salary_v.luong_tienchucmungchiabuon>0}{$salary_v.luong_tienchucmungchiabuon|number_format}{/if}</td>
<td>{if $salary_v.luong_dieuchinhtruoctongluong>0}{$salary_v.luong_dieuchinhtruoctongluong|number_format}{/if}</td>
<td>{if $salary_v.luong_giolamthieutrongthang>0}{$salary_v.luong_giolamthieutrongthang}{/if}</td>
<td>{if $salary_v.luong_giolamthieutrongthang_value>0}{$salary_v.luong_giolamthieutrongthang_value|number_format}{/if}</td>
<td>{if $salary_v.luong_sogionghiphepnghibu>0}{$salary_v.luong_sogionghiphepnghibu}{/if}</td>
<td>{if $salary_v.luong_sogionghiphepnghibu_value>0}{$salary_v.luong_sogionghiphepnghibu_value|number_format}{/if}</td>

<td>{if $salary_v.tongluong>0}{$salary_v.tongluong|number_format}{/if}</td>
<td>{if $salary_v.luong_thunhapkhac>0}{$salary_v.luong_thunhapkhac|number_format}{/if}</td>
<td>{if $salary_v.luong_thangluongthu13>0}{$salary_v.luong_thangluongthu13|number_format}{/if}</td>
<td>{if $salary_v.trocapkhongchiuthue>0}{$salary_v.trocapkhongchiuthue|number_format}{/if}</td>
<td>{if $salary_v.tongluongkhongchiuthue>0}{$salary_v.tongluongkhongchiuthue|number_format}{/if}</td>
<td>{if $salary_v.luong_songuoiphuthuoc>0}{$salary_v.luong_songuoiphuthuoc}{/if}</td>

<td>{if $salary_v.thunhapchithuetruocgiamtru>0}{$salary_v.thunhapchithuetruocgiamtru|number_format}{/if}</td>
<td>{if $salary_v.thunhaptinhthuesaugiamtru>0}{$salary_v.thunhaptinhthuesaugiamtru|number_format}{/if}</td>
<td>{if $salary_v.sothuephainopthangnay>0}{$salary_v.sothuephainopthangnay|number_format}{/if}</td>
<td>{if $salary_v.congtychiu_baohiemxahoi>0}{$salary_v.congtychiu_baohiemxahoi|number_format}{/if}</td>
<td>{if $salary_v.congtychiu_baohiemyte>0}{$salary_v.congtychiu_baohiemyte|number_format}{/if}</td>
<td>{if $salary_v.congtychiu_baohiemthatnghiep>0}{$salary_v.congtychiu_baohiemthatnghiep|number_format}{/if}</td>
<td>{if $salary_v.congtychiu_kinhphicongdoan>0}{$salary_v.congtychiu_kinhphicongdoan|number_format}{/if}</td>
<td>{if $salary_v.congtychiubaohiem_total>0}{$salary_v.congtychiubaohiem_total|number_format}{/if}</td>
<td>{if $salary_v.canhanchiu_baohiemxahoi>0}{$salary_v.canhanchiu_baohiemxahoi|number_format}{/if}</td>
<td>{if $salary_v.canhanchiu_baohiemyte>0}{$salary_v.canhanchiu_baohiemyte|number_format}{/if}</td>
<td>{if $salary_v.canhanchiu_baohiemthatnghiep>0}{$salary_v.canhanchiu_baohiemthatnghiep|number_format}{/if}</td>
<td>{if $salary_v.canhanchiubaohiem_total>0}{$salary_v.canhanchiubaohiem_total|number_format}{/if}</td>
<td>{if $salary_v.tongluongconlaichuatra>0}{$salary_v.tongluongconlaichuatra|number_format}{/if}</td>
<td>{if $salary_v.luong_trocapbaohiem_trathuenopthua>0}{$salary_v.luong_trocapbaohiem_trathuenopthua|number_format}{/if}</td>
<td>{if $salary_v.tongluongthucnhantruatra>0}{$salary_v.tongluongthucnhantruatra|number_format}{/if}</td>
<td>{if $salary_v.luong_thangtruocchuyenqua ne ""}{$salary_v.luong_thangtruocchuyenqua|number_format}{/if}</td>
<td>{if $salary_v.tongluongdanhanchuyenkhoan>0}{$salary_v.tongluongdanhanchuyenkhoan|number_format}{/if}</td>
<td>{if $salary_v.bank_number ne ""}{$salary_v.bank_number}{/if}</td>
<td>{if $salary_v.tienthuong>0}{$salary_v.tienthuong|number_format}{/if}</td>

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
<script type="text/javascript" src="/js/jquery.blockUI.js"></script>
</body>
</html>

	
	
	
	


{literal}
<script language="javascript">

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
		location.href="/salary/delete/?id="+id+"&back={/literal}{$smarty.server.REQUEST_URI|urlencode}{literal}";  
	}
}


function search()
{
	var frm=document.frm
	//check setting
	var response = '';
	$.ajax({
	type: "POST",
	url: "/salary/chksetting/",
	data: "yearmonth="+ document.getElementById("year").value+'/'+document.getElementById("month").value,
	async: false,
	success: function(html){
		 response = html;
	}
	});		

	if (response=="1"){
		alert("Salary setting has not been set for the ["+document.getElementById("year").value+'/'+document.getElementById("month").value+"]");
		return false;
	}		
	
	
	frm.ac.value=1;
	frm.submit();
}


function export_exel(){
	var frm=document.frm
	//check setting
	var response = '';
	$.ajax({
	type: "POST",
	url: "/salary/chksetting/",
	data: "yearmonth="+ document.getElementById("year").value+'/'+document.getElementById("month").value,
	async: false,
	success: function(html){
		 response = html;
	}
	});		

	if (response=="1"){
		alert("Salary setting has not been set for the ["+document.getElementById("year").value+'/'+document.getElementById("month").value+"]");
		return false;
	}		
	
	
	frm.ac.value=3;
	frm.submit();

}



function payslip_print(){
	var frm=document.frm
	//check setting
	var response = '';
	$.ajax({
	type: "POST",
	url: "/salary/chksetting/",
	data: "yearmonth="+ document.getElementById("year").value+'/'+document.getElementById("month").value,
	async: false,
	success: function(html){
		 response = html;
	}
	});		

	if (response=="1"){
		alert("Salary setting has not been set for the ["+document.getElementById("year").value+'/'+document.getElementById("month").value+"]");
		return false;
	}		
	
	location.href="/salary/?print=payslip&staff_id="+document.getElementById("staff_id").value+"&yearmonth="+document.getElementById("year").value+'/'+document.getElementById("month").value+"&b={/literal}{php}echo urlencode($_SERVER['REQUEST_URI']);{/php}{literal}";
	//frm.ac.value=3;
	//frm.submit();

}


</script>
{/literal}