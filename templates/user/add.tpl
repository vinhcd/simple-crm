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
     <h1>Add new user</h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="/user/">User list</a></li>
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
                  <label for="inputEmail3" class="col-sm-2 control-label">Role</label>
                  <div class="col-sm-6">
					<input type="radio" name="role" value="1" checked="checked">
					User&nbsp;&nbsp;
			
					<input type="radio" name="role" value="2">
					Admin
				  </div>
                </div>			   


			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Staff ID</label>
                  <div class="col-sm-6"><input name="staff_id" type="text" id="staff_id" size="30" autocomplete="off" class="form-control"/></div>
                </div>


			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Time Machine ID</label>
                  <div class="col-sm-6"><input name="id_timesheet_machine" type="text" id="id_timesheet_machine" size="30" autocomplete="off" class="form-control"/></div>
                </div>

			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">First Name</label>
                  <div class="col-sm-6"><input name="first_name" type="text" id="first_name" size="30" autocomplete="off" class="form-control"/></div>
                </div>

			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Last Name</label>
                  <div class="col-sm-6"><input name="last_name" type="text" id="last_name" size="30" autocomplete="off" class="form-control"/></div>
                </div>
				
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Birthday</label>
                  <div class="col-sm-6"> <div class="col-sm-2" style="padding:0px"><input name="birthday" type="text" id="birthday" size="30" autocomplete="off" class="form-control" style="width:100px"/></div> <div class="col-sm-6" style=" padding-top:5px;"> YYYY/MM/DD</div></div>
                </div>
								
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-6"><input name="email" type="text" id="email" size="30" autocomplete="off" class="form-control"/></div>
                </div>
				
				
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Position</label>
                  <div class="col-sm-6">
					<select class="form-control select2" style="width: 100%;" name="position_id" id="project_id">
					<option value=""></option>
					{foreach from=$position item=position_v}
					<option value="{$position_v.id}">{$position_v.name}</option>
					{/foreach}
					</select>				  
				  </div>
                </div>
								
				
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Password</label>
                  <div class="col-sm-6"><input name="pw" type="password" id="pw" autocomplete="off" class="form-control"></div>
                </div>
				
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Cofirm password</label>
                  <div class="col-sm-6"><input name="pw2" type="password" id="pw2" autocomplete="off" class="form-control"></div>
                </div>
				
				
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Slack ID</label>
                  <div class="col-sm-6"><input name="slack_id" type="text" id="slack_id" size="30" autocomplete="off" class="form-control"/></div>
                </div>
								
				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Join project</label>
                  <div class="col-sm-8">
				  <div class="col-sm-10" style="padding:0">
					<table id="example1" class="table table-bordered table-striped">
					<tr>
					<th>Name</th>
					<th style="width:100px">From date</th>
					<th style="width:100px">Finish date</th>
					<th style="width:50px"></th>
					</tr>
					{foreach from=$project item=project_v}
					<tr{if $project_v.valid eq 1} bgcolor="#FF0000"{/if}>
					<td>{$project_v.id}/{$project_v.name}</td>
					<td>{php}echo date("Y/m",$this->_tpl_vars["project_v"]["start_date"]);{/php} </td>
					<td>{php}echo date("Y/m",$this->_tpl_vars["project_v"]["finish_date"]);{/php} </td>
					<td align="center"><input type="checkbox" value="{$project_v.id}" name="project_list[]"/></td>
					</tr>
					{/foreach}
					</table>	
				  </div> 	
				  </div>
                </div>	
				

		</div>
		</div>




		<div class="box box-info with-border">
		
			<div class="box-header with-border">
			  <h3 class="box-title">Ngân hàng</h3>
			</div>
					
			<!-- form start -->
			<div class="box-body">
		
				<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Tên ngân hàng</label>
				<div class="col-sm-6"><input name="bank_name" type="text" id="bank_name" autocomplete="off" class="form-control"/></div>
				</div>
		
				<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Chi nhánh</label>
				<div class="col-sm-6"><input name="bank_branch" type="text" id="bank_branch" autocomplete="off" class="form-control"/></div>
				</div>
		
				<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Tên người hưởng thụ</label>
				<div class="col-sm-6"><input name="bank_huongthu" type="text" id="bank_huongthu" autocomplete="off" class="form-control"/></div>
				</div>
	
	
				<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Số tài khoản</label>
				<div class="col-sm-6"><input name="bank_number" type="text" id="bank_number" autocomplete="off" class="form-control"/></div>			
				</div>
	

						
			</div><!-- /.box-body -->
		</div>			






		<div class="box box-info with-border">
		
			<div class="box-header with-border">
			  <h3 class="box-title">Personal salary setting</h3>
			</div>
					
			<!-- form start -->
			<div class="box-body">
		

			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Hợp đồng</label>
                  <div class="col-sm-6"><input type="radio" name="loaihopdong" value="1" checked="checked">Thử việc&nbsp;&nbsp;&nbsp;<input type="radio" name="loaihopdong" value="2">Chính thức</div>
                </div>

			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Ngày vào công ty</label>
                  <div class="col-sm-6"><input name="join_date" type="text" id="join_date" size="30" autocomplete="off" class="form-control" style="width:100px"/></div>
                </div>


			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Ngày hợp đồng chính thức</label>
                  <div class="col-sm-6"><input name="ngayhopdongchinhthuc" type="text" id="ngayhopdongchinhthuc" size="30" autocomplete="off" class="form-control" style="width:100px"/></div>
                </div>

		
				<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Lương cơ bản</label>
				<div class="col-sm-6"><input name="luong_luongcoban" type="text" id="luong_luongcoban" autocomplete="off" class="form-control" onKeyUp="salepricef(this);"/></div>
				</div>
		
				<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Số người phụ thuộc</label>
				<div class="col-sm-6"><input name="luong_songuoiphuthuoc" type="text" id="luong_songuoiphuthuoc" autocomplete="off" class="form-control"/></div>
				</div>
		
				<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Trợ cấp đi lại</label>
				<div class="col-sm-6"><input name="luong_trocapdilai" type="text" id="luong_trocapdilai" autocomplete="off" class="form-control" onKeyUp="salepricef(this);"/></div>
				</div>
	
	
				<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Trợ cấp tiếng Nhật</label>
				<div class="col-sm-6"><input name="luong_trocaptiengnhat" type="text" id="luong_trocaptiengnhat" autocomplete="off" class="form-control" onKeyUp="salepricef(this);"/></div>			
				</div>
	
				<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Trợ cấp liên lạc</label>
				<div class="col-sm-6"><input name="luong_trocaplienlac" type="text" id="luong_trocaplienlac" autocomplete="off" class="form-control" onKeyUp="salepricef(this);"/></div>	
				</div>
				
				<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Trợ cấp gửi xe</label>
				<div class="col-sm-6"><input name="luong_trocapguixe" type="text" id="luong_trocapguixe" autocomplete="off" class="form-control" onKeyUp="salepricef(this);"/></div>								
				</div>


				<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Phụ cấp trách nhiệm</label>
				<div class="col-sm-6"><input name="luong_trocaptrachnhiem" type="text" id="luong_trocaptrachnhiem" autocomplete="off" class="form-control" onKeyUp="salepricef(this);"/></div>								
				</div>			
	
	
				<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Trợ cấp ăn trưa</label>
				<div class="col-sm-6"><input name="luong_trocapantrua" type="text" id="luong_trocapantrua" autocomplete="off" class="form-control" onKeyUp="salepricef(this);"/></div>								
				</div>	
						
			</div><!-- /.box-body -->
		</div>			
		
				
		</form>

		
		<div class="box-footer">
		<button type="button" class="btn btn-info2" onClick="add();">Lưu lại</button>
		
		<button type="button" class="btn btn-default" onClick="location.href='/user/';">Đóng lại</button>
		</div>
		<!-- /.box-footer -->

		
		


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
<script type="text/javascript">
<!--

