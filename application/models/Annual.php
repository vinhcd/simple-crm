<?php
require_once 'Common.php';
require_once 'Salary.php';
class Annual
{


	public function updateAnnual($staff_id="", $db){
		
		$sql="select * from staff where valid=0";
		if (!empty($staff_id)) $sql .=" and id='".$staff_id."'";
		
		
		$store_staff=array();
		$rs = $db->query($sql);	
		$i=0;
		while ($rows = $db->fetch_array($rs)){
			$staff[$i]= $rows;
			$i++;
		}	
		
		
		$year=date("Y");
		$month=date("n");
		
		if ($month==1) {
			$year=$year-1;
			$month=12;
		}else{
			$month=$month-1;
		}
		
		
		//if ($month>1) $month=$month-1;
		
		$start=1;
		if (!empty($staff_id)) $start=$month;

		for ($i=1;$i<=$month;$i++){
			for ($j=0;$j<count($staff);$j++){
				$dauky=0;
				if ($i>1){
					$sql="select * from ngayphep where staff_id='".$staff[$j]["id"]."' and month_year='".$year."-".($i-1)."'";
					$ngayphep_one = $db->query_first($sql);
					$dauky=$ngayphep_one["sophepconlai"];
				}
				$tangtrogthang=8;
				//tinh so phep su dung
				
				$date_from=$year."-".$i."-1";
				$date_to=date("Y-m-t 23:59:59", strtotime($date_from));
				$tinhngayphep=$this->tinhngayphepAction($staff[$j]["id"], strtotime($date_from), strtotime($date_to), $db);
				
				//tong so gio lam bi thieu trong thang
				$sogiolamthieu=$tinhngayphep[1];
				
				
				
				//so phep co the su dung trong thang
				$phepcothedung=$dauky+$tangtrogthang;
				
				$sql="select * from ngayphep where staff_id='".$staff[$j]["id"]."' and month_year='".$year."-".$i."'";
				$ngayphep_one2 = $db->query_first($sql);
				$phepcothedung +=$ngayphep_one2["dieuchinhphep"];
				
	
				
				//tinh so phep su dung
				$sophepsudung=0;
				if ($sogiolamthieu>0)
				if ($sogiolamthieu>=$phepcothedung){
					$sophepsudung=$phepcothedung;
				}else{
					$sophepsudung=$sogiolamthieu;
					
				}
				
				//tinh so phep con lai
				$sophepconlai=$phepcothedung;
				if ($sophepsudung>0)
					if ($sogiolamthieu>$sophepsudung){
						$sophepconlai=0;
					}else{
						$sophepconlai=$phepcothedung-$sogiolamthieu;
					}
						
				
				//tinh so gio tru luong
				$sogiotruluong=0;
				if ($sophepconlai<=0 && $sogiolamthieu>0) $sogiotruluong=$sogiolamthieu-$sophepsudung;
				

				if (empty($ngayphep_one2)){
					$data=array();
					$data["staff_id"]=$staff[$j]["id"];
					$data["month_year"]=$year."-".$i;
					$data["dauky"]=$dauky;
					$data["tangtrogthang"]=$tangtrogthang;
					$data["sophepsudung"]=$sophepsudung;
					$data["sophepconlai"]=$sophepconlai;
					$data["sogiolamthieu"]=$sogiolamthieu;
					$data["sogiotruluong"]=$sogiotruluong;
					
					
					if ($db->query_insert("ngayphep", $data)===false){
						$db->query("rollback");
						$db->close();
						die("err");
					}	
									
				}else{
				
					$data=array();
					$data["dauky"]=$dauky;
					$data["tangtrogthang"]=$tangtrogthang;
					$data["sophepsudung"]=$sophepsudung;
					$data["sophepconlai"]=$sophepconlai;
					$data["sogiolamthieu"]=$sogiolamthieu;
					$data["sogiotruluong"]=$sogiotruluong;
					
					if ($db->query_update("ngayphep", $data, "staff_id='".$staff[$j]["id"]."' and month_year='".$year."-".$i."'")===false){
						$db->query("rollback");
						$db->close();
						die("err");
					}				
				
				}
		
			
			}
		
		}		
		
		
		
		
		//$db->close();	
		
	
		//die('ok');	
	
	} 






  public function tinhngayphepAction($staff_id, $date_from, $date_to, $db){
		ini_set('display_errors', 1);
		$salary = new Salary();
		$common = new Common();
		$sql="select * from staff where valid=0 and id='".$staff_id."'";
		$rs = $db->query($sql);
		$woking_time=array();
		$i=0;
		$total_wh=0;
		$total_mh=0;
		while ($rows = $db->fetch_array($rs)) {	

			for ($j=$date_from; $j<=$date_to; $j+=86400) {  
				
				$sql="select * from time_sheet where staff_id='".$rows['id']."' and DATE_FORMAT(check_in,'%Y-%m-%d')='".date("Y-m-d", $j)."'";
				
				$time_sheet_one= $db->query_first($sql);
				
				$work_hours=0;
				if (!empty($time_sheet_one["check_in"]) && !empty($time_sheet_one["check_out"])){
				
					$wt=$salary->work_hours($time_sheet_one["check_in"], $time_sheet_one["check_out"], $rows["id"], $db);
					$work_hours=$wt[0];
					$total_wh+=doubleval($wt[0]);
				}

				//tinh gio lam thieu
				$sql="select * from national_days where DATE_FORMAT(national_day,'%Y/%m/%d')='".date("Y/m/d", $j)."'";
				$national_days_one= $db->query_first($sql);
		
		
				//tinh gio lam thieu
				if (!$common->isThisDayAWeekend(date("Y/m/d", $j)) && empty($national_days_one)) $woking_time[$i]["mh"]= 8-$work_hours;
				if (!$common->isThisDayAWeekend(date("Y/m/d", $j)) && empty($national_days_one)) $total_mh+=8-doubleval($work_hours);

				
				$i++;
			}  	
			
			
		}	

		return array($total_wh, $total_mh);
  } 
	
	

}