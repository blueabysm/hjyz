<?php
include_once("../../util/columnsFunctions.php");
include_once("../../util/commonFunctions.php");

class deleteUserClass{
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	
	function deleteUserClass($postObj,$getObj,$mysql)
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
		
		$this->toURL = "manageUser.php";
		if (($id==0) || (IsNumber($id)==0)){	
			$this->errorMessage = "错误的参数";
			return;			
		}		
		
		
		//取管理员ID
		$sqlstr = "select user_name from admins where (user_sub_id=".$_SESSION['sess_user_sub_id'].") and (user_id=$id)";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult == -1){
			$this->errorMessage = "未找到指定的用户!";
			return;
		}
		if ($sqlResult["user_name"] == 'admin'){
			$this->errorMessage = "不能删除默认用户!";
			return;
		}
		//删除用户表记录
		$sqlstr = "delete from admins where user_id=$id";
		$this->mysql->deleteRec($sqlstr);
		$sqlstr = "delete from my_object where user_id=$id";
		$this->mysql->deleteRec($sqlstr);		
		if ($this->mysql->a_rows <=0){
			$this->errorMessage = "删除未成功!";			
		}
		
	}		
}
?>