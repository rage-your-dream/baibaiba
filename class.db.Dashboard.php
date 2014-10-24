<?php

require_once "class.DBConn.php";

class DashboardDB extends DBConn{
	/**
	 * 添加新board
	 */
	public function insertNewBoard($data){
		$conn=parent::getConn();
		
 		$sql2="INSERT into dashboard (id,name) values(:id,:name) ";			
 		
 		try{
 			$st=$conn->prepare($sql2);
 			$st->bindValue(":id",$data["id"],PDO::PARAM_INT);
 			$st->bindValue(":name",$data["name"],PDO::PARAM_STR);
 			$st->execute();
 		}catch(PDOException $e){
 			echo "Insert new dashboard to db failure:".$e->getMessage();
 			return false;
 		}
 		return true;
	} 
	public function selectMaxDshboardId(){
		$conn=parent::getConn();
		$id=0;
		$sql1="SELECT MAX(id) as id from dashboard";
		try{
 			$st=$conn->prepare($sql1);
 			$st->execute();
 			$r=$st->fetch();
 			if($r["id"])
 				return $r["id"];
 			else return 1;
 		}catch(PDOException $e){
 			echo "select max dashboard id failed:".$e->getMessage();
 			return false;
 		}	
	}
	/**
	 * boardname
	 */
	public function selectDasbordName($id){
		$conn=parent::getConn();
 		$sql="SELECT name from dashboard WHERE id=:id";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":id",$id,PDO::PARAM_INT);
 			$st->execute();
 			$row=$st->fetch();
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}		
 		return $row;
	}

	public function selectDashBoardChartId($id){
		$conn=parent::getConn();
 		$sql="select id from chart where dashboard_id=:id ";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":id",$id,PDO::PARAM_INT);
 			$st->execute();
 			$row=$st->fetchAll();
 			return $row;
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}			
	}
	
}
//$db=new DashboardDB();
//echo $db->insertNewBoard(array("name"=>"first","id"=>1));
//$tdb->updateDragableWidgdit(array("name"=>"任务：打死铁松","target"=>"用合理的方式发泄加班的情绪","checklist"=>"腿断;脑残"));
//$tdb->select();
?>
