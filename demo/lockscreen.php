<!DOCTYPE html>
<html lang="en"><head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Neon Admin Panel">
	<meta name="author" content="Laborator.co">
	
	<title>Neon | Lockscreen</title>
	

	<style>.file-input-wrapper { overflow: hidden; position: relative; cursor: pointer; z-index: 1; }
	.file-input-wrapper input[type=file], 
	.file-input-wrapper input[type=file]:focus, 
	.file-input-wrapper input[type=file]:hover { position: absolute; top: 0; left: 0; cursor: pointer; opacity: 0; filter: alpha(opacity=0); z-index: 99; outline: 0; }
	.file-input-name { margin-left: 8px; }
	</style>
	<link rel="stylesheet" href="js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css" id="style-resource-1">
	<link rel="css/font-icons/entypo/css/entypo.css" id="style-resource-2">
	<link rel="stylesheet" href="css/bootstrap-min.css" id="style-resource-4">
	<link rel="stylesheet" href="css/neon-core-min.css" id="style-resource-5">
	<link rel="stylesheet" href="css/neon-theme-min.css" id="style-resource-6">
	<link rel="stylesheet" href="css/neon-forms-min.css" id="style-resource-7">
	<link rel="stylesheet" href="css/custom-min.css" id="style-resource-8">

	</script><script src="js/jquery-1.11.0.min.js"></script>
	<script>$.noConflict();</script>

	<!--[if lt IE 9]><script src="http://demo.neontheme.com/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	
	<!-- TS1405151071: Neon - Responsive Admin Template created by Laborator -->
</head>
<body class="page-body loaded login-page is-lockscreen login-form-fall login-form-fall-init">

<div class="login-container">
	
	<div class="login-header">
		
		<div class="login-content">
			
			<a href="#" class="logo">
				<img src="images/logo@2x.png" alt="" width="200">
			</a>
			
			<p class="description">请输入您的密码!</p>
			
			<!-- progress bar indicator -->
			<div class="login-progressbar-indicator">
				<h3>0%</h3>
				<span>logging in...</span>
			</div>
		</div>
		
	</div>
	
	<div class="login-form">
		
		<div class="login-content">
			
			<form novalidate="novalidate" method="post" role="form" id="form_lockscreen">
				
				<div class="form-group lockscreen-input">
					
					<div class="lockscreen-thumb">
						<img src="images/dog.jpg" class="img-circle">
						
						<div class="lockscreen-progress-indicator">0%</div>
					<canvas height="150" width="150"></canvas></div>
					
					<div class="lockscreen-details">
						<h4>这是用户名</h4>
						<span data-login-text="logging in...">注销</span>
					</div>
					
				</div>
				
				<div class="form-group">
					
					<div class="input-group">
						<div class="input-group-addon">
							<i class="entypo-key"></i>
						</div>
						
						<input class="form-control" name="password" id="password" placeholder="Password" autocomplete="off" type="password">
					</div>
				
				</div>
				
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-block btn-login">
						<i class="entypo-login"></i>
						Login In
					</button>
				</div>
				
			</form>
			
			
			<div class="login-bottom-links">
				
				<a href="login.php" class="link">用其他用户登录...>> <i class="entypo-right-open"></i></a>
				
				<br>
				
				
				
			</div>
			
		</div>
		
	</div>
	
</div>


	<script src="js/gsap/main-gsap.js" id="script-resource-1"></script>
	<script src="js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
	<script src="js/bootstrap.js" id="script-resource-3"></script>
	<script src="js/joinable.js" id="script-resource-4"></script>
	<script src="js/resizeable.js" id="script-resource-5"></script>
	<script src="js/neon-api.js" id="script-resource-6"></script>
	<script src="js/cookies.min.js" id="script-resource-7"></script>
	<script src="js/jquery.validate.min.js" id="script-resource-8"></script>
	<script src="js/neon-login.js" id="script-resource-9"></script>
	<script src="js/neon-custom.js" id="script-resource-10"></script>
	<script src="js/neon-demo.js" id="script-resource-11"></script>
	<script src="js/neon-skins.js" id="script-resource-12"></script>
	
	

</body>
</html>