<?php
require_once 'MyZendControllerAction.php';
require_once('Smarty/Smarty.class.php');
require_once 'function.php';
require_once 'Staff.php';
require_once '/var/www/html/timesheet.neoscorp.vn/library/PHPExcel-1.8/Classes/PHPExcel.php';
require_once '/var/www/html/timesheet.neoscorp.vn/library/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';


class AccessoriesController extends MyZendControllerAction{


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
			$data["name"]=$req["name"];
			$data["description"]=$req["description"];
			$data["staff_id"]=$req["staff_id"];
			if (!empty($req["buy_date"])) $data["buy_date"]=$req["buy_date"];
			$data["service_tag"]=$req["service_tag"];
			$data["mfg_yr"]=$req["mfg_yr"];
			$data["express_service_code"]=$req["express_service_code"];
			$data["invoice"]=$req["invoice"];
			$data["provider"]=$req["provider"];
			$data["ram"]=$req["ram"];
			$data["win_license"]=$req["win_license"];
			$data["anti_virus"]=$req["anti_virus"];
			$data["office"]=$req["office"];
			if (!empty($req["os"])) 
				$data["os"]=serialize($req["os"]);
			else
				$data["os"]="null";
			$data["create_date"]=time();
			$data["last_update"]=time();
			$data["last_updte_staff_id"]=$admin->staff_id;
			$db->query_insert("accessories", $data);
			$db->close();
			header("location: /accessories/");die;
			
			
		
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
	
		
		$o_smarty->display("accessories/add.tpl");


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
			$con .=" AND (a.name like '%".$req["q"]."%' OR a.description like '%".$req["q"]."%')";	
		}

		if (!empty($req["staff_id"])){
			$con .=" AND a.staff_id='".$req["staff_id"]."'";
		}
			

		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
		
		
		if (isset($req["ac"]) && $req["ac"]==3){
		
	


		
			$xl = new PHPExcel();
			$xl->setActiveSheetIndex(0);
			$sheet = $xl->getActiveSheet();
			$sheet->setTitle("Danh sách thiết bị");
	
			
			$pageMargins = $sheet->getPageMargins();

			
			$pageMargins->setTop(0.3);
			$pageMargins->setBottom(0.3);
			$pageMargins->setLeft(0.6);
			$pageMargins->setRight(0.3);


			//$sheet->mergeCells("A1:".chr(76+count($project))."1");
			$sheet->setCellValue('A1', "Danh sách thiết bị");
			$sheet->getStyle("A1")->getFont()->setBold(true)->setSize(16);
			$sheet->mergeCells("A1:N1");
			
			$sheet->setCellValue('A3', "ID");
			$sheet->setCellValue('B3', "Accessories Name");
			$sheet->setCellValue('C3', "Staff Name");
			$sheet->setCellValue('D3', "Order Date");
			$sheet->setCellValue('E3', "service_tag");
			$sheet->setCellValue('F3', "mfg_yr");
			$sheet->setCellValue('G3', "express_service_code");
			$sheet->setCellValue('H3', "invoice");
			$sheet->setCellValue('I3', "provider");
			$sheet->setCellValue('J3', "ram");
			$sheet->setCellValue('K3', "win_license");
			$sheet->setCellValue('L3', "anti_virus");
			$sheet->setCellValue('M3', "office");
			$sheet->setCellValue('N3', "os");
			
			
										

			//$sheet->getStyle("A3")->getFont()->setBold(true);
			

			$sql="select a.*, b.first_name, b.last_name from accessories a 
			left join staff b on a.staff_id=b.id";
			
			$project=array();	
			$rs = $db->query($sql);
			$i=4;
			while ($rows = $db->fetch_array($rs)) {	
				$sheet->setCellValue('A'.$i, ' '.$rows["id"]);
				$sheet->setCellValue('B'.$i, ' '.$rows["name"]);
				$sheet->setCellValue('C'.$i, ' '.$rows["first_name"]." ".$rows["last_name"]);
				$sheet->setCellValue('D'.$i, ' '.$rows["buy_date"]);
				$sheet->setCellValue('E'.$i, ' '.$rows["service_tag"]);
				$sheet->setCellValue('F'.$i, ' '.$rows["mfg_yr"]);
				$sheet->setCellValue('H'.$i, ' '.$rows["express_service_code"]);
				$sheet->setCellValue('H'.$i, ' '.$rows["invoice"]);
				$sheet->setCellValue('I'.$i, ' '.$rows["provider"]);
				$sheet->setCellValue('J'.$i, ' '.$rows["ram"]);
				$sheet->setCellValue('K'.$i, ' '.$rows["win_license"]);
				$sheet->setCellValue('L'.$i, ' '.$rows["anti_virus"]);
				$sheet->setCellValue('M'.$i, ' '.$rows["office"]);
				$os="";
				if (!empty($rows["os"])) $os=implode(", ", unserialize($rows["os"]));
				$sheet->setCellValue('N'.$i, $os);
				$i++;
			}				
			

			
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="Danh sach thiet bi.xlsx"');
			header('Cache-Control: max-age=0');
			
			$writer = PHPExcel_IOFactory::createWriter($xl, 'Excel2007');
			$writer->save('php://output');		
			die;
			
								
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

		

		$sql="select a.*, b.first_name, b.last_name from accessories a 
		left join staff b on a.staff_id=b.id
		where 1=1 $con ";
		
		
	
		$db->query($sql); 
		$itemcnt=$db->affected_rows;	
	
		$allpagenum = ceil($itemcnt/$limit);
		$o_smarty->assign("allpagenum",$allpagenum);
	
		$order="order by a.create_date";
		if (!empty($req["sort_fileds"])){
			$order="order by {$req["sort_fileds"]}";
		}
	
	
		$sql = $sql." $order LIMIT ".(($p - 1) * $limit)." ";
		$sql = $sql.",".$limit." ";


		
			
		$accessories=array();	
		$rs = $db->query($sql);
		$i=0;
		while ($rows = $db->fetch_array($rs)) {	
			$accessories[$i]= $rows;	
			if (!empty($rows["os"])) $accessories[$i]["os"]=implode(", ", unserialize($rows["os"]));
			
			//unserialize($rows["os"]);
			$i++;	
		}	
			
		
		$o_smarty->assign("accessories",$accessories);		



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
		
		
		
	$sql="select * from staff where valid=0";


	$store_staff=array();
	$rs = $db->query($sql);	
	$i=0;
	while ($rows = $db->fetch_array($rs)){
		$staff[$i]= $rows;
		
		$i++;
	}	
	$o_smarty->assign("staff",$staff);

$db->close();
		
		$o_smarty->display("accessories/index.tpl");
	
	
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
	

	$sql="select * from accessories where id=".$req["id"];
	$accessories_one= $db->query_first($sql);	
	$o_smarty->assign("accessories_one",$accessories_one);
	if (!empty($accessories_one["os"])){
		$o_smarty->assign("os",unserialize($accessories_one["os"]));
	}


	
	
	
	if (isset($req["ac"]) && $req["ac"]==1){			
			$data=array();
			$data["name"]=$req["name"];
			$data["description"]=$req["description"];
			$data["staff_id"]=$req["staff_id"];
			if (!empty($req["buy_date"])) 
				$data["buy_date"]=$req["buy_date"];
			else
				$data["buy_date"]="null";
			$data["service_tag"]=$req["service_tag"];
			$data["mfg_yr"]=$req["mfg_yr"];
			$data["express_service_code"]=$req["express_service_code"];
			$data["invoice"]=$req["invoice"];
			$data["provider"]=$req["provider"];
			$data["ram"]=$req["ram"];
			$data["win_license"]=$req["win_license"];
			$data["anti_virus"]=$req["anti_virus"];
			$data["office"]=$req["office"];
			if (!empty($req["os"])) 
				$data["os"]=serialize($req["os"]);
			else
				$data["os"]="null";
			$data["create_date"]=time();
			$data["last_update"]=time();
			$data["last_updte_staff_id"]=$admin->staff_id;

			$db->query_update("accessories", $data, "id=".$req["id"]);

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
			location.href="/accessories/edit/?id=<?=$req["id"]?>";
			-->
			</script>
			</body>
			</html>		
			<?			
			
			

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
		
	
		
	$o_smarty->display("accessories/edit.tpl");
}  


	

  
}