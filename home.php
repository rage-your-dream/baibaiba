
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
	
	<title>质量管理平台</title>
	
	<style>.file-input-wrapper { overflow: hidden; position: relative; cursor: pointer; z-index: 1; }
	.file-input-wrapper input[type=file], .file-input-wrapper input[type=file]:focus, 
	.file-input-wrapper input[type=file]:hover { position: absolute; top: 0; left: 0; cursor: pointer; opacity: 0; filter: alpha(opacity=0); z-index: 99; outline: 0; }
	.file-input-name { margin-left: 8px; }
	.listTitle{
		font-size:20px;
		font-family:黑体;
		font-weight:bold;
	}
	span{
		vertical-align:bottom;
	}
	.panel-title{
		font-size:20px;
		font-family:黑体;
	}
	.center-body{
		margin:auto;
		width:60%;
	}
	.center-body1{
		width:63%;
		margin:auto;
	}
	#explain{
		height:250px;
		background:#fa9c9a;
	}
	#explain-1{
		height:410px;
		background:url(images/img-02.png) repeat-x;
		color:white;
		margin-bottom:20px;
		margin-left:0px;
	}
	#explain p{
		font-family:黑体;
		font-size:15px;
		color:#fff;
		
	}
	#explain h1{
		text-align:center;
		font-size:30px;
		color:#fff;	
		font-weight:bold;
	}
	h3{
		text-align:center;
		margin-right:21px;
	}
	.cellstyle p{
		text-indent: 2em;
		margin-right:21px;
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
	<link rel="stylesheet" href="css/mycss/mail.css" id="style-resource-11">
	
	<script type=text/javascript src="js/jquery-2.1.0.min.js"></script>
</head>
<?php
require_once "class.ui.Tiles.php";
require_once "class.ui.Panels.php";
require_once "class.ui.Models.php";
?>
<body class="page-body loaded" >
<div class="page-container <?php if(isset($_GET["snap"])){ echo $_GET["snap"]; } ?>">
	<?php require_once "slider.php"; ?>
	<div style="min-height: 1442px;" class="main-content">
	<?php require_once "titlerow.php"; 
	if(!isset($_GET["page"])){ 
	?>

	<!-- 
    			<div class="panel-body with-table"><table class="col-sm-12">

				<tbody>
					<tr>
						<td class="padding-lg col-sm-6">
						
							<div class="list-group" style="margin: 0px auto">
								<a class="list-group-item active listTitle" >
									<span class="badge badge-plain">ALL</span>
									Mobogenie
								</a>
								<a class="list-group-item" href="#panel1">
									<span class="badge badge-primary">1</span>
									Confluence:知识分享及交流
								</a>
								<a class="list-group-item" href="#panel2">
									<span class="badge badge-success">2</span>
									Jira:产品需求及项目管理
								</a>
								<a class="list-group-item" href="#panel3">
									<span class="badge badge-danger">3</span>
									TestLink:测试及用例管理
								</a>
								<a class="list-group-item" href="#panel4">
									<span class="badge badge-info">4</span>
									Hudson：每日构建与持续集成
								</a>
								<a class="list-group-item" href="#panel5">
									<span class="badge badge-warning">5</span>
									扫一扫
								</a>
								<a class="list-group-item" href="#panel6">
									<span class="badge badge-invert">6</span>
									各质量指标数据及分析展示
								</a>

							</div>
							
						</td>
						<td class="padding-lg col-sm-6" >
							<div id="explain" class="jumbotron"  style="margin: 0px auto">
							<h1>详细介绍就在下面哦~~~</h1>
	
							<p><strong>点一点</strong>你就知道了~\(≧▽≦)/~</p>
							<p>加油↖(^ω^)↗</p>
							<p>告诉你一个小秘密哦，<strong>点击每个版块的标题，</strong>有可能会直接跳转到对应页面。</p>
							<p>快来试试吧！</p>
							
							</div>
						</td>
						
					</tr>

				</tbody>
			</table></div>
 -->	
				<div class="col-md-12" id="explain-1" style="text-align: center">
				<img src="images/img-01.png">
				</div>

		
<div class="row">
	
	<div class="col-md-6 panel-invert" data-collapsed="0" id="panel1" >
		
		<div data-collapsed="0" class="panel panel-primary">
			
			<!-- panel head -->
			<div class="panel-heading">

				<div class="panel-title listTitle">
				<a href="post.php?target=mobo_confluence">Confluence:知识分享及交流</a>
				</div>				
			</div>
			
			<!-- panel body -->
			<div class="panel-body">
		
			<div class="scrollable" data-autohide="0" data-rail-radius="10" data-rail-width="8" data-rail-opacity=".9" data-rail-color="#39414e" data-scroll-position="right" data-height="300" class="scrollable" style="overflow: hidden; width: auto; height: 300px;">
				
				<div class="col-md-12 cellstyle">
				<h3>Confluence:知识分享及交流</h3>
				<p>

				<p>
				Confluence是专业的企业知识管理与协同软件，当前主要用于mobogenie各团队成员之间的交流协作和知识共享。在这里，团队成员齐心协力，各擅其能，它强大的编辑和站点管理特征能够帮助团队成员之间共享信息、文档协作、集体讨论，从此打破不同团队、不同部门以及个人之间信息孤岛的僵局，真正实现了组织资源共享。
				</p><p><strong>空间：</strong>分布式存储知识，支持创建无限多空间；
				</p><p><strong>页面：</strong>支持页面模板功能，简单的符号描述你的想法；
				</p><p><strong>可视化的编辑器：</strong>支持从剪贴板中粘贴文本和图片；
				</p><p><strong>收藏和关注功能：</strong>可以收藏和关注自己喜欢的内容和空间；
				</p><p><strong>操作功能：</strong>office集成，可导入Word文档，支持多种宏，支持拖拽上传批量附件。
				
				</p>
				</div>
				<div class="col-md-12" style="text-align: center">
				<img src="images/app-img4.png">
				</div>
				</div>				
			</div>
			</div>
			
		</div>
		
	
	<div class="col-md-6 panel-invert" data-collapsed="0" id="panel2">
		
		<div data-collapsed="0" class="panel panel-success">
			
			<!-- panel head -->
			<div class="panel-heading">
				<div class="panel-title listTitle">
				<a href="http://oa.it.mobogarden.com/jira">Jira:产品需求及项目管理</a>
				</div>

			</div>
			
			<!-- panel body -->
			<div class="panel-body">
				<div class="scrollable" data-autohide="0" data-rail-radius="10" data-rail-width="8" data-rail-opacity=".9" data-rail-color="#b4e8a8" data-scroll-position="right" data-height="300" class="scrollable" style="overflow: hidden; width: auto; height: 300px;">
				

		
				<div class="col-md-12 cellstyle">
				<h3>问题跟踪和管理</h3>

				<p>
				Jira是项目及事物跟踪及管理工具，当前主要用于mobogenie各客户端项目的需求收集、任务管理、缺陷管理等。
				</p><p>问题跟踪和管理：可以<strong>自定义多个工作流</strong>为不同项目使用，对<strong>项目需求、任务、缺陷等进行跟踪管理</strong>；
				</p><p><strong>1)项目概览：</strong>快速了解项目基本状态，如问题情况，变动记录，报告等；
				</p><p><strong>2)邮件提醒：</strong>通过邮件提醒功能进行协作通知，提高工作效率；
				</p><p><strong>3)过滤器：</strong>通过自带或自定义的过滤器快速查询；
				</p><p><strong>4)动态链接：</strong>允许在项目间交叉链接问题，如重复的问题和子问题等。				
				</p>
				</div>
				<div  style="text-align: center">
				<img src="images/app-img5.png">
				</div>
				<div class="col-md-12 cellstyle">
				<h3>自定义仪表板</h3>
				<p>

				<p>
				 仪表板页面可以立刻看到所有与自己有关的信息
				 </p><p>按照自己的需求定义过滤器，生成图表
				 </p><p>随时了解问题和项目的进展情况
				
				</p>
				</div>
				<div  style="text-align: center">
				<img src="images/app-img6.png">
				</div>		
				</div>
			</div>
			
		</div>
		
	</div>
	
