<?php
include_once("../../util/commonFunctions.php");

class addCorpClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	public $corp_type_list;	
	public $c_type;
	public $corp_name;
	public $short_name;
	public $phone;
	public $addr;
	

	
	function addCorpClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";

		
				
		$this->corp_name = '';
		$this->short_name = '';
		$this->phone = '';
		$this->addr = '';	
	}
	
	function Page_Load()
	{				
		//取单位类型列表
		$sqlstr = 'select t_id,t_name from corp_type';
		$this->corp_type_list = $this->mysql->findAllRec($sqlstr);
		if ($this->corp_type_list == -1){
			$this->errorMessage = "找不到单位类型数据，无法创建单位";
			return;
		}
		//如果是点击了添加按钮
		if(isset($this->postVars["btnAdd"])){			
			$this->btnAdd_Click();
		}			
	}
	
	function btnAdd_Click()
	{
		
		//填充form
		$this->c_type = $this->postVars["c_type"];
		$this->corp_name = trim($this->postVars["corp_name"]);
		$this->short_name = trim($this->postVars["short_name"]);
		$this->phone = trim($this->postVars["phone"]);
		$this->addr = trim($this->postVars["addr"]);
		
		//检查参数
		if ( strlen($this->corp_name) < 1){
			$this->errorMessage = "请填写单位名称";
			return;
		}
		if (strlen($this->short_name) < 1){
			$this->errorMessage = "请填写简称";
			return;
		}
		
		//添加信息
		$sqlstr = "insert into corp(c_type,corp_name,short_name,phone,addr) values(" .
					"$this->c_type,'$this->corp_name','$this->short_name','$this->phone','$this->addr')";			
		$this->mysql->insertRec($sqlstr);
		$this->toURL = 'manageCorp.php';
	}	
}
?>