<?php
	include 'include/conn.php';
	//返回节数
	function jie($j)
	{
		if($j == "1")
			return "1-2节";
		if($j == "2")
			return "3-4节";
		if($j == "3")
			return "5-6节";
		if($j == "4")
			return "7-8节";
		if($j == "5")
			return "9-10节";
	}
	//返回周
	function zhou($z)
	{
		if($z == "1")
			return "周一";
		if($z == "2")
			return "周二";
		if($z == "3")
			return "周三";
		if($z == "4")
			return "周四";
		if($z == "5")
			return "周五";
		if($z == "6")
			return "周六";
		if($z == "7")
			return "周日";
	}
	
	$year = $_POST['year']."_________";
	$course_class = $_POST['course_class'];
	$sql = "SELECT `time_add`,`course_id`,`tips` FROM `teacher_sj_schedule` WHERE time_add like '$year' AND course_class like '%$course_class%'";
	$result = mysql_query($sql);
	while($info = mysql_fetch_array($result))
	{
		$sql_course = "SELECT course_name,teacher_id FROM `course` WHERE course_id = '".$info['course_id']."'";
		$result_course = mysql_query($sql_course);
		$info_course = mysql_fetch_array($result_course);
		echo $info_course['course_name']."@";
		
		$sql_teacher = "SELECT teacher_name FROM `teacher` WHERE teacher_id = '".$info_course['teacher_id']."'";
		$result_teacher = mysql_query($sql_teacher);
		$info_teacher = mysql_fetch_array($result_teacher);
		echo $info_teacher['teacher_name']."@";
		

		$week  = substr($info['time_add'],10,2);
		$j_jie = substr($info['time_add'],12,1);
		$z_zhou = substr($info['time_add'],13,1);
		echo "第".$week."周 ".zhou($z_zhou)." ".jie($j_jie)."@";
		
		$address = substr($info['time_add'],5,2);
		$sql_address = "SELECT * FROM school where school_id = '$address'";
		$result_address = mysql_query($sql_address);
		$info_address = mysql_fetch_array($result_address);
		echo $info_address['school_name'].substr($info['time_add'],7,3)."@";
		
		echo $info['tips']."@";
		
		$sql_file = "select file_name from file where course_id = '".$info['course_id']."'";
		$result_file = mysql_query($sql_file);
		while($info_file = mysql_fetch_array($result_file))
		{
			//$filename = iconv("utf-8","gbk",$info_file['file_name']);
				echo "<a class=\"prime_a\" href=\"downloads/".$info_file['file_name']."\">".$info_file['file_name']."</a>";
		}
		echo "@";

	}
?>