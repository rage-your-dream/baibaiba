<?php
require_once "class.DBConn.php";
class UserDB extends DBConn{
	
	public function insertLDAP($data){
		$conn=parent::getConn();
 		$sql="insert into user (employee_id,username,email,department) " .
 				"values(:employee_id,:username,:email,:department) ";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":employee_id",$data["employee_id"],PDO::PARAM_STR);
 			$st->bindValue(":username",$data["username"],PDO::PARAM_STR);
 			$st->bindValue(":email",$data["email"],PDO::PARAM_STR);
 			$st->bindValue(":department",$data["department"],PDO::PARAM_STR);
 			$st->execute();
 			$conn=Null;
 		}catch(PDOException $e){
 			echo "insertLDAP() failed:".$e->getMessage();
 			return false;
 		}	
 		
 		return true;
	}
	public function select($rule=Null){
		$conn=parent::getConn();
 		$sql="select num,username,phone,qq,email from showdb.user ";
 		if(isset($rule)){
 			$sql=$sql.$rule;
 		}
 		try{
 			$rows=$conn->query($sql); 
 			return $rows;
 		}catch(PDOException $e){
 			echo "insert failed:".$e->getMessage();
 			return false;
 		}	

	}

	public function hasUser($email){
		$conn=parent::getConn();
 		$sql="select email,username from  showdb.user WHERE email=:email ";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":email",$email,PDO::PARAM_STR);	
 			$st->execute();
 			$row=$st->fetch();
 			$conn=Null;
 			return $row;
 		}catch(PDOException $e){
 			echo " error:".$e->getMessage();
 			return false;
 		}	
	}
}

?>
