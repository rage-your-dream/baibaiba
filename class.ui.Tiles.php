<?php
/*
 * Created on 2014-7-13
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 class Tile{
 	public $title="主题";
 	public $introduce="***请简单介绍***";
 	public $color="tile-primary";
 	public $icon="entypo-gauge";
 	public $data=array();
	public function setValues(){
		if(isset($this->data["title"])){
			$this->title=$this->data["title"];
		}
		if(isset($this->data["introduce"])){
			$this->introduce=$this->data["introduce"];
		}
		if(isset($this->data["color"])){
			$this->color=$this->data["color"];
		}
		if(isset($this->data["icon"])){
			$this->icon=$this->data["icon"];
		}
	}
 	
 	public function show(){
 		if(isset($this->data["drag_id"])){
 			echo "<div class='tile-title {$this->color} dragable drsElement' data_drag_id='{$this->data["drag_id" ]}' style='position:fixed;left:{$this->data['left']};top:{$this->data['top']};'>" ;
 		}
 		else echo "<div class='tile-title {$this->color} dragable drsElement' >" ;
		echo "<div class='icon'>";	
		echo "<i class=' {$this->icon}'></i></div>";
		echo "<div class='title'>";
		echo "<h3>{$this->title}</h3>";	
		echo "<p>{$this->introduce}</p>";
		echo "</div></div>";
 	}
 	
 }
 class StatsTile extends Tile{
 	public $datashow=99;
	public function setValues(){
		parent::setValues();
		if(isset($this->data["datashow"])){
			$this->datashow=$this->data["datashow"];
		}
	}
 	public function show(){
 		if(isset($this->data["drag_id"])){
 			echo "<div class='tile-title {$this->color} dragable' data_drag_id='{$this->data["drag_id" ]}' style='position:fixed;left:{$this->data['left']};top:{$this->data['top']};'>" ;
 		}else{
 			 echo "<div class='tile-stats {$this->color} dragable' >"  ;
 		}
		echo "<div class='icon'><i class='{$this->icon}' ></i></div>" ; 
		echo "<div class='num' data-start='0' data-end='{$this->datashow}' data-prefix='' data-postfix='' data-duration='1500' data-delay='0' >000</div>";
		echo "<h3>{$this->title}</h3>";		
		echo "<p>{$this->introduce}</p>";
		echo "</div>";
 	}
 }
 class ProcessTile extends Tile{
 	//public $width=0.5;
 	public $data_fill=0.5;
 	public $footer="";
 	public function setValues(){
		parent::setValues();
		if(isset($this->data["data_fill"])){
			$this->data_fill=$this->data["data_fill"];
		}
		if(isset($this->data["footer"])){
			$this->footer=$this->data["footer"];
		}
	}
 	public function show(){
 		echo "<div class='tile-progress {$this->color}'> " ;
		echo "<div class='tile-header'>"	;
		echo "<h3>{$this->title}</h3>" ;
		echo "<span>{$this->introduce}</span>";
		echo "</div>" ;		
		echo "<div class='tile-progressbar'>";
		echo "<span style='width: {$this->data_fill};' data-fill='{$this->data_fill}'></span>";	
		echo "</div>";
		echo "<div class='tile-footer'><h4>";
		echo "<span class='pct-counter'>{$this->data_fill}</span>%"	;
		echo "</h4><span>{$this->footer}</span></div> </div>"	;
 	}
 }
 
  class BlockTile extends Tile{
 	//public $width=0.5;
 	public $data_fill=0.5;
 	public $footer="";
 	public function setValues(){
		parent::setValues();
		if(isset($this->data["data_fill"])){
			$this->data_fill=$this->data["data_fill"];
		}
		if(isset($this->data["footer"])){
			$this->footer=$this->data["footer"];
		}
	}
 	public function showDemo($_id){
 		//头部
 		echo "<div class='tile-block {$this->color} dragable' id='{$_id}'>" ;
		echo "<div class='tile-header'>";	
		echo "<i class='entypo-list'></i>";
		echo "<a href='#'>{$this->title}<span>To do list, tick one.</span></a>";	
		echo "</div>";	
		
		//身体		
		echo "<div class='tile-content'>"	;
		echo "<p>请按照如下验收标准</p>";
		echo "<input class='form-control' placeholder='Add Task' type='text'>"	;
		echo "<ul class='todo-list'>"	;
		echo "<li>";		
		echo "<div class='checkbox checkbox-replace color-white neon-cb-replacement'>"	;	
		echo "<label class='cb-wrapper'><input type='checkbox'><div class='checked'></div></label>"	;	
		echo "<label>Website Design</label>"	;			
		echo "</div>";
		echo "</li>";	
		
		echo "<li>";		
		echo "<div class='checkbox checkbox-replace color-white neon-cb-replacement checked'>"	;	
		echo "<label class='cb-wrapper'><input type='checkbox'><div class='checked'></mdiv></label>"	;	
		echo "<label>Slicing</label>"	;			
		echo "</div>";
		echo "</li>";				
		echo "</ul>";				
		echo "</div>";			
		echo "<div class='tile-footer'><a href='#'>View all tasks</a>";
		echo "<button type='button' class='btn btn-block'>提交</button>"  ;
 		echo "</div></div>"	;
		
 	}
 }
?>
