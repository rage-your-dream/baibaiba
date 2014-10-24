<?php
require_once "class.ui.Charts.php";
require_once "class.ui.Panels.php";
require_once "class.db.Chart.php";
require_once "class.db.Mobo.php";
 class MoboChart{
	const dashboard_id=2;
	public $data=array();
	public $chart_id;
	public $chart_type;
	public $chart;
	public  function demo(){echo "你好";}
	
	public function newChart2DB(){
		$db=new ChartDB();
		$db->insertChart($this->chart_id,$this->chart_type,$this->demo(),MoboChart::dashboard_id);
	}	
	
	/**
	 * 从63上获取数据，如果数据不锁定，从其他其他数据源跟新数据
	 */
	public function getChart($datalock){
		$db=new ChartDB();
		$c=$db->selectChart($this->chart_id);
		$this->chart->setChartArray($c["data"]);
		
		if($datalock==0){
			$this->freshChart();
		}
		return $this->chart->getChartJson();
	}

}
/*每人的bug分布*/
class BugEveryOneChart extends MoboChart{
	
	function __construct(){
		$this->chart_id=2;
		$this->chart_type="d3_column_pie";
		$this->chart=new D3Chart();
	}
	public function demo(){

 		$this->chart->data["title"]=array("text"=>"未关闭缺陷情况");
		
		$this->chart->data["series"]=array(
			array("State"=>"zct","freq"=>array("NEW"=> 3,"fixed"=> 1,"closed"=> 5)),
			array("State"=>"wzp","freq"=>array("NEW"=> 5,"fixed"=> 7,"closed"=> 5)),
			array("State"=>"cy","freq"=>array("NEW"=> 3,"fixed"=> 3,"closed"=> 6))
		);
    	return $this->chart->getChartJson();	
	}
	/**
	 * 从其他数据源获取数据
	 */
	public function freshChart(){
		$db=new MoboDB();
		$r=$db->selectBugEveryOne();
		//得到的格式是name,status,value 需要的格式是 {{State:"张三"，freq:{New:1,fixed:2,closed:3}}}
		$series=array();
		foreach($r as $rr){
			if($rr["status"]=="1"){
				$series[$rr["name"]]["NEW"]=(int)$rr["value"];
			}else if($rr["status"]=="3"){
				$series[$rr["name"]]["InProgress"]=(int)$rr["value"];
			}else if($rr["status"]=="4"){
				$series[$rr["name"]]["Reopened"]=(int)$rr["value"];
			}else if($rr["status"]=="5"){
				$series[$rr["name"]]["Resolved"]=(int)$rr["value"];
			}else if($rr["status"]=="6"){
				$series[$rr["name"]]["Closed"]=(int)$rr["value"];
			}
		}
		$series1=array();
		$series2=array();
		foreach($series as $k=>$s){
			$series1["State"]=$k;
			$series1["freq"]=array_merge(array("NEW"=>0,"InProgress"=>0,"Reopened"=>0,"Resolved"=>0,"Closed"=>0),$s);
			array_push($series2,$series1);
		}
		$this->chart->data["series"]=$series2;
		return $this->chart->getChartJson();
	}	
}

/*任务分布*/
class TaskDistributionChart extends MoboChart{
	
