<?php
	session_start();
	include "include/conn.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" id="html">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
<script src="include/js/Jquery.js">
</script>
<link href="include/css/global.css" type="text/css" rel="stylesheet"/>
<title>沈工大 - 排课系统</title>
</head>

<body class="body_pos">
<div id="contest">
    
<!-- div层[排一个课]-->
	<div class="header">
    	<div class="header_text">
            	<ul>
            		<li><a href="index.php" class="header_first">首页</a></li>
                    <li><a href="query.php" class="header_first">机房课程表</a></li>
         			<li><a href="class_shedule.php" class="header_first">班级课程表</a></li>
					<?php
					if(isset($_SESSION['teacher_id']))
					{
						$select_flag=0;
						echo "
							<li><a href=teacher/teacher_index.php class=header_first>个人中心</a> </li>
                    		<li><a class=header_first onclick=zhuxiao()>注销</a></li>";
					}
                    else
					{
						$select_flag=1;
						echo "
							 <li><a href = teacher/index.php class=header_first>教师登录</li></a>";
					}
					?>
                   <li><a style="margin-left:60px;font-size:14px; width:120px;" class="header_first">
                        <ul class="some_select"style= left:<?php echo $select_flag==0?"640px":"520px;"; ?>>
                            <li onclick="course_select()">按课程查询</li>
                            <li onclick="address_select()">按机房查询</li>
                            <li onclick="student_num_select()">按学号查询</li>
                            <li onclick="week_select()">按周次查询</li>
                            <li onclick="teacher_num_select()">按教师号查询</li>
                        </ul>
                    
                    更多查询</a>
                    </li>
                    <li><a style=" font-size:14px; width:90px;"href="http://portal.sut.edu.cn/dcp/forward.action?path=/portal/portal&p=HomePage" class="header_first" target="_blank">数字工大</a></li>
                    
    			</ul>
         </div>
    </div>
    <div class="triangle1"></div>
    <div class="triangle2"></div>

<!--<a href = "teacher/index.php" class="a" style="width:300px; display:inline">教师登录</a>
<a href = "query.php" class="a" style="width:300px;  display:inline">机房课程表</a>
-->

<center>
<br/>
<form  name="form">
 <input type="text" name="year"  id="year" style="display:none;" value="<?php echo $db_year;?>"/>
  <!--隐藏表单，1：course;2:address;3:student_num;4:week;5:teacher_num;6:teaacher_name-->
  <input type="text" style="display:none" name="select_id" />
   学院:
   <select name="school" id="school" onChange="change_school(document.form.school.options[document.form.school.selectedIndex].value)">
        <option value="" selected="selected">==请选择学院==</option>
    </select>
   专业:
	<select name="major"  id="major" onChange="change_major(document.form.major.options[document.form.major.selectedIndex].value)">
	  <option value=""selected="selected">==请选择专业==</option>
    </select>
   年级:
    <select name="grade"  id="grade" onchange="change_grade(document.form.grade.options[document.form.grade.selectedIndex].value)">
      <option value="" selected="selected">==请选择年级==</option>
    </select>
   班级:
	<select name="w_class" id="w_class">
      <option value="" selected="selected">==请选择班级==</option>
    </select>
    <input type="button" value="查询" onclick="Inquiry()" class="button"/>
    <input type="button" value="按教师查询" onclick="up_Inquiry()" class="button"/>


    <p>
    <p>
    <center>
    <div id="mask">
	</div>
    <div id="up"; style="display:none; width:400px; height:250px;">
        <br /><br />
        <font id="select_any">请输入教师名：&nbsp;&nbsp;</font>
        <input  name="teacher_name" id="teacher_name" type="text" class="input_text" onkeydown="if(event.keyCode == 13) teacher_Inquiry()"/>
        <br />
        <br />
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" value="确定" onclick="teacher_Inquiry()"  class="button"/>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" value="返回" onclick="teacher_Cancel()"  class="button"/>
         <br />
        <br />
    </div>
    </center>
</form>
    <br />
    <div id="result_query">
    </div>
</center>
</div>

<div class="back-to" id="toolBackTo">
    <a class="backtotop">
    <img src="image/back-tip.png"/>	
    </a>
</div>

<div class="footer"></div>
</body>
<script src="include/js/school_major_class.js">
</script>
<script>
function zhuxiao()
{
	x = "000";
	$.ajax({
   		type: "POST",
  		url: "teacher/logout.ajax.php",
		data:"x="+x,
   		success: function(msg)
		{
			window.top.location.href = "index.php";
   		}
	   }); 
}
var year = document.getElementById("year").value;
function teacher_Inquiry()
{
	select_some = document.form.teacher_name.value;
	select_id = document.form.select_id.value;
	
	$.ajax({
		type:"POST",
		url:"take_data_teacher.ajax.php",
		data:"select_any="+select_some+"&year="+year+"&select_id="+select_id,
		success: function(msg)
		{
			document.getElementById("contest").style.height="auto";
			document.getElementById("result_query").style.display="inline";
			document.getElementById("result_query").innerHTML = msg;
		}
		});
	teacher_Cancel();
}
function teacher_Cancel()
{
	$('#mask').animate({'opacity':'0'},function(){$('#mask').css({'zIndex':'-5'});});
	$('#up').fadeOut(200);
}

