<?php
include_once("../../util/commonFunctions.php");

class deleteLinkColumnsClass{
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	public $retURL; //返回地址
	
	
	function deleteLinkColumnsClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";

		$this->retURL = "../columns/manageColumnsTree.php";
	}
	
	function Page_Load()
	{
		$sqlstr = "";		
		$sqlResult;
		$id=0; //链接条ID
		$cid=0; //栏目ID
		
		if(isset($this->getVars["id"])){
			$id = trim($this->getVars["id"]);
		}
		if(isset($this->getVars["cid"])){
			$cid = trim($this->getVars["cid"]);			
		}
		if(isset($this->getVars["retURL"])){
			$this->retURL = trim($this->getVars["retURL"]);
		}
		if(isset($this->postVars["retURL"])){
			$this->retURL = trim($this->postVars["retURL"]);
		}
		$this->toURL = "manageLinkColumns.php?id=$cid&retURL=$this->retURL";
		
		if (($id==0) || ($cid == 0) || (IsNumber($id)==0) || (IsNumber($cid) == 0)){
			$this->errorMessage = "错误的参数";
			return;			
		}
		
		$sqlstr = "delete from columns_link where columns_link_id=$id and $cid in (select obj_id from my_object where menu_id=35 and user_id=".$_SESSION["sess_user_id"].")";
		$this->mysql->deleteRec($sqlstr);		
		if ($this->mysql->a_rows <=0){
			$this->errorMessage = "删除失败!";			
		}
				
		
	}
}
?>