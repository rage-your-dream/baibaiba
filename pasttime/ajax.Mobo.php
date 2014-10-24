<?php
require_once "class.bean.Mobo.php";
if(isset($_GET["action"])){
	if($_GET["action"]=="fresh_chart"){
		$class_name=$_GET[""];
		
		if($_GET["chart_id"]=="1"){$ch=new CodeQualityChart();	
		}elseif($_GET["chart_id"]=="2"){$ch=new BugEveryOneChart();	
		}elseif($_GET["chart_id"]=="3"){$ch=new OpenedBugChart();	
		}elseif($_GET["chart_id"]=="8"){$ch=new RequirementChangeChart();
		}elseif($_GET["chart_id"]=="4"){$ch=new DelayOfPlanChart();
		}elseif($_GET["chart_id"]=="5"){$ch=new BugPercent();		
		}elseif($_GET["chart_id"]=="6"){$ch=new TestDensity();
		}elseif($_GET["chart_id"]=="7"){$ch=new DefectRemovalRate();
		}elseif($_GET["chart_id"]=="9"){$ch=new TaskDistributionChart();
		}
		echo $ch->getChart($_GET["datalock"]);

	}
	
}
?>
