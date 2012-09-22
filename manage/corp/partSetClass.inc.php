<?php
class partSetClass{
	
	public $mysql;
	public $corpList;
	
	function partSetClass($mysql)
	{
		$this->mysql = $mysql;
	}
	
	function Page_Load()
 	{ 		
		$sqlstr = 'select c_id,short_name,phone from corp where c_id in (select obj_id from my_object where menu_id=20 and user_id='.$_SESSION["sess_user_id"].')';		 
 		$this->corpList = $this->mysql->findAllRec($sqlstr);
 		if ($this->corpList == -1) {
 			$this->corpList = NULL;
 		}
 	}
}
?>