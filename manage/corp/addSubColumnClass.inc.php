<?php
include_once("../../util/commonFunctions.php");
include_once("../../util/columnsFunctions.php");

class addSubColumnClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	public $corp_id;
	public $objID;
	public $s_type;
	public $sub_order;
	public $column_id;
	public $colList;
	

	
	function addSubColumnClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		
		$this->corp_id = 0;		
		$this->objID = 0;
		$this->column_id = 0;
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
		
		
		if ( 
		     ($this->corp_id == 0) || (isNumber($this->corp_id) == 0) || 
		     ($this->objID == 0) || (isNumber($this->objID) == 0) ||
		     (isNumber($this->s_type) == 0) ||
		     ($this->s_type < 1) || ($this->s_type > 2)
		     ){
				$this->errorMessage = "参数错误";
				$this->toURL = "manageSubColumns.php?s_type=$this->s_type&corp_id=$this->corp_id&id=$this->objID";				
				return;			
		}

		//取栏目列表
		$sqlstr = "select columns_id,columns_name from columns where columns_type_id in (select columns_type_id from columns_type where type_handle='wzlm' or type_handle='tzlm') and create_type<2 and columns_id in (select obj_id from my_object where user_id=".$_SESSION["sess_user_id"]." and (menu_id=34 or menu_id=43) and obj_id>0) and columns_id not in (select column_id from corp_part_sub where c_type=$this->s_type and item_id=$this->objID) order by columns_id;";
		$this->colList = $this->mysql->findAllRec($sqlstr);
		if ($this->colList == -1){
			$this->colList = NULL;
		}
				
		//如果是点击了保存按钮
		if(isset($this->postVars["btnAdd"])){			
			$this->btnAdd_Click();			
		}		
	}
	
	function btnAdd_Click()
	{
				
		
		//填充form
		$this->column_id = $this->postVars["column_id"];
		$this->sub_order = trim($this->postVars["sub_order"]);
		
		//检查参数		
		if (IsNumber($this->sub_order) ==0){
			$this->errorMessage = "序号必须是一个数字";
			return;
		}
		for($i=0;$i<count($this->column_id);$i++){
			$sqlstr = 'insert into corp_part_sub(item_id,column_id,sub_order,c_type) values('."
			$this->objID,".$this->column_id[$i].",$this->sub_order,$this->s_type)";
			$this->mysql->insertRec($sqlstr);
		}
		$this->toURL = "manageSubColumns.php?s_type=$this->s_type&corp_id=$this->corp_id&id=$this->objID";		
	}
}
?>