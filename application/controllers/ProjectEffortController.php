<?php
require_once 'MyZendControllerAction.php';
require_once('Smarty/Smarty.class.php');
require_once 'function.php';
require_once 'Staff.php';

class ProjectEffortController extends MyZendControllerAction{


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
			$data["project_id"]=$req["id"];
			$data["position_id"]=$req["position_id"];
			$data["staff_id"]=$req["staff_id"];
			$data["from_date"]=$req["from_date"];
			$data["to_date"]=$req["to_date"];
			$data["effort"]=intval($req["effort"]);
			$data["create_by_staff_id"]=$admin->staff_id;
			
			$db->query_insert("project_detail", $data);
			$db->close();

			header("location: /project-effort/");die;
			
			
		
		}


		
		$sql="select * from project where id=".$req["id"];
		$project_one= $db->query_first($sql);	
		$o_smarty->assign("project_one",$project_one);		
		


		$sql="select * from staff where valid=0";
		$staff=array();	
		$rs = $db->query($sql);
		$i=0;
		while ($rows = $db->fetch_array($rs)) {	
			$staff[$i]= $rows;		
			$i++;	
		}	
		
		$o_smarty->assign("staff",$staff);	
	
	
	
		$sql="select * from position";
		$position=array();	
		$rs = $db->query($sql);
		$i=0;
		while ($rows = $db->fetch_array($rs)) {	
			$position[$i]= $rows;		
			$i++;	
		}	
		
		$o_smarty->assign("position",$position);
				
		$o_smarty->display("project-effort/add.tpl");


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
		
		$fromdate=date("Y/m/01");
		if (!empty($req["fromdate"])) $fromdate=$req["fromdate"];


		$todate=date("Y/m/t");
		if (!empty($req["todate"])) $todate=$req["todate"];
		
		
		
		$con .=" AND finish_date>=".strtotime($fromdate);	
		$con .=" AND finish_date>=".strtotime($todate);	
		
		//Thong ke
		$sql="select sum(a.effort) as total_effort, a.staff_id, b.first_name, b.last_name from project_detail a 
left join staff b on a.staff_id=b.id
left join project c on a.project_id=c.id
where a.from_date>='".$fromdate."' and a.to_date<='".$todate."'";
		if (!empty($req["q"])){
			$sql .=" AND (a.project_id like '".$req["q"]."%' OR c.name like '%".$req["q"]."%')";	
		}
		
		$sql .=" group by a.staff_id";

		$project_sumary=array();	
		$rs = $db->query($sql);
		$i=0;
		while ($rows = $db->fetch_array($rs)) {	
			$project_sumary[$i]= $rows;	
			$project_sumary[$i]["use"]= round($rows["total_effort"]*($this->getWorkingDays($fromdate,$todate)/100));	
			$project_sumary[$i]["free"]= 100-round($rows["total_effort"]*($this->getWorkingDays($fromdate,$todate)/100));
				
			
			$i++;	
		}
		$o_smarty->assign("project_sumary",$project_sumary);	
		
				

		$sql="select * from project where 1=1 $con order by create_date desc";		
		$project=array();	
		$rs = $db->query($sql);
		$i=0;
		while ($rows = $db->fetch_array($rs)) {	
			$project[$i]= $rows;		
			$sql2="select a.*, b.name as position_name, c.first_name, c.last_name from project_detail a 
			left join position b on a.position_id=b.id
			left join staff c on a.staff_id=c.id
			where a.project_id=".$rows["id"];
			$rs2 = $db->query($sql2);
			while ($rows2 = $db->fetch_array($rs2)) {
				$project[$i]["detail"][]=$rows2;
			}	
			
			$i++;	
		}	
			
		$db->close();


		$o_smarty->assign("project",$project);		
		
		
		
		$o_smarty->display("project-effort/index.tpl");
	
	
	}
  
  