function Inquiry()
{
	var grade_id = document.form.grade.options[document.form.grade.selectedIndex].value;
	var school_id = document.form.school.options[document.form.school.selectedIndex].value;
	var major_id = document.form.major.options[document.form.major.selectedIndex].value;
	var class_id = document.form.w_class.options[document.form.w_class.selectedIndex].value;
	var course_class = grade_id+''+school_id+''+major_id+''+class_id;
	
	//alert(course_class);
	$.ajax({
		type: "POST",
  		url: "take_data.ajax.php",
  	 	data: "year="+year+"&course_class="+course_class,
   		success: function(msg)
		{
			document.getElementById("contest").style.height="auto";
			document.getElementById("result_query").style.display="inline";
			document.getElementById("result_query").innerHTML = msg;
			 /*table_temp = document.getElementById("t_table");
			 var table_rows = table_temp.rows.length;
			
			 for(x = table_rows-1;x >0;x--)
			 {
				table_temp.deleteRow(x);	
			 }
			
			 if(msg == "")
			 {
				 trr = table_temp.insertRow(1);
				 trr.innerHTML = "暂无课程信息";
			 }
			 else
			 {
				cnt=0;
				x=0;
				var data = msg.split("@");
				var len = data.length-1;
				//alert(len);
				cnt = len;
				len = len-1;
				//alert(msg);
				
    		 	for(var i = 1;i<=cnt/6;i++)
    		 	{
      		 		var trr = table_temp.insertRow(1);
      		  		for(var j=0;j<6;j++)
      				{
       					var tdd = trr.insertCell();
     				 	tdd.innerHTML="";
						len--;
     				}
				}
				for(i = 1;i<=cnt/6;i++)
    		 	{
      		  		for(var j=0;j<6;j++)
      				{
						table_temp.rows[i].cells[j].innerHTML=data[x];
       					x++;
     				}
				}
			}*/
		}
		});
}

function click_up()
{
	$('#mask').css({'zIndex':'5'});
	$('#mask').animate({'opacity':'0.8'},200);
	$('#up').fadeIn(200);
}
function course_select()
{
	click_up();
	document.form.select_id.value=1;
	document.getElementById("select_any").innerHTML="请输入课程名：<font class=up_tips>[如：数据结构] <br /> <br /></font>";
	document.getElementById("teacher_name").focus();
}
function address_select()
{
	click_up();
	document.form.select_id.value=2;
	document.getElementById("select_any").innerHTML="请输入机房号：<font class=up_tips>[如：205 ]<br /> <br /></font>";
	document.getElementById("teacher_name").focus();
}
function student_num_select()
{
	click_up();
	document.form.select_id.value=3;
	document.getElementById("select_any").innerHTML="请输入学号：<font class=up_tips>[如：100405201] <br /> <br /></font>";
	document.getElementById("teacher_name").focus();
}
function week_select()
{
	click_up();
	document.form.select_id.value=4;
	document.getElementById("select_any").innerHTML="请输入周次：<font class=up_tips>[如：03 ]<br /> <br /></font>";
	document.getElementById("teacher_name").focus();
}
function teacher_num_select()
{click_up();
	document.form.select_id.value=5;
	document.getElementById("select_any").innerHTML="请输入教师号：<font class=up_tips>[如：11111 ]<br /> <br /></font>";
	document.getElementById("teacher_name").focus();
}
function up_Inquiry()
{
	click_up();
	document.form.select_id.value=6;
	document.getElementById("select_any").innerHTML="请输入教师名：<font class=up_tips>[如：修国一 ]<br /> <br /></font>";
	document.getElementById("teacher_name").focus();
}

//返回顶部
$("#toolBackTo").hide();
$(function () {
	$(window).scroll(function(){
	if ($(window).scrollTop()>1){
	$("#toolBackTo").fadeIn(1);
	}
	else
	{
	$("#toolBackTo").fadeOut(1);
	}
	});


//当点击跳转链接后，回到页面顶部位置
	});
	
	$("#toolBackTo").click(function(){
	$('body,html').animate({scrollTop:0},1000);
		return false;
	});
	
	
	//表格排序
	function sortrows(Table,n){
		var rows = Table.getElementsByTagName("tr");
		//rows = Array.prototype.slice.call(rows,1);
		var k = rows.length;
		try{
        	rows = Array.prototype.slice.call(rows)
      	}
		catch(e){
			var	ret = [];
        		while(k){
					ret[--k] = rows[k];//Clone数组
				}
				rows = ret;
		}
		rows = rows.splice(1,rows.length);
		rows.sort(function (row1,row2){
		
		var cell1 = row1.getElementsByTagName("td")[n];
		var cell2 = row2.getElementsByTagName("td")[n];
		var val1 = cell1.innerHTML;
		var val2 = cell2.innerHTML;
		return val1.localeCompare(val2);
		});
		Table = document.getElementsByTagName("tbody")[0];
		for(var i=0;i<rows.length;i++)
		{
			Table.appendChild(rows[i]);
		}
	}
	function ownSort(m)
	{
		var Table = document.getElementById("t_table");
		sortrows(Table,m);
	}
</script>
</html>