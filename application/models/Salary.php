<?php
require_once 'Common.php';

class Salary
{


	//từ 0-14 sẽ tính là 0; 15 -29 tính là 0,25; từ 30 đến 44 tính là 0,5 từ 45 đến 59 tính là 0,75				

	function block_time($work_hours){
	
		$fraction = $work_hours - floor($work_hours);
		///echo ($fraction*60)."<br>";
		
		if ($fraction*60<=14)
			$work_hours=floor($work_hours);
		elseif ($fraction*60<=29)
			$work_hours=floor($work_hours)+0.25;
		elseif ($fraction*60<=44)
			$work_hours=floor($work_hours)+0.5;
		else
			$work_hours=floor($work_hours)+0.75;	
			
		return $work_hours;
	}
	
	


	function work_hours($start_time, $finish_time, $staff_id, $db){
		$start_time=date("Y/m/d H:i:s",strtotime($start_time));
		
		$t7cn_start=$start_time;
		$t7cn_finish=$finish_time;
			
		$common = new Common();
		$ot_time=$finish_time;
		
		$work_hours=0;
		$ot1=$ot2=$ot3=$ot4=0;
		
		if (strtotime($start_time)<strtotime(date("Y/m/d 8:30:00",strtotime($start_time))))
			$start_time=date("Y/m/d 8:30:00",strtotime($start_time));
	
		if (strtotime($start_time)<strtotime(date("Y/m/d 13:30:00",strtotime($start_time))) && strtotime($start_time)>strtotime(date("Y/m/d 12:00:00",strtotime($start_time))))
			$start_time=date("Y/m/d 13:30:00",strtotime($start_time));
						
	
		//if (strtotime($finish_time)>strtotime(date("Y/m/d 18:00:00",strtotime($finish_time))))
		//$finish_time=date("Y/m/d 18:00:00",strtotime($finish_time));
		
		if (strtotime($finish_time)>strtotime(date("Y/m/d 12:00:00",strtotime($finish_time))) && strtotime($finish_time)<strtotime(date("Y/m/d 13:30:00",strtotime($finish_time))))
			$finish_time=date("Y/m/d 12:00:00",strtotime($finish_time));
		
		if (strtotime($start_time)>strtotime(date("Y/m/d 12:00:00",strtotime($start_time))))
			$finish_time=date("Y/m/d 18:00:00",strtotime($finish_time));
			
			
		
		//echo $start_time." ".$finish_time."<br>";		
		
		$wh_temp=strtotime($finish_time)-strtotime($start_time);
		
		//loai gio nghi trua
		if (strtotime($start_time)<strtotime(date("Y/m/d 12:00:00",strtotime($start_time))) && strtotime($finish_time)>strtotime(date("Y/m/d 13:30:00",strtotime($start_time))))
			$wh_temp=$wh_temp-3600*1.5;
			
		$work_hours=$wh_temp/3600;
						
		if ($work_hours>8) 
			$work_hours=8;
		else{
			$work_hours=$this->block_time($work_hours);
		}
		
		if ($work_hours<0) $work_hours=0;				
		
		
		//1.trước 10h tối  và ngày thường thì là loại 1: 150%
		//2. sau 10 tối và ngày thường thì là loại 2: 200%
		//3. thứ 7,cn thì là loại 3: x200%
		//4. loại 4 thì do em nhập: 300%
		
		//tính OT
		//ot loại 1,2
		
		
		$sql="select a.id from overtime a
		left join overtime_staff b on a.id=b.overtime_id
		where b.staff_id='".$staff_id."' and a.approved=1 and DATE_FORMAT(a.from_time,'%Y/%m/%d')='".date("Y/m/d",strtotime($start_time))."' limit 1";
		$overtime_one= $db->query_first($sql);

		
		if (strtotime($ot_time)>strtotime(date("Y/m/d 19:15:00",strtotime($start_time)))){

			
			
			if (!empty($overtime_one)){
				if (strtotime($ot_time)>strtotime(date("Y/m/d 22:00:00",strtotime($start_time)))){
					$ot_time=strtotime($ot_time)-strtotime(date("Y/m/d 19:00:00",strtotime($start_time)));
					$ot1=3;
					$ot2=$this->block_time($ot_time/3600)-3;
	
				}else{
					$ot_time=strtotime($ot_time)-strtotime(date("Y/m/d 19:00:00",strtotime($start_time)));
					$ot1=$this->block_time($ot_time/3600);
				}
			}
		
		}

		
		//ot t7, cn
		//echo $this->isThisDayAWeekend($start_time);
		if ($common->isThisDayAWeekend($start_time)) $work_hours=$ot1=$ot2=$ot3=$ot4=0;
		
		if (!empty($overtime_one) && $common->isThisDayAWeekend($start_time)){
			$wh_temp=strtotime($t7cn_finish)-strtotime($t7cn_start);	
			//loai gio nghi trua
			if (strtotime($t7cn_start)<strtotime(date("Y/m/d 12:00:00",strtotime($t7cn_start))) && strtotime($t7cn_finish)>strtotime(date("Y/m/d 13:30:00",strtotime($t7cn_start))))
				$wh_temp=$wh_temp-3600*1.5;
						
			$ot3=$this->block_time($wh_temp/3600);
		}
		
		//check xem co phai ngay le khong
		$sql="select * from national_days where DATE_FORMAT(national_day,'%Y/%m/%d')='".date("Y/m/d",strtotime($start_time))."'";
		$national_days_one= $db->query_first($sql);
		if (!empty($national_days_one)) $work_hours=$ot1=$ot2=$ot3=$ot4=0;

		
		if (!empty($overtime_one) && !empty($national_days_one)){
			$wh_temp=strtotime($t7cn_finish)-strtotime($t7cn_start);	
			//loai gio nghi trua
			if (strtotime($t7cn_start)<strtotime(date("Y/m/d 12:00:00",strtotime($t7cn_start))) && strtotime($t7cn_finish)>strtotime(date("Y/m/d 13:30:00",strtotime($t7cn_start))))
				$wh_temp=$wh_temp-3600*1.5;
						
			$ot4=$this->block_time($wh_temp/3600);

		}						

		return array($work_hours, $ot1, $ot2, $ot3, $ot4);

	}	
	
	
	

}