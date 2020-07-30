<?php

class Kitchen
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
			$sql="select product_id, b.branch_id from kitchen_import_detail a 
			left join kitchen_import b on a.import_id=b.id
			where a.import_id='".$id."'";
			$rs = $db->query($sql);
			while ($rows = $db->fetch_array($rs)) {
				$product_list[]= $rows;
			}	
	
		}		
		
		//return
		if ($type==3){
			$sql="select a.product_id, b.branch_id from kitchen_return_detail a 
			left join kitchen_return b on a.return_id=b.id
			where a.return_id='".$id."'";
			$rs = $db->query($sql);
			while ($rows = $db->fetch_array($rs)) {
				$product_list[]= $rows;
			}	
	
		}
		
		
		//transfer
		if ($type==5){
			$sql="select a.product_id, b.from_branch_id as branch_id from kitchen_transfer_detail a 
			left join kitchen_transfer b on a.transfer_id=b.id
			where a.transfer_id='".$id."'";
			$rs = $db->query($sql);
			while ($rows = $db->fetch_array($rs)) {
				$product_list[]= $rows;
			}
		}
			
			
		//cancel
		if ($type==7){
			$sql="select a.product_id, b.branch_id from kitchen_cancel_detail a 
			left join kitchen_cancel b on a.cancel_id=b.id
			where a.cancel_id='".$id."'";
			$rs = $db->query($sql);
			while ($rows = $db->fetch_array($rs)) {
				$product_list[]= $rows;
			}	
	
		}

		//export
		if ($type==10){
			$sql="select distinct b.product_id, c.branch_id, d.qty_dinhluong from invoice_detail a 
left join menu_detail b on a.menu_id=b.menu_id
left join invoice c on a.invoice_id=c.id
left join product d on b.product_id=d.id
where a.invoice_id='".$id."'";
			$rs = $db->query($sql);
			while ($rows = $db->fetch_array($rs)) {
				$product_list[]= $rows;
			}	
			
			//var_dump($product_list);
			
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
			$sql="select inventory_date from kitchen_store where branch_id='".$product_list[$i]["branch_id"]."' and product_id='".$product_list[$i]["product_id"]."' ";
			$sql .=" AND inventory_date is not null order by inventory_date desc limit 1";
			$store_one = $db->query_first($sql);	
			//echo $sql."<br>";
			
			$import_date=$export_date=$return_date=$cancel_date=$transfer_date="";
			if (!empty($store_one)){
				$import_date=" and b.import_date>'".$store_one["inventory_date"]."'";
				$export_date=" and c.sale_date>'".$store_one["inventory_date"]."'";
				$return_date=" and b.return_date>'".$store_one["inventory_date"]."'";
				$cancel_date=" and b.cancel_date>'".$store_one["inventory_date"]."'";
			}
				
			//tong nhap
			$sql="select sum(a.qty) as sumofqty  from kitchen_import_detail a 
			left join kitchen_import b on a.import_id=b.id
			where b.branch_id='".$product_list[$i]["branch_id"]."' and a.product_id='".$product_list[$i]["product_id"]."' ".$import_date;	
			$store_import_detail_one = $db->query_first($sql);
			$total_import=doubleval($store_import_detail_one["sumofqty"]);		
			
			//tong xuat
			$sql="select d.unit_id, b.unit_id as unit_id_dinhluong,sum(b.qty*a.qty) as sumofqty from invoice_detail a 
left join menu_detail b on a.menu_id=b.menu_id
left join invoice c on a.invoice_id=c.id
left JOIN product d on b.product_id=d.id
where c.branch_id='".$product_list[$i]["branch_id"]."' and b.product_id='".$product_list[$i]["product_id"]."' ".$export_date;
			$store_export_detail_one = $db->query_first($sql);
			
			$total_export=0;

			if (doubleval($product_list[$i]["qty_dinhluong"])>0){
				$total_export=$store_export_detail_one["sumofqty"]/$product_list[$i]["qty_dinhluong"];
			}else{
				$total_export=$store_export_detail_one["sumofqty"];
			
			}
			
			/*		
			//gam to kg
			if ($store_export_detail_one["unit_id"]==9 && $store_export_detail_one["unit_id_dinhluong"]==10){
				$total_export=$store_export_detail_one["sumofqty"]/1000;
			//mL -> L	
			}elseif ($store_export_detail_one["unit_id"]==25 && $store_export_detail_one["unit_id_dinhluong"]==26){
				$total_export=$store_export_detail_one["sumofqty"]/1000;
				
			}else{
				$total_export=$store_export_detail_one["sumofqty"];
			}
			
			//echo $total_export."<br>";
			//var_dump($store_export_detail_one);
			//echo $sql;die;
			*/
			
			$total_export=doubleval($total_export);	
	

			
			
			//Tra hang
			$sql="select sum(a.qty) as sumofqty  from kitchen_return_detail a 
			left join kitchen_return b on a.return_id=b.id
			where b.branch_id='".$product_list[$i]["branch_id"]."' and a.product_id='".$product_list[$i]["product_id"]."' ".$return_date;	
			$store_return_detail_one = $db->query_first($sql);
			$total_return=doubleval($store_return_detail_one["sumofqty"]);	

			
			//Huy hang, hang hong
			$sql="select sum(a.qty) as sumofqty  from kitchen_cancel_detail a 
			left join kitchen_cancel b on a.cancel_id=b.id
			where b.branch_id='".$product_list[$i]["branch_id"]."' and a.product_id='".$product_list[$i]["product_id"]."' ".$cancel_date;	
			$store_cancel_detail_one = $db->query_first($sql);
			$total_cancel=doubleval($store_cancel_detail_one["sumofqty"]);				
			
			
			
			$tonkho=$total_import-$total_export-$total_return-$total_cancel;

			
			
			if ($type==9){
				$sql="select * from kitchen_inventory where kitchen_id='".$product_list[$i]["branch_id"]."' and  product_id='".$product_list[$i]["product_id"]."' order by id desc limit 1";
				$kitchen_inventory_one= $db->query_first($sql);	


				$sql="update kitchen_store set 
					total_import=".$total_import.",
					total_export=".$total_export.",
					total_cancel=".$total_cancel.",
					total_return=".$total_return.",
					total_tonkho=total_dauky+".$tonkho.",
					total_inventory=".$kitchen_inventory_one["qty"].",
					total_cuoiky=".$kitchen_inventory_one["qty"].",
					inventory_date=".time()."
					where branch_id='".$product_list[$i]["branch_id"]."' and  product_id='".$product_list[$i]["product_id"]."' and  inventory_date is null
				";
				$db->query($sql) or die("error: s2");
		
			
				$sql="insert into kitchen_store(
					product_id,
					branch_id,
					total_dauky,
					total_tonkho					
				) values(";
				
				$sql .="
					'".$product_list[$i]["product_id"]."', 
					'".$product_list[$i]["branch_id"]."', 
					".$kitchen_inventory_one["qty"].", 
					".$kitchen_inventory_one["qty"]."
				)";
				$db->query($sql) or die("error: s2");			
			
			}else{

				//giao dich truoc no
				$sql="select * from kitchen_store where branch_id='".$product_list[$i]["branch_id"]."' and  product_id='".$product_list[$i]["product_id"]."' and  inventory_date is null";
				$kitchen_store_one = $db->query_first($sql);		
				if (empty($kitchen_store_one)){
					$sql="insert into kitchen_store(
						product_id,
						branch_id,
						total_import,
						total_export,
						total_cancel,
						total_return,
						total_tonkho					
					) values(";
					
					$sql .="
						'".$product_list[$i]["product_id"]."', 
						'".$product_list[$i]["branch_id"]."', 
						".$total_import.",
						".$total_export.",
						".$total_cancel.",
						".$total_return.",
						".$tonkho."
					)";
					$db->query($sql) or die("error: s2");
				
				}else{
					$sql="update kitchen_store set 
						total_import=".$total_import.",
						total_export=".$total_export.",
						total_cancel=".$total_cancel.",
						total_return=".$total_return.",
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
		
	
	}
	


}