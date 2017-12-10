<?php
function getScore($contents){
//转码显示
$contents=iconv('gbk', 'UTF-8', $contents);
$table_pattern = '/<table width="90%" class="table" align="center"[\w\W]*?>([\w\W]*?)<\/table>/';
preg_match_all($table_pattern, $contents, $matches);
  
$tmp="/<td.*>(.*)<\/td>/iUs";

	$a=Array();
    foreach($matches[0] as $tr)
    {
    preg_match_all($tmp,$tr,$td);
    $a[]=$td[1];
    }
	$str="必修："."\n";
	switch(date("m")){
		case 9:
		case 10:
		case 11:
		case 12:
		case 1:
	    case 2:
			$term="第一学期";
			break;
	    case 3:
	    case 4:
		case 5:
		case 6:
		case 7:
	    case 8:
			$term="第二学期";
			break;
	}
	$term=date("Y")."年".$term;
    for($i=7;$i<count($a[0]);$i=$i+10){
    	if($a[0][$i]==$term){
    		$str .= strip_tags($a[0][$i-5])."："
		         .$a[0][$i+1]."\n"."\n";
    	}else{
    		continue;
    	}
    }
	$str .= "选修："."\n";
	for($i=6;$i<count($a[1]);$i=$i+9){
    	if($a[1][$i]==$term){
    		$str .= strip_tags($a[1][$i-5])."："
		         .$a[1][$i+1]."\n"."\n";
    	}else{
    		continue;
    	}
    }
	return $str;
}
?>