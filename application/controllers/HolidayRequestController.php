<?php
require_once 'MyZendControllerAction.php';
require_once('Smarty/Smarty.class.php');
require_once 'function.php';
include_once 'SlackBot.php';
include_once 'SlackBotInfo.php';


class HolidayRequestController extends MyZendControllerAction{


	public function init()
	{
		//parent::init();
		
		$admin= Zend_Registry::get('admin');
		if (empty($admin->staff_id)) {
			$this->_redirect("/login/?b=".urlencode($_SERVER['REQUEST_URI']));
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


	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
	$db->connect();	

	$req=$this->getRequest()->getParams();
	$o_smarty->assign("controller",$req["controller"]);
	$o_smarty->assign("action",$req["action"]);


	$con="";

	if ($admin->role==2){
		if (!empty($req["q"])){
			$con .=" AND (a.staff_id like '".$req["q"]."%' OR b.first_name like '%".$req["q"]."%' OR b.last_name like '%".$req["q"]."%')";	
		}
	}else{
		$con .=" AND a.staff_id='".$admin->staff_id."'";
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











		$sql="select a.*, b.first_name, b.last_name from request_holoday a
		left join staff b on a.staff_id=b.id
	where 1=1 $con ";




	$db->query($sql); 
	$itemcnt=$db->affected_rows;	


	$allpagenum = ceil($itemcnt/$limit);
	
	
	$o_smarty->assign("allpagenum",$allpagenum);

	//$sql = $sql." order by a.createdate desc";


	$sql = $sql." order by last_update desc LIMIT ".(($p - 1) * $limit)." ";
	$sql = $sql.",".$limit." ";


	$overtimes=array();

	$rs = $db->query($sql);
	while ($rows = $db->fetch_array($rs)) {
		$overtimes[]= $rows;
	}	
	$o_smarty->assign("overtime",$overtimes);



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
	

	$o_smarty->display("HolidayRequest/index.tpl");

	
  }
  
  
  


  public function debtAction(){
	$o_smarty = new Smarty();	
    $o_smarty->template_dir = APP_BASE_PATH.'/templates/';
    $o_smarty->compile_dir  = APP_BASE_PATH.'/templates_c/';
	$o_smarty->caching = false; 

	$admin= Zend_Registry::get('admin');	
	$o_smarty->assign("loginid",$admin->overtime_id);
	$o_smarty->assign("overtime_name",$admin->overtime_name);
	$o_smarty->assign("admin",$admin->admin);
	$permission = new Permission();
$o_smarty->assign("permission_list",$permission->datalist($admin->overtime_id));
	$o_smarty->assign("domain",DOMAIN);


	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
	$db->connect();	

	$req=$this->getRequest()->getParams();
	$o_smarty->assign("controller",$req["controller"]);
	$o_smarty->assign("action",$req["action"]);


	//phan tich URL	
	$url_a=array();
	$url=$_SERVER['REQUEST_URI'];	
	$url=str_replace("/HolidayRequest/debt/","",$url);	
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


	$p=1;
	if (!empty($req["p"])) $p=$req["p"];
	$limit=50;


	$con="";
	if (isset($req["overtimeid"]) && $req["overtimeid"]!="") $con .=" and a.overtimeid = '".trim($req["overtimeid"])."'";

	if (isset($req["debt_type"]) && $req["debt_type"]=="all") 
		$con .="";
	elseif (isset($req["debt_type"]) && $req["debt_type"]==1) 
		$con .=" and a.thucno>0";
	elseif (isset($req["debt_type"]) && $req["debt_type"]==2) 
		$con .=" and a.thucno<=0";
	else
		if (empty($req["overtimeid"])) $con .=" and a.thucno>0";
	
	$sql="select a.*, b.phone, b.fullname, b.address from overtimes_debt a left join overtimes b on a.overtimeid=b.overtimeid where 1=1 $con ";




	$db->query($sql); 
	$itemcnt=$db->affected_rows;	
	$allpagenum = ceil($itemcnt/$limit);
	$o_smarty->assign("allpagenum",$allpagenum);

	$sql = $sql." order by a.lastupdate desc,a.thucno desc LIMIT ".(($p - 1) * $limit)." ";
	$sql = $sql.",".$limit." ";



	$overtime=array();
	$rs = $db->query($sql);
	while ($rows = $db->fetch_array($rs)) {

		$overtime[]= $rows;

	}	
	$o_smarty->assign("overtime",$overtime);



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






	
	if (isset($req["detail"])){
		$sql="select * from overtimes_debt_detail where overtimeid='".$req["overtimeid"]."' and status<>100 order by createdate desc limit 20";
	//echo $sql;
	
		$debt_overtimes=array();
	
		$rs = $db->query($sql);
		while ($rows = $db->fetch_array($rs)) {
	
			$debt_overtimes[]= $rows;
	
		}	
		$o_smarty->assign("debt_overtimes",$debt_overtimes);
		
		//var_dump($debt_overtimes);
	
	}	

	
	$o_smarty->display("HolidayRequest/debt.tpl");

	
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


	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
	$db->connect();	

	$req=$this->getRequest()->getParams();
	$o_smarty->assign("controller",$req["controller"]);
	$o_smarty->assign("action",$req["action"]);


	
	
	if (isset($req["ac"]) && $req["ac"]==1){		
		$data=array();
		$data["staff_id"]=$admin->staff_id;
		$data["from_time"]=$req["from_time"];
		$data["to_time"]=$req["to_time"];
		$data["create_date"]=time();
		$data["last_update"]=time();
		$data["reason"]=$req["reason"];
					
		$db->query_insert("request_holoday", $data);

$mesage="
@saki さん
お休みの件ですが。
ご理由: {$req["reason"]}
お時間：{$req["from_time"]}　～　{$req["to_time"]}
よろしくお願いいたします。
";
$this->slack($mesage, '#general', $admin->slack_id);

		?>

		
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		</head>
		<body>
		<script language="javascript">
		<!--
		alert("Request successfully");
		window.location = "/holiday-request/";
		-->
		</script>
		</body>
		</html>		
		<?
		die;
	}
	
		
			
	$db->close();

	$o_smarty->display("HolidayRequest/add.tpl");
}



function slack($message, $channel, $username)
{
    $ch = curl_init("https://slack.com/api/chat.postMessage");
    $data = http_build_query([
        "token" => "xoxp-413655459073-414077006179-521578152165-b7da86b161d2efbea1cb05373ac966eb",
    	"channel" => $channel, //"#mychannel",
    	"text" => $message, //"Hello, Foo-Bar channel message.",
    	"username" => $username,
    ]);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    
    return $result;
}



	public function chkovertimeidAction()
	{
		$req=$this->getRequest()->getParams();	 

		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
		
		$sql="select * from overtimes where overtimeid='".$req["overtimeid"]."'";	
		$members_one= $db->query_first($sql);		

		if (!empty($members_one)) echo "1";
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


	
	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
	$db->connect();	

	$req=$this->getRequest()->getParams();
	$o_smarty->assign("controller",$req["controller"]);
	$o_smarty->assign("action",$req["action"]);
	
	$sql="select * from request_holoday where id='".$req["id"]."'";
	$request_holoday_one= $db->query_first($sql);	
	$o_smarty->assign("request_holoday_one",$request_holoday_one);

	if ($request_holoday_one["staff_id"] != $admin->staff_id && $admin->role!=2){
		die("Error: No permission");
	}
	
	if ($request_holoday_one["staff_id"] == $admin->staff_id && strtotime($request_holoday_one["to_time"])<time() && $admin->role!=2){
		?>
		
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		</head>
		
		<body>
		<script language="javascript">
		<!--
		alert("It's over time you can't edit.\nPlease contact to Admin!");
		window.location = "/holiday-request/";
		-->
		</script>
		</body>
		</html>		
		<?
		die;
		
	}
	
	
	if (isset($req["ac"]) && $req["ac"]==1){
	
	
		$data=array();
		$data["from_time"]=$req["from_time"];
		$data["to_time"]=$req["to_time"];
		$data["last_update"]=time();
		$data["reason"]=$req["reason"];
		$db->query_update("request_holoday", $data, "id='".$req["id"]."'");

$mesage="
@saki さん
お休みの件ですが。
ご理由: {$req["reason"]}
お時間：{$req["from_time"]}　～　{$req["to_time"]}
よろしくお願いいたします。(edited) 
";

$this->slack($mesage, '#general', $admin->slack_id);


	
		?>
		
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		</head>
		
		<body>
		<script language="javascript">
		<!--
		alert("Edit successfully");
		window.location = "/holiday-request/edit/?id=<?=$req["id"]?>";
		-->
		</script>
		</body>
		</html>		
		<?
		die;
	}

	$db->close();
	$o_smarty->display("HolidayRequest/edit.tpl");
}



public function deleteAction(){
	$o_smarty = new Smarty();	
    $o_smarty->template_dir = APP_BASE_PATH.'/templates/';
    $o_smarty->compile_dir  = APP_BASE_PATH.'/templates_c/';
	$o_smarty->caching = false; 

	$admin= Zend_Registry::get('admin');	
	$o_smarty->assign("admin",$admin);
	$o_smarty->assign("loginid",$admin->login_id);
	$o_smarty->assign("login_opt",$admin->login_opt);
	$o_smarty->assign("staff_name",$admin->staff_name);	


	
	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
	$db->connect();	

	$req=$this->getRequest()->getParams();
	$o_smarty->assign("controller",$req["controller"]);
	$o_smarty->assign("action",$req["action"]);
	
	$sql="select * from request_holoday where id='".$req["id"]."'";
	$request_holoday_one= $db->query_first($sql);	
	$o_smarty->assign("request_holoday_one",$request_holoday_one);

	if ($admin->role!=2){
		die("Error: No permission");
	}
	
	$db->query("delete from request_holoday where id='".$req["id"]."'");
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
	window.location = "/holiday-request/";
	-->
	</script>
	</body>
	</html>		
	<?
	die;

}

public function approvedAction(){
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


	if ($admin->role!=2){
		die("Error: No permission");
	}

	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
	$db->connect();	

	$o_smarty->assign("domain",DOMAIN);
	


	
	
	if (isset($req["ac"]) && $req["ac"]==1){
	
	
		$data=array();
		$data["approved"]=1;
		$data["last_update"]=time();
		$data["reason2"]=$req["reason2"];
		$db->query_update("overtime", $data, "id='".$req["id"]."'");

	
		?>
		
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		</head>
		
		<body>
		<script language="javascript">
		<!--
		alert("Successfully");
		window.location = "/HolidayRequest/";
		-->
		</script>
		</body>
		</html>		
		<?
		die;
	}
	


	if (isset($req["ac"]) && $req["ac"]==2){
	
	
		$data=array();
		$data["approved"]=2;
		$data["last_update"]=time();
		$data["reason2"]=$req["reason2"];
		$db->query_update("overtime", $data, "id='".$req["id"]."'");

	
		?>
		
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		</head>
		
		<body>
		<script language="javascript">
		<!--
		alert("Successfully");
		window.location = "/HolidayRequest/";
		-->
		</script>
		</body>
		</html>		
		<?
		die;
	}

	$sql="select a.*, b.first_name, b.last_name from overtime a 
	left join staff b on a.staff_id=b.id
	where a.id='".$req["id"]."'";
	$overtime_one= $db->query_first($sql);	
	$o_smarty->assign("overtime_one",$overtime_one);



	$sql="select * from staff where valid=0 and id in(select staff_id from overtime_staff where overtime_id='".$req["id"]."')";
		
	$staff=array();	
	$rs = $db->query($sql);
	$i=0;
	while ($rows = $db->fetch_array($rs)) {	
		$staff[$i]= $rows;		
		$i++;	
	}	
	
	$o_smarty->assign("staff",$staff);	



	$o_smarty->display("HolidayRequest/approved.tpl");
}

	

  
}