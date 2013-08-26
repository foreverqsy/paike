<?php 
session_start();
if(!isset($_SESSION['teacher_id']))
	header("location:../teacher/index.php");
else
	if($_SESSION['limits'] ==0)
		header("location:../admin/index.php");
		
include "../include/conn.php";

$teacher_id = $_SESSION['teacher_id'];
$sql_teacher = "SELECT teacher_name FROM teacher WHERE teacher_id = '$teacher_id'";
$result_teacher = mysql_query($sql_teacher); 
$info_teacher=mysql_fetch_array($result_teacher);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../include/css/global.css" type="text/css" rel="stylesheet"/>
<title>教师排课</title>
<style>
td{
width:200px;
height:50px;
border:1px solid #000000;
}
</style>
<script language="javascript" type="text/javascript" src="../include/js/Jquery.js">
</script>
</head>
<body class="body_pos">
    <div id="contest">
          <div class="header">
    		<div class="header_text">
            	<ul>
            		<li><a href="../index.php" class="header_first">首页</a></li>
                    <li><a href="schedule.php" class="header_first">机房课程表</a></li>
                    <li><a href="../class_shedule.php" class="header_first">班级课程表</a></li>
                	<li><a href="teacher_index.php" class="header_first">个人中心</a></li>
                    <li><a class="header_first" onclick="zhuxiao()">注销</a></li>
                    <li><a style="margin-left:120px; font-size:14px; width:90px;" href="http://portal.sut.edu.cn/dcp/forward.action?path=/portal/portal&p=HomePage" class="header_first" target="_blank">数字工大</a></li>
                    <li><a style="font-size:14px; width:90px;" href="http://www.sut.edu.cn" class="header_first" target="_blank">工大官网</a></li>
    			</ul>
           	 </div>
            </div>
            <div class="triangle1"></div>
   			 <div class="triangle2"></div>
    			<center>
    
            <!--
            <a href="../index.php" class="prime_a" style="font-size:18px">首页&nbsp;&nbsp;&nbsp;&nbsp;</a>沈阳工业大学  机房排课系统&nbsp;&nbsp;&nbsp;&nbsp;欢迎您<a href="teacher_index.php" class="prime_a" style="font-size:19px;"><?php/* echo "   ".$info_teacher['teacher_name']."   ";*/?></a>老师!
            &nbsp;&nbsp;&nbsp;&nbsp;<a onclick="zhuxiao()" class="prime_a" style="font-size:18px;">注销</a>
            -->
                    <form name="form0">
                    
                    <!-- 存储url传值 -->
                    <?php
                    if(!isset($_GET['time']))
                        $url_time = "";
                    else
                        $url_time = $_GET['time'];
                    ?>
                    <input type="text" name="url_time" value="<?php echo $url_time?>" style="display:none">
                    <input type="text" name="year"  style="display:none;" value="<?php echo $db_year;?>" class="input_text"/>
                    <input type="text" name="servers_time" style="display:none;" value="<?php echo $servers_time?>">
                    <!-- 存储日历 -->
                    <?php
                        $sql_calendar = "select * from calendar where 1";
                        $result_calendar = mysql_query($sql_calendar);
                        $info_calendar = mysql_fetch_array($result_calendar);
                    ?>
                    <input type="text" name="year_rili"  id="year_rili" style="display:none;" value="<?php echo $info_calendar['calendar_year'];?>"/>
                    <input type="text" name="month_rili"  id="month_rili" style="display:none;" value="<?php echo $info_calendar['calendar_month'];?>"/>
                    <input type="text" name="day_rili"  id="day_rili" style="display:none;" value="<?php echo $info_calendar['calendar_day'];?>"/>
                    
                    第<select id="week_select" onchange="change_week()">
                        <option value="01" selected>1</option>
                        <?php 
                        for($i=2;$i<=9;$i++)
                            echo  "<option value=\"".'0'.$i."\">$i</option>";
                        for($i=10;$i<=20;$i++)
                            echo  "<option value=\"$i\">$i</option>";
                        ?>
                      
                        
                    </select>周&nbsp;&nbsp;&nbsp;&nbsp;
                    学院:<select name="h_school" id="h_school" onchange="change()">
                    <?php
                    $sql_school = "SELECT * FROM `ini_school` WHERE 1";
                    $result_school = mysql_query($sql_school);
                    while($info_school = mysql_fetch_array($result_school))
                    {
                        echo "<option value = \"".$info_school['school_id']."\">".$info_school['school']."</option>";
                    }
                    ?>
                    </select>
                    &nbsp;&nbsp;&nbsp;&nbsp;机房：
                    <select id="address" onchange="change_address()">
                    <?php
                    $sql_address = "SELECT * FROM `ini_address` WHERE 1";
                    $result_address = mysql_query($sql_address);
                    while($info_address = mysql_fetch_array($result_address))
                    {
                        echo "<option value = \"".$info_address['address']."\">".$info_address['address']."</option>";
                    }
                    ?>
                    </select>
                    <p>
                    <table width="87%;"; id="s_week"; height="550px;"; style="font-size:10px;";>
                    <tr align="center" height="50px;">
                        <td></td>
                        <td>星期一</td>
                        <td>星期二</td>
                        <td>星期三</td>
                        <td>星期四</td>
                        <td>星期五</td>
                        <td>星期六</td>
                        <td>星期日</td>
                      </tr>
                      <?php
                      //生成空表格
                     $i = 1;
                     $j = 2;
                     for($row=1;$row<=5;$row++)
                     {
                            echo "<tr height=\"100px;\">";
                            echo "<td align=\"center\">".$i."-".$j."节</td>";
                            $i+=2;
                            $j+=2;
                            for($cell=1;$cell<=7;$cell++)
                            {
                                echo "<td></td>";		
                            }
                            echo "</tr>";
                     }
                    ?>
                     </table>
                     </form>
                    </center>
            
            <!-- div层[排一个课]-->
                    <div id="up"; style="display:none; width:400px; height:400px;">
                    <form action="" name="form" style="margin-left:30px; margin-top:50px;">
                        <p>
                        <a onclick="putongke()" class="prime_a">普通课</a>&nbsp;|&nbsp;<a onclick="renxuanke()" class="prime_a">任选课</a>
                        <input  type="text" style="display:none" name="time" /> <!-- 存放时间地址字段-->
                        <p>
                        <div id="putong">
                       学院:&nbsp;&nbsp;
                       <select name="school" id="school" onChange="change_school(document.form.school.options[document.form.school.selectedIndex].value)">
                            <option value="" selected="selected">==请选择学院==</option>
                        </select>
                        <p>专业:&nbsp;&nbsp;
                        <select name="major"  id="major" onChange="change_major(document.form.major.options[document.form.major.selectedIndex].value)">
                          <option value=""selected="selected">==请选择专业==</option>
                        </select>
                        <p>年级:&nbsp;&nbsp;
                        <select name="grade"  id="grade" onchange="change_grade(document.form.grade.options[document.form.grade.selectedIndex].value)">
                          <option value="" selected="selected">==请选择年级==</option>
                        </select>
                        <p>班级:&nbsp;&nbsp;
                        <select name="w_class" id="w_class">
                          <option value="" selected="selected">==请选择班级==</option>
                        </select>
                        <p>课程:&nbsp;&nbsp;
                        <select name="course" id="course">
                        <option value="" selected="selected">==请选择课程==</option>
                        <?php
                        //动态生成老师对应课课程
                        $sql = "select * from course where teacher_id = '".$_SESSION['teacher_id']."'";
                        $result1 = mysql_query($sql);
                        while($info1 = mysql_fetch_array($result1))
                        {
                            if($info1[2]!="点此排课")
                            echo "<option value=$info1[0]>$info1[2]</option>";
                        } 
                        ?>
                        </select>
                        <p>
                        备注:&nbsp;&nbsp;<input type="text" name="tips"/>
                        <p>
                        <input  name="add" type="button" value="添加" onclick="resure()" class="button" />&nbsp;&nbsp;&nbsp;&nbsp;
                        <input  name="over" type="button" value="返回" onclick="cancel()"  class="button"/>
                    </form>
            
            
            </div>
    </div>
      <div id="mask"></div>
