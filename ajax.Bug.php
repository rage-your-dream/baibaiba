<?php
require_once "class.ui.Charts.php";
require_once "class.db.Bug.php";
if(isset($_GET["action"])){
	if($_GET["action"]=="bug_lw"){	
		//首先把两个种bug数据合并成图表所需数据格式
		$db=new BugDB();
		$chart_series=array();
		$new_bug=$db->selectNewBugLW();
		$leave_bug=$db->selectLeaveBugLW();
		$categories=array();
		//将新增bug数据和遗留bug数据格式化图表可以显示的数据集
		$new_data=array("name"=>"新增BUG","data"=>array());
		$leave_data=array("name"=>"新增未关闭","data"=>array());
		foreach($new_bug as $bug){
			array_push($categories,$bug["name"]);
			array_push($new_data["data"],(int)$bug["data"]);
		}
		//将数据与X坐标映射
		foreach($categories as $c){
			$b=false;
			foreach($leave_bug as $bug){	
				if($c==$bug["name"]){
					$b=true;
					array_push($leave_data["data"],(int)$bug["data"]);
					break;
				}
				
			}
			if(!$b)
				array_push($leave_data["data"],0);
		}
		$chart_series[0]=$new_data;
		$chart_series[1]=$leave_data;
		
		//设置图表参数
		$chart_lw=new ColumnChart();
		$chart_lw->data["chart"]["type"] ="column";	
 		$chart_lw->data["title"]=array("text"=>"周新增BUG");
 		$chart_lw->data["subtitle"]=array("text"=>"周新增bug及新增bug关闭情况");
 		$chart_lw->data["xAxis"]= array("title"=>array("text"=>"（单位：项目）"),"categories"=>$categories);
    	$chart_lw->data["yAxis"]=array("title"=>array("text"=>"BUG数（个）"));
    	$chart_lw->data["series"]=$chart_series;

    	echo $chart_lw->getChartJson();
    }else if($_GET["action"]=="new_bug_table"){
		//首先把两个种bug数据合并成图表所需数据格式
		$db=new BugDB();
		$chart_series=array();
		$new_bug=$db->selectNewBugLW();
		$leave_bug=$db->selectLeaveBugLW();
		$categories=array();

    	echo $leave_bug;
	}else if($_GET["action"]=="bug_open_week"){
		//返回每周未关闭BUG图表
		$db=new BugDB();
		$d=$db->selectOpenBugByWeek();
		$chart_series=array();
		
		$categories=array();
		$wd=array("name"=>"累计BUG数","data"=>array(),"dataLabels"=>array("enabled"=>"true","rotation"=>0));
		foreach($d as $weekbug){
			array_push($categories,$weekbug["week_num"]);
			array_push($wd["data"],(int)$weekbug["count"]);
		}
		$chart_series[0]=$wd;
		
		//设置图表参数
		$chart_lw=new ColumnChart();
		$chart_lw->data["chart"]["type"] ="column";	
 		$chart_lw->data["title"]=array("text"=>"本年度项目缺陷积累数");
 		$chart_lw->data["subtitle"]=array("text"=>"");
 		$chart_lw->data["xAxis"]= array("title"=>array("text"=>"（单位：项目）"),"categories"=>$categories);
    	$chart_lw->data["yAxis"]=array("title"=>array("text"=>"BUG数（个）"));
    	$chart_lw->data["series"]=$chart_series;
    	
    	echo $chart_lw->getChartJson();
	}else if($_GET["action"]=="bug_status_assign"){
		//返回开放与未关闭BUG比率图表
		$db=new BugDB();
		$Dim1=$db->selectWeekBugDistributeDim1();
		$data1=array();
		foreach($Dim1 as $val){
			array_push($data1,array("name"=>$val["name"],"y"=>(int)$val["y"],"color"=>$val["color"]));
		}
		$Dim2=$db->selectWeekBugDistributeDim2();
		$data2=array();
		foreach($Dim2 as $val){
			array_push($data2,array("name"=>$val["name"],"y"=>(int)$val["y"],"color"=>$val["color"]));
		}
		
		//设置图表参数
		$chart_lw=new Dim2PieChart();
    	$chart_lw->data["chart"]=array("type"=>"pie");	
 		$chart_lw->data["title"]=array("text"=>"本周发现缺陷分布");
 		$chart_lw->data["subtitle"]=array("text"=>"本周发现bug状态和指派人");
    	$chart_lw->data["series"][0]=array("name"=>"Status","size"=>"60%","dataLabels"=>array("distance"=>-50,"color"=>"white"));
    	$chart_lw->data["series"][1]=array("name"=>"Assign","size"=>"80%","innerSize"=>"60%");
    	$chart_lw->data["colors"]=array("#42A07B", "#9B5E4A", "#72727F", "#1F949A", "#82914E", "#86777F", "#42A07B","#514F78");
    	$chart_lw->data["series"][0]["data"]=$data1;
    	$chart_lw->data["series"][1]["data"]=$data2;

    	echo $chart_lw->getChartJson();
	}
	else if($_GET["action"]=="week_bug_trend"){
		//返回开放BUG图表
		$db=new BugDB();
		$week_bugs=$db->selectWeekBugTrend();
		$seires=array();	
		foreach($week_bugs as $val){
			$seires[$val["name"]][$val["weekday"]]=$val["count"];	
		}
		$w=date('w');
		$data=array();
		foreach($seires as $key=>$probug){
			$d=array();
			
			for($i=0;$i<$w;$i++){
				if(!isset($seires[$key][$i.""])) {
					$seires[$key][$i.""]=0;
				}
				$d[$i]=(int)$seires[$key][$i.""];
			}
			//补齐未过日期的值（null 是无线）
//			for($i=$w;$i<7;$i++){
//				if(!isset($seires[$key][$i.""])) {
//					$seires[$key][$i.""]=null;
//				}
//				$d[$i]=$seires[$key][$i.""];
//			}
			array_push($data,array("name"=>$key,"data"=>$d));
		}
		//设置图表参数
		$chart_lw=new LineChart();
		$chart_lw->data["chart"]["type"] ="line";	
 		$chart_lw->data["title"]=array("text"=>"缺陷发展趋势");
 		$chart_lw->data["subtitle"]=array("text"=>"本周缺陷发展趋势");
 		$chart_lw->data["xAxis"]=array("title"=>array("text"=>"（单位：当前周）"),"categories"=>array("星期一","星期二","星期三","星期四","星期五","星期六","星期日"));
    	$chart_lw->data["yAxis"]=array("title"=>array("text"=>"新增缺陷数（个）"));
    	$chart_lw->data["series"]=$data;
    	echo $chart_lw->getChartJson();
	}

}
?>
