<?php
	session_start();
	$teacher_id = $_SESSION['teacher_id'];
	$old_password = md5($_POST['old_password']);
	$new_password = md5($_POST['new_password']);
	
	include '../include/conn.php';
	
	$sql = 'SELECT * FROM teacher WHERE teacher_id = \''.$teacher_id.'\' AND teacher_psw = \''.$old_password.'\'';
	
	$result = mysql_query($sql);
	if($result)
	{
		$info = mysql_fetch_array($result);
		if($info)
		{
			$sql = 'UPDATE teacher SET teacher_psw = \''.$new_password.'\' WHERE teacher_id = \''.$teacher_id.'\'';
			$update_result = mysql_query($sql);
			if($update_result)
			{
				echo '2';	//RIGHT PASSWORD & MOD
			}
			else
			{
				echo '3';	//RIGHT PASSWORD & UNMOD	
			}
		}
		else
		{
			echo '1';	//WRONG PASSWORD
		}
	}
	else
	{
		echo '0';	//数据库访问出错	
	}
?>