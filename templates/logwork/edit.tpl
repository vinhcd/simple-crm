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
     <h1>Edit user</h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="/logwork/">User list</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	<form method="post" name="frm" class="form-horizontal">
	<input type="hidden" name="ac" />
	<input type="hidden" name="staff_id" value="{$staff_one.id}" />
		
          <div class="box box-info with-border">

            <!-- form start -->
              <div class="box-body">
  
 			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Actived</label>
                  <div class="col-sm-6"><input type="checkbox" name="valid" {if $staff_one.valid eq 0}checked="checked"{/if}></div>
                </div>
				
				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Role</label>
                  <div class="col-sm-6">
	    
        <input type="radio" name="role" value="1"{if $staff_one.role eq 1}checked="checked"{/if}>
        User&nbsp;&nbsp;

        <input type="radio" name="role" value="2"{if $staff_one.role eq 2}checked="checked"{/if}>
        Admin
				  </div>
                </div>
				
				
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Staff ID</label>
                  <div class="col-sm-6"><input  type="text" size="30" autocomplete="off" class="form-control" value="{$staff_one.id}" disabled="disabled"/></div>
                </div>


			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Time Machine ID</label>
                  <div class="col-sm-6"><input name="id_timesheet_machine" type="text" id="id_timesheet_machine" size="30" autocomplete="off" class="form-control" value="{$staff_one.id_timesheet_machine}"/></div>
                </div>
				

			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">First Name</label>
                  <div class="col-sm-6"><input name="first_name" type="text" id="first_name" size="30" autocomplete="off" class="form-control" value="{$staff_one.first_name}"/></div>
                </div>

			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Last Name</label>
                  <div class="col-sm-6"><input name="last_name" type="text" id="last_name" size="30" autocomplete="off" class="form-control" value="{$staff_one.last_name}"/></div>
                </div>
				
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-6"><input size="30" autocomplete="off" class="form-control" value="{$staff_one.email}" disabled="disabled"/></div>
                </div>
				
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Password</label>
                  <div class="col-sm-6">
				  
				  <div><input name="pw" type="password" id="pw" autocomplete="off" class="form-control"></div>
				  <div><span style="color:#FF0000">(leave blank if you don't want to change it)</span></div>
				  
				  </div>
                </div>
				
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Confirm password</label>
                  <div class="col-sm-6"><input name="pw2" type="password" id="pw2" autocomplete="off" class="form-control"></div>
                </div>
				
				
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Slack ID</label>
                  <div class="col-sm-6"><input name="slack_id" type="text" id="slack_id" size="30" autocomplete="off" class="form-control" value="{$staff_one.slack_id}"/></div>
                </div>

				
				<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Join project</label>
                  <div class="col-sm-8">
					<table id="example1" class="table table-bordered table-striped">
					<tr>
					<th width="20px">Name</th>
					<th width="150px">From date</th>
					<th width="100px">Finish date</th>
					<th></th>					</tr>
					{foreach from=$project item=project_v}
					<tr{if $project_v.valid eq 1} bgcolor="#FF0000"{/if}>
					<td>{$project_v.id}/{$project_v.name}</td>
					<td>{php}echo date("Y/m",$this->_tpl_vars["project_v"]["start_date"]);{/php} </td>
					<td>{php}echo date("Y/m",$this->_tpl_vars["project_v"]["finish_date"]);{/php} </td>
					<td align="center"><input type="checkbox" value="{$project_v.id}" name="project_list[]"{if $project_v.id|in_array:$staff_project}  checked="checked"{/if}/></td>
					</tr>
					{/foreach}
					</table>	

				  </div>
                </div>			
		</form>

		<!-- /.box-body -->
		<div class="box-footer">
		<button type="button" class="btn btn-info2" onClick="update();">Save</button>
		
		<button type="button" class="btn btn-default" onClick="location.href='/logwork/';">Close</button>
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

function disableAll(chkname,chkname2) 
{
//alert(chkname);

	checkboxes = jQuery("[name='"+chkname+"']");
    for(var i in checkboxes){
		if (document.getElementById(chkname2).checked){
			checkboxes[i].checked = true;
		}else{
			checkboxes[i].checked = false;
		}
    }

}


function update(){
	var frm=document.frm;

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


	if (frm.pw.value!='' && frm.pw2.value!=frm.pw.value){
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
-->
</script>
{/literal}