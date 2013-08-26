<?php
include "../include/conn.php";
mysql_query("set names utf8 ");
$teacher_id = $_POST['teacher_id']; 
$sql = "select course_name,course_id FROM `course` WHERE teacher_id = '$teacher_id'";
$result = mysql_query($sql);
/*{ "people": [

{ "firstName": "Brett", "lastName":"McLaughlin", "email": "aaaa" },

{ "firstName": "Jason", "lastName":"Hunter", "email": "bbbb"},

{ "firstName": "Elliotte", "lastName":"Harold", "email": "cccc" }

]}*/
echo "{ \"course\": [";
$len = mysql_num_rows($result);
$i=0;
while($info = mysql_fetch_array($result))
{
	$i++;
	echo "{\"course_id\": \"".$info['course_id']."\",\"course_name\":\"".$info['course_name']."\"}";
	if($i!=$len)
		echo ",";
}
echo "]}";
?>