	function __construct(){
		$this->chart_id=9;
		$this->chart_type="d3_treemap";
		$this->chart=new D3Chart();
	}
	public function demo(){

 		$this->chart->data["title"]=array("text"=>"未关闭缺陷情况");
		
		$this->chart->data["series"]=array(
			"name"=>"任务分布","children"=>array(
				array("name"=>"任务1","children"=>array(array("name"=>"任务1.1","size"=>1),array("name"=>"任务1.2","size"=>1))),
				array("name"=>"任务2","children"=>array(array("name"=>"任务2.1","size"=>1),array("name"=>"任务2.2","size"=>1)))
			)
			
		);
    	return $this->chart->getChartJson();	
	}
	/**
	 * 从其他数据源获取数据
	 */
	public function freshChart(){
		$db=new MoboDB();
		$r=$db->selectTaskDistribution();
		//得到的格式是version,status,assign,sub 需要的格式是 如demo
		$series=array();
		foreach($r as $rr){
			if(!isset($series[$rr["version"]][$rr["status"]][$rr["assign"]]))
				$series[$rr["version"]][$rr["status"]][$rr["assign"]]=array("name"=>$rr["sub"],"size"=>1);
		}
		
		$series123=array("name"=>"任务分布","children"=>array());
		
		foreach($series as $k=>$s){//version 
			$series1=array("name"=>$k,"children"=>array());	//	ex:  {{name:v1.2.1,children:{}},..}
			foreach($s as $kk=>$ss){//status 
				$series2=array("name"=>$kk,"children"=>array());//	ex: v1.2.1 :{{name:todo,children:{}},{name:testing,children:{}},..}
				foreach($ss as $kkk=>$sss){//assign 
					$series3=array("name"=>$kkk,"children"=>array()); //ex: todo :{{name:王楠,children:{}},{name:李连强,children:{}},..}
					foreach($ss as $kkkk=>$ssss){//task 
						array_push($series3["children"],$ssss); //ex: 王楠:{{name:添加图片,size:1},{name:添加gaoxi图片,size:1},..}
					}
					$series3["name"].=count($series3["children"]);
					array_push($series2["children"],$series3);
				}
				array_push($series1["children"],$series2);
			}
			array_push($series123["children"],$series1);
		}
		$this->chart->data["series"]=$series123;
		return $this->chart->getChartJson();
	}	
}
/*未关闭缺陷*/
class OpenedBugChart extends MoboChart{
	
