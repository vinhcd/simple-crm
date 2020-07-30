<?php
require_once 'MyZendControllerAction.php';
require_once('Smarty/Smarty.class.php');
require_once 'function.php';
require_once 'Staff.php';

class LogworkController extends MyZendControllerAction{


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
		
		
		$sql="select * from project where id in(select project_id from staff_project where staff_id='".$admin->staff_id."') and start_date<='".time()."' and finish_date>='".time()."' order by create_date desc";

		$project=array();	
		$rs = $db->query($sql);
		$i=0;
		while ($rows = $db->fetch_array($rs)) {	
			$project[$i]= $rows;		
			$i++;	
		}
		$o_smarty->assign("project",$project);
		
				
		
		if (isset($req["ac"]) && $req["ac"]==1){
		
			

			$sql = "begin";
			$db->query($sql);

			$sql="delete from logwork where staff_id='".$admin->staff_id."' and date='".trim($req["logwork_date"])."'";
			$db->query($sql);

		
			for ($i=0;$i<count($project);$i++){
				if (!empty($req["hour_".$project[$i]['id']])){
					$data=array();
					$data["staff_id"]=$admin->staff_id;
					$data["date"]=trim($req["logwork_date"]);
					$data["project_id"]=$project[$i]['id'];
					$data["time"]=trim($req["hour_".$project[$i]['id']]);
					$data["comment"]=trim($req["comment_".$project[$i]['id']]);
					$data["create_date"]=time();
					$data["last_update"]=time();						
					$db->query_insert("logwork", $data);
				}
			
			}
				

			//コミット
			$sql = "commit";
			$db->query($sql);	
			$db->close();
		
			if (!empty($req['back']))
				header("location:".urldecode($req['back']));
			else
				header("location: /logwork/");
				
				
			die;
		}
			
		
		$o_smarty->display("logwork/add.tpl");


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

		$cond="";

		if (!empty($req["fromdate"])){
			$cond .=" AND a.date>='".$req["fromdate"]."'";
			$date_from = strtotime($req["fromdate"]); 
		}else{
			$cond .=" AND a.date>='".date("Y/m/01")."'";
			$date_from = strtotime(date("Y/m/01")); 
		}
		
	
		if (!empty($req["todate"])){
			 $cond .=" AND a.date<='".$req["todate"]."'";
			 $date_to = strtotime($req["todate"]);
		}else{
			$cond .=" AND a.date>='".date("Y/m/t")."'";
			 $date_to = strtotime(date("Y/m/t"));
		}
		
	
	

		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
		

		if ($admin->role==2){
			$sql="select * from staff where valid=0";
			if (!empty($req["staff_id"])){
				$sql="select * from staff where valid=0 and id='".$req["staff_id"]."'";
			}
		}else{
			$sql="select * from staff where valid=0 and id='".$admin->staff_id."'";
		}	

	
		$rs = $db->query($sql);
		$logwork=array();	
		$k=0;
		while ($rows = $db->fetch_array($rs)) {	

			for ($j=$date_from; $j<=$date_to; $j+=86400) {  
				//echo date("Y-m-d", $j).'<br />';  
				$logwork[$k]['staff_id']=$rows['id'];
				$logwork[$k]['first_name']=$rows['first_name'];
				$logwork[$k]['last_name']=$rows['last_name'];
				$logwork[$k]['date']=date("Y/m/d", $j);
				$sql="select * from logwork where staff_id='".$rows['id']."' and date='".date("Y-m-d", $j)."' limit 1";
				//echo $sql.'<br />';  
				$logwork_one= $db->query_first($sql);
				if (empty($logwork_one))
					$logwork[$k]['logwork']=0;
				else
					$logwork[$k]['logwork']=1;
				
				if ($this->isThisDayAWeekend(date("Y/m/d", $j))) $logwork[$k]['color']="red";
				
				$k++;
			}  	
			

		}	


	


			
		

		//var_dump($logwork);

		$o_smarty->assign("logwork",$logwork);		
		
		
	
	
	$sql="select * from staff where valid=0";


