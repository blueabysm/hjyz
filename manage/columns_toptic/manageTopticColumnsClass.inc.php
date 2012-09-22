<?php
include_once("../../util/commonFunctions.php");

class manageTopticColumnsClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	public $topticColumnsName;	
	public $columnsID;
	public $topticList;
	
	function manageTopticColumnsClass($postObj,$getObj,$mysql)
 	{
 		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->columnsID = 0;
		$this->topticColumnsName = "";
		
	}
	
	function Page_Load()
 	{
 		$sqlstr = "";		
		$sqlResult;		
		
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
		
		$sqlstr = "select columns_name from columns where columns_id=$this->columnsID and $this->columnsID in (select obj_id from my_object where menu_id=41 and user_id=".$_SESSION["sess_user_id"].")";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult == -1){
			$this->errorMessage = "未找到指定的栏目!";
			$this->toURL = "../columns/manageColumnsTree.php";
			return;
		}
		$this->topticColumnsName = trim($sqlResult["columns_name"]);
		
 			
 		$sqlstr = "select columns_toptic_id,toptic_order,to_index,slide_id,article_column_id,html_column_id,imagetable_id,toptic_name,toptic_href from columns_toptic where columns_id=".$this->columnsID." order by toptic_order";
 		$this->topticList = $this->mysql->findAllRec($sqlstr);
 	}
}
?>