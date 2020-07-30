<?php
require_once 'MyZendControllerAction.php';
require_once('Smarty/Smarty.class.php');
require_once 'function.php';
require_once 'Annual.php';

class HolidayController extends MyZendControllerAction{


	public function init()
	{

		/*if ($_SERVER['REMOTE_ADDR']!="118.70.129.39" && $_SERVER['REMOTE_ADDR']!="101.99.7.206"){
			?>
			
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			</head>
			
			<body>
			<script language="javascript">
			<!--
			alert("Error: No permission");
			location.href="/";
			-->
			</script>
			</body>
			</html>		
			<?	
			die;	
		}*/

		
		$admin= Zend_Registry::get('admin');
		if (empty($admin->staff_id)) {
			$this->_redirect("/login/?b=".urlencode($_SERVER['REQUEST_URI']));
		}


		if ($admin->role!=2){
			die("Error: No permission");
		}
		
	}






  public function indexAction(){
	$o_smarty = new Smarty();	
	$o_smarty->template_dir = APP_BASE_PATH.'/templates/';
	$o_smarty->compile_dir  = APP_BASE_PATH.'/templates_c/';
	$o_smarty->caching = false; 

	$admin= Zend_Registry::get('admin');	
	$o_smarty->assign("admin",$admin);
	$o_smarty->assign("loginid",$admin->login_id);
	$o_smarty->assign("login_opt",$admin->login_opt);
	$o_smarty->assign("staff_name",$admin->staff_name);
	
	$o_smarty->assign("domain",DOMAIN);
	

	
	$req=$this->getRequest()->getParams();
	$o_smarty->assign("controller",$req["controller"]);
	$o_smarty->assign("action",$req["action"]);

	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
	$db->connect();	


	$con="";
	$url="";
	

	if (!empty($req["customerid"])){
		$con .=" AND (a.customerid like '".$req["customerid"]."%' OR a.fullname like '%".$req["customerid"]."%')";	
		//$csv_con .=" AND a.staffid=".$req["staffid"];	
		//$url .="&staffid=".$req["staffid"];
	}


	$p=1;
	if (!empty($req["p"])) $p=$req["p"];
	$limit=50;

	
	
	//phan tich URL	
	$url_a=array();
	$url=$_SERVER['REQUEST_URI'];	
	$url=str_replace("/store/rptssale/","",$url);	
	$url=str_replace("?","",$url);	
	if ($url!="") $url_a=explode("&",$url);
	
	$url="";
	if (count($url_a)>0)
	for ($i=0;$i<count($url_a);$i++){
		if (strpos($url_a[$i],"p=")===false){
			$url .=$url_a[$i];
			if ($i<count($url_a)-1) $url .="&";			
		}
		
	}
	
	if ($url!="") $url="&".$url;
	$o_smarty->assign("url",$url);











		$sql="select * from national_days a
	where 1=1 $con ";
	


	$db->query($sql); 
	$itemcnt=$db->affected_rows;	


	$allpagenum = ceil($itemcnt/$limit);
	
	
	$o_smarty->assign("allpagenum",$allpagenum);

	//$sql = $sql." order by a.createdate desc";


	$sql = $sql." order by a.national_day desc LIMIT ".(($p - 1) * $limit)." ";
	$sql = $sql.",".$limit." ";


	$national_days=array();

	$rs = $db->query($sql);
	while ($rows = $db->fetch_array($rs)) {
		$national_days[]= $rows;
	}	
	$o_smarty->assign("national_days",$national_days);

	//var_dump($national_days);

	$start=0;
	$finish=0;	
	if (empty($req["p"])) {
		$start=1;
		
		if ($allpagenum>7) 
			$finish=7;
		else
			$finish=$allpagenum;
		
		
	}else{
	
		if ($req["p"]<5){
			$start=1;
			if ($allpagenum<7){
				$finish=$allpagenum;
			}else{
				$finish=7;
			}
						
		}else{
			$start=$req["p"]-3;
			
			$finish=$req["p"]+3;
			
			if ($req["p"]>($allpagenum-3)) $finish=$allpagenum;
		}
		
	}
	
	$o_smarty->assign("start", $start);
	$o_smarty->assign("finish", $finish);	
	$o_smarty->assign("p", $p);
	
	
	
	
	
	
	
	
	
	

	$o_smarty->assign("branch_all_power", $admin->branch_all);
$o_smarty->assign("module_all", $admin->module_all);	
	if (!empty($admin->power_module_user)) 	$o_smarty->assign("power_module_user", $admin->power_module_user);
	
	$o_smarty->display("holiday/index.tpl");

	
  }
  
  
  

public function addAction(){
	$o_smarty = new Smarty();	
	$o_smarty->template_dir = APP_BASE_PATH.'/templates/';
	$o_smarty->compile_dir  = APP_BASE_PATH.'/templates_c/';
	$o_smarty->caching = false; 

	$admin= Zend_Registry::get('admin');	
	$o_smarty->assign("admin",$admin);
	$o_smarty->assign("loginid",$admin->login_id);
	$o_smarty->assign("login_opt",$admin->login_opt);
	$o_smarty->assign("staff_name",$admin->staff_name);
	
	$o_smarty->assign("domain",DOMAIN);
	

	
	$req=$this->getRequest()->getParams();
	$o_smarty->assign("controller",$req["controller"]);
	$o_smarty->assign("action",$req["action"]);




	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
	$db->connect();	




	
	if (isset($req["ac"]) && $req["ac"]==1){		
	
		$sql = "begin";
		$db->query($sql);
			
		$data=array();
		$data["national_day"]=$req["holiday_date"];
		$data["comment"]=$req["comment"];
		$data["create_date"]=time();
		$data["last_update"]=time();

		if ($db->query_insert("national_days", $data)===false){
			$db->query("rollback");
			$db->close();
			die("err");
		}		
		
		$annual = new Annual();	
		$annual->updateAnnual("", $db);	
				

		$db->query("commit");	
		$db->close();
				
		
		?>

		
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		</head>
		<body>
		<script language="javascript">
		<!--
		alert("Add successfully");
		window.location = "/holiday/";
		-->
		</script>
		</body>
		</html>		
		<?
		die;
	}
	
		
	$o_smarty->display("holiday/add.tpl");
}



