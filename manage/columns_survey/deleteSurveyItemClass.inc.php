<?php
include_once("../../util/commonFunctions.php");

class deleteSurveyItemClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	function deleteSurveyItemClass($postObj,$getObj,$mysql)
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
		$id=0; //备选答案ID
		$cid=0; //栏目ID
		
		if(isset($this->getVars["id"])){
			$id = trim($this->getVars["id"]);
		}
		if(isset($this->getVars["cid"])){
			$cid = trim($this->getVars["cid"]);			
		}
		if (($id==0) || ($cid == 0) || (IsNumber($id)==0) || (IsNumber($cid) == 0)){
			$this->toURL = "manageSurvey.php?id=$cid";
			$this->errorMessage = "错误的参数";
			return;			
		}
		
		$sqlstr = "delete from survey_item where survey_item_id=$id and $cid in (select obj_id from my_object where menu_id=37 and user_id=".$_SESSION["sess_user_id"].")";
		$this->mysql->deleteRec($sqlstr);		
		if ($this->mysql->a_rows >0){
			//删除自定义答案
			$sqlstr = "delete from survey_custom where survey_item_id=$id";
			$this->mysql->deleteRec($sqlstr);		
		}
				
		$this->toURL = "manageSurvey.php?id=$cid";
	}
}
?>