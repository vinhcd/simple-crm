<?php
require_once 'Staff.php';

class Permission
{

		
	function check_access_page($staff_id, $module_id){
		
		//check neu la admin
		$staff = new Staff();
		if ($staff->staff_one($staff_id)["permission"]==2){
			return true;
		}
		
		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	


		//neu ko phai la admin thi check xem user nay co quyen truy cap vao page hay khong
		$sql="select * from permission where staff_id={$staff_id} and module_id={$module_id}";
		$permission_one= $db->query_first($sql);
		$db->close();
		
		if (empty($permission_one)){
			return false;
		}else{
			return true;
		}
	
			
	}
	


	function permission_one($staff_id, $module_id){
		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
		$sql="select * from permission where staff_id={$staff_id} and module_id={$module_id}";
		$permission_one= $db->query_first($sql);
		$db->close();
		
		if (empty($permission_one)){
			return null;
		}else{
			return $permission_one;
		}
			
	}
		

	function datalist($staff_id){
		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
		
		$sql="select module_id from permission where staff_id=".$staff_id;
			
		$data=array();	
		$rs = $db->query($sql);
		$i=0;
		while ($rows = $db->fetch_array($rs)) {	
			$data[$i]= $rows["module_id"];		
			$i++;	
		}	
			
		$db->close();
		
		return $data;
			
	}
	
	

}