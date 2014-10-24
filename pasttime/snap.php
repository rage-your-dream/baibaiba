<?php
	echo "<span style='display:none'>";
	require "class.bean.Tools.php";
	try{
		$snap=new Snap();
	}catch(Exception $e){
 		echo "".$e->getMessage();
 	}
	$url=$_GET["u"]."?snap=sidebar-collapsed";
	$img_name=$_GET["img_name"];
	$snap->data=array("url"=>$url,"img_name"=>$img_name);
	$snap->snap_go();
	echo "</span>";	
	echo "<div id='snap_img'><img src='images/snap/{$img_name}.jpg' alt='' style='width:95%;'></div>";
?>
