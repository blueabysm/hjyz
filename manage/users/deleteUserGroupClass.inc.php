<?php
include_once("../../util/columnsFunctions.php");
include_once("../../util/commonFunctions.php");

class deleteUserGroupClass{
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	
	function deleteUserGroupClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
	}
	
	function Page_Load()
	{
		$sqlstr = "";		
		$sqlResult;
		$id=0; 
		
		if(isset($this->getVars["id"])){
			$id = trim($this->getVars["id"]);
		}
		
		$this->toURL = "manageUserGroup.php";
		if (($id==0) || (IsNumber($id)==0)){	
			$this->errorMessage = "错误的参数";
			return;			
		}		
		
		
		//删除用户组表记录
		$sqlstr = "delete from admins_group where group_id=$id";
		$this->mysql->deleteRec($sqlstr);		
		if ($this->mysql->a_rows >0){
			$this->errorMessage = "删除成功!";			
		}
		
	}		
}
?>