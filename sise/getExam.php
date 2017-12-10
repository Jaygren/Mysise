<?php
function getExam($contents){
	//转码显示
$contents=iconv('gbk', 'UTF-8', $contents);

   $table_pattern = '/<table width="90%" class="table" [\w\W]*?>([\w\W]*?)<\/table>/';
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
            $str.="课程:".$a[0][$i]."-".$a[0][$i+1]."\n"
            ."考试日期：".$a[0][$i+2]."\n"
            ."考试时间：".$a[0][$i+3]."\n"
            ."考场名称：".$a[0][$i+5]."\n"
            ."座位：".$a[0][$i+6]."\n"
            ."考试状态：".$a[0][$i+7]."\n"."\n";
			$i=$i+7;
        }
	return $str;
}
?>