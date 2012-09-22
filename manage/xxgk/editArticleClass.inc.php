<?php
include_once("../../util/commonFunctions.php");
class editArticleClass{
	
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
	public $back_text;
	public $s_id;
	
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
	
	function editArticleClass($postObj,$getObj,$mysql)
	{		
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->article_id = 0;
		$this->item_id = 0;
		$this->article_order = 100;
		
		$this->comments_type = 1;
		$this->article_title = "";
		$this->article_from = "";
		$this->article_ath = "";
		$this->article_key = "";
		$this->article_content = "";
		$this->img_url = "";
		$this->s_id = 0;
		
		$this->comments_type_list = array(1,'不允许评论',2,'允许评论显示评论内容需审批',3,'允许评论并直接显示评论内容');
		$this->retURL = "../columns/manageColumnsTree.php";
		$this->to_page = 1;		
		
	}
	
	function Page_Load()
	{	
		$this->toURL = "manageArticle.php?id=".$this->item_id."&page=".$this->to_page."&retURL=$this->retURL";
		//检查并设置参数
		if(isset($this->getVars["retURL"])){
			$this->retURL = trim($this->getVars["retURL"]);
		}
		if(isset($this->postVars["retURL"])){
			$this->retURL = trim($this->postVars["retURL"]);
		}		
		if(isset($this->getVars["item_id"])){
			$this->item_id = trim($this->getVars["item_id"]);
		}
		if(isset($this->postVars["item_id"])){
			$this->item_id = trim($this->postVars["item_id"]);
		}
		if(isset($this->getVars["page"])){
			$this->to_page = trim($this->getVars["page"]);
		}
		if(isset($this->postVars["to_page"])){
			$this->to_page = trim($this->postVars["to_page"]);
		}
		if ( ($this->item_id == 0) || (isNumber($this->item_id) == 0) ){
				$this->errorMessage = "栏目参数错误";
				$this->toURL = $this->retURL;
				return;			
		}

		//检查权限
		$this->my_purviews = checkPurview(55,$this->item_id,$this->mysql,array('add','edit','editAll'));
		if ($this->my_purviews == -1){
			$this->errorMessage = "没有权限!";
			return;
		}
		
		$sqlstr = "select columns_name from columns where columns_id=$this->item_id and $this->item_id in (select obj_id from my_object where menu_id=55 and user_id=".$_SESSION["sess_user_id"].")";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的栏目!";
			return;
		}
		$this->columns_name = trim($sqlResult["columns_name"]);
		
		
		if(isset($this->getVars["article_id"])){
			$this->article_id = trim($this->getVars["article_id"]);
		}
		if(isset($this->postVars["article_id"])){
			$this->article_id = trim($this->postVars["article_id"]);
		}
		
				
		//如果为0表示是添加文章
		if ($this->article_id == 0) {
       		$find = strpos($this->my_purviews,',add,');
       		if ($find === false){
       			$this->errorMessage = '没有权限添加文章';
       			return;
       		}
       		$this->article_state_list = array(3,'待审',5,'起草');
       		$this->article_state = 5;
       		
       		$this->toURL = "";
			//如果是点击了保存按钮
			if(isset($this->postVars["btnSave"])){			
				$this->btnSave_Click();
				return;
			}
       		return;
		}
		
		if (isNumber($this->article_id) == 0){
			$this->errorMessage = "文章参数错误";
			return;			
		}
		
