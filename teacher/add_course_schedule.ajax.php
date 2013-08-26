<?php
	include "../include/conn.php";
	mysql_query("set names utf8 ");
	$course_id=$_POST['course_id'];
	$time_add = $_POST['time_add'];
	$course_class = $_POST['student_id'];
	$tips = $_POST['tips'];
	//处理任选课情况
	if($course_class!="")
	{
		//截取字符串，处理不同地点同一班级有课情况
		$year = substr($time_add,0,5);
		$week_time = substr($time_add,10,4);
		$time_add2 = $year.'_____'.$week_time;
	
		//$sql = "SELECT * FROM `teacher_sj_schedule` WHERE time_add like '20131_____0111' AND course_class like '%".$course_class."%'";
		$sql = "SELECT * FROM `teacher_sj_schedule` WHERE time_add like '$time_add2' AND course_class like '%".$course_class."%'";
		$result = mysql_query($sql);
		if($result)
		{
			$info = mysql_fetch_array($result);
			if($info)
			{
				echo  '2';
			}
			else	
			{
				$sql1="UPDATE teacher_sj_schedule SET `course_id` = '$course_id',`course_class`=concat(`course_class`,'$course_class@'),`lock`='2',tips='$tips' WHERE `time_add` = '$time_add' AND (`lock`=1 or `course_id`='$course_id')";
				mysql_query($sql1);
				$row = mysql_affected_rows();
				//echo $sql1."fanyiwei".$row;
				if($row)
				{
					echo '1';
				}
				else
					echo '0';
			}
		}
		else
			echo 0;
			
	}
	//如果是任选课
	else
	{
		$sql1="UPDATE teacher_sj_schedule SET course_id = '$course_id',`lock`='2',tips='$tips' WHERE time_add = '$time_add' AND (`lock`=1 or `course_id`='$course_id')";
		mysql_query($sql1);
		$row = mysql_affected_rows();
				//echo $sql1."fanyiwei".$row;
		if($row)
		{
			echo '1';
		}
		else
			echo '0';
	}
?>