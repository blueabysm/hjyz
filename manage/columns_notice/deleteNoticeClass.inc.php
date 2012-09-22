<?php
include_once("../../util/columnsFunctions.php");
include_once("../../util/commonFunctions.php");

class deleteNoticeClass{
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	public $retURL; //返回地址
	
	public $columnsID;
	public $page;
	
	function deleteNoticeClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";		

		$this->columnsID = 0;		
	}
	
	function Page_Load()
	{
		$sqlstr = "";		
		$sqlResult;
		$id=0; 
		
		//检查并设置参数
 		if(isset($this->getVars["retURL"])){
			$this->retURL = trim($this->getVars["retURL"]);
		}				
		if(isset($this->getVars["cid"])){
			$this->columnsID = trim($this->getVars["cid"]);
		}
 		if(isset($this->getVars["page"])){
			$this->page = trim($this->getVars["page"]);			
		}		
		if ( ($this->columnsID == 0) || (isNumber($this->columnsID) == 0) ){
			$this->errorMessage = "栏目参数错误";
			$this->toURL = $this->retURL;
			return;			
		}		
		if(isset($this->getVars["id"])){
			$id = trim($this->getVars["id"]);
		}		
		if (($id==0) || (IsNumber($id)==0)){	
			$this->errorMessage = "错误的参数";
			return;			
		}		
		
		
		//删除表记录
		$sqlstr = "delete from columns_notice where notice_id=$id and columns_id=$this->columnsID and create_user_id=".$_SESSION["sess_user_id"];
		$this->mysql->deleteRec($sqlstr);		
		if ($this->mysql->a_rows >0){
			$sqlstr = "delete from columns_notice_relpy where notice_id=$id";
			$this->mysql->deleteRec($sqlstr);
			$this->errorMessage = "删除成功!";			
		}
		$this->toURL = 'javascript:history.back()';
	}		
}
?>