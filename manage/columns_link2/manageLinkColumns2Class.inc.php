<?php
include_once("../../util/commonFunctions.php");

class manageLinkColumns2Class{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	public $linkColumnsName;	
	public $columnsID;
	public $linkList;
	
	function manageLinkColumns2Class($postObj,$getObj,$mysql)
 	{
 		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->columnsID = 0;
		$this->linkColumnsName = "";
		
	}
	
	function Page_Load()
 	{
 		$sqlstr = "";		
		$sqlResult;
		$tmpstr= "";
		
		//检查并设置参数		
		if(isset($this->getVars["id"])){
			$this->columnsID = trim($this->getVars["id"]);
		}
		if(isset($this->postVars["columnsID"])){
			$this->columnsID = trim($this->postVars["columnsID"]);
		}
		if ( ($this->columnsID == 0) || (isNumber($this->columnsID) == 0) ){
			$this->errorMessage = "栏目参数错误";
			$this->toURL = "../columns/manageColumnsTree.php";
			return;			
		}
		
		
		
		$sqlstr = "select columns_name from columns where columns_id=$this->columnsID and $this->columnsID in (select obj_id from my_object where menu_id=42 and user_id=".$_SESSION["sess_user_id"].")";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的栏目!";
			$this->toURL = "../columns/manageColumnsTree.php";			
			return;
		}
		$this->linkColumnsName = trim($sqlResult["columns_name"]);		
		
 			
 		$sqlstr = "select columns_id,sub_columns_id,item_order,item_title,item_link,(select columns_name from columns where columns_id=c2.sub_columns_id) sub_link_name from columns_link2 c2 where columns_id=".$this->columnsID." order by item_order";
 		$this->linkList = $this->mysql->findAllRec($sqlstr);
 	}
}
?>