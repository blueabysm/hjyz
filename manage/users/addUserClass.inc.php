<?php
include_once("../../util/commonFunctions.php");
include_once("users_function.php");

class addUserClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	public $user_type_list;	
	public $user_type;
	public $user_realname;
	public $user_company;
	public $user_part;
	public $user_phone;
	public $user_email;
	public $user_pwd;
	public $user_pwd2;
	public $user_name;	
	public $user_state;
	public $user_state_list;
	
	public $treeItemStr;
	

	
	function addUserClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";

		
				
		$this->user_realname = "";
		$this->user_company = 0;
		$this->user_part = 0;
		$this->user_phone = "";
		$this->user_email = "";
		$this->user_pwd = "";
		$this->user_pwd2 = "";
		$this->user_name = "";
		$this->user_type = "";		
		$this->user_type_list = array(1,"网站会员",5,"网站管理员");
		$this->user_state = 2;
		$this->user_state_list = array(1,"正常",2,"冻结");
	}
	
	function Page_Load()
	{				
		$sqlstr = "select c_id,short_name from corp";
		$this->treeItemStr = "[['所有单位','',".getTreeStr($this->mysql,$sqlstr).']]';
		//如果是点击了保存按钮
		if(isset($this->postVars["btnAdd"])){			
			$this->btnAdd_Click();
			return;			
		}			
	}
	
	function btnAdd_Click()
	{
		$sqlstr = "";		
		$sqlResult;
		$nowLen = 0;
		
		
		//填充form
		$this->user_type = trim($this->postVars["user_type"]);
		$this->user_state = trim($this->postVars["user_state"]);
		$this->user_name = trim($this->postVars["user_name"]);
		$this->user_realname = trim($this->postVars["user_realname"]);
		$this->user_company = trim($this->postVars["user_company"]);
		$this->user_part = trim($this->postVars["user_part"]);
		$this->user_phone = trim($this->postVars["user_phone"]);
		$this->user_email = trim($this->postVars["user_email"]);
		$this->user_pwd = trim($this->postVars["user_pwd"]);
		$this->user_pwd2 = trim($this->postVars["user_pwd2"]);
		
		//检查参数
		$nowLen = strlen($this->user_name); 
		if ( ($nowLen == 0) || ( $nowLen < 5) || ($nowLen > 16) || (isUserName($this->user_name) == 0) ) {
			$this->errorMessage = "请填写合法的用户名";
			return;
		}
		$nowLen = strlen($this->user_pwd); 
		if ($nowLen < 5){
			$this->errorMessage = "密码必须在5-16位之间";
			return;
		}
		if ($this->user_pwd != $this->user_pwd2){
			$this->errorMessage = "两次填写的密码不一致";
			return;
		}		
		if (strlen($this->user_realname) <= 0) {
			$this->errorMessage = "请填写姓名";
			return;
		}			
		
		
		//检查用户名
		$sqlstr = "select user_id from admins where user_name='$this->user_name'";
		$sqlResult = $this->mysql->findOneRec($sqlstr);		
		if ((count($sqlResult) > 0) && ($sqlResult >0) ){
			$this->errorMessage = "用户名已存在!";
			return;
		}
		//添加用户信息
		$sqlstr = "insert into admins(user_name,user_pwd,user_type,user_realname,user_state,user_sub_id,user_company,user_part,user_phone,user_email) values(" .
					"'$this->user_name','".md5($this->user_pwd)."',$this->user_type,'$this->user_realname',$this->user_state,".$_SESSION['sess_user_sub_id'].",$this->user_company,$this->user_part,'$this->user_phone','$this->user_email');";			
		
		$this->mysql->insertRec($sqlstr);
						
		$sqlstr = 'insert into my_object(user_id) values('.$this->mysql->getNewInsertID().')';			
		$this->mysql->insertRec($sqlstr);			
		$this->toURL = "manageUser.php";
	}	
}
?>