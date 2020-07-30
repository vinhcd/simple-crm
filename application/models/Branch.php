<?php

class Branch
{

 	//type=1 import	
	//type=2 import del	
	//type=3 return	
	//type=4 return	del
	//type=5 transfer	
	//type=6 transfer del
	//type=7 cancel	
	//type=8 cancel del
	//type=9 inventory
	
	//type=10 export	
	//type=11 export del	
				
	function tinhkho($id, $type){
		$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);				
		$db->connect();	
		$sql = "set autocommit = 0";
		$db->query($sql);
			
		$product_list=array();

		
		//import
		if ($type==1){
			$sql="select product_id, b.branch_id from branch_import_detail a 
			left join branch_import b on a.import_id=b.id
			where a.import_id='".$id."'";
			$rs = $db->query($sql);
			while ($rows = $db->fetch_array($rs)) {
				$product_list[]= $rows;
			}	
	
		}		
		
		//return
		if ($type==3){
			$sql="select a.product_id, b.branch_id from branch_return_detail a 
			left join branch_return b on a.return_id=b.id
			where a.return_id='".$id."'";
			$rs = $db->query($sql);
			while ($rows = $db->fetch_array($rs)) {
				$product_list[]= $rows;
			}	
	
		}
		
		
		//transfer
		if ($type==5){
			$sql="select a.product_id, b.from_branch_id as branch_id from branch_transfer_detail a 
			left join branch_transfer b on a.transfer_id=b.id
			where a.transfer_id='".$id."'";
			$rs = $db->query($sql);
			while ($rows = $db->fetch_array($rs)) {
				$product_list[]= $rows;
			}
		}
			
			
		//cancel
		if ($type==7){
			$sql="select a.product_id, b.branch_id from branch_cancel_detail a 
			left join branch_cancel b on a.cancel_id=b.id
			where a.cancel_id='".$id."'";
			$rs = $db->query($sql);
			while ($rows = $db->fetch_array($rs)) {
				$product_list[]= $rows;
			}	
	
		}

		//cancel
		if ($type==10){
			$sql="select a.product_id, b.branch_id from branch_export_detail a 
			left join branch_export b on a.export_id=b.id
			where a.export_id='".$id."'";
			$rs = $db->query($sql);
			while ($rows = $db->fetch_array($rs)) {
				$product_list[]= $rows;
			}	
	
		}							
			
		//delete
		if ($type==2 || $type==4 || $type==6 || $type==8 || $type==9 || $type==11){
		//echo count($id);die;
			for($i=0;$i<count($id);$i++){
				$product_list[$i]['product_id']=$id[$i]["product_id"];
				$product_list[$i]['branch_id']=$id[$i]["branch_id"];
			}
		}				
		
