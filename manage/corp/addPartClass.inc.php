<?php
include_once("../../util/commonFunctions.php");

class addPartClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	public $corp_name;
	public $corp_id;
	
	public $part_order;
	public $part_name;
	public $part_master;
	public $part_phone;
	public $part_monitor_phone;
	public $part_note;
	public $master_photo;
	public $part_addr;
	public $part_mail;
	
	public $file_url;
	
	function addPartClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->corp_name = "";
		$this->part_id = 0;
		$this->corp_id = 0;
		
		$this->part_order = 100;
		$this->part_name = '';
		$this->part_master = '';
		$this->part_phone = '';
		$this->part_monitor_phone = '';
		$this->part_note = '';
		$this->master_photo = 0;
		$this->part_addr = '';
		$this->part_mail = '';
		
		$this->file_url = '';
		
	}
	
	function Page_Load()
	{
						
		//检查并设置参数		
		if(isset($this->getVars["corp_id"])){
			$this->corp_id = trim($this->getVars["corp_id"]);
		}
		if(isset($this->postVars["corp_id"])){
			$this->corp_id = trim($this->postVars["corp_id"]);
		}
		if ( ($this->corp_id == 0) || (isNumber($this->corp_id) == 0) ){
				$this->errorMessage = "单位参数错误";
				$this->toURL = "partSet.php";
				return;			
		}
		
		
		$sqlstr = "select short_name from corp where c_id=$this->corp_id and $this->corp_id in (select obj_id from my_object where menu_id=20 and user_id=".$_SESSION["sess_user_id"].')';		 
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的单位!";
			$this->toURL = "partSet.php";
			return;
		}
		$this->corp_name = trim($sqlResult["short_name"]);		
		
						
		//如果是点击了保存按钮
		if(isset($this->postVars["btnSave"])){
			$this->btnSave_Click();
		}		
	}
	
	function btnSave_Click()
	{	
		
		//填充form
		$this->part_order = $this->postVars["part_order"];
		$this->part_name = trim($this->postVars["part_name"]);
		$this->part_master = trim($this->postVars["part_master"]);
		$this->part_phone = trim($this->postVars["part_phone"]);
		$this->part_monitor_phone = trim($this->postVars["part_monitor_phone"]);
		$this->part_note = trim($this->postVars["part_note"]);
		$this->master_photo = $this->postVars["master_photo"];
		$this->part_addr = trim($this->postVars["part_addr"]);
		$this->part_mail = trim($this->postVars["part_mail"]);
		$this->file_url = trim($this->postVars["file_url"]);
		
		//检查参数
		if (strlen($this->part_name) <=0){
			$this->errorMessage = "请填写机构名称";
			return;
		}
		if (IsNumber($this->part_order) ==0){
			$this->errorMessage = "序号必须是一个数字";
			return;
		}		
		if (strlen($this->part_master) <=0){
			$this->errorMessage = "请填写负责人";
			return;
		}
		if (strlen($this->part_phone) <=0){
			$this->errorMessage = "请填写联系电话";
			return;
		}
		if (strlen($this->part_monitor_phone) <=0){
			$this->errorMessage = "请填监督电话";
			return;
		}
		if (strlen($this->part_note) <=0){
			$this->errorMessage = "请填机构职能";
			return;
		}				
		
		
		//修改基本信息
		$sqlstr = 'insert into corp_part(
					corp_id,
					article_column_id,
					part_order,
					part_name,
					part_master,
					part_phone,
					part_monitor_phone,
					part_note,
					master_photo,
					part_addr,
					part_mail) values('.
					"$this->corp_id,
					0,
					$this->part_order,
					'$this->part_name',
					'$this->part_master',
					'$this->part_phone',
					'$this->part_monitor_phone',
					'$this->part_note',
					$this->master_photo,
					'$this->part_addr',
					'$this->part_mail')";
		$this->mysql->insertRec($sqlstr);
			
		$this->toURL = "managePart.php?id=".$this->corp_id;
	}
}
?>