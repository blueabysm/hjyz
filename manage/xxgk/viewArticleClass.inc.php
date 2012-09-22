<?php
include_once("../../util/commonFunctions.php");
class viewArticleClass{
	
	public $article_id;
	public $item_id;
	public $article_order;
	public $article_time;
	public $article_state;
	public $comments_type;	
	public $article_title;
	public $article_from;
	public $article_ath;
	public $article_key;
	public $article_content;
	public $img_url;
	public $user_realname;
	public $back_text;
	
	public $article_state_list;
	public $comments_type_list;
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	public $retURL; //返回地址
	public $to_page;
	
	private $my_purviews;
	
	function viewArticleClass($postObj,$getObj,$mysql)
	{		
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->article_id = 0;
		$this->item_id = 0;
		
		$this->comments_type = 1;
		$this->article_title = "";
		$this->article_from = "";
		$this->article_ath = "";
		$this->article_key = "";
		$this->article_content = "";
		$this->img_url = "";
		
		$this->comments_type_list = array(1,'不允许评论',2,'允许评论显示评论内容需审批',3,'允许评论并直接显示评论内容');
		
		$this->article_state_list = array(1,'发布',3,'待审',4,'退回');
		$this->article_state = 3;
		
	}
	
	function Page_Load()
	{	
		
		//检查并设置参数
		if(isset($this->getVars["id"])){
			$this->article_id = trim($this->getVars["id"]);
		}
		if(isset($this->postVars["article_id"])){
			$this->article_id = trim($this->postVars["article_id"]);
		}
		
		if ( ($this->article_id == 0) || (isNumber($this->article_id) == 0) ){
				$this->errorMessage = "文章参数错误";
				return;			
		}
		
		
		
		//加载文章信息
		$sqlstr = "select * from article where article_id=$this->article_id";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的记录!";
			return;
		}
		
       	$this->toURL = "";
	
		
		$this->article_order = trim($sqlResult["article_order"]);
		$this->comments_type = trim($sqlResult["comments_type"]);
		$this->article_title = trim($sqlResult["article_title"]);
		$this->article_from = trim($sqlResult["article_from"]);
		$this->article_ath = trim($sqlResult["article_ath"]);
		$this->article_key = trim($sqlResult["article_key"]);
		$this->img_url = trim($sqlResult["img_url"]);
		$tmpstr = $this->article_key;
		//去掉首尾的逗号
		if (strlen($tmpstr) > 0) {
			$tmpstr = substr($tmpstr,1,strlen($tmpstr)- 2);
			$this->article_key = $tmpstr;			
		}
		
		//取内容
		$sqlstr = "select article_content from article_content where article_id=$this->article_id";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$this->article_content = htmlspecialchars_decode(trim($sqlResult["article_content"]));			
	}	
}
?>