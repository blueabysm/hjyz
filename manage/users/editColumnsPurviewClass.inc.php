<?php
include_once("../../util/columnsFunctions.php");
include_once("users_function.php");

class editColumnsPurviewClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	public $retURL; //返回地址
	
	public $menu_name;
	public $columns_name;
	
	public $id;
	public $uid;
	public $page;
	public $t;
	public $rec_id;
	public $purList;
	private $typeID;
	public $selPurList;
	public $oldPurList;
	
	
	
	function editColumnsPurviewClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
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
		$sqlstr = "";		
		$sqlResult;		
				
		//检查并设置参数		
		if(isset($this->getVars["id"])){
			$this->id = trim($this->getVars["id"]);
		}
		if(isset($this->postVars["id"])){
			$this->id = trim($this->postVars["id"]);
		}
		
		if(isset($this->getVars["rec_id"])){
			$this->rec_id = trim($this->getVars["rec_id"]);
		}
		if(isset($this->postVars["rec_id"])){
			$this->rec_id = trim($this->postVars["rec_id"]);
		}
		
		if(isset($this->getVars["uid"])){
			$this->uid = trim($this->getVars["uid"]);
		}
		if(isset($this->postVars["uid"])){
			$this->uid = trim($this->postVars["uid"]);
		}
		
		if(isset($this->getVars["t"])){
			$this->t = trim($this->getVars["t"]);
		}
		if(isset($this->postVars["t"])){
			$this->t = trim($this->postVars["t"]);
		}
		
		if(isset($this->getVars["page"])){
			$this->page = trim($this->getVars["page"]);
		}
		if(isset($this->postVars["page"])){
			$this->page = trim($this->postVars["page"]);
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
	
		$sqlstr = "select menu_name from menus where menu_id=$this->id";
		$sqlResult = $this->mysql->findOneRec($sqlstr);		
		if ($sqlResult == -1){
			$this->errorMessage = "找不到指定的权限!";
			return;
		}		
		$this->menu_name = trim($sqlResult['menu_name']);
		$sqlstr = "select obj_id,pur_list from my_object where rec_id=$this->rec_id and menu_id=$this->id and user_id=$this->uid";
		$sqlResult = $this->mysql->findOneRec($sqlstr);		
		if ($sqlResult == -1){
			$this->errorMessage = "找不到指定的记录!";
			return;
		}		
		$this->oldPurList = trim($sqlResult['pur_list']);
		$sqlstr = "select columns_name from columns where columns_id=".$sqlResult['obj_id'];
		$sqlResult = $this->mysql->findOneRec($sqlstr);		
		if ($sqlResult == -1){
			$this->errorMessage = "找不到对应的栏目!";
			return;
		}
		$this->columns_name = trim($sqlResult['columns_name']);		
		
 		$sqlstr = "select p_id,p_name from purview where menu_id=$this->id order by p_order";
 		$this->purList = $this->mysql->findAllRec($sqlstr);	
 		$this->toURL = "";
		//如果是点击了保存按钮
		if(isset($this->postVars["btnAdd"])){			
			$this->btnAdd_Click();
		}				
	}
	
	function btnAdd_Click()
	{
		
		
		$tmpstr= "";
		
		//填充form
		$this->selPurList = $this->postVars["selPurList"];		
		
		$tmpstr= ",";
		for($i=0;$i<count($this->selPurList);$i++){
			$tmpstr = $tmpstr.$this->selPurList[$i].",";
		}
		$sqlstr = "update my_object set pur_list='$tmpstr' where rec_id=$this->rec_id and menu_id=$this->id and user_id=$this->uid";
		$this->mysql->updateRec($sqlstr);
		$this->toURL = "editObjColumnsPurview.php?t=$this->t&id=$this->id&uid=$this->uid&page=$this->page";
	}
}
?>