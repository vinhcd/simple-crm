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
<script src="/js/function.js"></script>
{include file='menu.tpl'}

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1>Salary common setting</h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
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
                  <label for="inputEmail3" class="col-sm-2 control-label">Salary month</label>
                  <div class="col-sm-6">

				<select name="year" id="year" onChange="load_project()"><br>
					{php}
					for ($i=2018;$i<date("Y")+2;$i++){
					{/php}
					<option value="{php}echo $i;{/php}"{php}echo ($i==$this->_tpl_vars["current_year"])?' selected="selected"':''{/php}>{php}echo $i;{/php}</option>>
					{php}
					}
					{/php} 
				</select>


				  <select name="month" id="month" onChange="load_project()">
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
				
			
				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Số ngày làm việc</label>
                  <div class="col-sm-6"><input name="luong_songaylamviec" type="text" id="luong_songaylamviec" autocomplete="off" class="form-control"/></div>
                </div>						


				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Lương cơ sở</label>
                  <div class="col-sm-6"><input name="luong_luongcoso" type="text" id="luong_luongcoso" autocomplete="off" class="form-control" onKeyUp="salepricef(this);"/></div>
                </div>	


			</div>
			</div>
		
	
	
			<div class="box box-info with-border">
			
            <div class="box-header with-border">
              <h3 class="box-title">Làm thêm giờ</h3>
            </div>
						
			<!-- form start -->
			<div class="box-body">
			
			
				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Làm thêm ngày thường </label>
                  <div class="col-sm-6"><input name="luong_lamthemngaythuong" type="text" id="luong_lamthemngaythuong" autocomplete="off" class="form-control" value="{$salary_setting_one.luong_lamthemngaythuong}"/></div>
                </div>	
				
				
				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Làm thêm đêm ngày thường</label>
                  <div class="col-sm-6"><input name="luong_lamthemdemngaythuong" type="text" id="luong_lamthemdemngaythuong" autocomplete="off" class="form-control" value="{$salary_setting_one.luong_lamthemdemngaythuong}"/></div>
                </div>	
				
				
				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Làm thêm cuối tuần</label>
                  <div class="col-sm-6"><input name="luong_lamthemcuoituan" type="text" id="luong_lamthemcuoituan" autocomplete="off" class="form-control" value="{$salary_setting_one.luong_lamthemcuoituan}"/></div>
                </div>	
				
				
				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Làm thêm ngày lễ</label>
                  <div class="col-sm-6"><input name="luong_lamthemngayle" type="text" id="luong_lamthemngayle" autocomplete="off" class="form-control" value="{$salary_setting_one.luong_lamthemngayle}"/></div>
                </div>	

			</div>
			</div>		
	
	
	
	
	
	
	
	
	
			<div class="box box-info with-border">
			
            <div class="box-header with-border">
              <h3 class="box-title">Bảo hiểm và chi phí công đoàn công ty chịu</h3>
            </div>
						
			<!-- form start -->
			<div class="box-body">
			
			
				<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Bảo hiểm xã hội</label>
				<div class="col-sm-6"><input name="luong_congtybaohiemxahoi" type="text" id="luong_congtybaohiemxahoi" autocomplete="off" class="form-control" value="{$salary_setting_one.luong_congtybaohiemxahoi}"/></div>
				</div>


				<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Bảo hiểm y tế</label>
				<div class="col-sm-6"><input name="luong_congtybaohiemyte" type="text" id="luong_congtybaohiemyte" autocomplete="off" class="form-control" value="{$salary_setting_one.luong_congtybaohiemyte}"/></div>			
				</div>

				<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Bảo hiểm thất nghiệp</label>
				<div class="col-sm-6"><input name="luong_congtybaohiemthatnghiep" type="text" id="luong_congtybaohiemthatnghiep" autocomplete="off" class="form-control" value="{$salary_setting_one.luong_congtybaohiemthatnghiep}"/></div>	
				</div>
				
				<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Kinh phí công đoàn</label>
				<div class="col-sm-6"><input name="luong_congtykinhphicongdoan" type="text" id="luong_congtykinhphicongdoan" autocomplete="off" class="form-control" value="{$salary_setting_one.luong_congtykinhphicongdoan}"/></div>								
				</div>
				
				
			</div>
			</div>		








			<div class="box box-info with-border">
			
            <div class="box-header with-border">
              <h3 class="box-title">Bảo hiểm và chi phí công đoàn người lao động chịu</h3>
            </div>
						
			<!-- form start -->
			<div class="box-body">
			
			
				<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Bảo hiểm xã hội</label>
				<div class="col-sm-6"><input name="luong_canhanbaohiemxahoi" type="text" id="luong_canhanbaohiemxahoi" autocomplete="off" class="form-control" value="{$salary_setting_one.luong_canhanbaohiemxahoi}"/></div>
				</div>


				<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Bảo hiểm y tế</label>
				<div class="col-sm-6"><input name="luong_canhanbaohiemyte" type="text" id="luong_canhanbaohiemyte" autocomplete="off" class="form-control" value="{$salary_setting_one.luong_canhanbaohiemyte}"/></div>			
				</div>

				<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Bảo hiểm thất nghiệp</label>
				<div class="col-sm-6"><input name="luong_canhanbaohiemthatnghiep" type="text" id="luong_canhanbaohiemthatnghiep" autocomplete="off" class="form-control" value="{$salary_setting_one.luong_canhanbaohiemthatnghiep}"/></div>	
				</div>
				

				
			</div>
			</div>	
			
			
			
			
			<div class="box box-info with-border">
			
            <div class="box-header with-border">
              <h3 class="box-title">Thuế thu nhập</h3>
            </div>
						
			<!-- form start -->
			<div class="box-body">
			
			
				<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Giảm trừ bản thân</label>
				<div class="col-sm-6"><input name="luong_giamtrubanthan" type="text" id="luong_giamtrubanthan" autocomplete="off" class="form-control" onKeyUp="salepricef(this);"/></div>
				</div>

				<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Giảm trừ người phụ thuộc</label>
				<div class="col-sm-6"><input name="luong_giamtrunguoiphuthuoc" type="text" id="luong_giamtrunguoiphuthuoc" autocomplete="off" class="form-control" onKeyUp="salepricef(this);"/></div>
				</div>
				
				
			</div>
			</div>	
			
			
			
			
			
			
				
				
		</form>

		<!-- /.box-body -->
		<div class="box-footer">
			<button type="button" class="btn btn-info2" onClick="save();">Save common setting</button>
			<button type="button" class="btn btn-info2" onClick="copy_setting();">Copy last month common setting for selected current Year/Month</button>
			
			<button type="button" class="btn btn-info2" onClick="personal_setting();">Making personal setting for selected current Year/Month</button>
		</div>
		<!-- /.box-footer -->

		
			<div class="box box-info with-border" style="margin-top:10px">
			
            <div class="box-header with-border">
              <h3 class="box-title">Personal data</h3>
            </div>
						
			<!-- form start -->
			<div class="box-body" style="overflow-x:auto;">
			
			
				<table id="data_table"></table>
				
				
			</div>
			</div>	


		


    </section>
    <!-- /.content -->
  </div>

