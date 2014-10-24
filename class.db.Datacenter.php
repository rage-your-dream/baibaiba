<?php
require_once "class.DBConn.php";
require_once "config.php";
class DatacenterDB extends DBConn{
	/*
	 * 查询PVUV每日趋势
	 */
	public function selectPvUvDayTrend(){
		$conn=parent::getConn(DB_DSN_SHOW);
 		$sql="SELECT DATE_FORMAT(createtime,'%Y/%m/%d') AS `time`,COUNT(id) AS pv,COUNT(DISTINCT username) AS uv FROM sys_log WHERE  `event`='click' AND username NOT IN ('wangzhipeng','zhangchengtao','liuhao_17173','yuecui','liutiesong') AND createtime >= '2014-9-25 15:36' GROUP BY `time` ORDER BY `time`;";
 		try{
 			$st=$conn->prepare($sql);
 			$st->execute();
 			$row=$st->fetchALL();
 			$conn=Null;
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}		
 		return $row;
	}
	/*
	 * 查询PV 分布数据 
	 */
	public function selectPvDistribute(){
		$conn=parent::getConn(DB_DSN_SHOW);
 		$sql="SELECT st.transname AS `name` ,COUNT(sl.description) AS num FROM sys_log sl JOIN sys_log_description_trans st ON  sl.description = st.description WHERE `event`='click' AND username NOT IN ('wangzhipeng','zhangchengtao','liuhao_17173','yuecui','liutiesong') AND createtime >= '2014-9-25 15:36' GROUP BY `name` ORDER BY `num` DESC;";
 		try{
 			$st=$conn->prepare($sql);
 			$st->execute();
 			$row=$st->fetchALL();
 			$conn=Null;
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}		
 		return $row;
	}
	/*
	 * 查询总PV
	 */
	public function selectTotalPV(){
		$conn=parent::getConn(DB_DSN_SHOW);
 		$sql="SELECT COUNT(*) AS pv FROM sys_log WHERE  `event`='click' AND username NOT IN ('wangzhipeng','zhangchengtao','liuhao_17173','yuecui','liutiesong') AND createtime >= '2014-9-25 15:36';";
 		//echo $sql;
 		try{
 			$st=$conn->prepare($sql);
 			$st->execute();
 			$row=$st->fetchALL();
 			$conn=Null;
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}		
 		return $row[0][0];
	}
	/*
	 * 查询总UV
	 */
	public function selectTotalUV(){
		$conn=parent::getConn(DB_DSN_SHOW);
 		$sql="SELECT COUNT(DISTINCT username) AS uv FROM sys_log WHERE  `event`='click' AND username NOT IN ('wangzhipeng','zhangchengtao','liuhao_17173','yuecui','liutiesong') AND createtime >= '2014-9-25 15:36';";
 		//echo $sql;
 		try{
 			$st=$conn->prepare($sql);
 			$st->execute();
 			$row=$st->fetchALL();
 			$conn=Null;
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}		
 		return $row[0][0];
	}
	/**
	 * 查询当日和昨日的PV / UV 
	 */
	 public function selectTodayVisit(){
		$conn=parent::getConn(DB_DSN_SHOW);
 		$sql="SELECT DATE_FORMAT(NOW(),'%Y/%m/%d') AS `time`,COUNT(id) AS pv,COUNT(DISTINCT username) AS uv FROM sys_log WHERE  `event`='click' AND username NOT IN ('wangzhipeng','zhangchengtao','liuhao_17173','yuecui','liutiesong') AND createtime >= DATE_FORMAT(NOW(),'%Y/%m/%d') UNION SELECT DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 DAY),'%Y/%m/%d') AS `time`,COUNT(id) AS pv,COUNT(DISTINCT username) AS uv FROM sys_log WHERE  `event`='click' AND username NOT IN ('wangzhipeng','zhangchengtao','liuhao_17173','yuecui','liutiesong') AND createtime >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 1 DAY),'%Y/%m/%d') AND createtime < DATE_FORMAT(NOW(),'%Y/%m/%d');";
 		try{
 			$st=$conn->prepare($sql);
 			$st->execute();
 			$row=$st->fetchALL();
 			$conn=Null;
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}		
 		return $row;
	}
	/**
	 * 查询7日pv量 
	 */
	 public function select7DayPv(){
		$conn=parent::getConn(DB_DSN_SHOW);
 		$sql="SELECT ur.username AS uname,ur.department AS ubumen,COUNT(sl.id) AS num FROM sys_log sl JOIN `user` ur ON sl.username = SUBSTRING_INDEX(ur.email,'@',1) WHERE  sl.`event`='click' AND sl.username NOT IN ('wangzhipeng','zhangchengtao','liuhao_17173','yuecui','liutiesong') AND sl.createtime >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 6 DAY),'%Y/%m/%d') GROUP BY uname,ubumen ORDER BY num DESC LIMIT 10;";
 		try{
 			$st=$conn->prepare($sql);
 			$st->execute();
 			$row=$st->fetchALL();
 			$conn=Null;
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}		
 		return $row;
	}
	 
}

//	$db = new DatacenterDB();
//	$row = $db->select7DayPv();
//	print_r($row);
?>
