<?php
class myInfoClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	public $user_realname;
	public $user_phone;
	public $user_email;
	public $user_pwd;
	public $user_pwd2;
	public $user_name;
	
	
	function myInfoClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->user_realname = "";
		$this->user_phone = "";
		$this->user_email = "";
		$this->user_pwd = "";
		$this->user_pwd2 = "";
		
		$this->user_name = $_SESSION["sess_user_name"];
	}
	
	function Page_Load()
	{
		$sqlstr = "";		
		$sqlResult;
		
		//如果是点击了保存按钮
		if(isset($this->postVars["btnSave"])){			
			$this->btnSave_Click();
			return;
		}

					
		$sqlstr = "select * from admins where user_id=".$_SESSION["sess_user_id"];
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult == -1){
			$this->errorMessage = "用户信息丢失!";
			$this->toURL = "../logout.php";
			return;
		}
		
		$this->user_realname = trim($sqlResult["user_realname"]);
		$this->user_phone = trim($sqlResult["user_phone"]);
		$this->user_email = trim($sqlResult["user_email"]);		
		
			
	}
	
	function btnSave_Click()
	{
		$sqlstr = "";
		
		$this->user_realname = trim($this->postVars["user_realname"]);
		$this->user_phone = trim($this->postVars["user_phone"]);
		$this->user_email = trim($this->postVars["user_email"]);
		$this->user_pwd = trim($this->postVars["user_pwd"]);
		$this->user_pwd2 = trim($this->postVars["user_pwd2"]);
		
		//参数检查
		if (strlen($this->user_realname) <= 0) {
			$this->errorMessage = "请填写姓名";
			return;
		}
		if (strlen($this->user_pwd) > 0) {
			if (strlen($this->user_pwd) < 5){
				$this->errorMessage = "密码必须在5-16位之间";
				return;
			}
			if ($this->user_pwd != $this->user_pwd2){
				$this->errorMessage = "两次输入的密码不一致";
				return;
			}
		}
		
			
		$sqlstr = "update admins set user_realname='$this->user_realname',user_phone='$this->user_phone',user_email='$this->user_email'";
		if (strlen($this->user_pwd) > 0) {
			$sqlstr = $sqlstr . ",user_pwd='".md5($this->user_pwd)."'";
		}
		$sqlstr = $sqlstr . " where user_id=".$_SESSION["sess_user_id"];
		$this->mysql->updateRec($sqlstr);
		if ($this->mysql->a_rows > 0){
			$this->errorMessage = "保存已成功";
		}
		
	}
}
?>