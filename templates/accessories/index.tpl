{include file='header.tpl'}
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
{include file='header_content.tpl'}
{include file='menu.tpl'}
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
	<h1>Accessories management</h1>
      <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    







 <!-- SELECT2 EXAMPLE -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Search</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
		 <form name="frm" id="frm" method="get" accept-charset="utf-8" class="form-horizontal" id="searchForm">
		<input type="hidden" name="ac" />
		<input type="hidden" id="sort_fileds" name="sort_fileds" value="{$smarty.get.sort_fileds}">
		 
		
	
		<div class="row">
			<div class="col-md-6">
				<label>Accessories:</label>

					<input type="text" class="form-control" name="q" value="{$smarty.get.q}">

			</div>
			
			
			<div class="col-md-6">
				<label>Staff:</label>
				<select class="form-control select2" style="width: 100%;" name="staff_id" id="staff_id">
					<option value="">All</option>
					{foreach from=$staff item=store_staff_v}
					<option value="{$store_staff_v.id}"{if $smarty.get.staff_id eq $store_staff_v.id} selected="selected"{/if}>{$store_staff_v.id}/{$store_staff_v.first_name} {$store_staff_v.last_name}</option>
					{/foreach}
				</select>
				</div>
		
		</div>		
		
		<div class="row" style="margin-top:10px">
		<div class="col-md-12">
		<button class="btn btn-primary pull-right" id="userPics_btn_search" type="button" onClick="export_exel();" style="margin-left:10px">Excel export</button>
		<button class="btn btn-primary pull-right" id="userPics_btn_search" type="submit">Search</button>
		</div>
		</div>
		 



		 
		</form>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
	  
	  




	  
<div style="margin-bottom:10px;"><input type="button" onClick="location.href='/accessories/add/'" value="Add new"></div>	  

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
<th width="50px"><b>Id</b> <a href="javascript:void(0);" onClick="search_data('id');"><i id="s_id" class="fa fa-fw fa-sort"></i></a></th>
<th><b>Name</b> <a href="javascript:void(0);" onClick="search_data('name');"><i id="s_name" class="fa fa-fw fa-sort"></i></a></th>
<th width="200px"><b>Staff Name</b> <a href="javascript:void(0);" onClick="search_data('last_name');"><i id="s_last_name" class="fa fa-fw fa-sort"></i></a></th>
<th width="100px">Buy Date</th>
<th>service_tag</th>
<th>mfg_yr</th>
<th>express_service_code</th>
<th>invoice</th>
<th>provider</th>
<th>ram</th>
<th>win_license</th>
<th>anti_virus</th>
<th>office</th>
<th>os</th>
<th width="50px">&nbsp;</th>
</tr>
{foreach from=$accessories item=accessories_v}
<tr>
<td>{$accessories_v.id}</td>
<td>{$accessories_v.name}</td>
<td>{$accessories_v.first_name} {$accessories_v.last_name}</td>
<td>{$accessories_v.buy_date}</td>
<td>{$accessories_v.service_tag}</td>
<td>{$accessories_v.mfg_yr}</td>
<td>{$accessories_v.express_service_code}</td>
<td>{$accessories_v.invoice}</td>
<td>{$accessories_v.provider}</td>
<td>{$accessories_v.ram}</td>
<td>{$accessories_v.win_license}</td>
<td>{$accessories_v.anti_virus}</td>
<td>{$accessories_v.office}</td>
<td>{$accessories_v.os}</td>


<td align="center"><input type="button" value="Edit/View" onClick="location.href='/accessories/edit/?id={$accessories_v.id}'" /></td>
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
<script type="text/javascript" src="/js/jquery.blockUI.js"></script>

</body>
</html>

	
	
	
	

{literal}
<script language="javascript">

$(function () {
 //Initialize Select2 Elements
$('.select2').select2();
})
	



function importdel(id,model){
myRet = confirm("Có chắc chắn xóa không?");
if ( myRet == true ){
	location.href="/xn/importdel/?id="+id+"&model="+model;  
}
}




function export_exel(){
	var frm=document.frm
	frm.ac.value=3;
	frm.submit();

}

sort_data();
</script>
{/literal}
{php}
function money_round($input_data) {
	if (strpos((string)$input_data,".")){
	$tmp=explode(".",$input_data);
	$input_data=(int)$tmp[0];
	}
	return (int)$input_data;
}

{/php}
