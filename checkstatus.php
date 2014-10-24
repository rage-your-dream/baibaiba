<?php
require_once "config.php";
if(!isset($_SESSION["username"]) ){
	//echo $_SERVER["REMOTE_ADDR"];
	if($_SERVER["REMOTE_ADDR"]=="127.0.0.1"||Localhost==$_SERVER["REMOTE_ADDR"]){
		$_SESSION["username"]="Localhost";
		$_SESSION["email"]="Localhost";
		return;
	}
	if(isset($_COOKIE[session_name()])){
		setCookie(session_name(),"",time-3600,"/");
	}
	$_SESSION=array();
	session_destroy();	
	header("Location: login.php");
}
?>
