<?php
	$teacher_id = $_POST['teacher_id'];
	$teacher_name = $_POST['teacher_name'];
	$teacher_school = $_POST['teacher_school'];
	include '../include/conn.php';
	$sql = 'UPDATE teacher SET teacher_school = \''.$teacher_school.'\' , teacher_name = \''.$teacher_name.'\' WHERE teacher_id = \''.$teacher_id.'\'';
	$result = mysql_query($sql);
	if($result)
	{
		$row = mysql_affected_rows();
//		echo $row;
		if($row)
		{
			echo '2';	//已更新
		}
		else
		{
			echo '1';	//同以前相同
		}
	}
	else
	{
		echo '0';	//出错
	}
?>