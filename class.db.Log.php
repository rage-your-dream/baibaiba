<?php
require_once "class.DBConn.php";
class LogDB extends DBConn{
	
	/**
	 * 插入slider页面click事件
	 */
	public function insertLog($data){
		$event=$data['event'];
		$page=$data['page'];
		$description=$data['description'];
		$username=$data['username'];
		$ip=$data['ip'];
		$conn=parent::getConn();
		$sql="INSERT INTO sys_log (`event`,`page`,`description`,`username`,`ip`)".
			 "VALUES('{$event}','{$page}','{$description}','{$username}','{$ip}');";
 		try{
 			$st=$conn->prepare($sql);
 			$st->execute();
 			$conn=Null;
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}		
 		return true;
	}
}

?>
