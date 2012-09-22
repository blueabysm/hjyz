<?php
include_once("../../util/commonFunctions.php");
include_once("../../util/columnsFunctions.php");

class relpyNoticeClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	
	
	public $title;
	public $content;
	public $send_time;
	public $user_realname;	
	public $reply_type;
	public $relpyTypeList;
	public $notice_id;
	public $note;
	public $relpy_id;
	
	

	
	function relpyNoticeClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->title = "";
		$this->content = "";
		$this->reply_type = 0;
		$this->relpyTypeList = array(0,"暂不回复",1,"参会",2,"不参会");
		$this->notice_id = 0;
		$this->note = "";
				
	}
	
	function Page_Load()
	{	
		if(isset($this->getVars["id"])){
			$this->notice_id = trim($this->getVars["id"]);
		}
		if(isset($this->postVars["notice_id"])){
			$this->notice_id = trim($this->postVars["notice_id"]);
		}		
		if ( ($this->notice_id == 0) || (isNumber($this->notice_id) == 0) ){
				$this->errorMessage = "参数错误";
				$this->toURL = "myNewNotice.php";					
				return;			
		}

		
		//加载通知基本信息		
		$sqlstr = "select title,content,send_time,(select user_realname from admins where user_id=create_user_id) user_realname from columns_notice where state=1 and notice_id in (select notice_id from columns_notice_relpy where user_id=".$_SESSION['sess_user_id']." and notice_id=$this->notice_id and reply_type=0)";
 		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult == -1){
			$this->errorMessage = "未找到指定的记录!";
			$this->toURL = "myNewNotice.php";
			return;
		}
		$this->title = trim($sqlResult["title"]);
		$this->content = trim($sqlResult["content"]);		
		$this->user_realname = trim($sqlResult["user_realname"]);		
		$this->send_time = $sqlResult["send_time"];
		
		//加载回复信息
		$sqlstr = "select relpy_id,state,reply_type,note from columns_notice_relpy where user_id=".$_SESSION['sess_user_id']." and notice_id=$this->notice_id and reply_type=0";		
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult == -1){
			$this->errorMessage = "未找到指定的记录!";
			$this->toURL = "myNewNotice.php";
			return;
		}
 		$this->relpy_id = $sqlResult["relpy_id"];				
		$this->note = trim($sqlResult["note"]);		
		$this->reply_type = $sqlResult["reply_type"];
		$state = $sqlResult["state"];
		if ($state == 0){
			$sqlstr = "update columns_notice_relpy set state=1,read_time=now() where relpy_id=$this->relpy_id";
			$this->mysql->updateRec($sqlstr);
		}
 		

		//如果是点击了保存按钮
		if(isset($this->postVars["btnSave"])){			
			$this->btnSave_Click();
		}				
	}
	
	function btnSave_Click()
	{			
		$sqlResult;
		$this->toURL = "";		
		
		//填充form		
		$this->note = trim($this->postVars["note"]);
		$this->reply_type = $this->postVars["reply_type"];
		$this->relpy_id = $this->postVars["relpy_id"];
		
		if ($this->reply_type == 0){
			$this->toURL = "myNewNotice.php";
			return;
		}
		//检查参数
		if ( ($this->reply_type == 2) && (strlen($this->note) <= 0) ){
			$this->errorMessage = "请填说明";
			return;
		}
		
		$sqlstr = "update columns_notice_relpy set note='$this->note',reply_type=$this->reply_type,relpy_time=now() where relpy_id=$this->relpy_id";
		$this->mysql->updateRec($sqlstr);
		$this->toURL = "myNewNotice.php";
	}

	
}
?>