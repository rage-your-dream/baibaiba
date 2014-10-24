<?php
require_once "class.DBConn.php";
require_once "config.php";
class MoboDB extends DBConn{
	/**
	 * 查询已关闭和未关闭的BUG数
	 */
	public function selectBugOandC1(){
		$conn=parent::getConn(DB_DSN_MOBO_JIRA,DB_MOBO_JIRA_USERNAME,DB_MOBO_JIRA_PASSWORD);
 		$sql='SELECT CASE issuestatus WHEN 6 THEN "关闭" ELSE "未关闭" END AS `name`,COUNT(ID) AS `y`,' .
 				'CASE issuestatus WHEN 6 THEN "#6A9AC2" ELSE "#66BA7C " END AS `color` FROM jiraissue ji WHERE ' .
 				'project IN (10100) GROUP BY `name` ORDER BY issuestatus DESC;';
 		try{
 			$st=$conn->prepare($sql);
 			$st->execute();
 			$row=$st->fetchAll();
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}		
 		return $row;
	}
	/**
	 * 查询已关闭和未关闭的BUG数
	 */
	public function selectBugOandC2(){
		$conn=parent::getConn(DB_DSN_MOBO_JIRA,DB_MOBO_JIRA_USERNAME,DB_MOBO_JIRA_PASSWORD);
 		$sql=" SELECT CONCAT('当前版本(',(SELECT vname FROM projectversion WHERE project = 10100 AND DESCRIPTION NOT LIKE '%not begin%' ORDER BY vname DESC LIMIT 1),') ') AS `name`,COUNT(ji.id) AS `y`,'#6A9AC2' AS `color` FROM jiraissue ji  INNER JOIN nodeassociation nn ON ji.id = nn.SOURCE_NODE_ID INNER JOIN projectversion pn ON pn.id = nn.SINK_NODE_ID WHERE ji.project IN (10100) AND nn.ASSOCIATION_TYPE='IssueVersion' AND ji.issuestatus = 6 AND pn.vname = (SELECT vname FROM projectversion WHERE project = 10100 AND DESCRIPTION NOT LIKE '%not begin%' ORDER BY vname DESC LIMIT 1) UNION  SELECT '历史版本' AS `name`, (SELECT COUNT(ID) FROM jiraissue ji WHERE project IN (10100) AND ji.issuestatus = 6 ) - ( SELECT COUNT(ji.id) AS `y` FROM jiraissue ji  INNER JOIN nodeassociation nn ON ji.id = nn.SOURCE_NODE_ID INNER JOIN projectversion pn ON pn.id = nn.SINK_NODE_ID WHERE ji.project IN (10100) AND nn.ASSOCIATION_TYPE='IssueVersion' AND ji.issuestatus = 6 AND pn.vname = (SELECT vname FROM projectversion WHERE project = 10100 AND DESCRIPTION NOT LIKE '%not begin%' ORDER BY vname DESC LIMIT 1) )AS `y`,'#6A9AC2' AS `color` UNION  SELECT CONCAT('当前版本(',(SELECT vname FROM projectversion WHERE project = 10100 AND DESCRIPTION NOT LIKE '%not begin%' ORDER BY vname DESC LIMIT 1),') ') AS `name`,COUNT(ji.id) AS `y`,'#66BA7C ' AS `color` FROM jiraissue ji  INNER JOIN nodeassociation nn ON ji.id = nn.SOURCE_NODE_ID INNER JOIN projectversion pn ON pn.id = nn.SINK_NODE_ID WHERE ji.project IN (10100) AND nn.ASSOCIATION_TYPE='IssueVersion' AND ji.issuestatus != 6 AND pn.vname = (SELECT vname FROM projectversion WHERE project = 10100 AND DESCRIPTION NOT LIKE '%not begin%' ORDER BY vname DESC LIMIT 1) UNION  SELECT '历史版本' AS `name`, (SELECT COUNT(ID) FROM jiraissue ji WHERE project IN (10100) AND ji.issuestatus != 6 ) - ( SELECT COUNT(ji.id) AS `y` FROM jiraissue ji  INNER JOIN nodeassociation nn ON ji.id = nn.SOURCE_NODE_ID INNER JOIN projectversion pn ON pn.id = nn.SINK_NODE_ID WHERE ji.project IN (10100) AND nn.ASSOCIATION_TYPE='IssueVersion' AND ji.issuestatus != 6 AND pn.vname = (SELECT vname FROM projectversion WHERE project = 10100 AND DESCRIPTION NOT LIKE '%not begin%' ORDER BY vname DESC LIMIT 1) )AS `y`,'#66BA7C ' AS `color`  ;"; 
 		try{
 			$st=$conn->prepare($sql);
 			$st->execute();
 			$row=$st->fetchAll();
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}		
 		return $row;
	}
	/**
	 * 查询未关闭缺陷
	 */
	public function selectOpenBug(){
		$conn=parent::getConn(DB_DSN_MOBO_JIRA,DB_MOBO_JIRA_USERNAME,DB_MOBO_JIRA_PASSWORD);
 		$sql="SELECT pv.vname AS `version`, RIGHT(cv.STRINGVALUE, 1) p, SUM(CASE ji.issuestatus WHEN 5 THEN 0.1 ELSE 1 END) AS num FROM jiraissue ji JOIN nodeassociation nn ON ji.id = nn.SOURCE_NODE_ID JOIN projectversion pv ON pv.id = nn.SINK_NODE_ID JOIN customfieldvalue cv ON cv.ISSUE = ji.ID WHERE ji.project IN (10100) AND pv.PROJECT IN (10100) AND nn.SINK_NODE_ENTITY = 'Version' AND nn.ASSOCIATION_TYPE = 'IssueVersion' AND ji.issuetype = 1 AND ji.issuestatus NOT IN (6) AND cv.CUSTOMFIELD = 10047 GROUP BY `version`, p ORDER BY `version`, p ;"; 
 		try{
 			$st=$conn->prepare($sql);
 			$st->execute();
 			$row=$st->fetchAll(); //MYSQL_NUM MYSQL_BOTH MYSQL_ASSOC
 			//print_r($row);
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}		
 		return $row;
	}
	
