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
     <h1>Project edit</h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="/project/">Project list</a></li>
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
                  <label for="inputEmail3" class="col-sm-2 control-label">Project name</label>
                  <div class="col-sm-6"><input name="project_name" type="text" id="project_name" size="30" autocomplete="off" class="form-control" value="{$project_one.name}"/></div>
                </div>

			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Start date</label>
                  <div class="col-sm-6">
				  
				  
					Year:&nbsp;<select name="from_year">
					{php}for ($i=2018;$i<date("Y")+2;$i++):{/php}
					<option value="{php}echo $i;{/php}"{php}if (date("Y",$this->_tpl_vars["project_one"]["start_date"])==$i) echo " selected";{/php}>{php}echo $i;{/php}</option>
					{php}endfor;{/php}
					</select>
					Month:&nbsp;<select name="from_month">
					{php}for ($i=1;$i<13;$i++):{/php}
					<option value="{php}echo $i;{/php}"{php}if (date("n",$this->_tpl_vars["project_one"]["start_date"])==$i) echo " selected";{/php}>{php}echo $i;{/php}</option>
					{php}endfor;{/php}
					</select>	
				  </div>
                </div>
				
			   	<div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Finis date</label>
                  <div class="col-sm-6">
				  
				  
					Year:&nbsp;<select name="to_year">
					{php}for ($i=2018;$i<date("Y")+2;$i++):{/php}
					<option value="{php}echo $i;{/php}"{php}if (date("Y",$this->_tpl_vars["project_one"]["finish_date"])==$i) echo " selected";{/php}>{php}echo $i;{/php}</option>
					{php}endfor;{/php}
					</select>
					Month:&nbsp;<select name="to_month">
					{php}for ($i=1;$i<13;$i++):{/php}
					<option value="{php}echo $i;{/php}"{php}if (date("n",$this->_tpl_vars["project_one"]["finish_date"])==$i) echo " selected";{/php}>{php}echo $i;{/php}</option>
					{php}endfor;{/php}
					</select>	
					
					</div>
                </div>
				
				
					
		</form>

		<!-- /.box-body -->
		<div class="box-footer">
		<button type="button" class="btn btn-info2" onClick="update();">Save</button>
		
		<button type="button" class="btn btn-default" onClick="location.href='/project/';">Close</button>
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

	if (frm.project_name.value==""){
		alert("[Project Name] is not empty");
		return false;
	}

	frm.ac.value=1;
	frm.submit();
}	
-->
</script>
{/literal}