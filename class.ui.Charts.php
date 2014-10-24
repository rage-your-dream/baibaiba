<?php

 class ChartFactory{
 	static public function getChart($type){
 		if($type=="LineChart"){
 			return new LineChart();
 		}else if($type=="SpiderwebChart"){
 			return new SpiderwebChart();
 		}else if($type=="ColumnChart"){
 			return new ColumnChart();
 		}else if($type=="PieChart"){
 			return new PieChart();
 		}else if($type=="Dim2PieChart"){
 			return new Dim2PieChart();
 		}else if($type=="LineAndColumnChart"){
 			return new LineAndColumnChart();
 		}else if($type=="D3Chart"){
 			return new D3Chart();
 		}
 	}
 }
 abstract class Chart{
 	public $data=array();
 	/*
 	 * $data["chart"]:决定图表类型 $data["chart"]["type"]:{line:线型,clume:bar:柱型,}
 	 * $data["title"]:标题 $data["title"]["text"]:标题文字
 	 * $date["subtitle"]:子标题 $date["subtitle"]["text"]:子标题文字
 	 * $date["xAxis"]:横向坐标 $date["xAxis"]["categories"]:坐标范围
 	 * $date["yAxis"]:纵向坐标 $date["yAxis"]["title"]:纵向坐标标题 $date["yAxis"]["title"]["text"]:纵向坐标标题文字
 	 * $date["tooltip"]:提示 $date["tooltip"]["valueSuffix"]:提示后缀
 	 * $date["legend"]:里程 $date["$legend"]["layout"]:排版 $date["$legend"]["align"]:对齐
 	 * +$date["legend"]["verticalAlign"]:垂直对齐 >$date["$legend"]["borderWidth"]:边框宽度
 	 * $date["series"]["name"]:数据名 $date["series"]["data"]:数据值
 	 */
 	 
 	 /**
 	  * 将数组类型数据装换成前段显示需要的json格式
 	  */
 	 public function getChartJson(){
 		$str=json_encode($this->data);
 		return $str;
 	}
	/**
 	 * 将JSON转换的数组
 	 */
 	public function setChartArray($str){
 		$this->data=json_decode($str,true);
 	}
 	
 	/**
 	 * 提供DEMO
 	 */
 	public function demo(){
 		$this->data["title"]=array("text"=>"标题");
 		$this->data["subtitle"]=array("text"=>"副标题");
 	}
 	public function seriesCover($data){
 		if($data==null) return;
 		$this->data["series"]=$data;
 	}
 	/**
 	 * 图表参数编辑区，在图表编辑页面调用
 	 */
 	public abstract function optionsEditShow();
 	/**
 	 * 图表参数编辑
 	 */
 	public abstract function optionsEditAction($data); 
 	/**
 	 * 图表数据编辑区，在图表编辑页面调用
 	 */
 	public abstract function seriesEditShow();
 	/**
 	 * 图表数据编辑
 	 */
 	public abstract function seriesEditAction($data);
 	public function calculate($data){
 	}

 }
 
 class LineChart extends Chart{ 
 	
     public function demo(){ 
     	parent::demo();
     	$this->data["chart"]["type"] ="line";	
 		$this->data["xAxis"]= array("title"=>array("text"=>"X轴显示文字"),"categories"=>array("Jan","Feb","Mar"));
    	$this->data["yAxis"]=array("title"=>array("text"=>"Day"));
    	$this->data["series"]=array(
    		array( "name" =>"name","data" =>array(7,2,3))
     	);
     }
		 
   
    public function optionsEditShow(){
    	$default_value="";
    	echo "<h3>标题</h3>";
		echo "<input id='title_text' name='title' class='form-control' value='{$this->data["title"]["text"]}' placeholder='{$this->data["title"]["text"]}' type='text' size='20'>";
		echo "<hr><h3>副标题</h3>";
		echo "<input id='title_text' name='subtitle' class='form-control' value='{$this->data["subtitle"]["text"]}' placeholder='{$this->data["subtitle"]["text"]}' type='text' size='20'>";
		echo "<hr><h3>X轴坐标</h3>";	
		#x轴
		if(isset($this->data["xAxis"]["title"]["text"]))
			$default_value=$this->data["xAxis"]["title"]["text"];			
		echo "<input id='xAxis_text' name='x_title' class='form-control' class='options_input' value='{$default_value}' placeholder='X轴文字'  type='text'>";
		#两条Y轴
		
			echo "<hr><h3>左边Y轴坐标</h3>";
			$default_value="";
			if(isset($this->data["yAxis"][0]["title"]["text"]))
				$default_value=$this->data["yAxis"][0]["title"]["text"];
			echo "<input id='yAxis_text_0' name='y_left_title' class='form-control' class='options_input' value='{$default_value}' placeholder='左边Y轴文字'  type='text'>";
			echo "<hr><h3>右边Y轴坐标</h3>";
			$default_value="";
			if(isset($this->data["yAxis"][1]["title"]["text"]))
				$default_value=$this->data["yAxis"][1]["title"]["text"];
			echo "<input id='yAxis_text_1' name='y_right_title' class='form-control' class='options_input' value='{$default_value}' placeholder='右边Y轴文字'  type='text'>";
			echo "<hr><h3>左边Y轴基线</h3>";
			$default_value="-1";
			if(isset($this->data["yAxis"][0]["plotLines"][0]["value"]))
				$default_value=$this->data["yAxis"][0]["plotLines"][0]["value"];
			echo "<input id='plotlines_value_0' name='plotlines_left_value' class='form-control' class='options_input' value='{$default_value}' placeholder='左边Y轴基线'  type='text'>";
			echo "<hr><h3>右边Y轴基线</h3>";
			$default_value="-1";
			if(isset($this->data["yAxis"][1]["plotLines"][0]["value"]))
				$default_value=$this->data["yAxis"][1]["plotLines"][0]["value"];
			echo "<input id='plotlines_value_1' name='plotlines_right_value' class='form-control' class='options_input' value='{$default_value}' placeholder='右边Y轴基线'  type='text'>";
			
		
		
		
		$default_value='';
		if($this->data["legend"]["enabled"])
			$default_value="checked='1'";
		echo "<div class='checkbox img_tooltip'><label><input name='legend_enable'  value='1' {$default_value} type='checkbox' class='hover_img_show'>显示数据刻度</label><div><img src='images/legend.png'></img></div></div>";
		
    }
    public  function optionsEditAction($data){
    	$this->data["chart"]=array("type"=>"line");	
    	$this->data["title"]["text"]=$data["title"];
		$this->data["subtitle"]["text"]=$data["subtitle"];
		$this->data["xAxis"]["title"]["text"]=$data["x_title"];
		#如果只有一个Y轴
			$this->data["yAxis"]=array();
			$this->data["yAxis"][0]["title"]["text"]=$data["y_left_title"];
			$this->data["yAxis"][1]["title"]["text"]=$data["y_right_title"];
	 	if($data["plotlines_left_value"]!=-1){ 
			$this->data["yAxis"][0]["plotLines"][0]["value"]=(float)$data["plotlines_left_value"];
			$this->data["yAxis"][0]["plotLines"][0]["color"]="#FF0000";
			$this->data["yAxis"][0]["plotLines"][0]["dashStyle"]="ShortDot";
			$this->data["yAxis"][0]["plotLines"][0]["width"]=2;
			$this->data["yAxis"][0]["plotLines"][0]["zIndex"]=5;
     	}
     	if($data["plotlines_right_value"]!=-1){ 
			$this->data["yAxis"][1]["plotLines"][0]["value"]=(float)$data["plotlines_right_value"];
			$this->data["yAxis"][1]["plotLines"][0]["color"]="#339933";
			$this->data["yAxis"][1]["plotLines"][0]["dashStyle"]="ShortDot";
			$this->data["yAxis"][1]["plotLines"][0]["width"]=2;
			$this->data["yAxis"][1]["plotLines"][0]["zIndex"]=5;	
		}
		$this->data["yAxis"][1]["opposite"]=true;
		if(isset($data["legend_enable"]))
			$this->data["legend"]["enabled"]=true;
		else 
			$this->data["legend"]["enabled"]=false;
    }
    public function seriesEditShow(){
    	echo "<table class='table table-bordered linetable' id='table0'>";
		echo "<thead>"	;			
		echo "<tr id='series_head_tr'>"	;
		echo "<th>Name<input type='hidden' class='edit_input' value='name'/></th>";
		echo "<th>yAxis<input type='hidden' class='edit_input' value='yAxis'/></th>";
		$col=0;
		//xAxis刻度				
		foreach($this->data["xAxis"]["categories"] as $v){
			$col++;
			echo "<th class='col{$col}'><input type='text' class='edit_input' value='{$v}'/><a class='delete_col' href='#'><i class='entypo-cancel'></i></a></th>";
		};
		for($i=0;$i<20;$i++){	
			$col++;		
			echo "<th class='col{$col}'><input type='text' class='edit_input' value='可编辑'/><a class='delete_col' href='#'><i class='entypo-cancel'></i></a></th>";
		}
		echo "</tr>";
		echo "</thead>"	;			
		echo "<tbody>";					 
		foreach($this->data["series"] as $d){
			echo "<tr class='seires_body_tr'>";
			echo "<td><input type='text' class='edit_input' value='{$d["name"]}'/><a class='delete_row' href='#'><i class='entypo-cancel'></i></a></td>";
			if(!isset($d["yAxis"])) $d["yAxis"]=0;
			echo "<td><input type='text' class='edit_input' value='{$d["yAxis"]}'/></td>";
			$col=0;
			//循环放置数据到表格
			foreach($d["data"] as $a){
				$col++;
				echo "<td class='col{$col}'><input type='text' class='edit_input' value='{$a}'/></td>";
			}
			for($i=0;$i<20;$i++){		
				$col++;	
				echo "<td class='col{$col}'><input type='text' class='edit_input' value='可编辑'/></td>";
			}
			echo "</tr>";
		}
		for($i=0;$i<10;$i++){
			echo "<tr class='seires_body_tr'>";	
			echo "<td><input type='text' class='edit_input' value='可编辑'/</td>";	
			$col=0;	
			for($j=0;$j<count($this->data["xAxis"]["categories"]);$j++){
				$col++;
				echo "<td class='col{$col}'><input type='text' class='edit_input' value='可编辑'/></td>";
			}
			for($j=0;$j<20;$j++){		
				$col++;	
				echo "<td class='col{$col}'><input type='text' class='edit_input' value='可编辑'/></td>";
			}
			echo "</tr>";
		}
		echo "</tbody>"	;			
		echo "</table>"	;			
    }
 	public function seriesEditAction($data){
 		$this->data["series"]=array();
		#数据格式 ： array("name"=>"1级bug","data"=>array(4, 3, 1, 5, 4)),
		#取X轴刻度
		$thtr=explode(":",$data);
		$ths=explode(",",$thtr[0]);
		$ths_data=array();
		for($i=2;$i<count($ths);$i++){
			array_push($ths_data,$ths[$i]);
		}
		$this->data["xAxis"]["categories"]=$ths_data;
		#取线数据
		$tdtr=explode(";",$thtr[1]);
		foreach($tdtr as $tr){
			$tds=explode(",",$tr);
			$tds_name=$tds[0];
			$tds_yaxis=(float)$tds[1];		
			$tds_data=array();
			for($i=2;$i<count($tds);$i++){
				array_push($tds_data,(float)$tds[$i]);
			}
			array_push( $this->data["series"],array("name"=>$tds_name,"yAxis"=>$tds_yaxis,"data"=>$tds_data));
		}
 	}
 	public function seriesCover($data){
 		if(!isset($data)) return;
 		$this->data["xAxis"]["categories"]=$data["xAxis"]["categories"];
 		$this->data["series"]=$data["series"];
 	}
 }
 /**
  * 蜘蛛网
  */
 class SpiderwebChart extends LineChart{
 	public function demo(){
 		parent::demo();
 		$this->data["chart"]["type"] ="line";
 		$this->data["chart"]["polar"] =true;	
 		$this->data["series"]=array(
    		array( "name" =>"name","data" =>array(7,2,3),"pointPlacement"=>"on")
    	);
 	}
 	/**
 	 * 图表参数编辑区，在图表编辑页面调用
 	 */
 	public function optionsEditShow(){
 		echo "<h3>标题</h3>";
 		echo "<input id='title_text' name='title' class='form-control' value='{$this->data["title"]["text"]}' placeholder='{$this->data["title"]["text"]}' type='text' size='20'>";
 		echo "<hr><h3>副标题</h3>";
 		echo "<input id='title_text' name='subtitle' class='form-control' value='{$this->data["subtitle"]["text"]}' placeholder='{$this->data["subtitle"]["text"]}' type='text' size='20'>";
 		$default_value='';
		if($this->data["legend"]["enabled"])
			$default_value="checked='1'";
		echo "<div class='checkbox img_tooltip'><label><input name='legend_enable'  value='1' {$default_value} type='checkbox' class='hover_img_show'>显示数据刻度</label><div><img src='images/legend.png'></img></div></div>";
		
 	}
 	public  function optionsEditAction($data){
 		$this->data["chart"]["type"] ="line";
 		$this->data["chart"]["polar"] =true;
 		$this->data["title"]["text"]=$data["title"];
		$this->data["subtitle"]["text"]=$data["subtitle"];
		#六边形，不处理默认是圆形
		$this->data["yAxis"]=array("gridLineInterpolation"=>"polygon","lineWidth"=>0,"min"=>0);
 		if(isset($data["legend_enable"]))
			$this->data["legend"]["enabled"]=true;
		else 
			$this->data["legend"]["enabled"]=false;
 	}
 	/**
 	 * 图表数据编辑区，在图表编辑页面调用
 	 */
 	public function seriesEditShow(){
 		parent::seriesEditShow();
 	}
 	public function seriesEditAction($data){
 		parent::seriesEditAction($data);
 		#去掉圆圈
 		$this->data["aAxis"]["tickmarkPlacement"]="on";
 		$this->data["aAxis"]["lineWidth"]=0;
 		#旋转角度
 		foreach($this->data["series"] as $key=>$line){
 			$this->data["series"][$key]["pointPlacement"]="on";
 		}
 	}
 }
 class ColumnChart extends Chart{ 
 
    public function demo(){ 
     	$this->data["chart"]["type"] ="column";	
 		$this->data["xAxis"]= array("title"=>array("text"=>"X轴显示文字"),"categories"=>array("Jan","Feb","Mar"));
    	$this->data["yAxis"]=array("title"=>array("text"=>"Day"));
    	
    	$this->data["series"]=array(
    		array( "name" =>"name","data" =>array(7,2,3),"dataLabels"=>array("enabled"=>"true","rotation"=>-90,"y"=>10,"color"=>"#ffffff"))
    	);
    }
   
    public function optionsEditShow(){
    	$default_value="";
    	echo "<h3>标题</h3>";
		echo "<input id='title_text' name='title' class='form-control' value='{$this->data["title"]["text"]}' placeholder='{$this->data["title"]["text"]}' type='text' size='20'>";
		echo "<hr><h3>副标题</h3>";
		echo "<input id='title_text' name='subtitle' class='form-control' value='{$this->data["subtitle"]["text"]}' placeholder='{$this->data["subtitle"]["text"]}' type='text' size='20'>";
		echo "<hr><h3>X轴坐标</h3>";	
		$default_value="";
		if(isset($this->data["xAxis"]["title"]["text"]))
			$default_value=$this->data["xAxis"]["title"]["text"];
		echo "<input id='xAxis_text' name='x_title' class='form-control' class='options_input' value='{$default_value}' placeholder='X轴文字'  type='text'>";

		if(count($this->data["yAxis"])!=2){
			echo "<hr><h3>Y轴坐标</h3>";
			$default_value="";
			if(isset($this->data["yAxis"]["title"]["text"]))
				$default_value=$this->data["yAxis"]["title"]["text"];
			echo "<input id='yAxis_text' name='y_title' class='form-control' class='options_input' value='{$default_value}' placeholder='Y轴文字'  type='text'>";
		}
		else{
			echo "<hr><h3>左边Y轴坐标</h3>";
			$default_value="";
			if(isset($this->data["yAxis"][0]["title"]["text"]))
				$default_value=$this->data["yAxis"][0]["title"]["text"];
			echo "<input id='yAxis_text_0' name='y_left_title' class='form-control' class='options_input' value='{$default_value}' placeholder='左边Y轴文字'  type='text'>";
			echo "<hr><h3>右边Y轴坐标</h3>";
			$default_value="";
			if(isset($this->data["yAxis"][1]["title"]["text"]))
				$default_value=$this->data["yAxis"][1]["title"]["text"];
			echo "<input id='yAxis_text_1' name='y_right_title' class='form-control' class='options_input' value='{$default_value}' placeholder='右边Y轴文字'  type='text'>";
		}

		$default_value='';
		if($this->data["legend"]["enabled"])
			$default_value="checked='true'";
		echo "<div class='checkbox img_tooltip'><label><input name='legend_enable'  value='1' {$default_value} type='checkbox' class='hover_img_show'>显示数据刻度</label><div><img src='images/legend.png'></img></div></div>";
		$checked="";
		//if(isset($this->data["series"][0]["dataLabels"]))
			//$checked="checked='true'";
		//echo "<div class='checkbox img_tooltip'><label><input name='legend_vertical'  value='1' {$checked} type='checkbox' class='hover_img_show'>显示每节的数值</label><div><img src='images/legend.png'></img></div></div>";
		$checked="";
		if($this->data["plotOptions"]["column"]["stacking"]=="normal")
			$checked="checked='true'";
		echo "<div class='checkbox img_tooltip'><label><input name='stacking'  value='1' {$checked} type='checkbox' class='hover_img_show'>阶梯式显示</label><div><img src='images/stack.png'></img></div></div>";
    }
    public function optionsEditAction($data){
    	$this->data["chart"]=array("type"=>"column");
    	$this->data["title"]["text"]=$data["title"];
		$this->data["subtitle"]["text"]=$data["subtitle"];
		$this->data["xAxis"]["title"]["text"]=$data["x_title"];
		#刻度
		if(!isset($data["legend_enable"])) 	
		 	$this->data["legend"]["enabled"]=false;
		else
			$this->data["legend"]["enabled"]=true;
		#堆栈
		if(isset($data["stacking"])) { 	
		 	$this->data["plotOptions"]["column"]=array("stacking"=>"normal");
		 	foreach($this->data["series"] as $k=>$line){
				$this->data["series"][$k]["dataLabels"]=array("enabled"=>true,"rotation"=>-90,"y"=>0,"color"=>"#ffffff");
			}
		}else{ 
			$this->data["plotOptions"]["column"]=array("stacking"=>"");
			foreach($this->data["series"] as  $k=>$line){
				$this->data["series"][$k]["dataLabels"]=array("enabled"=>false);
			}
		}
		
		$this->data["yAxis"]["stackLabels"]["enabled"]=true;
		#y轴
		if(!isset($data["y_right_title"])){
			$this->data["yAxis"]["title"]["text"]=$data["y_title"];
			
		}
		else{
			$this->data["yAxis"][0]["title"]["text"]=$data["y_left_title"];
			$this->data["yAxis"][1]["title"]["text"]=$data["y_right_title"];
		}	
    }
    public function seriesEditShow(){
		echo "<table class='table table-bordered linetable' id='table0'>";
		echo "<thead>"	;			
		echo "<tr id='series_head_tr'>"	;
		echo "<th>Name<input type='hidden' class='edit_input' value='name'/></th>";
		$col=0;
		//xAxis刻度				
		foreach($this->data["xAxis"]["categories"] as $v){
			$col++;
			echo "<th class='col{$col}'><input type='text' class='edit_input' value='{$v}'/><a class='delete_col' href='#'><i class='entypo-cancel'></i></a></th>";
		};
		for($i=0;$i<20;$i++){	
			$col++;		
			echo "<th class='col{$col}'><input type='text' class='edit_input' value='可编辑'/><a class='delete_col' href='#'><i class='entypo-cancel'></i></a></th>";
		}
		echo "</tr>";
		echo "</thead>"	;			
		echo "<tbody>";					 
		foreach($this->data["series"] as $d){
			echo "<tr class='seires_body_tr'>";
			echo "<td><input type='text' class='edit_input' value='{$d["name"]}'/><a class='delete_row' href='#'><i class='entypo-cancel'></i></a></td>";
			$col=0;
			//循环放置数据到表格
			foreach($d["data"] as $a){
				$col++;
				echo "<td class='col{$col}'><input type='text' class='edit_input' value='{$a}'/></td>";
			}
			for($i=0;$i<20;$i++){		
				$col++;	
				echo "<td class='col{$col}'><input type='text' class='edit_input' value='可编辑'/></td>";
			}
			echo "</tr>";
		}
		for($i=0;$i<10;$i++){
			echo "<tr class='seires_body_tr'>";	
			echo "<td><input type='text' class='edit_input' value='可编辑'/</td>";	
			$col=0;	
			for($j=0;$j<count($this->data["xAxis"]["categories"]);$j++){
				$col++;
				echo "<td class='col{$col}'><input type='text' class='edit_input' value='可编辑'/></td>";
			}
			for($j=0;$j<20;$j++){		
				$col++;	
				echo "<td class='col{$col}'><input type='text' class='edit_input' value='可编辑'/></td>";
			}
			echo "</tr>";
		}
		echo "</tbody>"	;			
		echo "</table>"	;					
    }
    public function seriesEditAction($data){
    	//echo $data;
 		$this->data["series"]=array();
			//array("name"=>"1级bug","data"=>array(4, 3, 1, 5, 4)),
		//取X轴刻度
		$thtr=explode(":",$data);
		$ths=explode(",",$thtr[0]);
		$ths_data=array();
		for($i=1;$i<count($ths);$i++){
			array_push($ths_data,$ths[$i]);
		}
		$this->data["xAxis"]["categories"]=$ths_data;
		//取线数据
		$tdtr=explode(";",$thtr[1]);
		foreach($tdtr as $tr){
			$tds=explode(",",$tr);
			$tds_name=$tds[0];
			
			$tds_data=array();
			for($i=1;$i<count($tds);$i++){
				array_push($tds_data,(float)$tds[$i]);
			}
			array_push( $this->data["series"],array("name"=>$tds_name,"data"=>$tds_data));
		}
 	}
 	
 
 }
 class PieChart extends Chart{ 
 	
    public function demo(){ 
     	$this->data["chart"]=array("type"=>"pie");	
 		$this->data["title"]=array("text"=>"标题");
 		$this->data["subtitle"]=array("text"=>"副标题");
        $this->data["tooltip"]=array("pointFormat"=>"{series.data[0]}:<b>{point.percentage:.1f}%({point.y})</b>");
    	$this->data["series"][0]=array("name"=>"name","data"=>array(array("data1",1),array("data2",2),array("data3",3)));
    }

    public function optionsEditShow(){
    	echo "<input name='type' value='pie' type='hidden'>";
		echo "<h3>标题</h3>";
		echo "<input id='title_text' name='title' class='form-control' value='{$this->data["title"]["text"]}' placeholder='填写标题' type='text' size='20'>";
		echo "<hr><h3>副标题</h3>";
		echo "<input id='subtitle_text' name='subtitle' class='form-control' value='{$this->data["subtitle"]["text"]}' placeholder='{$this->data["subtitle"]["text"]}' type='text' size='30'>";
		echo "<div class='checkbox img_tooltip'><label><input name='legend_enable'  value='1' type='checkbox' class='hover_img_show'>显示数据刻度</label><div><img src='images/legend.png'></img></div></div>";
		echo "<div class='radio img_tooltip'>	<label><input name='legend_show'  value='label_show_inner' class='hover_img_show' checked='true' type='radio'>内部标签</label><div><img src='images/legend.png'></img></div></div>";
		echo "<div class='radio img_tooltip'>	<label><input name='legend_show'  value='label_show_outer' class='hover_img_show'  type='radio'>外部标签</label><div><img src='images/legend.png'></img></div></div>";
		echo "<div class='checkbox img_tooltip'><label><input type='checkbox' name='half_circle' value='1' class='hover_img_show'>半圆显示</label><div><img src='images/legend.png'></img></div></div>";
    } 
    public function optionsEditAction($data){
    	$this->data["chart"]=array("type"=>"pie");
    	$this->data["title"]["text"]=$data["title"];
		$this->data["subtitle"]["text"]=$data["subtitle"];
		$this->data["xAxis"]["title"]["text"]=$data["x_title"];
		#刻度
		if(!isset($data["legend_enable"])) 	
		 	$this->data["legend"]["enabled"]=false;
		else
			$this->data["legend"]["enabled"]=true;
		
		if(isset($data["legend_show"])&& $data["legend_show"]=="label_show_inner"){
			$this->data["plotOptions"]["pie"]=array("dataLabels"=>array("enabled"=>"true","distance"=>-50));
		}else{
			$this->data["plotOptions"]["pie"]=array("dataLabels"=>array("enabled"=>"true"));
		}	
		if(isset($data["half_circle"])){
			$this->data["plotOptions"]["pie"]["startAngle"]=-90;
			$this->data["plotOptions"]["pie"]["endAngle"]=90;
			$this->data["plotOptions"]["pie"]["center"]=array('50%', '75%');
		}else{
			
		}
		if(isset($data["legend_enable"])){
			$this->data["plotOptions"]["pie"]["showInLegend"]="true";
		}
    }
    public function seriesEditShow(){
    	echo "<div class='data_edit'>";
    	echo "<table class='table table-bordered'>";
		echo "<thead>"	;			
		echo "<tr id='series_thead_tr'>"	;
		echo "<th>Name</th><th>Value</th>";				
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";				
										
		
		foreach($this->data["series"][0]["data"] as $d){
			echo "<tr class='series_body_tr'>";
			echo "<td contenteditable>{$d[0]}</td>";
			echo "<td contenteditable>{$d[1]}</td>";			
			echo "<td ><a href='#' class='delete_row'>删除本行</a></td>";
			echo "</tr>";
		}
		
		for($i=0;$i<10;$i++){
			echo "<tr class='series_body_tr editable'>";
			echo "<td contenteditable>可编辑</td>";
			echo "<td contenteditable>可编辑</td>";			
			echo "<td ><a href='#' class='delete_row'>删除本行</a></td>";
			echo "</tr>";
		}			
		
		echo "</tbody>"	;				
		echo "</table>"	;
		echo "</div>"	;
    }
    public function seriesEditAction($data){
 		
 	}
 	public function seriesCover($data){
 		if($data==null) return;
 	}
 }
 class Dim2PieChart extends Chart{ 

    public function demo(){ 
     	$this->data["chart"]=array("type"=>"dim2pie");	
 		$this->data["title"]=array("text"=>"标题");
 		$this->data["subtitle"]=array("text"=>"副标题");
    	$this->data["series"][0]=array("name"=>"name0","size"=>"60%","dataLabels"=>array("distance"=>-30));
    	$this->data["series"][1]=array("name"=>"name1","size"=>"80%","innerSize"=>"62%");
    	$this->data["colors"]=array("#C80000","#C800C8","#0062FF","#00AAFF","#00B400");
    	$this->data["series"][0]["data"]=array(array("name"=>"data1","y"=>80,"color"=>"#Cccccc"),array("name"=>"data2","y"=>100),array("name"=>"data3","y"=>40));
    	$this->data["series"][1]["data"]=array(array("name"=>"d1","y"=>40,"color"=>"#Cccccc"),array("name"=>"d2","y"=>40,"color"=>"#Cccccc"),array("name"=>"2","y"=>100),array("name"=>"d3","y"=>40));
    }
 	public function optionsEditShow(){
 		echo "<input name='type' value='pie' type='hidden'>";
 		echo "<h3>标题</h3>";
 		echo "<input id='title_text' name='title' class='form-control' value='{$this->data["title"]["text"]}' placeholder='填写标题' type='text' size='20'>";
 		echo "<hr><h3>副标题</h3>";
 		echo "<input id='subtitle_text' name='subtitle' class='form-control' value='{$this->data["subtitle"]["text"]}' placeholder='{$this->data["subtitle"]["text"]}' type='text' size='30'>";
 		$checked='';
		//if(isset($this->data["legend"]["enabled"])&&$this->data["legend"]["enabled"]==true)
			//$checked="checked='true'";
 		//echo "<div class='checkbox img_tooltip'><label><input name='legend_enable' {$checked} value='1' type='checkbox' class='hover_img_show'>显示数据刻度</label><div><img src='images/legend.png'></img></div></div>";
		
 	}
	public function optionsEditAction($data){
    	$this->data["chart"]=array("type"=>"pie");
    	$this->data["title"]["text"]=$data["title"];
    	$this->data["subtitle"]["text"]=$data["subtitle"];
    	if(isset($data["legend_enable"])){
    		$this->data["plotOptions"]["pie"]["showInLegend"]="true";
    	}
    }
 	public  function seriesEditShow(){
 		echo "<table class='table table-bordered linetable' id='table0'>";
		echo "<thead>"	;			
		echo "<tr id='series_head_tr'>"	;
		echo "<th>Name<input type='hidden' class='edit_input' value='1'/></th>";
		echo "<th>Value<input type='hidden' class='edit_input' value='2'/></th>";
		echo "<th>Color<input type='hidden' class='edit_input' value='3'/></th>";
		echo "<th>内圆=0/外圆=1<input type='hidden' class='edit_input' value='4'/></th>";
		
		echo "</tr>";
		echo "</thead>"	;			
		echo "<tbody>";				
		//数据	 
		foreach($this->data["series"][0]["data"] as $d){
			echo "<tr class='seires_body_tr'>";
			echo "<td><input type='text' class='edit_input' value='{$d["name"]}'/><a class='delete_row' href='#'><i class='entypo-cancel'></i></a></td>";
			echo "<td><input type='text' class='edit_input' value='{$d["y"]}'/></td>";
			if(isset($d["color"])) 
 				$color=$d["color"];
 			else $color="#默认颜色";
 			echo "<td><input type='text' class='edit_input' value='{$color}'/></td>";
 			echo "<td><input type='text' class='edit_input' value='0'/></td>";
			echo "</tr>";
		}
		foreach($this->data["series"][1]["data"] as $d){
			echo "<tr class='seires_body_tr'>";
			echo "<td><input type='text' class='edit_input' value='{$d["name"]}'/><a class='delete_row' href='#'><i class='entypo-cancel'></i></a></td>";
			echo "<td><input type='text' class='edit_input' value='{$d["y"]}'/></td>";
			if(isset($d["color"])) 
 				$color=$d["color"];
 			else $color="#默认颜色";
 			echo "<td><input type='text' class='edit_input' value='{$color}'/></td>";
 			echo "<td><input type='text' class='edit_input' value='1'/></td>";
			echo "</tr>";
		}
		for($i=0;$i<10;$i++){
			echo "<tr class='series_body_tr editable'>";
			echo "<td><input type='text' class='edit_input' value='可编辑'/></td>";
			echo "<td><input type='text' class='edit_input' value='可编辑'/></td>";
			echo "<td><input type='text' class='edit_input' value='可编辑'/></td>";
			echo "<td><input type='text' class='edit_input' value='可编辑'/></td>";
			echo "</tr>";
			
		}
		echo "</tbody>"	;			
		echo "</table>"	;		
 		
 		}
 		/**
 		 * 在这里把字符串解析后赋值给series
 		 */
 		public function seriesEditAction($data){
 			$this->data["series"][1]=array("name"=>"1","size"=>"80%","innerSize"=>"62%");
    		$this->data["series"][0]=array("name"=>"0","size"=>"60%","dataLabels"=>array("distance"=>-30));
    		$this->data["series"][0]["data"]=array();
    		$this->data["series"][1]["data"]=array();
 			
 			//arr0内外环数据
 			$arr0=explode(":",$data);
 			$arr0=$arr0[1];
 			//$arr_data0数组，每条的数据 
 			$arr_data0=explode(";",$arr0);
 			
 			foreach($arr_data0 as $s){
 				$one=explode(",",$s);
 				if($one[3]==0){
 					$a=array("name"=>$one[0],"y"=>(float)$one[1],"color"=>$one[2]);
 					array_push($this->data["series"][0]["data"],$a);
 				}else{
 					$a=array("name"=>$one[0],"y"=>(float)$one[1],"color"=>$one[2]);
 					array_push($this->data["series"][1]["data"],$a);
 				}
 			}
 		}
 		public function seriesCover($data){	
    		$this->data["series"]=$data["series"];
 		}
 		
 	}
 class LineAndColumnChart extends Chart{
 	/**
 	 * 提供DEMO
 	 */
 	public function demo(){
		parent::demo();
		$this->data["chart"]=array("zoomType"=>"xy");
 		$this->data["title"]=array("text"=>"未关闭缺陷情况");
		$this->data["xAxis"]=array("categories"=>array('1.2.0', '2.1.1', '2.1.2', '2.5.3', '3.0.0'));
		$this->data["yAxis"]=array(
			array("title"=>array("text"=>"未关闭bugDI值","style"=>array("color"=>"#89A54E"))),
			array("title"=>array("text"=>"缺陷数(单位：个)","style"=>array("color"=>"#4572A7")),"opposite"=>true)		
		);
		$this->data["tooltip"]=array("shared"=>true);
		$this->data["series"]=array(
			array("name"=>"1级bug","color"=>"#4572A7","type"=>"column","yAxis"=>1,"data"=>array(4, 3, 1, 5, 4)),
			array("name"=>"2级bug","color"=>"#7cb5ec","type"=>"column","yAxis"=>1,"data"=>array(1, 7, 4, 3, 5)),
			array("name"=>"未关闭bugDI值","color"=>"#89A54E","type"=>"spline","data"=>array(31,12,13,17,15))
		);

 	}
 	
 	/**
 	 * 图表参数编辑区，在图表编辑页面调用
 	 */
 	public function optionsEditShow(){
 		echo "<h3>标题</h3>";
		echo "<input id='title_text' name='title' class='form-control' value='{$this->data["title"]["text"]}' placeholder='{$this->data["title"]["text"]}' type='text' size='20'>";
		echo "<hr><h3>副标题</h3>";
		echo "<input id='title_text' name='subtitle' class='form-control' value='{$this->data["subtitle"]["text"]}' placeholder='{$this->data["subtitle"]["text"]}' type='text' size='20'>";
		echo "<hr><h3>X轴坐标</h3>";	
		$default_value="";
		if(isset($this->data["xAxis"]["title"]["text"]))
			$default_value=$this->data["xAxis"]["title"]["text"];
		echo "<input id='xAxis_text' name='x_title' class='form-control' class='options_input' value='{$default_value}' placeholder='X轴文字'  type='text'>";

		if(count($this->data["yAxis"])!=2){
			echo "<hr><h3>Y轴坐标</h3>";
			$default_value="";
			if(isset($this->data["yAxis"]["title"]["text"]))
				$default_value=$this->data["yAxis"]["title"]["text"];
			echo "<input id='yAxis_text' name='y_title' class='form-control' class='options_input' value='{$default_value}' placeholder='Y轴文字'  type='text'>";
		}
		else{
			echo "<hr><h3>左边Y轴坐标</h3>";
			$default_value="";
			if(isset($this->data["yAxis"][0]["title"]["text"]))
				$default_value=$this->data["yAxis"][0]["title"]["text"];
			echo "<input id='yAxis_text_0' name='y_left_title' class='form-control' class='options_input' value='{$default_value}' placeholder='左边Y轴文字'  type='text'>";
			echo "<hr><h3>右边Y轴坐标</h3>";
			$default_value="";
			if(isset($this->data["yAxis"][1]["title"]["text"]))
				$default_value=$this->data["yAxis"][1]["title"]["text"];
			echo "<input id='yAxis_text_1' name='y_right_title' class='form-control' class='options_input' value='{$default_value}' placeholder='右边Y轴文字'  type='text'>";
		}

		$default_value='';
		if($this->data["legend"]["enabled"])
			$default_value="checked='true'";
		echo "<div class='checkbox img_tooltip'><label><input name='legend_enable'  value='1' {$default_value} type='checkbox' class='hover_img_show'>显示数据刻度</label><div><img src='images/legend.png'></img></div></div>";
		$checked="";
 	}
 	public function optionsEditAction($data){
 		$this->data["title"]["text"]=$data["title"];
		$this->data["subtitle"]["text"]=$data["subtitle"];
		$this->data["xAxis"]["title"]["text"]=$data["x_title"];
		#刻度
		if(!isset($data["legend_enable"])) 	
		 	$this->data["legend"]["enabled"]=false;
		else
			$this->data["legend"]["enabled"]=true;
		#y轴
		if(!isset($data["y_right_title"])){
			$this->data["yAxis"]["title"]["text"]=$data["y_title"];
			
		}
		else{
			$this->data["yAxis"][0]["title"]["text"]=$data["y_left_title"];
			$this->data["yAxis"][1]["title"]["text"]=$data["y_right_title"];
		}
 	}
 	/**
 	 * 图表数据编辑区，在图表编辑页面调用
 	 */
 	public function seriesEditShow(){
 		echo "<table class='table table-bordered linetable' id='table0'>";
		echo "<thead>"	;			
		echo "<tr id='series_head_tr'>"	;
		echo "<th>Name<input type='hidden' class='edit_input' value='name'/></th>";
		echo "<th>Type<input type='hidden' class='edit_input' value='type'/></th>";
		echo "<th>yAxis<input type='hidden' class='edit_input' value='yAxis'/></th>";
		$col=0;
		//xAxis刻度				
		foreach($this->data["xAxis"]["categories"] as $v){
			$col++;
			echo "<th class='col{$col}'><input type='text' class='edit_input' value='{$v}'/><a class='delete_col' href='#'><i class='entypo-cancel'></i></a></th>";
		};
		for($i=0;$i<20;$i++){	
			$col++;		
			echo "<th class='col{$col}'><input type='text' class='edit_input' value='可编辑'/><a class='delete_col' href='#'><i class='entypo-cancel'></i></a></th>";
		}
		echo "</tr>";
		echo "</thead>"	;			
		echo "<tbody>";				
		//数据		 
		foreach($this->data["series"] as $d){
			echo "<tr class='seires_body_tr'>";
			echo "<td><input type='text' class='edit_input' value='{$d["name"]}'/><a class='delete_row' href='#'><i class='entypo-cancel'></i></a></td>";
			echo "<td><input type='text' class='edit_input' value='{$d["type"]}'/></td>";
			if(!isset($d["yAxis"])) $d["yAxis"]=0;
			echo "<td><input type='text' class='edit_input' value='{$d["yAxis"]}'/></td>";
			$col=0;
			//循环放置数据到表格
			foreach($d["data"] as $a){
				$col++;
				echo "<td class='col{$col}'><input type='text' class='edit_input' value='{$a}'/></td>";
			}
			for($i=0;$i<20;$i++){		
				$col++;	
				echo "<td class='col{$col}'><input type='text' class='edit_input' value='可编辑'/></td>";
			}
			echo "</tr>";
		}
		for($i=0;$i<10;$i++){
			echo "<tr class='seires_body_tr'>";	
			echo "<td><input type='text' class='edit_input' value='可编辑'/</td>";	
			$col=0;	
			for($j=0;$j<count($this->data["xAxis"]["categories"]);$j++){
				$col++;
				echo "<td class='col{$col}'><input type='text' class='edit_input' value='可编辑'/></td>";
			}
			for($j=0;$j<20;$j++){		
				$col++;	
				echo "<td class='col{$col}'><input type='text' class='edit_input' value='可编辑'/></td>";
			}
			echo "</tr>";
		}
		echo "</tbody>"	;			
		echo "</table>"	;					
 	}
 	public function seriesEditAction($data){
 		$this->data["series"]=array();
			//array("name"=>"1级bug","color"=>"#4572A7","type"=>"column","yAxis"=>1,"data"=>array(4, 3, 1, 5, 4)),
		$thtr=explode(":",$data);
		$ths=explode(",",$thtr[0]);
		$ths_data=array();
		for($i=3;$i<count($ths);$i++){
			array_push($ths_data,$ths[$i]);
		}
		$this->data["xAxis"]["categories"]=$ths_data;
		$tdtr=explode(";",$thtr[1]);
		foreach($tdtr as $tr){
			$tds=explode(",",$tr);
			$tds_name=$tds[0];
			$tds_type=$tds[1];
			$tds_yAxis=$tds[2];
			$tds_data=array();
			for($i=3;$i<count($tds);$i++){
				array_push($tds_data,(float)$tds[$i]);
			}
			array_push( $this->data["series"],array("name"=>$tds_name,"type"=>$tds_type,"yAxis"=>(float)$tds_yAxis,"data"=>$tds_data));
		}
		
 	}
 	public function seriesCover($data){
 		if($data==null) return;
 		$this->data["xAxis"]["categories"]=$data["xAxis"]["categories"];
 		$this->data["series"]=$data["series"];
 	}
 	public function calculate($data){
 		$this->data=$data;
 	}
 
 }

 class D3Chart extends Chart{
 	public function demo(){		
 	}
 	public function optionsEditShow(){
 	}
 	public function optionsEditAction($data){
 	}

 	public function seriesEditShow(){	
 	}
 	public function seriesEditAction($data){
 	}
 	public function seriesCover($data){
 		if($data==null) return;
 		$this->data["series"]=$data;
 	}
 }
?>
