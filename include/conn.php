<?php
$conn =  mysql_connect("localhost","root","000000") or die("数据库链接错误");
mysql_select_db("paike", $conn) or die("数据库选择错误");
mysql_query("set names utf8 "); 

$sql_ini = "SELECT * FROM `ini_year_term` WHERE 1";
$result_ini = mysql_query($sql_ini);
$db_year="";
while($info_ini = mysql_fetch_array($result_ini))
	$db_year = $info_ini['year_term'];//设置年
$default_password = md5('000000');

//服务器时间
$var_serversTime=getdate();
$servers_time = $var_serversTime['mon'].'@'.$var_serversTime['mday']
?>