</body>
<script>
if((screen.width <= 1024) && (screen.height <= 768))
{
	//alert("哈哈");
	document.getElementById("contest").style.left="0";
}
var time_array = new Array();
//设置下拉列表默认值函数
function select_ini(select_name,select_value)
{
	var s = document.getElementById(select_name);  
    var ops = s.options;  
    for(var i=0;i<ops.length; i++)
	{  
        var tempValue = ops[i].value;  
        if(tempValue == select_value)  
        {  
            ops[i].selected = true;  
        }  
    }  
}
//页面加载完成后执行change()填表格操作
$(document).ready(function() 
{
	//设置默认值为信息学院
	select_ini("h_school","04");
	var url_time = document.form0.url_time.value;
	if(url_time.length=="12")
	{
		select_ini("week_select",url_time.substr(10,2))
		select_ini("h_school",url_time.substr(5,2));
		select_ini("address",url_time.substr(7,3));
		chuancan(url_time);
	}
	else
		change() 
});

function rili(year,month,day)
{
	flag = 0;
	flag_year = 0;
	if((year%4==0 && year%100!=0) || year%400==0)
	{
		flag = 1;
	}
	else
		flag = 0;
	for(i=1;i<=20;i++)
	{
		time_array[i] = new Array();
		for(j = 1;j<=7;j++)
		{	
			if(month==13)
			{
				month=1;
				flag_year = 1;
			}
			time_array[i][j] = month+"月"+day+"日";
			if((month==1 || month==3 ||month==5 ||month==7 ||month==8 ||month==10 ||month==12) && day==31)
			{
				day=1;
				month++;
			}
			else if(day==28 && month==2 && flag == 0)
			{
				day=1;
				month++;
			}
			else if(day==29 && month==2 && flag == 1)
			{
				day=1;
				month++;
			}
			else if((month==4 ||month==6 ||month==9 ||month==11) &&day==30)
			{
				day=1;
				month++;
			}
			else
				day++;
		}
	}
	return flag_year;
}
//机房下拉列表改变时调用函数
function change_address()
{
	change();
}
//第几周下拉列表改变时调用函数
function change_week()
{
	change();
}
//获取当前表单数据
function change()
{
	
	var year = document.form0.year.value;//获取年份
	var h_school = document.getElementById("h_school");
	h_school = h_school.options[h_school.selectedIndex].value;//获取学院
	var address = document.getElementById("address");//获取机房号
	address = address.options[address.selectedIndex].value;
	//alert(address);
	var temp = document.getElementById("week_select");//获取周次
	week= temp.options[temp.selectedIndex].value;
	time = year+''+h_school+''+address+''+week;
	//alert(time);
	
	//调用动态填写表格函数
	chuancan(time);
//	$('#up').fadeOut(500);
}
function rili_table()
{
	var table_temp = document.getElementById("s_week");//表格 
	var temp = document.getElementById("week_select");//获取周次
	var week_rili = temp.options[temp.selectedIndex].text;
	//alert(time);
	var year_rili = document.form0.year_rili.value;//年份
	var month_rili = document.form0.month_rili.value;//月
	var day_rili  = document.form0.day_rili.value;//日
	var flag_year = rili(year_rili,month_rili,day_rili);

	table_temp.rows[0].cells[1].innerHTML = "星期一 ["+time_array[week_rili][1]+"]";
	table_temp.rows[0].cells[2].innerHTML = "星期二 ["+time_array[week_rili][2]+"]";
	table_temp.rows[0].cells[3].innerHTML = "星期三 ["+time_array[week_rili][3]+"]";
	table_temp.rows[0].cells[4].innerHTML = "星期四 ["+time_array[week_rili][4]+"]";
	table_temp.rows[0].cells[5].innerHTML = "星期五 ["+time_array[week_rili][5]+"]";
	table_temp.rows[0].cells[6].innerHTML = "星期六 ["+time_array[week_rili][6]+"]";
	table_temp.rows[0].cells[7].innerHTML = "星期日 ["+time_array[week_rili][7]+"]";
}
function time_limit(xingqi)
{	
	var t = document.getElementById("week_select");//获取周次
	var zhou = t.options[t.selectedIndex].text;
	var servers_time = document.form0.servers_time.value.split("@");
	var local_time=time_array[zhou][xingqi];

	local_time=local_time.replace("月","日");
	local_time=local_time.split("日");
	var local_mon=parseInt(local_time[0]);
	var servers_mon=parseInt(servers_time[0]);
	var local_day=parseInt(local_time[1]);
	var servers_day=parseInt(servers_time[1]);
	if(servers_mon<local_mon)
	{
		//alert(servers_mon+"<"+local_mon);
		return 1;
	}
	else if(servers_mon==local_mon && servers_day<=local_day)
	{
		return 1;
	}
	else
	{	return 0;}
}
</script>

