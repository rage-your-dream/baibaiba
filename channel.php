<?php
session_start();
require_once "checkstatus.php";
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>质量部</title>
	

	<link rel="stylesheet" href="js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css" id="style-resource-1">
	<link rel="stylesheet" href="css/font-icons/entypo/css/entypo.css" id="style-resource-2">
	<link rel="stylesheet" href="css/bootstrap-min.css" id="style-resource-4">
	<link rel="stylesheet" href="css/neon-core-min.css" id="style-resource-5">
	<link rel="stylesheet" href="css/neon-theme-min.css" id="style-resource-6">
	<link rel="stylesheet" href="css/neon-forms-min.css" id="style-resource-7">
	<link rel="stylesheet" href="css/custom-min.css" id="style-resource-8">
	<script type=text/javascript src="js/jquery-2.1.0.min.js"></script>
 
</head>
<body class="page-body loaded" >
<div class="page-container ">
	<?php require_once "slider.php"; ?>
	<div style="min-height: 1442px;" class="main-content">
<?php require_once "titlerow.php";?>
<div class="row">
    <div class="col-sm-12" align="center">
    	<iframe id="frame_content" framespacng="0" frameborder="0" scrolling="no" width="1300px"  src="AppCNumCreate/index.php"></iframe>
    	
	</div>
</div>





<script type="text/javascript">
function reinitIframe(){
var iframe = document.getElementById("frame_content");
try{
iframe.height =  iframe.contentWindow.document.documentElement.scrollHeight;
}catch (ex){}
}
window.setInterval("reinitIframe()", 200);
</script>


<script src="js/highcharts.js"></script>
<script src="js/gsap/main-gsap.js"></script>
<script src="js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
<script src="js/bootstrap.js"></script>

<script src="js/joinable.js" id="script-resource-4"></script>
<script src="js/resizeable.js"></script>  
<script src="js/neon-api.js" id="script-resource-6"></script>

<script src="js/neon-custom.js" id="script-resource-3"></script>
<script src="js/neon-demo.js" id="script-resource-11"></script>
</body>
