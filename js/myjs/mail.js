;(function($){
	    //点击弹出发送邮件表单
	    $("#editmail_a").click(function(){
	    	var url="ajax.Tools.php?action=snap";
	    	//alert(window.location.href);
	    	
	    	$(".img1").remove();
	    	$.post(url, {u:window.location.href}, function(data) {
        		$("#mail_div").append("<div class='img1'>"+data+"</div>");
        		$("#loadingpic").html("加载完成.");
   		 	});
   		 	
	    	$("#loadingpic").html("图片加载中...");
	    	$('#editmail').modal('show');
	    });
	    
	    $("#send_mail").click(function(e){
	    	e.preventDefault();
	    	var url="mail.php";
	    	$.get(url, $("#mail_form").serialize(), function(data) {
        		$(".confirm_msg").html(data);
        		$('#mail_result').modal('show');
   		 	});
	    }); 

})(jQuery);