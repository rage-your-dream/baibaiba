<?php
require_once "config_visible.php";
class Snap{
	/**
	 * para $url 截图页面url
	 * para $img_path 图片保存地址
	 * 利用phantomjs截图
	 */
	
	function takeSnap($url,$img_path){
		$curdir=getcwd();
		$snap_js_path="{$curdir}/snap/snap.js";
		if(strtolower(PHP_OS)=="linux"){	
			$cmd_line=PHANTOMJS_PATH_LINUX." {$curdir}/snap/snap.js  $url  $img_path " ;	
            $info=shell_exec($cmd_line);            
		}else {
			$cmd_line="{$curdir}".PHANTOMJS_PATH_WIN." {$curdir}/snap/snap.js  $url  $img_path	" ;	
			exec($cmd_line);
		}
	}
}	
//Snap::takeSnap("http://localhost/ladaoba/dashboard.php?id=2&edit=true","images/local/snap/a.jpg");
?>
