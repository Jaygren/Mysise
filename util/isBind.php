<?php

//绑定校验
function isBind($openid,$cookie_file)
{
    $dbm = new DatabaseManager();
	$data = $dbm->query($openid)->fetch();
    $result = $dbm->query($openid);
    if ($result->rowCount()){
    $usernmae=$data["username"];
	$password=$data["password"];
//------------------------------------------------------------	
$post_fields=getLoginInfo($usernmae,$password);

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
if(issetLogined($content)=="登录成功"){
	return 1;
}else{
	return 2;
}
	}
   return 3;
}
?>