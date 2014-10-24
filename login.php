<?php 
session_start();

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

function processLogin(){
	/*if(isset($_GET["username"]) and $_GET["username"]=="guest"){
		$_SESSION["username"]="guest";
		$_SESSION["email"]="CY0000";
		header("Location:home.php");
	}*/
	if(isset($_POST["email"]) and isset($_POST["password"]) ){
		require_once "class.db.Utils.php";
		require_once "class.LDAP.php";
		require_once "class.MD5.php";
		require_once "class.db.Log.php";
		$ldap=new LDAP();
		$md5=new MD5();
		$email=$_POST["email"];
		if($email != ""){
			if(!strpos($email,"@cyou-inc.com")){
				$email=$email.'@cyou-inc.com';
			};
			if($_POST["password"]!=""){
				$usermsg="";
				$usermsg=$ldap->login($email,$_POST["password"]);
				if($usermsg)
				{
					$email = substr($_POST["email"],0,strpos($_POST["email"],"@"));
					$username = $usermsg["username"];
					$employee_id = $usermsg["employee_id"];
					$department = $usermsg["department"];
					$db=new UserDB();
					$user=$db->hasUser($_POST["email"]);			
					//如果数据库里修改了用户名则使用修改后的，否则使用num值
					if($user){		
						$username=$user["username"];
					}else{		
						$db->insertLDAP(array("email"=>$_POST["email"],"username"=>$username,"employee_id"=>$employee_id,"department"=>$department));
					}
					//保存session
					$_SESSION["username"]=$username;
					$_SESSION["email"]=$email;
					$_SESSION["password"]=$md5->string2secret($_POST["password"]);
					//保存cookie
					setcookie("email",     $_SESSION["email"], time()+3600*24*7);
					setcookie("username",  $_SESSION["username"], time()+3600*24*7);
					setcookie("password",  $_SESSION["password"], time()+3600*24*7);
					//记录登陆日志
					$data['event']='login';
					$data['page']='login.php';
					$data['description']='login success';
					$data['username']=$_SESSION["email"];
					$data['ip']=getIP();
					$db=new LogDB();
					$db->insertLog($data);
					
					header("Location: home.php");
				}else displayLoginForm("您输入的帐号或密码有误，请重试");
			}else displayLoginForm("密码不能为空");
		}else displayLoginForm("帐号不能为空");
	}else displayLoginForm("登陆失败，请稍后重试");
}
if(isset($_POST["login"]) or isset($_GET["login"])){
	processLogin();
}else{
	if(isset($_COOKIE["email"])&&isset($_COOKIE["password"])){
		$_SESSION["email"]=$_COOKIE["email"];
		$_SESSION["username"]=$_COOKIE["username"];
		$_SESSION["password"]=$_COOKIE["password"];
		header("Location: home.php");
	}
	
	displayLoginForm(Null);
}
function displayLoginForm($errorMsg){ 

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>质量管理平台</title>
	

	<style>.file-input-wrapper { overflow: hidden; position: relative; cursor: pointer; z-index: 1; }
	.file-input-wrapper input[type=file], .file-input-wrapper input[type=file]:focus, 
	.file-input-wrapper input[type=file]:hover { position: absolute; top: 0; left: 0; cursor: pointer; opacity: 0; filter: alpha(opacity=0); z-index: 99; outline: 0; }
	.file-input-name { margin-left: 8px; }
	#modal{
		modal
		z-index:1000;
	}
	</style>
	<link rel="stylesheet" href="js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css" id="style-resource-1">
	<link rel="stylesheet" href="css/font-icons/entypo/css/entypo.css" id="style-resource-2">
	<link rel="stylesheet" href="css/bootstrap-min.css" id="style-resource-4">
	<link rel="stylesheet" href="css/neon-core-min.css" id="style-resource-5">
	<link rel="stylesheet" href="css/neon-theme-min.css" id="style-resource-6">
	<script type=text/javascript src="js/jquery-1.8.3.min.js"></script>
	<!--判断浏览器类型和版本 不兼容IE678-->
    <script type="text/javascript">
    $(function () {
    var Sys = {};
    var ua = navigator.userAgent.toLowerCase();
    var s;
	(s = ua.match(/rv:([\d.]+)\) like gecko/)) ? Sys.ie = s[1] :
	(s = ua.match(/msie ([\d.]+)/)) ? Sys.ie = s[1] :
	(s = ua.match(/firefox\/([\d.]+)/)) ? Sys.firefox = s[1] :
	(s = ua.match(/chrome\/([\d.]+)/)) ? Sys.chrome = s[1] :
	(s = ua.match(/opera.([\d.]+)/)) ? Sys.opera = s[1] :
	(s = ua.match(/version\/([\d.]+).*safari/)) ? Sys.safari = s[1] : 0;
		if (Sys.ie){
			if(parseInt(Sys.ie)<10){
				document.getElementById("email").disabled=true;
				document.getElementById("password").disabled=true;
				document.getElementById("login").disabled=true;
				document.getElementById('browser_check').setAttribute("class", "form-login-error show");
            };
		};
//		if (Sys.firefox){
//			alert('Firefox: ' + Sys.firefox);
//		};
//		if (Sys.chrome){
//			alert('Chrome: ' + Sys.chrome);
//		};
//		if (Sys.opera){
//			alert('Opera: ' + Sys.opera);
//		};
//		if (Sys.safari){
//			alert('Safari: ' + Sys.safari);
//            }; 
	});
    </script>
 
