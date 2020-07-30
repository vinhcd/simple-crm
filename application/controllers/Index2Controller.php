<?php
require_once 'MyZendControllerAction.php';
require_once('Smarty/Smarty.class.php');


class Index2Controller extends MyZendControllerAction{


	public function init()
	{
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
	

	$admin= Zend_Registry::get('admin');	
	$o_smarty->assign("admin",$admin);
	$o_smarty->assign("loginid",$admin->login_id);
	$o_smarty->assign("login_opt",$admin->login_opt);
	$o_smarty->assign("staff_name",$admin->staff_name);
	$req=$this->getRequest()->getParams();
	$o_smarty->assign("controller",$req["controller"]);
	$o_smarty->assign("action",$req["action"]);
	//var_dump($req);
	
	
	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
	$db->connect();	

	$cond="";
	$cond2="";	

	if (!empty($req["fromdate"])){
		$cond .=" AND a.check_in_org>='".$req["fromdate"]."'";
		$cond2 .=" AND DATE_FORMAT(birthday, '%m-%d')>='".date("m-t",strtotime($req["fromdate"]))."'";
	}else{
		$cond .=" AND a.check_in_org>='".date("Y-m-01 00:00:00", strtotime("-1 months"))."'";
	}
	

	if (!empty($req["todate"])){
		$cond .=" AND a.check_in_org<='".$req["todate"]." 23:59:59'";
	}else{
		$cond .=" AND a.check_in_org<='".date("Y-m-t 23:59:59", strtotime("-1 months"))."'";
	}

		
		/*
		$sql="select staff_id, count(*) as times, b.id, b.first_name, b.last_name from 
(select staff_id, MIN(date_time) as latetime from time_sheet_org 
where 1=1 $cond
group by staff_id, DATE_FORMAT(date_time,'%Y-%m-%d') HAVING latetime>DATE_FORMAT(latetime,'%Y-%m-%d 8:30:00') order by staff_id, date_time) as xxx 
left join staff b on xxx.staff_id=b.id_timesheet_machine
group by staff_id order by times desc";
		*/
		
		$sql="
		select a.staff_id, b.first_name, b.last_name, count(*) as times FROM time_sheet a 
		left join staff b on a.staff_id=b.id
		where 
		1=1 $cond and 
		((DAYOFWEEK(a.check_in_org)<>1 AND DAYOFWEEK(a.check_in_org)<>7 AND a.check_in_org>DATE_FORMAT(a.check_in_org,'%Y-%m-%d 8:30:00')  and a.check_out_org>DATE_FORMAT(a.check_in_org,'%Y-%m-%d 13:30:00')) 
		or (DAYOFWEEK(a.check_in_org)<>1 AND DAYOFWEEK(a.check_in_org)<>7 AND a.check_in_org>DATE_FORMAT(a.check_in_org,'%Y-%m-%d 8:30:00')  and a.check_out_org<DATE_FORMAT(a.check_in_org,'%Y-%m-%d 13:30:00')) 
		or (DAYOFWEEK(a.check_in_org)<>1 AND DAYOFWEEK(a.check_in_org)<>7 AND a.check_in_org>DATE_FORMAT(a.check_in_org,'%Y-%m-%d 13:30:00')))
		GROUP BY a.staff_id
		ORDER BY times desc
		";		
		$rs = $db->query($sql);
		$i=0;
		$golate=array();
		$id_list="";
		while ($rows = $db->fetch_array($rs)) {	
			$golate[$i]=$rows;
			$id_list .="'".$rows["staff_id"]."',";		
			$i++;
		}	
		
		$id_list=substr($id_list,0,strlen($id_list)-1);
		$sql="select * from staff where valid=0";
		if ($id_list!="") $sql .=" and id not in($id_list)";
		$rs = $db->query($sql);
		while ($rows = $db->fetch_array($rs)) {	
			$golate[$i]=$rows;
			$golate[$i]["staff_id"]=$rows["id"];
			$golate[$i]["times"]=0;
			$i++;
		}	
		$o_smarty->assign("golate",$golate);	

		
		
		$sql="select * from staff where DATE_FORMAT(birthday, '%m-%d')>='".date("m-01")."' and DATE_FORMAT(birthday, '%m-%d')<='".date("m-t")."'";
		$rs = $db->query($sql);
		$birthday=array();
		while ($rows = $db->fetch_array($rs)) {	
			$birthday[$i]=$rows;
			
			$i++;
		}	
		$o_smarty->assign("birthday",$birthday);	

	/*
	
	
	


		$cond="";
		$url="";
	
	
		if (!empty($req["fromdate"])){	 	
			$temp1=explode("/",$req["fromdate"]);		
			$cond .=" AND ngay>='".$temp1[2]."/".$temp1[1]."/".$temp1[0]."'";
			$url .="&fromdate=".$temp1[0]."/".$temp1[1]."/".$temp1[2];	 
		}
		
		if (!empty($req["todate"])){	
			 $temp1=explode("/",$req["todate"]);	
			 $cond .=" AND ngay<='".$temp1[2]."/".$temp1[1]."/".$temp1[0]." 23:59:59'";
			 $url .="&todate=".$temp1[0]."/".$temp1[1]."/".$temp1[2];
		}
	
		$o_smarty->assign("url",$url);	
	
	
	
	
	
	
	
	
		$p=1;
		if (!empty($req["p"])) $p=$req["p"];
		$limit=10;
		$sql="select * from sale_by_day where 1=1 $cond";	
		$db->query($sql); 
		$itemcnt=$db->affected_rows;	
		$allpagenum = ceil($itemcnt/$limit);
		$o_smarty->assign("allpagenum",$allpagenum);
		
		
		
		if ($itemcnt>$limit){
			$sql = $sql." order by ngay asc LIMIT ".($itemcnt-$limit)." ";
			$sql = $sql.",".$limit." ";
		}else $sql = $sql." order by ngay asc";
			
			
		
				
		$sale_by_day=array();
		$income=array();
		$rs = $db->query($sql);
		$i=0;
		$tongdoanhthu=0;
		while ($rows = $db->fetch_array($rs)) {	
			$sale_by_day[$i]=$rows;		
			$i++;
			$tongdoanhthu=$tongdoanhthu+(float)$rows["tongdoanhthu"];
		
		}	
		$o_smarty->assign("sale_by_day",$sale_by_day);	
		$o_smarty->assign("tongdoanhthu",$tongdoanhthu);	
//	echo number_format($tongdoanhthu);
	
		$start=0;
		$finish=0;	
		if (empty($c)) {
			$start=1;
			
			if ($allpagenum>7) 
				$finish=7;
			else
				$finish=$allpagenum;			
			
		}else{
		
			if ($c<5){
				$start=1;
				if ($allpagenum<7){
					$finish=$allpagenum;
				}else{
					$finish=7;
				}
							
			}else{
				$start=$c-3;
				
				$finish=$c+3;
				
				if ($c>($allpagenum-3)) $finish=$allpagenum;
			}
			
		}
		
		$o_smarty->assign("start", $start);
		$o_smarty->assign("finish", $finish);	
		$o_smarty->assign("p", $p);	
	
	*/
	
	
	
	
	
	
			$o_smarty->display("index/index2.tpl");


	
  }
  
  
  
  

 

  
}