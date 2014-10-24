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
	

	<style>
	.cbp_tmlabel img{
		height:100px;
		width:auto !important;
		display:inline;
	}
	</style>
	<link rel="stylesheet" href="js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css" id="style-resource-1">
	<link rel="stylesheet" href="css/font-icons/entypo/css/entypo.css" id="style-resource-2">
	<link rel="stylesheet" href="css/bootstrap-min.css" id="style-resource-4">
	<link rel="stylesheet" href="css/neon-core-min.css" id="style-resource-5">
	<link rel="stylesheet" href="css/neon-theme-min.css" id="style-resource-6">
	<link rel="stylesheet" href="css/neon-forms-min.css" id="style-resource-7">
	<link rel="stylesheet" href="css/custom-min.css" id="style-resource-8">
	<link rel="stylesheet" href="css/mycss/scrum.css" id="style-resource-11">
	
	<link rel="stylesheet" href="css/timeline.css" id="style-resource-11">
	
	<script type=text/javascript src="js/jquery-2.1.0.min.js"></script>
 
</head>
<?php
require_once "class.ui.Tiles.php";
require_once "class.ui.Panels.php";
?>
<body class="page-body loaded" >
<div class="page-container <?php if(isset($_GET["snap"])) echo "sidebar-collapsed"; ?>">
	<?php require_once "slider.php"; ?>
	<div style="min-height: 1442px;" class="main-content">
	<?php require_once "titlerow.php";?>
<div class="row">
    <ul class="cbp_tmtimeline">
    	
	
	<?php 
	require_once "class.db.Picture.php";
	require_once "class.db.Scrum.php";
	require_once "class.bean.Timeline.php";
	function showDays(){
		
		
		$day=date('Y-m-d ');
		//echo date($day,strtotime('-1 day'));;
		$endday=strtotime("2014-8-1 0:0:0");
		$endday= date('Y-m-d',$endday);
		$i=1;
		do{
			$db=new PictureDB();
			$result=$db->selectByDay($i-1);
			//print_r($result);
			$p=new PictureTimeline();
			$p->data["picture"]=$result;
			
			$dbscrum=new TaskDB();
			$tasks=$dbscrum->selectByDay($i-1);
			$s=new ScrumTimeline();
			$s->alldata=$tasks;
			
		
			$timeline=new Timeline();
			$timeline->data["day"]=$day;
			$timeline->picture=$p;
			$timeline->scrum=$s;
			$timeline->showDay();
			$day=date('Y-m-d ',strtotime("-{$i} day"));
			$i++;
		}while($day>=$endday)	;
	}
	showDays();
	?>
	
    </ul>
</div>

</div></div>

<?php

$modal=new Modal();
$modal->data=array("model_id"=>"editmail","model_title"=>"编辑邮件");
$modal->show();

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
<script>
jQuery.noConflict();
(function($){
    	var url="ajax.Bug.php?action=bug_lw";
    	$.getJSON(url,  function(data) {
    		options=data;
        	$('#new_bug').highcharts(options);
   		});	
		var url="ajax.Bug.php?action=bug_open_week";
    	$.getJSON(url,  function(data) {
    		options=data;
        	$('#week_open_bug').highcharts(options);
   		});
   		 
   		var url="ajax.Bug.php?action=bug_open_closed";
   		$.getJSON(url,  function(data) {
    		options=data;
        	$('#all_open_bug').highcharts(options);
   		}); 
   	
   		var url="ajax.Bug.php?action=bug_open_five";
   		$.getJSON(url,  function(data) {
    		options=data;
        	$('#all_open5_bug').highcharts(options);
   		}); 
	    //点击弹出发送邮件表单
	    $("#editmail_a").click(function(){
	    	var url="mail.php?u=http://localhost/ladaoba/bug.php\?snap=1&img_name=bug";
	    	$.get(url,  function(data) {
        		$(".modal-body").html(data);
        		$('#img_name').val('bug');
   		 	});
   		 	
	    	$(".modal-body").html("加载中...");
	    	$('#editmail').modal('show');
	    });
	    
		
})(jQuery);


</script>

</body>
