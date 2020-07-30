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
    <h1>Thêm tiền thưởng cho nhân viên</h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="/supplier/">Nhà cung cấp</a></li>
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
                  <label for="inputEmail3" class="col-sm-2 control-label">Nhân viên</label>

                  <div class="col-sm-6">
					<select name="staffid" id="staffid" class="form-control">
					<option value=""></option>
					{foreach from=$store_staff item=staff_v}		
					<option value="{$staff_v.staffid}">{$staff_v.staffid} {$staff_v.staff_name}</option>
					{/foreach}
					</select>
                  </div>
                </div>
				
							   
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Số tiền</label>

                  <div class="col-sm-6"> <input name="amount" type="text" id="amount" size="60" class="form-control"/>
                  </div>
                </div>
				
				
			   <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Lý do</label>

                  <div class="col-sm-6">
					<select name="bonus_reason" class="form-control">
					<option value=""></option>
					{foreach from=$bonus_reason item=bonus_reason_v}
					<option value="{$bonus_reason_v.id}">{$bonus_reason_v.name}</option>
					{/foreach}
					</select>	
                  </div>
                </div>	
				
					
			   <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Thêm vào lương tháng</label>

                  <div class="col-sm-6">
					<select name="bonus_month" class="form-control">
						<option value="01/{$smarty.now|date_format:"%Y"}"{if $smarty.now|date_format:"%m/%Y" eq $smarty.now|date_format:"01/%Y"} selected="selected"{/if}>01-{$smarty.now|date_format:"%Y"}</option>
						<option value="02/{$smarty.now|date_format:"%Y"}"{if $smarty.now|date_format:"%m/%Y" eq $smarty.now|date_format:"02/%Y"} selected="selected"{/if}>02-{$smarty.now|date_format:"%Y"}</option>
						<option value="03/{$smarty.now|date_format:"%Y"}"{if $smarty.now|date_format:"%m/%Y" eq $smarty.now|date_format:"03/%Y"} selected="selected"{/if}>03-{$smarty.now|date_format:"%Y"}</option>
						<option value="04/{$smarty.now|date_format:"%Y"}"{if $smarty.now|date_format:"%m/%Y" eq $smarty.now|date_format:"04/%Y"} selected="selected"{/if}>04-{$smarty.now|date_format:"%Y"}</option>
						<option value="05/{$smarty.now|date_format:"%Y"}"{if $smarty.now|date_format:"%m/%Y" eq $smarty.now|date_format:"05/%Y"} selected="selected"{/if}>05-{$smarty.now|date_format:"%Y"}</option>
						<option value="06/{$smarty.now|date_format:"%Y"}"{if $smarty.now|date_format:"%m/%Y" eq $smarty.now|date_format:"06/%Y"} selected="selected"{/if}>06-{$smarty.now|date_format:"%Y"}</option>
						<option value="07/{$smarty.now|date_format:"%Y"}"{if $smarty.now|date_format:"%m/%Y" eq $smarty.now|date_format:"07/%Y"} selected="selected"{/if}>07-{$smarty.now|date_format:"%Y"}</option>
						<option value="08/{$smarty.now|date_format:"%Y"}"{if $smarty.now|date_format:"%m/%Y" eq $smarty.now|date_format:"08/%Y"} selected="selected"{/if}>08-{$smarty.now|date_format:"%Y"}</option>
						<option value="09/{$smarty.now|date_format:"%Y"}"{if $smarty.now|date_format:"%m/%Y" eq $smarty.now|date_format:"09/%Y"} selected="selected"{/if}>09-{$smarty.now|date_format:"%Y"}</option>
						<option value="10/{$smarty.now|date_format:"%Y"}"{if $smarty.now|date_format:"%m/%Y" eq $smarty.now|date_format:"10/%Y"} selected="selected"{/if}>10-{$smarty.now|date_format:"%Y"}</option>
						<option value="11/{$smarty.now|date_format:"%Y"}"{if $smarty.now|date_format:"%m/%Y" eq $smarty.now|date_format:"11/%Y"} selected="selected"{/if}>11-{$smarty.now|date_format:"%Y"}</option>
						<option value="12/{$smarty.now|date_format:"%Y"}"{if $smarty.now|date_format:"%m/%Y" eq $smarty.now|date_format:"12/%Y"} selected="selected"{/if}>12-{$smarty.now|date_format:"%Y"}</option>

					</select>	
                  </div>
                </div>	
			
				
							

			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Ghi chú</label>

                  <div class="col-sm-6">
				 <input name="note" type="text" id="note" size="60" class="form-control"/>
                  </div>
                </div>
	  
			 
		</form>

		<!-- /.box-body -->
		<div class="box-footer">
		<button type="button" class="btn btn-info2" onClick="save();">Lưu lại</button>
		
		<button type="button" class="btn btn-default" onClick="location.href='/worktime/';">Đóng lại</button>
		</div>
		<!-- /.box-footer -->

		
		


    </section>
    <!-- /.content -->
  </div>

{include file='footer.tpl'}
</body>
</html>

{literal}
<script language="javascript">
<!--
function save(){
	var frm=document.frm;
	if (frm.amount.value==""){
		alert("Chưa nhập số tiền");
		return false;
	}

	if (frm.bonus_reason.value==""){
		alert("Chưa chọn [Lý do]");
		return false;
	}

	frm.ac.value=1;
	frm.submit();
}
-->
</script>
{/literal}
