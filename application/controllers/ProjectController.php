<?php
require_once 'MyZendControllerAction.php';
require_once('Smarty/Smarty.class.php');
require_once 'function.php';
require_once 'Staff.php';

class ProjectController extends MyZendControllerAction{


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
		
		if ($admin->role!=2 && $admin->position_id != 5){
			die("Error: No permission");
		}
		
	}


	public function checkloginidAction()
	{
		$req=$this->getRequest()->getParams();	 


		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
		
		$sql="select * from staff where login_id='".$req["loginid"]."'";	
		$members_one= $db->query_first($sql);
		

		if (!empty($members_one)) echo "1";
		die;
	}	


	public function get_number_of_days_in_month($date) {
		// Using first day of the month, it doesn't really matter
		$date = $date."-1";
		return date("t", strtotime($date));
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
		
		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
		
		$req=$this->getRequest()->getParams();
		$o_smarty->assign("controller",$req["controller"]);
		$o_smarty->assign("action",$req["action"]);
		
		
		
		
		if (isset($req["ac"]) && $req["ac"]==1){
		
		
			$data=array();
			$data["name"]=$req["project_name"];
			$data["start_date"]=strtotime($req["from_year"]."/".$req["from_month"]."/01");
			$data["finish_date"]=strtotime($req["to_year"]."/".$req["to_month"]."/".date("t", strtotime($req["to_year"]."/".$req["to_month"]."/01"))." 23:59:59");

			$data["create_date"]=time();
			$data["last_update"]=time();
			$db->query_insert("project", $data);
			$db->close();

			header("location: /project/");die;
			
			
		
		}
		
	
	
		
		$o_smarty->display("project/add.tpl");


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

		$con="";
		if (!empty($req["q"])){
			$con .=" AND (id like '".$req["q"]."%' OR name like '%".$req["q"]."%')";	
		}


		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
		
		

		$sql="select * from project where 1=1 $con order by create_date desc";
			
		$project=array();	
		$rs = $db->query($sql);
		$i=0;
		while ($rows = $db->fetch_array($rs)) {	
			$project[$i]= $rows;		
			$i++;	
		}	
			
		$db->close();




		$o_smarty->assign("project",$project);		
		
		
		
		$o_smarty->display("project/index.tpl");
	
	
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
	$req=$this->getRequest()->getParams();
	$o_smarty->assign("controller",$req["controller"]);
	$o_smarty->assign("action",$req["action"]);


	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
	$db->connect();	

	$admin= Zend_Registry::get('admin');
	
	$o_smarty->assign("domain",DOMAIN);
	

	$sql="select * from project where id=".$req["id"];
	$project_one= $db->query_first($sql);	
	$o_smarty->assign("project_one",$project_one);



	
	
	
	if (isset($req["ac"]) && $req["ac"]==1){
		
			
	
			$data=array();
			$data["name"]=$req["project_name"];
			$data["start_date"]=strtotime($req["from_year"]."/".$req["from_month"]."/01");
			$data["finish_date"]=strtotime($req["to_year"]."/".$req["to_month"]."/".date("t", strtotime($req["to_year"]."/".$req["to_month"]."/01"))." 23:59:59");
			$data["last_update"]=time();


			$db->query_update("project", $data, "id=".$req["id"]);

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
			location.href="/project/edit/?id=<?=$req["id"]?>";
			-->
			</script>
			</body>
			</html>		
			<?			
			
			

	}
	


		
	
		
	$o_smarty->display("project/edit.tpl");
}  


	

  
}