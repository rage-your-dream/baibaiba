<?php
session_start();
require_once "mail/PHPMailerAutoload.php";
require_once "class.bean.Mail.php";
require_once "config_visible.php";
require_once "config.php";

function sendMail($m){
	$mail = new PHPMailer();
	//刘浩增加 addBCC
	$mail->addBCC("liuhao_17173@cyou-inc.com","liuhao");
	$mail->From     = $m->data["From"];
	$mail->FromName = $m->data["FromName"];
	#$mail->SMTPAuth = true;
	$mail->Host     = MAIL_HOST;
	$mail->Port     = MAIL_HOST_PORT;
	$mail->isSMTP();
	$mail->CharSet="utf-8";
	$mail->Subject =$m->data["Subject"];
	$id=0;
	$img_name=$_SESSION["email"];
	
	$msg="";
	if(isset($m->data["msg"])){
		$msg=$m->data["msg"];
	}
	$mail->AddEmbeddedImage(SNAP_DIR_PATH."{$img_name}.jpg", $id, 'attachment', 'base64', 'image/jpeg');
	$img='<img alt="" src="cid:'.$id.'" style="border: none;" />';
	$mail->Body    = $m->boardMail($msg,$img);
	
    $mail->AltBody = "不能显示HTML格式邮件内容";
    foreach($m->data["To"] as $to){
    	$mail->addAddress($to,$to);
    }
    
    //$mail->addStringAttachment($row['photo'], 'YourPhoto.jpg');
    if(!$mail->send()){
    	print_r($m->data);
    	echo "邮件发送过程遇到问题 <br>";
    	echo $mail->ErrorInfo;
    	exit;
    }   
    else echo "邮件发送成功";

}
if(isset($_GET["to"])){
	$mail=new Mail();
	$mail->data["From"]=MAIL_FROM;
	$mail->data["FromName"]="质量部门户系统";
	if(isset($_GET["subject"])){
		$mail->data["Subject"]=$_GET["subject"];
	}else echo "请填写邮件主题";
	if(isset($_GET["to"])){
		$mail->data["To"]=explode(";",$_GET["to"]);
	}else echo "请填写收件人";
	if(isset($_GET["msg"])){
		$mail->data["msg"]=$_GET["msg"];
	}
	if(isset($_GET["img_name"])){
		$mail->data["img_name"]=$_GET["img_name"];
	}else echo "img_name 丢失";
	sendMail($mail);
}else if(isset($_POST["to"])){
	$mail=new Mail();
	$mail->data["From"]=MAIL_FROM;
	$mail->data["FromName"]="质量部门户系统";
	if(isset($_POST["subject"])){
		$mail->data["Subject"]=$_POST["subject"];
	}else echo "请填写邮件主题";
	if(isset($_POST["to"])){
		$mail->data["To"]=explode(";",$_POST["to"]);
	}else echo "请填写收件人";
	if(isset($_POST["msg"])){
		$mail->data["msg"]=$_POST["msg"];
	}
	if(isset($_POST["img_name"])){
		$mail->data["img_name"]=$_POST["img_name"];
	}else echo "img_name 丢失";
	sendMail($mail);
}


?>
