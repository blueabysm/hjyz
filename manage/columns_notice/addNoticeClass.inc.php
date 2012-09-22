<?php
include_once("../../util/commonFunctions.php");
include_once("../../util/columnsFunctions.php");

class addNoticeClass{
	
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
	public $columnsID;
	public $page;

	
	function addNoticeClass($postObj,$getObj,$mysql)
	{
		$this->getVars = $getObj;
		$this->postVars = $postObj;
		$this->mysql = $mysql;
		$this->errorMessage = "";
		$this->toURL = "";
		
		$this->title = "";
		$this->content = "";
		$this->errorURL =""; 
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
		$this->errorURL = "manageNewNotice.php?id=$this->columnsID&page=$this->page&retURL=$this->retURL";
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

		//加载用户组列表
		$sqlstr = "select group_id,group_name,group_users from admins_group";
 		$this->userGroupList = $this->mysql->findAllRec($sqlstr);
		//加载用户列表
		$sqlstr = "select user_id,user_realname from admins where user_type<9";
 		$this->allUserList = $this->mysql->findAllRec($sqlstr);

		//如果是点击了保存按钮
		if(isset($this->postVars["btnSave"])){		
			
			$this->btnSave_Click();
		}				
	}
	
	function btnSave_Click()
	{			
		$sqlResult;		
		
		//填充form
		$this->title = trim($this->postVars["title"]);
		$this->content = trim($this->postVars["content"]);
		$this->selUserList = $this->postVars["selUserList"];
		$user_num = 0;
		
		
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
		//内容预处理
		$ip = 'http://'.$_SERVER['SERVER_ADDR'];
		if ($_SERVER['SERVER_PORT'] != 80){
			$ip = $ip.':'.$_SERVER['SERVER_PORT'];
		}
		$ip = $ip.'/';
		$this->content = str_replace($ip,'/',$this->content);
		$this->content = str_replace(WEB_DOMAIN_NAME,'',$this->content);
		$this->content = htmlspecialchars($this->content); 
		
		//添加基本信息
		$sqlstr = 'insert into columns_notice(create_user_id,columns_id,user_num,create_time,title,content) values(' .
					$_SESSION['sess_user_id'].",$this->columnsID,$user_num,now(),'$this->title','%%s')";
		$args= array($this->content);			
		$this->mysql->insertRec($sqlstr,$args);
		if ($user_num > 0){		
			$notice_id = $this->mysql->getNewInsertID();
			//排除相同用户
			$uList;			
			for($i=0;$i<count($this->selUserList);$i++){
				if ($this->userExists($uList,$this->selUserList[$i])) continue;
				$uList[] = $this->selUserList[$i];
			}	
			for($i=0;$i<count($uList);$i++){
				$sqlstr = 'insert into columns_notice_relpy(notice_id,user_id) values(' .
						"$notice_id,".$uList[$i].')';
				$this->mysql->insertRec($sqlstr);
			}
		}
		
		
		$this->toURL = $this->errorURL;
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