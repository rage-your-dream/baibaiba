<?php
class picture{
	/**
	 * $data 结构
	 * data["src"] 图片相对存放位置
	 * data["title"] 图片主题
	 * data["introduce"] 图片介绍
	 * data["heart_num"] 点赞数
	 */
	public $data;
	
	public function show(){
		echo "<article class=\"album\">";
		//图片显示在头部
		echo "<header>"	;
		echo "<a href=''>";		
		echo "<img src='{$this->data["src"]}' class='img-responsive img-rounded full-width'>";
		echo "</a>"	;
		//echo "<a href='#' class='album-options'><i class='entypo-cog'></i></a>";			
		echo "</header>";
				
		//主题部分
		echo "<section class='album-info'>";
		echo "<h3><a href=''>{$this->data["title"]}</a></h3>"	;	
		echo "<p>{$this->data["introduce"]}</p>"	;		
		echo "</section>"	;		
					
		//foot
		echo "<footer class='album-footer'>";	
		echo "<div class='row'>";	
		echo "<div class='col-xs-10'>";		
		echo "<div class='album-images-count'><i class='entypo-heart'></i>{$this->data["heart_num"]}</div>";
		echo "</div>";
		echo "<div class='col-xs-2'>";
		echo "<div class='album-options'><a href='#'><i class='entypo-trash'></i></a></div>";	
		echo "</div>";	
		echo "</div>";				
		echo "</footer>";				
		echo "</article>";

	}
}
?>
