<?php
class manageUserGroupClass{
	
	public $mysql;
	public $userGroupList;
	
	function manageUserGroupClass($mysql)
	{
		$this->mysql = $mysql;
	}
	
	function Page_Load()
 	{
 		$sqlstr = "";		
		$sqlResult;
		
		$sqlstr = "select group_id,group_name from admins_group";
 		$this->userGroupList = $this->mysql->findAllRec($sqlstr);
 		
 	}
	
}
?>