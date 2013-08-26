<?php
include "../include/conn.php";
mysql_query("set names utf8 ");
$sql = "UPDATE `teacher_sj_schedule` SET `course_id`='00000000',`course_class`='',`lock`='1',tips='' WHERE time_add = '$_POST[time_add]'";
mysql_query($sql);
if(mysql_affected_rows())
{
	echo '1';
}
else
	echo '0';

?>