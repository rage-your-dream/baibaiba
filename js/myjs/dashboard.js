;(function($){
	//加载图表
	function freshChart(mid){	
		var url="ajax.Dashboard.php?action=fresh_chart&chart_id="+mid;
		$.getJSON(url,  function(data) {
			//alert(data);
//			console.log($('#panel'+mid).width());
			if(mid==2)
				dashboard(2,data.series);
			else if(mid==9)
				drawChart(9,data.series);
			else
				$('#chart'+mid).highcharts(data);
		});
		
		initPanelOptions(mid);
	}
	
	
	/**
	 * 1、给编辑按钮一个href值，点击直接进入编辑页面
	 * 2、根据数据库的锁状态设置锁图标
	 */
	function initPanelOptions(mid){
		var url=window.location.href.split("/");
		var pname=url[url.length-1];
		//为编辑按钮赋值
		$("#panel"+mid+" .edit").attr("href","editchart.php?chart_id="+mid+"&backpage="+pname);
	}
	function freshAllChart(){
		$(".ichart").each(function(){
			$id=$(this).attr("id");
			$id=$id.substring(5);
			freshChart($id);
		});
	}
	freshAllChart();
	window.onresize=function(){  
		if($("#panel2 .toggle_analysis_msg").children("i").hasClass("entypo-picture")){
			$("#chart2").width($("#panel2").width());
		}else{
			$("#chart2").width($("#panel2").width()*7/10);
		}
		freshChart(2);
        	
	} 
	//在边栏折叠或打开是刷新图表
	$(".sidebar-collapse-icon .entypo-menu").click(function(){
		freshAllChart();
	});
	//刷新图的数据{
	$(".fresh").click(function(e){
		e.preventDefault();
		var panel_id=$(this).parents(".panel").attr("id");
    	var mid=panel_id.substring(5);
    	freshChart(mid);
	});
	var a=500;
    //设定高度不变  
    $(".toggle_analysis_msg").click(function(e){
    	//防止页面跳动
    	e.preventDefault();
    	//拿到panel id
    	var panel_id=$(this).parents(".panel").attr("id");
    	var id=panel_id.substring(5);
    
    	//分析数据展板
    	msg_card=$("#"+panel_id+" .ichart_analysis_msg");
    	
    	chart=$("#chart"+id);
    	if($(this).children("i").hasClass("entypo-picture")){
    		//缩小panel
    		$("#chart"+id).width($("#chart"+id).width()*7/10);
    		freshChart(id);
    		//分析数据显示
    		msg_card.show();
    		//改变数据库里的状态
    		$.get("ajax.Panel.php?action=update_anaylsis_show&panel_id="+id+"&is_analysis_show=1",  function(data) {});
    		//切换按钮图标
        	$(this).html("<i class='entypo-doc'></i>");
    	}else{
    		$("#chart"+id).width($("#chart"+id).width()*10/7);
    		freshChart(id);
    		$.get("ajax.Panel.php?action=update_anaylsis_show&panel_id="+id+"&is_analysis_show=0",  function(data) {});
    		$(msg_card).hide();
    		$(this).html("<i class='entypo-picture'></i>");
    	}
    	
    })
    
    //点击缩小panel
	$(".smaller").click(function(e){
		e.preventDefault();
		//首先拿到panelid
		var panel = $(this).parents(".panel");
		var id=panel.attr("id").substring(5);
		//根据表盘和panel的宽计算缩小后的值，缩小表盘额1/12
		var width_board=$(".boader-content").width();
		var width_panel=panel.width();
		var width=width_panel-width_board/12;
		panel.width(width);
		freshChart(id);
		width=Math.round(width*12/width_board);
		$.get("ajax.Panel.php?action=update_size&panel_id="+id+"&width="+width,  function(data) {});
		
		
	});
    //点击放大panel
	$(".larger").click(function(e){
		e.preventDefault();
		var panel = $(this).parents(".panel");
		var id=panel.attr("id").substring(5);

		var width_board=$(".boader-content").width();
		var width_panel=panel.width();
		var width=width_panel+width_board/12;
		panel.width(width);
		freshChart(id);
		width=Math.round(width*12/width_board);
		$.get("ajax.Panel.php?action=update_size&panel_id="+id+"&width="+width,  function(data) {});
	});
	//点击panel问号号，说明信息展现和隐藏切换
	$(".toggle_help_msg").click(function(e){
		e.preventDefault();
		var $id=$(this).parent().parent().parent().attr("id");
		$("#"+$id+" .ichart_help_msg").toggle();
	});
	//点击切换数据所状态
	$(".lock").click(function(e){
		e.preventDefault();
		var $id=$(this).parents("div .panel").attr("id").substring(5);
		if($(this).children("i").hasClass('entypo-lock-open')){
			$(this).html("<i class='entypo-lock'></i>");
			$(this).attr("data-original-title","点击图表随页面刷新");
			//改变所状态
			var url="ajax.Panel.php?action=update_lock_status&panel_id="+$id+"&lock=1";
			$.get(url,  function(data) {
				if(data!="Y") alert(data);
				var url="ajax.Dashboard.php?action=fresh_chart&chart_id="+$id+"&stroe=true";
				$.get(url,function(data){
					freshChart($id);
				});
			});
		}else {
			$(this).html("<i class='entypo-lock-open'></i>");
			$(this).attr("data-original-title","点击图表数据锁定");
			lock=0;
			var url="ajax.Panel.php?action=update_lock_status&panel_id="+$id+"&lock=0";
			$.get(url,  function(data) {
				if(data!="Y") alert(data);
				freshChart($id);
			});
		}

		
	});
	var $board_width=0;
	var $board_height=0;
	
	$(".dragable").draggable({
		stop:function(event,ui){
			$widgit_top=$(this).offset().top;
			$widgit_left=$(this).position().left;
			//alert($widgit_left+";"+$board_width)
			$x=$widgit_left;
			if($x>800)
				$x=$x-26;
			else if($x>200)
				$x=$x-15;
			$y=$widgit_top;
			var url="ajax.Panel.php?action=update_location";
			var $panel_id=$(this).attr("id").substring(5);
			
			$.get(url,{"panel_id":$panel_id,"x":$x,"y":$y,"page_width":$board_width,"page_height":$board_height} , function(data) {
    			if(data!="Y") alert(data);
   			});
		}
	});
	$( ".boader-content").droppable({
		drop:function(event,ui){
			$board_height=$(this).height();
			$board_width=$(this).width();
		}
	});
	//点赞
	$(".praise").click(function(e){
		e.preventDefault();	
		var $id=$(this).parents("div .panel").attr("id").substring(5);
		if($(this).children("i").hasClass('entypo-heart-empty')){
			var num =parseInt($(this).children("span").text())+1;
			$(this).html("<i style='color:red;font-size:130%' class='entypo-heart'></i>已赞(<span>"+num+"</span>)");
			//动态效果
			var left = $(this).position().left, top =  $(this).position().top, obj=$(this);
			$(this).append('<div id="praise"><b>+1 Thank you!</b></div> ');
			$('#praise').css({'position':'absolute','z-index':'1', 'color':'#C30','left':left+'px','top':top+'px'}).animate({top:top-10,left:left+10},'slow',function(){
				$(this).fadeIn('fast').remove();
			});
			//记录数据库数据
			var url="ajax.Panel.php?action=update_praise&panel_id="+$id+"&praise=1";
			$.get(url,  function(data) {
				if(data!="Y") alert(data);
			});
		}else {
			var num =parseInt($(this).children("span").text())-1;
			$(this).html("<i style='color:red;font-size:130%' class='entypo-heart-empty'></i>　赞(<span>"+num+"</span>)");
			//动态效果
			var left = $(this).children("i").position().left, top =  $(this).position().top, obj=$(this);
			$(this).append('<div id="praise"><b>-1 It\'s sorrow</b></div> ');
			$('#praise').css({'position':'absolute','z-index':'1', 'color':'#C30','left':left+'px','top':top+'px'}).animate({top:top-10,left:left+10},'slow',function(){
				$(this).fadeIn('fast').remove();
			});
			//记录数据库数据
			var url="ajax.Panel.php?action=update_praise&panel_id="+$id+"&praise=0";
			$.get(url,  function(data) {
				if(data!="Y") alert(data);
			});
		}
	});
	
})(jQuery);