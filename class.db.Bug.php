<?php
require_once "class.DBConn.php";
require_once "config.php";
class BugDB extends DBConn{
	
	/**
	 * 查询上周新增和未关闭BUG
	 * LW lastweek
	 */
	public function selectBugLW(){
		$conn=parent::getConn(DB_DSN_REDMINE);
		$w=date('w')-1;
// 		$sql="SELECT a.ProjectName AS `name`,COUNT(a.ProjectName) AS `count1`,b.`count2`FROM bug a LEFT JOIN (SELECT ProjectName AS `name`,COUNT(ProjectName) AS `count2` FROM bug WHERE StatusId IN(1,2,9,22) AND CreateTime > SUBDATE(CURDATE(),DATE_FORMAT(CURDATE(),'%w')-1) GROUP BY ProjectName)b ON a.ProjectName = b.`name` WHERE  a.CreateTime > SUBDATE(CURDATE(),DATE_FORMAT(CURDATE(),'%w')-1) GROUP BY a.ProjectName;";
 		$sql="CALL selectWeekBugTable();";
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
	 * 查询上周新增BUG
	 * LW lastweek
	 */
	public function selectNewBugLW(){
		$conn=parent::getConn(DB_DSN_REDMINE);
 		$sql="CALL selectNewBugLW();";
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
 		return $row;
	}
	
	/**
	 * 查询上周遗留BUG 经过修改调整为本周，sql语句也做了变动
	 * LW lastweek
	 */
	//select   ProjectName,count(ProjectName) from bug where  DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= date(CreateTime)  and (StatusId='1' or StatusId='2' or StatusId='9')  group by ProjectName;
	public function selectLeaveBugLW(){
		$conn=parent::getConn(DB_DSN_REDMINE);
 		$sql="CALL selectLeaveBugLW();";
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
 		return $row;
	}
	/**
	 * 按周查询开放BUG
	 */
	//select week(CreateTime,3),count(*) from bug where year(CreateTime)='2014' and (StatusId =  '1' OR bug.StatusId =  '2' OR bug.StatusId =  '9') group by week(CreateTime,3)
	public function selectOpenBugByWeek(){
		$conn=parent::getConn(DB_DSN_PMS);
 		$sql="SELECT projectname AS week_num,COUNT(bugid) AS `count` FROM bug WHERE createtime > '2014-01-01' AND statusid IN (1,2,5,8,9,22) GROUP BY projectname ORDER BY `count` DESC limit 21;";
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
 		return $row;
	}
	/**
	 * 查询个项目开放BUG
	 */
	//select   ProjectName,count(ProjectName) from bug where StatusId='1' or StatusId='2' or StatusId='9' group by ProjectName;
	public function selectOpenBug(){
		$conn=parent::getConn(DB_DSN_PMS);
 		$sql="select ProjectName as name,count(ProjectName) as count from bug where StatusId='1' or StatusId='2' or StatusId='9'or StatusId='22' group by ProjectName order by count DESC;";
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
 		return $row;
	}
	/**
	 * 查询个项目关闭BUG
	 */
	//select   ProjectName,count(ProjectName) from bug where StatusId='5' or StatusId='8'  group by ProjectName;
	public function selectClosedBug(){
		$conn=parent::getConn(DB_DSN_PMS);
 		$sql="select ProjectName as name,count(ProjectName) as count from bug where StatusId='5' or StatusId='8'  group by ProjectName;";
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
 		return $row;
	}
	
	/**
	 * 查询本周新增bug（按照星期日期,项目）
	 */
	//select   ProjectName,count(ProjectName) from bug where StatusId='1' or StatusId='2' or StatusId='9' group by ProjectName;
	public function selectWeekBugTrend(){
		$conn=parent::getConn(DB_DSN_REDMINE);
 		$sql="CALL selectWeekBugTrend();";
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
 		return $row;
	}
	
	/**
	 * 查询本周新增bug（按照状态,指派）
	 */
	//select   ProjectName,count(ProjectName) from bug where StatusId='1' or StatusId='2' or StatusId='9' group by ProjectName;
	public function selectWeekBugDistributeDim1(){
		$conn=parent::getConn(DB_DSN_REDMINE);
 		$sql="CALL selectWeekBugDistributeDim1();";
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
 		return $row;
	}
	
	public function selectWeekBugDistributeDim2(){
		$conn=parent::getConn(DB_DSN_REDMINE);
 		$sql="CALL selectWeekBugDistributeDim2();";
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
 		return $row;
	}
	
	/*
	 * 查询本周发现缺陷总数
	 */
	public function selectWeekTotalBug(){
		$conn=parent::getConn(DB_DSN_REDMINE);
 		$sql="CALL selectWeekTotalBug();";
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
	
}

//$db=new BugDB();
//$r=$db->selectWeekBugDistributeDim1();
//print_r($r);
?>