</div>
<div class="row">
	
	<div class="col-md-6" id="panel3">
		
		<div data-collapsed="0" class="panel panel-danger">
			
			<!-- panel head -->
			<div class="panel-heading">
				<div class="panel-title listTitle">
				<a href="http://oa.it.mobogarden.com/testlink">TestLink:测试及用例管理</a>				
				</div>				
			</div>
			
			<!-- panel body -->
			<div class="panel-body">
				<div class="scrollable" data-autohide="0" data-rail-radius="10" data-rail-width="8" data-rail-opacity=".9" data-rail-color="#ffafbd" data-scroll-position="right" data-height="300" class="scrollable" style="overflow: hidden; width: auto; height: 300px;">
				<div class="row">
				<div class="col-md-6" style="text-align: center">
				<img src="images/app-img7.png">
				</div>
		
				<div class="col-md-6 cellstyle">
				<h3>TestLink:测试及用例管理</h3>

				<p>
				TestLink 是基于web的测试管理工具，主要用于管理测试用例，从测试需求、测试计划、测试用例管理和用例执行，到最后的结果分析，一套完整的测试流程控制，帮助测试人员有效的控制测试过程。
				</p><p><strong>TestLink主要有以下功能：</strong>
				</p><p>1.测试需求的管理；
				</p><p>2.测试计划的管理；
				</p><p>3.测试用例的管理；
				</p><p>4.测试用例的执行；
				</p><p>5.测试结果的分析 (包括测试结果的图表分析)；
				</p><p>6.基于角色的用户管理。
				</p><p>当前<strong>主要用于</strong>mobogenie各客户端项目的<strong>测试用例创建和管理</strong>，并且还提供了一些简单的统计功能。
				
				</p>
				</div>
				</div>				
				</div>
			</div>
			
		</div>
		
	</div>
	
	<div class="col-md-6" id="panel4">
		
		<div data-collapsed="0" class="panel panel-info">
			
			<!-- panel head -->
			<div class="panel-heading">
				<div class="panel-title">
				<a href="http://hudson.it.mobogarden.com">Hudson：每日构建与持续集成</a>
				</div>

			</div>
			
			<!-- panel body -->
			<div class="panel-body">
				<div class="scrollable" data-autohide="0" data-rail-radius="10" data-rail-width="8" data-rail-opacity=".9" data-rail-color="#a6e8f3" data-scroll-position="right" data-height="300" class="scrollable" style="overflow: hidden; width: auto; height: 300px;">
				<div class="row">
				<div class="col-md-6" style="text-align: center">
				<img src="images/app-img3.png">
				</div>
		
				<div class="col-md-6 cellstyle">
				<h3>Hudson：每日构建与持续集成</h3>
				<p>

				<p>
				Hudson是目前业内广泛应用的持续集成平台。它具有多功能的配置和良好的扩展性，可结合多种脚本和插件，使编译、构建更加自定义化，有助于提高项目构建的成功率。
				</p><p>目前我们的Hudson平台主要实现如下功能：
				</p><p><strong>1、代码自动检出构建：</strong>自动从SVN版本库里面检出特定版本的源码并执行构建过程；
				</p><p><strong>2、定制化需求打包：</strong>通过配置测试Job，测试人员可随时根据需要打出测试包进行测试；
				</p><p><strong>3、版本发布打包：</strong>配置管理人员可以借助Hudson轻松的批量打出用于发布的包；
				</p><p><strong>4、自动化构建及代码检查：</strong>采取了DailyBuild和CheckInBuild的模式进行自动化构建，并集成了代码检查工具，对源代码进行规范性检查；
				</p><p><strong>5、邮件提醒构建结果：</strong>构建结束会自动触发邮件，将结果信息发送到相关人员的邮箱。
				
				</p>
				</div>
				</div>
				</div>
			</div>
			
		</div>
		
	</div>
