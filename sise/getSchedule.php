<?php
function getSchedule($contents){
//转码显示
$contents=iconv('gbk', 'UTF-8', $contents);

$html = new simple_html_dom();
$html->load($contents);
//返回最后一个table标签
$table = $html->find('table',-1);
        $table = preg_replace("#</td><tr[^>]*?>#",'</td></tr><tr>',$table);
//		echo $table;
        $html->load($table);
        $tds = $html->find('tr td');
        $tds = preg_replace("#<strong[^>]*?>(.*?)</strong[^>]*?>#","$1",$tds);
//		var_dump($tds);
        $a = array();
        $n = 0;
        for ($i = 0;$i<9;$i++)
        {
            for ($j = 0;$j<8;$j++)
            {
                $old = strip_tags($tds[$n++]);
                $new = preg_replace('#\&nbsp\;#','' ,$old );
                $a[$i][$j] = $new;
            }
        }
        $html->clear();	
		$str=null;
		for ($j = 1;$j<6;$j++){
		for ($i = 0;$i<count($a);$i++)
		{
		       if ($a[$i][$j] == "")
                  {
                      continue;
                  }
			$str.= $a[$i][0]."\n".$a[$i][$j]."\n"."\n";
        }
	    }
return $str;
}
?>