<?php

class Staff
{

		
	function datalist($id="",$con=""){
		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
		
		
		if ($id=="martpos")
			$sql="select * from staff where 1=1 $con order by createdate desc";
		else
			$sql="select * from staff where login_id<>'martpos' $con order by createdate desc";
			
		$staff=array();	
		$rs = $db->query($sql);
		$i=0;
		while ($rows = $db->fetch_array($rs)) {	
			$staff[$i]= $rows;		
			$i++;	
		}	
			
		$db->close();
		
		return $staff;
			
	}
	
	
	
	function staff_one($id){
		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
		$sql="select * from staff where valid=0 and id=".$id;
		$staff_one= $db->query_first($sql);
		$db->close();
		
		if (empty($staff_one)){
			return null;
		}else{
			return $staff_one;
		}
			
	}	
	
	

}