<script>
//动态填写表格函数,参数为字段前12位
function chuancan(selected)
{
	rili_table();//调用日历设置函数
	//selected为前12位，即没有节次和第几周
	//JQ的ajax返回id为selected的数据
	$.ajax({
   		type: "POST",
  		url: "change_table.ajax.php",
  	 	data: "time_add="+selected,
   		success: function(msg)
		{
			var temp = document.getElementById("s_week");
			var change,cnt=0;
			change=msg.split("@");//分割返回数据
			//alert(msg);
			if(msg  == '')
			{
				for(i=1;i<=5;i++)
					for(j=1;j<=7;j++)
						temp.rows[i].cells[j].innerHTML="";
			}
			else
			{
				for(i=1;i<=5;i++)
				{
					for(j=1;j<=7;j++)
					{
					
						lock = change[cnt].substr(0,1);
						change[cnt] = change[cnt].substr(1);
						tips = change[cnt].split("备注:");
						//alert(lock);
						if(lock=='2')
						{
							
							if(change[cnt].indexOf("删除")!=-1)
							{
								tt = change[cnt].replace("删除","");
								temp.rows[i].cells[j].innerHTML=tt+"<div class=\"course_text\"><a style = \"color:red;\" onclick=\"deleted("+selected+","+i+","+j+")\" class=\"prime_a\">删除</a></div>";
							}
							else 
								temp.rows[i].cells[j].innerHTML=change[cnt];
						}
						else if(lock=='0')
						{
							temp.rows[i].cells[j].innerHTML="<div class=\"course_text\">管理员已加锁<p>备注:"+tips[1]+"</div>";
						}
						else
						{
							var temp = document.getElementById("s_week");
							temp.rows[i].cells[j].innerHTML="<div class=\"course_text\"><a onclick=\"paike("+selected+","+i+","+j+")\" class=\"prime_a\">点此排课</a></div>";
						}
						cnt++;
					}
				}
			}
   		}
	   }); 
}
//获取点击坐标 显示div隐藏排课层
function paike(time,row,cell)
{
	if(time_limit(cell)==0)
	{
		alert("日期已过，不允许排课");
	}
	else
	{
		document.form.add.value="添加"
		var temp = document.getElementById("s_week");
		time_add = time+''+row+''+cell;
		document.form.time.value = time_add;//给存储时间地址ID赋值
		//alert(time_add);
		
			$('#mask').css({'zIndex':'5'});
			$('#mask').animate({'opacity':'0.5'},200);
		
		$('#up').fadeIn(200);
	}
}

