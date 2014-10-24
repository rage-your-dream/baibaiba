<?php
require_once "class.db.Channel.php";
function formatTailNum($num){
	if($num>9999) echo "尾号越界";
	$num=str_pad($num,"4","0",STR_PAD_LEFT);
	return $num;
}

if($_GET["action"]=="add"){
	$data=array();
	$data["channel_name"]=$_POST["channel_name"];
	$data["bd"]=$_POST["bd"];
	$data["promotion_number"]=$_POST["promotion_team"];
	$data["payment_number"]=$_POST["payment_method"];
	$data["cooperation_number"]=$_POST["cooperation_mode"];
	$data["version_number"]=$_POST["version_type"];
	$data["has_sdk"]=$_POST["has_sdk"];
	$data["description"]=$_POST["description"];
	
	$db=new ChannelDB();
	$channelNum=$db->existsChannelName(0,$data["channel_name"]);
	if($channelNum["num"] == 0){
		$num=$db->selectMixTailNum($data)+1;
		$num= formatTailNum($num);
		$data["tail_number"]=$num."";
		$data["channel_number"]=$data["promotion_number"].$data["payment_number"].$data["cooperation_number"].$data["version_number"].$data["tail_number"];
		echo $db->insertChannel($data);
	}else{
		echo 2;
	};
}
else if($_GET["action"]=="update"){
	$data=array();
	$id=$_POST["id"];
	$data["channel_name"]=$_POST["channel_name"];
	$data["bd"]=$_POST["bd"];
	$data["has_sdk"]=$_POST["has_sdk"];
	$data["description"]=$_POST["description"];
	$db=new ChannelDB();
	$channelNum=$db->existsChannelName($id,$data["channel_name"]);
	if($channelNum["num"] == 0){
		echo $db->updateOneChannelNumber($id,$data);
	}else{
		echo 2;
	};
	
}
else if($_GET["action"]=="select"){
	$rule="";
	if(isset($_POST["channel_number"])&&$_POST["channel_number"]!="")
		$rule.=" and c.channel_number like '%{$_POST["channel_number"]}%' ";
	if(isset($_POST["channel_name"])&&$_POST["channel_name"]!="")
		$rule.=" and c.channel_name like '%{$_POST["channel_name"]}%' ";
	if(isset($_POST["bd"])&&$_POST["bd"]!="")
		$rule.=" and c.bd like '%{$_POST["bd"]}%' ";
	if(isset($_POST["promotion_team"])&&$_POST["promotion_team"]!="")
		$rule.=" and c.promotion_number= '{$_POST["promotion_team"]}'";
	if(isset($_POST["payment_method"])&&$_POST["payment_method"]!="")
		$rule.=" and c.payment_number='{$_POST["payment_method"]}' ";
	if(isset($_POST["cooperation_mode"])&&$_POST["cooperation_mode"]!="")
		$rule.=" and c.cooperation_number= '{$_POST["cooperation_mode"]}'";
	if(isset($_POST["version_type"])&&$_POST["version_type"]!="")
		$rule.=" and c.version_number= '{$_POST["version_type"]}'";
	if(isset($_POST["has_sdk"])&&$_POST["has_sdk"]!="")
		$rule.=" and c.has_sdk= '{$_POST["has_sdk"]}'";
	
	$db=new ChannelDB();
	$rows=$db->selectChannelNumbers($rule);
	$datas = array();
	$data = array();
	foreach($rows as $row){
		for($i=1;$i<12;$i++){ 
			$data[$i-1]=$row[$i];
		}
		$data[11]="<a class='btn btn-default btn-sm btn-icon icon-left' href='update.php?id={$row[0]}'><i class='entypo-pencil'></i><b>修改</b></a>";
		array_push($datas,$data);
	}
	echo json_encode($datas);
}
?>