	function __construct(){
		$this->chart_id=3;
		$this->chart_type="line_column";
		$this->chart=new LineAndColumnChart();
	}
	public function demo(){
		$this->chart->data["subtitle"]=array("text"=>"数据来源于mobo");
 		$this->chart->data["chart"]=array("zoomType"=>"xy");
 		$this->chart->data["title"]=array("text"=>"未关闭缺陷情况");
		$this->chart->data["xAxis"]=array("categories"=>array('1.2.0', '2.1.1', '2.1.2', '2.5.3', '3.0.0'));
		$this->chart->data["yAxis"]=array(
			array("title"=>array("text"=>"未关闭bugDI值","style"=>array("color"=>"#89A54E"))),
			array("title"=>array("text"=>"缺陷数(单位：个)","style"=>array("color"=>"#4572A7")),"opposite"=>true)		
		);
		$this->chart->data["plotOptions"]=array("column"=>array("stacking"=>"normal","dataLabels"=>array("enabled"=>true,"color"=>"white")));
		$this->chart->data["tooltip"]=array("shared"=>true);
		$this->chart->data["series"]=array(
			array("name"=>"1级bug","color"=>"#4572A7","type"=>"column","yAxis"=>1,"data"=>array(4, 3, 1, 5, 4)),
			array("name"=>"2级bug","color"=>"#7cb5ec","type"=>"column","yAxis"=>1,"data"=>array(1, 7, 4, 3, 5)),
			array("name"=>"3级bug","color"=>"#7cb2ec","type"=>"column","yAxis"=>1,"data"=>array(1, 7, 6, 3, 1)),
			array("name"=>"未关闭bugDI值","color"=>"#89A54E","type"=>"spline","data"=>array(31,12,13,17,15))
		);
    	$this->chart->improve();
    	return $this->chart->getChartJson();
    	
		
	}
	/**
	 * 从其他数据源获取数据
	 */
	public function freshChart(){
		$db = new MoboDB();
		$c=$db->selectOpenBug();//包含所有数据的array
		//得到categories
		$version = array();
		foreach($c as $key => $val){
			if(in_array($val['version'],$version) == 0){
				array_push($version,$val['version']);
			}
		}
		//得到series 1级bug
		$p = array();
		foreach($c as $key => $val){
			if((int)$val['p'] == 1){
				for($i = 0;$i<count($version);$i++){
					if($version[$i]==$val['version']){
						$p[$i]=(float)$val['num'];
					}
				}
			}
		}
		$p1 = array();
		for($i = 0;$i<count($version);$i++){
			if(array_key_exists($i,$p)){
				array_push($p1,(float)$p[$i]);
			}
			else{
				array_push($p1,0);
			}
		}
		//得到series 2级bug
		$p = array();
		foreach($c as $key => $val){
			if((int)$val['p'] == 2){
				for($i = 0;$i<count($version);$i++){
					if($version[$i]==$val['version']){
						$p[$i]=(float)$val['num'];
					}
				}
			}
		}
		$p2 = array();
		for($i = 0;$i<count($version);$i++){
			if(array_key_exists($i,$p)){
				array_push($p2,(float)$p[$i]);
			}
			else{
				array_push($p2,0);
			}
		}
		//得到series 3级bug
		$p = array();
		foreach($c as $key => $val){
			if((int)$val['p'] == 3){
				for($i = 0;$i<count($version);$i++){
					if($version[$i]==$val['version']){
						$p[$i]=(float)$val['num'];
					}
				}
			}
		}
		$p3 = array();
		for($i = 0;$i<count($version);$i++){
			if(array_key_exists($i,$p)){
				array_push($p3,(float)$p[$i]);
			}
			else{
				array_push($p3,0);
			}
		}
		//得到series 4级bug
		$p = array();
		foreach($c as $key => $val){
			if((int)$val['p'] == 4){
				for($i = 0;$i<count($version);$i++){
					if($version[$i]==$val['version']){
						$p[$i]=(float)$val['num'];
					}
				}
			}
		}
		$p4 = array();
		for($i = 0;$i<count($version);$i++){
			if(array_key_exists($i,$p)){
				array_push($p4,(float)$p[$i]);
			}
			else{
				array_push($p4,0);
			}
		}
		//得到series DI值
		$DI = array();
		for($i = 0;$i<count($version);$i++){
			$val = $p1[$i]*10 + $p2[$i]*3 + $p3[$i]*1 + $p4[$i]*0.1;
			array_push($DI,(float)$val);
		}
		//将bug个数四舍五入
		for($i=0;$i<count($p1);$i++){
			$p1[$i]=round($p1[$i]);
			$p2[$i]=round($p2[$i]);
			$p3[$i]=round($p3[$i]);
			$p4[$i]=round($p4[$i]);
		};
		$this->chart->data["xAxis"]=array("categories"=>$version);
		$this->chart->data["series"]=array(
			array("name"=>"1级bug","type"=>"column","yAxis"=>1,"data"=>$p1),
			array("name"=>"2级bug","type"=>"column","yAxis"=>1,"data"=>$p2),
			array("name"=>"3级bug","type"=>"column","yAxis"=>1,"data"=>$p3),
			array("name"=>"4级bug","type"=>"column","yAxis"=>1,"data"=>$p4),
			array("name"=>"未关闭bugDI值","color"=>"#89A54E","type"=>"spline","data"=>$DI)
		);
		return $this->chart->getChartJson();
	}
	/**
	 * 从63上获取数据，如果数据不锁定，从其他其他数据源跟新数据
	 */
	public function getChart(){
		$db=new ChartDB();
		$c=$db->selectChart($this->chart_id);
		$this->chart->setChartArray($c["data"]);
		$c=$db->selectChartDataLock($this->chart_id);
		
		if($c["data_lock"]==0){
			$this->freshChart();
		}
		return $this->chart->getChartJson();
	}
}

class RequirementChangeChart extends MoboChart{
	
	function __construct(){
		$this->chart_id=8;
		$this->chart_type="column";
		$this->chart=new ColumnChart();
	}
	public function demo(){
     	$this->chart->data["chart"]["type"] ="column";	
     	$this->chart->data["title"]=array("text"=>"模块需求变更情况");	
     	$this->chart->data["subtitle"]=array("text"=>"模块需求变更情况");	
 		$this->chart->data["xAxis"]= array("categories"=>array('picture', 'music', 'function', 'video', 'app&game','讨论区'));
    	$this->chart->data["yAxis"]=array("min"=>"0","title"=>array("text"=>""),"stackLabels"=>array("enabled"=>true,"style"=>array("fontWeight"=>"bold","color"=>"gray")));
    	$this->chart->data["legend"]=array("enabled"=>true);	
    	$this->chart->data["plotOptions"]=array("column"=>array("stacking"=>"normal","dataLabels"=>array("enabled"=>true,"color"=>"white")));
    	
    	$this->chart->data["series"]=array(
    		array( "name" =>"增加","data" =>array(15,11,9, 6, 3, 2)),
    		array( "name" =>"删除","data" =>array(2,5 ,2, 3, 2, 11))
    	);
    	
    	//$this->chart->improve();
    	return $this->chart->getChartJson();
    	
		
	}
	/**
	 * 从其他数据源获取数据
	 */
	public function freshChart(){
		$this->demo();
		
	}
}