//删除排课
function deleted(time,row,cell)
{
	
	if(time_limit(cell)==0)
	{
		alert("对不起,日期已过,不允许删除");
	}
	else
	{
		time_add = time+''+row+''+cell;
		var conf = confirm("是否删除此排课");
		if(conf)
		{
			$.ajax({
			type: "POST",
			url: "delete_course_schedule.ajax.php",
			data: "time_add="+time_add,
			success: function(msg)
			{
				//alert(msg);
				if(msg=='1')
				{
					
	//				$('#up').fadeOut(100);
					chuancan(time_add.substr(0,12));
					
				}
				else
				{
					alert("删除失败");
	//				$('#up').fadeOut(100);
					chuancan(time_add.substr(0,12));
				}
			}
		   }); 
		}
	}
}
//普通课
var renxuanke_or_putongke=1;
function putongke()
{
	renxuanke_or_putongke=1;
	select_ini("school","04");//设置学院默认值为信息学院
	document.form.school.disabled="";
	document.form.major.disabled="";
	document.form.grade.disabled="";
	document.form.w_class.disabled="";
}
//任选课
function renxuanke()
{
	renxuanke_or_putongke=0;
	select_ini("school","");//设置学院默认值为空即｛==请选择学院==｝
	select_ini("major","");
	select_ini("grade","");
	select_ini("w_class",""); 
	//禁用部分下拉列表
	document.form.school.disabled="false";
	document.form.major.disabled="false";
	document.form.grade.disabled="false";
	document.form.w_class.disabled="false";
}
//确定按钮 用来加一门课
function resure()
{

	var address = document.getElementById("address");//获取机房号
	address = address.options[address.selectedIndex].value;
	
	var grade_id = document.form.grade.options[document.form.grade.selectedIndex].value;
	var school_id = document.form.school.options[document.form.school.selectedIndex].value;
	var major_id = document.form.major.options[document.form.major.selectedIndex].value;
	var class_id = document.form.w_class.options[document.form.w_class.selectedIndex].value;
	var student_id = grade_id+''+school_id+''+major_id+''+class_id;
	
	var course_id = document.form.course.options[document.form.course.selectedIndex].value;
	tips = document.form.tips.value;
	time_add = document.form.time.value;
	
	//alert(time_add);

	if(school_id=="" && renxuanke_or_putongke)
	{
		alert("您需要选择学院");
	}
	else if(major_id=="" && renxuanke_or_putongke)
	{
		alert("您需要选择专业");
	}
	else if(grade_id=="" && renxuanke_or_putongke)
	{
		alert("您需要选择年级");
	}
	else if(class_id=="" && renxuanke_or_putongke)
	{
		alert("您需要选择班级");
	}
	else if(course_id=="")
	{
		alert("您需要选择课程");
	}
	else
	{	
/****************************
*****************************/
	//通过ajax给数据库添加一个课程安排
	$.ajax({
   		type: "POST",
  		url: "add_course_schedule.ajax.php",
  	 	data: "time_add="+time_add+"&course_id="+course_id+"&student_id="+student_id+"&tips="+tips,
   		success: function(msg)
		{
			//alert(msg);
			if(msg=='1')
			{
				alert("添加成功");
				document.form.add.value="继续添加"
				chuancan(time_add.substr(0,12));
				
			}
			else if(msg=='2')
			{
				alert("系统检测到该班在机房有课,添加失败");
				$('#mask').animate({'opacity':'0'},function(){$('#mask').css({'zIndex':'-5'});});
				$('#up').fadeOut(100);
				chuancan(time_add.substr(0,12));
			}
			else
			{
				alert("添加失败");
				$('#mask').animate({'opacity':'0'},function(){$('#mask').css({'zIndex':'-5'});});
				$('#up').fadeOut(100);
				chuancan(time_add.substr(0,12));
			}
   		}
	   }); 
	//alert(student_id+''+time_add+course_id);
	}
}
//取消按钮，返回并更新页面
function cancel()
{
	$('#mask').animate({'opacity':'0'},function(){$('#mask').css({'zIndex':'-5'});});
	$('#up').fadeOut(500);
	time_add = document.form.time.value;
	chuancan(time_add.substr(0,12));
}
function zhuxiao()
{
	x = "000";
	$.ajax({
   		type: "POST",
  		url: "logout.ajax.php",
		data:"x="+x,
   		success: function(msg)
		{
			window.top.location.href = "../index.php";
   		}
	   }); 
}
</script>
<script language="javascript" type="text/javascript" charset="utf-8" src="../include/js/school_major_class.js">
</script>
</html>
