<?php
session_start();
	$_SESSION=array();
	session_destroy();
	unset($_SESSION["num"]);
	unset($_SESSION["name"]);
	unset($_SESSION["id"]);
	session_write_close();
	setcookie("num",  	   "", time()-3600,"","",false,true);
	setcookie("username",  "", time()-3600,"","",false,true);
	setcookie("password",  "", time()-3600,"","",false,true);
	header("Location:login.php");

?>
