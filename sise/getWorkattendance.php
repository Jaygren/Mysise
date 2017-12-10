<?php
function getWorkattendance($contents){
//转码显示
$contents=iconv('gbk', 'UTF-8', $contents);
$html = new simple_html_dom();

// 从url中加载
$html->load($contents);
$a = $html->find("td[align=center]");
$str = null;												
    for($i = 1;$i < count($a);$i++){
        $str .="课程代码:".trim($a[$i]->text())."\n"
        ."课程名称:".trim($a[++$i]->text())."\n"
        ."考勤情况:".trim($a[++$i]->text())."\n"."\n";
    }
	$html->clear();
	return $str;
}
?>