<?php
include_once("../../util/commonFunctions.php");
include_once("../../util/columnsFunctions.php");

class editSubColumnClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	public $corp_id;
	public $objID;
	public $s_type;
	public $sub_order;
	public $columns_name;
	public $sub_id;
	

	
	function editSubColumnClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		
		$this->corp_id = 0;		
		$this->objID = 0;
		$this->sub_id = 0;
		$this->sub_order = 100;
		
	}
	
	function Page_Load()
	{
		$sqlstr = "";		
				
		//检查并设置参数		
		if(isset($this->getVars["corp_id"])){
			$this->corp_id = trim($this->getVars["corp_id"]);
		}
		if(isset($this->postVars["corp_id"])){
			$this->corp_id = trim($this->postVars["corp_id"]);
		}
		if(isset($this->getVars["s_type"])){
			$this->s_type = trim($this->getVars["s_type"]);
		}
		if(isset($this->postVars["s_type"])){
			$this->s_type = trim($this->postVars["s_type"]);
		}
		if(isset($this->getVars["objID"])){
			$this->objID = trim($this->getVars["objID"]);
		}
		if(isset($this->postVars["objID"])){
			$this->objID = trim($this->postVars["objID"]);
		}
		if(isset($this->getVars["sub_id"])){
			$this->sub_id = trim($this->getVars["sub_id"]);
		}
		if(isset($this->postVars["sub_id"])){
			$this->sub_id = trim($this->postVars["sub_id"]);
		}
		
		
		if ( 
		     ($this->corp_id == 0) || (isNumber($this->corp_id) == 0) || 
		     ($this->objID == 0) || (isNumber($this->objID) == 0) ||
		     ($this->sub_id == 0) || (isNumber($this->sub_id) == 0) ||
		     (isNumber($this->s_type) == 0) ||
		     ($this->s_type < 1) || ($this->s_type > 2)
		     ){
				$this->errorMessage = "参数错误";
				$this->toURL = "manageSubColumns.php?s_type=$this->s_type&corp_id=$this->corp_id&id=$this->objID";				
				return;			
		}

		//取记录信息
		$sqlstr = "select sub_order,(select columns_name from columns c where a.column_id=c.columns_id) columns_name from corp_part_sub a where sub_id=$this->sub_id and c_type=$this->s_type and item_id=$this->objID and column_id in (select obj_id from my_object where user_id=".$_SESSION["sess_user_id"]." and (menu_id=34 or menu_id=43))";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的记录!";
			$this->toURL = "manageSubColumns.php?s_type=$this->s_type&corp_id=$this->corp_id&id=$this->objID";
			return ;
		}
		$this->sub_order = $sqlResult["sub_order"];
		$this->columns_name = trim($sqlResult["columns_name"]);
		
				
		//如果是点击了保存按钮
		if(isset($this->postVars["btnAdd"])){			
			$this->btnAdd_Click();			
		}		
	}
	
	function btnAdd_Click()
	{
				
		
		//填充form
		$this->sub_order = trim($this->postVars["sub_order"]);
		
		//检查参数		
		if (IsNumber($this->sub_order) ==0){
			$this->errorMessage = "序号必须是一个数字";
			return;
		}
		$sqlstr = "update corp_part_sub set sub_order=$this->sub_order where sub_id=$this->sub_id;";
		$this->mysql->updateRec($sqlstr);
		$this->toURL = "manageSubColumns.php?s_type=$this->s_type&corp_id=$this->corp_id&id=$this->objID";		
	}
}
?>