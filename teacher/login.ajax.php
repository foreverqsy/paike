<?php
	session_start();
	include "../include/conn.php";
	mysql_query("set names utf8 ");
	$sql = "SELECT * FROM teacher WHERE teacher_id = '$_POST[teacher_id]'";
	$rezult=mysql_query($sql);
	if($rezult)
	{
		$info=mysql_fetch_array($rezult);
		if($info)
		{
			$psw=MD5($_POST['teacher_psw']);
			if($info['teacher_psw']==$psw)
			{
				$_SESSION['teacher_id']=$info['teacher_id'];
				$_SESSION['teacher_name'] = $info['teacher_name'];
				$_SESSION['limits'] = $info['limits'];
				//mysql_free_result($rezult);
				if($info['limits']=='1')
					echo '1';
				else if($info['limits']=='0')
					echo '2';
				else
					echo '0';
			}
			else
				echo '0';
		}
		else
			echo '0';
	}
	else
		echo '0';
?>