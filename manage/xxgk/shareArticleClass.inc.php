<?php
include_once("../../util/columnsFunctions.php");
include_once("../users/users_function.php");

class shareArticleClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	public $retURL; //返回地址
	
	public $menu_name;
	
	public $id;
	public $item_id;
	public $page;
	public $colList;
	public $treeItemStr;
	private $maxColumnsDepth;
	private $nowDepth;
	
	
	
	function shareArticleClass($postObj,$getObj,$mysql,$dep)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		
		$this->item_id = 0;
		$this->page = 0;
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
		
		if(isset($this->getVars["item_id"])){
			$this->item_id = trim($this->getVars["item_id"]);
		}
		if(isset($this->postVars["item_id"])){
			$this->item_id = trim($this->postVars["item_id"]);
		}
		
		if(isset($this->getVars["page"])){
			$this->page = trim($this->getVars["page"]);
		}
		if(isset($this->postVars["page"])){
			$this->page = trim($this->postVars["page"]);
		}
		
		if(isset($this->getVars["retURL"])){
			$this->retURL = trim($this->getVars["retURL"]);
		}
		if(isset($this->postVars["retURL"])){
			$this->retURL = trim($this->postVars["retURL"]);
		}
			
		
		
		$this->toURL = "manageArticle.php?id=$this->item_id&retURL=$this->retURL&page=$this->page";
		if ( ($this->item_id == 0) || (isNumber($this->item_id) == 0) ||
			 ($this->id == 0) || (isNumber($this->id) == 0)    ){
			$this->errorMessage = "错误的参数";
			return;			
		}
		$this->typeID = getTypeIdByT(1,$this->mysql);
		if ($this->typeID == -1){
			$this->errorMessage = "错误的栏目类型";
			return;
		}
		
		//如果是点击了保存按钮
		if(isset($this->postVars["btnAdd"])){			
			$this->btnAdd_Click();
			return;			
		}
 				
		$this->nowDepth = 0;
		
		$sqlstr = "select columns_id,columns_name,sub_id from columns";		
		$sqlWhere = " where level=0 and columns_type_id=$this->typeID and create_type < 2 and columns_id in (select obj_id from my_object where menu_id>0 and obj_id>0 and user_id=".$_SESSION["sess_user_id"].')';
		$sqlstr = $sqlstr . $sqlWhere ." order by columns_id";
		$this->treeItemStr = "[['所有根栏目','',".$this->getTreeStr($sqlstr).']]';
		$this->toURL = "";
				
	}
	
	function btnAdd_Click()
	{
		
		
		$tmpstr= "";
		
		//填充form		
		$this->colList = $this->postVars["colList"];
		$colmnus = explode(',',$this->colList);			
		
		for($i=0;$i<count($colmnus);$i++){
			$sqlstr = "insert into article(
					item_id,
					article_order,
					article_time,
					article_state,
					comments_type,
					click_count,
					article_title,
					article_from,
					article_ath,
					article_key,
					img_url,
					s_id,
					user_id,
					back_text ) 
					select 
					'".$colmnus[$i]."',
					article_order,
					now(),
					article_state,
					comments_type,
					click_count,
					article_title,
					article_from,
					article_ath,
					article_key,
					img_url,
					".$this->id.",
					user_id,
					back_text
			 from article a where a.article_id=".$this->id;			
			$this->mysql->insertRec($sqlstr);
		}
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
				$sql = "select columns_id,columns_name,sub_id from columns where columns_type_id=$this->typeID and columns_id in (".$columnsList[$i]['sub_id'].") and columns_id in (select obj_id from my_object where menu_id>0 and obj_id>0 and user_id=".$_SESSION["sess_user_id"].")";
				$str = $str."['".$columnsList[$i]['columns_name']."','$link',";				
				$str = $str.$this->getTreeStr($sql,$retURL).'],';
			}			
		}
		$this->nowDepth = $this->nowDepth - 1;
		return substr($str,0,strlen($str)-1);
	}	
}
?>