	public function checkdateAction()
	{
		$req=$this->getRequest()->getParams();	 


		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
		
		$sql="select * from national_days where national_day='".$req["date"]."'";	
		$members_one= $db->query_first($sql);
		

		if (!empty($members_one)) echo "1";
		die;
	}	
	

	public function checkdate2Action()
	{
		$req=$this->getRequest()->getParams();	 


		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
		
		$sql="select * from national_days where national_day='".$req["date"]."' and id<>".$req["id"];	
		$members_one= $db->query_first($sql);
		

		if (!empty($members_one)) echo "1";
		die;
	}
	


	public function deleteAction(){
		$admin= Zend_Registry::get('admin');	
		$req=$this->getRequest()->getParams();
		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
		
		$sql = "begin";
		$db->query($sql);
				
		$sql="delete from national_days where id='".$req["id"]."'";

		if (!$db->query($sql)){
			$db->query("rollback");
			$db->close();
			die("err");
		}
				

		$annual = new Annual();	
		$annual->updateAnnual("", $db);	
				

		$db->query("commit");	
		$db->close();
		
		?>
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		</head>
		<body>
		<script language="javascript">
		<!--
		alert("Delete successfully");
		window.location = "/holiday/";
		-->
		</script>
		</body>
		</html>		
		<?
		die;
	
	}	



public function editAction(){
	$o_smarty = new Smarty();	
	$o_smarty->template_dir = APP_BASE_PATH.'/templates/';
	$o_smarty->compile_dir  = APP_BASE_PATH.'/templates_c/';
	$o_smarty->caching = false; 

	$admin= Zend_Registry::get('admin');	
	$o_smarty->assign("admin",$admin);
	$o_smarty->assign("loginid",$admin->login_id);
	$o_smarty->assign("login_opt",$admin->login_opt);
	$o_smarty->assign("staff_name",$admin->staff_name);
	
	$o_smarty->assign("domain",DOMAIN);
	

	
	$req=$this->getRequest()->getParams();
	$o_smarty->assign("controller",$req["controller"]);
	$o_smarty->assign("action",$req["action"]);






	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
	$db->connect();	



	
	
	if (isset($req["ac"]) && $req["ac"]==1){
	
		$sql = "begin";
		$db->query($sql);
			
		$data=array();
		$data["national_day"]=$req["holiday_date"];
		$data["comment"]=$req["comment"];
		$data["last_update"]=time();

		
		if ($db->query_update("national_days", $data,"id='".$req["id"]."'")===false){
			$db->query("rollback");
			$db->close();
			die("err1");
		}				
					
		
		$annual = new Annual();	
		$annual->updateAnnual("", $db);	
				

		$db->query("commit");	
		$db->close();
	
	
		?>
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		</head>
		<body>
		<script language="javascript">
		<!--
		alert("Edit successfully");
		window.location = "/holiday/edit/?id=<?=$req["id"]?>";
		-->
		</script>
		</body>
		</html>			
		<?
		die;
	}
	
	$sql="select * from national_days where id='".$req["id"]."'";
	$national_days_one= $db->query_first($sql);	
	$o_smarty->assign("national_days_one",$national_days_one);
		
	$o_smarty->display("holiday/edit.tpl");
}





	

  
}