		for($i=0;$i<count($product_list);$i++){
			//echo $product_list[$i]["product_id"]."<br>";
			//tinh toan ngay chot kho
			$sql="select inventory_date from branch_store where branch_id='".$product_list[$i]["branch_id"]."' and product_id='".$product_list[$i]["product_id"]."' ";
			$sql .=" AND inventory_date is not null order by inventory_date desc limit 1";
			$store_one = $db->query_first($sql);	
			//echo $sql."<br>";
			
			$import_date=$export_date=$return_date=$cancel_date=$transfer_date="";
			if (!empty($store_one)){
				$import_date=" and b.import_date>'".$store_one["inventory_date"]."'";
				$export_date=" and b.export_date>'".$store_one["inventory_date"]."'";
				$return_date=" and b.return_date>'".$store_one["inventory_date"]."'";
				$transfer_date=" and b.transfer_date>'".$store_one["inventory_date"]."'";
				$cancel_date=" and b.cancel_date>'".$store_one["inventory_date"]."'";
			}
				
			//tong nhap
			$sql="select sum(a.qty) as sumofqty  from branch_import_detail a 
			left join branch_import b on a.import_id=b.id
			where b.branch_id='".$product_list[$i]["branch_id"]."' and a.product_id='".$product_list[$i]["product_id"]."' ".$import_date;	
			$store_import_detail_one = $db->query_first($sql);
			$total_import=doubleval($store_import_detail_one["sumofqty"]);		
			
			//tong xuat
			$sql="select sum(a.qty) as sumofqty  from branch_export_detail a 
			left join branch_export b on a.export_id=b.id
			where b.branch_id='".$product_list[$i]["branch_id"]."' and a.product_id='".$product_list[$i]["product_id"]."' ".$export_date;	
			$store_export_detail_one = $db->query_first($sql);
			$total_export=doubleval($store_export_detail_one["sumofqty"]);	
			
			//Tra hang
			$sql="select sum(a.qty) as sumofqty  from branch_return_detail a 
			left join branch_return b on a.return_id=b.id
			where b.branch_id='".$product_list[$i]["branch_id"]."' and a.product_id='".$product_list[$i]["product_id"]."' ".$return_date;	
			$store_return_detail_one = $db->query_first($sql);
			$total_return=doubleval($store_return_detail_one["sumofqty"]);	

			//Chuyen kho
			$sql="select sum(a.qty) as sumofqty  from branch_transfer_detail a 
			left join branch_transfer b on a.transfer_id=b.id
			where b.from_branch_id='".$product_list[$i]["branch_id"]."' and a.product_id='".$product_list[$i]["product_id"]."' ".$transfer_date;	
			$store_transfer_detail_one = $db->query_first($sql);
			$total_transfer=doubleval($store_transfer_detail_one["sumofqty"]);	
			
			//Huy hang, hang hong
			$sql="select sum(a.qty) as sumofqty  from branch_cancel_detail a 
			left join branch_cancel b on a.cancel_id=b.id
			where b.branch_id='".$product_list[$i]["branch_id"]."' and a.product_id='".$product_list[$i]["product_id"]."' ".$cancel_date;	
			$store_cancel_detail_one = $db->query_first($sql);
			$total_cancel=doubleval($store_cancel_detail_one["sumofqty"]);				
			
			
			
			$tonkho=$total_import-$total_export-$total_return-$total_cancel-$total_transfer;

			
			
			if ($type==9){
				$sql="select * from branch_inventory where branch_id='".$product_list[$i]["branch_id"]."' and  product_id='".$product_list[$i]["product_id"]."' order by id desc limit 1";
				$branch_inventory_one= $db->query_first($sql);	


				$sql="update branch_store set 
					total_import=".$total_import.",
					total_export=".$total_export.",
					total_cancel=".$total_cancel.",
					total_return=".$total_return.",
					total_transfer=".$total_transfer.",
					total_tonkho=total_dauky+".$tonkho.",
					total_inventory=".$branch_inventory_one["qty"].",
					total_cuoiky=".$branch_inventory_one["qty"].",
					inventory_date=".time()."
					where branch_id='".$product_list[$i]["branch_id"]."' and  product_id='".$product_list[$i]["product_id"]."' and  inventory_date is null
				";
				$db->query($sql) or die("error: s2");
		
			
				$sql="insert into branch_store(
					product_id,
					branch_id,
					total_dauky,
					total_tonkho					
				) values(";
				
				$sql .="
					'".$product_list[$i]["product_id"]."', 
					'".$product_list[$i]["branch_id"]."', 
					".$branch_inventory_one["qty"].", 
					".$branch_inventory_one["qty"]."
				)";
				$db->query($sql) or die("error: s2");			
			
			}else{

				//giao dich truoc no
				$sql="select * from branch_store where branch_id='".$product_list[$i]["branch_id"]."' and  product_id='".$product_list[$i]["product_id"]."' and  inventory_date is null";
				$branch_store_one = $db->query_first($sql);		
				if (empty($branch_store_one)){
					$sql="insert into branch_store(
						product_id,
						branch_id,
						total_import,
						total_export,
						total_cancel,
						total_return,
						total_transfer,
						total_tonkho					
					) values(";
					
					$sql .="
						'".$product_list[$i]["product_id"]."', 
						'".$product_list[$i]["branch_id"]."', 
						".$total_import.",
						".$total_export.",
						".$total_cancel.",
						".$total_return.",
						".$total_transfer.",
						".$tonkho."
					)";
					$db->query($sql) or die("error: s2");
				
				}else{
					$sql="update branch_store set 
						total_import=".$total_import.",
						total_export=".$total_export.",
						total_cancel=".$total_cancel.",
						total_return=".$total_return.",
						total_transfer=".$total_transfer.",
						total_tonkho=total_dauky+".$tonkho."
						where branch_id='".$product_list[$i]["branch_id"]."' and  product_id='".$product_list[$i]["product_id"]."' and  inventory_date is null
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