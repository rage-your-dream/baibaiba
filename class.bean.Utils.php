<?php
require_once "class.db.Utils.php";
class User{
	private $id=0;
	private $num="CY0000";
	private $username="小3";
	private $phone="18612345678";
	private $qq="1234";
	private $email="erhuo@cyou-inc.com";
	public $data=array();
	public function setValues($data_array){
		if(isset($data_array)){
 			$this->data=array_merge($this->data,$data_array);
 		}
 		
 		if(isset($this->data["id"])){
 			$this->id=$this->data["id"];
 		}
 		if(isset($this->data["username"])){
 			$this->username=$this->data["username"];
 		}
 		if(isset($this->data["num"])){
 			$this->sprint_num=$this->data["num"];
 		}
 		if(isset($this->data["phone"])){
 			$this->phone=$this->data["phone"];
 		}
 		if(isset($this->data["qq"])){
 			$this->qq=$this->data["qq"];
 		}
 		if(isset($this->data["email"])){
 			$this->email=$this->data["email"];
 		}
 		
	}
	public function loginCheck($num,$password){
		$userdb=new UserDB();
		$u=$userdb->login($num,$password);
		if($u){
			$d=array("id"=>$u[0],"num"=>$u[1],"username"=>$u[2]);
			return $d;
		}else{
			return false;
		}
	}
	public function show(){
		
	}
}
//$u=new User();
//$u->loginCheck("CY8060","nicai");
?>
