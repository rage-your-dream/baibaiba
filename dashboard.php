<?php
session_start();
require_once "checkstatus.php";
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css" id="style-resource-1">
	<link rel="stylesheet" href="css/font-icons/entypo/css/entypo.css" id="style-resource-2">
	<link rel="stylesheet" href="css/bootstrap-min.css" id="style-resource-4">
	<link rel="stylesheet" href="css/neon-core-min.css" id="style-resource-5">
	<link rel="stylesheet" href="css/neon-theme-min.css" id="style-resource-6">
	<link rel="stylesheet" href="css/neon-forms-min.css" id="style-resource-7">
	<link rel="stylesheet" href="css/custom-min.css" id="style-resource-8">
	<link rel="stylesheet" href="css/mycss/dashboard_tmp002.css">
	
	<link rel="stylesheet" href="css/mycss/d3.css">
	<link rel="stylesheet" href="css/mycss/mail.css">
	
	<script type="text/javascript" src="js/jquery-2.1.0.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script type="text/javascript" src="js/d3/d3.js"></script>
    <script type="text/javascript" src="js/d3/d3.layout.js"></script>
	<script type="text/javascript" src="js/d3/d3.v3.min.js"></script>

</head>
<body class="page-body loaded">
<div class="page-container <?php if(isset($_SESSION["username"])&&$_SESSION["username"]=="Localhost"){ echo "sidebar-collapsed" ;} ?>" >
<?php
require_once "slider.php"; 
require_once "class.ui.Panels.php";
require_once "class.ui.Models.php";
require_once "class.db.Panel.php";
require_once "class.db.Chart.php";
require_once "class.bean.Permission.php";
echo "<div  class='main-content boader-content'>";//style='min-height: 2042px;'
?>
<div class="row">
	<!-- Profile Info and Notifications -->
	<div class="col-md-8  clearfix">
		<ul class="user-info pull-left pull-none-xsm">
			<!-- Profile Info -->
			<li class="profile-info dropdown"><!-- add class "pull-right" if you want to place this from right -->
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<img src="images/head.png" alt="" class="img-circle" width="44">
					<?php if(isset($_SESSION["username"]))echo $_SESSION["username"]; ?>
				</a>
			</li>
		</ul>
	</div>
	<!-- Raw Links -->
	<div class="col-md-3 clearfix">	
		<ul class="list-inline links-list pull-right">	
			<?php if(isset($_SESSION["email"])){
				$permission=new Permission();
				$dashboard_id=$_GET["id"];
 				$isEditable=$permission->checkBoardEditPermission($dashboard_id,$_SESSION["email"]);
 				if($isEditable){
 					if(!isset($_GET["edit"])){
 						$href="dashboard.php?id={$dashboard_id}&edit=true";
 						echo "<li><a href='{$href}'>编辑模式<i class='entypo-pencil right'></i></a>";
 					}else{
 						$href="dashboard.php?id={$dashboard_id}";
 						echo "<li><a href='{$href}'>退出编辑模式<i class='entypo-pencil right'></i></a>";
 					}	
 					echo "<li class='sep'></li>";
 				}
 				$isCreateable=$permission->checkBoardCreateChart($dashboard_id,$_SESSION["email"]);
 				if($isCreateable){
 					echo "<li><a href='{$href}'>创建图表<i class='entypo-plus-squared right'></i></a>";
 					echo "<li class='sep'></li>";
 				}
			}
			?>				
			<li><a href="#" id="editmail_a" >截图邮件<i class="entypo-mail right"></i></a>
			</li>
			<li class="sep"></li>
			<li><a href="logout.php?action=logout">注销 <i class="entypo-logout right"></i></a></li>
		</ul>
	</div>
</div>
<hr>
<?php
$chart_db = new ChartDB();
$dashboard_id=2;
if(isset($_GET["id"]))
	$dashboard_id=$_GET["id"];
 
 function showPanel($chart_id,$panel_id,$dashboard_id,$help_msg,$analysis_msg){
 	$username=$_SESSION["email"];
 	$panel_db=new PanelDB(); 
 	$p=$panel_db->selectPanel($panel_id,$username);
 	if($p["ishide"]==1) {
 		return;
 	}
 	$panel=new Panel();
 	$panel->data=$p;
 	$panel->data["left"]=($p["x"])."px";
 	$panel->data["top"] =($p["y"])."px";

 	//截图不需要显示这些
 	if(!isset($_GET["snap"])){ 
 		$permission=new Permission();
 		$isEditable=$permission->checkBoardEditPermission($dashboard_id,$_SESSION["email"]);
 		$panel->addOptionPraise($panel->data["praiseStatus"],$panel->data["totalPraise"]);
 		$panel->addOptionHelp();
 		if($isEditable&&isset($_GET["edit"])){
 			$panel->addOptionFresh();
 			$panel->addOptionEdit();
 			if($panel->data["data_lock"]=="1")
 				$panel->addOptionDataLock(1);
 			else 
 				$panel->addOptionDataLock();
 			if($panel->data["analysis_show"]=="1")
 				$panel->addOptionAnalysis(1);
 			else
 				$panel->addOptionAnalysis();
 			//$panel->addOptionChangeSize();
 			$panel->data["dragable"]='dragable';
 		}
 	}
 	//data["analysis_show"]=="1" 表示显示分析数据 ,如果显示分析数据：chart宽度60%，图标为打开;否则：width默认，图标为折叠样式
 	if($panel->data["analysis_show"]=="1"){ 
 		$panel->data["content"] ="<div class='ichart small' style='width:70%' id='chart{$chart_id}'></div>";
 		$panel->data["content"].="<div class='ichart_analysis_msg showing'>{$analysis_msg}</div>";
 		$panel->data["content"].="<div class='ichart_help_msg' style='width:70%'>{$help_msg}</div>";
 	}else{ 
 		$panel->data["content"] ="<div class='ichart large' id='chart{$chart_id}'></div>";
 		$panel->data["content"].="<div class='ichart_analysis_msg' style='display:none;'>{$analysis_msg}</div>";
 		$panel->data["content"].="<div class='ichart_help_msg'>{$help_msg}</div>";
 	}
 	$panel->show();	
 }
#遍历当前dashboard所有chart
$charts = $chart_db->selectChartByDashboardId($dashboard_id);
foreach($charts as $chart){
	echo "<div class='row'>";
	showPanel($chart["id"],$chart["panel_id"],$dashboard_id,$chart["help_msg"],$chart["analysis_msg"]);
	echo "</div>";
}

$chart_db=null;
?>
</div>
</div>
<?php
require_once "class.bean.Mail.php";
$mm=new Mail();
$modal=new Modal();
$modal->data=array("model_id"=>"editmail","model_title"=>"编辑邮件","content"=>$mm->displayMailForm()."<p id='loadingpic'></p><div id='img_div'></div>");
$modal->show();

$m=new Modal();
$m->data=array("model_id"=>"mail_result","title"=>"邮件发送结果","but_name"=>"知道了","content"=>"<p class='confirm_msg'></p>");
$m->showConfirmModel();

?>
<script src="js/highcharts.js"></script>
<script src="js/highcharts-more.js"></script>
<script src="js/gsap/main-gsap.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/joinable.js"></script>
<script src="js/resizeable.js"></script>
<script src="js/neon-api-zct.js"></script>
<script src="js/neon-custom.js"></script>
<script src="js/myjs/mail.js"></script>
<script src="js/myjs/d3.chart.demo.js"></script>
<script src="js/myjs/dashboard.js"></script>
</body>
</html>
