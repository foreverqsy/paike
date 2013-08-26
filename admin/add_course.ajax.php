<?php
	include '../include/conn.php';
	$teacher_id = $_POST['teacher_id'];
	$course_id = $_POST['course_id'];
	$course_name = $_POST['course_name'];
	$course_hour = $_POST['course_hour'];

	$sql = 'INSERT INTO course VALUES (\''.$course_id.'\',\''.$teacher_id.'\',\''.$course_name.'\',\''.$course_hour.'\')';
	 mysql_query($sql);
	if(mysql_affected_rows())
	{
		echo '1';
	}
	else
	{
		echo '0';	
	}
?>