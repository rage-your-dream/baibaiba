<?php
require_once "config.php";
class MD5{
	/**
	 * 加密
	 */
	function string2secret($str)
	{
		$key = MD5_KEY;
		$td = mcrypt_module_open(MCRYPT_DES,'','ecb','');
		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
		$ks = mcrypt_enc_get_key_size($td);
	
		$key = substr(md5($key), 0, $ks);
		mcrypt_generic_init($td, $key, $iv);
		$secret = mcrypt_generic($td, $str);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		return $secret;
	}
	/**
	 * 解密
	 */
	function secret2string($sec)
	{
		$key = MD5_KEY;
		$td = mcrypt_module_open(MCRYPT_DES,'','ecb','');
		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
		$ks = mcrypt_enc_get_key_size($td);
	
		$key = substr(md5($key), 0, $ks);
		mcrypt_generic_init($td, $key, $iv);
		$string = mdecrypt_generic($td, $sec);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		return trim($string);
	}
}
?>
