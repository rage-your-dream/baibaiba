<?php
#表盘编辑权限 001
define("BOARD_EDIT","001");
#创建图表权限
define("BOARD_CREATE_CHART","000");
require_once "class.db.Permission.php";
class Permission{
	function checkPermission($rule,$email){
		$db=new PermissionDB();
		$rows=$db->selectPermissionDB($email);
		foreach($rows as $row){
			if($row["rule"]==$rule) return true;
		}
		return false;
	}
	function checkBoardEditPermission($board_id,$email_prefix){
		return $this->checkPermission(BOARD_EDIT."_".$board_id,$email_prefix);
	}
	function checkBoardCreateChart($board_id,$email_prefix){
		return $this->checkPermission(BOARD_CREATE_CHART."_".$board_id,$email_prefix);
	}
}
//$p=new Permission();
//echo $p->checkBoardEditPermission(2,"zhangchengtao133");
?>
