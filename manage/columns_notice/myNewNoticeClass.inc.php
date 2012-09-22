<?php
class myNewNoticeClass{
	
	public $mysql;
	public $newNoticeList;
	
	function myNewNoticeClass($mysql)
	{
		$this->mysql = $mysql;
	}
	
	function Page_Load()
 	{
 		$sqlstr = "";		
		$sqlResult;
		
		$sqlstr = "select notice_id,title,send_time,(select user_realname from admins where user_id=create_user_id) user_realname from columns_notice where state=1 and notice_id in (select notice_id from columns_notice_relpy where user_id=".$_SESSION['sess_user_id']." and (state=0 or reply_type=0) ) order by notice_id desc";
 		$this->newNoticeList = $this->mysql->findAllRec($sqlstr);
 		
 	}
	
}
?>