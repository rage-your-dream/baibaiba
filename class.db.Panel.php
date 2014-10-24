<?php
require_once "class.DBConn.php";
class PanelDB extends DBConn{
	/**
	 * 新建图表时初始化图表位置
	 */
	public function insertPanel($id){
		$conn=parent::getConn();
 		$sql="INSERT INTO panel (id) VALUES(:id) ";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":id",$id,PDO::PARAM_INT);
 			$st->execute();
 			return true;
 		}catch(PDOException $e){
 			echo "insertPanel() failed:".$e->getMessage();
 			return false;
 		}	
	}
	/**
	 * 删除图表数据
	 * 还没有用到
	 */
	public function deletePanel($id){
 		$conn=parent::getConn();
 		$sql="DELETE FROM panel WHERE id=:id ";
 		try{	
 			$st1=$conn->prepare($sql);
 			$st1->bindValue(":id",$id,PDO::PARAM_INT);
 			$st1->execute();
 			return true;
 		}catch(PDOException $e){
 			echo "insert failed:".$e->getMessage();
 			return false;
 		}	
	}
	/**
	 * 根据panel的id来获取panel的所有字段
	 */
	public function selectPanel($id,$username){
		$conn=parent::getConn();
 		$sql="SELECT `id`,`title`,`x`,`y`,`width`,`height`,`page_width`,`page_height`,`data_lock`,`ishide`,`analysis_show`,IFNULL((SELECT ispraise FROM praise WHERE panel_id = :id AND username = :username ORDER BY id DESC LIMIT 1),0) AS `praiseStatus`,(SELECT COUNT(id) FROM praise WHERE panel_id = :id AND ispraise = 1) AS `totalPraise` FROM panel WHERE id=:id";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":id",$id,PDO::PARAM_INT);
 			$st->bindValue(":username",$username,PDO::PARAM_STR);
 			$st->execute();
 			$row=$st->fetch();
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}		
 		return $row;
	}
	public function updatePanelLocation($data,$id){
		$conn=parent::getConn();
 		$sql="UPDATE panel Set x=:x,y=:y,page_width=:page_width,page_height=:page_height WHERE id=:id";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":x",$data["x"],PDO::PARAM_INT);
 			$st->bindValue(":y",$data["y"],PDO::PARAM_INT);
 			$st->bindValue(":page_width",$data["page_width"],PDO::PARAM_INT);
 			$st->bindValue(":page_height",$data["page_height"],PDO::PARAM_INT);
 			$st->bindValue(":id",$id,PDO::PARAM_INT);
 			$st->execute();
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}
 		return true;
	}
	public function updatePanelAnalysisShow($id,$isshow){
		$conn=parent::getConn();
 		$sql="UPDATE panel Set analysis_show=:isshow WHERE id=:id";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":isshow",$isshow,PDO::PARAM_INT);
 			$st->bindValue(":id",$id,PDO::PARAM_INT);
 			$st->execute();
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}
 		return true;
	}

	/**
	 * 图表大小存档
	 */
	 public function updatePanelSize($width,$id){
		$conn=parent::getConn();
 		$sql="UPDATE panel Set width=:width WHERE id=:id";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":width",$width,PDO::PARAM_INT);
 			$st->bindValue(":id",$id,PDO::PARAM_INT);
 			$st->execute();
 		}catch(PDOException $e){
 			echo "updatePanelSize failure:".$e->getMessage();
 			return false;
 		}
 		return true;
	}
	/**
 	 * 切换锁状态
 	 */
	public function updatePaneltDataLock($id,$status){
		$conn=parent::getConn();
 		$sql="UPDATE panel Set data_lock=:status WHERE id=:id ";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":id",$id,PDO::PARAM_INT);
 			$st->bindValue(":status",$status,PDO::PARAM_INT);
 			$st->execute();
 			return true;
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}			
	}
	/**
	 * 插入praise数据
	 */
	public function insertPraise($username,$panel_id,$praise){
		$conn=parent::getConn();
 		$sql="INSERT INTO `showdb`.`praise`(`username`,`panel_id`,`ispraise`)VALUES (:username,:panel_id,:praise);";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":username",$username,PDO::PARAM_STR);
 			$st->bindValue(":panel_id",$panel_id,PDO::PARAM_INT);
 			$st->bindValue(":praise",$praise,PDO::PARAM_INT);
 			$st->execute();
 			return true;
 		}catch(PDOException $e){
 			echo "insertPraise() failed:".$e->getMessage();
 			return false;
 		}	
	}
	/**
 	 * 更新praise数据
 	 */
	public function updatePraise($username,$panel_id,$praise){
		$conn=parent::getConn();
 		$sql="UPDATE `praise` SET `ispraise` = :praise WHERE `username` = :username AND `panel_id`= :panel_id ORDER BY id DESC LIMIT 1;";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":username",$username,PDO::PARAM_STR);
 			$st->bindValue(":panel_id",$panel_id,PDO::PARAM_INT);
 			$st->bindValue(":praise",$praise,PDO::PARAM_INT);
 			$st->execute();
 			return true;
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}			
	}
	
}

//$db = new PanelDB();
//print_r( $db->selectPanel(3,'wangzhipeng'));

?>