	/**
	 * 查询每个人身上的BUG情况
	 */
	public function selectBugEveryOne(){
		$conn=parent::getConn(DB_DSN_MOBO_JIRA,DB_MOBO_JIRA_USERNAME,DB_MOBO_JIRA_PASSWORD);
		$sql="SELECT ";
		$sql.="cu.display_name AS `name`,ji.issuestatus AS `status`,COUNT(ji.ID) AS `value` " ;
		$sql.="FROM jiraissue ji " ;
		$sql.="JOIN nodeassociation nn ON ji.id = nn.SOURCE_NODE_ID  " ;
		$sql.="JOIN projectversion pn ON pn.id = nn.SINK_NODE_ID  " ;
		$sql.="JOIN cwd_user cu ON ji.assignee = cu.user_name  " ;
		$sql.="WHERE ji.project IN (10100) AND ji.issuetype = 1 AND nn.ASSOCIATION_TYPE='IssueVersion' AND pn.vname = (SELECT vname FROM projectversion WHERE project = 10100 AND DESCRIPTION NOT LIKE '%not begin%' ORDER BY vname DESC LIMIT 1) " ;
		$sql.="GROUP BY cu.display_name,ji.issuestatus " ;
		$sql.="ORDER BY cu.display_name,ji.issuestatus " ;
		
 		try{
 			$st=$conn->prepare($sql);
 			$st->execute();
 			$row=$st->fetchAll();
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}		
 		return $row;
	}
	/**
	 * 查询每个人身上的BUG情况
	 */
	public function selectTaskDistribution(){
		$conn=parent::getConn(DB_DSN_MOBO_JIRA,DB_MOBO_JIRA_USERNAME,DB_MOBO_JIRA_PASSWORD);
		$sql="SELECT ";
		$sql.="pv.vname AS `version`,`is`.pname AS `status`,cu.display_name AS `assign`,ji.summary AS `sub` ";
		$sql.="FROM jiraissue ji ";
		$sql.="JOIN customfieldvalue cv ON ji.id = cv.issue ";
		$sql.="JOIN projectversion pv ON cv.NUMBERVALUE = pv.id ";
		$sql.="JOIN issuestatus `is` ON ji.issuestatus = `is`.id ";
		$sql.="LEFT JOIN cwd_user cu ON ji.assignee= cu.user_name ";
		$sql.="WHERE ji.issuetype IN(3,5) AND ji.project IN (10120) AND cv.customfield = 10029 ";
		$sql.="ORDER BY `version`,`status`,`assign` ";
 		try{
 			$st=$conn->prepare($sql);
 			$st->execute();
 			$row=$st->fetchAll();
 		}catch(PDOException $e){
 			echo "failure:".$e->getMessage();
 			return false;
 		}		
 		return $row;
	}
	/**
	 * 各版本BUG清除率
	 */
	public function selectDefectRemovalRate(){
		$conn=parent::getConn(DB_DSN_MOBO_JIRA,DB_MOBO_JIRA_USERNAME,DB_MOBO_JIRA_PASSWORD);
		$sql ="SELECT "; 
  		$sql.="pv.vname AS `version`, ";
  		$sql.="SUM(CASE ji.issuestatus WHEN 6 THEN 1 WHEN 5 THEN 0.9 END)/COUNT(ji.id)*100 AS `rate` ";
		$sql.="FROM ";
  		$sql.="jiraissue ji ";
  		$sql.="JOIN ";
  		$sql.="nodeassociation nn ";
  		$sql.="ON ji.id = nn.SOURCE_NODE_ID ";
  		$sql.="JOIN ";
  		$sql.="projectversion pv ";
  		$sql.="ON pv.id = nn.SINK_NODE_ID ";
		$sql.="WHERE ji.project IN (10100) ";
  		$sql.="AND pv.PROJECT IN (10100) ";
  		$sql.="AND nn.SINK_NODE_ENTITY = 'Version' ";
  		$sql.="AND nn.ASSOCIATION_TYPE = 'IssueVersion' ";
  		$sql.="AND ji.issuetype = 1 ";
		$sql.="GROUP BY `version` ";
		$sql.="ORDER BY `version` ";
		try{
 			$st=$conn->prepare($sql);
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
