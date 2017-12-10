<?php
$appid = "wxe86b43fba4d6cc9e";
$appsecret = "08f9c649d0c7f023bf764f8e5439031d";
$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
$output=https_request($url);
$jsoninfo=json_decode($output,true);
$access_token=$jsoninfo["access_token"];
$jsonmenu = '{
    "button": [
        {
            "name": "查询", 
            "sub_button": [
                {
                    "type": "click", 
                    "name": "个人信息", 
                    "key": "btn_person"
                },
                {
                    "type": "click", 
                    "name": "奖惩记录", 
                    "key": "btn_reward"
                }, 
                {
                    "type": "click", 
                    "name": "晚归违规记录", 
                    "key": "btn_wrongdoing"
                }, 
                {
                    "type": "view", 
                    "name": "开设课程", 
                    "url": "http://class.sise.com.cn:7001/sise/coursetemp/courseInfo.html"
                }
            ]
        }, 
        {
            "name": "学习宝具", 
            "sub_button": [
                 
                {
                    "type": "click", 
                    "name": "考勤查询", 
                    "key": "btn_workattendance"
                }, 
                {
                    "type": "click", 
                    "name": "我的课表", 
                    "key": "btn_schedule"
                }, 
                {
                    "type": "click", 
                    "name": "考试时间", 
                    "key": "btn_exam"
                }, 
                {
                    "type": "click", 
                    "name": "成绩查询", 
                    "key": "btn_score"
                }
            ]
        }, 
        {
            "name": "其他", 
            "sub_button": [
                {
                    "name": "绑定账号", 
                    "type": "click", 
                    "key": "btn_bind"
                }, 
                {
                    "name": "绑定账号", 
                    "type": "click", 
                    "key": "btn_unbind"
                }
            ]
        }
    ]
}';
//创建菜单
$url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
$result=https_request($url,$jsonmenu);
var_dump($result);
//自定义CURL会话创建菜单
function https_request($url,$data=null){
	$curl=curl_init();
	curl_setopt($curl,CURLOPT_URL,$url);
	curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,FALSE);
	curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,FALSE);
	if(!empty($data)){
		curl_setopt($curl,CURLOPT_POST,1);
		curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
	}
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
	$output=curl_exec($curl);
	return $output;
}
?>