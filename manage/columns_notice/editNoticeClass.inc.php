<?php
include_once("../../util/commonFunctions.php");

class editNoticeClass{
	
	public $getVars;
	public $postVars;
	public $mysql;
	public $errorMessage;
	public $toURL;
	public $retURL; //返回地址
	
	public $errorURL;
	
	
	public $title;
	public $content;
	public $allUserList;
	public $selUserList;
	public $userGroupList;
	public $state;
	public $stateList;
	public $notice_id;
	public $oldUserList;
	public $columnsID;
	public $page;
	public $s;
	

	
	function editNoticeClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->title = "";
		$this->content = "";
		$this->state = 0;
		$this->stateList = array(0,"起草",1,"发布");
		$this->notice_id = 0;				
		$this->columnsID = 0;
		
	}
	
	function Page_Load()
	{	
		
		//检查并设置参数
 		if(isset($this->getVars["retURL"])){
			$this->retURL = trim($this->getVars["retURL"]);
		}
		if(isset($this->postVars["retURL"])){
			$this->retURL = trim($this->postVars["retURL"]);
		}		
		if(isset($this->getVars["cid"])){
			$this->columnsID = trim($this->getVars["cid"]);
		}
		if(isset($this->postVars["columnsID"])){
			$this->columnsID = trim($this->postVars["columnsID"]);
		}
 		if(isset($this->getVars["page"])){
			$this->page = trim($this->getVars["page"]);			
		}
		if(isset($this->postVars["page"])){
			$this->page = trim($this->postVars["page"]);
		}
		if(isset($this->getVars["s"])){
			$this->s = trim($this->getVars["s"]);
		}
		if(isset($this->postVars["s"])){
			$this->s = trim($this->postVars["s"]);
		}
		if (s == 1){
			$this->errorURL = 'manageNewNotice.php?id=';
		} else {
			$this->errorURL = 'manageOldNotice.php?id=';
		}
		$this->errorURL = $this->errorURL."$this->columnsID&page=$this->page&retURL=$this->retURL";
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
		if(isset($this->postVars["notice_id"])){
			$this->notice_id = trim($this->postVars["notice_id"]);
		}		
		if ( ($this->notice_id == 0) || (isNumber($this->notice_id) == 0) ){
				$this->errorMessage = "参数错误";
				$this->toURL = $this->errorURL;					
				return;			
		}

		
		//加载用户组列表
		$sqlstr = "select group_id,group_name,group_users from admins_group";
 		$this->userGroupList = $this->mysql->findAllRec($sqlstr);
		//加载用户列表
		$sqlstr = "select user_id,user_realname from admins where user_type<9";
 		$this->allUserList = $this->mysql->findAllRec($sqlstr);
 		
 		

		//如果是点击了保存按钮
		if(isset($this->postVars["btnSave"])){			
			$this->btnSave_Click();
			return;
		}
		//加载基本信息
		$sqlstr = "select state,title,content from columns_notice where columns_id=$this->columnsID and notice_id=$this->notice_id and create_user_id=".$_SESSION["sess_user_id"];
		$sqlResult = $this->mysql->findOneRec($sqlstr);
		if ($sqlResult == -1){
			$this->errorMessage = "未找到指定的记录!";
			$this->toURL = $this->errorURL;				
			return;
		}
		$this->title = trim($sqlResult["title"]);
		$this->content = trim($sqlResult["content"]);
		$this->state = $sqlResult["state"];		
 						
		//加载已选用列表
		$sqlstr = "select user_id from columns_notice_relpy where notice_id=$this->notice_id";
 		$this->oldUserList = $this->mysql->findAllRec($sqlstr); 		
	}
	
	function btnSave_Click()
	{			
		$sqlResult;
		$this->toURL = "";
		$user_num = 0;		
		
		//填充form
		$this->title = trim($this->postVars["title"]);
		$this->content = trim($this->postVars["content"]);
		$this->state = trim($this->postVars["state"]);
		$this->selUserList = $this->postVars["selUserList"];
		
		
		//检查参数		
		if (strlen($this->title) <= 0) {
			$this->errorMessage = "请填写标题";
			return;
		}
		if (strlen($this->content) <= 0) {
			$this->errorMessage = "请填写内容";
			return;
		}		
		$user_num = count($this->selUserList);	
	    
		//内容预处理
		$ip = 'http://'.$_SERVER['SERVER_ADDR'];
		if ($_SERVER['SERVER_PORT'] != 80){
			$ip = $ip.':'.$_SERVER['SERVER_PORT'];
		}
		$ip = $ip.'/';
		$this->content = str_replace($ip,'/',$this->content);
		$this->content = str_replace(WEB_DOMAIN_NAME,'',$this->content);
		$this->content = htmlspecialchars($this->content); 
		
		//保存基本信息
		$sqlstr = "update columns_notice set title='$this->title',content='%%s',user_num=$user_num";
		if ($this->state == 1){
			$sqlstr = $sqlstr.",state=$this->state,send_time=now()";
		}
		$sqlstr = $sqlstr." where notice_id=$this->notice_id";
		$args= array($this->content);
		$this->mysql->updateRec($sqlstr,$args);
		$sqlstr = "delete from columns_notice_relpy where notice_id=$this->notice_id";
		$this->mysql->deleteRec($sqlstr);
		
		if ($user_num > 0){			
			//排除相同用户
			$uList;			
			for($i=0;$i<count($this->selUserList);$i++){
				if ($this->userExists($uList,$this->selUserList[$i])) continue;
				$uList[] = $this->selUserList[$i];
			}	
			for($i=0;$i<count($uList);$i++){
				$sqlstr = 'insert into columns_notice_relpy(notice_id,user_id) values(' .
						"$this->notice_id,".$uList[$i].')';
				$this->mysql->insertRec($sqlstr);
			}
		}
		
		$this->toURL = $this->errorURL;
	}

	function isSelected($uid)
	{		
		if (count($this->oldUserList) < 1) return -1;
		for($i=0;$i<count($this->oldUserList);$i++){
			if ($uid == $this->oldUserList[$i]['user_id']) return 1;
		}
		return -1;
	}
	
	function userExists($uList,$uID)
	{
		if (count(userExists)<=0) return false;
		for($i=0;$i<count($uList);$i++){
			if ($uList[$i] == $uID) return true;
		}
		return false;
	}
}
?>