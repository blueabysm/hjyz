<?php
include_once("../util/commonFunctions.php");

class adminLeftClass
{	
	public $mysql;
	public $mainMenuList;
	public $subMenuList;
	
	function adminLeftClass($mysql)
	{
		$this->mysql = $mysql;
	}
	
	function Page_Load()
	{
		
		$ids = $_SESSION['sess_user_purview'];
		$ids = substr($ids,1,strlen($ids)-2);
		$sqlstr = "select menu_id,pid,menu_name,menu_url,menu_note from menus where menu_show=1 and menu_id in ($ids) order by pid,menu_order";
		$this->subMenuList = $this->mysql->findAllRec($sqlstr);
 		$sqlstr = "select menu_id,menu_name from menus where menu_show=1 and menu_id in (select pid from menus b where b.menu_id in ($ids)) order by menu_order";
 		$this->mainMenuList = $this->mysql->findAllRec($sqlstr);
	}
}
?>