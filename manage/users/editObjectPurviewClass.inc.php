<?php
class editObjectPurviewClass{
	
	public $getVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	public $uid;
	public $page;
	public $purList;
	
	function editObjectPurviewClass($getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->mysql = $mysql;
		
		$this->uid = 0;
		$this->page = 0;
	}
	
	function Page_Load()
 	{
 		
 		//检查并设置参数		
		if(isset($this->getVars["uid"])){
			$this->uid = trim($this->getVars["uid"]);
		}
 		if(isset($this->getVars["page"])){
			$this->page = trim($this->getVars["page"]);			
		}
		
		$this->toURL = "managePurview.php?page=$this->page";
		if ( ($this->uid == 0) || (isNumber($this->uid) == 0) ){
			$this->errorMessage = "错误的参数";
			return;			
		}
		
		$sqlstr = 'select pur_list from my_object where menu_id=0 and obj_id=0 and user_id='.$this->uid;
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult == -1){
			$this->errorMessage = "找不到该用户拥有的权限记录!";
			return;
		}
		$ids = trim($sqlResult["pur_list"]);
		if (strlen($ids)<2){
			$this->errorMessage = "该用户尚未分配基本权限!";
			return;
		} else {
			$ids = substr($ids,1,strlen($ids) -2);
		}

 		$sqlstr = "select menu_id,menu_name,pur_edit_url from menus where LENGTH(pur_edit_url)>0 and menu_id in ($ids) order by pid,menu_order";
		
 		$this->purList = $this->mysql->findAllRec($sqlstr); 		
		$this->toURL = "";		
 	}
	
}
?>