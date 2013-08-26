<?php
	include "../include/conn.php";
	mysql_query("set names utf8 ");
	
	$sql = "UPDATE `calendar` SET `calendar_year`=".$_POST['calendar_year'].",`calendar_month`=".$_POST['calendar_month'].",`calendar_day`=".$_POST['calendar_day']." WHERE 1";
	//echo $sql;
	
	if(mysql_query($sql))
	{
		echo '1';
	}
	else
		echo '0';
?>