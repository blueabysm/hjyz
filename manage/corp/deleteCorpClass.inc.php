<?php
include_once("../../util/commonFunctions.php");

class deleteCorpClass{
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	
	function deleteCorpClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
	}
	
	function Page_Load()
	{
		$sqlstr = "";		
		$sqlResult;
		$id=0; 
		
		if(isset($this->getVars["id"])){
			$id = trim($this->getVars["id"]);
		}
		$this->toURL = "manageCorp.php";
		if (($id==0) || (IsNumber($id)==0)){
			return;			
		}		
		
		
		//删除子栏目表记录
		$sqlstr = "delete from corp_part_sub where c_type=1 and item_id in (select part_id from corp_part where corp_id=$id)";
		$this->mysql->deleteRec($sqlstr);
		$sqlstr = "delete from corp_part_sub where c_type=2 and item_id in (select head_id from corp_head where corp_id=$id)";
		$this->mysql->deleteRec($sqlstr);
		//删除部门
		$sqlstr = "delete from corp_part where corp_id=$id";
		$this->mysql->deleteRec($sqlstr);
		//删除领导信息
		$sqlstr = "delete from corp_head where corp_id=$id";
		$this->mysql->deleteRec($sqlstr);
		//删除单位信息
		$sqlstr = "delete from corp where c_id=$id";
		$this->mysql->deleteRec($sqlstr);
		//删除权限
		$sqlstr = "delete from my_object where menu_id=20 and obj_id=$id";
		$this->mysql->deleteRec($sqlstr);
		
	}		
}
?>