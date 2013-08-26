<?php
include "../include/conn.php";
mysql_query("set names utf8 ");
$course_id=$_POST['course_id'];
$time_add = $_POST['time_add'];
$course_class = $_POST['student_id'];
$tips = $_POST['tips'];

$sql1="UPDATE teacher_sj_schedule SET course_id = '$course_id',course_class='$course_class',`lock`='0',tips='$tips' WHERE time_add = '$time_add' AND `lock`='1'";
mysql_query($sql1);
$row = mysql_affected_rows();
		//echo $sql1."fanyiwei".$row;
if($row)
{
	echo '1';
}
else
	echo '0';
?>