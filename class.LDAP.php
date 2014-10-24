<?php
require_once "config.php";

class LDAP{ 
	public $ladp;
	function __construct(){
		$this->ldap['base'] = "";
		$this->ladp['host'] = LDAP_HOST;
		$this->ladp['port'] = LDAP_PORT;
		$this->ladp['dn']   = LDAP_DN;
	}
	public function login($username,$password){
		$username=substr($username,0,strpos($username,"@"));
		$dn="";
		$this->ladp['conn'] = ldap_connect( $this->ladp['host'], $this->ladp['port'] ) or die( "Could not connect to server {$this->ladp['host']}");
		$this->ladp['bind'] = ldap_bind( $this->ladp['conn'], $this->ladp['dn'], LDAP_PSW );
		//查找用户名
		ldap_set_option($this->ladp['conn'], LDAP_OPT_PROTOCOL_VERSION, 3); 
		ldap_set_option($this->ladp['conn'], LDAP_OPT_REFERRALS, 0); 
		$filter= "(&(objectCategory=Person)(sAMAccountName=$username))";

		$search=ldap_search($this->ladp['conn'],"OU=Users,OU=Managed,DC=cyou-inc,DC=com",$filter);  //根据uid获取到用户的信息 
		if ( $search )
		$info = ldap_get_entries ($this->ladp['conn'], $search );
		if ($info ["count"] != 0){		
			
			/*foreach($info as $k=>$s)
			{
				echo "<br>key:".$k.";values:";
				if(is_array($s)){
					foreach($s as $kk=>$ss){
						echo "key1:".$kk.";values:";
						if(is_array($ss))
							print_r($ss);
						else echo "".$ss."<br>";
					}
				}else echo "".$s."<br>";
			}*/
			$username = mb_convert_encoding($info[0]["displayname"][0],"utf-8","gbk");
			$employee_id= mb_convert_encoding($info[0]["employeeid"][0],"utf-8","gbk");
			$department= mb_convert_encoding($info[0]["department"][0],"utf-8","gbk");

			//登陆验证	先将GBK编码转UTF-8
			$userDn=mb_convert_encoding($info[0]["dn"],"utf-8","gbk");
			if (ldap_bind($this->ladp['conn'],$userDn,$password)) 
				return array("username"=>$username,"employee_id"=>$employee_id,"department"=>$department);	
		}
		return false;
		//ldap_unbind($this->ladp['conn']) or die("Can't unbind from LDAP server.");		
	}	
} 
?>