{include file='footer.tpl'}
</body>
</html>


{literal}
<script type="text/javascript">
<!--


function save(){
	//save data
	$.ajax({
		data: {
			'year_month': document.getElementById("year").value+'/'+document.getElementById("month").value,
			'luong_songaylamviec': document.getElementById("luong_songaylamviec").value,
			'luong_luongcoso': document.getElementById("luong_luongcoso").value,
			'luong_lamthemngaythuong': document.getElementById("luong_lamthemngaythuong").value,
			'luong_lamthemdemngaythuong': document.getElementById("luong_lamthemdemngaythuong").value,
			'luong_lamthemcuoituan': document.getElementById("luong_lamthemcuoituan").value,
			'luong_lamthemngayle': document.getElementById("luong_lamthemngayle").value,
			'luong_congtybaohiemxahoi': document.getElementById("luong_congtybaohiemxahoi").value,
			'luong_congtybaohiemyte': document.getElementById("luong_congtybaohiemyte").value,
			'luong_congtybaohiemthatnghiep': document.getElementById("luong_congtybaohiemthatnghiep").value,
			'luong_congtykinhphicongdoan': document.getElementById("luong_congtykinhphicongdoan").value,
			'luong_canhanbaohiemxahoi': document.getElementById("luong_canhanbaohiemxahoi").value,
			'luong_canhanbaohiemyte': document.getElementById("luong_canhanbaohiemyte").value,
			'luong_canhanbaohiemthatnghiep': document.getElementById("luong_canhanbaohiemthatnghiep").value,
			'luong_giamtrubanthan': document.getElementById("luong_giamtrubanthan").value,
			'luong_giamtrunguoiphuthuoc': document.getElementById("luong_giamtrunguoiphuthuoc").value,
		},
		type: 'POST',
		url: "/salary/save/",
		cache: false,
		success: function(response){
		//alert(response);
		
			if (response=="ok"){
				alert("Save successfully");
			}else{
				alert("Error: Check your data again!");
			}
		}
	});		
	
}	



