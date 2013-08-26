<?php
include "../include/conn.php";
mysql_query("set names utf8 ");
$time_add = $_POST['time_add']; 
$time_add = $time_add.'____';
$sql = "DELETE FROM `teacher_sj_schedule` WHERE time_add like '$time_add'";
//echo $sql;
mysql_query($sql);
//echo mysql_affected_rows()."<br>";
if(mysql_affected_rows())
{
	echo '1';
}
else
	echo '0';

?>