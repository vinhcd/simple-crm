{include file='header.tpl'}
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
{include file='header_content.tpl'}
{include file='menu.tpl'}
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
	<h1>National holiday</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    




<div style="margin-bottom:10px;"><input type="button" onClick="location.href='/holiday/add/'" value="Add new"></div>

	  
	  

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
			
			
			
<div class="pad5 scrollView">
<div class="width-1800">			


<div style=" margin-bottom:15px;">
<div class="box-body table-responsive no-padding">
<table id="example1" class="table table-bordered table-striped">
	<tr>
<th>Date</th>
<th>Comment</th>
<th></th>
</tr>
{foreach from=$national_days item=national_days_v}
<tr>
<td>{$national_days_v.national_day}</td>
<td>{$national_days_v.comment}</td>
<td align="center" nowrap="nowrap" width="220px">
<input type="button" value="Edit" onClick="location.href='/holiday/edit/?id={$national_days_v.id}'">
<input type="button" value="Delete" onClick="delete_day({$national_days_v.id})">
</td>
</tr>

{/foreach}
</table>
	
</div>
</div>






<div class="row" style="margin-top:-10px">
{*
    <div class="col-lg-6">
        <ul class="pagination ">
            <li>1 / {$allpagenum} Trang</li>
        </ul>
    </div>
*}
    <div class="col-lg-12">
        <div class="paginator" value="1">
            <ul class="pagination pull-right">
			
                <li class="prev{if $p eq 1} disabled{/if}"><a href="?p={$p-1}{$url}"><</a></li>
				
				{section name=foo start=$start loop=$finish+1 step=1}	

				{if $smarty.section.foo.index eq $p}
				<li class="active"><a href="#">{$smarty.section.foo.index}</a></li>
				{else}
				<li><a title="{$smarty.section.foo.index}" href="?p={$smarty.section.foo.index}{$url}">{$smarty.section.foo.index}</a></li>
				{/if}

				{/section}
				<li class="next{if $p eq $allpagenum} disabled{/if}"><a rel="next" href="?p={$p+1}{$url}">></a></li>
				
            </ul>
        </div>

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

</body>
</html>

	
	
	
	

{literal}
<script language="javascript">
<!--


$("#fromdate").datepicker({ dateFormat: "dd/mm/yy"});
$("#fromdate").datepicker("setDate", "{/literal}{$smarty.get.fromdate}{literal}");

$("#todate").datepicker({ dateFormat: "dd/mm/yy"});
$("#todate").datepicker("setDate", "{/literal}{$smarty.get.todate}{literal}");





function delete_day(id){
myRet = confirm("Are you sure?");
if ( myRet == true ){
	location.href="/holiday/delete/?id="+id;
}
}


-->
</script>
{/literal}
