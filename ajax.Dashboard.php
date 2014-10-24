<?php
session_start();
require_once "class.db.Chart.php";
require_once "class.db.Panel.php";
require_once "class.ui.Charts.php";
require_once "class.bean.Datafresh.php";
require_once "class.bean.Reflect.php";
#ajax.Dashboard 是dashboard的动态部分实现
if(isset($_GET["action"])){
	if($_GET["action"]=="fresh_chart"){
		$id = $_GET["chart_id"];
		$username=$_SESSION["email"];
		$p_db=new PanelDB();
		$datalock =	$p_db->selectPanel($id,$username);
		$datalock =	$datalock["data_lock"];
		if(isset($_GET["stroe"])) $datalock=0;
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
		$machine=DataMachineFactory::getDataMachine($data_machine);
		if($datalock==0){
			#数据源获取的数据覆盖图表原有数据
			$chart->seriesCover($machine->freshChart());			
			if(isset($_GET["stroe"])){
				$db->updateChart($id,$chart->getChartJson());
			}
		}
		#计算
		$chart->calculate($machine->calculate($chart->data));	
		echo $chart->getChartJson();
	}

}

?>
