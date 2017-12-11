<?php
/**
1.	提供学生个人信息查询(完成)
2.	提供学生课表查询。（最好有上课前自动提醒功能）(完成)
3.	提供学生考勤信息查询。（完成）
4.	提供学生考试时间查询。（完成）
5.	提供学生成绩查询。（完成）
6.	提供学生奖惩情况查询(完成)
7.	提供学生开设课程信息查询。（直接post页面）(算完成了)
8.	提供晚归、违规电器查询。（完成）
 * 
 */
require_once 'util/simple_html_dom.php';
require_once 'util/MySiseUtil.php';
require_once 'sise/siseLogin.php';
require_once 'sise/getPerson.php';
require_once 'sise/getSchedule.php';
require_once 'sise/getExam.php';
require_once 'sise/getWorkattendance.php';
require_once 'sise/getScore.php';
require_once 'sise/getReward.php';
require_once 'sise/getWrongdoing.php';

//自己填
$usernmae="";
$password="";
$post_fields=getLoginInfo($usernmae,$password);
$cookie_file = tempnam("./","cookie");//cookie的文件保存路径
//------------------------------------------------------------


//------------------------------------------------------------
//提交登录表单请求
$login_url="http://class.sise.com.cn:7001/sise/login_check.jsp";
MysiseLogin($cookie_file,$login_url,$post_fields);
//------------------------------------------------------------


//------------------------------------------------------------
//登录成功后，获取各版块链接
$url="http://class.sise.com.cn:7001/sise/module/student_states/student_select_class/main.jsp";
$content=MysiseHeader($url,$cookie_file);
//------------------------------------------------------------


//------------------------------------------------------------
//判断登录正确性
if(issetLogined($content)=="登录成功"){
//------------------------------------------------------------
echo "登录成功\n";
// 从url中加载
$urls=getUtils($content);
//------------------------------------------------------------


//------------------------------------------------------------
//1：获取"个人信息"数据
$contents=MysiseHeader($urls[0],$cookie_file);
$str=getPerson($contents);
echo "1:".$str;
//------------------------------------------------------------


//------------------------------------------------------------
//2：获取"课程表信息"数据
$contents=MysiseHeader($urls[1],$cookie_file);
$str=getSchedule($contents);
echo "2:".$str;
//------------------------------------------------------------


//------------------------------------------------------------
//3：获取"学生考试时间"数据
$contents=MysiseHeader($urls[2],$cookie_file);
$str=getExam($contents);
echo "3:".$str;
//------------------------------------------------------------


//------------------------------------------------------------
//4：获取"考勤信息"数据
$contents=MysiseHeader($urls[3],$cookie_file);
$str=getWorkattendance($contents);
echo "4:".$str;	
//------------------------------------------------------------


//------------------------------------------------------------
//5：获取"个人成绩"数据
$contents=MysiseHeader($urls[0],$cookie_file);
$str=getScore($contents);
echo "5：".$str;
//------------------------------------------------------------


//------------------------------------------------------------
//6：获取"奖惩记录"数据
$contents=MysiseHeader($urls[5],$cookie_file);
$str=getReward($contents);
echo "6:".$str;	
//------------------------------------------------------------


//------------------------------------------------------------
//8：获取"晚归、违规用电记录"数据
$contents=MysiseHeader($urls[21],$cookie_file);
$str=getWrongdoing($contents);
echo "8:".$str;
//------------------------------------------------------------	
}else{
 echo "登录失败\n";
 exit;
}
//------------------------------------------------------------


//------------------------------------------------------------
unlink($cookie_file);
?>
