<?php
/*
 * Created on 2014-7-23
 * author : PP
 */


 class Mail{
 	public $data;
 	/**
 	 * 发送报表截图邮件
 	 */
 	public function boardMail($msg,$content){
 		$file = "mail/template/board_mail.html";
		$mailbody = file_get_contents($file);//读取demo中内容
		$mailbody = str_replace("REPLACE_MSG",$msg,$mailbody);
		$mailbody = str_replace("REPLACE_IMG",$content,$mailbody);
		return $mailbody;
 	}
 	function displayMailForm($errorMsg=Null){
		$m= "<div id='mail_div'><form method='post' id='mail_form' action='mail.php'>";
		$m=$m. "<fieldset id='fieldset'>";
		$m=$m. "<input id='send_mail' type='submit' data-dismiss='modal' value='发送' class='mail_input' onclick='abc();'/><br>";
		$m=$m. "<input type='text' name='subject' id='mail_subject' style='width:95%;' class='mail_input' placeholder='邮件主题'><br>";
		$m=$m. "<input type='text' style='width:95%;' name='to' id='mial_to' class='mail_input' placeholder='收件人（; 隔开）'><br>";
		$m=$m. "<textarea cols='90' name='msg' id='mail_msg' rows='3' style='width:95%;' class='mail_input' placeholder='内容说明'></textarea>";
		$m=$m. "<input type='hidden' id='mail_img_name' name='img_name' value='home'>";
		$m=$m. "</fieldset>";
		$m=$m. "</form></div>";
		$m=$m. "<hr>";
		return $m;
	}
 }
 
 
 ?>