function getWorkingDays($startDate,$endDate){
    // do strtotime calculations just once
    $endDate = strtotime($endDate);
    $startDate = strtotime($startDate);


    //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
    //We add one to inlude both dates in the interval.
    $days = ($endDate - $startDate) / 86400 + 1;

    $no_full_weeks = floor($days / 7);
    $no_remaining_days = fmod($days, 7);

    //It will return 1 if it's Monday,.. ,7 for Sunday
    $the_first_day_of_week = date("N", $startDate);
    $the_last_day_of_week = date("N", $endDate);

    //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
    //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
    if ($the_first_day_of_week <= $the_last_day_of_week) {
        if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
        if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
    }
    else {
        // (edit by Tokes to fix an edge case where the start day was a Sunday
        // and the end day was NOT a Saturday)

        // the day of the week for start is later than the day of the week for end
        if ($the_first_day_of_week == 7) {
            // if the start date is a Sunday, then we definitely subtract 1 day
            $no_remaining_days--;

            if ($the_last_day_of_week == 6) {
                // if the end date is a Saturday, then we subtract another day
                $no_remaining_days--;
            }
        }
        else {
            // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
            // so we skip an entire weekend and subtract 2 days
            $no_remaining_days -= 2;
        }
    }

    //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
   $workingDays = $no_full_weeks * 5;
    if ($no_remaining_days > 0 )
    {
      $workingDays += $no_remaining_days;
    }    


    return $workingDays;
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


	$sql="select * from project_detail where id=".$req["id"];
	$project_detail_one= $db->query_first($sql);	
	$o_smarty->assign("project_detail_one",$project_detail_one);		



	if ($admin->role!=2 && $admin->staff_id != $project_detail_one["create_by_staff_id"]){
		die("Error: No permission");
		$db->close();
	}
	


	$admin= Zend_Registry::get('admin');
	
	$o_smarty->assign("domain",DOMAIN);
	

	
	
	if (isset($req["ac"]) && $req["ac"]==1){
		
			
			
		
			$data=array();
			$data["project_id"]=$req["id"];
			$data["position_id"]=$req["position_id"];
			$data["staff_id"]=$req["staff_id"];
			$data["from_date"]=$req["from_date"];
			$data["to_date"]=$req["to_date"];
			$data["effort"]=intval($req["effort"]);
			$db->query_update("project_detail", $data, "id=".$req["id"]);
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
			location.href="/project-effort/edit/?id=<?=$req["id"]?>";
			-->
			</script>
			</body>
			</html>		
			<?			
			
			

	}
	
	
	

		$sql="select * from project where id=".$project_detail_one["project_id"];
		$project_one= $db->query_first($sql);	
		$o_smarty->assign("project_one",$project_one);		
		


		$sql="select * from staff where valid=0";
		$staff=array();	
		$rs = $db->query($sql);
		$i=0;
		while ($rows = $db->fetch_array($rs)) {	
			$staff[$i]= $rows;		
			$i++;	
		}	
		
		$o_smarty->assign("staff",$staff);	
	
	
	
		$sql="select * from position";
		$position=array();	
		$rs = $db->query($sql);
		$i=0;
		while ($rows = $db->fetch_array($rs)) {	
			$position[$i]= $rows;		
			$i++;	
		}	
		
		$o_smarty->assign("position",$position);
				
	
		
		$o_smarty->display("project-effort/edit.tpl");
}  





public function deleteAction(){
	$req=$this->getRequest()->getParams();
	$admin= Zend_Registry::get('admin');	


	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
	$db->connect();	


	$sql="select * from project_detail where id=".$req["id"];
	$project_detail_one= $db->query_first($sql);	

	if ($admin->role!=2 && $admin->staff_id != $project_detail_one["create_by_staff_id"]){
		die("Error: No permission");
		$db->close();
	}	
			

	$db->query("delete from project_detail where id=".$req["id"]);
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
	location.href="/project-effort/";
	-->
	</script>
	</body>
	</html>		
	<?			
	
} 	

  
}