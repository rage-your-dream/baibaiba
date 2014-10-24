<?php
require_once "class.ui.Charts.php";
require_once "class.db.Datacenter.php";
if(isset($_GET["action"])){
	if($_GET["action"]=="pv_distribute"){
		//pv分布
		$db=new DatacenterDB();
		$d=$db->selectPvDistribute();
		$chart_series=array();
		
		$categories=array();
		$wd=array("name"=>"PV分布","data"=>array(),"dataLabels"=>array("enabled"=>"true","rotation"=>0,"format"=>"{point.y} %"));
		$totalpv = 0;
		foreach($d as $pvdistribute){
			$totalpv=$totalpv+(int)$pvdistribute["num"];
		}
		foreach($d as $pvdistribute){
			array_push($categories,$pvdistribute["name"]);
			array_push($wd["data"],round($pvdistribute["num"]/$totalpv*100,2));
		}
		$chart_series[0]=$wd;
		
		//设置图表参数
		$chart_lw=new LineChart();
		$chart_lw->data["chart"]["type"] ="bar";	
 		$chart_lw->data["title"]=array("text"=>"PV分布");
 		$chart_lw->data["subtitle"]=array("text"=>"各页面pv占总数百分比");
 		$chart_lw->data["xAxis"]= array("title"=>array("text"=>""),"categories"=>$categories);
    	$chart_lw->data["yAxis"]=array("title"=>array("text"=>"百分比（%）"));
    	$chart_lw->data["tooltip"]=array("pointFormat"=>"<span style='color:{series.color}'>● {series.name}</span>: <b>{point.y} %</b>");
    	$chart_lw->data["series"]=$chart_series;
    	echo $chart_lw->getChartJson();
	}else if($_GET["action"]=="pv_uv_day_trend"){
		$db=new DatacenterDB();
		$d=$db->selectPvUvDayTrend();
		$categories=array();
		$pv=array();
		$uv=array();
		foreach($d as $val){
			array_push($categories,$val["time"]);
			array_push($pv,(int)$val["pv"]);
			array_push($uv,(int)$val["uv"]);
		}
		
		//设置图表参数
		$chart_lw=new LineChart();
    	$chart_lw->data["chart"]=array("type"=>"line");	
 		$chart_lw->data["title"]=array("text"=>"PV/UV每日趋势");
 		$chart_lw->data["subtitle"]=array("text"=>"");
 		$chart_lw->data["xAxis"]=array("title"=>array("text"=>""),"categories"=>$categories);
		$chart_lw->data["yAxis"]=array("title"=>array("text"=>"访问数（每日）"));
		$chart_lw->data["plotOptions"]=array("line"=>array("dataLabels"=>array("enabled"=>"true")));
 		$chart_lw->data["series"][0]["name"]="PV";
 		$chart_lw->data["series"][1]["name"]="UV";
    	$chart_lw->data["series"][0]["data"]=$pv;
    	$chart_lw->data["series"][1]["data"]=$uv;

    	echo $chart_lw->getChartJson();
	}
}
?>
