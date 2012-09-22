<?php
include_once("../util/commonFunctions.php");

class loginClass
{
	public $postVars;
	public $mysql;
	public $errorMessage;
	
	
	function loginClass($postObj,$mysql)
	{
		$this->postVars = $postObj;
		$this->mysql = $mysql;
	}
	
	function Page_Load()
	{
		if(isset($this->postVars["btnLogin"])){			
			return $this->btnLogin_Click();
		}
	}
	
	function btnLogin_Click()
	{	
		$this->errorMessage = "用户名或密码不正确,请重新输入!";
		$strLength= 0;
		$sqlstr = "";
		$tmpstr = "";
		$sqlResult;
		$address = $this->postVars["address"];
		
		if (isset($this->postVars["userName"]) == false) return;
		if (isset($this->postVars["userPwd"]) == false) return;
		
		if($address == 'index'){	
		}else{
			if (isset($this->postVars["userYzm"]) == false) return;
		}
		
			
		$userName = trim($this->postVars["userName"]);
		$userPwd = trim($this->postVars["userPwd"]);
		$userYzm = trim($this->postVars["userYzm"]);
		
		if($address == 'index'){	
		}else{
			if($userYzm != $_SESSION["sessRandomNumber"]){
				$this->errorMessage = "验证码错误！";
				return;
			}	
		}	
		
		if (isUserName($userName) == 0) return;
		$strLength = strlen($userName); 
		if ( ($strLength>16) || ($strLength<5) ) return;
		$strLength = strlen($userPwd); 
		if ( ($strLength>16) || ($strLength<5) ) return;	
		
		
		$sqlstr = "select * from admins where user_name='$userName';";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult == -1){
			return;
		}
		
		$tmpstr = md5($userPwd);
	
		if ($tmpstr != $sqlResult["user_pwd"]) {
			return;
		}
		
		if ($sqlResult["user_state"] != 1){
			$this->errorMessage = "你的用户账号已被冻结,不能登录!";
			return;
		}		
		
		//登录成功
		unset($_SESSION['sess_user_id']);
		unset($_SESSION['sess_user_name']);
		unset($_SESSION['sess_user_type']);		
		unset($_SESSION['sess_user_realname']);
		unset($_SESSION['sess_user_company']);
		unset($_SESSION['sess_user_sub_id']);
		unset($_SESSION['sess_user_purview']);
//		session_unregister("sess_user_id");
//		session_unregister("sess_user_name");
//		session_unregister("sess_user_type");
//		session_unregister("sess_user_realname");
//		session_unregister("sess_user_company");		
		
		$_SESSION['sess_user_id'] = $sqlResult["user_id"];
		$_SESSION['sess_user_name'] = trim($sqlResult["user_name"]);
		$_SESSION['sess_user_type'] = $sqlResult["user_type"];
		$_SESSION['sess_user_realname'] = trim($sqlResult["user_realname"]);
		$_SESSION['sess_user_company'] = trim($sqlResult["user_company"]);
		$_SESSION['sess_user_sub_id'] = trim($sqlResult["user_sub_id"]);
		
		$sqlstr = "select pur_list from my_object where menu_id=0 and obj_id=0 and user_id=".$sqlResult["user_id"];
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult == -1){
			$this->errorMessage = "你没有任何权限，所以无法登录系统!";
			return;
		}
		$_SESSION['sess_user_purview'] = trim($sqlResult["pur_list"]);
		
				
		header("location:index.php");		
	}
}
?>