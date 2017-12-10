<?php
function DatabaseManager()
{
  if(isset($_SERVER['HTTP_APPNAME'])){        //SAE
        $mysql_host = SAE_MYSQL_HOST_M;
        $mysql_host_s = SAE_MYSQL_HOST_S;
        $mysql_port = SAE_MYSQL_PORT;
        $mysql_user = SAE_MYSQL_USER;
        $mysql_password = SAE_MYSQL_PASS;
        $mysql_database = SAE_MYSQL_DB;
    }
  $con = mysql_connect($mysql_host.':'.$mysql_port, $mysql_user, $mysql_password);
  if (!$con){
		die('Could not connect: ' . mysql_error());
	}
  
  mysql_query("SET NAMES 'UTF8'");
  mysql_select_db($mysql_database, $con);
  
  //增加
    function add($openid,$username,$password)
    {
        $statement = "INSERT INTO `mysise` (`id`,`openid`, `username`, `password`) VALUES ( null,'".$openid."', '".$username."', '".$password."')";
        return mysql_query($statement);
    }
	//删除
    function delete($openid)
    {
        $statement = "DELETE FROM `mysise` WHERE `openid` = '".$openid."';";
        return mysql_query($statement);
    }
  //查询
    function query($openid)
    {
        $statement = "SELECT * FROM `mysise` WHERE `openid` = '".$openid."'";
        $result = mysql_query($mysql_state);
        return $result;
    }
	mysql_close($con);
} 
?>