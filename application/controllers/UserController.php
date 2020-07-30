<?php
require_once 'MyZendControllerAction.php';
require_once('Smarty/Smarty.class.php');
require_once 'function.php';
require_once 'Staff.php';

class UserController extends MyZendControllerAction{


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


	public function checkemailAction()
	{
		$req=$this->getRequest()->getParams();	 


		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
		
		$sql="select * from staff where email='".$req["email"]."'";	
		$members_one= $db->query_first($sql);
		

		if (!empty($members_one)) echo "1";
		die;
	}
	
	
	
	public function staffidAction()
	{
		$req=$this->getRequest()->getParams();	 


		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
		
		$sql="select * from staff where id='".$req["staff_id"]."'";	
		$members_one= $db->query_first($sql);
		

		if (!empty($members_one)) echo "1";
		die;
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
		


			$sql = "begin";
			$db->query($sql);
		
			$data=array();
			$data["id"]=$req["staff_id"];
			$data["first_name"]=trim($req["first_name"]);
			$data["last_name"]=trim($req["last_name"]);
			$data["id_timesheet_machine"]=trim($req["id_timesheet_machine"]);
			$data["pw"]=md5($req["pw"]);
			$data["email"]=$req["email"];
			$data["slack_id"]=$req["slack_id"];
			$data["position_id"]=$req["position_id"];
			$data["role"]=$req["role"];
			$data["loaihopdong"]=$req["loaihopdong"];
			if (empty($req["join_date"]))
				$data["join_date"]='NULL';
			else
				$data["join_date"]=$req["join_date"];

			if (empty($req["birthday"]))
				$data["birthday"]='NULL';
			else
				$data["birthday"]=$req["birthday"];
				
			if (empty($req["ngayhopdongchinhthuc"]))
				$data["ngayhopdongchinhthuc"]='NULL';
			else
				$data["ngayhopdongchinhthuc"]=$req["ngayhopdongchinhthuc"];


			if (empty($req["luong_luongcoban"]))
				$data["luong_luongcoban"]='NULL';
			else
				$data["luong_luongcoban"]=removecomma2($req["luong_luongcoban"]);

			if (empty($req["luong_songuoiphuthuoc"]))
				$data["luong_songuoiphuthuoc"]='NULL';
			else
				$data["luong_songuoiphuthuoc"]=$req["luong_songuoiphuthuoc"];

			if (empty($req["luong_trocapdilai"]))
				$data["luong_trocapdilai"]='NULL';
			else
				$data["luong_trocapdilai"]=removecomma2($req["luong_trocapdilai"]);
				
			
			if (empty($req["luong_trocaptiengnhat"]))
				$data["luong_trocaptiengnhat"]='NULL';
			else
				$data["luong_trocaptiengnhat"]=removecomma2($req["luong_trocaptiengnhat"]);

			if (empty($req["luong_trocaplienlac"]))
				$data["luong_trocaplienlac"]='NULL';
			else
				$data["luong_trocaplienlac"]=removecomma2($req["luong_trocaplienlac"]);

			if (empty($req["luong_trocapguixe"]))
				$data["luong_trocapguixe"]='NULL';
			else
				$data["luong_trocapguixe"]=removecomma2($req["luong_trocapguixe"]);
			
			if (empty($req["luong_trocaptrachnhiem"]))
				$data["luong_trocaptrachnhiem"]='NULL';
			else
				$data["luong_trocaptrachnhiem"]=removecomma2($req["luong_trocaptrachnhiem"]);
			
			if (empty($req["luong_trocapantrua"]))
				$data["luong_trocapantrua"]='NULL';
			else
				$data["luong_trocapantrua"]=removecomma2($req["luong_trocapantrua"]);
			

			if (empty($req["bank_name"]))
				$data["bank_name"]='NULL';
			else
				$data["bank_name"]=$req["bank_name"];


			if (empty($req["bank_branch"]))
				$data["bank_branch"]='NULL';
			else
				$data["bank_branch"]=$req["bank_branch"];


			if (empty($req["bank_huongthu"]))
				$data["bank_huongthu"]='NULL';
			else
				$data["bank_huongthu"]=$req["bank_huongthu"];


			if (empty($req["bank_number"]))
				$data["bank_number"]='NULL';
			else
				$data["bank_number"]=$req["bank_number"];
			
			
			$data["create_date"]=time();
			$data["last_update"]=time();
			
			
						
			$staff_id=$db->query_insert("staff", $data);
			if ($staff_id===false){
				$db->query("rollback");
				$db->close();
				die("err1");
			}			
			
			
			if (isset($req["project_list"])){
				$project_list=$req["project_list"];
				for ($i=0;$i<count($project_list);$i++){
					$sql="insert into staff_project(project_id, staff_id) values({$project_list[$i]},'{$req["staff_id"]}')";
					if ($db->query($sql)===false){
						$db->query("rollback");
						$db->close();
						die("err2");
					}
				}
			}
			
			

			//コミット
			$sql = "commit";
			$db->query($sql);	
			$db->close();
		
			
			//die;
			header("location: /user/");die;
			
			
		
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
			
		
	$sql="select * from position";
	$position=array();	
	$rs = $db->query($sql);
	$i=0;
	while ($rows = $db->fetch_array($rs)) {	
		$position[$i]= $rows;
		$i++;	
	}	
	$o_smarty->assign("position",$position);	

		
		$o_smarty->display("user/add.tpl");


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
			$con .=" AND (id like '".$req["q"]."%' OR first_name like '%".$req["q"]."%' OR last_name like '%".$req["q"]."%')";	
		}

