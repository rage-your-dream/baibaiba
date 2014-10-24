<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>质量部渠道号系统</title>
	

	<style>.file-input-wrapper { overflow: hidden; position: relative; cursor: pointer; z-index: 1; }
	.file-input-wrapper input[type=file], .file-input-wrapper input[type=file]:focus, 
	.file-input-wrapper input[type=file]:hover { position: absolute; top: 0; left: 0; cursor: pointer; opacity: 0; filter: alpha(opacity=0); z-index: 99; outline: 0; }
	.file-input-name { margin-left: 8px; }
	
	</style>
	<link rel="stylesheet" href="js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css" id="style-resource-1">
	<link rel="stylesheet" href="css/font-icons/entypo/css/entypo.css" id="style-resource-2">
	<link rel="stylesheet" href="css/bootstrap-min.css" id="style-resource-4">
	<link rel="stylesheet" href="css/neon-core-min.css" id="style-resource-5">
	<link rel="stylesheet" href="css/neon-theme-min.css" id="style-resource-6">
	<link rel="stylesheet" href="css/neon-forms-min.css" id="style-resource-7">
	<link rel="stylesheet" href="css/erhuo.css" >
	<link rel="stylesheet" href="css/alert.css" >
		
	<script type=text/javascript src="js/jquery-1.8.3.min.js"></script>
 	<script src="js/bootstrap.js"></script>
 	
</head>
<?php require_once "class.db.Channel.php";
$db=new ChannelDB();
?>
<body class="page-body loaded" >
<div class="page-container123">
<form action="man.php" id="add_form" method="post">
	<table class='table table-bordered linetable'>
	<tr><td style="text-align: right"><label for="channel_name">渠道名称：  </labvel></td>
		<td><input type="text" class="xax" id="channel_name" name="channel_name" value="" maxlength="32"/></td>
		<td class='tip' data_tip="channel_name"></td>
	</tr>
	<tr><td style="text-align: right"><label for="bd">BD：  </labvel></td>
		<td><input type="text" class="xax" id="bd" name="bd" value="" maxlength="32"/></td>
		<td class='tip' data_tip="bd"></td>
	</tr>
	<tr><td style="text-align: right"><label for="promotion_team">推广团队：  </labvel></td>
		<td>
			<select id="promotion_team" name="promotion_team" size="1" class="xax">
				<option value="">--请选择--</option>
				<?php 
					$rows=$db->selectPromotionTeams();
					foreach($rows as $row){
						echo "<option value='{$row["promotion_number"]}'>{$row["team_name"]}</option>";
					}
				?>
			</select>
		</td>
		<td class='tip' data_tip="promotion_team"></td>
	</tr>
	<tr><td style="text-align: right"><label for="payment_method">付费方式：  </labvel></td>
		<td>
			<select id="payment_method" name="payment_method" size="1" class="xax">
				<option value="">--请选择--</option>
				<?php 
					$rows=$db->selectPaymentMethods();
					foreach($rows as $row){
						echo "<option value='{$row["payment_number"]}'>{$row["payment_name"]}</option>";
					}
				?>
			</select>
		</td>
		<td class='tip' data_tip="payment_method"></td>
	</tr>
	<tr><td style="text-align: right"><label for="cooperation_mode">合作方式：  </labvel></td>
		<td>
			<select id="cooperation_mode" name="cooperation_mode" size="1" class="xax">
				<option value="">--请选择--</option>
				<?php 
					$rows=$db->selectCooperationModes();
					foreach($rows as $row){
						echo "<option value='{$row["cooperation_number"]}'>{$row["cooperation_name"]}</option>";
					}
				?>
			</select>
		</td>
		<td class='tip' data_tip="cooperation_mode"></td>
	</tr>
	<tr><td style="text-align: right"><label for="version_type">版本类型：  </labvel></td>
		<td>
			<select id="version_type" name="version_type" size="1" class="xax">
				<option value="">--请选择--</option>
				<?php 
					$rows=$db->selectVersionTypes();
					foreach($rows as $row){
						echo "<option value='{$row["version_number"]}'>{$row["type_name"]}</option>";
					}
				?>
			</select>
		</td>
		<td class='tip' data_tip="version_type"></td>
	</tr>
	<tr><td style="text-align: right"><label for="has_sdk">有无SDK：  </labvel></td>
		<td>
			<select id="has_sdk" name="has_sdk" size="1" class="xax">
				<option value="">--请选择--</option>
				<?php 
					$rows=$db->selectSDKTypes();
					foreach($rows as $row){
						echo "<option value='{$row["sdk_number"]}'>{$row["type_name"]}</option>";
					}
				?>
			</select>
		</td>
		<td class='tip' data_tip="has_sdk"></td>
	</tr>
	<!--tr><td><label for="bd">后续编号</labvel></td>
		<td><input type="text" class="button" name="bd" value="value" /></td>
	</tr-->
	</table>
	<div align="center">
	<textarea  class="button" name="description" placeholder="备注" style="width:32%;line-height:40px"></textarea><br>
	<input id="submit" type="submit" value="提交" />
	<a href="index.php" id="to_select">返回</a>
	</div>
	
