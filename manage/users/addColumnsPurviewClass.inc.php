<?php
include_once("../../util/columnsFunctions.php");
include_once("users_function.php");

class addColumnsPurviewClass{
	
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
	public $t;
	public $purList;
	public $colList;
	public $treeItemStr;
	private $maxColumnsDepth;
	private $nowDepth;	
	private $typeID;
	public $selPurList;
	
	
	
	function addColumnsPurviewClass($postObj,$getObj,$mysql,$dep)
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
		$this->maxColumnsDepth = $dep;		
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
		//如果是点击了保存按钮
		if(isset($this->postVars["btnAdd"])){			
			$this->btnAdd_Click();
			return;			
		}
		
		$sqlstr = "select p_id,p_name from purview where menu_id=$this->id order by p_order";
 		$this->purList = $this->mysql->findAllRec($sqlstr);
 				
		$this->nowDepth = 0;
		$sqlstr = "select columns_id,columns_name,sub_id from columns where columns_type_id=$this->typeID and sites_id>=0 and create_type<2 and columns_id not in (select obj_id from my_object where user_id=$this->uid and menu_id=$this->id and obj_id>0) order by columns_id;";
		$this->treeItemStr = "[['所有根栏目','',".$this->getTreeStr($sqlstr).']]';
		$this->toURL = "";
				
	}
	
	function btnAdd_Click()
	{
		
		
		$tmpstr= "";
		
		//填充form		
		$this->colList = $this->postVars["colList"];
		$this->selPurList = $this->postVars["selPurList"];
		$colmnus = explode(',',$this->colList);	
		
		
		$tmpstr= ",";
		for($i=0;$i<count($this->selPurList);$i++){
			$tmpstr = $tmpstr.$this->selPurList[$i].",";
		}
		for($i=0;$i<count($colmnus);$i++){
			$sqlstr = "insert into my_object(user_id,menu_id,obj_id,pur_list) values($this->uid,$this->id,".$colmnus[$i].",'$tmpstr')";			
			$this->mysql->insertRec($sqlstr);
		}
		$this->toURL = "editObjColumnsPurview.php?t=$this->t&id=$this->id&uid=$this->uid&page=$this->page";
	}		
	function getTreeStr($sqlstr)
	{
		$this->nowDepth = $this->nowDepth + 1;
		if ($this->nowDepth > $this->maxColumnsDepth) {					
			return "['到达最大栏目深度','']";
		}
		$str = "['无','']"; 
		if ($sqlstr == '') return $str;
		$columnsList = $this->mysql->findAllRec($sqlstr);
		
		if ($columnsList == -1) return $str;
		
		$col_count = count($columnsList);
		$str = "";		
		for($i=0;$i<$col_count;$i++){
			$link = "javascript:addCol(\'".$columnsList[$i]['columns_name']."\',".$columnsList[$i]['columns_id'].')';
			
			if (trim($columnsList[$i]['sub_id']) == '') {
				$str = $str."['".$columnsList[$i]['columns_name']."','$link'],";
			} else {
				$sql = "select columns_id,columns_name,sub_id from columns where columns_type_id=$this->typeID and columns_id in (".$columnsList[$i]['sub_id'].") and columns_id not in (select obj_id from my_object where user_id=$this->uid and menu_id=$this->id and obj_id>0) order by columns_id;";
				$str = $str."['".$columnsList[$i]['columns_name']."','$link',";				
				$str = $str.$this->getTreeStr($sql,$retURL).'],';
			}			
		}
		$this->nowDepth = $this->nowDepth - 1;
		return substr($str,0,strlen($str)-1);
	}	
}
?>