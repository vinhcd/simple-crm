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
    	<h1>Working time edit</h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="/worktime/">Time sheet managment</a></li>
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
                  <label for="inputEmail3" class="col-sm-2 control-label">Staff</label>

                  <div class="col-sm-6">
					<select name="staff_id" id="staff_id" class="form-control">
					<option value=""></option>
					{foreach from=$staff item=staff_v}		
					<option value="{$staff_v.id}"{if $staff_v.id eq $woking_time_one.staff_id} selected="selected"{/if}>{$staff_v.id}/{$staff_v.first_name} {$staff_v.last_name}</option>
					{/foreach}
					</select>
                  </div>
                </div>
				
				
							   
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">From hour</label>

                  <div class="col-sm-6"> 
				  
					Date:&nbsp;<input type="text" name="start_time" id="start_time" style="width:70px">
					Hour:&nbsp;<select name="start_time_hour">
					{php}for ($i=0;$i<24;$i++):{/php}
					<option value="{php}echo $i;{/php}"{php}if($i==date("G",strtotime($this->_tpl_vars["woking_time_one"]["check_in"]))):echo" selected";endif;{/php}>{php}echo $i;{/php}</option>
					{php}endfor;{/php}
					</select>
					Minute:&nbsp;<select name="start_time_minute">
					{php}for ($i=0;$i<61;$i++):{/php}
					<option value="{php}echo $i;{/php}"{php}if($i==(int)date("i",strtotime($this->_tpl_vars["woking_time_one"]["check_in"]))):echo" selected";endif;{/php}>{php}echo $i;{/php}</option>
					{php}endfor;{/php}
					</select>
	
	
                  </div>
                </div>
				
				
			   <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">To hour</label>
					<div class="col-sm-6"> 
					Date:&nbsp;<input type="text" name="finish_time" id="finish_time" style="width:70px">
					Hour:&nbsp;<select name="finish_time_hour">
					{php}for ($i=0;$i<24;$i++):{/php}
					<option value="{php}echo $i;{/php}"{php}if($i==date("G",strtotime($this->_tpl_vars["woking_time_one"]["check_out"]))):echo" selected";endif;{/php}>{php}echo $i;{/php}</option>
					{php}endfor;{/php}
					</select>
					Minute:&nbsp;<select name="finish_time_minute">
					{php}for ($i=0;$i<61;$i++):{/php}
					<option value="{php}echo $i;{/php}"{php}if($i==(int)date("i",strtotime($this->_tpl_vars["woking_time_one"]["check_out"]))):echo" selected";endif;{/php}>{php}echo $i;{/php}</option>
					{php}endfor;{/php}
					</select>		
                  </div>
                </div>	
				
			 
			 
		</form>

		<!-- /.box-body -->
		<div class="box-footer">
		<button type="button" class="btn btn-info2" onClick="edit();">Save</button>
		
		<button type="button" class="btn btn-default" onClick="location.href='{$smarty.get.back|urldecode}';">Close</button>
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


$('#start_time').datetimepicker({
	lang:'en',
	timepicker:false,
	format:'Y/m/d',
	formatDate:'Y/m/d',
	value:'{/literal}{php}echo date("d/m/Y",strtotime($this->_tpl_vars["woking_time_one"]["start_time"])); {/php}{literal}'
});


$('#finish_time').datetimepicker({
	lang:'en',
	timepicker:false,
	format:'Y/m/d',
	formatDate:'Y/m/d',
	value:'{/literal}{php}if ($this->_tpl_vars["woking_time_one"]["finish_time"]!='0000-00-00 00:00:00') echo date("d/m/Y",strtotime($this->_tpl_vars["woking_time_one"]["finish_time"])); else echo date("d/m/Y",strtotime($this->_tpl_vars["woking_time_one"]["start_time"]));{/php}{literal}'
});




function edit(){
	var frm=document.frm;
	if (frm.staff_id.value==""){
		alert("[Staff] is not empty");
		return false;
	}
	if (frm.start_time.value==""){
		alert("[From hour] is not empty");
		return false;
	}

	if (frm.start_time.value==""){
		alert("[To hour] is not empty");
		return false;
	}

	frm.ac.value=1;
	frm.submit();
}	






{literal}


-->
</script>
{/literal}