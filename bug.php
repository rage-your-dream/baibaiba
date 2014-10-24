<?php
session_start();
require_once "checkstatus.php";
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>质量部</title>
	

	<link rel="stylesheet" href="js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css" id="style-resource-1">
	<link rel="stylesheet" href="css/font-icons/entypo/css/entypo.css" id="style-resource-2">
	<link rel="stylesheet" href="css/bootstrap-min.css" id="style-resource-4">
	<link rel="stylesheet" href="css/neon-core-min.css" id="style-resource-5">
	<link rel="stylesheet" href="css/neon-theme-min.css" id="style-resource-6">
	<link rel="stylesheet" href="css/neon-forms-min.css" id="style-resource-7">
	<link rel="stylesheet" href="css/custom-min.css" id="style-resource-8">
	<link rel="stylesheet" href="css/mycss/scrum.css" id="style-resource-11">
	<link rel="stylesheet" href="css/mycss/mail.css" id="style-resource-11">
	<script type=text/javascript src="js/jquery-2.1.0.min.js"></script>
 
</head>
<?php
require_once "class.ui.Tiles.php";
require_once "class.ui.Panels.php";
require_once "class.ui.Models.php";
require_once "class.db.Bug.php";
?>
<body class="page-body loaded" >
<div class="page-container <?php if(isset($_GET["snap"])){ echo $_GET["snap"]; } ?>">
	<?php require_once "slider.php"; ?>
	<div style="min-height: 1442px;" class="main-content">
<?php require_once "titlerow.php";?>
<div class="row">
    <div class="col-sm-4">
    	<?php
    		$db=new BugDB();
			$new_bug_total=$db->selectWeekTotalBug();
	    	$h=new StatsTile();
			$h->icon ="entypo-eye";
			$h->color ="tile-blue";
			$h->title="缺陷数";
			$h->introduce ="本周发现缺陷总数";
			$h->datashow=$new_bug_total;
			$h->show() 
		?>
		<?php 
		//拼接content
			$content = "<div id='new_bug'></div>";
			$content = $content."<table id='datatable' style='margin-left:0px;margin-top:40px;' class='table table-bordered table-striped'> <thead> <tr> <th></th> <th>新增BUG</th> <th>新增未关闭</th> </tr> </thead> <tbody> ";
			$db=new BugDB();
			$bug=$db->selectBugLW();
			$tr="";
			foreach($bug as $val){
				$tr=$tr."<tr> <th>".$val[0]."</th><td>".$val[1]."</td><td>".$val[2]."</td></tr>";
			}
			$content = $content.$tr."</tbody></table>";
		//panel 内容
			$panel=new Panel();
    		$panel->data=array("title"=>"design by 刘浩");
			$panel->data["content"]=$content;
    		$panel->show(); 
    	?>
    </div>
    <div class="col-sm-8">
	    <div class="row">
		    <div class="col-sm-6">
			<?php 
				$panel=new Panel();
		    	$panel->data=array("title"=>"");
		    	$panel->data["content"]="<div id='bug_status_assign'></div>";
		    	$panel->show(); 
		    ?>
		    </div>
		    <div class="col-sm-6">
			<?php 
				$panel=new Panel();
		    	$panel->data=array("title"=>"");
		    	$panel->data["content"]="<div id='week_bug_trend'></div>";
		    	$panel->show(); 
		    ?>
		    </div>
		</div>
		<div class="row">
		    <div class="col-sm-12">
				<?php 
					$panel=new Panel();
		    		$panel->data=array("title"=>"");
		    		$panel->data["content"]="<div id='week_open_bug'></div>";
		    		$panel->show(); 
		    	?>
		   	</div>
		</div>
    </div>
</div>

</div></div>

<?php
require_once "class.bean.Mail.php";
$mm=new Mail();
$modal=new Modal();
$modal->data=array("model_id"=>"editmail","model_title"=>"编辑邮件","content"=>$mm->displayMailForm()."<p id='loadingpic'></p><div id='img_div'></div>");
$modal->show();

$m=new Modal();
$m->data=array("model_id"=>"mail_result","title"=>"邮件发送结果","but_name"=>"知道了","content"=>"<p class='confirm_msg'></p>");
$m->showConfirmModel();

?>
<script src="js/highcharts.js"></script>
<script src="js/gsap/main-gsap.js"></script>
<script src="js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
<script src="js/bootstrap.js"></script>

<script src="js/joinable.js" id="script-resource-4"></script>
<script src="js/resizeable.js"></script>  
<script src="js/neon-api.js" id="script-resource-6"></script>
<script src="js/cookies.min.js" id="script-resource-7"></script>
<script src="js/jquery.validate.min.js" id="script-resource-8"></script>

<script src="js/neon-login.js" id="script-resource-9"></script>
<script src="js/neon-custom.js" id="script-resource-3"></script>
<script src="js/neon-demo.js" id="script-resource-11"></script>
<script src="js/neon-skins.js" id="script-resource-12"></script>

<script src="js/jquery.sparkline.min.js"></script>
<script src="js/jquery.dataTables.js"></script>
<script src="js/myjs/mail.js"></script>
<script>
jQuery.noConflict();
(function($){
    	var url="ajax.Bug.php?action=bug_lw";
    	$.getJSON(url,  function(data) {$('#new_bug').highcharts(data);});	

		$('#DataTable').dataTable( {
	        //"processing": true,
	        "serverSide": true,
	        "ajax": "data.php?datafrom=bug",
	         "columns": [
	            { "data": "project_name" },
	            { "data": "bug_num" }
	            
	        ] 
	    });
   		
		var url="ajax.Bug.php?action=bug_open_week";
    	$.getJSON(url,  function(data) {
    		options=data;
        	$('#week_open_bug').highcharts(options);
   		});
   		 
   		var url="ajax.Bug.php?action=bug_status_assign";
   		$.getJSON(url,  function(data) {
    		options=data;
        	$('#bug_status_assign').highcharts(options);
   		}); 
   	
   		var url="ajax.Bug.php?action=week_bug_trend";
   		$.getJSON(url,  function(data) {
    		options=data;
        	$('#week_bug_trend').highcharts(options);
   		}); 
	   
	    
		
})(jQuery);


</script>

</body>
