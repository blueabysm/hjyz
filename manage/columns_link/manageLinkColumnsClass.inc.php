<?php
include_once("../../util/commonFunctions.php");

class manageLinkColumnsClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	public $retURL; //返回地址
	
	public $linkColumnsName;	
	public $columnsID;
	public $linkList;
	
	function manageLinkColumnsClass($postObj,$getObj,$mysql)
 	{
 		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		$this->retURL = "../columns/manageColumnsTree.php";
		
		$this->columnsID = 0;
		$this->linkColumnsName = "";
		
	}
	
	function Page_Load()
 	{
 	
		
		//检查并设置参数
 		if(isset($this->getVars["retURL"])){
			$this->retURL = trim($this->getVars["retURL"]);
		}
		if(isset($this->postVars["retURL"])){
			$this->retURL = trim($this->postVars["retURL"]);
		}
				
		if(isset($this->getVars["id"])){
			$this->columnsID = trim($this->getVars["id"]);
		}
		if(isset($this->postVars["columnsID"])){
			$this->columnsID = trim($this->postVars["columnsID"]);
		}
		if ( ($this->columnsID == 0) || (isNumber($this->columnsID) == 0) ){
			$this->errorMessage = "栏目参数错误";
			$this->toURL = $this->retURL;
			return;			
		}		
				
		$sqlstr = "select columns_name from columns where columns_id=$this->columnsID and $this->columnsID in (select obj_id from my_object where menu_id=35 and user_id=".$_SESSION["sess_user_id"].")";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的栏目!";
			$this->toURL = $this->retURL;
			
			return;
		}
		$this->linkColumnsName = trim($sqlResult["columns_name"]);
		
		$sqlstr = "select columns_link_id,item_order,item_title,item_link from columns_link where columns_id=".$this->columnsID." order by item_order";
 		$this->linkList = $this->mysql->findAllRec($sqlstr);
 		if ($this->linkList == -1) $this->linkList = NULL;	
 	} 	
}
?>