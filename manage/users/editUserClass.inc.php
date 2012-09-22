<?php
include_once("../../util/commonFunctions.php");
include_once("users_function.php");

class editUserClass{
	
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
	public $user_id;
	
	public $user_company_name;
	public $user_part_name;
	
	public $treeItemStr;
	

	
	function editUserClass($postObj,$getObj,$mysql)
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
		$this->user_id = 0;

		$this->user_company_name = '';
		$this->user_part_name = '';
		
	}
	
	function Page_Load()
	{				
		$sqlstr = "";
		
		if(isset($this->getVars["id"])){
			$this->user_id = trim($this->getVars["id"]);
		}
		if(isset($this->postVars["user_id"])){
			$this->user_id = trim($this->postVars["user_id"]);
		}		
		if ( ($this->user_id == 0) || (isNumber($this->user_id) == 0) ){
				$this->errorMessage = "参数错误";
				$this->toURL = "manageUser.php";
				return;			
		}		
		
		$sqlstr = "select c_id,short_name from corp";
		$this->treeItemStr = "[['所有单位','',".getTreeStr($this->mysql,$sqlstr).']]';
		
		//加载用户信息
		$sqlstr = "select user_name,user_type,user_realname,user_state,user_company,(select short_name from corp where c_id=user_company) user_company_name,user_part,(select part_name from corp_part where part_id=user_part) user_part_name, user_phone,user_email from admins where user_id=$this->user_id";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult == -1){
			$this->errorMessage = "未找到指定的记录!";
			$this->toURL = "manageUser.php";
			return;
		}
		$this->user_name = trim($sqlResult["user_name"]);
		//如果是点击了保存按钮
		if(isset($this->postVars["btnSave"])){			
			
			$this->btnSave_Click();	
			return;
		}			
		
		$this->user_realname = trim($sqlResult["user_realname"]);
		$this->user_company = $sqlResult["user_company"];
		$this->user_part = $sqlResult["user_part"];
		$this->user_company_name = trim($sqlResult["user_company_name"]);
		$this->user_part_name = trim($sqlResult["user_part_name"]);
		$this->user_phone = trim($sqlResult["user_phone"]);
		$this->user_email = trim($sqlResult["user_email"]);		
		$this->user_type = $sqlResult["user_type"];
		$this->user_state = $sqlResult["user_state"];
		
	}
	
	function btnSave_Click()
	{
		$sqlstr = "";		
		$sqlResult;
		$nowLen = 0;
		
		
		//填充form
		$this->user_type = trim($this->postVars["user_type"]);
		$this->user_state = trim($this->postVars["user_state"]);
		$this->user_id = trim($this->postVars["user_id"]);
		$this->user_realname = trim($this->postVars["user_realname"]);
		$this->user_company = trim($this->postVars["user_company"]);
		$this->user_part = trim($this->postVars["user_part"]);
		$this->user_phone = trim($this->postVars["user_phone"]);
		$this->user_email = trim($this->postVars["user_email"]);
		$this->user_pwd = trim($this->postVars["user_pwd"]);
		$this->user_pwd2 = trim($this->postVars["user_pwd2"]);
		
		//检查参数		
		$nowLen = strlen($this->user_pwd);
		if ($nowLen != 0){ 
			if ($nowLen < 5){
				$this->errorMessage = "密码必须在5-16位之间";
				return;
			}
			if ($this->user_pwd != $this->user_pwd2){
				$this->errorMessage = "两次填写的密码不一致";
				return;
			}
		}		
		if (strlen($this->user_realname) <= 0) {
			$this->errorMessage = "请填写姓名";
			return;
		}
		
		
		//保存用户信息
	    $sqlstr = "update admins set user_type=$this->user_type,user_state=$this->user_state,user_realname='$this->user_realname',user_company=$this->user_company,user_part=$this->user_part,user_phone='$this->user_phone',user_email='$this->user_email'";			
		
		if (strlen($this->user_pwd)>0){
			$sqlstr = $sqlstr.",user_pwd='" .md5($this->user_pwd). "'";
		}
		$sqlstr = $sqlstr." where user_id=".$this->user_id;
		$this->mysql->updateRec($sqlstr);
		$this->toURL = "manageUser.php";
	}	
}
?>