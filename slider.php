<div style="min-height: 1024px;" class="sidebar-menu">
	<header class="logo-env">
		<!-- logo -->
		<div class="logo">
			<!--h2><a href=""><img src="images/logo@2x_grey.png" alt="" width="150"></a></h2-->
			<h3><a style="color:#FFFFFF;font-size:18px;font-family:YouYuan;font-weight:900;" href="home.php">集成质量管理平台</a></h3>
		</div>
			
		<!-- logo collapse icon -->						
		<div class="sidebar-collapse">
			<a href="#" class="sidebar-collapse-icon with-animation">
			<!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
				<i class="entypo-menu"></i>
			</a>
		</div>
			
									
		<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
		<div class="sidebar-mobile-menu visible-xs">
			<a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
				<i class="entypo-menu"></i>
			</a>
		</div>
			
	</header>
	<ul id="main-menu" >
		
		<!--li class="root-level" id="search">
			<form method="get" action="">
				<input name="q" class="search-input" placeholder="栏目查询..." type="text">
				<button type="submit"><i class="entypo-search"></i></button>
			</form>
		</li-->
		<li class="root-level has-sub ">
			<a href="#"><i ><img width="25"src= "images/mobo_logo.png"></i><span>Mobogenie</span></a>
			<ul class="visibale">		
				<li>
					<a href="post.php?target=mobo_confluence" target="_blank"><i class="entypo-login"></i><span>Confluence:知识分享及交流</span></a>
				</li>
				<li>
					<a href="http://confluence.oversea.mobogarden.com:8090" target="_blank"><i class="entypo-login"></i><span>海外专用Confluence：知识分享及交流</span></a>
				</li>
				<li>
					<a href="http://oa.it.mobogarden.com/jira" target="_blank"><i class="entypo-login"></i><span>Jira:产品需求及项目管理</span></a>
				</li>
				<li>
					<a href="http://oa.it.mobogarden.com/testlink" target="_blank"><i class="entypo-login"></i><span>TestLink:测试及用例管理</span></a>
				</li>
				<li>
					<a href="http://hudson.it.mobogarden.com" target="_blank"><i class="entypo-login"></i><span>Hudson:每日构建与持续集成</span></a>
				</li>
				<li>
					<a href="http://oa.it.mobogarden.com/AppsAngle/index.php?app_name=Mobogenie" target="_blank"><i class="entypo-newspaper"></i><span>扫一扫</span></a>
				</li>
				<li>
					<a href="dashboard.php?id=2"><i class="entypo-gauge"></i><span>各质量指标数据及分析展示</span></a>
				</li>
			</ul>
		</li>
	</ul>
</div>
<script>
(function($){
	$("a").click(function(e){
		var hr=$(this).attr("href");		
		if(hr!=""&&!hr.indexOf("#")==0){
			var url="ajax.Log.php";
			$.post(url,{action:"sliderlog",description:hr}, function(data) {});	
    	}    	
    });
    function uiVisible(){
    	var url=window.location.href.split("/");
		var pname=url[url.length-1];
		if(pname=="home.php"){
			pname="dashboard.php?id=2";
		}
		if(pname=="dashboard.php?id=2&edit=true"){
			pname="dashboard.php?id=2";
		}
		for(var i=0;i<$("a").length;i++){
			if($($("a")[i]).attr("href")==pname){
				$($("a")[i]).parents("ul").addClass("visible");
				$($("a")[i]).parents("li").addClass("opened");
			}
		}
	};
	uiVisible();
})($);

</script>
