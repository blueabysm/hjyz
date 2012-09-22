<?php
include_once("../../util/columnsFunctions.php");
include_once("../../util/commonFunctions.php");

class deleteLinkColumns2Class{
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	
	function deleteLinkColumns2Class($postObj,$getObj,$mysql)
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
		$id=0; //链接条ID
		$cid=0; //栏目ID		
		
		if(isset($this->getVars["id"])){
			$id = trim($this->getVars["id"]);
		}
		if(isset($this->getVars["cid"])){
			$cid = trim($this->getVars["cid"]);			
		}
		$this->toURL = "manageLinkColumns2.php?id=$cid";
		if (($id==0) || ($cid == 0) || (IsNumber($id)==0) || (IsNumber($cid) == 0)){	
			$this->errorMessage = "错误的参数";
			return;			
		}		
				
		$sqlstr = "delete from columns_link2 where sub_columns_id=$id and $cid in (select obj_id from my_object where menu_id=42 and user_id=".$_SESSION["sess_user_id"].")";
		
		$this->mysql->deleteRec($sqlstr);		
		if ($this->mysql->a_rows >0){
			//删除子链接栏目
			deleteColumns_ljtlm($this->mysql,$id);
			//删除权限
			$sqlstr = 'delete from my_object where user_id='.$_SESSION["sess_user_id"]." and menu_id=35 and obj_id=$id";
			$this->mysql->deleteRec($sqlstr);			
		}
		
	}
}
?>