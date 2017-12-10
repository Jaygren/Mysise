<?php
function getLoginInfo($username,$password){
$html = file_get_html('http://class.sise.com.cn:7001/sise/login.jsp');
$items = $html -> find("input[value]");
$random1 = $items[0] -> name;
$random2 =  $items[0] -> value;
$random3 = $items[1] -> name;
$random4 =  $items[1] -> value;
$post_fields="username=$username&password=$password&$random1=$random2&$random3=$random4";
return $post_fields;
}
?>