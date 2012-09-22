<?php
include_once("../../util/commonFunctions.php");

class manageHeadClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	public $corpName;	
	public $corpID;
	public $headList;
	
	function manageHeadClass($postObj,$getObj,$mysql)
 	{
 		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->corpID = 0;
		$this->corpName = "";
		
	}
	
	function Page_Load()
 	{
 		$sqlstr = "";		
		$sqlResult;		
		
		//检查并设置参数		
		if(isset($this->getVars["id"])){
			$this->corpID = trim($this->getVars["id"]);
		}
		if(isset($this->postVars["corpID"])){
			$this->corpID = trim($this->postVars["corpID"]);
		}
		if ( ($this->corpID == 0) || (isNumber($this->corpID) == 0) ){
			$this->errorMessage = "单位参数错误";
			$this->toURL = "partSet.php";
			return;			
		}		
		
		$sqlstr = "select short_name from corp where c_id=$this->corpID and $this->corpID in (select obj_id from my_object where menu_id=20 and user_id=".$_SESSION["sess_user_id"].')';		 
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的单位!";
			$this->toURL = "partSet.php";
			return;
		}
		$this->corpName = trim($sqlResult["short_name"]);
		
		
 		$sqlstr = "select head_id,head_name,head_post from corp_head where corp_id=$this->corpID order by head_order";
 		$this->headList = $this->mysql->findAllRec($sqlstr);
 		if ($this->headList == -1) {
 			$this->headList = NULL;
 		} 		
 	}
}
?>