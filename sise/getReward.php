<?php

function getReward($contents){
	//转码显示
$contents=iconv('gbk', 'UTF-8', $contents);;
$html = new simple_html_dom();

// 从url中加载
$html->load($contents);
$a = $html->find('td[class="tablebody"]');
$str = null;													
    for($i = 0;$i < count($a);$i++){
        $str .="学年:".trim($a[$i]->text())."\n"
        ."学期:".trim($a[++$i]->text())."\n"
        ."奖励级别:".trim($a[++$i]->text())."\n"
        ."奖励原因:".trim($a[++$i]->text())."\n"
        ."奖励单位/部门:".trim($a[++$i]->text())."\n"
        ."奖励日期:".trim($a[++$i]->text())."\n"."\n";
    }
	   $html->clear();
	
return $str;
}
?>