/*代码质量图*/
class CodeQualityChart extends MoboChart{
	
	function __construct(){
		$this->chart_id=1;
		$this->chart_type="spiderweb";
		$this->chart=new SpiderwebChart();
	}
	public function demo(){
		$this->chart->data["title"]=array("text"=>"代码质量解析");
 		$this->chart->data["subtitle"]=array("text"=>"数据来源于mobo");
 		$this->chart->data["pane"]=array("size"=>"90%");
 		$this->chart->data["xAxis"]=array("categories"=>array('严重问题', '阻断问题', '技术债务', '复杂性总数', 
	                '注释率', '重复率') ,"tickmarkPlacement"=>"on","lineWidth"=>0);
	    $this->chart->data["yAxis"]=array("gridLineInterpolation"=>"polygon");
	    $this->chart->data["tooltip"]=array("shared"=>true,"pointFormat"=>"<span style='color:{series.color}'>{series.name}: <b>{point.y:,.0f}</b><br/>");    
	    $this->chart->data["legend"]=array("enabled"=>true);
      
    	$this->chart->data["series"]=array(
    		array("name"=>"14/7/12","data"=>array(344, 153, 153, 219, 172, 100),"pointPlacement"=>"on"),
    		array("name"=>"14/7/12","data"=>array(345, 156, 400, 399, 260, 140),"pointPlacement"=>"on")   		
    	);
    	$this->chart->improve();
    	return $this->chart->getChartJson();
		
	
	}
	/**
	 * 从其他数据源获取数据
	 */
	public function freshChart(){
		$this->demo();
	}
}

class BugPercent extends MoboChart{
	function __construct(){
		$this->chart_id=5;
		$this->chart_type="dim2pie";
		$this->chart=new Dim2PieChart();
	}
	public function demo(){
		$this->chart->data["chart"]=array("type"=>"pie");	
 		$this->chart->data["title"]=array("text"=>"缺陷占比");
 		$this->chart->data["subtitle"]=array("text"=>"");
        // $this->data["tooltip"]=array("pointFormat"=>"{series.data[0]}:<b>{point.percentage:.1f}%({point.y})</b>");
        $this->chart->data["series"][0]=array("name"=>"总占比","size"=>"60%","dataLabels"=>array("distance"=>-30));
    	$this->chart->data["series"][1]=array("name"=>"历史占比","size"=>"80%","innerSize"=>"62%");
		$this->chart->data["series"][0]["data"]=array(array("name"=>"data1","y"=>80,"color"=>"#Cccccc"),array("name"=>"data2","y"=>100),array("name"=>"data3","y"=>40));
    	$this->chart->data["series"][1]["data"]=array(array("name"=>"d1","y"=>40,"color"=>"#Cccccc"),array("name"=>"d2","y"=>40,"color"=>"#Cccccc"),array("name"=>"2","y"=>100),array("name"=>"d3","y"=>40));
    	
    	echo $this->chart->getChartJson();
    }
	/**
	 * 从其他数据源获取数据
	 */
	public function freshChart(){
		$db=new MoboDB();
		$bug1=$db->selectBugOandC1();
		$bug2=$db->selectBugOandC2();
		$db=null;
		
    	$this->chart->data["series"][0]["data"]=array();
    	$this->chart->data["series"][1]["data"]=array();
    	foreach($bug1 as $bug){
    		$abc=array("name"=>$bug["name"],"y"=>(int)$bug["y"],"color"=>$bug["color"]);
    		array_push($this->chart->data["series"][0]["data"],$abc);
    	}
    	foreach($bug2 as $bug){
    		$name=$bug["name"].$bug["y"]."个";
    		$abc=array("name"=>$name,"y"=>(int)$bug["y"],"color"=>$bug["color"]);
    		array_push($this->chart->data["series"][1]["data"],$abc);
    	}
    	$this->chart->improve();
    	return $this->chart->getChartJson();
	}


}
/**
 * 计划延期&变更响应率
 */
class TestDensity extends MoboChart{

