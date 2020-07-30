<?php

class General
{

 	//type=1 export
	//type=2 export delete
 	//type=3 import
	//type=4 import delete	
 	//type=5 return
	//type=6 return delete	
 	//type=7 cancel
	//type=8 cancel delete	
	//type=9 chot kho	

	
	//type=10 branch return
	//type=11 branch return delete		
		
	function tinhkho($id, $type){
		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
		$sql = "set autocommit = 0";
		$db->query($sql);
			
		$product_list=array();
		//export
		if ($type==1){
			$sql="select product_id from general_export_detail where export_id='".$id."'";
			$rs = $db->query($sql);
			while ($rows = $db->fetch_array($rs)) {
				$product_list[]= $rows;
			}	
	
		}
		
		//import
		if ($type==3){
			$sql="select product_id from general_import_detail where import_id='".$id."'";
			$rs = $db->query($sql);
			while ($rows = $db->fetch_array($rs)) {
				$product_list[]= $rows;
			}	
	
		}		
		
		//return
		if ($type==5){
			$sql="select product_id from general_return_detail where return_id='".$id."'";
			$rs = $db->query($sql);
			while ($rows = $db->fetch_array($rs)) {
				$product_list[]= $rows;
			}	
	
		}	
		
		
		//cancel
		if ($type==7){
			$sql="select product_id from general_cancel_detail where cancel_id='".$id."'";
			$rs = $db->query($sql);
			while ($rows = $db->fetch_array($rs)) {
				$product_list[]= $rows;
			}	
	
		}		
		
		
		
		//total branch return
		if ($type==10){
			$sql="select product_id from general_branch_return_detail where return_id='".$id."'";
			$rs = $db->query($sql);
			while ($rows = $db->fetch_array($rs)) {
				$product_list[]= $rows;
			}	
	
		}				
		
		//export or import delete
		if ($type==2 || $type==4 || $type==6 || $type==8 || $type==9 || $type==11){
			for($i=0;$i<count($id);$i++)
				$product_list[$i]['product_id']=$id[$i];
		}
		
		
		for($i=0;$i<count($product_list);$i++){
			//echo $product_list[$i]["product_id"]."<br>";
			//tinh toan ngay chot kho
			$sql="select inventory_date from general_store where product_id='".$product_list[$i]["product_id"]."' ";
			$sql .=" AND inventory_date is not null order by inventory_date desc limit 1";
			$store_one = $db->query_first($sql);	
			//echo $sql."<br>";
			
			$import_date=$export_date=$return_date=$cancel_date="";
			if (!empty($store_one)){
				$import_date=" and b.import_date>'".$store_one["inventory_date"]."'";
				$export_date=" and b.export_date>'".$store_one["inventory_date"]."'";
				$return_date=" and b.return_date>'".$store_one["inventory_date"]."'";
				$cancel_date=" and b.cancel_date>'".$store_one["inventory_date"]."'";
			}
				
			//tong nhap
			$sql="select sum(a.qty) as sumofqty  from general_import_detail a 
			left join general_import b on a.import_id=b.id
			where a.product_id='".$product_list[$i]["product_id"]."' ".$import_date;	
			$store_import_detail_one = $db->query_first($sql);
			$total_import=doubleval($store_import_detail_one["sumofqty"]);		
	
			//tong xuat
			$sql="select sum(a.qty) as sumofqty  from general_export_detail a 
			left join general_export b on a.export_id=b.id
			where a.product_id='".$product_list[$i]["product_id"]."' ".$export_date;	
			$store_import_detail_one = $db->query_first($sql);
			$total_export=doubleval($store_import_detail_one["sumofqty"]);		
			
			//Tra hang
			$sql="select sum(a.qty) as sumofqty  from general_return_detail a 
			left join general_return b on a.return_id=b.id
			where a.product_id='".$product_list[$i]["product_id"]."' ".$return_date;	
			$store_return_detail_one = $db->query_first($sql);
			$total_return=doubleval($store_return_detail_one["sumofqty"]);	
			
			
			//Nhan tra hang tu chi nhanh
			$sql="select sum(a.qty) as sumofqty  from general_branch_return_detail a 
			left join general_branch_return b on a.return_id=b.id
			where a.product_id='".$product_list[$i]["product_id"]."' ".$return_date;	
			$general_branch_return_detail_one = $db->query_first($sql);
			$total_branch_return=doubleval($general_branch_return_detail_one["sumofqty"]);	
						
			//Huy hang, hang hong
			$sql="select sum(a.qty) as sumofqty  from general_cancel_detail a 
			left join general_cancel b on a.cancel_id=b.id
			where a.product_id='".$product_list[$i]["product_id"]."' ".$cancel_date;	
			$store_cancel_detail_one = $db->query_first($sql);
			$total_cancel=doubleval($store_cancel_detail_one["sumofqty"]);			

			
			$tonkho=$total_branch_return+$total_import-$total_export-$total_return-$total_cancel;

			
			
			if ($type==9){
				$sql="select * from general_inventory where product_id='".$product_list[$i]["product_id"]."' order by id desc limit 1";
				$general_inventory_one= $db->query_first($sql);	


				$sql="update general_store set 
					total_import=".$total_import.",
					total_export=".$total_export.",
					total_cancel=".$total_cancel.",
					total_return=".$total_return.",
					total_branch_return=".$total_branch_return.",
					total_tonkho=total_dauky+".$tonkho.",
					total_inventory=".$general_inventory_one["qty"].",
					total_cuoiky=".$general_inventory_one["qty"].",
					inventory_date=".time()."
					where product_id='".$product_list[$i]["product_id"]."' and  inventory_date is null
				";
				$db->query($sql) or die("error: s2");
		
			
				$sql="insert into general_store(
					product_id,
					total_dauky,
					total_tonkho					
				) values(";
				
				$sql .="
					'".$product_list[$i]["product_id"]."', 
					".$general_inventory_one["qty"].", 
					".$general_inventory_one["qty"]."
				)";
				$db->query($sql) or die("error: s2");			


				
			
			}else{
			
			
			
				//giao dich truoc no
				$sql="select * from general_store where product_id='".$product_list[$i]["product_id"]."' and  inventory_date is null";
				$general_store_one = $db->query_first($sql);		
				if (empty($general_store_one)){
					$sql="insert into general_store(
						product_id,
						total_import,
						total_export,
						total_cancel,
						total_return,
						total_branch_return,
						total_tonkho					
					) values(";
					
					$sql .="
						'".$product_list[$i]["product_id"]."', 
						".$total_import.",
						".$total_export.",
						".$total_cancel.",
						".$total_return.",
						".$total_branch_return.",
						".$tonkho."
					)";
					$db->query($sql) or die("error: s2");
				
				}else{
					$sql="update general_store set 
						total_import=".$total_import.",
						total_export=".$total_export.",
						total_cancel=".$total_cancel.",
						total_return=".$total_return.",
						total_branch_return=".$total_branch_return.",
						total_tonkho=total_dauky+".$tonkho."
						where product_id='".$product_list[$i]["product_id"]."' and  inventory_date is null
					";
					$db->query($sql) or die("error: s2");
					//echo $sql."<br>";
				
				}
				
				
			
			
			
			
			}
			
			
			
			
			
			
		}//for($i=0;$i<count($product_list);$i++){
		
		//コミット
		$sql = "commit";
		$db->query($sql);	
		$db->close();
			
		//die;
		
	
	}

}