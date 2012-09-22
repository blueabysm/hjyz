<?php
class manageCorpClass{
	
	public $mysql;
	public $corpList;
	
	function manageCorpClass($mysql)
	{
		$this->mysql = $mysql;
	}
	
	function Page_Load()
 	{ 		
		$sqlstr = "select c_id,corp_name,short_name,phone,addr,to_index from corp";
 		$this->corpList = $this->mysql->findAllRec($sqlstr);
 		if ($this->corpList == -1) {
 			$this->corpList = NULL;
 		}
 	}
}
?>