<?php

//提交登录表单请求
function MysiseLogin($cookie_file,$login_url,$post_fields){
$ch = curl_init($login_url);
curl_setopt($ch,CURLOPT_HEADER,1);//是否显示头信息
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);//设置自动显示返回的信息
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch,CURLOPT_POST,1);//post方式提交
curl_setopt($ch,CURLOPT_POSTFIELDS,$post_fields);//要提交的信息
curl_setopt($ch,CURLOPT_COOKIEJAR,$cookie_file);//设置Cookie信息保存在指定的文件中
$content = curl_exec($ch);//执行CURL
curl_close($ch);//释放系统资源
}
function MysiseHeader($url,$cookie_file){
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
$content = curl_exec($ch);
curl_close($ch);
return $content;
}
//获取各版块链接
function getUtils($content){
$html = new simple_html_dom();
$html->load($content);
$a = $html->find("td[onclick]");
$urls[0]="http://class.sise.com.cn:7001/".substr($a[0]->onclick, 54, -1);
$urls[1]="http://class.sise.com.cn:7001/".substr($a[1]->onclick,40,-1);
$urls[2]="http://class.sise.com.cn:7001/".substr($a[2]->onclick, 49, -1);
$urls[3]="http://class.sise.com.cn:7001/".substr($a[3]->onclick, 49, -1);
$urls[5]="http://class.sise.com.cn:7001/".substr($a[5]->onclick,40,-1);
$urls[21]="http://class.sise.com.cn:7001/".substr($a[21]->onclick,40,-1);
return $urls;
}
//判断登录
function issetLogined($content){
	if(substr_count($content,'id="running"')){
     return "登录成功";
	}else{
     return "登录失败";
	}
}
?>