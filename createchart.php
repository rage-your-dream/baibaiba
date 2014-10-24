<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>图表创建</title>
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

	<script type="text/javascript" src="js/highcharts.js"></script>
	<script type="text/javascript" src="js/highcharts-more.js"></script>

</head>
<body class="page-body loaded">
<?php 
require_once "class.ui.Charts.php";
require_once "class.ui.Panels.php";
require_once "class.db.Chart.php";
$dashboard_id=$_GET["dashboard_id"];
?>
<div id='boader_content'>
	<div id="first_row" class="row">
		<div class="col-sm-8"></div>
		<div class="col-sm-2"></div>
		<div class="col-sm-2"><a id="back" href="<?php echo "dashboard.php?id=".$dashboard_id; ?>">返回表盘</a></div>
	</div>
	<hr>
	<div class="row">
	<div class="col-sm-1"></div>
	<div class="col-sm-10"><div class="row">
<?php 
	#linechart
	echo "<div class='col-sm-6'>";
	$line_chart=new LineChart();
	$line_panel=new Panel();
	$line_chart->demo();
	$line_panel->data["content"] ="<div class='ichart' id='chart1'></div>";
	$line_panel->addOptionCreate();
	$line_panel->show();
	echo '<script>'.'$("#chart1").highcharts('.$line_chart->getChartJson().');'.'</script>';
	echo "</div>";
	#ColumnChart
	echo "<div class='col-sm-6'>";
	$column_chart=new ColumnChart();
	$column_panel=new Panel();
	$column_chart->demo();
	$column_panel->data["content"] ="<div class='ichart' id='chart2'></div>";
	$column_panel->addOptionCreate();
	$column_panel->show();
	echo '<script>'.'$("#chart2").highcharts('.$column_chart->getChartJson().');'.'</script>';
	echo "</div>";
	#SpiderwebChart
	echo "<div class='col-sm-6'>";
	$spiderweb_chart=new SpiderwebChart();
	$spiderweb_panel=new Panel();
	$spiderweb_chart->demo();
	$spiderweb_panel->data["content"] ="<div class='ichart' id='chart3'></div>";
	$spiderweb_panel->addOptionCreate();
	$spiderweb_panel->show();
	echo '<script>'.'$("#chart3").highcharts('.$spiderweb_chart->getChartJson().');'.'</script>';
	echo "</div>";
	#ColumnChart
	echo "<div class='col-sm-6'>";
	$line_column_chart=new LineAndColumnChart();
	$line_column_panel=new Panel();
	$line_column_chart->demo();
	$line_column_panel->data["content"] ="<div class='ichart' id='chart4'></div>";
	$line_column_panel->addOptionCreate();
	$line_column_panel->show();
	echo '<script>'.'$("#chart4").highcharts('.$line_column_chart->getChartJson().');'.'</script>';
	echo "</div>";
	#PieChart
	echo "<div class='col-sm-6'>";
	$pie_chart=new PieChart();
	$pie_panel=new Panel();
	$pie_chart->demo();
	$pie_panel->data["content"] ="<div class='ichart' id='chart5'></div>";
	$pie_panel->addOptionCreate();
	$pie_panel->show();
	echo '<script>'.'$("#chart5").highcharts('.$pie_chart->getChartJson().');'.'</script>';
	echo "</div>";
	#Dim2PieChart
	echo "<div class='col-sm-6'>";
	$dim2pie_chart=new Dim2PieChart();
	$dim2pie_panel=new Panel();
	$dim2pie_chart->demo();
	$dim2pie_panel->data["content"] ="<div class='ichart' id='chart6'></div>";
	$dim2pie_panel->addOptionCreate();
	$dim2pie_panel->show();
	echo '<script>'.'$("#chart6").highcharts('.$dim2pie_chart->getChartJson().');'.'</script>';
	echo "</div>";
?>
	</div></div>
	</div>	
</div>

</body>
</html>