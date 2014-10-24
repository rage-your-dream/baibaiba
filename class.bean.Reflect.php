<?php
require_once "class.db.Chart.php";
class Relect{
	public $chart_machine;
	function __construct($class_name){
		$this->chart_machine[]=new $class_name(); 
	}
	function __call($name,$args){
		foreach($this->chart_machine as $obj){
			$a=new ReflectionClass($obj);
			if($method=$a->getMethod($name)){
				$method->invoke($obj,$args);
			} 
		}
	}	
}

?>
