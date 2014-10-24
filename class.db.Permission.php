<?php
require_once "class.DBConn.php";
class PermissionDB extends DBConn{
	/**
	 * 根据panel的id来获取panel位置
	 */
	public function selectPermissionDB($id){
		$conn=parent::getConn();
 		$sql="SELECT user_email,rule FROM permission WHERE user_email=:email";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":email",$id,PDO::PARAM_STR);
 			$st->execute();
 			$row=$st->fetchAll();
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}		
 		return $row;
	}
}
?>
