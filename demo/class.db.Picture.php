<?php
require_once "class.DBConn.php";

class PictureDB extends DBConn{
	
	public function insert($data){
		$conn=parent::getConn();
 		$sql="insert into picture (name,path,ower,uploadtime,size,msg) " .
 				"values(:name,:path,:ower,:uploadtime,:size,:msg) ";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":name",$data["name"],PDO::PARAM_STR);
 			$st->bindValue(":path",$data["path"],PDO::PARAM_STR);
 			$st->bindValue(":ower",$data["ower"],PDO::PARAM_STR);
 			$st->bindValue(":uploadtime",$data["uploadtime"],PDO::PARAM_STR);
 			$st->bindValue(":size",$data["size"],PDO::PARAM_INT);
 			$st->bindValue(":msg",$data["msg"],PDO::PARAM_STR);
 			$st->execute();
 		}catch(PDOException $e){
 			echo "insert failed:".$e->getMessage();
 			return false;
 		}	
 		
 		return true;
	} 
	public function selectAll(){
		$conn=parent::getConn();
 		$sql="select id,name,path,ower,uploadtime,size,msg from picture ";
 		try{
 			$st=$conn->prepare($sql);
 			$st->execute();
 			$row=$st->fetchAll();
 			$conn=Null;
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}		
 		return $row;
	}
	public function selectByDay($day){
		$conn=parent::getConn();
 		$sql="select id,name,path,ower,uploadtime,size,msg from picture WHERE DATE_SUB(CURDATE(), INTERVAL {$day} DAY)=DATE(uploadtime) ";
 		try{
 			$st=$conn->prepare($sql);
 			$st->execute();
 			$row=$st->fetchAll();
 			$conn=Null;
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}		
 		return $row;
	}
}
?>
