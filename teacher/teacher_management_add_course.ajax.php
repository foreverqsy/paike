<?php
	session_start();
	$teacher_id = $_SESSION['teacher_id'];
	$course_id = $_POST['course_id'];
	$course_name = $_POST['course_name'];
	$course_hour = $_POST['course_hour'];
	
	include '../include/conn.php';
	
	$sql = 'INSERT INTO course VALUES (\''.$course_id.'\',\''.$teacher_id.'\',\''.$course_name.'\',\''.$course_hour.'\')';
	$result = mysql_query($sql);
	if($result)
	{
		echo '1';
	}
	else
	{
		echo '0';	
	}
?>