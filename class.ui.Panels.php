<?php
 /**
  * 表盘页面panel
  */
 class Panel{
 	public $data;
 	public $options="";
 	public function addOption($class,$tooltip,$entypo){
		$this->options.="<a href='#'  class='{$class} tooltip-default' data-toggle='tooltip' data-placement='top' title='' " .
			"data-original-title='{$tooltip}' ><i class='$entypo'></i></a> ";	
		
 	}
 	public function addOptionCreate(){
 		$this->addOption("create","点击创建图表","entypo-check");
 	}
 	/**
 	 * 显示帮助按钮
 	 */
 	public function addOptionHelp(){
 		$this->addOption("toggle_help_msg","点击显示图表介绍","entypo-help");
 	}
 	 /**
 	 * 显示点赞按钮
 	 */
 	public function addOptionPraise($praiseStatus,$totalPraise){
 		if($praiseStatus == 0) //没有点赞
 			$this->options.="<a href='#' class='praise'><i style='color:red;font-size:130%' class='entypo-heart-empty'></i>　赞(<span>".$totalPraise."</span>)</a> ";
 		elseif($praiseStatus == 1) //已经点赞
 			$this->options.="<a href='#' class='praise'><i style='color:red;font-size:130%' class='entypo-heart'></i>已赞(<span>".$totalPraise."</span>)</a> ";
 	}
 	/**
 	 * 显示刷新
 	 */
 	public function addOptionFresh(){
 		$this->addOption("fresh","点击刷新图表","entypo-arrows-ccw");
 	}
 	/**
 	 * 显示分析按钮
 	 */
 	public function addOptionAnalysis($isshow=null){
 		if($isshow)
 			$this->addOption("toggle_analysis_msg","点击关闭图表分析","entypo-doc");
 		else
 			$this->addOption("toggle_analysis_msg","点击显示图表分析","entypo-picture");
 	}
 	/**
 	 * 显示数据锁按钮
 	 */
 	public function addOptionDataLock($isdatalock=null){
 		if($isdatalock)
 			$this->addOption("lock","点击图表随页面刷新","entypo-lock");
 		else
 			$this->addOption("lock","点击图表数据锁定","entypo-lock-open");
 	}
 	/**
 	 * 显示编辑按钮
 	 */
 	public function addOptionEdit(){
 		$this->addOption("edit","点击进行内容编辑","entypo-pencil");
 	}
 	
 	/**
 	 * 显示图表删除按钮
 	 */
 	public function addOptionDelete(){
 		$this->addOption("delete","点击删除图表","entypo-trash");
 	}
 	/**
 	 * 显示放大和缩小按钮
 	 */
 	public function addOptionChangeSize(){
 		$this->addOption("smaller","点击缩小1号","entypo-resize-small");
 		$this->addOption("larger","点击放大1号","entypo-resize-full");
 	}

 	/**
 	 * panel本身属性设置，宽高等
 	 */
 	public function show(){
 		$id=0;
 	 	if(isset($this->data["id"]))
 	 		$id=$this->data["id"];
 	 	$width="11";
 	 	if(isset($this->data["width"]))
 	 		$width="col-xs-".$this->data["width"];
 	 	$style="";
 	 	if(isset($this->data["left"])&&isset($this->data["top"])){
 			$style="style='position:absolute;left:{$this->data["left"]};top:{$this->data["top"]}'";
 		}
 	 	$title="";
 	 	if(isset($this->data["title"]))
 	 		$title=$this->data["title"];
 	 	if(!isset($this->data["dragable"]))
 	 		$this->data["dragable"]="";
 	 	$format= "<div class='panel panel-primary %s %s' id='panel%s' %s>" ;
 		printf($format,$width,$this->data["dragable"],$id,$style);
 		echo "<div class='panel-heading'>"	;
		echo "<div class='panel-title'>{$title}</div>";
		echo "<div class='panel-options'>$this->options</div>";	
		echo "</div>"; //头部几位数
		echo "<div class='panel-body'> "; 
		if(is_string($this->data["content"])){
			echo $this->data["content"];
		}else{
			$this->data["content"]->show();
		}
		echo "</div>";//body结束
 		echo "</div>";//panel结束
 	 } 
 	
 }
 
?>
