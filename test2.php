<?php
 require_once 'util/DatabaseManager.php';
 
// $dbm = new DatabaseManager();
// $res=$dbm->add("test", "1540129480", "8465213JIANlove");
// echo $res;

 $dbm = new DatabaseManager();
    $result = $dbm->query("test")->fetch();
    $usernmae=$result["username"];
	$password=$result["password"];
?>