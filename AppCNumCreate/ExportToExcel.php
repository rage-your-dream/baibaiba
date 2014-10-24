<?php
require_once "class.db.Channel.php";
require_once "Classes/PHPExcel.php";



function createExcel($rows){
    //creat excel
    $objPHPExcel = new PHPExcel();
    $objPHPExcel = PHPExcel_IOFactory::load("template.xls");
    $timetitle = (string) date('mdhis');
    // Add data
    $rowkey=array("A","B","C","D","E","F","G","H","I","J","K","L");
    $rowtitle=array("渠道号","渠道名称","BD","推广团队","付费方式","合作方式","版本类型","有无SDK","后续编号","说明","创建时间");
    for ($i=0; $i<count($rowtitle); $i++) {
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("$rowkey[$i]1","$rowtitle[$i]");
    }
    for ($n=0; $n<count($rows); $n++){
        $ntmp=$n+2; //first data row
        $rowtmp=$rows[$n];
        for ($m=0; $m<count($rows[$n])/2; $m++) {
            $mtmp=$m+1; 
            if ($mtmp==9) {
            	$objPHPExcel->setActiveSheetIndex(0)->SetCellValue("$rowkey[$m]$ntmp","=REPT(0,4-LEN(".$rowtmp[$mtmp]."))&".$rowtmp[$mtmp]);
            }
            else {
                $objPHPExcel->setActiveSheetIndex(0)->SetCellValue("$rowkey[$m]$ntmp", "$rowtmp[$mtmp]");
            }
        }
    }
    
    // Rename sheet
    //$objPHPExcel->getActiveSheet()->setTitle('Simple');
        
    //downfile
    ob_clean();
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment; filename=channel_num_$timetitle.xls");
    header("Content-Transfer-Encoding: binary");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Pragma: no-cache");
    $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
    $objWriter->save('php://output');

}



$rule="";
	if(isset($_POST["channel_number"])&&$_POST["channel_number"]!="")
		$rule.=" and c.channel_number like '%{$_POST["channel_number"]}%' ";
	if(isset($_POST["channel_name"])&&$_POST["channel_name"]!="")
		$rule.=" and c.channel_name like '%{$_POST["channel_name"]}%' ";
	if(isset($_POST["bd"])&&$_POST["bd"]!="")
		$rule.=" and c.bd like '%{$_POST["bd"]}%' ";
	if(isset($_POST["promotion_team"])&&$_POST["promotion_team"]!="")
		$rule.=" and c.promotion_number= '{$_POST["promotion_team"]}'";
	if(isset($_POST["payment_method"])&&$_POST["payment_method"]!="")
		$rule.=" and c.payment_number='{$_POST["payment_method"]}' ";
	if(isset($_POST["cooperation_mode"])&&$_POST["cooperation_mode"]!="")
		$rule.=" and c.cooperation_number= '{$_POST["cooperation_mode"]}'";
	if(isset($_POST["version_type"])&&$_POST["version_type"]!="")
		$rule.=" and c.version_number= '{$_POST["version_type"]}'";
	if(isset($_POST["has_sdk"])&&$_POST["has_sdk"]!="")
		$rule.=" and c.has_sdk= '{$_POST["has_sdk"]}'";
	
//serch data
$db=new ChannelDB();
$rows=$db->selectChannelNumbers($rule);
createExcel($rows);

?>





