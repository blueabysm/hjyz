<?php
include_once("../../util/commonFunctions.php");

class myCheckArticleListClass{
 	 	
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	
	public $articleList;
	
	
 	
 	function myCheckArticleListClass($mysql)
 	{ 		
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
 	}
 	
 	function Page_Load()
 	{		
 		$sqlstr = "select article_id,article_title,article_time,item_id,(select columns_name from columns c where c.columns_id=a.item_id) columns_name,(select user_realname from admins d where d.user_id=a.user_id) user_realname from article a  where a.article_state=3 and a.s_id=0 and a.item_id in (select obj_id from my_object where menu_id=16 and obj_id>0 and user_id=".$_SESSION["sess_user_id"].') order by article_time desc';		
 		
 		$this->articleList = $this->mysql->findAllRec($sqlstr); 		
		if ($this->articleList == -1){
			$this->articleList = NULL;
			return;
		}		
 	}
 }
?>