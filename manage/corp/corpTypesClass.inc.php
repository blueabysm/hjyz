<?php
class corpTypesClass{
	
	public $mysql;
	public $typeList;
	
	function corpTypesClass($mysql)
	{
		$this->mysql = $mysql;
	}
	
	function Page_Load()
 	{
		
		$sqlstr = "select t_id,t_name from corp_type";
 		$this->typeList = $this->mysql->findAllRec($sqlstr);
 		
 		if ($this->typeList == -1) {
 			$this->typeList = NULL;
 		}
 	}
	
}
?>