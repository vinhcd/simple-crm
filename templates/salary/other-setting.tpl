{include file='header.tpl'}
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
{include file='header_content.tpl'}
<script src="/js/function.js"></script>
{include file='menu.tpl'}

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1>Other setting</h1>
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
                  <label for="inputEmail3" class="col-sm-4 control-label">Salary month</label>
                  <div class="col-sm-6">

				<select name="year" id="year" disabled="disabled"><br>
					{php}
					$year_a=explode("/",$_GET["yearmonth"]);
					for ($i=2018;$i<date("Y")+2;$i++){
					{/php}
					<option value="{php}echo $i;{/php}"{php}echo ($i==$year_a[0])?' selected="selected"':''{/php}>{php}echo $i;{/php}</option>>
					{php}
					}
					{/php} 
				</select>


				  <select name="month" id="month" disabled="disabled">
					{php}
					for ($i=1;$i<13;$i++){
					{/php}
					<option value="{php}echo sprintf("%02d", $i);{/php}"{php}echo (sprintf("%02d", $i)==$year_a[1])?' selected="selected"':''{/php}>{php}echo sprintf("%02d", $i);{/php}</option>>
					{php}
					}
					{/php} 	
				  </select>
				</div>
                </div>
				

				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Số ngày phép đầu kỳ(đv: giờ)
</label>
                  <div class="col-sm-6"><input name="luong_phepdauky" type="text" id="luong_phepdauky" autocomplete="off" class="form-control" value="{$salary_personal_setting_one.luong_phepdauky}"/></div>
                </div>	
								

				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Quyết toán ngày phép còn lại trong năm(đv: giờ)
</label>
                  <div class="col-sm-6"><input name="luong_quyettoanconlaitrongnam" type="text" id="luong_quyettoanconlaitrongnam" autocomplete="off" class="form-control" value="{$salary_personal_setting_one.luong_quyettoanconlaitrongnam}" onKeyUp="salepricef(this);"/></div>
                </div>						

				
			
				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Tiền chúc mừng / chia buồn
</label>
                  <div class="col-sm-6"><input name="luong_tienchucmungchiabuon" type="text" id="luong_tienchucmungchiabuon" autocomplete="off" class="form-control" value="{if $salary_personal_setting_one.luong_tienchucmungchiabuon>0}{$salary_personal_setting_one.luong_tienchucmungchiabuon|number_format}{/if}" onKeyUp="salepricef(this);"/></div>
                </div>						


				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Điều chỉnh (Trước tổng lương)</label>
                  <div class="col-sm-6"><input name="luong_dieuchinhtruoctongluong" type="text" id="luong_dieuchinhtruoctongluong" autocomplete="off" class="form-control" value="{if $salary_personal_setting_one.luong_dieuchinhtruoctongluong>0}{$salary_personal_setting_one.luong_dieuchinhtruoctongluong|number_format}{/if}" onKeyUp="salepricef(this);"/></div>
                </div>	



				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Số giờ nghỉ phép, nghỉ bù (đặc biệt)</label>
                  <div class="col-sm-6"><input name="luong_sogionghiphepnghibu" type="text" id="luong_sogionghiphepnghibu" autocomplete="off" class="form-control" value="{if $salary_personal_setting_one.luong_sogionghiphepnghibu>0}{$salary_personal_setting_one.luong_sogionghiphepnghibu|number_format}{/if}"/></div>
                </div>	



				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Thu nhập khác</label>
                  <div class="col-sm-6"><input name="luong_thunhapkhac" type="text" id="luong_thunhapkhac" autocomplete="off" class="form-control" value="{if $salary_personal_setting_one.luong_thunhapkhac>0}{$salary_personal_setting_one.luong_thunhapkhac|number_format}{/if}" onKeyUp="salepricef(this);"/></div>
                </div>	


				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Tháng lương thứ 13 (thưởng)</label>
                  <div class="col-sm-6"><input name="luong_thangluongthu13" type="text" id="luong_thangluongthu13" autocomplete="off" class="form-control" value="{if $salary_personal_setting_one.luong_thangluongthu13>0}{$salary_personal_setting_one.luong_thangluongthu13|number_format}{/if}" onKeyUp="salepricef(this);"/></div>
                </div>	


				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Trợ cấp bảo hiểm từ Bảo hiểm xã hội/Trả thuế nộp thừa
</label>
                  <div class="col-sm-6"><input name="luong_trocapbaohiem_trathuenopthua" type="text" id="luong_trocapbaohiem_trathuenopthua" autocomplete="off" class="form-control" value="{if $salary_personal_setting_one.luong_trocapbaohiem_trathuenopthua>0}{$salary_personal_setting_one.luong_trocapbaohiem_trathuenopthua|number_format}{/if}" onKeyUp="salepricef(this);"/></div>
                </div>	

				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Tháng trước chuyển sang
</label>
                  <div class="col-sm-6"><input name="luong_thangtruocchuyenqua" type="text" id="luong_thangtruocchuyenqua" autocomplete="off" class="form-control" value="{if $salary_personal_setting_one.luong_thangtruocchuyenqua>0}{$salary_personal_setting_one.luong_thangtruocchuyenqua|number_format}{/if}" onKeyUp="salepricef(this);"/></div>
                </div>	




			</div>
			</div>
		
	
	
			
			
				
				
		</form>

		<!-- /.box-body -->
		<div class="box-footer">
			<button type="button" class="btn btn-info2" onClick="save();">Save</button>
			<button type="button" class="btn btn-default" onClick="location.href='/salary/setting/?yearmonth={$smarty.get.yearmonth}';">Đóng lại</button>
		</div>
		<!-- /.box-footer -->

	
		


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
	var frm=document.frm;
	frm.ac.value=1;
	frm.submit();	
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