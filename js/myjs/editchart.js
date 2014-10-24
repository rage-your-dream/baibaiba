;(function($){
	//加载图表
	function freshChart(){
		var chart_id=$("#chart").attr("data_chart_id");
		var url="ajax.EditChart.php?action=fresh_chart&chart_id="+chart_id+"&datalock=0";		
	    $.getJSON(url,  function(data) {
	    	//alert(data);
	    	if(chart_id==2)
				dashboard(-1,data.series);
			else if(chart_id==9)
				drawChart(-1,data.series);
			else
				$('#chart').highcharts(data);
	   });
	}
	freshChart();
  
   /*********************************************保存按钮方法去*******************************************************/
   //点击保存图表
   $("#store").click(function(){
   });
   
   $("#stroe_options").click(function(){
	   $id=$("#chart").attr("data_chart_id");
	   
	   var url="ajax.EditChart.php?action=update_options&chart_id="+$id;
	   $.getJSON(url ,$("#form123").serialize(), function(data) {
		   //alert(data);
		   $('#chart').highcharts(data);
	   });
	   
   });
   $("#stroe_series").click(function(){
	   $id=$("#chart").attr("data_chart_id");
	   $data="";
	   $data+=getTableHeadData();
	   if(getTableBodyData())
		   $data+=":"+getTableBodyData();
	   else {
		   alert("数据不完整,请认真填写");
	   }
	   var url="ajax.EditChart.php?action=update_series&chart_id="+$id;
	   $.getJSON(url ,{data:$data}, function(data) {
		   //alert(data);
		   $('#chart').highcharts(data);
	   });
	  
   });
   $("#stroe_help_msg").click(function(){
	   $id=$("#chart").attr("data_chart_id");
	   var url="ajax.EditChart.php?action=update_help_msg&chart_id="+$id;
	   $.get(url ,{"help_msg":$("#input_help_msg").val()}, function(data) {
		 	if(data=="Y") alert("保存说明文档成功！");
	   });
   });
   $("#input_help_msg").val($("#input_help_msg").attr("placeholder"));
   $("#stroe_analysis_msg").click(function(){
	   $id=$("#chart").attr("data_chart_id");
	   var url="ajax.EditChart.php?action=update_analysis_msg&chart_id="+$id;
	   $.get(url ,{"analysis_msg":$("#input_analysis_msg").val()}, function(data) {
		   if(data=="Y") alert("保存分析文档成功！");
	   });
   });
   $("#input_analysis_msg").val($("#input_analysis_msg").attr("placeholder"));
   //点击预览按钮改变图表显示
   $("#preview").click(function(){
   		
 		
   });
   
   /*****************************************图形数据编辑*****************************************/
   //隐藏编辑表表格多余编辑项
 
   function initTable(row,col){
	   trs=$("tr");
	   for(var j=0;j<trs.length;j++){		   
		   tds=$(trs[j]).children();
		   if($(tds[0]).children("input").val()=="可编辑"&&j>row){//遇到第一列为可编辑则隐藏
			   $(trs[j]).hide();
		   }else $(trs[j]).show();
		   for(var i=0;i<tds.length;i++){
			   if($(tds[i]).children("input").val()=="可编辑"&&i>col){//遇到第一列为可编辑则隐藏
				   $(tds[i]).hide();
			   }else  $(tds[i]).show();
		   } 
	   }
	  
   }
   
   initTable(0,0);
   
   //点击增加column编辑数据编辑列
   $(".add_col").click(function(e){
	   e.preventDefault();
	   var ths=$("th");
	   var col=0;
	   for(var j=0;j<ths.length;j++){
		  if($(ths[j]).children("input").val()=="可编辑")
			  break;
		  col=j;
	   }
	   //alert(col);
	   initTable(0,col+1);
   });
   //点击增加啊一行
   $(".add_row").click(function(e){
	   e.preventDefault();
	   var ths=$("th");
	   var col=0;
	   for(var j=0;j<ths.length;j++){
		  if($(ths[j]).children("input").val()=="可编辑")
			  break;
		  col=j;
	   }
	   var trs=$("tr");
	   var row=0;
	   for(var j=0;j<trs.length;j++){		   
		   tds=$(trs[j]).children();
		   if($(tds[0]).children("input").val()=="可编辑"&&j>row){
			   break;
		   }
		   row=j;
	   }
	   initTable(row+1,col);
   })
   //点击标记行删除
   $(".delete_row").click(function(e){
	   e.preventDefault();
	   $(this).parents("tr").remove();
   });
   //点击标记列删除
   $(".delete_col").click(function(e){
	   e.preventDefault();
	   var col=$(this).parents("th").attr("class");
	   $("."+col).remove();	   
   });
   colnum=0;
   //获取表格头的th，逗号连接
   function getTableHeadData(){
	   var ths=$("th");
	   var con=""; 		
	   for(var j=0;j<ths.length;j++){
		   var t=$(ths[j]).children("input").val();
  			if(t.indexOf("可编辑")>=0){
  				break;;
  			}
  			colnum=j;
  			con+=t+",";
		   
	   }
	   return con.substring(0,con.length-1);
   } 
   //alert(getTableHeadData(""));
   //获取table body中的表格值数据,tr数据用分号（;）连接，td数据用逗号（,）隔开
   function getTableBodyData(){
	   //alert(col);
	   var trs=$(" tr");
	   var json="";
	   for(var j=1;j<trs.length;j++){
  			tds=$(trs[j]).children();		
  			if($(tds[0]).children("input").val().indexOf("可编辑")>=0){
  				break;
  			}
  			t=$(tds[0]).children("input").val();
  			json+=t+",";
  			
  			for(var i=1;i<=colnum;i++){
  				//已删除和可编辑的数据不处理
  				if($(tds[i]).children("input").val()=="可编辑"){
  					return false;
  				}
  				
  				json+=$(tds[i]).children("input").val()+",";
  			}
  			json=json.substring(0,json.length-1)+";";
  			
  		}
	   json=json.substring(0,json.length-1);
	   return json;
   }
 
   //alert(getTableBodyData(""));
   
   //点击panel问号显示或者关闭帮助文档
   $(".help_show_hide").click(function(){
	   	$("#help_msg_div").html($("#input_help_msg").val());
        $("#help_msg_div").toggle();
   });
   //点击文档编辑区的“显示关闭浮层”显示或者关闭帮助文档
   $("#show_help_msg").click(function(){
	   	$("#help_msg_div").html($("#input_help_msg").val());
        $("#help_msg_div").toggle();
   });
   //编辑完成帮助文档的时候需要浮层文字也跟新
   $("#input_help_msg").blur(function(){
        $("#help_msg_div").html($("#input_help_msg").val());
   });
   $(".anilysis_show_hide").click(function(){
   	if($(this).children("i").hasClass("entypo-doc")){
       	$("#anilysis_msg_div").hide();
       	$(this).html("<i class='entypo-picture'></i>")
   	}else{
       	$("#anilysis_msg_div").show();
       	$("#anilysis_msg_div").val($("#input_analysis_msg").val());
       	$(this).html("<i class='entypo-doc'></i>")
   	}
   	
   })
   $("#show_hide_analysis").click(function(){
   		$("#anilysis_msg_div").toggle();
   		$("#anilysis_msg_div").val($("#input_analysis_msg").val());
   		$(".anilysis_show_hide").html("<i class='entypo-doc'></i>")
   })
   //编辑完成帮助文档的时候需要浮层文字也跟新
  $("#input_analysis_msg").blur(function(){
       $("#anilysis_msg_div").html($("#input_analysis_msg").val());
  })
  //复选按钮说明浮层
  $(".img_tooltip").hover(function(){
	  $(this).children("div").show();
  },
  function(){
	  $(this).children("div").hide();
  });
  
})(jQuery);