<?php
session_start();
require_once "class.db.Log.php";
if(isset($_POST["action"])){
	if($_POST["action"]=="sliderlog"){//slider.php的点击事件记录
		$data['event']='click';
		$data['page']='slider.php';
		$data['description']=$_POST["description"];
		$data['username']=$_SESSION["email"];
		$data['ip']=getIP();
		$db=new LogDB();
		if($db->insertLog($data))
			echo "Y";
    	else
    		echo "N";
    }  
}

function getIP()
{
	global $ip;
	if (getenv("HTTP_CLIENT_IP"))
		$ip = getenv("HTTP_CLIENT_IP");
	else if(getenv("HTTP_X_FORWARDED_FOR"))
		$ip = getenv("HTTP_X_FORWARDED_FOR");
	else if(getenv("REMOTE_ADDR"))
		$ip = getenv("REMOTE_ADDR");
	else
		$ip = "Unknow";
	return $ip;
}
?>
