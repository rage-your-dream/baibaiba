<!DOCTYPE HTML>
<html lang="en">
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
	<style>
	body {
		overflow: hidden;
		background-color: #999999;
		user-select: none;
		-webkit-user-select: none;
		-moz-user-select: none;
		-o-user-select: none;
		-ms-user-select: none;

	}
	#burn_gragh { 
		border:1px solid #CC0000;
		position: relative; 
		z-index: -1; 
	}
	#div_canvas{
		z-index: -2; 
	}
	</style>
	<script type=text/javascript src="js/jquery-1.11.0.min.js"></script>
	
	<script>$.noConflict();</script>
</head>
<?php
 echo '<body class="page-body loaded" > <div class="page-container">' ;
 //slider menu
 require_once "slider.php";
 echo "<div style='min-height: 1442px;' class='main-content'>";
 echo "<div class='div_canvas'><canvas  id='canvas' width='800' height='600'></canvas></div>";
 echo "</div></div>";
?>

<!--script src="js/ball/protoclass.js"></script>
<script src='js/ball/box2d.js'></script>
<script src='js/ball/Main.js'></script-->

<script src="js/gsap/main-gsap.js"></script>
<script src="js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/joinable.js"></script>
<script src="js/resizeable.js"></script>
<script src="js/neon-api.js"></script> 
<script src="js/neon-custom.js"></script>

<script>
function draw(){
	var canvas=document.getElementById("burn_gragh");
	var context=canvas.getContext("2d");
	context.moveTo(30,40);
	context.beginPath();
	context.lineTo(60,70);
	context.strokeStyle="#eee";
	context.stroke();
	context.closePath();
};
//$(function(){
	draw();
//});

</script>
</body>
</html>