</form>
	
</div>
<div id="alert_div" style="position: absolute; z-index: 10001; top: 250px; left: 40%; visibility: hidden;" class="W_layer">
 <div class="bg">
  <table cellspacing="0" cellpadding="0" border="0">
    <tr>
     <td style="width:280px;">
      <div class="content">
       <div class="title" style="cursor: move;"><span>提示信息</span></div>
       <a title="关闭" class="W_close" href="add.php"><b>×</b></a>
       <div class="detail layer_forward" >
        <div style="height:18px;"></div>
        <p class="alert_content">渠道添加<a style="font-size:25px;color:green;font-weight:900">成功</a>！请继续添加。</p>
       </div>
      </div>
    </td>
   </tr>
  </table>
 </div>
</div>

<script>
(function($){
	function check(){
		var return_val=1;
		var inputs = $(".xax");
		$(inputs).each(function(){
			if($(this).attr("name")=="channel_name"){
				if($(this).val()==""){
					$("input[name='channel_name']").addClass("bad");
					$("td[data_tip='channel_name']").html("* 渠道名称不能为空");
					return_val=0;
				}
			}else if($(this).attr("name")=="bd"){
				if($(this).val()==""){
					$("input[name='bd']").addClass("bad");
					$("td[data_tip='bd']").html("* BD不能为空");
					return_val=0;
				}
			}else if($(this).attr("name")=="promotion_team"){
				if($(this).val()==""){
					$("select[name='promotion_team']").addClass("bad");
					$("td[data_tip='promotion_team']").html("* 请选择推广团队");
					return_val=0;
				}
			}else if($(this).attr("name")=="payment_method"){
				if($(this).val()==""){
					$("select[name='payment_method']").addClass("bad");
					$("td[data_tip='payment_method']").html("* 请选择推广团队");
					return_val=0;
				}
			}else if($(this).attr("name")=="cooperation_mode"){
				if($(this).val()==""){
					$("select[name='cooperation_mode']").addClass("bad");
					$("td[data_tip='cooperation_mode']").html("* 请选择合作方式");
					return_val=0;
				}
			}else if($(this).attr("name")=="version_type"){
				if($(this).val()==""){
					$("select[name='version_type']").addClass("bad");
					$("td[data_tip='version_type']").html("* 请选择版本类型");
					return_val=0;
				}
			}else if($(this).attr("name")=="has_sdk"){
				if($(this).val()==""){
					$("select[name='has_sdk']").addClass("bad");
					$("td[data_tip='has_sdk']").html("* 请选择有无SDK");
					return_val=0;
				}
			};
		});
		return return_val;
	};
	$("#submit").click(function(e){
		e.preventDefault();	
		if(check() == 0){
			return;
		}
		$.post("man.php?action=add",$("#add_form").serialize(),function(data){
			if(data == 1){
				if($("#alert_div").css("visibility") == "hidden"){
					$("#alert_div").css("visibility","visible");
				}else{
					$("#alert_div").show(400);
				};
				setTimeout("$('#alert_div').slideUp()",1500);
			}else if(data == 2){
				$("input[name='channel_name']").addClass("bad");
				$("td[data_tip='channel_name']").html("* 渠道名称已存在！");
			}else{
				alert("添加渠道失败，请稍后重试！");
			};
		});
	});
	$("input").blur(function(){
		$(this).removeClass("bad");
		$(this).parents("tr").children("td[class='tip']").html("");
	});
	$("select").blur(function(){
		$(this).removeClass("bad");
		$(this).parents("tr").children("td[class='tip']").html("");
	});

})(jQuery);
</script>

</body>

