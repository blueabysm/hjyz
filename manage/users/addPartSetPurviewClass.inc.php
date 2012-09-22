<?php
include_once("../../util/columnsFunctions.php");
include_once("users_function.php");

class addPartSetPurviewClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	public $retURL; //返回地址
	
	public $menu_name;
	
	public $id;
	public $uid;
	public $page;
	public $purList;
	public $objList;
	public $selObjList;
	public $selPurList;
	
	
	
	function addPartSetPurviewClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		
		$this->uid = 0;
		$this->page = 0;
		$this->id = 0;
	}
	function Page_Load()
	{
				
		//检查并设置参数		
		if(isset($this->getVars["id"])){
			$this->id = trim($this->getVars["id"]);
		}
		if(isset($this->postVars["id"])){
			$this->id = trim($this->postVars["id"]);
		}
		
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
			
		
		
		$this->toURL = "editObjPartSetPurview.php?id=$this->id&uid=$this->uid&page=$this->page";
		if ( ($this->uid == 0) || (isNumber($this->uid) == 0) ||
			 ($this->id == 0) || (isNumber($this->id) == 0) ){
			$this->errorMessage = "错误的参数";
			return;			
		}		
	
		$sqlstr = "select menu_name from menus where menu_id=$this->id";
		$sqlResult = $this->mysql->findOneRec($sqlstr);		
		if ($sqlResult == -1){
			$this->errorMessage = "找不到指定的权限!";
			return;
		}		
		$this->menu_name = trim($sqlResult['menu_name']);
		//如果是点击了保存按钮
		if(isset($this->postVars["btnAdd"])){			
			$this->btnAdd_Click();
			return;			
		}
		
		$sqlstr = "select p_id,p_name from purview where menu_id=$this->id order by p_order";
 		$this->purList = $this->mysql->findAllRec($sqlstr);
 		
 		$sqlstr = 'select c_id,short_name from corp where c_id not in (select obj_id from my_object where menu_id=20 and user_id='.$this->uid.')';
 		$this->objList = $this->mysql->findAllRec($sqlstr);
 		$this->toURL = "";				
	}
	
	function btnAdd_Click()
	{
		
		
		$tmpstr= "";
		
		//填充form
		$this->selPurList = $this->postVars["selPurList"];
		$this->selObjList = $this->postVars["selObjList"];
		
		$tmpstr= ",";
		for($i=0;$i<count($this->selPurList);$i++){
			$tmpstr = $tmpstr.$this->selPurList[$i].",";
		}
		for($i=0;$i<count($this->selObjList);$i++){
			$sqlstr = "insert into my_object(user_id,menu_id,obj_id,pur_list) values($this->uid,$this->id,".$this->selObjList[$i].",'$tmpstr')";			
			$this->mysql->insertRec($sqlstr);
		}
		$this->toURL = "editObjPartSetPurview.php?id=$this->id&uid=$this->uid&page=$this->page";
	}
}
?>