		//加载文章信息
		$sqlstr = "select * from article where article_id=$this->article_id;";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的记录!";
			return;
		}
		$this->article_state = $sqlResult["article_state"];
		
		//判断有无权限
		$find = strpos($this->my_purviews,',editAll,');
       	if ($find === false){
       		$find = strpos($this->my_purviews,',edit,');
       		if ($find === false){
       			$this->errorMessage = '没有权限修改文章!';
				return;
       		} else {
       			if ( ($this->article_state < 4) || ($sqlResult["user_id"] != $_SESSION['sess_user_id']) ){
       				$this->errorMessage = "文章当前不允许修改!";
       				return;
       			}
       			$this->article_state_list = array(3,'待审',5,'起草',4,'退回');
       		}
       	} else {
       		$this->article_state_list = array(3,'待审',1,'发布',2,'归档',5,'起草',4,'退回');
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
		$this->back_text = trim($sqlResult["back_text"]);
		
		//取内容
		$sqlstr = "select article_content from article_content where article_id=$this->article_id;";
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		$this->article_content = trim($sqlResult["article_content"]);
		
			
	}
	
	function btnSave_Click()
	{
		$sqlstr = "";		
		$sqlResult;
		$tmpstr= "";
		
		//填充from
		$this->item_id = trim($this->postVars["item_id"]);
		$this->article_order = trim($this->postVars["article_order"]);
		$this->article_state = trim($this->postVars["article_state"]);
		$this->comments_type = 1;
		$this->article_title = trim($this->postVars["article_title"]);
		$this->article_from = trim($this->postVars["article_from"]);
		$this->article_ath = trim($this->postVars["article_ath"]);
		$this->article_key = trim($this->postVars["article_key"]);
		echo $this->article_key;
		$this->article_content = trim($this->postVars["article_content"]);
		$this->img_url = trim($this->postVars["img_url"]);
				//获取默认值
		if($this->img_url==""){
			      $pattern = "/src=\"(\S*\.jpg)/i";
				   preg_match_all($pattern,$this->article_content,$matches);
				   //print_r($matches);
				   if($matches[1][0]==""){
					$pattern = "/src=\"(\S*\.gif)/i";
					preg_match_all($pattern,$this->article_content,$matches);
				   }
				   if($matches[1][0]!=""){
					$this->img_url=$matches[1][0];
				   }
				$this->img_url = str_replace(WEB_DOMAIN_NAME,'',$this->img_url);
		}
		//检查参数
		if (strlen($this->article_title) <=0){
			$this->errorMessage = "请填写文章的标题";
			return;
		}
		if (strlen($this->article_content) <=0){
			$this->errorMessage = "请填写文章的内容";
			return;
		}
		if (IsNumber($this->article_order) == 0){
			$this->errorMessage = "序号必须是一个整数!";			
			return;
		}
		
		
		//保存记录
		//处理字段
/* 		$tmpstr = $this->article_key;		 
		if (strlen($tmpstr)>0){
			//中文逗号替换为英语逗号 并在两端加上 逗号
			$tmpstr = str_replace(",","",$tmpstr);			
			$this->article_key = $tmpstr;
		} */
		//内容预处理
		$ip = 'http://'.$_SERVER['SERVER_ADDR'];
		if ($_SERVER['SERVER_PORT'] != 80){
			$ip = $ip.':'.$_SERVER['SERVER_PORT'];
		}
		$ip = $ip.'/';
		$this->article_content = str_replace($ip,'/',$this->article_content);
		$this->article_content = str_replace(WEB_DOMAIN_NAME,'',$this->article_content);
		if(get_magic_quotes_gpc()){
			$this->article_content=stripslashes($this->article_content);
		}
		$this->article_content = htmlspecialchars($this->article_content);					
		if ($this->article_id>0){
			$sqlstr = "update article set article_order=$this->article_order,article_state=$this->article_state,comments_type=$this->comments_type,article_title='$this->article_title',article_from='$this->article_from',article_ath='$this->article_ath',article_key='$this->article_key',img_url='$this->img_url' where article_id=$this->article_id or s_id=$this->article_id;";		
			$this->mysql->updateRec($sqlstr);
			
			$sqlstr = "update article_content set article_content='%%s' where article_id=$this->article_id;";
			$args= array($this->article_content);
			$this->mysql->updateRec($sqlstr,$args);
			$result = $this->mysql->a_rows;
		} else {
			$sqlstr = "insert into article(item_id,article_order,article_time,article_state,comments_type,article_title,article_from,article_ath,article_key,img_url,user_id) values(" .
						"$this->item_id,$this->article_order,now(),$this->article_state,$this->comments_type,'$this->article_title','$this->article_from','$this->article_ath','$this->article_key','$this->img_url',".$_SESSION['sess_user_id'].");";			
			$this->mysql->insertRec($sqlstr);
			
			$tmpstr = $this->mysql->getNewInsertID();		
			$sqlstr = "insert into article_content(article_id,article_content) values(" .
						"$tmpstr,'%%s');";
			$args= array($this->article_content);			
			$this->mysql->insertRec($sqlstr,$args);
			$result = $this->mysql->a_rows;
		}
		
		$this->toURL = "manageArticle.php?id=".$this->item_id."&page=".$this->to_page."&retURL=$this->retURL";
	}
}
?>