</div>	
<div class="row">
	
	<div class="col-md-6" id="panel5">
		
		<div data-collapsed="0" class="panel panel-warning">
			
			<!-- panel head -->
			<div class="panel-heading">
				<div class="panel-title listTitle">
				<a href="http://oa.it.mobogarden.com/AppsAngle/index.php?app_name=Mobogenie">扫一扫</a>
				</div>				
			</div>
			
			<!-- panel body -->
			<div class="panel-body">
				<div class="scrollable" data-autohide="0" data-rail-radius="10" data-rail-width="8" data-rail-opacity=".9" data-rail-color="#ffd78a" data-scroll-position="right" data-height="300" class="scrollable" style="overflow: hidden; width: auto; height: 300px;">
				<div class="row">
		<div class="col-md-6" style="text-align: center">
				<img src="images/app-img1.png">
		</div>
		
		<div class="col-md-6 cellstyle">
			<h3>二维码扫描平台</h3>
			<p>
				通过项目分门别类。
				<br>
				</p><p>点一点就可以领略不同项目的移动工具（移动应用）
				<br>
				<br><br><br><br><br><br>
			</p>
		</div>

		</div>
	<div class="row">
		<div class="col-md-6" style="text-align: center">
				<img src="images/app-img2.png">
		</div>
		
		<div class="col-md-6 cellstyle">
		
			<h3>二维码扫描页</h3>
			<p>
				按照属性可以查找筛选，快速定位到我们需要的那个APK对应的二维码 
				</p>
				<p>只需要扫一下就可以轻松将APK安装到手机。
			
			</p>
			
		</div>
	</div>
				</div>
			</div>
			
		</div>
		
	</div>
	
	<div class="col-md-6" id="panel6">
		
		<div data-collapsed="0" class="panel panel-gray">
			
			<!-- panel head -->
			<div class="panel-heading">
				<div class="panel-title listTitle">
				<a href="moboboard.php">各质量指标数据及分析展示</a>
				</div>

			</div>
			
			<!-- panel body -->
			<div class="panel-body">
				<div class="scrollable" data-autohide="0" data-rail-radius="10" data-rail-width="8" data-rail-opacity=".9" data-rail-color="#fff" data-scroll-position="right" data-height="300" class="scrollable" style="overflow: hidden; width: auto; height: 300px;">

	<div class="row">
		<div class="col-md-6" style="text-align: center;margin-top:30px;">
				<img src="images/highlights-3-1-comments.png">
		</div>
		
		<div  class="col-md-6 cellstyle">
		
			<h3>统计图表</h3>
			<p>基于jira、testlink，hudson，SVN等系统的原始数据，通过数据分析，展示了mobogenie各客户端项目，当前及历史版本重要质量指标情况，包括版本进度、需求情况，缺陷情况以及代码质量等。<br>
			</p><p>1.质量指标数据展示： 基于jira等系统原始数据的更新情况，对质量指标结果定期/不定期刷新，及时了解版本当前质量水平；
			</p><p>2.数据分析：根据各质量指标数据情况，对当前及历史版本进行趋势分析，及早发现、规避风险；
			</p><p>3.邮件截图：点击“截图邮件”即可将当前数据情况，一键发送给相关人，还可以对邮件主题，邮件正文进行编辑及内容添加。
			
			</p>
			
		</div>
	</div>
					
				</div>
			</div>
			
		</div>
		
	</div>
	
</div>
</div>
</div>
    <?php }?>
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
<script src="js/gsap/main-gsap.js"></script>
<script src="js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
<script src="js/bootstrap.js"></script>

<script src="js/joinable.js" id="script-resource-4"></script>
<script src="js/resizeable.js"></script>  
<script src="js/neon-api.js" id="script-resource-6"></script>
<script src="js/cookies.min.js" id="script-resource-7"></script>
<script src="js/neon-custom.js" id="script-resource-3"></script>
<script src="js/jquery.sparkline.min.js"></script>
<script src="js/jquery.dataTables.js"></script>

<script src="js/myjs/mail.js"></script>

</body>

