<?php
include_once("../../util/commonFunctions.php");

class manageArticleClass{
 	
 	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	public $retURL; //返回地址
	
	public $articleColumnsName;
	public $articleList;
	public $columnsID;
	
	public $to_page;
	public $page_num;
	public $first_page;
	public $last_page;
	public $next_page;
	public $up_page;
 	
 	function manageArticleClass($postObj,$getObj,$mysql)
 	{
 		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->columnsID = 0;
		$this->articleColumnsName = "";
		$this->retURL = "../columns/manageColumnsTree.php";
		
		$this->to_page = 1;
		$this->page_num = 1;
		$this->first_page = 1;
		$this->last_page = 1;
		$this->up_page = 1;
		$this->next_page = 1;
 	}
 	
 	function Page_Load()
 	{
 		$sqlstr = "";		
		$sqlResult;
		
		//检查并设置参数
 		if(isset($this->getVars["retURL"])){
			$this->retURL = trim($this->getVars["retURL"]);
		}
		if(isset($this->postVars["retURL"])){
			$this->retURL = trim($this->postVars["retURL"]);
		}		
		if(isset($this->getVars["id"])){
			$this->columnsID = trim($this->getVars["id"]);
		}
		if(isset($this->postVars["columnsID"])){
			$this->columnsID = trim($this->postVars["columnsID"]);
		}
 		if(isset($this->getVars["page"])){
			$this->to_page = trim($this->getVars["page"]);
			if (isNumber($this->to_page) == 0){
				$this->to_page = 1;
			}
		}
		if ( ($this->columnsID == 0) || (isNumber($this->columnsID) == 0) ){
			$this->errorMessage = "栏目参数错误";
			$this->toURL = $this->retURL;
			return;			
		}	
		
		
		$sqlstr = "select columns_name from columns where columns_id=$this->columnsID and $this->columnsID in (select obj_id from my_object where menu_id=55 and user_id=".$_SESSION["sess_user_id"].")";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的栏目!";
			$this->toURL = $this->retURL;
			
			return;
		}
		$this->articleColumnsName = trim($sqlResult["columns_name"]);
		
		//取文章列表
		$this->getArticleList();
 	}
 	
 	function getArticleList()
 	{
 		$sqlstr = "";
 			
 		$sqlstr = "select a.article_id,a.article_title,a.article_time,a.article_state,a.article_order,a.s_id,(select b.item_id from article b where b.article_id=a.s_id) s_item_id from article a where item_id=$this->columnsID order by article_order desc,article_time desc"; 		
 		$this->articleList = $this->mysql->findAllRecByPage($sqlstr,$this->to_page,10); 		
		if ($this->articleList == -1){
			$this->articleList = NULL;
			return;
		}
 		$this->page_num = $this->mysql->page_amount;
		$this->last_page = $this->page_num;
		$p = $this->to_page - 1;
		if ($p  < 1){
			$this->up_page = 1;
		} else {
			$this->up_page = $p;
		}
		$p = $this->to_page + 1;
		if ($p > $this->page_num){
			$this->next_page = $this->page_num;
		} else {
			$this->next_page = $p;
		}
		
 	}
 }
?>