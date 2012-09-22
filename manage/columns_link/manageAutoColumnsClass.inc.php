<?php
include_once("../../util/commonFunctions.php");

class manageAutoColumnsClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	public $retURL; //返回地址
	
	public $autoColumnsName;	
	public $columnsID;
	public $linkList;
	
	function manageAutoColumnsClass($postObj,$getObj,$mysql)
 	{
 		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		$this->retURL = "../columns/manageColumns.php";
		
		$this->columnsID = 0;
		$this->autoColumnsName = "";
		
	}
	
	function Page_Load()
 	{
 	$sqlstr = "";		
		$sqlResult;
		$tmpstr= "";
		
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
		
		$tmpstr = $this->columnsID;
		$sqlstr = "select columns_name from columns where columns_id=$tmpstr and admin_id=".$_SESSION["sess_user_id"];
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的栏目!";
			$this->toURL = $this->retURL;
			
			return;
		}
		$this->autoColumnsName = trim($sqlResult["columns_name"]);
		
		
 		if(isset($this->postVars["btnReName"])){ 			
			
			$this->btnReName_Click();
			return;
		}
		
 	}
 	
 	function btnReName_Click()
 	{
 		$sqlstr = ""; 
 		
 		$this->autoColumnsName = trim($this->postVars["autoColumnsName"]);
 		
 		if (strlen($this->autoColumnsName) < 1){ 			
 			$this->errorMessage = "栏目名称不能为空!"; 			
 			return;
 		} 		 		
 		
 		$sqlstr = "update columns set columns_name='$this->autoColumnsName' where columns_id=$this->columnsID";		
		$this->mysql->updateRec($sqlstr);
 		
 	}
}
?>