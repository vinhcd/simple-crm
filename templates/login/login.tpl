<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Timesheet</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="/AdminLTE-2.4.0-rc/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/AdminLTE-2.4.0-rc/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="/AdminLTE-2.4.0-rc/bower_components/Ionicons/css/ionicons.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/AdminLTE-2.4.0-rc/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="/AdminLTE-2.4.0-rc/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="/AdminLTE-2.4.0-rc/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="/AdminLTE-2.4.0-rc/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
   <!-- Select2 -->
  <link rel="stylesheet" href="/AdminLTE-2.4.0-rc/bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/AdminLTE-2.4.0-rc/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/AdminLTE-2.4.0-rc/dist/css/skins/_all-skins.min.css">
	<!-- jQuery 3 -->
	<script src="/AdminLTE-2.4.0-rc/bower_components/jquery/dist/jquery.min.js"></script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title" style="font-weight:bold">Login</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
					<form method="post" name="frm" role="form">
		<input type="hidden" name="ac" value="1" />

              <div class="box-body">

                <div class="form-group">
                  <label for="exampleInputEmail1">Email</label>
                  <input type="email" class="form-control" name="loginid" id="loginid" value="{$smarty.post.loginid}" autocomplete="off" readonly onFocus="$(this).removeAttr('readonly');">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" class="form-control" id="pw" name="pw" autocomplete="off" readonly onFocus="$(this).removeAttr('readonly');">
                </div>
              </div>
              <!-- /.box-body -->
			<div style="text-align:center;">{if $login eq 1}<div style="color:#FF0000; font-size:16px; margin-bottom:20px;">Error: Incorrect Email or Password.</div>{/if}</div>

              <div class="box-footer">
                <button type="button" class="btn btn-primary" onClick="validateForm();">Login</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
</div>
</body></html>
{literal}
<script language="javascript">
<!--


$( "#loginid" ).keypress(function( event ) {
if ( event.which == 13 ) {
document.frm.pw.focus();
}
});


$( "#pw" ).keypress(function( event ) {
if ( event.which == 13 ) {
validateForm();
}
});

function validateForm()
{
var frm=document.frm;


	if (frm.loginid.value=="")
	{
		alert("[Email] is not empty");
		return false;
	}


	if (frm.pw.value=="")
	{
		alert("[Password] is not empty");
		return false;
	}
	frm.submit();



}
-->
</script>
{/literal}