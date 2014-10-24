<?php
session_start();
require_once "checkstatus.php";
require_once "class.MD5.php";
require_once "config_visible.php";
function postForm($url){
	$md5=new MD5();
	?>
	<meta charset="utf-8">
	管理员登陆，请勿泄漏！！！
	<form name="loginform" method="POST" action='<?php echo $url;?>' class="aui login-form-container">                                     
	    用户名<input name="os_username" id="os_username" value="admin" type="text">      
	    密码<input name="os_password" id="os_password" value="" type="password" style="">                 
	    <input id="loginButton" class="aui-button aui-style aui-button-primary" name="login" value="登录" type="submit" style="">                                                         
	    <input name="os_destination" value="" type="hidden">                                      
	</form>
	<?php 
}

	if(isset($_GET["target"])){
		if($_GET["target"]=="mobo_confluence"){	
			postForm(URL_MOBO_CONFLUENCE);
		}else
			header("Location: home.php");
 	}else
		header("Location: 404page.php"); 
?>


