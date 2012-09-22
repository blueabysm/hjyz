<?php
class manageSubSiteClass{
	
	public $mysql;
	public $subSiteList;
	
	function manageSubSiteClass($mysql)
	{
		$this->mysql = $mysql;
	}
	
	function Page_Load()
 	{
 		$sqlstr = "";		
		$sqlResult;

		
		$sqlstr = "select sub_sites_id,(select concat(user_realname,'(',user_name,')') from admins where user_id=admin_id) admin_name,site_state,site_name,site_href from sub_sites where site_type=2 order by sub_sites_id";
 		$this->subSiteList = $this->mysql->findAllRec($sqlstr);
 		
 	}
	
}
?>