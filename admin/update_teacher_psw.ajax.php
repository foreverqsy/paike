<?php
	$teacher_id = $_POST['teacher_id'];
	include '../include/conn.php';
	$sql = "UPDATE teacher SET teacher_psw = '".$default_password."' WHERE teacher_id = '".$teacher_id."'";
	//echo $sql;
	$result = mysql_query($sql);
	if($result)
	{
		echo '1';	//RIGHT PASSWORD & MOD
	}
	else
	{
		echo '0';	//RIGHT PASSWORD & UNMOD	
	}
?>