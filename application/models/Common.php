<?php

class Common
{


	function isThisDayAWeekend($date) {
	
		$timestamp = strtotime($date);
	
		$weekday= date("l", $timestamp );
	
		if ($weekday =="Saturday" OR $weekday =="Sunday") { return true; } 
		else {return false; }
	
	}
	
	
	
	
	

}