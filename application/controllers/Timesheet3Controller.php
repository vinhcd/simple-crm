<?php
require_once 'MyZendControllerAction.php';
require_once('Smarty/Smarty.class.php');
require_once 'function.php';
require_once 'Salary2.php';
require_once 'Common.php';
require_once '/var/www/html/timesheet.neoscorp.vn/library/PHPExcel-1.8/Classes/PHPExcel.php';
require_once '/var/www/html/timesheet.neoscorp.vn/library/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';

class Timesheet3Controller extends MyZendControllerAction{

	public function init()
	{
		$admin= Zend_Registry::get('admin');
		
		if (empty($admin->staff_id)) {
			$this->_redirect("/login/?b=".urlencode($_SERVER['REQUEST_URI']));
		}
		

		
	}


	public function getCommentAction()
	{
		$admin= Zend_Registry::get('admin');	
		$req=$this->getRequest()->getParams();
		
		
		if (empty($admin->staff_id)) die("error");
		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
		
		$sql="select * from comment where staff_id='".$admin->staff_id."' and DATE_FORMAT(date,'%Y-%m-%d')='".$req["date"]."'";
		$json= $db->query_first($sql);	
	
		header("Content-Type: text/javascript; charset=utf-8");
		echo json_encode($json);
		die;
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


	public function commentAction(){
		$admin= Zend_Registry::get('admin');	
		$req=$this->getRequest()->getParams();
	
	
		if (empty($admin->staff_id)) die("error");
		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
	
		$sql="select * from comment where staff_id='".$req["staff_id"]."' and DATE_FORMAT(date,'%Y-%m-%d')='".$req["date"]."'";
		$time_sheet_one= $db->query_first($sql);	
		
		if (empty($time_sheet_one)){
			$data=array();
			$data["date"]=$req["date"];
			$data["comment"]=$req["comment"];
			$data["staff_id"]=$req["staff_id"];
			$data["createdate"]=time();
			$data["updatedate"]=time();
			
			if ($db->query_insert("comment", $data)===false){
				$db->close();
				die("err");
			}
			
			
/*$mesage="
@BaoNQ
xxxxxxxxxxxxxxxxx
";

$this->slack($mesage, '#timesheet', $admin->slack_id);
*/			
						
		}else{
			$data=array();
			$data["comment"]=$req["comment"];
			$data["updatedate"]=time();

			if ($db->query_update("comment", $data, "staff_id='".$req["staff_id"]."' and DATE_FORMAT(date,'%Y-%m-%d')='".$req["date"]."'")===false){
				$db->close();
				die("err");
			}	
/*			
$mesage="
@BaoNQ
xxxxxxxxxxxxxxxxx
";

$this->slack($mesage, '#timesheet', $admin->slack_id);
*/					
		
		}
		
		$db->close();	
		
/*		
		
		if ($req["staff_id"]!="005"){
$config = array('ssl' => 'tls',
		'auth' => 'login',
		'username' => 'neos.timesheet@gmail.com',
		'password' => 'asdsad123@##ddd');

$transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
$bodytext="
Staff: ".$admin->staff_id."/".$admin->staff_name."<br>
Comment content:<br>
".$req["comment"]."<br>
Date: ".$req["date"]."<br>
URL:<br>
http://timesheet.neoscorp.vn/timesheet/?history=&ac=1&fromdate=".urlencode($req["fromdate"])."&todate=".urlencode($req["todate"])."&staff_id=".$admin->staff_id."
<br>
";
$mail = new Zend_Mail('UTF-8');
$mail->setBodyHtml($bodytext);
$mail->setFrom('noreply@neoscorp.vn','Neos Timesheet');
$mail->addTo("hangntc@neoscorp.vn", "Nguyen Thi Cam Hang");
$mail->setSubject('Comment from '.$admin->staff_name);
$mail->send($transport);			
			}
	
*/		
		die('ok');	
	
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

	if ($admin->role!=2){
		die("Error: No permission");
	}

	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
	$db->connect();	

	$o_smarty->assign("domain",DOMAIN);
	


	
	
	if (isset($req["ac"]) && $req["ac"]==1){

		
		$start_time=$req["start_time"]." ".$req["start_time_hour"].":".$req["start_time_minute"].":00";	
		$finish_time=$req["finish_time"]." ".$req["finish_time_hour"].":".$req["finish_time_minute"].":00";

		
		$data=array();
		$data["staff_id"]=$req['staff_id'];
		$data["check_in"]=$start_time;
		$data["check_out"]=$finish_time;
		$data["last_update"]=time();
		$data["last_update_staff_id"]=$admin->staff_id;
			
		$db->query_update("time_sheet", $data, "id=".$req["id"]);


//die;
	
		?>
		
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		</head>
		
		<body>
		<script language="javascript">
		<!--
		alert("Edit successfully");
		window.location = "<?=$req["back"]?>";
		-->
		</script>
		</body>
		</html>		
		<?
		die;
	}

	$sql="select * from staff where valid=0";


	$store_staff=array();
	$rs = $db->query($sql);	
	$i=0;
	while ($rows = $db->fetch_array($rs)){
		$staff[$i]= $rows;
		
		$i++;
	}	
	$o_smarty->assign("staff",$staff);
	

	$sql="select * from time_sheet a where id=".$req["id"];
	$woking_time_one= $db->query_first($sql);	
	$o_smarty->assign("woking_time_one",$woking_time_one);
		
	$o_smarty->display("timesheet/edit.tpl");
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
	$req=$this->getRequest()->getParams();
	$o_smarty->assign("controller",$req["controller"]);
	$o_smarty->assign("action",$req["action"]);


	if ($admin->role!=2){
		die("Error: No permission");
	}


	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
	$db->connect();	

	$o_smarty->assign("domain",DOMAIN);
	



	$sql="select * from staff where valid=0";


	$store_staff=array();
	$rs = $db->query($sql);	
	$i=0;
	while ($rows = $db->fetch_array($rs)){
		$staff[$i]= $rows;
		
		$i++;
	}	
	$o_smarty->assign("staff",$staff);



	
	
	
	if (isset($req["ac"]) && $req["ac"]==1){

		$start_time=$req["start_time"]." ".$req["start_time_hour"].":".$req["start_time_minute"].":00";	
		$finish_time=$req["finish_time"]." ".$req["finish_time_hour"].":".$req["finish_time_minute"].":00";

//echo $start_time;die;
		$data=array();
		$data["staff_id"]=$req['staff_id'];
		$data["check_in"]=$start_time;
		$data["check_out"]=$finish_time;
		$data["create_date"]=time();
		$data["last_update"]=time();
		$data["last_update_staff_id"]=$admin->staff_id;
		$db->query_insert("time_sheet", $data);	
	//die;
		?>
		
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		</head>
		<body>
		<script language="javascript">
		<!--
		alert("Add successfully");
		window.location = "<?=$req["back"]?>";
		-->
		</script>
		</body>
		</html>		
		<?
		die;
	}


	$o_smarty->display("timesheet/add.tpl");
}


public function deleteAction(){
	$admin= Zend_Registry::get('admin');	
	$req=$this->getRequest()->getParams();

	if ($admin->role!=2){
		die("Error: No permission");
	}
		
	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
	$db->connect();	
	
	$sql="delete from time_sheet where id=".$req["id"];
	$db->query_first($sql);	
	?>
	
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	
	<body>
	<script language="javascript">
	<!--
	alert("Delete successfully");
	window.location = "<?=$req["back"]?>";
	-->
	</script>
	</body>
	</html>		
	<?
	die;


}

/*
  
  public function indexAction(){
		ini_set('display_errors', 1);
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
	
	
		$salary = new Salary();
		$common = new Common();
	
	
	
		$sql="select * from staff where valid=0";
	
	
		$store_staff=array();
		$rs = $db->query($sql);	
		$i=0;
		while ($rows = $db->fetch_array($rs)){
			$store_staff[$i]= $rows;
			
			$i++;
		}	
		$o_smarty->assign("store_staff",$store_staff);
	
	
		$cond="";
		$cond2="";
		$url="";
	
		
	
		if (!empty($req["fromdate"])){
			$cond .=" AND a.check_in>='".$req["fromdate"]."'";
			$date_from = strtotime($req["fromdate"]); 
		}else{
			$cond .=" AND a.check_in>='".date("Y/m/d", strtotime("-1 months"))."'";
			$date_from = strtotime(date("Y/m/d", strtotime("-1 months")));
		}
		
	
		if (!empty($req["todate"])){
			 $cond .=" AND a.check_in<='".$req["todate"]." 23:59:59'";
			 $date_to = strtotime($req["todate"]);
		}else{
			 $cond .=" AND a.check_in<='".date("Y/m/t 23:59:59", strtotime("-1 months"))."'";
			 $date_to = strtotime(date("Y/m/t 23:59:59", strtotime("-1 months")));
		}
		
		if ($admin->role==2){
			if (!empty($req["staff_id"])){
				$cond .=" AND a.staff_id='".$req["staff_id"]."'";
			}
		}else{
			$cond .=" AND a.staff_id='".$admin->staff_id."'";
		}
		
		
		$p=1;
		if (!empty($req["p"])) $p=$req["p"];
		$limit=100;





	
		//phan tich URL	
		$url_a=array();
		$url=$_SERVER['REQUEST_URI'];	
		$url=str_replace("/timesheet/","",$url);	
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


		
		$sql="select a.* ,b.first_name, b.last_name from time_sheet a 
		left join staff b on a.staff_id=b.id where 1=1 $cond ";
	
		$sql_excel=$sql;
		
	
		$db->query($sql); 
		$itemcnt=$db->affected_rows;	
		$allpagenum = ceil($itemcnt/$limit);
		$o_smarty->assign("allpagenum",$allpagenum);
	
	
		$sql = $sql." ORDER BY a.staff_id, a.check_in ";
		$sql_excel = $sql;
		
		if ($admin->role==2) $sql .="desc";
		
		
		
		$sql = $sql." LIMIT ".(($p - 1) * $limit)." ";
		$sql = $sql.",".$limit." ";		
		


		
		
	
		$woking_time=array();

	
		$rs = $db->query($sql);
		$i=0;
		while ($rows = $db->fetch_array($rs)) {
			$woking_time[$i]= $rows;
			$wt=$salary->work_hours($rows["check_in"], $rows["check_out"], $rows["staff_id"], $db);
			$woking_time[$i]["work_hours"]= $wt[0];
			$woking_time[$i]["ot1"]= $wt[1];
			$woking_time[$i]["ot2"]= $wt[2];
			$woking_time[$i]["ot3"]= $wt[3];
			$woking_time[$i]["ot4"]= $wt[4];
	
			$i++;
		}	
		



		if (isset($req["ac"]) && $req["ac"]==3){
		
			$sql="select * from project order by create_date desc";
			
			$project=array();	
			$rs = $db->query($sql);
			while ($rows = $db->fetch_array($rs)) {	
				$project[]= $rows;		
			}		


		
			$xl = new PHPExcel();
			$xl->setActiveSheetIndex(0);
			$sheet = $xl->getActiveSheet();
			$sheet->setTitle('Sheet1');
	
			
			$pageMargins = $sheet->getPageMargins();

			
			$pageMargins->setTop(0.3);
			$pageMargins->setBottom(0.3);
			$pageMargins->setLeft(0.6);
			$pageMargins->setRight(0.3);


			$sheet->mergeCells("A1:".chr(76+count($project))."1");
			$sheet->setCellValue('A1', "Time sheet");
			$sheet->getStyle("A1:".chr(76+count($project))."1")->getFont()->setBold(true)->setSize(20);


			$sheet->getStyle('A1')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
			);

			$sheet->mergeCells("A2:".chr(76+count($project))."2");
			$sheet->setCellValue('A2', "Created date: ".date("Y/m/d H:i"));
			$sheet->getStyle('A2')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
			);

			$sheet->setCellValue('A3', "STT");					
			$sheet->setCellValue('B3', "Mã NV");
			$sheet->setCellValue('C3', "Họ và đệm");
			$sheet->setCellValue('D3', "Tên");
			$sheet->setCellValue('E3', "Ngày");
			$sheet->setCellValue('F3', "Vào");
			$sheet->setCellValue('G3', "Ra");
			$sheet->setCellValue('H3', "Giờ công");
			$sheet->setCellValue('I3', "OT1");
			$sheet->setCellValue('J3', "OT2");
			$sheet->setCellValue('K3', "OT3");
			$sheet->setCellValue('L3', "OT4");
			
			
			for ($p=0;$p<count($project);$p++){
				$sheet->setCellValue(chr(77+$p)."3", $project[$p]["name"]);
			}	






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
		$stt=1;
		$i=4;
		while ($rows = $db->fetch_array($rs)) {	

			for ($j=$date_from; $j<=$date_to; $j+=86400) {  
				$sheet->setCellValue('A'.$i, $stt);
				$sheet->setCellValue('B'.$i, ' '.$rows["id"]);
				$sheet->setCellValue('C'.$i, $rows["first_name"]);
				$sheet->setCellValue('D'.$i, $rows["last_name"]);			
				$sheet->setCellValue('E'.$i, date("Y-m-d", $j));
				
				$sql="select * from time_sheet where staff_id='".$rows['id']."' and DATE_FORMAT(check_in,'%Y-%m-%d')='".date("Y-m-d", $j)."'";
				$time_sheet_one= $db->query_first($sql);
				if (!empty($time_sheet_one["check_in"])){
					$sheet->setCellValue('F'.$i, date("H:i",strtotime($time_sheet_one["check_in"])));					
				}
				
				if (!empty($time_sheet_one["check_out"])){
					$sheet->setCellValue('G'.$i, date("H:i",strtotime($time_sheet_one["check_out"])));					
				}		
				
				
				if (!empty($time_sheet_one["check_in"]) && !empty($time_sheet_one["check_out"])){
				
					$wt=$salary->work_hours($time_sheet_one["check_in"], $time_sheet_one["check_out"], $rows["id"], $db);
					$woking_time[$i]["work_hours"]= $wt[0];
					$woking_time[$i]["ot1"]= $wt[1];
					$woking_time[$i]["ot2"]= $wt[2];
					$woking_time[$i]["ot3"]= $wt[3];
					$woking_time[$i]["ot4"]= $wt[4];

					
					$sheet->setCellValue('H'.$i, $wt[0]);
					
					$sheet->setCellValue('I'.$i, $wt[1]);
					$sheet->setCellValue('J'.$i, $wt[2]);
					$sheet->setCellValue('K'.$i, $wt[3]);
					$sheet->setCellValue('L'.$i, $wt[4]);					
					

					
					for ($p=0;$p<count($project);$p++){
						$sql="select time from logwork where staff_id='".$rows["id"]."' and date='".date("Y-m-d", $j)."' and project_id=".$project[$p]['id'];
						//echo $sql;die;
						
						$logwork_one= $db->query_first($sql);
						if (!empty($logwork_one)){
							$sheet->setCellValue(chr(77+$p).$i, $logwork_one['time']);
						}
					}					

					
					
					
				}
				
						
				
				$stt++;
				$i++;
			}  	
			
			
		}	


			
			
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="Timesheet.xlsx"');
			header('Cache-Control: max-age=0');
			
			$writer = PHPExcel_IOFactory::createWriter($xl, 'Excel2007');
			$writer->save('php://output');		
			die;
			
								
		}


		$o_smarty->assign("woking_time",$woking_time);
		
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
	
	
			
		$o_smarty->display("timesheet/index.tpl");
	
  }  
*/


  	function isThisDayAWeekend($date) {
	
		$timestamp = strtotime($date);
	
		$weekday= date("l", $timestamp );
	
		if ($weekday =="Saturday" OR $weekday =="Sunday") { return true; } 
		else {return false; }
	
	}
	
	
  public function indexAction(){
		ini_set('display_errors', 1);
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
	
	
		$salary = new Salary2();
		$common = new Common();
	
	
	
		$sql="select * from staff where valid=0";
	
	
		$store_staff=array();
		$rs = $db->query($sql);	
		$i=0;
		while ($rows = $db->fetch_array($rs)){
			$store_staff[$i]= $rows;
			
			$i++;
		}	
		$o_smarty->assign("store_staff",$store_staff);
	
	
		$cond="";
		$cond2="";
		$url="";
	
		
	
		if (!empty($req["fromdate"])){
			$cond .=" AND a.check_in>='".$req["fromdate"]."'";
			$date_from = strtotime($req["fromdate"]); 
		}else{
			$cond .=" AND a.check_in>='".date("Y/m/01", strtotime("-1 months"))."'";
			$date_from = strtotime(date("Y/m/01", strtotime("-1 months")));
		}
//		echo $date_from;
	
		if (!empty($req["todate"])){
			 $cond .=" AND a.check_in<='".$req["todate"]." 23:59:59'";
			 $date_to = strtotime($req["todate"]);
		}else{
			 $cond .=" AND a.check_in<='".date("Y/m/t 23:59:59", strtotime("-1 months"))."'";
			 $date_to = strtotime(date("Y/m/t 23:59:59", strtotime("-1 months")));
		}
		
		if ($admin->role==2){
			if (!empty($req["staff_id"])){
				$cond .=" AND a.staff_id='".$req["staff_id"]."'";
			}
		}else{
			$cond .=" AND a.staff_id='".$admin->staff_id."'";
		}
		
		
		$p=1;
		if (!empty($req["p"])) $p=$req["p"];
		$limit=1;





	
		//phan tich URL	
		$url_a=array();
		$url=$_SERVER['REQUEST_URI'];	
		$url=str_replace("/timesheet/","",$url);	
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





/*		
		$sql="select a.* ,b.first_name, b.last_name from time_sheet a 
		left join staff b on a.staff_id=b.id where 1=1 $cond ";
	
		$sql_excel=$sql;
		
	
		$db->query($sql); 
		$itemcnt=$db->affected_rows;	
		$allpagenum = ceil($itemcnt/$limit);
		$o_smarty->assign("allpagenum",$allpagenum);
	
	
		$sql = $sql." ORDER BY a.staff_id, a.check_in ";
		$sql_excel = $sql;
		
		if ($admin->role==2) $sql .="desc";
		
		
		
		$sql = $sql." LIMIT ".(($p - 1) * $limit)." ";
		$sql = $sql.",".$limit." ";		
		


		
		
	
		$woking_time=array();

	
		$rs = $db->query($sql);
		$i=0;
		while ($rows = $db->fetch_array($rs)) {
			$woking_time[$i]= $rows;
			$wt=$salary->work_hours($rows["check_in"], $rows["check_out"], $rows["staff_id"], $db);
			$woking_time[$i]["work_hours"]= $wt[0];
			$woking_time[$i]["ot1"]= $wt[1];
			$woking_time[$i]["ot2"]= $wt[2];
			$woking_time[$i]["ot3"]= $wt[3];
			$woking_time[$i]["ot4"]= $wt[4];
	
			$i++;
		}	
		
*/




		$allpagenum=1;
		if ($admin->role==2){
			$sql="select * from staff where valid=0 ";
			if (!empty($req["staff_id"])) $sql .=" and id='".$req["staff_id"]."'";
	
			$db->query($sql); 
			$itemcnt=$db->affected_rows;	
			$allpagenum = ceil($itemcnt/$limit);
			$o_smarty->assign("allpagenum",$allpagenum);

			
			$sql = $sql." order by id LIMIT ".(($p - 1) * $limit)." ";
			$sql = $sql.",".$limit." ";		

			
			if (!empty($req["staff_id"])){
				$sql="select * from staff where valid=0 and id='".$req["staff_id"]."'";
			}
		}else{
			$sql="select * from staff where valid=0 and id='".$admin->staff_id."'";
		}	

	
		$rs = $db->query($sql);
		$woking_time=array();
		$i=0;
		$total_wh=0;
		while ($rows = $db->fetch_array($rs)) {	

			for ($j=$date_from; $j<=$date_to; $j+=86400) {  
				//echo date("Y-m-d", $j)."<br>";
				if ($this->isThisDayAWeekend(date("Y/m/d", $j))) $woking_time[$i]['color']="red";
				
				$woking_time[$i]["staff_id"]= $rows["id"];
				$woking_time[$i]["date"]= date("Y-m-d", $j);
				$woking_time[$i]["first_name"]= $rows["first_name"];
				$woking_time[$i]["last_name"]=$rows["last_name"];
				
				
				$sql="select * from time_sheet where staff_id='".$rows['id']."' and DATE_FORMAT(check_in,'%Y-%m-%d')='".date("Y-m-d", $j)."'";
				
				$time_sheet_one= $db->query_first($sql);
				$woking_time[$i]["time_sheet_id"]= $time_sheet_one["id"];
				
				if (!empty($time_sheet_one["check_in"])){
					$woking_time[$i]["check_in"]= date("H:i",strtotime($time_sheet_one["check_in"]));
				}
				
				if (!empty($time_sheet_one["check_out"])){
					$woking_time[$i]["check_out"]=date("H:i",strtotime($time_sheet_one["check_out"]));		
				}		
				
				
				
				
				
				if (!empty($time_sheet_one["check_in"]) && !empty($time_sheet_one["check_out"])){
				
					$wt=$salary->work_hours($time_sheet_one["check_in"], $time_sheet_one["check_out"], $rows["id"], $db);
					$woking_time[$i]["work_hours"]= $wt[0];
					$woking_time[$i]["ot1"]= $wt[1];
					$woking_time[$i]["ot2"]= $wt[2];
					$woking_time[$i]["ot3"]= $wt[3];
					$woking_time[$i]["ot4"]= $wt[4];
					$total_wh+=doubleval($wt[0]);
					
				}
				
				//get comment
				$sql="select * from comment where staff_id='".$rows['id']."' and DATE_FORMAT(date,'%Y-%m-%d')='".date("Y-m-d", $j)."'";
				$comment_one= $db->query_first($sql);
				$woking_time[$i]["comment"]= $comment_one["comment"];
				//echo "<!--$sql \n-->";

				$i++;
			}  	
			
			
		}	


		$o_smarty->assign("total_wh", $total_wh);



		if (isset($req["ac"]) && $req["ac"]==3){
		
			$sql="select * from project order by create_date desc";
			
			$project=array();	
			$rs = $db->query($sql);
			while ($rows = $db->fetch_array($rs)) {	
				$project[]= $rows;		
			}		


		
			$xl = new PHPExcel();
			$xl->setActiveSheetIndex(0);
			$sheet = $xl->getActiveSheet();
			$sheet->setTitle('Sheet1');
	
			
			$pageMargins = $sheet->getPageMargins();

			
			$pageMargins->setTop(0.3);
			$pageMargins->setBottom(0.3);
			$pageMargins->setLeft(0.6);
			$pageMargins->setRight(0.3);


			$sheet->mergeCells("A1:".chr(76+count($project))."1");
			$sheet->setCellValue('A1', "Time sheet");
			$sheet->getStyle("A1:".chr(76+count($project))."1")->getFont()->setBold(true)->setSize(20);


			$sheet->getStyle('A1')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
			);

			$sheet->mergeCells("A2:".chr(76+count($project))."2");
			$sheet->setCellValue('A2', "Created date: ".date("Y/m/d H:i"));
			$sheet->getStyle('A2')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
			);

			$sheet->setCellValue('A3', "STT");					
			$sheet->setCellValue('B3', "Mã NV");
			$sheet->setCellValue('C3', "Họ và đệm");
			$sheet->setCellValue('D3', "Tên");
			$sheet->setCellValue('E3', "Ngày");
			$sheet->setCellValue('F3', "Vào");
			$sheet->setCellValue('G3', "Ra");
			$sheet->setCellValue('H3', "Giờ công");
			$sheet->setCellValue('I3', "OT1");
			$sheet->setCellValue('J3', "OT2");
			$sheet->setCellValue('K3', "OT3");
			$sheet->setCellValue('L3', "OT4");
			
			
			for ($p=0;$p<count($project);$p++){
				$sheet->setCellValue(chr(77+$p)."3", $project[$p]["name"]);
			}	






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
		$stt=1;
		$i=4;
		while ($rows = $db->fetch_array($rs)) {	

			for ($j=$date_from; $j<=$date_to; $j+=86400) {  
				$sheet->setCellValue('A'.$i, $stt);
				$sheet->setCellValue('B'.$i, ' '.$rows["id"]);
				$sheet->setCellValue('C'.$i, $rows["first_name"]);
				$sheet->setCellValue('D'.$i, $rows["last_name"]);			
				$sheet->setCellValue('E'.$i, date("Y-m-d", $j));
				
				$sql="select * from time_sheet where staff_id='".$rows['id']."' and DATE_FORMAT(check_in,'%Y-%m-%d')='".date("Y-m-d", $j)."'";
				$time_sheet_one= $db->query_first($sql);
				if (!empty($time_sheet_one["check_in"])){
					$sheet->setCellValue('F'.$i, date("H:i",strtotime($time_sheet_one["check_in"])));					
				}
				
				if (!empty($time_sheet_one["check_out"])){
					$sheet->setCellValue('G'.$i, date("H:i",strtotime($time_sheet_one["check_out"])));					
				}		
				
				
				if (!empty($time_sheet_one["check_in"]) && !empty($time_sheet_one["check_out"])){
				
					$wt=$salary->work_hours($time_sheet_one["check_in"], $time_sheet_one["check_out"], $rows["id"], $db);
					$woking_time[$i]["work_hours"]= $wt[0];
					$woking_time[$i]["ot1"]= $wt[1];
					$woking_time[$i]["ot2"]= $wt[2];
					$woking_time[$i]["ot3"]= $wt[3];
					$woking_time[$i]["ot4"]= $wt[4];

					
					$sheet->setCellValue('H'.$i, $wt[0]);
					
					$sheet->setCellValue('I'.$i, $wt[1]);
					$sheet->setCellValue('J'.$i, $wt[2]);
					$sheet->setCellValue('K'.$i, $wt[3]);
					$sheet->setCellValue('L'.$i, $wt[4]);					
					

					
					for ($p=0;$p<count($project);$p++){
						$sql="select time from logwork where staff_id='".$rows["id"]."' and date='".date("Y-m-d", $j)."' and project_id=".$project[$p]['id'];
						//echo $sql;die;
						
						$logwork_one= $db->query_first($sql);
						if (!empty($logwork_one)){
							$sheet->setCellValue(chr(77+$p).$i, $logwork_one['time']);
						}
					}					

					
					
					
				}
				
						
				
				$stt++;
				$i++;
			}  	
			
			
		}	


			
			
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="Timesheet.xlsx"');
			header('Cache-Control: max-age=0');
			
			$writer = PHPExcel_IOFactory::createWriter($xl, 'Excel2007');
			$writer->save('php://output');		
			die;
			
								
		}


