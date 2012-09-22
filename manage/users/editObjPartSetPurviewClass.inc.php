<?php
class editObjPartSetPurviewClass{
	
	public $getVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	public $id;
	public $uid;
	public $page;
	public $purList;
	public $objList;
	
	function editObjPartSetPurviewClass($getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->mysql = $mysql;
		
		$this->uid = 0;
		$this->page = 0;
		$this->t = 0;
		$this->id = 0;
	}
	
	function Page_Load()
 	{
 		
 		//检查并设置参数
 		if(isset($this->getVars["id"])){
			$this->id = trim($this->getVars["id"]);
		}		
		if(isset($this->getVars["uid"])){
			$this->uid = trim($this->getVars["uid"]);
		}
 		if(isset($this->getVars["page"])){
			$this->page = trim($this->getVars["page"]);			
		}
		
		$this->toURL = "editObjPartSetPurview.php?page=$this->page&uid=$this->uid";
		if ( ($this->uid == 0) || (isNumber($this->uid) == 0) ||
			 ($this->id == 0) || (isNumber($this->id) == 0)  ){
			$this->errorMessage = "错误的参数";
			return;			
		}

 		$sqlstr = "select rec_id,(select short_name from corp where c_id=obj_id) obj_name,pur_list from  my_object where menu_id=$this->id and user_id=$this->uid and obj_id>0";
		$this->objList = $this->mysql->findAllRec($sqlstr);		 		
		$sqlstr = "select p_id,p_name from  purview where menu_id=$this->id order by p_order";
		$this->purList = $this->mysql->findAllRec($sqlstr);
		$this->toURL = "";		
 	}
	
}
?>