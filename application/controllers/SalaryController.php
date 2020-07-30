<?php
require_once 'MyZendControllerAction.php';
require_once('Smarty/Smarty.class.php');
require_once 'function.php';
require_once 'Salary.php';
require_once 'Common.php';
//include 'phpexcel/Classes/PHPExcel.php';
//include 'phpexcel/Classes/PHPExcel/IOFactory.php';
require_once '/var/www/html/timesheet.neoscorp.vn/library/PHPExcel-1.8/Classes/PHPExcel.php';
require_once '/var/www/html/timesheet.neoscorp.vn/library/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';

class salaryController extends MyZendControllerAction{

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


	public function chksettingAction()
	{
		$req=$this->getRequest()->getParams();	 


		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
		
		$sql="select * from salary_setting where yearmonth='".$req["yearmonth"]."'";	
		$salary_setting= $db->query_first($sql);
		

		if (empty($salary_setting)) echo "1";
		die;
	}
	
	
	public function otherSettingAction(){

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

			if (empty($req["luong_quyettoanconlaitrongnam"]))
				$data["luong_quyettoanconlaitrongnam"]='NULL';
			else
				$data["luong_quyettoanconlaitrongnam"]=$req["luong_quyettoanconlaitrongnam"];

			if (empty($req["luong_tienchucmungchiabuon"]))
				$data["luong_tienchucmungchiabuon"]='NULL';
			else
				$data["luong_tienchucmungchiabuon"]=removecomma2($req["luong_tienchucmungchiabuon"]);

			if (empty($req["luong_dieuchinhtruoctongluong"]))
				$data["luong_dieuchinhtruoctongluong"]='NULL';
			else
				$data["luong_dieuchinhtruoctongluong"]=removecomma2($req["luong_dieuchinhtruoctongluong"]);

			if (empty($req["luong_sogionghiphepnghibu"]))
				$data["luong_sogionghiphepnghibu"]='NULL';
			else
				$data["luong_sogionghiphepnghibu"]=removecomma2($req["luong_sogionghiphepnghibu"]);
				
			
			if (empty($req["luong_thunhapkhac"]))
				$data["luong_thunhapkhac"]='NULL';
			else
				$data["luong_thunhapkhac"]=removecomma2($req["luong_thunhapkhac"]);

			if (empty($req["luong_thangluongthu13"]))
				$data["luong_thangluongthu13"]='NULL';
			else
				$data["luong_thangluongthu13"]=removecomma2($req["luong_thangluongthu13"]);

			if (empty($req["luong_trocapbaohiem_trathuenopthua"]))
				$data["luong_trocapbaohiem_trathuenopthua"]='NULL';
			else
				$data["luong_trocapbaohiem_trathuenopthua"]=removecomma2($req["luong_trocapbaohiem_trathuenopthua"]);

			if (empty($req["luong_thangtruocchuyenqua"]))
				$data["luong_thangtruocchuyenqua"]='NULL';
			else
				$data["luong_thangtruocchuyenqua"]=removecomma2($req["luong_thangtruocchuyenqua"]);



			if (empty($req["luong_phepdauky"]))
				$data["luong_phepdauky"]='NULL';
			else
				$data["luong_phepdauky"]=$req["luong_phepdauky"];



			
			if (!$db->query_update("salary_personal_setting", $data, "yearmonth='".$req["yearmonth"]."' and staff_id='".$req['staff_id']."'")){
				$db->query("rollback");
				$db->close();
				die("err2");				
			}			
		
			
			$db->query("commit");	
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
			alert("Update successfully");
			location.href="/salary/setting/?yearmonth=<?=$req["yearmonth"]?>";
			-->
			</script>
			</body>
			</html>		
			<?						
			die;
		
		}
		

		$sql="select * from salary_personal_setting where staff_id='".$req["staff_id"]."' and yearmonth='".$req["yearmonth"]."'";
		$salary_personal_setting_one= $db->query_first($sql);
		$o_smarty->assign("salary_personal_setting_one",$salary_personal_setting_one);
	
	//	var_dump($salary_setting_one);
		
		$o_smarty->display("salary/other-setting.tpl");


	}


public function settingAction(){
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




	$current_year = date("Y");
	if (!empty($req["yearmonth"])) $current_year=explode("/",$req["yearmonth"])[0];
	$o_smarty->assign("current_year",$current_year);
	
	$current_month = date("m");
	if (!empty($req["yearmonth"])) $current_month=explode("/",$req["yearmonth"])[1];
	$o_smarty->assign("current_month",$current_month);
		
	
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



	
		
	$o_smarty->display("salary/setting.tpl");
}