		$o_smarty->assign("woking_time",$woking_time);
		
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
	
	
			
		$o_smarty->display("timesheet/index.tpl");
	
  }  



  public function uploadAction(){
	$admin= Zend_Registry::get('admin');
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	$req=$this->getRequest()->getParams();
	
	
	  
	if (is_uploaded_file($_FILES["upfile"]["tmp_name"])) {
	  if (move_uploaded_file($_FILES["upfile"]["tmp_name"], "/var/www/html/timesheet.neoscorp.vn/tmp/" . $_FILES["upfile"]["name"])) {
		chmod("/var/www/html/timesheet.neoscorp.vn/tmp/" . $_FILES["upfile"]["name"], 0644);
		echo $_FILES["upfile"]["name"] . "をアップロードしました。<br>";
	  } else {
		echo "ファイルをアップロードできません。<br>";
	  }
	} else {
	  echo "ファイルが選択されていません。<br>";
	}

	
	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
	$db->connect();	

	$readFile ="/var/www/html/timesheet.neoscorp.vn/tmp/".$_FILES["upfile"]["name"];
	$objPHPExcel = PHPExcel_IOFactory::load($readFile);
	$data = $objPHPExcel->getActiveSheet()->toArray(null, true,true,true);
	
	//var_dump($data);die;
	
	
	
	$aryResult = array();
	for ($i=1; $i<count($data); $i++){
		if ($i<2) continue;
		
	
		$name = $data[$i]['A'];
		$date = $data[$i]['B'];
		$aryTmp = explode(" ", $date);
		
		if(!isset($aryResult[$aryTmp[0]])) {
			$aryResult[$aryTmp[0]][$name] = array(
				$date,
				$date
			);
		} elseif(!isset($aryResult[$aryTmp[0]][$name])) {
			$aryResult[$aryTmp[0]][$name] = array(
				$date,
				$date
			);
		} else {
			$aryResult[$aryTmp[0]][$name][1] = $date;
		}
		
		
		//save du lieu goc
		$date_time=explode(" ",$data[$i]['B']);
		$date_time0=explode("/",$date_time[0]);
		$date_time_v=$date_time0[2]."/".$date_time0[0]."/".$date_time0[1]." ".$date_time[1];
				
		$sql = "begin";
		$db->query($sql);

		$sql="select * from time_sheet_org where staff_id='".trim($data[$i]['A'])."' and date_time='".$date_time_v."'";
		$time_sheet_org= $db->query_first($sql);

		$sql="select * from staff where id_timesheet_machine='".trim($data[$i]['A'])."'";
		$staff_one= $db->query_first($sql);
		
			
		if (empty($time_sheet_org) && !empty($staff_one)){
			$datav=array();
			
			//var_dump($date_time0);die;
			
			$datav["staff_id"]=trim($data[$i]['A']);
			$datav["date_time"]=$date_time_v;
			$datav["create_date"]=time();
			
			if ($db->query_insert("time_sheet_org", $datav)===false){
				$db->query("rollback");
				$db->close();
				die("err1");
			}
							
			//var_dump($data);die;
		
		}
		

	}
	

	foreach($aryResult as $value){
		//var_dump($value);
		foreach($value as $key=>$value2){
		
		
			$check_in=explode(" ",$value2[0]);
			$check_in0=explode("/",$check_in[0]);
			$check_in_v=$check_in0[2]."/".$check_in0[0]."/".$check_in0[1]." ".$check_in[1];

		
			$check_out=explode(" ",$value2[1]);
			$check_out0=explode("/",$check_out[0]);
			$check_out_v=$check_out0[2]."/".$check_out0[0]."/".$check_out0[1]." ".$check_out[1];
		
			$sql="select * from staff where id_timesheet_machine='".trim($key)."'";
			$staff_one= $db->query_first($sql);
			
			$sql="select * from time_sheet where staff_id='".$staff_one['id']."' and DATE_FORMAT(check_in,'%Y/%m/%d')='".$check_in0[2]."/".sprintf('%02d',$check_in0[0])."/".sprintf('%02d',$check_in0[1])."'";
			$time_sheet= $db->query_first($sql);
		
					
			if (!empty($staff_one) && empty($time_sheet)){
			
				$datav=array();
				$datav["staff_id"]=$staff_one['id'];
				$datav["check_in"]=$check_in_v;
				$datav["check_out"]=$check_out_v;
				$datav["check_in_org"]=$check_in_v;
				$datav["check_out_org"]=$check_out_v;				
				$datav["create_date"]=time();
				$datav["last_update"]=time();
				$datav["last_update_staff_id"]=trim($key);
				$datav["last_update_staff_id"]=$admin->staff_id;
				if ($db->query_insert("time_sheet", $datav)===false){
					$db->query("rollback");
					$db->close();
					die("err2");
				}				
						
			}
				
			//echo $key.$value2[0].$value2[1];
			//print_r($value2);
			//echo "<br>---------------------<br>";
		
		}
	}
		
	
	//$sql="insert into time_sheet(staff_id, check_in, check_out, create_date, last_update, last_update_staff_id) select "
	
	$db->query("commit");	
	$db->close();
	header("location: /timesheet/");
		
	//echo count($data);
	
		//echo "<pre>";
		///print_r($aryResult);
  
  }










  
}