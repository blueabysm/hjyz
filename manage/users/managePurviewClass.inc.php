<?php
class managePurviewClass{
	
	public $mysql;
	public $userList;
	
	function managePurviewClass($mysql)
	{
		$this->mysql = $mysql;
	}
	
	function Page_Load()
 	{
 		$sqlstr = "";		
		$sqlResult;

		
		$sqlstr = "select user_id,user_name,user_type,user_realname,(select short_name from corp where c_id=user_company) user_company_name from admins where  user_type<=5";
 		$this->userList = $this->mysql->findAllRec($sqlstr);
 		
 	}
	
}
?>