<?php
require_once "class.db.Mobo.php";
class DataMachineFactory{
	public function getDataMachine($type){
		if($type=="OpenedBugChart"){
			return new OpenedBugChart();
		}else if($type=="CodeQualityChart"){
			return new CodeQualityChart();
		}else if($type=="BugEveryOneChart"){
			return new BugEveryOneChart();
		}
		else if($type=="TaskDistributionChart"){
			return new TaskDistributionChart();
		}
		else if($type=="OpenedBugChart"){
			return new OpenedBugChart();
		}
		else if($type=="BugPercent"){
			return new BugPercent();
		}
		else if($type=="RequirementChangeChart"){
			return new RequirementChangeChart();
		}
		else if($type=="TestDensity"){
			return new TestDensity();
		}else if($type=="DefectRemovalRate"){
			return new DefectRemovalRate();
		}else if($type=="DelayOfPlanChart"){
			return new DelayOfPlanChart();
		}
	}
}
class DataMachine{
	public function calculate(){
		
	}
}
/*每人的bug分布*/
class BugEveryOneChart extends DataMachine{
	public function freshChart(){
		$db=new MoboDB();
		$r=$db->selectBugEveryOne();
		//得到的格式是name,status,value 需要的格式是 {{State:"张三"，freq:{New:1,fixed:2,closed:3}}}
		$series=array();
		foreach($r as $rr){
			if($rr["status"]=="1"){
				$series[$rr["name"]]["NEW"]=(int)$rr["value"];
			}else if($rr["status"]=="3"){
				$series[$rr["name"]]["正在处理"]=(int)$rr["value"];
			}else if($rr["status"]=="4"){
				$series[$rr["name"]]["重新打开"]=(int)$rr["value"];
			}else if($rr["status"]=="5"){
				$series[$rr["name"]]["已解决"]=(int)$rr["value"];
			}else if($rr["status"]=="6"){
				$series[$rr["name"]]["已关闭"]=(int)$rr["value"];
			}
		}
		$series1=array();
		$series2=array();
		foreach($series as $k=>$s){
			$series1["State"]=$k;
			$series1["freq"]=array_merge(array("NEW"=>0,"正在处理"=>0,"重新打开"=>0,"已解决"=>0,"已关闭"=>0),$s);
			array_push($series2,$series1);
		}
		return $series2;
	}	
}
/*任务分布*/
class TaskDistributionChart extends DataMachine{
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
		return $series123;
	}	
}
/*未关闭缺陷*/
class OpenedBugChart extends DataMachine{
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
		
		$chart["xAxis"]=array("categories"=>$version);
		$chart["series"]=array(
			array("name"=>"1级bug","type"=>"column","yAxis"=>1,"data"=>$p1),
			array("name"=>"2级bug","type"=>"column","yAxis"=>1,"data"=>$p2),
			array("name"=>"3级bug","type"=>"column","yAxis"=>1,"data"=>$p3),
			array("name"=>"4级bug","type"=>"column","yAxis"=>1,"data"=>$p4)
		);

		return $chart;
	}
	public function calculate($chart){
		/*计算BUG series DI值
		* 版本未关闭BUG数=BUG总数-BUG状态为“关闭”和“已解决”的数量+BUG状态为“已解决”的数量*0.1
		* 版本未关闭BUG DI值=1级未关闭BUG数*1级DI值+2级未关闭BUG数*2级DI值+3级未关闭BUG数*3级DI值+4级未关闭BUG数*4级DI值
		* 不同级别BUG的DI值不同，具体为：1级BUG为10，2级BUG为3，3级BUG为1，4级BUG为0.1
		*/
		$DI = array("name"=>"未关闭bugDI值","type"=>"spline","data"=>array());
		
		for($i = 0;$i<count($chart["xAxis"]["categories"]);$i++){
			$val = $chart["series"][0]["data"][$i]*10 + $chart["series"][1]["data"][$i]*3 + $chart["series"][2]["data"][$i]*1 + $chart["series"][3]["data"][$i]*0.1;
			array_push($DI["data"],(float)$val);
		}
		$chart["series"][4]=$DI;
		return $chart;
	}
}

class BugPercent extends DataMachine{
	public function freshChart(){
		$db=new MoboDB();
		$bug1=$db->selectBugOandC1();
		$bug2=$db->selectBugOandC2();
		$db=null;
		
    	$data=array(array(),array());
    	foreach($bug1 as $bug){
    		$abc=array("name"=>$bug["name"],"y"=>(int)$bug["y"],"color"=>$bug["color"]);
    		array_push($data[0],$abc);
    	}
    	foreach($bug2 as $bug){
    		$name=$bug["name"].$bug["y"]."个";
    		$abc=array("name"=>$name,"y"=>(int)$bug["y"],"color"=>$bug["color"]);
    		array_push($data[1],$abc);
    	}
    	$data123["series"]=array(array("name"=>"Bug数","size"=>"60%","dataLabels"=>array("distance"=>-30)),array("name"=>"Bug数","size"=>"80%","innerSize"=>"62%"));
    	$data123["series"][0]["data"]=$data[0];
    	$data123["series"][1]["data"]=$data[1];
    	return $data123;
	}
}

class RequirementChangeChart extends DataMachine{
	public function freshChart(){	
		return null;
	}
}


/*代码质量图*/
class CodeQualityChart extends DataMachine{
	public function freshChart(){
		return null;
	}
} 

/**
 * 计划延期&变更响应率
 */
class TestDensity extends DataMachine{
	public function freshChart(){
		return null;
	}
}

/**
 * 各版本上线前缺陷清除率对比图
 */
class DefectRemovalRate extends DataMachine{
	public function freshChart(){
		$db=new MoboDB();
		$rate=$db->selectDefectRemovalRate();
		$categries=array();
		$series=array();
		foreach($rate as $one){
			array_push($categries,$one['version']);
			array_push($series,round((float)$one['rate'],2));
		}
		
		$chart["xAxis"]=array("categories"=>$categries);
		$chart["series"]=array(
			array("name"=>"清除率","type"=>"line","yAxis"=>0,"data"=>$series)
		);
		return $chart;
	}
}
/**
 * 计划延期&变更响应率
 */
class DelayOfPlanChart extends DataMachine{
	public function freshChart(){
		return null;
	}
}

?>
