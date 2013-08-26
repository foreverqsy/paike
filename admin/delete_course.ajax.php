<?php
	$course_id = $_POST['course_id'];
	include '../include/conn.php';
	$sql = 'DELETE FROM course WHERE course_id = '.$course_id;
	
	$sql_sj = "UPDATE `teacher_sj_schedule` SET `course_id`='00000000',`course_class`='',`lock`='1',`tips`='' WHERE course_id=".$course_id;
	mysql_query($sql);
	if(mysql_affected_rows())
	{
		mysql_query($sql_sj);
		echo '1';	
	}
	else
	{
		echo '0';	
	}
?>