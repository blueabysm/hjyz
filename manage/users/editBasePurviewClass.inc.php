<?php
include_once("../../util/commonFunctions.php");
include_once("../../util/columnsFunctions.php");

class editBasePurviewClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	public $retURL; //返回地址
	
	public $errorURL;
	
	
	public $allPurviewList;
	public $selPurviewList;
	public $uid;
	public $page;
	public $rec_id;

	
	function editBasePurviewClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		$this->errorURL ="";
		 
		$this->page = 0;
		$this->uid = 0;
	}
	
	function Page_Load()
	{
		//检查并设置参数		
		if(isset($this->getVars["uid"])){
			$this->uid = trim($this->getVars["uid"]);
		}
		if(isset($this->postVars["uid"])){
			$this->uid = trim($this->postVars["uid"]);
		}
 		if(isset($this->getVars["page"])){
			$this->page = trim($this->getVars["page"]);			
		}
		if(isset($this->postVars["page"])){
			$this->page = trim($this->postVars["page"]);
		}
		$this->errorURL = "managePurview.php?page=$this->page";
		if ( ($this->uid == 0) || (isNumber($this->uid) == 0) ){
			$this->errorMessage = "错误的参数1";
			$this->toURL = $this->errorURL;
			return;			
		}		
		
		$sqlstr = "select rec_id,pur_list from my_object where menu_id=0 and obj_id=0 and user_id=$this->uid";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "找不到指定的用户!";
			$this->toURL = $this->errorURL;			
			return;
		}
		$this->selPurviewList = trim($sqlResult["pur_list"]);	
		$this->rec_id = $sqlResult["rec_id"];

		//加载权限列表
		$sqlstr = "select menu_id,pid,menu_name from menus order by pid,menu_order";
 		$this->allPurviewList = $this->mysql->findAllRec($sqlstr);
		

		//如果是点击了保存按钮
		if(isset($this->postVars["btnSave"])){		
			
			$this->btnSave_Click();
		}				
	}
	
	function btnSave_Click()
	{			
		$sqlResult;		
		
		//填充form		
		$this->selPurviewList = $this->postVars["selPurviewList"];
	
		if (count($this->selPurviewList) <= 0) {
			$this->errorMessage = "至少要选择一项";
			return;
		}
		
		$tmpstr = "";
		for($i=0;$i<count($this->selPurviewList);$i++){
			$tmpstr = $tmpstr.$this->selPurviewList[$i].",";
		}
		$tmpstr = ','.$tmpstr;
		$sqlstr = "update my_object set pur_list='$tmpstr' where rec_id=$this->rec_id";
		$this->mysql->updateRec($sqlstr);		
		$this->toURL = $this->errorURL;
	}	
}
?>