<?php
include_once("../../util/commonFunctions.php");

class editCorpClass{
	
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
	public $c_id;
	public $to_index;
	public $to_index_list;
	
	function editCorpClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";

		
		$this->c_id = 0;		
		$this->corp_name = '';
		$this->short_name = '';
		$this->phone = '';
		$this->addr = '';	
		$this->to_index = 0;
		$this->to_index_list = array(0,"否",1,"是");
	}
	
	function Page_Load()
	{		
		if(isset($this->getVars["id"])){
			$this->c_id = trim($this->getVars["id"]);
		}
		if(isset($this->postVars["c_id"])){
			$this->c_id = trim($this->postVars["c_id"]);
		}		
		if ( ($this->c_id == 0) || (isNumber($this->c_id) == 0) ){
				$this->errorMessage = "参数错误";
				$this->toURL = "manageCorp.php";
				return;			
		}
		//加载信息
		$sqlstr = "select c_type,corp_name,short_name,phone,addr,to_index from corp where c_id=$this->c_id";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult == -1){
			$this->errorMessage = "未找到指定的记录!";
			$this->toURL = "manageCorp.php";
			return;
		}
		$this->c_type = $sqlResult["c_type"];		
		$this->corp_name = trim($sqlResult["corp_name"]);
		$this->short_name = trim($sqlResult["short_name"]);
		$this->phone = trim($sqlResult["phone"]);
		$this->addr = trim($sqlResult["addr"]);
		$this->to_index = $sqlResult["to_index"];
		//取单位类型列表
		$sqlstr = 'select t_id,t_name from corp_type';
		$this->corp_type_list = $this->mysql->findAllRec($sqlstr);
		if ($this->corp_type_list == -1){
			$this->errorMessage = "找不到单位类型数据，无法创建单位";
			return;
		}
		//如果是点击了添加按钮
		if(isset($this->postVars["btnSave"])){			
			$this->btnSave_Click();
		}			
	}
	
	function btnSave_Click()
	{
		
		//填充form
		$this->c_type = $this->postVars["c_type"];
		$this->corp_name = trim($this->postVars["corp_name"]);
		$this->short_name = trim($this->postVars["short_name"]);
		$this->phone = trim($this->postVars["phone"]);
		$this->addr = trim($this->postVars["addr"]);
		$this->to_index = trim($this->postVars["to_index"]);
		//检查参数
		if ( strlen($this->corp_name) < 1){
			$this->errorMessage = "请填写单位名称";
			return;
		}
		if (strlen($this->short_name) < 1){
			$this->errorMessage = "请填写简称";
			return;
		}
		
		//保存信息
		$sqlstr = "update corp set c_type=$this->c_type,corp_name='$this->corp_name',short_name='$this->short_name',phone='$this->phone',addr='$this->addr',to_index='$this->to_index' where c_id=$this->c_id";					
		$this->mysql->updateRec($sqlstr);
		$this->toURL = 'manageCorp.php';
	}	
}
?>