<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>图表编辑</title>
	<link rel="stylesheet" href="js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css" id="style-resource-1">
	<link rel="stylesheet" href="css/font-icons/entypo/css/entypo.css" id="style-resource-2">
	<link rel="stylesheet" href="css/bootstrap-min.css" id="style-resource-4">
	<link rel="stylesheet" href="css/neon-core-min.css" id="style-resource-5">
	<link rel="stylesheet" href="css/neon-theme-min.css" id="style-resource-6">
	<link rel="stylesheet" href="css/neon-forms-min.css" id="style-resource-7">
	<link rel="stylesheet" href="css/custom-min.css" id="style-resource-8">
	<link rel="stylesheet" href="css/mycss/d3.css">
	<link rel="stylesheet" href="css/mycss/editChart.css">
	<script type="text/javascript" src="js/jquery-2.1.0.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script type="text/javascript" src="js/d3/d3.js"></script>
    <script type="text/javascript" src="js/d3/d3.layout.js"></script>
	<script type="text/javascript" src="js/d3/d3.v3.min.js"></script>
	<script type="text/javascript" src="js/highcharts.js"></script>
	<script type="text/javascript" src="js/highcharts-more.js"></script>

</head>
<body class="page-body loaded">
<?php 
require_once "class.ui.Charts.php";
require_once "class.bean.Datafresh.php";
require_once "class.db.Chart.php";
#返回页面
$back_page=$_GET["backpage"]."&edit=true";

$chart_id=$_GET["chart_id"];
#从数据库读取图表数据
$db=new ChartDB();
$chart_from_db=$db->selectChart($chart_id);
#拿到数据源类和图表类
$chart_type=$chart_from_db["type"];
//$data_machine=$chart_from_db["data_machine"];
#利用工厂实例化图表对象
$chart=ChartFactory::getChart($chart_type);
#赋值到各属性
$chart->setChartArray($chart_from_db["data"]);

$help=$db->selectChartHelpMsg($chart_id);
$analysis=$db->selectChartAnalysisMsg($chart_id);
	
?>
<div id='boader_content'>
	<div id="first_row" class="row">
		<div class="col-sm-8"></div>
		<div class="col-sm-2">
		<!--button name="" id='preview' type='button' class='btn btn-green' >预览</button>
		<button name="" id='store' type='button' class='btn btn-green' >保存图表</button-->
		</div>
		<div class="col-sm-2">
		<a id="back" href="<?php echo $back_page; ?>">返回表盘</a>
		</div>
	</div>
	
	<hr>
	<div class="row">
		<div class="col-sm-1">
		</div>
		<div class="col-sm-6">
			<!--图表显示panel-->
			<div class='panel panel-primary chart_panel'>
				<div class='panel-heading'>
					<div class='panel-title'></div>
					<div class='panel-options'>		
						<a href='#' class='help_show_hide'><i class='entypo-help'></i></a>	
						<a href='#' class='anilysis_show_hide'><i class='entypo-picture'></i></a>			
					</div>
				</div>	
 				<div class='panel-body' > 		
					<div id="chart"  data_chart_id='<?php echo $chart_id; ?>' data_chart_type='<?php echo $chart_from_db["type"]; ?>' ></div>
					<div id="help_msg_div"><?php if($help["help_msg"]) echo $help["help_msg"];?></div>
					<div id="anilysis_msg_div"><?php if($analysis["analysis_msg"]) echo $analysis["analysis_msg"];?></div>
				</div>
			</div>
			<!--数据编辑panel-->
			<div class='panel panel-primary chart_panel series_edit_panel'>
				<div class='panel-heading'>
					<div class='panel-title'>数据编辑区</div>
					<div class='panel-options'>								
						<a href='#' class='add_row'>添加行<i class='entypo-down'></i></a>
						<a href='#' class='add_col'>添加列<i class='entypo-right'></i></a>
						<a href='#' data-rel='collapse'><i class='entypo-down-open'></i></a>				
					</div>
				</div>	
 				<div class='panel-body'> 
					<?php $chart->seriesEditShow();?>				
					<br>
					<button id='stroe_series' type='button' class='btn btn-green' >保存图表数据</button>	
				</div>
			</div><!--数据编辑区结束 -->
			<div class='panel panel-primary chart_panel'>
				<div class='panel-heading'>
					<div class='panel-title'>说明文档编辑区</div>
					<div class='panel-options'>		
						<a href='#'  data-rel='collapse'><i class='entypo-down-open'></i></a>				
					</div>
				</div>	
		
 				<div class='panel-body'> 
 					<form action="#" id='form_help_msg' method="get">
					<div class="row">
						<div class='col-md-12'>		
							<textarea cols='' style="width:100%" name='help_msg' rows='8' id='input_help_msg' placeholder='<?php if($help["help_msg"]) echo $help["help_msg"];
							else echo "可以使用html标签，如：&lt;h2&gt;bug量&lt;/h2&gt<br>&lt;p&gt;偏高&lt;/p&gt";?>'></textarea>	
						</div>
						<br>
						<div class='col-md-6'>
							<button id='show_help_msg' type='button' class='btn btn-gray' >显示关闭说明浮层</button>
							<button id='stroe_help_msg' type='button' class='btn btn-green' >保存说明文档</button>
						</div>
					</div>
				</form>
			</div></div><!--说明文档编辑区结束-->
			<div class='panel panel-primary chart_panel'>
				<div class='panel-heading'>
					<div class='panel-title'>分析数据编辑区</div>
					<div class='panel-options'>		
						<a href='#'  data-rel='collapse'><i class='entypo-down-open'></i></a>				
					</div>
				</div>	
		
 				<div class='panel-body'> 
					<div class="row">
					<div class='col-md-12'>			
					<textarea cols='' style="width:100%" name='analysis_msg' id='input_analysis_msg' placeholder='<?php if($analysis["analysis_msg"]) echo $analysis["analysis_msg"];
							else echo "可以使用html标签，如：&lt;h2&gt;bug量&lt;/h2&gt<br>&lt;p&gt;偏高&lt;/p&gt";?>' rows='8'></textarea>	
				</div>
				<br>
				<div class='col-md-6'>
					<button id='show_hide_analysis' type='button' class='btn btn-gray' >显示关闭分析浮层</button>
					<button id='stroe_analysis_msg' type='button' class='btn btn-green' >保存分析数据</button>
				</div>
			</div>
				</div></div><!--分析总结结束-->
		</div>
		<div class="col-sm-4">
			<h2>属性编辑区</h2>
			<hr>
			<form action="#" id="form123" method="get">
			<?php $chart->optionsEditShow();?>
			</form>
			<br>
				<button id='stroe_options' type='button' class='btn btn-green' >保存图表属性</button>
		</div>
	</div>
	
</div>
<script src="js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="js/bootstrap.js"></script>


<script src="js/myjs/d3.chart.demo.js"></script>
<script src="js/myjs/editchart.js"></script>
</body>
</html>