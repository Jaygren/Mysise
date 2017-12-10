<?php

function getPerson($contents){
	//转码显示
$contents=iconv('gbk', 'UTF-8', $contents);
$html = new simple_html_dom();
// 从url中加载
$html->load($contents);
$a=$html->find("div align='left'");
   $str = "姓名:".trim($a[3]->text())."\n"
   ."年级:".trim($a[4]->text())."\n"
   ."专业:".trim($a[5]->text())."\n"
   ."身份证号:".trim($a[6]->text())
   ."\n"."电子邮箱:".trim($a[7]->text())
   ."\n"."学习导师:".trim($a[8]->text())
   ."\n"."辅导员:".trim($a[9]->text());
 return $str;	
}
?>