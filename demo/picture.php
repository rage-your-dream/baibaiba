<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>质量部</title>
	

	<style>
	.album{
		border:1px solid #CCCCCC;
		margin:20px;
		border-radius: 3px;
	}
	.album img{
        max-height:280px;
    }
	.album-info{
		padding:0px 5px;
	}
	.album-footer{
		padding:5px 0px;
		border-top:1px solid #cccccc;
	}
	.album-options{
		border-left:1px solid #cccccc;
	}
	
	</style>
	<link rel="stylesheet" href="js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css" id="style-resource-1">
	<link rel="stylesheet" href="css/font-icons/entypo/css/entypo.css" id="style-resource-2">
	<link rel="stylesheet" href="css/bootstrap-min.css" id="style-resource-4">
	<link rel="stylesheet" href="css/neon-core-min.css" id="style-resource-5">
	<link rel="stylesheet" href="css/neon-theme-min.css" id="style-resource-6">
	<link rel="stylesheet" href="css/neon-forms-min.css" id="style-resource-7">
	<link rel="stylesheet" href="css/custom-min.css" id="style-resource-8">
	<link rel="stylesheet" href="css/mycss/scrum.css" id="style-resource-11">
	
	<script type=text/javascript src="js/jquery-2.1.0.min.js"></script>
 
</head>
<body class="page-body loaded" >
<div class="page-container" style="min-height:1442px;" >
	<?php require_once "slider.php"; ?>
	<div style="min-height:1442px;" class="main-content">
	<?php require_once "titlerow.php"; ?>
	<div class="row">
		<form action="uploadfile.php" method="post" enctype="multipart/form-data" id="fileup">
			<input type="file" name="picupload" id="pic_up"/>
			<input type="submit" value="上传" id="uploadpicture"/>
		</form>
		<br>
	</div>
	<div class="row">
	<?php 
	require_once "class.ui.Picture.php"; 
	require_once "class.db.Picture.php";
	$db=new PictureDB();
	$result=$db->selectAll();
	foreach($result as $p){
		echo "<div class='col-xs-4'>";
		$pic=new Picture();
		$pic->data=array("src"=>"images/upload/{$p["name"]}","title"=>"{$p["msg"]}","introduce"=>"{$p["ower"]} 上传于{$p["uploadtime"]}","heart_num"=>999);
		$pic->show();
		echo "</div>";
	}
	?> 
	</div>
	</div>

</div>
<script src="js/highcharts.js"></script>
<script src="js/gsap/main-gsap.js"></script>
<script src="js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
<script src="js/bootstrap.js"></script>

<script src="js/joinable.js" id="script-resource-4"></script>  
<script src="js/neon-api.js" id="script-resource-6"></script>
<script src="js/cookies.min.js" id="script-resource-7"></script>

<script src="js/neon-custom.js" id="script-resource-3"></script>
<script src="js/neon-demo.js" id="script-resource-11"></script>
<script src="js/neon-skins.js" id="script-resource-12"></script>


<script>
jQuery.noConflict();
(function($){
	    //点击弹出发送邮件表单
	   /* $("#uploadpicture").click(function(e){
	    	e.preventDefault();
	    	var url="uploadfile.php";
	    	$.post(url,{picupload:$("#pic_up").val()}, function(data) {
        		alert(data);
   		 	});
   		 	
	    });*/	
})(jQuery);


</script>

</body>
	