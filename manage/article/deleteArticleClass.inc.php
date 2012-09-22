<?php
include_once("../../util/commonFunctions.php");

class deleteArticleClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	public $retURL; //返回地址
	public $to_page;
	
	private $my_purviews;
	
	function deleteArticleClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		$this->retURL = "../columns/manageColumnsTree.php";
		$this->to_page = 1;
	}
	
	function Page_Load()
	{
		$sqlstr = "";		
		$sqlResult;
		$id=0; //文章ID
		$cid=0; //栏目ID
		
		if(isset($this->getVars["id"])){
			$id = trim($this->getVars["id"]);
		}
		if(isset($this->getVars["cid"])){
			$cid = trim($this->getVars["cid"]);			
		}
		if(isset($this->getVars["retURL"])){
			$this->retURL = trim($this->getVars["retURL"]);
		}
		if(isset($this->postVars["retURL"])){
			$this->retURL = trim($this->postVars["retURL"]);
		}
		if(isset($this->getVars["page"])){
			$this->to_page = trim($this->getVars["page"]);
		}
		$this->toURL = "manageArticle.php?id=$cid&page=$this->to_page&retURL=$this->retURL";
		
		if (($id==0) || ($cid == 0) || (IsNumber($id)==0) || (IsNumber($cid) == 0)){
			$this->errorMessage = "错误的参数";			
			return;			
		}

		//检查权限
		$this->my_purviews = checkPurview(34,$cid,$this->mysql,array('del','delAll'));
		if ($this->my_purviews == -1){
			$this->errorMessage = "没有权限!";
			return;
		}
		
		//删除文章基本信息
		$sqlstr = "delete from article where (article_id=$id and item_id=$cid) or (s_id=$id)";
		$find = strpos($this->my_purviews,',delAll,');
       	if ($find === false){
       		$sqlstr = $sqlstr.' and article_state>3 and user_id='.$_SESSION["sess_user_id"];
       	}
		$this->mysql->deleteRec($sqlstr);
		if ($this->mysql->a_rows <=0){
			$this->errorMessage = "无法删除";
			return;			
		}
		
		//删除文章内容
		$sqlstr = "delete from article_content where article_id=$id";
		$this->mysql->deleteRec($sqlstr);
		//删除文章评论
		$sqlstr = "delete from article_comments where article_id=$id";
		$this->mysql->deleteRec($sqlstr);
		
				
	}
}
?>