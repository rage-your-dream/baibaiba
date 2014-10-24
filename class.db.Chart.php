<?php
require_once "class.DBConn.php";

class ChartDB extends DBConn{
	/**
	 * 添加新图表
	 */
	public function insertChart($id,$type,$chart,$dashboard_id){
 		$conn=parent::getConn();
 		$sql="insert into chart (id,type,data,dashboard_id) values(:id,:type,:data,:dbid) ";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":id",$id,PDO::PARAM_INT);
 			$st->bindValue(":type",$type,PDO::PARAM_STR);
 			$st->bindValue(":data",$chart,PDO::PARAM_STR);
 			$st->bindValue(":dbid",$dashboard_id,PDO::PARAM_INT);
 			$st->execute();
 			return true;
 		}catch(PDOException $e){
 			echo "insert failed:".$e->getMessage();
 			return false;
 		}	
	}
	/**
 	 * 根据ID获取图表HelpMsg
 	 */
	public function updateChart($id,$chart){
		//echo $chart;
		$conn=parent::getConn();
 		$sql="UPDATE chart Set data=:data where id=:id ";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":id",$id,PDO::PARAM_INT);
 			$st->bindValue(":data",$chart,PDO::PARAM_STR);
 			$st->execute();
 			return true;
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}			
	}
	/**
	 * 删除图表
	 */
	public function deleteChart($id){
 		$conn=parent::getConn();
 		$sql="DELETE FROM chart where id=:id ";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":id",$id,PDO::PARAM_INT);
 			$st->execute();
 			return true;
 		}catch(PDOException $e){
 			echo "insert failed:".$e->getMessage();
 			return false;
 		}	
	}
 	/**
 	 * 查找最大id
 	 * 
 	 */
 	public function selectMaxChartId(){
 		$conn=parent::getConn();
 		$sql="select MAX(id) as id from chart";
 		try{
 			$st=$conn->prepare($sql);
 			$st->execute();
 			$row=$st->fetch();
 			if($row)
 				return $row["id"];
 			else return 1;
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}		
 	}
 	
 	/**
 	 * 根据ID获取图表内容
 	 */
	public function selectChart($id){
		$conn=parent::getConn();
 		$sql="select type,data_machine,data from chart where id=:id ";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":id",$id,PDO::PARAM_INT);
 			$st->execute();
 			$row=$st->fetch();
 			return $row;
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}			
	}
	/**
 	 * 根据ID获取图表HelpMsg
 	 */
	public function selectChartHelpMsg($id){
		$conn=parent::getConn();
 		$sql="select help_msg from chart where id=:id ";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":id",$id,PDO::PARAM_INT);
 			$st->execute();
 			$row=$st->fetch();
 			return $row;
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}			
	}
	public function selectChartAnalysisMsg($id){
		$conn=parent::getConn();
 		$sql="select analysis_msg from chart where id=:id ";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":id",$id,PDO::PARAM_INT);
 			$st->execute();
 			$row=$st->fetch();
 			return $row;
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}			
	}
	/**
 	 * 根据ID获取图表HelpMsg
 	 */
	public function updateChartHelpMsg($id,$msg){
		$conn=parent::getConn();
 		$sql="UPDATE chart Set help_msg=:msg where id=:id ";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":id",$id,PDO::PARAM_INT);
 			$st->bindValue(":msg",$msg,PDO::PARAM_STR);
 			$st->execute();
 			return true;
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}			
	}
	/**
 	 * 根据ID获取图表analysisMsg
 	 */
	public function updateChartAnalysisMsg($id,$msg){
		$conn=parent::getConn();
 		$sql="UPDATE chart Set analysis_msg=:msg where id=:id ";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":id",$id,PDO::PARAM_INT);
 			$st->bindValue(":msg",$msg,PDO::PARAM_STR);
 			$st->execute();
 			
 			return true;
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}			
	}
	
	/**
 	 * 根据dashboard_id获取Chart
 	 */
	public function selectChartByDashboardId($board_id){
		$conn=parent::getConn();
 		$sql="SELECT id,panel_id,help_msg,analysis_msg FROM chart WHERE dashboard_id =:id";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":id",$board_id,PDO::PARAM_INT);
 			$st->execute();
 			$row=$st->fetchAll();
 			return $row;
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}			
	}
		/**
 	 * 根据dashboard_id获取所有chart_id,help_msg,analysis_msg
 	 */
	public function selectChartInfo($dashboard_id){
		$conn=parent::getConn();
 		$sql="SELECT id AS chart_id,id AS pannel_id,help_msg AS help_msg,analysis_msg AS analysis_msg FROM chart WHERE dashboard_id =:id and id not in (SELECT id FROM panel WHERE ishide = 1);";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":id",$dashboard_id,PDO::PARAM_INT);
 			$st->execute();
 			$row=$st->fetchALL();
 			return $row;
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}			
	}
}
?>
