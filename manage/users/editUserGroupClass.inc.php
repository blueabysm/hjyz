<?php
include_once("../../util/commonFunctions.php");
include_once("../../util/columnsFunctions.php");

class editUserGroupClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	
	public $group_name;
	public $group_id;
	public $allUserList;
	public $selUserList;
	public $groupUsers;
	

	
	function editUserGroupClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->group_name = "";
		$this->group_id = 0;			
		
	}
	
	function Page_Load()
	{				
		$sqlstr = "";
		
		if(isset($this->getVars["id"])){
			$this->group_id = trim($this->getVars["id"]);
		}
		if(isset($this->postVars["group_id"])){
			$this->group_id = trim($this->postVars["group_id"]);
		}		
		if (isNumber($this->group_id) == 0){
				$this->errorMessage = "参数错误";
				$this->toURL = "manageUserGroup.php";
				return;			
		}
		
		//加载用户列表
		$sqlstr = "select user_id,user_realname from admins where user_type<9";
 		$this->allUserList = $this->mysql->findAllRec($sqlstr);

		//如果是点击了保存按钮
		if(isset($this->postVars["btnSave"])){			
			
			$this->btnSave_Click();	
			return;
		}
	    
		if ($this->group_id == 0) return;
		
		
		//加载用户组信息
		$sqlstr = "select group_name,group_users from admins_group where group_id=$this->group_id";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult == -1){
			$this->errorMessage = "未找到指定的记录!";
			$this->toURL = "manageUserGroup.php";
			return;
		}
		$this->group_name = trim($sqlResult["group_name"]);		
		$this->groupUsers = trim($sqlResult["group_users"]);
	}
	
	function btnSave_Click()
	{			
		$sqlResult;		
		
		//填充form
		$this->group_id = trim($this->postVars["group_id"]);
		$this->group_name = trim($this->postVars["group_name"]);
		$this->selUserList = $this->postVars["selUserList"];
		
		
		//检查参数		
		if (strlen($this->group_name) <= 0) {
			$this->errorMessage = "请填写用户组名称";
			return;
		}
		$user_num = count($this->selUserList);
		if ($user_num <= 0) {
			$this->errorMessage = "请选择成员";
			return;
		}
		$this->groupUsers = "";
		for($i=0;$i<$user_num;$i++){
			$this->groupUsers = $this->groupUsers.$this->selUserList[$i].",";
		}
		$this->groupUsers = substr($this->groupUsers,0,strlen($this->groupUsers) -1);		
		$sqlstr = "select group_name from admins_group where group_name='$this->group_name'";
		if ($this->group_id != 0) {
			$sqlstr = $sqlstr + " and group_id<>$this->group_id";
		}
		
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult == -1){
			if ($this->group_id != 0) {
				$sqlstr = "update admins_group set group_name='$this->group_name',group_users='$this->groupUsers' where group_id=$this->group_id";
				$this->mysql->updateRec($sqlstr);
			} else {
				$sqlstr = "insert into admins_group(group_name,group_users) values('$this->group_name','$this->groupUsers')";
				$this->mysql->insertRec($sqlstr);
			}
			
		} else {
			$this->errorMessage = "用户组名已存在";
			return;
		}		
		
		
		$this->toURL = "manageUserGroup.php";
	}	
}
?>