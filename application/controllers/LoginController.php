<?php
require_once 'MyZendControllerAction.php';
require_once('Smarty/Smarty.class.php');

class LoginController extends MyZendControllerAction{


	public function init()
	{
		//parent::init();
	}
	
	
	
	public function logoutAction()
	{
		$admin= Zend_Registry::get('admin');
		Zend_Session::namespaceUnset('admin');
		$this->_redirect("/login/");die;
	}


	public function chagepassAction(){
		$admin= Zend_Registry::get('admin');	
		$req=$this->getRequest()->getParams();
	
	
		if (empty($admin->staff_id)) die("error");
	
		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
	
	
		$data=array();
		$data["pw"]=md5($req["pw"]);
	
		if ($db->query_update("staff", $data, "id='".$admin->staff_id."'")===false){
			$db->query("rollback");
			$db->close();
			die("err");
		}			
		$db->close();
		die('ok');	
	
	}  	
	
	public function indexAction(){
		$admin= Zend_Registry::get('admin');
		if (!empty($admin->login_id)) header("location:/");
		
		$o_smarty = new Smarty();	
		$o_smarty->template_dir = APP_BASE_PATH.'/templates/';
		$o_smarty->compile_dir  = APP_BASE_PATH.'/templates_c/';
		$o_smarty->caching = false; 	
		$req=$this->getRequest()->getParams();
		
		
		
		
		$o_smarty->assign("userid","");
		$o_smarty->assign("password","");
		
		if (isset($req["ac"]) && $req["ac"]==1){
		
			
			$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
			$db->connect();	
			
			
			$sql="select * from staff where valid =0 and email='".mysql_real_escape_string($req["loginid"])."' AND pw='".md5(mysql_real_escape_string($req["pw"]))."'";
			$rows= $db->query_first($sql);	
			//echo $sql;die;
			if (empty($rows)){
				$o_smarty->assign("login",1);
			}else{			
				$admin->position_id = $rows["position_id"];
				$admin->staff_id = $rows["id"];
				$admin->email = $rows["email"];
				$admin->staff_name = $rows["first_name"]." ".$rows["last_name"];
				$admin->role = $rows["role"];
				$admin->slack_id = $rows["slack_id"];
					if (!empty($req['b']))
						header("location:".urldecode($req['b']));
					else
						header("location:/");
					
					
			}
		
		
		
		
		}
		
		$o_smarty->display("login/login.tpl");
	
	
	}

  
	public function chkloginAction()
	{
		$admin= Zend_Registry::get('admin');
		if (empty($admin->login_id)){
			die("login");
		}
	}
  
  
}