<?php
session_start();
require_once "class.db.Panel.php";
require_once "class.db.Chart.php";
if(isset($_GET["action"])){
	if($_GET["action"]=="update_size"){
		//跟新图表panel的size
		$id=$_GET["panel_id"];
		$width=$_GET["width"];		
		$db=new PanelDB();
		if($db->updatePanelSize($width,$id)){
			echo "Y";
		}else{
			echo "N";
		}
	}else if($_GET["action"]=="update_location"){
		//跟新图表panel的位置
		$id=$_GET["panel_id"];
		$d=array();
		$d["x"] =$_GET["x"];
		$d["y"] =$_GET["y"];
		$d["page_width"] =$_GET["page_width"];
		$d["page_height"] =$_GET["page_height"];
		$db=new PanelDB();
		if($db->updatePanelLocation($d,$id)){
			echo "Y";
		}else{
			echo "N";
		}
	}else if($_GET["action"]=="update_anaylsis_show"){
		//跟新图表panel的位置
		$id=$_GET["panel_id"];
		$isshow=$_GET["is_analysis_show"];
		$db=new PanelDB();
		if($db->updatePanelAnalysisShow($id,$isshow)){
			echo "Y";
		}else{
			echo "N";
		}
	}else if($_GET["action"]=="update_lock_status"){
		//跟新图表panel的位置
		$id=$_GET["panel_id"];
		$islock=$_GET["lock"];
		$db=new PanelDB();
		if($db->updatePaneltDataLock($id,$islock)){
			echo "Y";
		}else{
			echo "N";
		}
	}else if($_GET["action"]=="update_praise"){
		//点赞
		$panel_id=$_GET["panel_id"];
		$praise=$_GET["praise"];
		$username=$_SESSION["email"];
		$db=new PanelDB();
		if($praise == 1){
			if($db->insertPraise($username,$panel_id,$praise)){
				echo "Y";
			}else{
				echo "N";
			}
		}else if($praise == 0){
			if($db->updatePraise($username,$panel_id,$praise)){
				echo "Y";
			}else{
				echo "N";
			}
		}else{
			echo "N";
		}
	}
}
?>
