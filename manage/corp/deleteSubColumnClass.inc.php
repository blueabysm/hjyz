<?php
include_once("../../util/commonFunctions.php");

class deleteSubColumnClass{
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	
	
	function deleteSubColumnClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
	}
	
	function Page_Load()
	{		
		$corp_id = 0;
		$objID = 0;
		$s_type = 0;
		$sub_id = 0;
		
		//检查并设置参数		
		if(isset($this->getVars["corp_id"])){
			$corp_id = trim($this->getVars["corp_id"]);
		}
		if(isset($this->getVars["s_type"])){
			$s_type = trim($this->getVars["s_type"]);
		}
		if(isset($this->getVars["objID"])){
			$objID = trim($this->getVars["objID"]);
		}
		if(isset($this->getVars["sub_id"])){
			$sub_id = trim($this->getVars["sub_id"]);
		}		
		
		$this->toURL = "manageSubColumns.php?s_type=$s_type&corp_id=$corp_id&id=$objID";
		if ( 
		     ($corp_id == 0) || (isNumber($corp_id) == 0) || 
		     ($objID == 0) || (isNumber($objID) == 0) ||
		     ($sub_id == 0) || (isNumber($sub_id) == 0) ||
		     (isNumber($s_type) == 0) ||
		     ($s_type < 1) || ($s_type > 2)
		     ){
				$this->errorMessage = "参数错误";
				return;			
		}

		//取记录信息
		$sqlstr = "select sub_order from corp_part_sub where sub_id=$sub_id and c_type=$s_type and item_id=$objID and column_id in (select obj_id from my_object where user_id=".$_SESSION["sess_user_id"]." and (menu_id=34 or menu_id=43))";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的记录!";
			return ;
		}		
		
 		//删除表记录
		$sqlstr = "delete from corp_part_sub where sub_id=$sub_id";
		$this->mysql->deleteRec($sqlstr);		
	}
}
?>