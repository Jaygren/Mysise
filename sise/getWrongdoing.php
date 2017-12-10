<?php
function getWrongdoing($contents){
//转码显示
$contents=iconv('gbk', 'UTF-8', $contents);

  $table_pattern = '/<table width="95%" class="table" align="center"[\w\W]*?>([\w\W]*?)<\/table>/';
        preg_match_all($table_pattern, $contents, $matches);
        $tmp="/<td.*>(.*)<\/td>/iUs";

	    $a=Array();
        foreach($matches[0] as $tr)
        {
            preg_match_all($tmp,$tr,$td);
            $a[]=$td[1];
        }
        $str=null;
        for($i=0;$i < count($a[0]);$i++ ){
            $str.="学年:".$a[0][$i]."第".$a[0][$i+1]."学期"."\n"
            ."宿舍:".$a[0][$i+2]."\n"
            ."停电日期:".$a[0][$i+3]."\n"
            ."停电次数:".$a[0][$i+4]."\n"
            ."停电天数:".$a[0][$i+5]."\n"
            ."停电原因:".$a[0][$i+6]."\n"
            ."责任人:".$a[0][$i+7]."\n"."\n";
			$i=$i+7;
        }
    $str=str_replace("<font color='blue'>",'',$str);
	$str=str_replace('</font>','',$str);
	return $str;
}
?>