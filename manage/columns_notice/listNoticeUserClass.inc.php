<?php
class listNoticeUserClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	public $retURL; //返回地址
	
	public $errorURL;
	
	
	public $userRelpyList;
	public $notice_id;
	public $columnsID;
	public $page;
	
	function listNoticeUserClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->notice_id = 0;
	}
	
	function Page_Load()
 	{
 		//检查并设置参数
 		if(isset($this->getVars["retURL"])){
			$this->retURL = trim($this->getVars["retURL"]);
		}				
		if(isset($this->getVars["cid"])){
			$this->columnsID = trim($this->getVars["cid"]);
		}		
 		if(isset($this->getVars["page"])){
			$this->page = trim($this->getVars["page"]);			
		}
		
		$this->errorURL = "manageOldNotice.php?id=$this->columnsID&page=$this->page&retURL=$this->retURL";
		if ( ($this->columnsID == 0) || (isNumber($this->columnsID) == 0) ){
			$this->errorMessage = "栏目参数错误";
			$this->toURL = $this->errorURL;
			return;			
		}		
		
		$sqlstr = "select columns_name from columns where columns_id=$this->columnsID"; 
		//:TODO 检测用户对该栏目的管理权限
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的栏目!";
			$this->toURL = $this->errorURL;			
			return;
		}
		$this->columnsName = trim($sqlResult["columns_name"]);	
 		
 		if(isset($this->getVars["id"])){
			$this->notice_id = trim($this->getVars["id"]);
		}		
		if ( ($this->notice_id == 0) || (isNumber($this->notice_id) == 0) ){
			$this->errorMessage = "参数错误";
			$this->toURL = $this->errorURL;			
			return;			
		}
		
		$sqlstr = "select state,reply_type,read_time,relpy_time,note,(select user_realname from admins b where b.user_id=a.user_id) user_realname from columns_notice_relpy a where a.notice_id=$this->notice_id  order by relpy_id desc";
 		$this->userRelpyList = $this->mysql->findAllRec($sqlstr);
 		
 	}
	
}
?>