public function loadsettingAction()
{
	$req=$this->getRequest()->getParams();
	$admin= Zend_Registry::get('admin');	
	
	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
	$db->connect();	

	$json=array();
	$sql="select * from salary_setting where yearmonth='".$req["year_month"]."'";
	//echo $sql;die;
	
	$salary_setting_one= $db->query_first($sql);
	$json=$salary_setting_one;
	
	
	$sql="select a.*, b.first_name, b.last_name from salary_personal_setting a 
	left join staff b on a.staff_id=b.id
	where a.yearmonth='".$req["year_month"]."'";
	
	$rs = $db->query($sql);	
	$i=0;
	while ($rows = $db->fetch_array($rs)){
		$json["product"][$i]=$rows;
		$i++;
	}	
	
	
	header("Content-Type: text/javascript; charset=utf-8");
	echo json_encode($json);
	die;
}
	


	public function saveAction(){
	
		$req=$this->getRequest()->getParams();
		$admin= Zend_Registry::get('admin');	
		
		
		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
		
		//トランザクションをはじめる準備
		$sql = "set autocommit = 0";
		$db->query($sql);
	
		//トランザクション開始
		$sql = "begin";
		$db->query($sql);
		
		$sql="delete from salary_setting where yearmonth='".$req["year_month"]."'";

		if (!$db->query($sql)){
			$db->query("rollback");
			$db->close();
			die("err2");
		}
		
		$data=array();
		$data["yearmonth"]=$req["year_month"];
		$data["luong_songaylamviec"]=$req["luong_songaylamviec"];
		$data["luong_luongcoso"]=removecomma2($req["luong_luongcoso"]);
		$data["luong_lamthemngaythuong"]=$req["luong_lamthemngaythuong"];
		$data["luong_lamthemdemngaythuong"]=$req["luong_lamthemdemngaythuong"];
		$data["luong_lamthemcuoituan"]=$req["luong_lamthemcuoituan"];
		$data["luong_lamthemngayle"]=$req["luong_lamthemngayle"];
		$data["luong_congtybaohiemxahoi"]=$req["luong_congtybaohiemxahoi"];
		$data["luong_congtybaohiemyte"]=$req["luong_congtybaohiemyte"];
		$data["luong_congtybaohiemthatnghiep"]=$req["luong_congtybaohiemthatnghiep"];
		$data["luong_congtykinhphicongdoan"]=$req["luong_congtykinhphicongdoan"];
		$data["luong_canhanbaohiemxahoi"]=$req["luong_canhanbaohiemxahoi"];
		$data["luong_canhanbaohiemyte"]=$req["luong_canhanbaohiemyte"];
		$data["luong_canhanbaohiemthatnghiep"]=$req["luong_canhanbaohiemthatnghiep"];
		$data["luong_giamtrubanthan"]=removecomma2($req["luong_giamtrubanthan"]);
		$data["luong_giamtrunguoiphuthuoc"]=removecomma2($req["luong_giamtrunguoiphuthuoc"]);	
		
		if ($db->query_insert("salary_setting", $data)===false){
			$db->query("rollback");
			$db->close();
			die("err3");
		}	
			
		//コミット
		$db->query("commit");	
		$db->close();		
		die("ok");
	}	
	
	
	

	public function copyAction(){
	
		$req=$this->getRequest()->getParams();
		$admin= Zend_Registry::get('admin');	
		
		
		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
		

//echo $req["year_month"]."/01";die;
		
		$sql="select * from salary_setting where yearmonth='".date("Y/m", strtotime("-1 months", strtotime($req["year_month"]."/01")))."'";
		//echo $sql;die;
		$salary_setting_one= $db->query_first($sql);	
		if (empty($salary_setting_one)){
			die("err1");
			$db->close();
		}

		
		//トランザクションをはじめる準備
		$sql = "set autocommit = 0";
		$db->query($sql);
	
		//トランザクション開始
		$sql = "begin";
		$db->query($sql);
		
		
		
		$sql="select * from salary_setting where yearmonth='".$req["year_month"]."'";
		$salary_setting_one= $db->query_first($sql);	
		if (empty($salary_setting_one)){
			$sql="insert into salary_setting select * from salary_setting where ";

		}
		
				
		
		$sql="delete from salary_setting where yearmonth='".$req["year_month"]."'";

		if (!$db->query($sql)){
			$db->query("rollback");
			$db->close();
			die("err2");
		}
		
		
		$sql="insert into salary_setting(
				yearmonth,
				luong_songaylamviec,
				luong_luongcoso,
				luong_lamthemngaythuong,
				luong_lamthemdemngaythuong,
				luong_lamthemcuoituan,
				luong_lamthemngayle,
				luong_congtybaohiemxahoi,
				luong_congtybaohiemyte,
				luong_congtybaohiemthatnghiep,
				luong_congtykinhphicongdoan,
				luong_canhanbaohiemxahoi,
				luong_canhanbaohiemyte,
				luong_canhanbaohiemthatnghiep,
				luong_giamtrubanthan,
				luong_giamtrunguoiphuthuoc		
		)select 
				'".$req["year_month"]."',
				luong_songaylamviec,
				luong_luongcoso,
				luong_lamthemngaythuong,
				luong_lamthemdemngaythuong,
				luong_lamthemcuoituan,
				luong_lamthemngayle,
				luong_congtybaohiemxahoi,
				luong_congtybaohiemyte,
				luong_congtybaohiemthatnghiep,
				luong_congtykinhphicongdoan,
				luong_canhanbaohiemxahoi,
				luong_canhanbaohiemyte,
				luong_canhanbaohiemthatnghiep,
				luong_giamtrubanthan,
				luong_giamtrunguoiphuthuoc	
		  from 	salary_setting where yearmonth='".date("Y/m", strtotime("-1 months", strtotime($req["year_month"]."/01")))."'
		";	
		
		if ($db->query($sql)===false){
			$db->query("rollback");
			$db->close();
			die("err3");
		}	
			
		//コミット
		$db->query("commit");	
		$db->close();		
		die("ok");
	}
	


	public function personalsettingAction(){
	
		$req=$this->getRequest()->getParams();
		$admin= Zend_Registry::get('admin');	
		
		
		$salary = new Salary();
		$common = new Common();
		//if (!$permission->check_access_page($admin->staff_id, self::$page_id)){


		
		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
		
		//トランザクションをはじめる準備
		$sql = "set autocommit = 0";
		$db->query($sql);
	
		//トランザクション開始
		$sql = "begin";
		$db->query($sql);
		
		
		$sql="select * from salary_setting where yearmonth='".$req["year_month"]."'";
		$salary_setting_one= $db->query_first($sql);

		
		$sql="select * from staff where valid=0";		
		$rs = $db->query($sql);	
		while ($rows = $db->fetch_array($rs)){
			$sql="select * from salary_personal_setting where yearmonth='".$req["year_month"]."' and staff_id='".$rows['id']."'";
			$salary_personal_setting_one=$db->query_first($sql);	
			if (empty($salary_personal_setting_one)){
				$data=array();
				$data["staff_id"]=$rows["id"];
				$data["yearmonth"]=$req["year_month"];
				
				if (empty($rows["luong_luongcoban"]))
					$data["luong_luongcoban"]="null";
				else
					$data["luong_luongcoban"]=$rows["luong_luongcoban"];

				if (empty($rows["luong_songuoiphuthuoc"]))
					$data["luong_songuoiphuthuoc"]="null";
				else
					$data["luong_songuoiphuthuoc"]=$rows["luong_songuoiphuthuoc"];

				if (empty($rows["luong_trocapdilai"]))
					$data["luong_trocapdilai"]="null";
				else
					$data["luong_trocapdilai"]=$rows["luong_trocapdilai"];

				if (empty($rows["luong_trocaptiengnhat"]))
					$data["luong_trocaptiengnhat"]="null";
				else
					$data["luong_trocaptiengnhat"]=$rows["luong_trocaptiengnhat"];
				
				
				if (empty($rows["luong_trocaplienlac"]))
					$data["luong_trocaplienlac"]="null";
				else
					$data["luong_trocaplienlac"]=$rows["luong_trocaplienlac"];

				if (empty($rows["luong_trocapguixe"]))
					$data["luong_trocapguixe"]="null";
				else
					$data["luong_trocapguixe"]=$rows["luong_trocapguixe"];

				if (empty($rows["luong_trocaptrachnhiem"]))
					$data["luong_trocaptrachnhiem"]="null";
				else
					$data["luong_trocaptrachnhiem"]=$rows["luong_trocaptrachnhiem"];

				if (empty($rows["luong_trocapantrua"]))
					$data["luong_trocapantrua"]="null";
				else
					$data["luong_trocapantrua"]=$rows["luong_trocapantrua"];
					
				if ($db->query_insert("salary_personal_setting", $data)===false){
					$db->query("rollback");
					$db->close();
					die("err2");
				}				
			}else{
				$data=array();
				
				if (empty($rows["luong_luongcoban"]))
					$data["luong_luongcoban"]="null";
				else
					$data["luong_luongcoban"]=$rows["luong_luongcoban"];

				if (empty($rows["luong_songuoiphuthuoc"]))
					$data["luong_songuoiphuthuoc"]="null";
				else
					$data["luong_songuoiphuthuoc"]=$rows["luong_songuoiphuthuoc"];

				if (empty($rows["luong_trocapdilai"]))
					$data["luong_trocapdilai"]="null";
				else
					$data["luong_trocapdilai"]=$rows["luong_trocapdilai"];

				if (empty($rows["luong_trocaptiengnhat"]))
					$data["luong_trocaptiengnhat"]="null";
				else
					$data["luong_trocaptiengnhat"]=$rows["luong_trocaptiengnhat"];
				
				if (empty($rows["luong_trocaplienlac"]))
					$data["luong_trocaplienlac"]="null";
				else
					$data["luong_trocaplienlac"]=$rows["luong_trocaplienlac"];

				if (empty($rows["luong_trocapguixe"]))
					$data["luong_trocapguixe"]="null";
				else
					$data["luong_trocapguixe"]=$rows["luong_trocapguixe"];

				if (empty($rows["luong_trocaptrachnhiem"]))
					$data["luong_trocaptrachnhiem"]="null";
				else
					$data["luong_trocaptrachnhiem"]=$rows["luong_trocaptrachnhiem"];

				if (empty($rows["luong_trocapantrua"]))
					$data["luong_trocapantrua"]="null";
				else
					$data["luong_trocapantrua"]=$rows["luong_trocapantrua"];

				if (!$db->query_update("salary_personal_setting", $data, "yearmonth='".$req["year_month"]."' and staff_id='".$rows['id']."'")){
					$db->query("rollback");
					$db->close();
					die("err2");				
				}
			
			}
		}	
		
			
		//tinh toan time
		$sql="select * from staff where valid=0 and id='004'";
		$rs = $db->query($sql);	
		$staff=array();
		while ($rows = $db->fetch_array($rs)){
			$staff[]=$rows;
		}			
		
		
		for ($i=0;$i<count($staff);$i++){
			$sql="select * from time_sheet where staff_id='".$staff[$i]["id"]."' and DATE_FORMAT(check_in,'%Y/%m')='{$req["year_month"]}'";

			$rs = $db->query($sql);
			$itemcnt=$db->affected_rows;	
			
			$work_hours_total=0;
			$ot1_total=$ot2_total=$ot3_total=$ot4_total=0;
			$luong_giolamthieutrongthang=0;
			while ($rows = $db->fetch_array($rs)) {
				$wt=$salary->work_hours($rows["check_in"], $rows["check_out"], $staff[$i]["id"], $db);
				$luong_giolamthieutrongthang +=8-$wt[0];
				$work_hours_total+=$wt[0];
				$ot1_total+=$wt[1];
				$ot2_total+=$wt[2];
				$ot3_total+=$wt[3];
				$ot4_total+=$wt[4];
			}

			if ($itemcnt<$salary_setting_one["luong_songaylamviec"]){
				$luong_giolamthieutrongthang+=($salary_setting_one["luong_songaylamviec"]-$itemcnt)*8;
			}
			
			
			
			/*$ngayphep=8;//1 thang được 1 ngày phép tương đương 8 tiếng
			
			//lay so ngay phep thang trước
			$sql="select luong_phepconlai from salary_personal_setting where staff_id='".$staff[$i]["id"]."' and yearmonth='".date("Y/m",strtotime("-1 months", strtotime($req["year_month"]."/01")))."'";
			$salary_personal_setting_one=$db->query_first($sql);
			if (floatval($salary_personal_setting_one["luong_phepconlai"])) $ngayphep+=floatval($salary_personal_setting_one["luong_phepconlai"]);
			
			//lay so ngay phep thang truoc
			$sql="select luong_phepdauky from salary_personal_setting where staff_id='".$staff[$i]["id"]."' and yearmonth='".$req["year_month"]."'";
			$salary_personal_setting_one=$db->query_first($sql);
			if (floatval($salary_personal_setting_one["luong_phepdauky"])) $ngayphep+=floatval($salary_personal_setting_one["luong_phepdauky"]);
			
			
			//echo strtotime(date("Y-m-t", strtotime($req["year_month"]."/01")));die;
			
			if (!empty($staff[$i]["ngayhopdongchinhthuc"]) && strtotime($staff[$i]["ngayhopdongchinhthuc"])<=strtotime(date("Y-m-t", strtotime($req["year_month"]."/01 23:59:59")))){
				$ngayphep=$ngayphep-$luong_giolamthieutrongthang;
				
				if ($ngayphep>=0){
					$luong_giolamthieutrongthang=0;
				}else{
					$luong_giolamthieutrongthang=abs($ngayphep);
					$ngayphep=0;
				}	
			}*/
			
			
			//Ngày phép còn lại đầu kỳ
			$ngayphepconlaidauky=0;
			$sql="select * from salary_personal_setting where staff_id='".$staff[$i]["id"]."' and yearmonth='".$req["year_month"]."'";
			$salary_personal_setting_one= $db->query_first($sql);
			if (doubleval($salary_personal_setting_one["luong_phepdauky"])>0){
				$ngayphepconlaidauky=$salary_personal_setting_one["luong_phepdauky"];
			}else{
				$sql="select * from salary_personal_setting where staff_id='".$staff[$i]["id"]."' and yearmonth='".date("Y/m", strtotime("-1 months", strtotime($req["year_month"]."/01")))."'";
				$salary_personal_setting_one= $db->query_first($sql);
				if (doubleval($salary_personal_setting_one["ngayphepconlaicuoiky"])>0){
					$ngayphepconlaidauky=$salary_personal_setting_one["ngayphepconlaicuoiky"];
				}
			}
	
			
			//Ngày phép tăng trong kỳ
			$ngaypheptangtrongky=8;
			
			//Ngày phép còn lại cuối kỳ
			$ngayphepconlaicuoiky=$ngayphepconlaidauky+$ngaypheptangtrongky;
			
			
			
			//Ngày phép đã dùng trong kỳ
			$ngayphepdadungtrongky=0;
			if ($luong_giolamthieutrongthang>0){
				if (!empty($staff[$i]["ngayhopdongchinhthuc"]) && strtotime($staff[$i]["ngayhopdongchinhthuc"])<=strtotime(date("Y-m-t", strtotime($req["year_month"]."/01 23:59:59")))){
					
					if ($ngayphepconlaicuoiky>$luong_giolamthieutrongthang){
						
						$ngayphepdadungtrongky=$luong_giolamthieutrongthang;
						$ngayphepconlaicuoiky=$ngayphepconlaicuoiky-$luong_giolamthieutrongthang;
						$luong_giolamthieutrongthang=0;
			
					}else{
						$luong_giolamthieutrongthang=$luong_giolamthieutrongthang-$ngayphepconlaicuoiky;
						$ngayphepdadungtrongky=$ngayphepconlaicuoiky;
						$ngayphepconlaicuoiky=0;
					}
					

				}			
			}	
			
			
			

			$sql="update salary_personal_setting set work_hours=$work_hours_total, ot1=$ot1_total, ot2=$ot2_total, ot3=$ot3_total, ot4=$ot4_total, luong_giolamthieutrongthang=$luong_giolamthieutrongthang, ngayphepconlaidauky=$ngayphepconlaidauky, ngaypheptangtrongky=$ngaypheptangtrongky, ngayphepdadungtrongky=$ngayphepdadungtrongky, ngayphepconlaicuoiky=$ngayphepconlaicuoiky where staff_id='".$staff[$i]["id"]."' and yearmonth='".$req["year_month"]."'";
			if (!$db->query($sql)){
				$db->query("rollback");
				$db->close();
				die("err6");
			}			
		
		}
			
		//コミット
		$db->query("commit");	
		$db->close();		
		die("ok");
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
		
	$o_smarty->display("salary/edit.tpl");
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


	$o_smarty->display("salary/add.tpl");
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





	$sql="select * from staff where valid=0";


	$store_staff=array();
	$rs = $db->query($sql);	
	$i=0;
	while ($rows = $db->fetch_array($rs)){
		$store_staff[$i]= $rows;
		
		$i++;
	}	
	$o_smarty->assign("store_staff",$store_staff);


	$current_year = date("Y",strtotime("-1 month"));
	if (!empty($req["year"])) $current_year=$req["year"];
	$o_smarty->assign("current_year",$current_year);
	
	$current_month = date("m",strtotime("-1 month"));
	if (!empty($req["month"])) $current_month=$req["month"];
	$o_smarty->assign("current_month",$current_month);
	


	$sql="select * from salary_setting where yearmonth='{$current_year}/{$current_month}'";
	$salary_setting_one= $db->query_first($sql);
	$o_smarty->assign("salary_setting_one",$salary_setting_one);




		$cond="a.yearmonth='{$current_year}/{$current_month}'";


	
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
		
		$sql="select a.*, b.* from salary_personal_setting a 
		left join staff b on a.staff_id=b.id
		where $cond";
	
		$sql_excel=$sql;
		
	
		$db->query($sql); 
		$itemcnt=$db->affected_rows;	
		$allpagenum = ceil($itemcnt/$limit);
		$o_smarty->assign("allpagenum",$allpagenum);
	
	
		$sql = $sql." ORDER BY a.staff_id";
		$sql_excel = $sql;

		
		$sql = $sql." LIMIT ".(($p - 1) * $limit)." ";
		$sql = $sql.",".$limit." ";		

	
		$salary=array();
		$rs = $db->query($sql);
		$i=0;
		while ($rows = $db->fetch_array($rs)) {
			$salary[$i]= $rows;
			
			
			//(27)=(3)+(5)+(7)+ (9)+(11)+(18)+(20)+(21)+(22)-(24)-(26)
			$tongluong=0;
			$tongluong=$rows["luong_luongcoban"];
			$tongluongkhongchiuthue=0;
			
			if ($rows["ot1"]>0){
				$salary[$i]["ot1_value"]=(($rows["luong_luongcoban"]/$salary_setting_one["luong_songaylamviec"])/8)*$rows["ot1"]*1.5;
				$tongluong+=(($rows["luong_luongcoban"]/$salary_setting_one["luong_songaylamviec"])/8)*$rows["ot1"]*1.5;
				
				$tongluongkhongchiuthue+=(($rows["luong_luongcoban"]/$salary_setting_one["luong_songaylamviec"])/8)*$rows["ot1"]*0.5;
				
			}
			
			if ($rows["ot2"]>0){
				$salary[$i]["ot2_value"]=(($rows["luong_luongcoban"]/$salary_setting_one["luong_songaylamviec"])/8)*$rows["ot2"]*2;
				$tongluong+=(($rows["luong_luongcoban"]/$salary_setting_one["luong_songaylamviec"])/8)*$rows["ot2"]*2;
				$tongluongkhongchiuthue+=(($rows["luong_luongcoban"]/$salary_setting_one["luong_songaylamviec"])/8)*$rows["ot2"]*1;
				
				//echo (($rows["luong_luongcoban"]/$salary_setting_one["luong_songaylamviec"])/8)*$rows["ot2"]*1;die;
				
			}
			
			if ($rows["ot3"]>0){
				$salary[$i]["ot3_value"]=(($rows["luong_luongcoban"]/$salary_setting_one["luong_songaylamviec"])/8)*$rows["ot3"]*2;
				$tongluong+=(($rows["luong_luongcoban"]/$salary_setting_one["luong_songaylamviec"])/8)*$rows["ot3"]*2;
				$tongluongkhongchiuthue+=(($rows["luong_luongcoban"]/$salary_setting_one["luong_songaylamviec"])/8)*$rows["ot3"]*1;
				
			}
			
			if ($rows["ot4"]>0){
				$salary[$i]["ot4_value"]=(($rows["luong_luongcoban"]/$salary_setting_one["luong_songaylamviec"])/8)*$rows["ot4"]*3;
				$tongluong+=(($rows["luong_luongcoban"]/$salary_setting_one["luong_songaylamviec"])/8)*$rows["ot4"]*3;
				$tongluongkhongchiuthue+=(($rows["luong_luongcoban"]/$salary_setting_one["luong_songaylamviec"])/8)*$rows["ot4"]*2;
			}
			
			
			$trocap_total=0;
			if ($rows["luong_trocapdilai"]>0)  $trocap_total+=$rows["luong_trocapdilai"];
			if ($rows["luong_trocaptiengnhat"]>0)  $trocap_total+=$rows["luong_trocaptiengnhat"];
			if ($rows["luong_trocaplienlac"]>0)  $trocap_total+=$rows["luong_trocaplienlac"];
			if ($rows["luong_trocapguixe"]>0)  $trocap_total+=$rows["luong_trocapguixe"];
			if ($rows["luong_trocaptrachnhiem"]>0)  $trocap_total+=$rows["luong_trocaptrachnhiem"];
			if ($rows["luong_trocapantrua"]>0)  $trocap_total+=$rows["luong_trocapantrua"];
			$salary[$i]["trocap_total"]=$trocap_total;
			$tongluong+=$trocap_total;
			
			if ($rows["luong_quyettoanconlaitrongnam"]>0){
				$salary[$i]["luong_quyettoanconlaitrongnam_value"]=(($rows["luong_luongcoban"]/$salary_setting_one["luong_songaylamviec"])/8)*$rows["luong_quyettoanconlaitrongnam"];
				$tongluong+=(($rows["luong_luongcoban"]/$salary_setting_one["luong_songaylamviec"])/8)*$rows["luong_quyettoanconlaitrongnam"];
			}		
			

			if ($rows["luong_tienchucmungchiabuon"]>0){
				$tongluong+=$rows["luong_tienchucmungchiabuon"];
			}

			if ($rows["luong_dieuchinhtruoctongluong"]>0){
				$tongluong+=$rows["luong_dieuchinhtruoctongluong"];
			}
			
			

			if ($rows["luong_giolamthieutrongthang"]>0){
				$salary[$i]["luong_giolamthieutrongthang_value"]=(($rows["luong_luongcoban"]/$salary_setting_one["luong_songaylamviec"])/8)*$rows["luong_giolamthieutrongthang"];
				$tongluong=$tongluong-(($rows["luong_luongcoban"]/$salary_setting_one["luong_songaylamviec"])/8)*$rows["luong_giolamthieutrongthang"];
			}

			if ($rows["luong_sogionghiphepnghibu"]>0){
				$salary[$i]["luong_sogionghiphepnghibu_value"]=(($rows["luong_luongcoban"]/$salary_setting_one["luong_songaylamviec"])/8)*$rows["luong_sogionghiphepnghibu"];
				$tongluong=$tongluong-(($rows["luong_luongcoban"]/$salary_setting_one["luong_songaylamviec"])/8)*$rows["luong_sogionghiphepnghibu"];
			}
			$salary[$i]["tongluong"]=$tongluong;

			//tro cap khong chiu thue
			//(29a)=(17)*(C4-(23)/8)/C4
			$trocapkhongchiuthue=0;
			if ($rows["luong_trocapantrua"]>0) $trocapkhongchiuthue+=$rows["luong_trocapantrua"];
			
			if ($trocapkhongchiuthue>0){
				$trocapkhongchiuthue=$trocapkhongchiuthue*($salary_setting_one["luong_songaylamviec"]-doubleval($rows["luong_giolamthieutrongthang"])/8)/$salary_setting_one["luong_songaylamviec"];
				$salary[$i]["trocapkhongchiuthue"]=$trocapkhongchiuthue;
			}
			
			//Tổng làm thêm giờ không chịu thuế
			//非課税残業
			//=TRUNC(ROUND(((3)/$C$4/8)*(4)*50%+((3)/$C$4/8)*(6)*100%+ ((3)/$C$4/8)*(8)*100%+((3)/$C$4/8)*(10)*200%;0);0)
			if ($tongluongkhongchiuthue>0){
				//echo $tongluongkhongchiuthue;die;
				$salary[$i]["tongluongkhongchiuthue"]=$tongluongkhongchiuthue;
			}
			
			
			
			//Bảo hiểm xã hội (17.5%)
			//社会保険 (17.5%)	
			$congtychiu_baohiemxahoi=0;
			if ($rows["luong_luongcoban"]>20*$salary_setting_one["luong_luongcoso"])
				$congtychiu_baohiemxahoi=$salary_setting_one["luong_luongcoso"]*20*$salary_setting_one["luong_congtybaohiemxahoi"]/100;
			else
				$congtychiu_baohiemxahoi=$salary_setting_one["luong_luongcoso"]*$salary_setting_one["luong_congtybaohiemxahoi"]/100;
			
			$salary[$i]["congtychiu_baohiemxahoi"]=$congtychiu_baohiemxahoi;	
				
				
			//Bảo hiểm y tế (3%)
			//健康保険 (3%)
			$congtychiu_baohiemyte=0;
			if ($rows["luong_luongcoban"]>20*$salary_setting_one["luong_luongcoso"])
				$congtychiu_baohiemyte=$salary_setting_one["luong_luongcoso"]*20*$salary_setting_one["luong_congtybaohiemyte"]/100;
			else
				$congtychiu_baohiemyte=$salary_setting_one["luong_luongcoso"]*$salary_setting_one["luong_congtybaohiemyte"]/100;
			
			$salary[$i]["congtychiu_baohiemyte"]=$congtychiu_baohiemyte;	



			$congtychiu_kinhphicongdoan=0;
			if ($rows["luong_luongcoban"]>20*$salary_setting_one["luong_luongcoso"])
				$congtychiu_kinhphicongdoan=$salary_setting_one["luong_luongcoso"]*20*$salary_setting_one["luong_congtykinhphicongdoan"]/100;
			else
				$congtychiu_kinhphicongdoan=$salary_setting_one["luong_luongcoso"]*$salary_setting_one["luong_congtykinhphicongdoan"]/100;
			
			$salary[$i]["congtychiu_kinhphicongdoan"]=$congtychiu_kinhphicongdoan;	

			$congtychiu_baohiemthatnghiep=$salary_setting_one["luong_luongcoso"]*	$salary_setting_one["luong_congtybaohiemthatnghiep"]/100;
			$salary[$i]["congtychiu_baohiemthatnghiep"]=$congtychiu_baohiemthatnghiep;
			
			$congtychiubaohiem_total=$congtychiu_baohiemxahoi+$congtychiu_baohiemyte+$congtychiu_kinhphicongdoan+$congtychiu_baohiemthatnghiep;
			$salary[$i]["congtychiubaohiem_total"]=$congtychiubaohiem_total;


			//Bảo hiểm và chi phí công đoàn người lao động chịu
			//xa hoi
			$canhanchiu_baohiemxahoi=0;
			if ($rows["luong_luongcoban"]>20*$salary_setting_one["luong_luongcoso"])
				$canhanchiu_baohiemxahoi=$salary_setting_one["luong_luongcoso"]*20*$salary_setting_one["luong_canhanbaohiemxahoi"]/100;
			else
				$canhanchiu_baohiemxahoi=$salary_setting_one["luong_luongcoso"]*$salary_setting_one["luong_canhanbaohiemxahoi"]/100;
			
			$salary[$i]["canhanchiu_baohiemxahoi"]=$canhanchiu_baohiemxahoi;	
			
			//y te
			$canhanchiu_baohiemyte=0;
			if ($rows["luong_luongcoban"]>20*$salary_setting_one["luong_luongcoso"])
				$canhanchiu_baohiemyte=$salary_setting_one["luong_luongcoso"]*20*$salary_setting_one["luong_canhanbaohiemyte"]/100;
			else
				$canhanchiu_baohiemyte=$salary_setting_one["luong_luongcoso"]*$salary_setting_one["luong_canhanbaohiemyte"]/100;
			
			$salary[$i]["canhanchiu_baohiemyte"]=$canhanchiu_baohiemyte;	

			//that nghiep
			$canhanchiu_baohiemthatnghiep=$salary_setting_one["luong_luongcoso"]*	$salary_setting_one["luong_canhanbaohiemthatnghiep"]/100;
			$salary[$i]["canhanchiu_baohiemthatnghiep"]=$canhanchiu_baohiemthatnghiep;
						

			$canhanchiubaohiem_total=$canhanchiu_baohiemxahoi+$canhanchiu_baohiemyte+$canhanchiu_baohiemthatnghiep;
			$salary[$i]["canhanchiubaohiem_total"]=$canhanchiubaohiem_total;
			
	
			//Thu nhập chịu thuế
			//(Trước giảm trừ)
			//課税所得
			//(扶養義務の控除前
			//=IF((27)>0;(27)-(29a)-(30)+(28)+(29);0)
			$thunhapchithuetruocgiamtru=0;
			if ($tongluong>0){
				$thunhapchithuetruocgiamtru=doubleval($tongluong)-doubleval($trocapkhongchiuthue)-doubleval($tongluongkhongchiuthue)+doubleval($rows["luong_thunhapkhac"])+doubleval($rows["luong_thangluongthu13"]);
				$salary[$i]["thunhapchithuetruocgiamtru"]=$thunhapchithuetruocgiamtru;
			}	

			//Thu nhập tính thuế
			//(Sau giảm trừ)
			//課税所得
			//(扶養義務の控除後）
			//=INT(IF(((32)-9000000-(31)*3600000-(43))<=0;0;(32)-9000000-(31)*3600000-(43)))			
			$thunhaptinhthuesaugiamtru=0;
			if (($thunhapchithuetruocgiamtru-$salary_setting_one["luong_giamtrubanthan"]-intval($rows["luong_songuoiphuthuoc"])*$salary_setting_one["luong_giamtrunguoiphuthuoc"]-$canhanchiubaohiem_total)>0){
			
				$thunhaptinhthuesaugiamtru=$thunhapchithuetruocgiamtru-$salary_setting_one["luong_giamtrubanthan"]-intval($rows["luong_songuoiphuthuoc"])*$salary_setting_one["luong_giamtrunguoiphuthuoc"];
				$salary[$i]["thunhaptinhthuesaugiamtru"]=$thunhaptinhthuesaugiamtru;
			}		
			
			if ($rows["loaihopdong"]==1)//thu viec
				$salary[$i]["thunhaptinhthuesaugiamtru"]=$thunhapchithuetruocgiamtru;
	
	
	
	
	//Số thuế phải nộp tháng này
	//実際給与から控除した税金
	//=TRUNC(IF((33)<=5000000;(33)*5%;IF((33)<=10000000;((33)-5000000)*10%+250000;IF((33)<=18000000;(((33)-10000000)*15%+750000);IF((33)<=32000000;(((33)-18000000)*20%+1950000);IF((33)<=52000000;(((33)-32000000)*25%+4750000);IF((33)<=80000000;(((33)-52000000)*30%+9750000);IF((33)>80000000;(((33)-80000000)*35%+18150000))))))));0)
			$sothuephainopthangnay=0;
			if ($thunhaptinhthuesaugiamtru<5000000)
				$sothuephainopthangnay=$thunhaptinhthuesaugiamtru*0.05;
			else if ($thunhaptinhthuesaugiamtru<10000000)
				$sothuephainopthangnay=($thunhaptinhthuesaugiamtru-5000000)*0.1+250000;
			else if ($thunhaptinhthuesaugiamtru<18000000)
				$sothuephainopthangnay=($thunhaptinhthuesaugiamtru-10000000)*0.15+750000;
			else if ($thunhaptinhthuesaugiamtru<32000000)
				$sothuephainopthangnay=($thunhaptinhthuesaugiamtru-18000000)*0.2+1950000;
			else if ($thunhaptinhthuesaugiamtru<52000000)
				$sothuephainopthangnay=($thunhaptinhthuesaugiamtru-32000000)*0.25+4750000;
			else if ($thunhaptinhthuesaugiamtru<80000000)
				$sothuephainopthangnay=($thunhaptinhthuesaugiamtru-52000000)*0.3+9750000;
			else
				$sothuephainopthangnay=($thunhaptinhthuesaugiamtru-80000000)*0.35+18150000;
			
			
			
			$salary[$i]["sothuephainopthangnay"]=$sothuephainopthangnay;
			if ($rows["loaihopdong"]==1)//thu viec
				$salary[$i]["sothuephainopthangnay"]=$thunhaptinhthuesaugiamtru*0.1;
			


			//Tổng lương còn lại chưa trả
			//未払給与
			$tongluongconlaichuatra=doubleval($tongluong)+doubleval($rows["luong_thunhapkhac"])+doubleval($rows["luong_thangluongthu13"])-doubleval($sothuephainopthangnay)-doubleval($canhanchiubaohiem_total);
			$salary[$i]["tongluongconlaichuatra"]=$tongluongconlaichuatra;
			
			
			//Tổng lương thực nhận chưa trả
			//支払合計
			$tongluongthucnhantruatra=doubleval($tongluongconlaichuatra)+doubleval($rows["luong_trocapbaohiem_trathuenopthua"]);
			$salary[$i]["tongluongthucnhantruatra"]=$tongluongthucnhantruatra;

			//Tổng lương thực nhận đã chuyển khoản
			$tongluongdanhanchuyenkhoan=$tongluongthucnhantruatra+doubleval($rows["luong_thangtruocchuyenqua"]);
			$salary[$i]["tongluongdanhanchuyenkhoan"]=$tongluongdanhanchuyenkhoan;

			$tienthuong=$rows["luong_luongcoban"]/12;
			if ($rows["loaihopdong"]==1)//thu viec
				$tienthuong=$rows["luong_luongcoban"]/(0.9*12);
			
			$salary[$i]["tienthuong"]=$tienthuong;
							
			$i++;
		}	
		$o_smarty->assign("salary",$salary);



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
			$sheet->setTitle($current_year."_".$current_month);
	
			
			$pageMargins = $sheet->getPageMargins();

			
			$pageMargins->setTop(0.3);
			$pageMargins->setBottom(0.3);
			$pageMargins->setLeft(0.6);
			$pageMargins->setRight(0.3);


			//$sheet->mergeCells("A1:".chr(76+count($project))."1");
			$sheet->setCellValue('A1', "Neos Vietnam International Co., Ltd");
			$sheet->getStyle("A1")->getFont()->setBold(true)->setSize(16);
			$sheet->setCellValue('A2', "Payroll - ".$current_year."/".$current_month);
			$sheet->getStyle("A2")->getFont()->setBold(true)->setSize(16);
			
			$sheet->mergeCells("A4:B4");
			$sheet->setCellValue('A4', "Số ngày làm việc/通勤日数:");
			$sheet->getStyle("A4")->getFont()->setBold(true);
			
			$sheet->getStyle("C4")->getFont()->setBold(true);
			$sheet->setCellValue('C4', $salary_setting_one["luong_songaylamviec"]);
			//$sheet->getStyle("A1:".chr(76+count($project))."1")->getFont()->setBold(true)->setSize(20);


			/*
			$sheet->mergeCells("A1:".chr(76+count($project))."1");
			$sheet->setCellValue('A1', "Time sheet");
			$sheet->getStyle("A1:".chr(76+count($project))."1")->getFont()->setBold(true)->setSize(20);
			*

			$sheet->getStyle('A1')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
			);

			$sheet->mergeCells("A2:".chr(76+count($project))."2");
			$sheet->setCellValue('A2', "Created date: ".date("Y/m/d H:i"));
			$sheet->getStyle('A2')->getAlignment()->applyFromArray(
				array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
			);	
			*/

			$sheet->mergeCells("A5:A6");
			$sheet->setCellValue('A5', "Mã nhân viên".PHP_EOL."社員番号");	
			$sheet->getStyle('A5')->getAlignment()->setWrapText(true);

  			
			$sheet->mergeCells("B5:B6");	
			$sheet->setCellValue('B5', "Họ và tên".PHP_EOL."氏名");
			$sheet->getStyle('B5')->getAlignment()->setWrapText(true);
			
			$sheet->mergeCells("C5:C6");
			$sheet->setCellValue('C5', "Lương cơ bản".PHP_EOL."基本給");
			$sheet->getStyle('C5')->getAlignment()->setWrapText(true);
			
			$sheet->mergeCells("D5:D6");
			$sheet->setCellValue('D5', "Lương cơ sở".PHP_EOL."基準賃金");
			$sheet->getStyle('D5')->getAlignment()->setWrapText(true);
			
			$sheet->mergeCells("E5:F5");
			$sheet->setCellValue('E5', "Làm thêm".PHP_EOL."(Ngày thường 160%)".PHP_EOL."平日残業(150%)");
			$sheet->getStyle('E5')->getAlignment()->setWrapText(true);

			$sheet->setCellValue('E6', "Số giờ".PHP_EOL."時間");
			$sheet->getStyle('E6')->getAlignment()->setWrapText(true);
			
			$sheet->setCellValue('F6', "Số tiền".PHP_EOL."金額");
			$sheet->getStyle('F6')->getAlignment()->setWrapText(true);
			
			
			$sheet->mergeCells("G5:H5");
			$sheet->setCellValue('G5', "Làm thêm".PHP_EOL."(Đêm ngày thường 200%)".PHP_EOL."平日夜中残業(200%)");
			$sheet->getStyle('G5')->getAlignment()->setWrapText(true);

			$sheet->setCellValue('G6', "Số giờ".PHP_EOL."時間");
			$sheet->getStyle('G6')->getAlignment()->setWrapText(true);
			
			$sheet->setCellValue('H6', "Số tiền".PHP_EOL."金額");
			$sheet->getStyle('H6')->getAlignment()->setWrapText(true);


			$sheet->mergeCells("I5:J5");
			$sheet->setCellValue('I5', "Làm thêm".PHP_EOL."(Cuối tuần 200%)".PHP_EOL."週末残業(200%)");
			$sheet->getStyle('I5')->getAlignment()->setWrapText(true);

			$sheet->setCellValue('I6', "Số giờ".PHP_EOL."時間");
			$sheet->getStyle('I6')->getAlignment()->setWrapText(true);
			
			$sheet->setCellValue('J6', "Số tiền".PHP_EOL."金額");
			$sheet->getStyle('J6')->getAlignment()->setWrapText(true);
			

			$sheet->mergeCells("K5:L5");
			$sheet->setCellValue('K5', "Làm thêm".PHP_EOL."(Ngày lễ 500%)".PHP_EOL."祝日残業(300%)");
			$sheet->getStyle('K5')->getAlignment()->setWrapText(true);

			$sheet->setCellValue('K6', "Số giờ".PHP_EOL."時間");
			$sheet->getStyle('K6')->getAlignment()->setWrapText(true);
			
			$sheet->setCellValue('L6', "Số tiền".PHP_EOL."金額");
			$sheet->getStyle('L6')->getAlignment()->setWrapText(true);


			$sheet->mergeCells("M5:S5");
			$sheet->setCellValue('M5', "Trợ cấp".PHP_EOL."手当");
			$sheet->getStyle('M5')->getAlignment()->setWrapText(true);


			$sheet->setCellValue('M6', "Trợ cấp đi lại".PHP_EOL."通勤手当");
			$sheet->getStyle('M6')->getAlignment()->setWrapText(true);

			$sheet->setCellValue('N6', "Trợ cấp tiếng Nhật".PHP_EOL."日本語手当");
			$sheet->getStyle('N6')->getAlignment()->setWrapText(true);
			
			$sheet->setCellValue('O6', "Trợ cấp liên lạc".PHP_EOL."携帯電話手当");
			$sheet->getStyle('O6')->getAlignment()->setWrapText(true);					

			$sheet->setCellValue('P6', "Trợ cấp gửi xe".PHP_EOL."駐車場手当 ");
			$sheet->getStyle('P6')->getAlignment()->setWrapText(true);					

			$sheet->setCellValue('Q6', "Phụ cấp trách nhiệm".PHP_EOL."管理職手当");
			$sheet->getStyle('Q6')->getAlignment()->setWrapText(true);					

			$sheet->setCellValue('R6', "Trợ cấp ăn trưa".PHP_EOL."昼食手当");
			$sheet->getStyle('R6')->getAlignment()->setWrapText(true);					

			$sheet->setCellValue('S6', "Tổng các khoản trợ cấp hàng tháng".PHP_EOL."毎月手当合計");
			$sheet->getStyle('S6')->getAlignment()->setWrapText(true);					




			$sheet->mergeCells("T5:U5");
			$sheet->setCellValue('T5', "Quyết toán ngày phép còn lại trong năm".PHP_EOL."有給残日数支払");
			$sheet->getStyle('T5')->getAlignment()->setWrapText(true);


			$sheet->setCellValue('T6', "Số giờ".PHP_EOL."時間");
			$sheet->getStyle('T6')->getAlignment()->setWrapText(true);

			$sheet->setCellValue('U6', "Số tiền".PHP_EOL."金額");
			$sheet->getStyle('U6')->getAlignment()->setWrapText(true);


			$sheet->mergeCells("V5:V6");
			$sheet->setCellValue('V5', "Tiền chúc mừng / chia buồn".PHP_EOL."慶弔・見舞金");
			$sheet->getStyle('V5')->getAlignment()->setWrapText(true);


			$sheet->mergeCells("W5:W6");
			$sheet->setCellValue('W5', "Điều chỉnh (Trước tổng lương)".PHP_EOL."その他調整（実際給与に関係する）");
			$sheet->getStyle('W5')->getAlignment()->setWrapText(true);
		



			$sheet->mergeCells("X5:Y5");
			$sheet->setCellValue('X5', "Số giờ nghỉ trừ lương".PHP_EOL."無給休暇");
			$sheet->getStyle('X5')->getAlignment()->setWrapText(true);


			$sheet->setCellValue('X6', "Số giờ".PHP_EOL."時間");
			$sheet->getStyle('X6')->getAlignment()->setWrapText(true);

			$sheet->setCellValue('Y6', "Số tiền".PHP_EOL."金額");
			$sheet->getStyle('Y6')->getAlignment()->setWrapText(true);



			$sheet->mergeCells("Z5:AA5");
			$sheet->setCellValue('Z5', "Số giờ nghỉ phép, nghỉ bù (đặc biệt)".PHP_EOL."その他休み");
			$sheet->getStyle('Z5')->getAlignment()->setWrapText(true);


			$sheet->setCellValue('Z6', "Số giờ".PHP_EOL."時間");
			$sheet->getStyle('Z6')->getAlignment()->setWrapText(true);

			$sheet->setCellValue('AA6', "Số tiền".PHP_EOL."金額");
			$sheet->getStyle('AA6')->getAlignment()->setWrapText(true);





			$sheet->mergeCells("AB5:AB6");
			$sheet->setCellValue('AB5', "Tổng lương".PHP_EOL."実際給与");
			$sheet->getStyle('AB5')->getAlignment()->setWrapText(true);


			$sheet->mergeCells("AC5:AC6");
			$sheet->setCellValue('AC5', "Thu nhập khác".PHP_EOL."その他収入");
			$sheet->getStyle('AC5')->getAlignment()->setWrapText(true);


			$sheet->mergeCells("AD5:AD6");
			$sheet->setCellValue('AD5', "Tháng lương thứ 13 (thưởng)".PHP_EOL."ボーナス");
			$sheet->getStyle('AD5')->getAlignment()->setWrapText(true);


			$sheet->mergeCells("AE5:AE6");
			$sheet->setCellValue('AE5', "Trợ cấp không chịu thuế".PHP_EOL."非課税手当");
			$sheet->getStyle('AE5')->getAlignment()->setWrapText(true);


			$sheet->mergeCells("AF5:AF6");
			$sheet->setCellValue('AF5', "Tổng làm thêm giờ không chịu thuế".PHP_EOL."非課税残業");
			$sheet->getStyle('AF5')->getAlignment()->setWrapText(true);




			$sheet->mergeCells("AG5:AJ5");
			$sheet->setCellValue('AG5', "Thuế thu nhập cá nhân".PHP_EOL."源泉個人所得税");
			$sheet->getStyle('AG5')->getAlignment()->setWrapText(true);


			$sheet->setCellValue('AG6', "Số người phụ thuộc".PHP_EOL."扶養義務人数");
			$sheet->getStyle('AG6')->getAlignment()->setWrapText(true);

			$sheet->setCellValue('AH6', "Thu nhập chịu thuế (Trước giảm trừ)".PHP_EOL."課税所得(扶養義務の控除前）");
			$sheet->getStyle('AH6')->getAlignment()->setWrapText(true);

			$sheet->setCellValue('AI6', "Thu nhập tính thuế (Sau giảm trừ)".PHP_EOL."課税所得(扶養義務の控除後）");
			$sheet->getStyle('AI6')->getAlignment()->setWrapText(true);


			$sheet->setCellValue('AJ6', "Số thuế phải nộp tháng này".PHP_EOL."実際給与から控除した税金");
			$sheet->getStyle('AJ6')->getAlignment()->setWrapText(true);





			$sheet->mergeCells("AK5:AO5");
			$sheet->setCellValue('AK5', "Bảo hiểm và chi phí công đoàn công ty chịu".PHP_EOL."会社が負担する社会保険・健康保険・失業保険・労働組合費");
			$sheet->getStyle('AK5')->getAlignment()->setWrapText(true);

			$sheet->setCellValue('AK6', "Bảo hiểm xã hội (17.5%)".PHP_EOL."社会保険 (17.5%)");
			$sheet->getStyle('AK6')->getAlignment()->setWrapText(true);

			$sheet->setCellValue('AL6', "Bảo hiểm y tế (3%)".PHP_EOL."健康保険 (3%)");
			$sheet->getStyle('AL6')->getAlignment()->setWrapText(true);

			$sheet->setCellValue('AM6', "Bảo hiểm thất nghiệp (1%)".PHP_EOL."失業保険　(1%)");
			$sheet->getStyle('AM6')->getAlignment()->setWrapText(true);

			$sheet->setCellValue('AN6', "Kinh phí công đoàn(2%)".PHP_EOL."労働組合費(2%)");
			$sheet->getStyle('AN6')->getAlignment()->setWrapText(true);

			$sheet->setCellValue('AO6', "Tổng (24%)".PHP_EOL."合計(24%)");
			$sheet->getStyle('AO6')->getAlignment()->setWrapText(true);




			$sheet->mergeCells("AP5:AS5");
			$sheet->setCellValue('AP5', "Bảo hiểm và chi phí công đoàn người lao động chịu".PHP_EOL."社員が負担する社会保険・健康保険・失業保険");
			$sheet->getStyle('AP5')->getAlignment()->setWrapText(true);

			$sheet->setCellValue('AP6', "Bảo hiểm xã hội (8%)".PHP_EOL."社会保険 (8%)");
			$sheet->getStyle('AP6')->getAlignment()->setWrapText(true);

			$sheet->setCellValue('AQ6', "Bảo hiểm y tế (1.5%)".PHP_EOL."健康保険 (1.5%)");
			$sheet->getStyle('AQ6')->getAlignment()->setWrapText(true);

			$sheet->setCellValue('AR6', "Bảo hiểm thất nghiệp (1%)".PHP_EOL."失業保険　(1%)");
			$sheet->getStyle('AR6')->getAlignment()->setWrapText(true);

			$sheet->setCellValue('AS6', "Tổng (10.5%)".PHP_EOL."合計(10.5%)");
			$sheet->getStyle('AS6')->getAlignment()->setWrapText(true);







			$sheet->mergeCells("AT5:AT6");
			$sheet->setCellValue('AT5', "Tổng lương còn lại chưa trả".PHP_EOL."未払給与");
			$sheet->getStyle('AT5')->getAlignment()->setWrapText(true);

			$sheet->mergeCells("AU5:AU6");
			$sheet->setCellValue('AU5', "Trợ cấp bảo hiểm từ Bảo hiểm xã hội/Trả thuế năm 2018 nộp thừa".PHP_EOL."社会保険手当・2017年過剰に納税した所得税の返金");
			$sheet->getStyle('AU5')->getAlignment()->setWrapText(true);

			$sheet->mergeCells("AV5:AV6");
			$sheet->setCellValue('AV5', "Tổng lương thực nhận chưa trả".PHP_EOL."支払合計");
			$sheet->getStyle('AV5')->getAlignment()->setWrapText(true);

			$sheet->mergeCells("AW5:AW6");
			$sheet->setCellValue('AW5', "Thang truoc chuyen sang");
			$sheet->getStyle('AW5')->getAlignment()->setWrapText(true);

			$sheet->mergeCells("AX5:AX6");
			$sheet->setCellValue('AX5', "Tổng lương thực nhận đã chuyển khoản".PHP_EOL."振替金額");
			$sheet->getStyle('AX5')->getAlignment()->setWrapText(true);

			$sheet->mergeCells("AY5:AY6");
			$sheet->setCellValue('AY5', "Tài khoản ngân hàng của nhân viên".PHP_EOL."銀行口座情報");
			$sheet->getStyle('AY5')->getAlignment()->setWrapText(true);

			$sheet->mergeCells("AZ5:AZ6");
			$sheet->setCellValue('AZ5', "賞与");
			$sheet->getStyle('AZ5')->getAlignment()->setWrapText(true);

			
			
			
			$sheet->setCellValue('A7', "(1)");
			$sheet->setCellValue('B7', "(2)");
			$sheet->setCellValue('C7', "(3)");
			$sheet->setCellValue('D7', "(3a)");
			$sheet->setCellValue('E7', "(4)");
			$sheet->setCellValue('F7', "(5)=(3)/C4/8");
			$sheet->setCellValue('G7', "(6)");
			$sheet->setCellValue('H7', "(7)=(3)/C4/8*(6)*200%");
			$sheet->setCellValue('I7', "(8)");
			$sheet->setCellValue('J7', "(9)=(3)/C4/8*(8)*200%");
			$sheet->setCellValue('K7', "(10)");
			$sheet->setCellValue('L7', "(11)=(3)/C4/8*(10)*300%");
			$sheet->setCellValue('M7', "(12)");
			$sheet->setCellValue('N7', "(13)");
			$sheet->setCellValue('O7', "(14)");
			$sheet->setCellValue('P7', "(15)");
			$sheet->setCellValue('Q7', "(16)");
			$sheet->setCellValue('R7', "(17)");
			
			$sheet->setCellValue('S7', "(18)=(12)+(13)+(14)+(15)+(16)+(17)");
			$sheet->setCellValue('T7', "(19)");
			$sheet->setCellValue('U7', "(20)");
			$sheet->setCellValue('V7', "(21)");
			$sheet->setCellValue('W7', "(22)");
			$sheet->setCellValue('X7', "(23)");
			$sheet->setCellValue('Y7', "(24)=((3)+(18))/C4/8*(23)");
			$sheet->setCellValue('Z7', "(25)");
			$sheet->setCellValue('AA7', "(26)");
			$sheet->setCellValue('AB7', "(27)=(3)+(5)+(7)+(9)+(11)+(18)+(20)+(21)+(22)-(24)-(26)");
			$sheet->setCellValue('AC7', "(28)");
			$sheet->setCellValue('AD7', "(29)");
						
			$sheet->setCellValue('AF7', "(30)");
			$sheet->setCellValue('AG7', "(31)");
			$sheet->setCellValue('AH7', "(32)");
			$sheet->setCellValue('AI7', "(33)");
			$sheet->setCellValue('AJ7', "(34)");
			$sheet->setCellValue('AK7', "(35)=(3)x17.5% or (3a)x20x17.5%");
			$sheet->setCellValue('AL7', "(36)=(3)x3% or (3a)x20x3%");
			$sheet->setCellValue('AM7', "(37)=(3)x1%");
			$sheet->setCellValue('AN7', "(38)=(3)x2% or (3a)x20x2%");
			$sheet->setCellValue('AO7', "(39)=(35)+(36)+(37)+(38)");
			$sheet->setCellValue('AP7', "(40)=(3)x8% or (3a)x20x8%");
			$sheet->setCellValue('AQ7', "(41)=(3)x1.5% or (3a)x20x1.5%");
			$sheet->setCellValue('AR7', "(42)=(3)x1% ");
			$sheet->setCellValue('AS7', "(43)=(40)+(41)+(42)");
			$sheet->setCellValue('AT7', "(44)=(27)+(28)+(29)-(34)-(43)");
			$sheet->setCellValue('AU7', "(45)");
			$sheet->setCellValue('AV7', "(46)=(44)+(45)");
			
			$sheet->setCellValue('AX7', "(47)");
			$sheet->setCellValue('AY7', "(48)");
			$sheet->setCellValue('AZ7', "(49)");
			
			
			$i=8;
			for ($j=0;$j<count($salary);$j++){
				$sheet->setCellValue('A'.$i, ' '.$salary[$j]["staff_id"]);
				$sheet->setCellValue('B'.$i, $salary[$j]["first_name"].' '.$salary[$j]["last_name"]);
				if ($salary[$j]["luong_luongcoban"]>0) $sheet->setCellValue('C'.$i, number_format($salary[$j]["luong_luongcoban"]));
				
				
				if ($salary_setting_one["luong_luongcoso"]>0) $sheet->setCellValue('D'.$i, number_format($salary_setting_one["luong_luongcoso"]));
				
				
				if (isset($salary[$j]["ot1"]) && $salary[$j]["ot1"]>0) $sheet->setCellValue('E'.$i, $salary[$j]["ot1"]);
				if (isset($salary[$j]["ot1_value"]) && $salary[$j]["ot1_value"]>0) $sheet->setCellValue('F'.$i, number_format($salary[$j]["ot1_value"]));

				if (isset($salary[$j]["ot2"]) && $salary[$j]["ot2"]>0) $sheet->setCellValue('F'.$i, $salary[$j]["ot2"]);
				if (isset($salary[$j]["ot2_value"]) && $salary[$j]["ot2_value"]>0) $sheet->setCellValue('F'.$i, number_format($salary[$j]["ot2_value"]));

				if (isset($salary[$j]["ot3"]) && $salary[$j]["ot3"]>0) $sheet->setCellValue('G'.$i, $salary[$j]["ot3"]);
				if (isset($salary[$j]["ot3_value"]) && $salary[$j]["ot3_value"]>0) $sheet->setCellValue('F'.$i, number_format($salary[$j]["ot3_value"]));

				if (isset($salary[$j]["ot4"]) && $salary[$j]["ot4"]>0) $sheet->setCellValue('H'.$i, $salary[$j]["ot4"]);
				if (isset($salary[$j]["ot4_value"]) && $salary[$j]["ot4_value"]>0) $sheet->setCellValue('F'.$i, number_format($salary[$j]["ot4_value"]));
		
			
				
				if (isset($salary[$j]["luong_trocapdilai"]) && $salary[$j]["luong_trocapdilai"]>0) $sheet->setCellValue('M'.$i, number_format($salary[$j]["luong_trocapdilai"]));
				if (isset($salary[$j]["luong_trocaptiengnhat"]) && $salary[$j]["luong_trocaptiengnhat"]>0) $sheet->setCellValue('N'.$i, number_format($salary[$j]["luong_trocaptiengnhat"]));
				if (isset($salary[$j]["luong_trocaplienlac"]) && $salary[$j]["luong_trocaplienlac"]>0) $sheet->setCellValue('O'.$i, number_format($salary[$j]["luong_trocaplienlac"]));
				if (isset($salary[$j]["luong_trocapguixe"]) && $salary[$j]["luong_trocapguixe"]>0) $sheet->setCellValue('P'.$i, number_format($salary[$j]["luong_trocapguixe"]));
				if (isset($salary[$j]["luong_trocaptrachnhiem"]) && $salary[$j]["luong_trocaptrachnhiem"]>0) $sheet->setCellValue('Q'.$i, number_format($salary[$j]["luong_trocaptrachnhiem"]));
				if (isset($salary[$j]["luong_trocapantrua"]) && $salary[$j]["luong_trocapantrua"]>0) $sheet->setCellValue('R'.$i, number_format($salary[$j]["luong_trocapantrua"]));
				if (isset($salary[$j]["trocap_total"]) && $salary[$j]["trocap_total"]>0) $sheet->setCellValue('S'.$i, number_format($salary[$j]["trocap_total"]));
				if (isset($salary[$j]["luong_quyettoanconlaitrongnam"]) && $salary[$j]["luong_quyettoanconlaitrongnam"]>0) $sheet->setCellValue('T'.$i, number_format($salary[$j]["luong_quyettoanconlaitrongnam"]));
				
				
				
				if (isset($salary[$j]["luong_quyettoanconlaitrongnam_value"]) && $salary[$j]["luong_quyettoanconlaitrongnam_value"]>0) $sheet->setCellValue('U'.$i, number_format($salary[$j]["luong_quyettoanconlaitrongnam_value"]));
				if (isset($salary[$j]["luong_tienchucmungchiabuon"]) && $salary[$j]["luong_tienchucmungchiabuon"]>0) $sheet->setCellValue('V'.$i, number_format($salary[$j]["luong_tienchucmungchiabuon"]));
				if (isset($salary[$j]["luong_dieuchinhtruoctongluong"]) && $salary[$j]["luong_dieuchinhtruoctongluong"]>0) $sheet->setCellValue('W'.$i, number_format($salary[$j]["luong_dieuchinhtruoctongluong"]));
				if (isset($salary[$j]["luong_giolamthieutrongthang"]) && $salary[$j]["luong_giolamthieutrongthang"]>0) $sheet->setCellValue('X'.$i, $salary[$j]["luong_giolamthieutrongthang"]);
				if (isset($salary[$j]["luong_giolamthieutrongthang_value"]) && $salary[$j]["luong_giolamthieutrongthang_value"]>0) $sheet->setCellValue('Y'.$i, number_format($salary[$j]["luong_giolamthieutrongthang_value"]));
				if (isset($salary[$j]["luong_sogionghiphepnghibu"]) && $salary[$j]["luong_sogionghiphepnghibu"]>0) $sheet->setCellValue('Z'.$i, $salary[$j]["luong_sogionghiphepnghibu"]);
				if (isset($salary[$j]["luong_sogionghiphepnghibu_value"]) && $salary[$j]["luong_sogionghiphepnghibu_value"]>0) $sheet->setCellValue('AA'.$i, number_format($salary[$j]["luong_sogionghiphepnghibu_value"]));				
				
			
				if (isset($salary[$j]["tongluong"]) && $salary[$j]["tongluong"]>0) $sheet->setCellValue('AB'.$i, number_format($salary[$j]["tongluong"]));
				if (isset($salary[$j]["luong_thunhapkhac"]) && $salary[$j]["luong_thunhapkhac"]>0) $sheet->setCellValue('AC'.$i, number_format($salary[$j]["luong_thunhapkhac"]));
				if (isset($salary[$j]["luong_thangluongthu13"]) && $salary[$j]["luong_thangluongthu13"]>0) $sheet->setCellValue('AD'.$i, number_format($salary[$j]["luong_thangluongthu13"]));
				if (isset($salary[$j]["trocapkhongchiuthue"]) && $salary[$j]["trocapkhongchiuthue"]>0) $sheet->setCellValue('AE'.$i, number_format($salary[$j]["trocapkhongchiuthue"]));
				if (isset($salary[$j]["tongluongkhongchiuthue"]) && $salary[$j]["tongluongkhongchiuthue"]>0) $sheet->setCellValue('AF'.$i, number_format($salary[$j]["tongluongkhongchiuthue"]));
				if (isset($salary[$j]["luong_songuoiphuthuoc"]) && $salary[$j]["luong_songuoiphuthuoc"]>0) $sheet->setCellValue('AG'.$i, $salary[$j]["luong_songuoiphuthuoc"]);
				
				

				if (isset($salary[$j]["thunhapchithuetruocgiamtru"]) && $salary[$j]["thunhapchithuetruocgiamtru"]>0) $sheet->setCellValue('AH'.$i, number_format($salary[$j]["thunhapchithuetruocgiamtru"]));
				if (isset($salary[$j]["thunhaptinhthuesaugiamtru"]) && $salary[$j]["thunhaptinhthuesaugiamtru"]>0) $sheet->setCellValue('AI'.$i, number_format($salary[$j]["thunhaptinhthuesaugiamtru"]));
				if (isset($salary[$j]["sothuephainopthangnay"]) && $salary[$j]["sothuephainopthangnay"]>0) $sheet->setCellValue('AJ'.$i, number_format($salary[$j]["sothuephainopthangnay"]));
				if (isset($salary[$j]["congtychiu_baohiemxahoi"]) && $salary[$j]["congtychiu_baohiemxahoi"]>0) $sheet->setCellValue('AK'.$i, number_format($salary[$j]["congtychiu_baohiemxahoi"]));
				if (isset($salary[$j]["congtychiu_baohiemyte"]) && $salary[$j]["congtychiu_baohiemyte"]>0) $sheet->setCellValue('AL'.$i, number_format($salary[$j]["congtychiu_baohiemyte"]));
				if (isset($salary[$j]["congtychiu_baohiemthatnghiep"]) && $salary[$j]["congtychiu_baohiemthatnghiep"]>0) $sheet->setCellValue('AM'.$i, number_format($salary[$j]["congtychiu_baohiemthatnghiep"]));
				if (isset($salary[$j]["congtychiu_kinhphicongdoan"]) && $salary[$j]["congtychiu_kinhphicongdoan"]>0) $sheet->setCellValue('AN'.$i, number_format($salary[$j]["congtychiu_kinhphicongdoan"]));
				if (isset($salary[$j]["congtychiubaohiem_total"]) && $salary[$j]["congtychiubaohiem_total"]>0) $sheet->setCellValue('AO'.$i, number_format($salary[$j]["congtychiubaohiem_total"]));
				if (isset($salary[$j]["canhanchiu_baohiemxahoi"]) && $salary[$j]["canhanchiu_baohiemxahoi"]>0) $sheet->setCellValue('AP'.$i, number_format($salary[$j]["canhanchiu_baohiemxahoi"]));
				if (isset($salary[$j]["canhanchiu_baohiemyte"]) && $salary[$j]["canhanchiu_baohiemyte"]>0) $sheet->setCellValue('AQ'.$i, number_format($salary[$j]["canhanchiu_baohiemyte"]));
				if (isset($salary[$j]["canhanchiu_baohiemthatnghiep"]) && $salary[$j]["canhanchiu_baohiemthatnghiep"]>0) $sheet->setCellValue('AR'.$i, number_format($salary[$j]["canhanchiu_baohiemthatnghiep"]));
				if (isset($salary[$j]["canhanchiubaohiem_total"]) && $salary[$j]["canhanchiubaohiem_total"]>0) $sheet->setCellValue('AS'.$i, number_format($salary[$j]["canhanchiubaohiem_total"]));
				if (isset($salary[$j]["tongluongconlaichuatra"]) && $salary[$j]["tongluongconlaichuatra"]>0) $sheet->setCellValue('AT'.$i, number_format($salary[$j]["tongluongconlaichuatra"]));
				if (isset($salary[$j]["luong_trocapbaohiem_trathuenopthua"]) && $salary[$j]["luong_trocapbaohiem_trathuenopthua"]>0) $sheet->setCellValue('AU'.$i, number_format($salary[$j]["luong_trocapbaohiem_trathuenopthua"]));
				if (isset($salary[$j]["tongluongthucnhantruatra"]) && $salary[$j]["tongluongthucnhantruatra"]>0) $sheet->setCellValue('AV'.$i, number_format($salary[$j]["tongluongthucnhantruatra"]));
				if (isset($salary[$j]["luong_thangtruocchuyenqua"])) $sheet->setCellValue('AW'.$i, number_format($salary[$j]["luong_thangtruocchuyenqua"]));
				if (isset($salary[$j]["tongluongdanhanchuyenkhoan"]) && $salary[$j]["tongluongdanhanchuyenkhoan"]>0) $sheet->setCellValue('AX'.$i, number_format($salary[$j]["tongluongdanhanchuyenkhoan"]));
	
	
				if (isset($salary[$j]["bank_number"]) && !empty($salary[$j]["bank_number"])) $sheet->setCellValue('AY'.$i, ' '.$salary[$j]["bank_number"]);
				if (isset($salary[$j]["tienthuong"]) && $salary[$j]["tienthuong"]>0) $sheet->setCellValue('AZ'.$i, number_format($salary[$j]["tienthuong"]));
				
				$i++;
			}
			
			
			
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="Payroll'.$current_year."_".$current_month.'.xlsx"');
			header('Cache-Control: max-age=0');
			
			$writer = PHPExcel_IOFactory::createWriter($xl, 'Excel2007');
			$writer->save('php://output');		
			die;
			
								
		}



		if (!empty($req["print"]) && $req["print"]=='payslip')
			$o_smarty->display("salary/payslip.tpl");
		else
			$o_smarty->display("salary/index.tpl");
	
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
	header("location: /salary/");
		
	//echo count($data);
	
		//echo "<pre>";
		///print_r($aryResult);
  
  }










  
}