<?php
include "../include/conn.php";
$user=$_POST['admin_user'];
$psw=$_POST['admin_psw'];

$sql="select *from admin where admin_user='$user'";

$result=mysql_query($sql);

if ($result)
{
	$info = mysql_fetch_array ($result);
	if ($info)
	{
		if($info['admin_psw']==md5($psw))
		{
			echo '1';
		}
		else
			echo '0';
	}
	else
		'0';
}
else
	echo '0';
?>