$(function () {
 //Initialize Select2 Elements
$('.select2').select2();
})


$("#join_date").datepicker({ dateFormat: "yy/mm/dd"});
$("#join_date").datepicker("setDate", "{/literal}{php}echo date("Y/m/d");{/php}{literal}");

$("#birthday").datepicker({ dateFormat: "yy/mm/dd"});

$("#ngayhopdongchinhthuc").datepicker({ dateFormat: "yy/mm/dd"});


function add(){
	var alphaExp1 = /^[a-z0-9]+$/;
	
	var frm=document.frm;

	if (frm.staff_id.value==""){
		alert("[Staff ID] is not empty");
		return false;
	}

	if (frm.id_timesheet_machine.value==""){
		alert("[Time Machine ID] is not empty");
		return false;
	}
	
	if (frm.first_name.value==""){
		alert("[First Name] is not empty");
		return false;
	}


	if (frm.last_name.value==""){
		alert("[Last Name] is not empty");
		return false;
	}




	if (frm.email.value==""){
		alert("[Email] is not empty");
		return false;
	}
	
	
	if (frm.position_id.value==""){
		alert("[position_id] is not empty");
		return false;
	}

	
	
	var response = '';
	$.ajax({
	type: "POST",
	url: "/user/staffid/",
	data: "staff_id="+frm.staff_id.value,
	async: false,
	success: function(html){
		 response = html;
	}
	});		

	if (response=="1"){
		alert("["+frm.staff_id.value+"] already exists");
		return false;
	}		


	var response = '';
	$.ajax({
	type: "POST",
	url: "/user/checkemail/",
	data: "email="+frm.email.value,
	async: false,
	success: function(html){
		 response = html;
	}
	});		

	if (response=="1"){
		alert("["+frm.email.value+"] already exists");
		return false;
	}		
	
	

	if (frm.pw.value==""){
		alert("[Pasword] is not empty");
		return false;
	}	

	if (frm.pw2.value!=frm.pw.value){
		alert("Password does not match the confirm password.");
		return false;
	}	
	
	if (frm.slack_id.value==""){
		alert("[Slack ID] is not empty");
		return false;
	}	
		
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