<?php
include_once("../../util/commonFunctions.php");
class checkArticleClass{
	
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
	public $columns_name;	
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	public $retURL; //返回地址
	public $to_page;
	
	private $my_purviews;
	
	function checkArticleClass($postObj,$getObj,$mysql)
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
		$this->retURL = "myCheckArticleList.php";
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
		if(isset($this->getVars["item_id"])){
			$this->item_id = trim($this->getVars["item_id"]);
		}
		if(isset($this->postVars["item_id"])){
			$this->item_id = trim($this->postVars["item_id"]);
		}		
		
		if ( ($this->article_id == 0) || (isNumber($this->article_id) == 0) || ($this->item_id == 0) || (isNumber($this->item_id) == 0)){
				$this->errorMessage = "文章参数错误";
				$this->toURL = $this->retURL;
				return;			
		}

		//检查权限
		$this->my_purviews = checkPurview(16,$this->item_id,$this->mysql,array('proc'));
		if ($this->my_purviews == -1){
			$this->errorMessage = "没有权限!".$this->my_purviews;
			$this->toURL = $this->retURL;
			return;
		}
		
		$sqlstr = "select columns_name from columns where columns_id=$this->item_id and $this->item_id in (select obj_id from my_object where menu_id=16 and user_id=".$_SESSION["sess_user_id"].")";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的栏目!";
			$this->toURL = $this->retURL;
			return;
		}
		$this->columns_name = trim($sqlResult["columns_name"]);
		
		
		//加载文章信息
		$sqlstr = "select a.*,(select user_realname from admins d where d.user_id=a.user_id) user_realname from article a where article_id=$this->article_id;";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的记录!";
			return;
		}
		
       	$this->toURL = "";

		//如果是点击了保存按钮
		if(isset($this->postVars["btnSave"])){			
			$this->btnSave_Click();
			return;
		}
		
		$this->article_order = trim($sqlResult["article_order"]);
		$this->comments_type = trim($sqlResult["comments_type"]);
		$this->article_title = trim($sqlResult["article_title"]);
		$this->article_from = trim($sqlResult["article_from"]);
		$this->article_ath = trim($sqlResult["article_ath"]);
		$this->article_key = trim($sqlResult["article_key"]);
		$this->img_url = trim($sqlResult["img_url"]);
		$this->user_realname = trim($sqlResult["user_realname"]);
		$tmpstr = $this->article_key;
		//去掉首尾的逗号
		if (strlen($tmpstr) > 0) {
			$tmpstr = substr($tmpstr,1,strlen($tmpstr)- 2);
			$this->article_key = $tmpstr;			
		}
		
		//取内容
		$sqlstr = "select article_content from article_content where article_id=$this->article_id;";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$this->article_content = htmlspecialchars_decode(trim($sqlResult["article_content"]));
		
			
	}
	
	function btnSave_Click()
	{
		$sqlstr = "";		
		$sqlResult;
		$tmpstr= "";
		
		//填充from
		$this->back_text = trim($this->postVars["back_text"]);
		$this->article_state = trim($this->postVars["article_state"]);
		$sqlstr = "update article set back_text='$this->back_text',article_state=$this->article_state where article_id=$this->article_id or s_id=$this->article_id;";		
		$this->mysql->updateRec($sqlstr);			
		$this->toURL = $this->retURL;
	}
}
?>