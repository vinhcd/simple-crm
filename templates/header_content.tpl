<header class="main-header">
    <!-- Logo -->
    <a href="/" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>N</b>EOS</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="/images/logo2.png"  alt="" /></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
					
<a href="#" style="padding:5px; margin-top:10px;">
<img src="/images/user2-160x160.png" alt="User Image" class="user-image"/>
<span class="hidden-xs">Welcome: {$staff_name}</span>
</a>
                    </li>
                    <li>
                        <a href="#" data-toggle="modal" data-target="#modal-default" style="padding:5px; margin-top:10px;">
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                            <span>Change password</span>
                        </a>
                    </li>					
                    <li>
                        <a href="/login/logout/" id="logout">
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
    </nav>
  </header>
  
<div class="modal fade" id="modal-default">
  <div class="modal-dialog" >
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title">Change password</h4>
	  </div>
	  <div class="modal-body">
	   <div class="col-xs-12">
				 <div class="row">
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Password</label>
                  <div class="col-sm-6">
				  
				  <div><input name="head_pw" type="password" id="head_pw" autocomplete="off" class="form-control"></div>
				  
				  </div>
                </div>
				</div>
				
				 <div class="row" style="margin-top:5px;">
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Confirm password</label>
                  <div class="col-sm-6"><input name="head_pw2" type="password" id="head_pw2" autocomplete="off" class="form-control"></div>
                </div>
				</div>


	   </div>

		<div class="clearfix"></div>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
		<button type="button" class="btn btn-primary" onclick="change_password();">Change</button>
	  </div>
	</div>
	<!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->  
{literal}
<script language="javascript">
<!--
function change_password(){

	if (document.getElementById("head_pw").value==""){
		alert("[Pasword] is not empty");
		return false;
	}	

	if (document.getElementById("head_pw2").value==""){
		alert("Password does not match the confirm password.");
		return false;
	}	

	if (document.getElementById("head_pw").value.length<6){
		alert("Password must have more than 6 characters");
		return false;
	}	
	
	$.ajax({
		data: {
			'pw': document.getElementById("head_pw").value
		},		
		type: 'POST',
		url: "/login/chagepass/",
		async: false,
		cache: false,
		success: function(response){	
			
			if (response=='ok'){
				alert("Change password successfully");
				document.getElementById("head_pw").value="";
				document.getElementById("head_pw2").value="";
				$('#modal-default').modal('hide');
			}else{
				alert("Error: change password failed");
				return false;
			}

		}
	});	
}
-->
</script>
{/literal}