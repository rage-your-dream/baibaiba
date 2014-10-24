<?php
require_once "class.DBConn.php";
class ChannelDB extends DBConn{
	/**
	 * 查询推广团队
	 */
	public function selectPromotionTeams(){
		$conn=parent::getConn();
 		$sql="SELECT promotion_number,team_name FROM promotion_team;";
 		try{
 			$st=$conn->prepare($sql);
 			$st->execute();
 			$row=$st->fetchALL();
 		}catch(PDOException $e){
 			echo "selectPromotionTeam() failed:".$e->getMessage();
 			return false;
 		}		
 		return $row;
	}
	/**
	 * 查询所有付款方式
	 */
	public function selectPaymentMethods(){
		$conn=parent::getConn();
 		$sql="SELECT payment_number,payment_name FROM payment_method;";
 		try{
 			$st=$conn->prepare($sql);
 			$st->execute();
 			$row=$st->fetchALL();
 		}catch(PDOException $e){
 			echo "selectPaymentMethods() failed:".$e->getMessage();
 			return false;
 		}		
 		return $row;
	}
	/**
	 * 查询所有合作方式
	 */
	public function selectCooperationModes(){
		$conn=parent::getConn();
 		$sql="SELECT cooperation_number,cooperation_name FROM cooperation_mode;";
 		try{
 			$st=$conn->prepare($sql);
 			$st->execute();
 			$row=$st->fetchALL();
 		}catch(PDOException $e){
 			echo "selectPaymentMethods() failed:".$e->getMessage();
 			return false;
 		}		
 		return $row;
	}
	/**
	 * 查询所有版本类型
	 */
	public function selectVersionTypes(){
		$conn=parent::getConn();
 		$sql="SELECT version_number,type_name FROM version_type;";
 		try{
 			$st=$conn->prepare($sql);
 			$st->execute();
 			$row=$st->fetchALL();
 		}catch(PDOException $e){
 			echo "selectPaymentMethods() failed:".$e->getMessage();
 			return false;
 		}		
 		return $row;
	}
	/**
	 * 查询所有SDK类型
	 */
	public function selectSDKTypes(){
		$conn=parent::getConn();
 		$sql="SELECT sdk_number,type_name FROM sdk_type;";
 		try{
 			$st=$conn->prepare($sql);
 			$st->execute();
 			$row=$st->fetchALL();
 		}catch(PDOException $e){
 			echo "selectPaymentMethods() failed:".$e->getMessage();
 			return false;
 		}		
 		return $row;
	}
	/**
	 * 查询最大的后续编号（这里取得是id 因为默认id就是最大后续编号，因为没有删除功能）
	 */
	public function selectMixTailNum($data){
		$conn=parent::getConn();
 		$sql="SELECT MAX(id) FROM channel_number ";
// 				"where promotion_number=:pn and payment_number=:pn1 and cooperation_number=:cn and version_number=:vn;";
 		try{
 			$st=$conn->prepare($sql);
// 			$st->bindValue(":pn",$data["promotion_number"],PDO::PARAM_STR);
// 			$st->bindValue(":pn1",$data["payment_number"],PDO::PARAM_STR);          // 此处注释的原因是 取max
// 			$st->bindValue(":cn",$data["cooperation_number"],PDO::PARAM_STR);
// 			$st->bindValue(":vn",$data["version_number"],PDO::PARAM_STR);
 			$st->execute();
 			$row=$st->fetch();
 			if(!$row[0]) return 0;
 			else return $row[0];
 		}catch(PDOException $e){
 			echo "selectPaymentMethods() failed:".$e->getMessage();
 			return false;
 		}		
 		return $row;
	}
	/**
	 * 插入新的渠道
	 */
	public function insertChannel($data){
 		$conn=parent::getConn();
 		$sql="insert into channel_number (channel_number,channel_name,bd,promotion_number,payment_number,cooperation_number,version_number,has_sdk,tail_number,description) " .
 				" values(:channel_number,:channel_name,:bd,:promotion_number,:payment_number,:cooperation_number,:version_number,:has_sdk,:tail_number,:description) ";
 		
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":channel_number",$data["channel_number"],PDO::PARAM_STR);
 			$st->bindValue(":channel_name",$data["channel_name"],PDO::PARAM_STR);
 			$st->bindValue(":bd",$data["bd"],PDO::PARAM_STR);
 			$st->bindValue(":promotion_number",$data["promotion_number"],PDO::PARAM_STR);
 			$st->bindValue(":payment_number",$data["payment_number"],PDO::PARAM_STR);
 			$st->bindValue(":cooperation_number",$data["cooperation_number"],PDO::PARAM_STR);
 			$st->bindValue(":version_number",$data["version_number"],PDO::PARAM_STR);
 			$st->bindValue(":has_sdk",$data["has_sdk"],PDO::PARAM_STR);
 			$st->bindValue(":tail_number",$data["tail_number"],PDO::PARAM_STR);
 			$st->bindValue(":description",$data["description"],PDO::PARAM_STR);
 	