	function __construct(){
		$this->chart_id=6;
		$this->chart_type="line";
		$this->chart=new LineChart();
	}
	public function demo(){
		$this->chart->data["title"]=array("text"=>"测试密度&缺陷密度");
		$this->chart->data["subtitle"]=array("text"=>"数据来源于mobo");
		$this->chart->data["xAxis"]=array("categories"=>array('1.1.0', '1.2.0', '1.3.0', '1.4.0', '1.5.0'));
		$this->chart->data["yAxis"]=array(
				array("title"=>array("text"=>"测试密度"),
				"min"=>0,
				"tickInterval"=>5,
				"plotLines"=>array(array("color"=>"#FF0000","dashStyle"=>"ShortDot","width"=>2,"value"=>25,"zIndex"=>5))),
				array("title"=>array("text"=>"缺陷密度"),
				"min"=>0,
				"tickInterval"=>2.4,
				"plotLines"=>array(array("color"=>"#FF0000","dashStyle"=>"ShortDot","width"=>2,"value"=>12,"zIndex"=>5)),
				"opposite"=>true
				)
		);
		$this->chart->data["tooltip"]=array("shared"=>true,"valuePrefix"=>"&");
		$this->chart->data["series"]=array(
				array("name"=>"测试密度","color"=>"#4572A7","data"=>array(7.0, 6.9, 9.5, 14.5, 18.4),"yAxis"=>0),
				array("name"=>"缺陷密度","color"=>"#7cb5ec","data"=>array(3.9, 4.2, 5.7, 8.5, 11.9),"yAxis"=>1)
		);
		
		return $this->chart->getChartJson();
		 

	}
	/**
	 * 从其他数据源获取数据
	 */
	public function freshChart(){
		$this->demo();
	}
	
}

/**
 * 各版本上线前缺陷清除率对比图
 */
class DefectRemovalRate extends MoboChart{
	function __construct(){
		$this->chart_id=7;
		$this->chart_type="line";
		$this->chart=new LineChart();
	}
	public function demo(){
		$this->chart->data["title"]=array("text"=>"各版本上线前缺陷清除率对比图");
		$this->chart->data["subtitle"]=array("text"=>"数据来源于mobo");
		$this->chart->data["xAxis"]=array("categories"=>array('1.2.0','1.2.1','1.5.0'));
		$this->chart->data["yAxis"]=array(
				"title"=>array("text"=>"清除率（%）"),
				"plotLines"=>array(array("color"=>"#FF0000","dashStyle"=>"ShortDot","width"=>2,"value"=>95,"zIndex"=>5))
		);
		$this->chart->data["tooltip"]=array("shared"=>true);
		$this->chart->data["series"]=array(
				array("name"=>"缺陷清除率","color"=>"#4572A7","data"=>array(89,83,96))
		); 
		//$this->chart->improve();
		return $this->chart->getChartJson();	
	}
	/**
	 * 从其他数据源获取数据
	 */
	public function freshChart(){
		$this->demo();
	}
}
/**
 * 计划延期&变更响应率
 */
class DelayOfPlanChart extends MoboChart{

	function __construct(){
		$this->chart_id=4;
		$this->chart_type="line";
		$this->chart=new LineChart();
	}
	public function demo(){
		$this->chart->data["title"]=array("text"=>"计划延期&变更响应率");
		$this->chart->data["subtitle"]=array("text"=>"数据来源于mobo");
		$this->chart->data["xAxis"]=array("categories"=>array('1.2.0','1.2.1','1.5.0'));
		$this->chart->data["yAxis"]=array(
				array("title"=>array("text"=>"未关闭bugDI值","style"=>array("color"=>"#89A54E"))),
				array("title"=>array("text"=>"缺陷数(单位：个)","style"=>array("color"=>"#4572A7")),"opposite"=>true)
		);
		$this->chart->data["tooltip"]=array("shared"=>true);
		$this->chart->data["series"]=array(
				array("name"=>"计划延期率","color"=>"#4572A7","data"=>array(12.5, 6.9, 39.5)),
				array("name"=>"变更响应率","color"=>"#7cb5ec","data"=>array(25,33,170))
		);
		//$this->chart->improve();
		return $this->chart->getChartJson();
		 

	}
	/**
	 * 从其他数据源获取数据
	 */
	public function freshChart(){
		$this->demo();
	}
}
?>
