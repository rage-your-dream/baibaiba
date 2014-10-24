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
	<script type=text/javascript src="js/jquery-2.1.0.min.js"></script>
 
</head>
<?php
require_once "class.ui.Tiles.php";
require_once "class.ui.Panels.php";
require_once "class.ui.Models.php";
require_once "class.db.Datacenter.php";
?>
<body class="page-body loaded" >
<div class="page-container ">
	<?php require_once "slider.php"; ?>
	<div style="width:1300px" class="main-content"><!--这行的width 控制页面的宽度-->
<?php require_once "titlerow.php";?>
<div class="row">
	<div class="col-sm-8">
		<div class="panel panel-primary drsElement dragable ui-draggable" style="width: 102%" id="charts_env">
			<div class="panel-heading">
				<div class="panel-title"></div>
                <div class="panel-options">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#container_p2" data-toggle="tab">日趋势</a></li>
                        <li class=""><a href="#container_p4" data-toggle="tab">Top 10 七日活跃用户</a></li>
					</ul>
				</div>
			</div>
			<div class="panel-body">
				<div class="tab-content">
					<div class="tab-pane active" id="container_p2" style="height:550px">
		    			<div id='pv_uv_day_trend' style="height:100%"></div>
					</div>
					<div class="tab-pane" id="container_p4" style="height:550px">                          
					    <table class="table table-bordered table-responsive">
					        <thead>
					            <tr>
					                <th width="5%"></th>
					                <th width="20%">用户</th>
					                <th width="30%">部门</th>
					                <th width="10%">七日PV量</th>
					                <th width="35%">七日PV量对比</th>
					            </tr>
					        </thead>
					        <tbody>
					        	<?php
					        		$color=array("","success","warning","info","danger","success","warning","info","danger","success","warning","info","danger");
					        		$num=0;
					        		$maxvalue=0;
					        		$db=new DatacenterDB();
									$data=$db->select7DayPv();
									foreach($data as $trdata){
										if($num==0){
											$maxvalue=$trdata["num"];
										};
										$num++;
						        		echo "<tr height='50'>";
						        		echo "<td>".$num."</td>";
						        		echo "<td>".$trdata["uname"]."</td>";
						        		echo "<td>".$trdata["ubumen"]."</td>";
						        		echo "<td>".$trdata["num"]."</td>";
						        		echo "<td><div class='progress'>";
						        		echo "<div class='progress-bar progress-bar-".$color[$num]."' style='width: ".($trdata["num"]/$maxvalue*100)."%'></div>";
						        		echo "</div></td>";
									}
					        	?>
					            </tr>
					        </tbody>
					    </table>
					</div>
				</div>
			</div>
            <table class="table table-bordered table-responsive" >
                <thead>
                    <tr>
						<?php
						$db=new DatacenterDB();
						$data=$db->selectTodayVisit();
	                       echo "<th width='50%' style='height:128px' class='col-padding-1'>";
	                       echo "<div class='pull-left'>";
	                       echo "<div class='h4 no-margin''>今日PV</div>";
	                       echo "<small>".$data[0]["pv"]."</small>";
	                       echo "</div>";
	                       if($data[0]["pv"] > $data[1]["pv"]){
	                           echo "<div class='pull-right'><i style='color:green;font-size:300%' class='entypo-up-bold'></i></div>";
	                       }else if($data[0]["pv"] < $data[1]["pv"]){
	                           echo "<div class='pull-right'><i style='color:red;font-size:300%' class='entypo-down-bold'></i></div>";
	                       }else{
	                       	   echo "<div class='pull-right'><i style='color:blue;font-size:300%;' class='glyphicon-minus'>&nbsp</i></div>";
	                       };
	                       echo "</th>";
	                       echo "<th width='50%' class='col-padding-1' >"; 
	                       echo "<div class='pull-left'>";
	                       echo "<div class='h4 no-margin'>今日UV</div>";
	                       echo "<small>".$data[0]["uv"]."</small>";
	                       echo "</div>";
	                       if($data[0]["uv"] > $data[1]["uv"]){
	                           echo "<div class='pull-right'><i style='color:green;font-size:300%' class='entypo-up-bold'></i></div>";
	                       }else if($data[0]["uv"] < $data[1]["uv"]){
	                           echo "<div class='pull-right'><i style='color:red;font-size:300%' class='entypo-down-bold'></i></div>";
	                       }else{
	                       	   echo "<div class='pull-right'><i style='color:blue;font-size:300%;' class='glyphicon-minus'>&nbsp</i></div>";
	                       };
	                       echo "</th>";
						?>
                    </tr>
                </thead>
            </table>
		</div>
	</div>
	<div class="col-sm-4">
    	<?php
    		$db=new DatacenterDB();
			$total_pv=$db->selectTotalPV();
	    	$h=new StatsTile();
			$h->icon ="entypo-eye";
			$h->color ="tile-red";
			$h->title="总PV";
			$h->introduce ="From 2014-9-25 15:36 To now";
			$h->datashow=$total_pv;
			$h->show() 
		?>
		<?php
    		$db=new DatacenterDB();
			$total_uv=$db->selectTotalUV();
	    	$h=new StatsTile();
			$h->icon ="entypo-eye";
			$h->color ="tile-green";
			$h->title="总UV";
			$h->introduce ="From 2014-9-25 15:36 To now";
			$h->datashow=$total_uv;
			$h->show() 
		?>
		<?php 
			$panel=new Panel();
		    $panel->data=array("title"=>"");
		    $panel->data["content"]="<div id='pv_distribute' style='height:100%'></div>";
		    $panel->show(); 
		?>
    </div>
</div>

</div></div>

<script src="js/highcharts.js"></script>
<script src="js/gsap/main-gsap.js"></script>
<script src="js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js" id="script-resource-2"></script>
<script src="js/bootstrap.js"></script>

<script src="js/joinable.js" id="script-resource-4"></script>
<script src="js/resizeable.js"></script>

<script src="js/neon-custom.js" id="script-resource-3"></script>
<script src="js/neon-demo.js" id="script-resource-11"></script>

<script src="js/jquery.dataTables.js"></script>

<script>
jQuery.noConflict();
(function($){   		
		var url="ajax.Datacenter.php?action=pv_uv_day_trend";
    	$.getJSON(url,  function(data) {
    		options=data;
        	$('#pv_uv_day_trend').highcharts(options);
   		});
   		 
   		var url="ajax.Datacenter.php?action=pv_distribute";
   		$.getJSON(url,  function(data) {
    		options=data;
        	$('#pv_distribute').highcharts(options);
   		}); 

})(jQuery);


</script>

</body>
