<?php
class myOldNoticeClass{	

	
	public $mysql;
	public $myRelpyList;
	
	function myOldNoticeClass($mysql)
	{
		$this->mysql = $mysql;
	}
	
	function Page_Load()
 	{
 		
		$sqlstr = "select a.title,a.send_time,(select c.user_realname from admins c where c.user_id=a.create_user_id) user_realname,b.reply_type,b.relpy_time,b.note from columns_notice a,columns_notice_relpy b where a.notice_id=b.notice_id and a.state=1 and b.user_id=".$_SESSION['sess_user_id']." and b.reply_type>0 order by a.notice_id desc";
 		$this->myRelpyList = $this->mysql->findAllRec($sqlstr); 		
 	}
	
}
?>