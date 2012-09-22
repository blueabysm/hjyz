<?php
include_once("../../util/columnsFunctions.php");
include_once("../../util/commonFunctions.php");
include_once("users_function.php");

class delColumnsPurviewClass{
	public $getVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	public $id;
	public $uid;
	public $page;
	public $t;
	public $rec_id;
	private $typeID;
	
	
	function delColumnsPurviewClass($getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->uid = 0;
		$this->page = 0;
		$this->t = 0;
		$this->id = 0;	
		$this->rec_id = 0;
	}
	
	function Page_Load()
	{
		//检查并设置参数		
		if(isset($this->getVars["id"])){
			$this->id = trim($this->getVars["id"]);
		}
		
		if(isset($this->getVars["rec_id"])){
			$this->rec_id = trim($this->getVars["rec_id"]);
		}
		
		if(isset($this->getVars["uid"])){
			$this->uid = trim($this->getVars["uid"]);
		}
		
		if(isset($this->getVars["t"])){
			$this->t = trim($this->getVars["t"]);
		}
		
		if(isset($this->getVars["page"])){
			$this->page = trim($this->getVars["page"]);
		}
		
		
		$this->toURL = "editObjColumnsPurview.php?t=$this->t&id=$this->id&uid=$this->uid&page=$this->page";
		if ( ($this->uid == 0) || (isNumber($this->uid) == 0) ||
			 ($this->id == 0) || (isNumber($this->id) == 0) ||
			 ($this->rec_id == 0) || (isNumber($this->rec_id) == 0) ||
			 ($this->t == 0) || (isNumber($this->t) == 0)    ){
			$this->errorMessage = "错误的参数";
			return;			
		}
		$this->typeID = getTypeIdByT($this->t,$this->mysql);
		if ($this->typeID == -1){
			$this->errorMessage = "错误的栏目类型";
			return;
		}
		
		//删除表记录
		$sqlstr = "delete from my_object where rec_id=$this->rec_id and menu_id=$this->id and user_id=$this->uid";		
		$this->mysql->deleteRec($sqlstr);
	}		
}
?>