</head>
<body class="page-body login-page login-form-fall loaded login-form-fall-init">
	<div class="login-container">
	
	<div class="login-header login-caret">
		
		<div align="center">
			
			<!--a href="" class="logo">
				<img src="images/logo@2x.png" alt="" width="600">
			</a-->
			<h1 style="color:#FFFFFF;font-size:58px;font-family:YouYuan;font-weight:900;">集成质量管理平台</h1>
			<!-- progress bar indicator -->
			<div class="login-progressbar-indicator">
				<h3>0%</h3>
				<span>登录...</span>
			</div>
		</div>
		
	</div>
	
	<div class="login-progressbar">
		<div></div>
	</div>
	
	<div class="login-form">

		<p class="description" align="center">欢迎访问我们的平台，别忘了给个好评！</p>
		<div class="login-content">
			<?php if($errorMsg) { ?>
			<div class="form-login-error show">
				<h3>登录失败</h3>
				<p> <strong><?php echo $errorMsg ?></strong></p>
			</div>
			<?php } ?>
			<form action="login.php" method="post" role="form" id="form_login" accept-charset="utf-8">
				<input name="login"  type="hidden" value="login">
				<div class="form-group">
					
					<div class="input-group">
						<div class="input-group-addon">
							<i class="entypo-user"></i>
						</div>
						
						<input class="form-control" name="email" id="email" placeholder="" autocomplete="on" type="text" value="">
						<span style="position:absolute;color:#b6b6b6;width:105px;line-height:45px;right:0;top:0">@cyou-inc.com</span>
					</div>
					
				</div>
				
				<div class="form-group">
					
					<div class="input-group">
						<div class="input-group-addon">
							<i class="entypo-key"></i>
						</div>
						
						<input class="form-control" name="password" id="password" placeholder="" autocomplete="off" type="password">
					</div>
				
				</div>
				<br/><br/>
				<div id="browser_check" class="form-login-error">
					<p> <strong>亲~~ IE9及以下浏览器体验效果不好噢</strong><br/>赶快换 Chrome FireFox Opera IE11 IE10 ... 试试吧</p>
				</div>
				<div class="form-group">
					<button id="login" type="submit" class="btn btn-info btn-default btn-block btn-login">
						<i class="entypo-login"></i>
						登录
					</button>
				</div>
				
				<!--<div class="form-group">
					<em>- or -</em>
				</div-->
				
				<!--div class="form-group">
					<a href="login.php?login=login&username=guest">	
					以guest身份登录	
					<i class="entypo-user"></i>		
					</a>	
				</div-->
				
								
			</form>
			
			
			<div class="login-bottom-links">
				
				<!--a href="" class="link">Forgot your password?</a-->
				<br><br>
				<a href="" class="description">design by 互联卓越运作中心&质量管理部</a><br>
				
			</div>
			
		</div>
		
	</div>
	
</div>
<script>
	document.getElementById("email").focus();
</script>
</body>	
<?php
} 
?>
