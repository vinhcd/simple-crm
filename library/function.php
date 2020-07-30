<?
function removecomma($str){
	return preg_replace('/[^0-9]+/i', '', $str);
}

function saveFloat($str){
	return floatval(str_replace(',', '.', $str));
}

function removecomma2($str){
	return preg_replace('/[^0-9-.]+/i', '', $str);
}


function qtyFormat($str){
	return str_replace('.', ',', $str);
}

function change_datetime($datetime){	
	$datetime_a=explode(" ",$datetime);
	$datetime_2=explode("/",$datetime_a[0]);
	$datetime_3=explode(":",$datetime_a[1]);	
	$mktime = mktime((int)$datetime_3[0],(int)$datetime_3[1],(int)date("s"),(int)$datetime_2[1],(int)$datetime_2[0],(int)$datetime_2[2]);
	return date("Y-m-d H:i:s", $mktime);
}

function change_date($datetime){	
	$datetime_a=explode(" ",$datetime);
	$datetime_2=explode("/",$datetime_a[0]);
	$mktime = mktime(0,0,(int)date("s"),(int)$datetime_2[1],(int)$datetime_2[0],(int)$datetime_2[2]);
	return date("Y-m-d", $mktime);
}

function number_format_no_round($val){	
	return number_format($val, strlen(end(explode(".", $val))));	
;
}

function cutphanle($val){	
	$pos=strpos((string)$val,".");

	if ($pos!==false)
		return substr($val,0,$pos);
	else
		return $val;
}


function bao_escape($string,$conn) {
	if(get_magic_quotes_runtime()) $string = stripslashes($string);
	return mysqli_real_escape_string($conn, $string);
}#-#escape()

function bao_query_insert($table, $data, $conn) {
	$q="INSERT INTO $table ";
	$v=''; $n='';

	foreach($data as $key=>$val) {
		$n.="`$key`, ";
		if(strtolower($val)=='null') $v.="NULL, ";
		elseif(strtolower($val)=='now()') $v.="NOW(), ";
		else $v.= "'".bao_escape($val,$conn)."', ";
	}

	$q .= "(". rtrim($n, ', ') .") VALUES (". rtrim($v, ', ') .");";

	return $q;

}#-#query_insert()


function bao_query_update($table, $data, $conn, $where='1') {
	$q="UPDATE $table SET ";

	foreach($data as $key=>$val) {
		if(strtolower($val)=='null') $q.= "`$key` = NULL, ";
		elseif(strtolower($val)=='now()') $q.= "`$key` = NOW(), ";
		else $q.= "`$key`='".bao_escape($val,$conn)."', ";
	}

	$q = rtrim($q, ', ') . ' WHERE '.$where.';';

	return $q;
}#-#query_update()

?>