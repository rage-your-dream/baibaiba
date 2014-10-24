<?php
session_start();
require_once "class.bean.Tools.php";
require_once "config_visible.php";
if($_GET["action"]=="snap"){
	#echo "<span style='display:none'>";
	
	$url=$_POST["u"];
	if(strpos($url,"#")>0){
		$url=substr($url,0,strlen($url)-1);
	}
	if(strpos($url,"&")>0){
		$url=explode("&",$url);
		$url=$url[0];
	}
	$img_path=SNAP_DIR_PATH.$_SESSION["email"].".jpg";
	//echo $url;
	Snap::takeSnap($url,$img_path);
	#echo "</span>";	
	echo "<img src='{$img_path}' alt='' style='width:95%;'>";
}
	

?>