	$store_staff=array();
	$rs = $db->query($sql);	
	$i=0;
	while ($rows = $db->fetch_array($rs)){
		$store_staff[$i]= $rows;
		
		$i++;
	}	
	$o_smarty->assign("store_staff",$store_staff);
$db->close();
		
		$o_smarty->display("logwork/index.tpl");
	
	
	}
  
  
  
  	function isThisDayAWeekend($date) {
	
		$timestamp = strtotime($date);
	
		$weekday= date("l", $timestamp );
	
		if ($weekday =="Saturday" OR $weekday =="Sunday") { return true; } 
		else {return false; }
	
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
	

	$sql="select * from staff where id='".$req["id"]."'";
	$staff_one= $db->query_first($sql);	
	$o_smarty->assign("staff_one",$staff_one);



	
	
	
	if (isset($req["ac"]) && $req["ac"]==1){
		
				
			$sql = "begin";
			$db->query($sql);
			

			$data=array();

			$data["first_name"]=trim($req["first_name"]);
			$data["last_name"]=trim($req["last_name"]);
			$data["id_timesheet_machine"]=trim($req["id_timesheet_machine"]);
			if (!empty($req["pw"])) $data["pw"]=md5($req["pw"]);
			$data["role"]=$req["role"];
			$data["last_update"]=time();
			$data["slack_id"]=$req["slack_id"];
			if (isset($req["valid"])) 
				$data["valid"]=0;
			else
				$data["valid"]=1;				
			$db->query_update("staff", $data, "id='".$req["id"]."'");



			$db->query("delete from staff_project where staff_id='".$req["id"]."'");
			
			if (isset($req["project_list"])){
				$project_list=$req["project_list"];
				for ($i=0;$i<count($project_list);$i++){
					$sql="insert into staff_project(project_id, staff_id) values({$project_list[$i]},'{$req["staff_id"]}')";
					$db->query($sql) or die("insert error2");
				}
			}

			
			
			//コミット
			$sql = "commit";
			$db->query($sql);	
			$db->close();

						
			?>
			
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<title>Sửa nhân viên</title>
			</head>
			
			<body>
			<script language="javascript">
			<!--
			alert("Sửa dữ liệu thành công");
			location.href="/logwork/edit/?id=<?=$req["id"]?>";
			-->
			</script>
			</body>
			</html>		
			<?			
			
			

	}
	

		$sql="select * from project where start_date<='".time()."' and finish_date>='".time()."' order by create_date desc";
			
		$project=array();	
		$rs = $db->query($sql);
		$i=0;
		while ($rows = $db->fetch_array($rs)) {	
			$project[$i]= $rows;		
			$i++;	
		}
		$o_smarty->assign("project",$project);
		
		
		
	$sql="select project_id from staff_project where staff_id='".$req["id"]."'";
	$staff_project=array();	
	$rs = $db->query($sql);
	$i=0;
	while ($rows = $db->fetch_array($rs)) {	
		$staff_project[$i]= $rows["project_id"];		
		$i++;	
	}	
	$o_smarty->assign("staff_project",$staff_project);			
	
		
	$o_smarty->display("logwork/edit.tpl");
}  





	public function loadprojectAction()
	{
		$req=$this->getRequest()->getParams();
		$admin= Zend_Registry::get('admin');	
		
		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	

		$json=array();
		$sql="select a.*, b.time, b.comment from project a 
		left join logwork b on a.id=b.project_id and b.staff_id='".$admin->staff_id."' and b.date='".$req['logwork_date']."'
		where a.id in(select project_id from staff_project where staff_id='".$admin->staff_id."') and a.start_date<='".time()."' and a.finish_date>='".time()."' order by a.create_date desc";
		
		$rs = $db->query($sql);	
		$i=0;
		$json=array();
		while ($rows = $db->fetch_array($rs)){
			$json["product"][$i]=$rows;
			
			$i++;
		}	


		header("Content-Type: text/javascript; charset=utf-8");
		echo json_encode($json);
		die;
	}
	
	
	

  
}