;(function($){
	//加载图表
	function freshChart(mid){	
		dl=1;
		if($("#panel"+mid).children("i").hasClass('entypo-lock'))
			dl=0;
		var url="ajax.Mobo.php?action=fresh_chart&chart_id="+mid+"&datalock="+dl;
		$.getJSON(url,  function(data) {
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
		//为编辑按钮赋值
		$("#panel"+mid+" .edit").attr("href","editChart.php?chart_id="+mid);
	}
	
	freshChart(1);
	freshChart(2);
	freshChart(3);
	freshChart(4);
	freshChart(5);
	freshChart(6);
	freshChart(7);
	freshChart(8);
	freshChart(9);
	
	window.onresize=function(){  
		if($("#panel2 .toggle_analysis_msg").children("i").hasClass("entypo-picture")){
			$("#chart2").width($("#panel2").width());
		}else{
			$("#chart2").width($("#panel2").width()*7/10);
		}
		freshChart(2);
		
		freshChart(9);
	} 
	
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
		var lock=0;
		if($(this).children("i").hasClass('entypo-lock-open')){
			$(this).html("<i class='entypo-lock'></i>");
			lock=1;
		}else {
			$(this).html("<i class='entypo-lock-open'></i>");
			lock=0;
		}
		var $id=$(this).parents("div .panel").attr("id").substring(5);
		var url="ajax.Panel.php?action=update_lock_status&panel_id="+$id+"&lock="+lock;
		$.get(url,  function(data) {
			if(data!="Y") alert(data);
		});
		freshChart($id);
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
	
	
})(jQuery);