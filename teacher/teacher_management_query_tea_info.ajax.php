<?php
	session_start();
	$teacher_id = $_SESSION['teacher_id'];
	
	include '../include/conn.php';
	
	$sql = 'SELECT teacher_name,teacher_school FROM teacher WHERE teacher_id = \''.$teacher_id.'\'';
	
	$result = mysql_query($sql);
	
	if($result)
	{
		$info = mysql_fetch_array($result);
		echo $info['teacher_name'].'@'.$info['teacher_school'];	
	}
	else
	{
		echo '0';	//数据库访问出错
	}
?>