 			$st->execute();
 			return true;
 		}catch(PDOException $e){
 			echo "insertChannel() failed:".$e->getMessage();
 			return false;
 		}	
	} 
	/**
	 * 查询所有渠道号
	 */
	public function selectChannelNumbers($rule){
		$conn=parent::getConn();
 		$sql="SELECT c.id,c.channel_number,c.channel_name,c.bd,promotion_team.team_name as p_num,payment_method.payment_name,cooperation_mode.cooperation_name,version_type.type_name," .
 				"sdk_type.type_name,c.tail_number,c.description,c.create_time FROM channel_number AS c,promotion_team,payment_method,cooperation_mode,version_type,sdk_type ".
 				"where c.promotion_number = promotion_team.promotion_number ".
 				"and c.payment_number = payment_method.payment_number ".
				"and c.cooperation_number = cooperation_mode.cooperation_number ".
				"and c.version_number =version_type.version_number ".
				"and c.has_sdk =sdk_type.sdk_number";
 				
 		if($rule) $sql.=$rule;
 		//echo $sql;
 		try{
 			$st=$conn->prepare($sql);
 			$st->execute();
 			$row=$st->fetchALL();
 		}catch(PDOException $e){
 			echo "selectPaymentMethods() failed:".$e->getMessage();
 			return false;
 		}		
 		return $row;
	}
	/**
	 * 查询单个渠道号
	 */
	public function selectOneChannelNumber($rule){
		$conn=parent::getConn();
 		$sql="SELECT id,channel_number,channel_name,bd,promotion_number,payment_number,cooperation_number,version_number," .
 				"has_sdk,tail_number,description FROM channel_number where ";
 				
 		if($rule) $sql.=$rule;
 		try{
 			$st=$conn->prepare($sql);
 			$st->execute();
 			$row=$st->fetch();
 		}catch(PDOException $e){
 			echo "selectPaymentMethods() failed:".$e->getMessage();
 			return false;
 		}		
 		return $row;
	}
	/**
	 * 更新一个渠道
	 */
	public function updateOneChannelNumber($id,$data){
		$conn=parent::getConn();

 		$sql="UPDATE channel_number Set channel_name=:channel_name,bd=:bd, " .
 			" has_sdk=:has_sdk,description=:description ".
 			" where id=:id ";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":id",$id,PDO::PARAM_INT);
 			$st->bindValue(":channel_name",$data["channel_name"],PDO::PARAM_STR);
 			$st->bindValue(":bd",$data["bd"],PDO::PARAM_STR);
 			$st->bindValue(":has_sdk",$data["has_sdk"],PDO::PARAM_STR);
 			$st->bindValue(":description",$data["description"],PDO::PARAM_STR);
 			$st->execute();
 			return true;
 		}catch(PDOException $e){
 			echo "updateOneChannelNumber():".$e->getMessage();
 			return false;
 		}			
	}
	/**
	 * 检查渠道名称存在
	 */
	public function existsChannelName($id,$channel_name){
		$conn=parent::getConn();

 		$sql="SELECT COUNT(*) as `num` FROM `channel_number` WHERE `channel_name` = :channel_name AND `id` != :id;";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":id",$id,PDO::PARAM_INT);
 			$st->bindValue(":channel_name",$channel_name,PDO::PARAM_STR);
 			$st->execute();
 			$row=$st->fetch();
 			return $row;
 		}catch(PDOException $e){
 			echo "existsChannelName():".$e->getMessage();
 			return false;
 		}			
	}
}
//	$db=new ChannelDB();
//	print_r($db->existsChannelName("烧豆腐烧豆腐烧豆腐烧豆腐"));
?>
