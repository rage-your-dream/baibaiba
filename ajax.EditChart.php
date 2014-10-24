<?php
require_once "class.db.Chart.php";
require_once "class.db.Panel.php";
require_once "class.ui.Charts.php";
if(isset($_GET["action"])){
	if($_GET["action"]=="fresh_chart"){
		$id = $_GET["chart_id"];
		#从数据库取表数据
		$db=new ChartDB();
		$chart_from_db=$db->selectChart($id);
		#拿到数据源类和图表类
		$data_machine=$chart_from_db["data_machine"];
		$chart_type=$chart_from_db["type"];
		#利用工厂实例化图表对象
		$chart=ChartFactory::getChart($chart_type);
		#json字符转化为图Array型数据
		$chart->setChartArray($chart_from_db["data"]);
		#利用工厂实例化图表对象
		#$machine=DataMachineFactory::getDataMachine($data_machine);

		echo $chart->getChartJson();
		
	}elseif($_GET["action"]=="update_series"){	
		$data=$_GET["data"];
		$id = $_GET["chart_id"];
		#从数据库取表数据
		$db=new ChartDB();
		$chart_from_db=$db->selectChart($id);
		#拿到数据源类和图表类
		$data_machine=$chart_from_db["data_machine"];
		$chart_type=$chart_from_db["type"];
		#利用工厂实例化图表对象
		$chart=ChartFactory::getChart($chart_type);
		#json字符转化为图Array型数据
		$chart->setChartArray($chart_from_db["data"]);
		#根据得到的数据设置属性
		$chart->seriesEditAction($data);
		//这里图表入库
		$db->updateChart($id,$chart->getChartJson());
		$panel_db=new PanelDB();
		$panel_db->updatePaneltDataLock($id,1);
		echo $chart->getChartJson();
	}
	else if($_GET["action"]=="update_options"){	
		$data=$_GET;
		$id = $_GET["chart_id"];
		#从数据库取表数据
		$db=new ChartDB();
		$chart_from_db=$db->selectChart($id);
		#拿到数据源类和图表类
		$data_machine=$chart_from_db["data_machine"];
		$chart_type=$chart_from_db["type"];
		#利用工厂实例化图表对象
		$chart=ChartFactory::getChart($chart_type);
		#json字符转化为图Array型数据
		$chart->setChartArray($chart_from_db["data"]);
		$chart->optionsEditAction($data);
		$db->updateChart($id,$chart->getChartJson());
		$panel_db=new PanelDB();
		$panel_db->updatePaneltDataLock($id,1);
		echo $chart->getChartJson();
	}
	else if($_GET["action"]=="update_help_msg"){
		$id=$_GET["chart_id"];
		$help_msg=$_GET["help_msg"];
		$db=new ChartDB();
		if($db->updateChartHelpMsg($id,$help_msg))
			echo "Y";
		else echo "N";
	}
	else if($_GET["action"]=="update_analysis_msg"){
		$id=$_GET["chart_id"];
		$analysis_msg=$_GET["analysis_msg"];
		$db=new ChartDB();
		if($db->updateChartAnalysisMsg($id,$analysis_msg))
			echo "Y";
		else echo "N";
	}
	
}
?>
