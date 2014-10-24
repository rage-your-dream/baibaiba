<?php

 class Modal{
 	public $data;
 	public function show(){
 		echo "<div aria-hidden='true' style='display: none; max-height: 840px;' class='modal fade ' id='{$this->data['model_id']}'>";
		echo "<div class='modal-dialog'>"	;
		echo "<div class='modal-content'>";
		echo "<div class='modal-header'>" ;
		echo "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>";
		echo "<h4 class='modal-title'>{$this->data['model_title']}</h4>"	;	
		echo "</div>";		
		
		echo "<div class='modal-body'>";	
		if(isset($this->data['content']))
			echo $this->data['content'];
			
		echo "</div>";
		echo "<div class='modal-footer'>";
		//echo "<button type='button' class='btn btn-default' data-dismiss='modal'>关闭</button>"	;
		//<button type="button" class="btn btn-info">Save changes</button>
		echo "</div>";
		echo "</div>";
		echo "</div>";
		echo "</div>";
 	}
 	public function showConfirmModel(){
 		echo "<div aria-hidden='true' style='display: none;' class='modal fade in' id='{$this->data['model_id']}'>";
 		echo "<div class='modal-dialog'  >";
		echo "<div class='modal-content'>";
		echo "<div class='modal-header'><h4 class='modal-title'>{$this->data["title"]}</h4></div>";
		echo "<div class='modal-body'>{$this->data["content"]}</div>";
		echo "<div class='modal-footer'>"	;
		echo "<button type='button' class='btn btn-info' data-dismiss='modal'>{$this->data['but_name']}</button>"	;
		echo "</div></div></div></div>"	;
 	}
 }
 
?>
