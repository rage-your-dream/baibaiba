<?php
session_start();
require_once "checkstatus.php";
require_once "class.MD5.php";
require_once "config_visible.php";
function getHttpStatusCode($url){
	$curl = curl_init();
	curl_setopt($curl,CURLOPT_URL,$url);//获取内容url
	curl_setopt($curl,CURLOPT_HEADER,1);//获取http头信息
	curl_setopt($curl,CURLOPT_NOBODY,1);//不返回html的body信息
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);//返回数据流，不直接输出
	curl_setopt($curl,CURLOPT_TIMEOUT,30); //超时时长，单位秒
	curl_exec($curl);
	$rtn= curl_getinfo($curl,CURLINFO_HTTP_CODE);
	curl_close($curl);
	return  $rtn;
}
function postForm($url){
	if(getHttpStatusCode($url)==200){
		$md5=new MD5();
		?>
		<meta charset="utf-8">
		跳转中，请稍等。。。
		<form name="loginform" method="POST" action='<?php echo $url;?>' class="aui login-form-container">                                     
		    <input name="os_username" id="os_username" value="<?php echo $_SESSION["email"]?>" type="hidden">      
		    <input name="os_password" id="os_password" value="<?php echo $md5->secret2string($_SESSION["password"])?>" type="password" style="display:none;">                 
		    <input id="loginButton" class="aui-button aui-style aui-button-primary" name="login" value="登录" type="submit" style="display:none;">                                                         
		    <input name="os_destination" value="" type="hidden">                                      
		</form>
		<?php 
	}else{
		header("Location: 404page.php");
	}
}
if(isset($_GET["target"])){
	if($_GET["target"]=="mobo_confluence"){	//confluence跳转
		postForm(URL_MOBO_CONFLUENCE);
	}elseif($_GET["target"]=="mobo_jira"){//jira跳转
		postForm(URL_MOBO_JIRA);
	}elseif($_GET["target"]=="mobo_testlink"){//testlink跳转
		postForm(URL_MOBO_TESTLINK);
	}elseif($_GET["target"]=="mobo_jenkins"){//jenkins跳转
		postForm(URL_MOBO_JINKENS);
	}elseif($_GET["target"]=="mobo_scanapps"){//scanapps跳转
		postForm(URL_MOBO_SACNAPPS);
	}
	else
		header("Location: home.php");
}else
	header("Location: 404page.php"); 
?>
<script>
window.onload=function(){document.loginform.submit();}
</script>

