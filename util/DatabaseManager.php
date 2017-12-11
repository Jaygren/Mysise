<?php
class DatabaseManager
{
    private $db = null;
    function __construct()
    {
        $dbms='mysql';     //数据库类型
        $host='localhost'; //数据库主机名
        $dbName='mysise';    //使用的数据库
        $user='root';      //数据库连接用户名
        $pass='';          //对应的密码
        $dsn="$dbms:host=$host;dbname=$dbName";
        try {
            $this->db = new PDO($dsn, $user, $pass); //初始化一个PDO对象
        } catch (PDOException $e) {
            die ("Error!: " . $e->getMessage() . "<br/>");
        }
    }
    function __destruct()
    {
        $this->close();
    }

  
  //增加
    function add($openid,$username,$password)
    {
	    $statement = "INSERT INTO `mysise` (`id`,`openid`, `username`, `password`) VALUES ( null,'".$openid."', '".$username."', '".$password."')";  
	     return $this->db->exec($statement);
    }
	//删除
    function delete($openid)
    {
      $statement = "DELETE FROM `mysise` WHERE `openid` = '".$openid."'";
      return $this->db->exec($statement);
    }
  //查询
    function query($openid)
    {
      $statement = "SELECT * FROM `mysise` WHERE `openid` = '".$openid."'";
      $result = $this->db->query($statement);
      return $result;
    }
	
    function close()
    {
        $this->db = null;
    }
} 
?>