		if (isset($req["del"])){
			$con .=" AND valid=1";
		}else
			$con .=" AND valid=0";

		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
		
		$order="order by valid, create_date desc";
		if (!empty($req["sort_fileds"])){
			$order="order by {$req["sort_fileds"]}";
		}

		$sql="select * from staff where 1=1 $con $order";
			
		$staff=array();	
		$rs = $db->query($sql);
		$i=0;
		while ($rows = $db->fetch_array($rs)) {	
			$staff[$i]= $rows;		
			$i++;	
		}	
			
		$db->close();




		$o_smarty->assign("staff",$staff);		
		
		
		
		$o_smarty->display("user/index.tpl");
	
	
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
			$data["position_id"]=$req["position_id"];
			
			
			if (isset($req["valid"])) 
				$data["valid"]=0;
			else
				$data["valid"]=1;	
				
				
			$data["loaihopdong"]=$req["loaihopdong"];
			if (empty($req["join_date"]))
				$data["join_date"]='null';
			else
				$data["join_date"]=$req["join_date"];

			if (empty($req["birthday"]))
				$data["birthday"]='null';
			else
				$data["birthday"]=$req["birthday"];


			if (empty($req["ngayhopdongchinhthuc"]))
				$data["ngayhopdongchinhthuc"]='null';
			else
				$data["ngayhopdongchinhthuc"]=$req["ngayhopdongchinhthuc"];


			if (empty($req["luong_luongcoban"]))
				$data["luong_luongcoban"]='NULL';
			else
				$data["luong_luongcoban"]=removecomma2($req["luong_luongcoban"]);

			if (empty($req["luong_songuoiphuthuoc"]))
				$data["luong_songuoiphuthuoc"]='NULL';
			else
				$data["luong_songuoiphuthuoc"]=$req["luong_songuoiphuthuoc"];

			if (empty($req["luong_trocapdilai"]))
				$data["luong_trocapdilai"]='NULL';
			else
				$data["luong_trocapdilai"]=removecomma2($req["luong_trocapdilai"]);
				
			
			if (empty($req["luong_trocaptiengnhat"]))
				$data["luong_trocaptiengnhat"]='NULL';
			else
				$data["luong_trocaptiengnhat"]=removecomma2($req["luong_trocaptiengnhat"]);

			if (empty($req["luong_trocaplienlac"]))
				$data["luong_trocaplienlac"]='NULL';
			else
				$data["luong_trocaplienlac"]=removecomma2($req["luong_trocaplienlac"]);

			if (empty($req["luong_trocapguixe"]))
				$data["luong_trocapguixe"]='NULL';
			else
				$data["luong_trocapguixe"]=removecomma2($req["luong_trocapguixe"]);
			
			if (empty($req["luong_trocaptrachnhiem"]))
				$data["luong_trocaptrachnhiem"]='NULL';
			else
				$data["luong_trocaptrachnhiem"]=removecomma2($req["luong_trocaptrachnhiem"]);
			
			if (empty($req["luong_trocapantrua"]))
				$data["luong_trocapantrua"]='NULL';
			else
				$data["luong_trocapantrua"]=removecomma2($req["luong_trocapantrua"]);
				

			if (empty($req["bank_name"]))
				$data["bank_name"]='NULL';
			else
				$data["bank_name"]=$req["bank_name"];


			if (empty($req["bank_branch"]))
				$data["bank_branch"]='NULL';
			else
				$data["bank_branch"]=$req["bank_branch"];


			if (empty($req["bank_huongthu"]))
				$data["bank_huongthu"]='NULL';
			else
				$data["bank_huongthu"]=$req["bank_huongthu"];


			if (empty($req["bank_number"]))
				$data["bank_number"]='NULL';
			else
				$data["bank_number"]=$req["bank_number"];
			
											
			//$db->query_update("staff", $data, "id='".$req["id"]."'");
			if ($db->query_update("staff", $data, "id='".$req["id"]."'")===false){
				$db->query("rollback");
				$db->close();
				die("err");
			}			

			
			$sql="delete from staff_project where staff_id='".$req["id"]."'";
			if ($db->query($sql)===false){
				$db->query("rollback");
				$db->close();
				die("err2");
			}
			

			
			if (isset($req["project_list"])){
				$project_list=$req["project_list"];
				for ($i=0;$i<count($project_list);$i++){
					$sql="insert into staff_project(project_id, staff_id) values({$project_list[$i]},'{$req["staff_id"]}')";
					if ($db->query($sql)===false){
						$db->query("rollback");
						$db->close();
						die("err3");
					}
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
			location.href="/user/edit/?id=<?=$req["id"]?>";
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
	
	
	
	$sql="select * from position";
	$position=array();	
	$rs = $db->query($sql);
	$i=0;
	while ($rows = $db->fetch_array($rs)) {	
		$position[$i]= $rows;
		$i++;	
	}	
	$o_smarty->assign("position",$position);	
		
		
	$o_smarty->display("user/edit.tpl");
}  


	

  
}