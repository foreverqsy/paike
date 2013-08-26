<?php
set_time_limit(0);
include "../include/conn.php";
mysql_query("set names utf8 ");
$id =  $_POST['year_term_school_address'];

$year_term = $_POST['year_term'];
$address = $_POST['address'];
$school = $_POST['school'];
$school_id = $_POST['school_id'];
$sql1 = "INSERT INTO `ini_year_term` (`year_term`) VALUES('$year_term')";
mysql_query($sql1);
$sql2 = "INSERT INTO `ini_school`(`school`,school_id) VALUES ('$school','$school_id')";
mysql_query($sql2);
$sql3 = "INSERT INTO `ini_address`(`address`) VALUES ('$address')";
mysql_query($sql3);
$sql = "";
for($i = 1;$i<=20;$i++)
{
	for($j = 1;$j<=5;$j++)
	{
		for($k = 1;$k<=7;$k++)
		{
			if($i<=9)
				$add_time = $id.'0'.$i.$j.$k;
			else
				$add_time = $id.$i.$j.$k;
			$sql=$sql."(".$add_time."),";
		}
	}
}

$sql = substr($sql,0,-1);
$sql = "INSERT INTO `teacher_sj_schedule`(`time_add`) VALUES".$sql;
mysql_query($sql);
if(mysql_affected_rows()==-1)
{
	echo '0';
}
else 
	echo '1';
?>