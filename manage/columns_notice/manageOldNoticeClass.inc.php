<?php
class manageOldNoticeClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	public $retURL; //返回地址
	
	public $oldNoticeList;
	public $columnsID;
	public $columnsName;
	
	public $to_page;
	public $page_num;
	public $first_page;
	public $last_page;
	public $next_page;
	public $up_page;
	
	function manageOldNoticeClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->columnsID = 0;
		$this->columnsName = "";
		$this->retURL = "../blank.php";
		
		$this->to_page = 1;
		$this->page_num = 1;
		$this->first_page = 1;
		$this->last_page = 1;
		$this->up_page = 1;
		$this->next_page = 1;
	}
	
	function Page_Load()
 	{ 				
 		//检查并设置参数
 		if(isset($this->getVars["retURL"])){
			$this->retURL = trim($this->getVars["retURL"]);
		}			
		if(isset($this->getVars["id"])){
			$this->columnsID = trim($this->getVars["id"]);
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
		
		$sqlstr = "select columns_name from columns where columns_id=$this->columnsID"; 
		//:TODO 检测用户对该栏目的管理权限
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult  == -1){
			$this->errorMessage = "未找到指定的栏目!";
			$this->toURL = $this->retURL;
			
			return;
		}
		$this->columnsName = trim($sqlResult["columns_name"]);
		
		//取通知列表
		$this->getNoticeList();
 		
 	} 	
	function getNoticeList()
 	{ 		
		
		$sqlstr = 'select notice_id,title,send_time,user_num,(select user_realname from admins where user_id=create_user_id) user_realname,'		
		.'(select count(*) from columns_notice_relpy b where b.notice_id=a.notice_id and b.state=1) read_num,'
		.'(select count(*) from columns_notice_relpy b where b.notice_id=a.notice_id and b.reply_type=1) come_num,'
		.'(select count(*) from columns_notice_relpy b where b.notice_id=a.notice_id and b.reply_type=2) lost_num'
		." from columns_notice a where a.columns_id=$this->columnsID and a.state=1 order by a.notice_id desc";
 		$this->oldNoticeList = $this->mysql->findAllRecByPage($sqlstr,$this->to_page,15);
 		
 		if ($this->oldNoticeList == -1){
			$this->oldNoticeList = NULL;
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