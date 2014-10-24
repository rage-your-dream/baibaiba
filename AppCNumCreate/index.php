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
	
	
	
	<script type=text/javascript src="js/jquery-1.8.3.min.js"></script>
 	<script src="js/bootstrap.js"></script>
 	<script src="js/jquery.dataTables.js"></script>
 	
	
 	
</head>
<?php require_once "class.db.Channel.php";
$db=new ChannelDB();
?>
<body class="page-body loaded">
<div class="page-container123">
	<div class="row">
		<div class="col-sm-6" style="height:20px">
			<a href="add.php" id="add_channel"><b>添加渠道号</b></a>
			<a id="export_channel" href="#"  onclick=setaction("ExportToExcel.php")><b>导出Excel</b>></a>
		</div>
		
	</div>
	
	<div class="row">
	<table class='table table-bordered linetable' id='select_Table'>
	<thead>
		<tr class="first_tr">
			<form action="#" id="select_form" method="post">
			<th width="6%">查询条件</th>
			<th width="8%"><input class = "select_input" type="text" name="channel_number" placeholder="渠道号"></input></th>
			<th width="8%"><input class = "select_input" type="text" name="channel_name" placeholder="渠道名称"></input></th>
			<th width="8%"><input class = "select_input" type="text" name="bd" placeholder="BD"></input></th>
			<th width="12%">
			<select class= "select_select" name="promotion_team" onchange=exec() size="1">
				<option value="">--推广团队--</option>
				<?php 
					$rows=$db->selectPromotionTeams();
					foreach($rows as $row){
						echo "<option value='{$row["promotion_number"]}'>{$row["team_name"]}</option>";
					}
				?>
			</select>
			</th>
			<th width="12%">
				<select class= "select_select" name="payment_method" onchange=exec() size="1">
				<option value="">--付费方式--</option>
				<?php 
					$rows=$db->selectPaymentMethods();
					foreach($rows as $row){
						echo "<option value='{$row["payment_number"]}'>{$row["payment_name"]}</option>";
					}
				?>
				</select>
			</th>
			<th width="12%">
				<select class= "select_select" name="cooperation_mode" onchange=exec() size="1">
				<option value="">--合作方式--</option>
				<?php 
					$rows=$db->selectCooperationModes();
					foreach($rows as $row){
						echo "<option value='{$row["cooperation_number"]}'>{$row["cooperation_name"]}</option>";
					}
				?>
			</select>
			</th>
			<th width="12%">
			<select class= "select_select" name="version_type" onchange=exec() size="1">
				<option value="">--版本类型--</option>
				<?php 
					$rows=$db->selectVersionTypes();
					foreach($rows as $row){
						echo "<option value='{$row["version_number"]}'>{$row["type_name"]}</option>";
					}
				?>
			</select>
			</th>
			<th width="12%">
			<select class= "select_select" name="has_sdk" onchange=exec() size="1">
				<option value="">--有无SDK--</option>
				<?php 
					$rows=$db->selectSDKTypes();
					foreach($rows as $row){
						echo "<option value='{$row["sdk_number"]}'>{$row["type_name"]}</option>";
					}
				?>
			</select>
			</th>
			<th width="8%">
				<input type="button"  id="select_but" onclick=document.getElementById("select_form").action='#' value="查询" style="display:none"/>
				<input type="reset" id="reset_but" value="重置"/>
			</th>

		</form>
		</tr>
		</thead>
		</table>
	</div>
	<div class="row">
	<table class='table table-bordered linetable' id='channel_table' style='margin-top:0px'>
	<thead>
		<tr>
			<th width="6%">渠道号</th>
			<th width="10%">渠道名称</th>
			<th width="10%">BD</th>
			<th width="6%">推广团队</th>
			<th width="6%">付费方式</th>
			<th width="6%">合作方式</th>
			<th width="6%">版本类型</th>
			<th width="8%">有无SDK</th>
			<th width="6%">后续编号</th>
			<th width="10%">说明</th>
			<th width="12%">创建时间</th>
			<th width="5%">操作</th>
		</tr>
	</thead				
	<tbody>	
	<?php 
//		$rows=$db->selectChannelNumbers(null);
//		foreach($rows as $row){
//			echo "<tr>";
//			for($i=1;$i<12;$i++){ 
//				echo "<td>".$row[$i]."</td>";
//			}
//			echo "<td><a href='update.php?id={$row[0]}'><b>修改</b></a></td>";
//			echo "</tr>";
//		}
	?>
	</tbody>
	</table>
	</div>
</div>

<script>
function setaction(n){
    document.getElementById("select_form").action=n;
    document.getElementById("select_form").submit();
}

function exec(){
	$('#select_but').trigger("click");
}
	
(function($){	
	$("#select_but").click(function(e){
		e.preventDefault();
		$.post("man.php?action=select",$("#select_form").serialize(),function(data){
			$("#channel_table").dataTable().fnClearTable(); 
			if(data!="[]"){
				$("#channel_table").dataTable().fnAddData(jQuery.parseJSON(data));
			};
		});
	});
	$("#reset_but").click(function(e){
		location.reload();
	});

	$("#channel_table").dataTable({
		"bPaginate": true, //开关，是否显示分页器
		"bFilter": false, //开关，是否显示表格的一些信息
		"bLengthChange": true, //开关，是否显示每页大小的下拉框	
		"bSort": true, //开关，是否启用各列具有按列排序的功能
		"bAutoWidth": true, //自适应宽度
		"aaSorting": [[10, "desc"]],
		"sPaginationType": "full_numbers", //用于指定分页器风格
		"oLanguage": {
			"sProcessing": "正在加载中......",
			"sLengthMenu": "每页显示 _MENU_ 条记录",
			"sEmptyTable": "无查询结果数据！",
			"sInfo": "当前显示 _START_ 到 _END_ 条，共 _TOTAL_ 条数据",
			"sInfoEmpty": "共 _TOTAL_ 条数据",
			"oPaginate": {
				"sFirst": " 首页 ",
				"sPrevious": " 上一页 ",
				"sNext": " 下一页 ",
				"sLast": " 末页 "
				}
			} //多语言配置
		});
		//补充datatables样式
		$('#channel_table_info').addClass('col-xs-6');
		$('#channel_table_paginate').addClass('col-xs-6');
		//初始化页面数据
		$('#select_but').trigger("click");
		
		//输入框失焦执行查询
		$("input[class=select_input]").focusout(function(){
			exec();
		})
		
})(jQuery);

</script>
</body>

