<?php

class Timeline{
	public $data;
	public $picture;
	public $scrum;
	public function showDay(){
		
		echo "<li>";
		echo "<time class=\"cbp_tmtime\" datetime=\"{$this->data["day"]}\"><span >{$this->data["day"]}</span> <span class=\"large\"></span></time>";		
		echo "<div class=\"cbp_tmicon bg-success\"><i class=\"entypo-tag\"></i></div>";		
		echo "<div class=\"cbp_tmlabel \">";
		if(isset($this->scrum))
			$this->scrum->show();
		if(isset($this->picture))
			$this->picture->show();
		
		echo "</div>";
		echo "</li>";
	}
	public function showWeek(){
		
	}
	public function showMonth(){
		
	}
}
class SvnTimeline{
	/**
	 * 介绍
	 */
	public function showLog($log){
		echo "<p>".$log["datetime"]."&nbsp;&nbsp;".$log["user"]."&nbsp;&nbsp;"."版本号-".$log["num"]."&nbsp;&nbsp;".$log["msg"]."</p>";
	}
	public function showBVersion($version,$log){
		echo "<div>";
		echo "<h2>新branches版本".$version["url"]."</h2>";
		echo "<p>".$log["datetime"]."&nbsp;&nbsp;".$log["user"]."&nbsp;&nbsp;"."版本号-".$log["num"]."&nbsp;&nbsp;".$log["msg"]."</p>";
		echo "</div>";
	}
	public function showTVersion($version,$log){
		echo "<div>";
		echo "<h2>新tags版本".$version["url"]."</h2>";
		echo "<p>".$log["datetime"]."&nbsp;&nbsp;".$log["user"]."&nbsp;&nbsp;"."版本号-".$log["num"]."&nbsp;&nbsp;".$log["msg"]."</p>";
		echo "</div>";
	}
}
class ScrumTimeline{
	public $alldata;
	public function show(){
		foreach($this->alldata as $data){
			echo "<div>";
			echo "<h4>".$data["finish_datetime"]."&nbsp;|&nbsp;".$data["ower_name"]."&nbsp;|&nbsp;".$data["name"]."</h4>";
			echo "<p>"."&nbsp;&nbsp;Sprint-".$data["sprint_num"]."-".$data["target"]."</p>";
			echo "</div>";
		}
	}
}
class PictureTimeline{
	/**
	 * data 结构:
	 */
	public $data;
	public function show(){
		echo "<div>";
		$count=count($this->data["picture"]);
		if($count>6){
			foreach($this->data["picture"] as $pic){
				echo "<img src=\"{$pic['path']}\" class=\"img-responsive img-rounded full-width\">";
			}
		}else{
			foreach($this->data["picture"] as $pic){
				echo "<img src=\"{$pic['path']}\" class=\"img-responsive img-rounded full-width\">";
			}
		}
		echo "<div>";
	}
}
?>
