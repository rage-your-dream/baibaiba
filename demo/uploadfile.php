<?php
session_start();
function uploadPicture(){
	if($_FILES["picupload"]["size"]>1024*1024*3){
		echo "图片太大".$_FILES["picupload"]["size"];
	}
	$curdir=getcwd();
	$tmpname=substr(basename($_FILES["picupload"]["tmp_name"]),0,-4);
	$filename=$_FILES["picupload"]["name"];
	$filename=$tmpname.substr($filename,strpos($filename,"."));
	echo $filename;
	if(move_uploaded_file($_FILES["picupload"]["tmp_name"],$curdir."/images/upload/".$filename)){
		echo "<article class='img_edit'>";
		//图片显示在头部
		echo "<header>"	;
		echo "<div class='img_div'>";		
		echo "<img src='images/upload/{$filename}' class='img_upload img-responsive img-rounded full-width'>";
		echo "</div>";	
		echo "<p class='ower_time'>".$_SESSION['username']."--上传于".date("Y-m-d H:i")."</p>";	
		echo "</header>";
		$date=date("Y-m-d H:i");		
		//主题部分
		echo "<section class='img-info'>";
		echo "<form action='uploadfile.php' method='post'>";
		echo "<aside><ul><li>文件名：{$filename}</li><li>大小:{$_FILES["picupload"]["size"]}</li></ul></aside>";
		echo "<textarea cols='90' id='mail_msg' rows='3' name='msg' placeholder='说点什么吧'></textarea>"	;
		echo "<input type='hidden' name='name' value='{$filename}' />"	;
		echo "<input type='hidden' name='ower' value='{$_SESSION['username']}' />"	;
		echo "<input type='hidden' name='uploadtime' value='{$date}'/>"	;	
		echo "<input type='hidden' name='size' value='{$_FILES["picupload"]["size"]}'/>"	;
		echo "<input type='hidden' name='path' value='images/upload/{$filename}'/>"	;
		
		echo "<br><input id='submit' type='submit' value='保存'/>"	;
		echo "</form>";
		echo "</section>";
		echo "<footer>";
		
		echo "</footer>";			
		echo "</article>";
	}
}

if(isset($_POST["name"])){
	require_once "class.db.Picture.php";
	$db=new PictureDB();
	$data=array("name"=>$_POST["name"]);
	if(isset($_POST["path"])&&isset($_POST["ower"])&&isset($_POST["uploadtime"])&&isset($_POST["size"])){
		$data["path"]=$_POST["path"];
		$data["ower"]=$_POST["ower"];
		$data["uploadtime"]=$_POST["uploadtime"];
		$data["size"]=$_POST["size"];
	}else uploadPicture();
	if(isset($_POST["msg"])){
		$data["msg"]=$_POST["msg"];
	}else 
		$data["msg"]="靠谱不";
	if($db->insert($data)) header("Location: picture.php");
	else uploadPicture();
	
}else { 

?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>质量部</title>
	

	<style>
	
	
	
	.body{
		position:absolute;
		left:15%;
		width:70%;
	}
	.img_edit{
		position:relative;
		left:5%;
        width:90%;
        padding:30px;
		border:1px solid #CCCCCC;
		margin:20px;
		border-radius: 3px;
        box-shadow:2px 2px 5px;
	}
    .img_div{
        position:relative;
        width:100%;
        border-bottom:1px solid #CCCCCC;
        box-shadow:0px 0px 5px;
     
    }
    .ower_time{
     	position:absolute;
		right:5%;       
    }
	.img-info{
    	margin:20px;
    	padding:0px;
	}
	.img-info ul{
   	 	margin:20px 10px;
   	 	padding:0px;
	}

	.img_upload{
		max-width:600px;
		
	}
	 #submit{
        margin-top:20px;
        border:1px solid #CCCCCC;
        padding:5px 10px;
        background-color:#00A65A;
        color:#ccc;
        border-radius: 3px;
  
    }
	</style>
	<link rel="stylesheet" href="js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css" id="style-resource-1">
	<link rel="stylesheet" href="css/font-icons/entypo/css/entypo.css" id="style-resource-2">
	<link rel="stylesheet" href="css/bootstrap-min.css" id="style-resource-4">
	<link rel="stylesheet" href="css/neon-core-min.css" id="style-resource-5">
	<link rel="stylesheet" href="css/neon-theme-min.css" id="style-resource-6">
	<link rel="stylesheet" href="css/neon-forms-min.css" id="style-resource-7">
	<link rel="stylesheet" href="css/custom-min.css" id="style-resource-8">
	
	
	<script type=text/javascript src="js/jquery-2.1.0.min.js"></script>
 
</head>
<body class="body" >
<?php uploadPicture();

?>
</body>
</html>
<?php }?>