function copy_setting(){
	//save data
	$.ajax({
		data: {
			'year_month': document.getElementById("year").value+'/'+document.getElementById("month").value,
		},
		type: 'POST',
		url: "/salary/copy/",
		cache: false,
		success: function(response){
		//alert(response);
		
			if (response=="ok"){
				alert("Copy successfully");
				load_project();
			}else if(response=="err1"){
				alert("Error: Not existed last month setting");
			}else{
				alert("Error");
			}
		}
	});		
	
}


function personal_setting(){
	//save data
	$.ajax({
		data: {
			'year_month': document.getElementById("year").value+'/'+document.getElementById("month").value,
		},
		type: 'POST',
		url: "/salary/personalsetting/",
		cache: false,
		success: function(response){
		//alert(response);
		
			if (response=="ok"){
				alert("Making successfully");
				load_project();
			}else{
				alert("Error");
			}
		}
	});		
	
}

load_project();

function load_project(){
	
	document.getElementById("luong_songaylamviec").value="";
	document.getElementById("luong_luongcoso").value="";
	document.getElementById("luong_lamthemngaythuong").value="";
	document.getElementById("luong_lamthemdemngaythuong").value="";
	document.getElementById("luong_lamthemcuoituan").value="";
	document.getElementById("luong_lamthemngayle").value="";
	document.getElementById("luong_congtybaohiemxahoi").value="";
	document.getElementById("luong_congtybaohiemyte").value="";
	document.getElementById("luong_congtybaohiemthatnghiep").value="";
	document.getElementById("luong_congtykinhphicongdoan").value="";
	document.getElementById("luong_canhanbaohiemxahoi").value="";
	document.getElementById("luong_canhanbaohiemyte").value="";
	document.getElementById("luong_canhanbaohiemthatnghiep").value="";
	document.getElementById("luong_giamtrubanthan").value="";
	document.getElementById("luong_giamtrunguoiphuthuoc").value="";
	$("#data_table").empty();
	
	$.ajax({
		data: {
			'year_month': document.getElementById("year").value+'/'+document.getElementById("month").value
		},		
		type: 'POST',
		url: "/salary/loadsetting/",
		cache: false,
		dataType : "json",
		success: function(response){	
			if (response.luong_songaylamviec!=undefined) document.getElementById("luong_songaylamviec").value=response.luong_songaylamviec;
			if (response.luong_luongcoso!=undefined) document.getElementById("luong_luongcoso").value=formatMoney(response.luong_luongcoso);
			if (response.luong_lamthemngaythuong!=undefined) document.getElementById("luong_lamthemngaythuong").value=response.luong_lamthemngaythuong;
			if (response.luong_lamthemdemngaythuong!=undefined) document.getElementById("luong_lamthemdemngaythuong").value=response.luong_lamthemdemngaythuong;
			if (response.luong_lamthemcuoituan!=undefined) document.getElementById("luong_lamthemcuoituan").value=response.luong_lamthemcuoituan;
			if (response.luong_lamthemngayle!=undefined) document.getElementById("luong_lamthemngayle").value=response.luong_lamthemngayle;
			if (response.luong_congtybaohiemxahoi!=undefined) document.getElementById("luong_congtybaohiemxahoi").value=response.luong_congtybaohiemxahoi;
			if (response.luong_congtybaohiemyte!=undefined) document.getElementById("luong_congtybaohiemyte").value=response.luong_congtybaohiemyte;
			if (response.luong_congtybaohiemthatnghiep!=undefined) document.getElementById("luong_congtybaohiemthatnghiep").value=response.luong_congtybaohiemthatnghiep;
			if (response.luong_congtykinhphicongdoan!=undefined) document.getElementById("luong_congtykinhphicongdoan").value=response.luong_congtykinhphicongdoan;
			if (response.luong_canhanbaohiemxahoi!=undefined) document.getElementById("luong_canhanbaohiemxahoi").value=response.luong_canhanbaohiemxahoi;
			if (response.luong_canhanbaohiemyte!=undefined) document.getElementById("luong_canhanbaohiemyte").value=response.luong_canhanbaohiemyte;
			if (response.luong_canhanbaohiemthatnghiep!=undefined) document.getElementById("luong_canhanbaohiemthatnghiep").value=response.luong_canhanbaohiemthatnghiep;
			if (response.luong_giamtrubanthan!=undefined) document.getElementById("luong_giamtrubanthan").value=formatMoney(response.luong_giamtrubanthan);
			if (response.luong_giamtrunguoiphuthuoc!=undefined) document.getElementById("luong_giamtrunguoiphuthuoc").value=formatMoney(response.luong_giamtrunguoiphuthuoc);
			
			
			
			$('#data_table').append('<tr><th></th><th>Mã NV</th><th>Họ & tên</th><th>Lương cơ bản</th><th>Phụ thuộc</th><th>Trợ cấp đi lại</th><th>Trợ cấp tiếng Nhật</th><th>Trợ cấp liên lạc</th><th>Trợ cấp gửi xe</th><th>Trợ cấp trách nhiệm</th><th>Trợ cấp ăn trưa</th><th>WH</th><th>OT1</th><th>OT2</th><th>OT3</th><th>OT4</th><th>Quyết toán ngày phép còn lại trong năm<br>有給残日数支払</th><th>Tiền chúc mừng / chia buồn<br>慶弔・見舞金</th><th>Điều chỉnh (Trước tổng lương)<br>その他調整（実際給与に関係する</th><th>Số giờ nghỉ phép, nghỉ bù (đặc biệt)<br>その他休み</th><th>Thu nhập khác<br>その他収入</th><th>Tháng lương thứ 13 (thưởng)<br>ボーナス</th></tr>');
	
	
	


			if (response.product!=undefined)
			for(var i=0;i<response.product.length;i++)
			{
		
				var luong_songuoiphuthuoc='';
				if (response.product[i].luong_songuoiphuthuoc!=null) luong_songuoiphuthuoc=response.product[i].luong_songuoiphuthuoc;
				
				var luong_luongcoban='';
				if (response.product[i].luong_luongcoban!=null) luong_luongcoban=formatMoney(response.product[i].luong_luongcoban);
				

				var luong_trocapdilai='';
				if (response.product[i].luong_trocapdilai!=null) luong_trocapdilai=formatMoney(response.product[i].luong_trocapdilai);


				var luong_trocaptiengnhat='';
				if (response.product[i].luong_trocaptiengnhat!=null) luong_trocaptiengnhat=formatMoney(response.product[i].luong_trocaptiengnhat);


				var luong_trocaplienlac='';
				if (response.product[i].luong_trocaplienlac!=null) luong_trocaplienlac=formatMoney(response.product[i].luong_trocaplienlac);


				var luong_trocapguixe='';
				if (response.product[i].luong_trocapguixe!=null) luong_trocapguixe=formatMoney(response.product[i].luong_trocapguixe);


				var luong_trocaptrachnhiem='';
				if (response.product[i].luong_trocaptrachnhiem!=null) luong_trocaptrachnhiem=formatMoney(response.product[i].luong_trocaptrachnhiem);


				var luong_trocapantrua='';
				if (response.product[i].luong_trocapantrua!=null) luong_trocapantrua=formatMoney(response.product[i].luong_trocapantrua);
				


				var work_hours='';
				if (response.product[i].work_hours!=null) work_hours=response.product[i].work_hours;


				var ot1='';
				if (response.product[i].ot1!=null) ot1=response.product[i].ot1;


				var ot2='';
				if (response.product[i].ot2!=null) ot2=response.product[i].ot2;


				var ot3='';
				if (response.product[i].ot3!=null) ot3=response.product[i].ot3;


				var ot4='';
				if (response.product[i].ot4!=null) ot4=response.product[i].ot4;

				var luong_quyettoanconlaitrongnam='';
				if (response.product[i].luong_quyettoanconlaitrongnam!=null) luong_quyettoanconlaitrongnam=response.product[i].luong_quyettoanconlaitrongnam;


				var luong_tienchucmungchiabuon='';
				if (response.product[i].luong_tienchucmungchiabuon!=null) luong_tienchucmungchiabuon=formatMoney(response.product[i].luong_tienchucmungchiabuon);


				var luong_dieuchinhtruoctongluong='';
				if (response.product[i].luong_dieuchinhtruoctongluong!=null) luong_dieuchinhtruoctongluong=formatMoney(response.product[i].luong_dieuchinhtruoctongluong);


				var luong_sogionghiphepnghibu='';
				if (response.product[i].luong_sogionghiphepnghibu!=null) luong_sogionghiphepnghibu=response.product[i].luong_sogionghiphepnghibu;


				var luong_thunhapkhac='';
				if (response.product[i].luong_thunhapkhac!=null) luong_thunhapkhac=formatMoney(response.product[i].luong_thunhapkhac);


				var luong_thangluongthu13='';
				if (response.product[i].luong_thangluongthu13!=null) luong_thangluongthu13=formatMoney(response.product[i].luong_thangluongthu13);

				
				$('#data_table').append('<tr><td><input type="button" value="Other setting" onclick="location.href=\'/salary/other-setting/?staff_id='+response.product[i].staff_id+'&yearmonth='+response.product[i].yearmonth+'\'"></td><td>' + response.product[i].staff_id+'</td><td>' + response.product[i].first_name+' '+response.product[i].last_name+'</td><td>'+luong_luongcoban+'</td><td>'+luong_songuoiphuthuoc+'</td><td>'+luong_trocapdilai+'</td><td>'+luong_trocaptiengnhat+'</td><td>'+luong_trocaplienlac+'</td><td>'+luong_trocapguixe+'</td><td>'+luong_trocaptrachnhiem+'</td><td>'+luong_trocapantrua+'</td><td>'+work_hours+'</td><td>'+ot1+'</td><td>'+ot2+'</td><td>'+ot3+'</td><td>'+ot4+'</td><td>'+luong_quyettoanconlaitrongnam+'</td><td>'+luong_tienchucmungchiabuon+'</td><td>'+luong_dieuchinhtruoctongluong+'</td><td>'+luong_sogionghiphepnghibu+'</td><td>'+luong_thunhapkhac+'</td><td>'+luong_thangluongthu13+'</td></tr>');
			
	
			}
			
			
			
			
		}
	});

	
	
}

function salepricef(vl){
	if (vl.value!="" && !IsNumeric(vl.value.replace( /\,/g, ""))){
		alert("Invalid data");
		vl.value="";
		//return;
	}
	autocomma(vl)
}

-->
</script>
{/literal}