<?php
	$course_id = $_POST['course_id'];
	$course_name = $_POST['course_name'];
	include '../include/conn.php';
	$sql = 'UPDATE course SET course_name = \''.$course_name.'\' WHERE course_id = \''.$course_id.'\'';
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